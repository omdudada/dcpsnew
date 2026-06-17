<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Form1Model
 * CRUD for FORM-1 (DCPS / NPS application for Pension Account No. - PRAN)
 * master table  : form1_application  (dpt_form1_application)
 * child table   : form1_nominee      (dpt_form1_nominee)
 *
 * Follows the existing project convention: table names without the dpt_
 * prefix (CI adds it via dbprefix), hand-built insert/update arrays,
 * audit columns created_by/created_date/updated_by/updated_date and a
 * soft-delete flag is_deleted.
 */
class Form1Model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	/* ---------------------------------------------------------------
	 * LISTING / SEARCH
	 * ------------------------------------------------------------- */
	public function getAll($search = array()){
		$this->db->select('f.*, d.designation_name');
		$this->db->from('form1_application as f');
		$this->db->join('designation as d', 'd.id = f.designation_id', 'left');
		$this->db->where('f.is_deleted', 0);

		if(!empty($search['keyword'])){
			$kw = trim($search['keyword']);
			$this->db->group_start();
			$this->db->like('f.first_name', $kw);
			$this->db->or_like('f.middle_name', $kw);
			$this->db->or_like('f.last_name', $kw);
			$this->db->or_like('f.pran_no', $kw);
			$this->db->or_like('f.emp_id', $kw);
			$this->db->group_end();
		}
		if(!empty($search['pay_center'])){
			$this->db->where('f.pay_center', $search['pay_center']);
		}

		$order_col = !empty($search['order_col']) ? $search['order_col'] : 'f.id';
		$order_dir = (!empty($search['order_dir']) && strtolower($search['order_dir']) === 'asc') ? 'asc' : 'desc';
		$this->db->order_by($order_col, $order_dir);

		$query = $this->db->get();
		return $query ? $query->result_array() : array();
	}

	/* ---------------------------------------------------------------
	 * GET BY ID (master + nominees)
	 * ------------------------------------------------------------- */
	public function getById($id){
		$this->db->select('f.*, d.designation_name');
		$this->db->from('form1_application as f');
		$this->db->join('designation as d', 'd.id = f.designation_id', 'left');
		$this->db->where('f.id', (int)$id);
		$this->db->where('f.is_deleted', 0);
		$row = $this->db->get()->row_array();
		if(!$row){
			return false;
		}
		$row['nominees'] = $this->getNominees($id);
		return $row;
	}

	public function getNominees($form1_id){
		$this->db->select('*');
		$this->db->from('form1_nominee');
		$this->db->where('form1_id', (int)$form1_id);
		$this->db->where('is_deleted', 0);
		$this->db->order_by('id', 'asc');
		return $this->db->get()->result_array();
	}

	/* ---------------------------------------------------------------
	 * INSERT (master + nominees in a transaction)
	 * $postdata  : flat post array
	 * $nominees  : array of nominee rows (name/address/dob/relationship/share)
	 * returns new id on success, 0 on failure
	 * ------------------------------------------------------------- */
	public function insert($postdata, $nominees = array()){
		$uid = $this->session->userdata('id');
		$now = time();

		$this->db->trans_start();

		$insert = $this->mapMaster($postdata);
		$insert['created_by']   = $uid;
		$insert['created_date'] = $now;
		$this->db->insert('form1_application', $insert);
		$form1_id = $this->db->insert_id();

		if($form1_id){
			$this->saveNominees($form1_id, $nominees, $uid, $now, true);
		}

		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			return 0;
		}
		return $form1_id;
	}

	/* ---------------------------------------------------------------
	 * UPDATE (master + replace nominees) in a transaction
	 * ------------------------------------------------------------- */
	public function update($id, $postdata, $nominees = array()){
		$uid = $this->session->userdata('id');
		$now = time();
		$id  = (int)$id;

		$this->db->trans_start();

		$update = $this->mapMaster($postdata);
		$update['updated_by']   = $uid;
		$update['updated_date'] = $now;
		$this->db->where('id', $id);
		$this->db->update('form1_application', $update);

		// replace nominees: soft-delete existing then insert the submitted set
		$this->db->where('form1_id', $id)->update('form1_nominee', array('is_deleted' => 1));
		$this->saveNominees($id, $nominees, $uid, $now, true);

		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			return 0;
		}
		return 1;
	}

	/* ---------------------------------------------------------------
	 * SOFT DELETE
	 * ------------------------------------------------------------- */
	public function softDelete($id){
		$uid = $this->session->userdata('id');
		$this->db->where('id', (int)$id);
		$this->db->update('form1_application', array(
			'is_deleted'   => 1,
			'deleted_by'   => $uid,
			'deleted_date' => time(),
		));
		// cascade soft-delete to nominees
		$this->db->where('form1_id', (int)$id)->update('form1_nominee', array('is_deleted' => 1));
		return $this->db->affected_rows() >= 0 ? 1 : 0;
	}

	/* ---------------------------------------------------------------
	 * Helpers
	 * ------------------------------------------------------------- */
	private function mapMaster($p){
		return array(
			'pran_no'              => isset($p['pran_no']) ? trim($p['pran_no']) : null,
			'emp_id'               => isset($p['emp_id']) ? trim($p['emp_id']) : null,
			'salutation'           => isset($p['salutation']) ? $p['salutation'] : null,
			'first_name'           => isset($p['first_name']) ? trim($p['first_name']) : '',
			'middle_name'          => isset($p['middle_name']) ? trim($p['middle_name']) : null,
			'last_name'            => isset($p['last_name']) ? trim($p['last_name']) : null,
			'gender'               => isset($p['gender']) ? $p['gender'] : null,
			'dob'                  => isset($p['dob']) ? $p['dob'] : null,
			'date_of_joining'      => isset($p['date_of_joining']) ? $p['date_of_joining'] : null,
			'date_of_appointment'  => isset($p['date_of_appointment']) ? $p['date_of_appointment'] : null,
			'designation_id'       => !empty($p['designation_id']) ? (int)$p['designation_id'] : null,
			'pay_scale'            => isset($p['pay_scale']) ? $p['pay_scale'] : null,
			'office_name'          => isset($p['office_name']) ? $p['office_name'] : null,
			'office_address'       => isset($p['office_address']) ? $p['office_address'] : null,
			'residential_address'  => isset($p['residential_address']) ? $p['residential_address'] : null,
			'phone_no'             => isset($p['phone_no']) ? $p['phone_no'] : null,
			'mobile_no'            => isset($p['mobile_no']) ? $p['mobile_no'] : null,
			'email'                => isset($p['email']) ? $p['email'] : null,
			'pay_center'           => isset($p['pay_center']) ? $p['pay_center'] : null,
			'ddo_code'             => isset($p['ddo_code']) ? $p['ddo_code'] : null,
			'dept_code'            => isset($p['dept_code']) ? $p['dept_code'] : null,
			'treasury_code'        => isset($p['treasury_code']) ? $p['treasury_code'] : null,
			'pao_code'             => isset($p['pao_code']) ? $p['pao_code'] : null,
			'prev_govt_service'    => !empty($p['prev_govt_service']) ? 1 : 0,
			'prev_service_details' => isset($p['prev_service_details']) ? $p['prev_service_details'] : null,
		);
	}

	private function saveNominees($form1_id, $nominees, $uid, $now, $isCreate){
		if(empty($nominees) || !is_array($nominees)){
			return;
		}
		foreach($nominees as $n){
			// skip fully empty rows
			if(empty($n['nominee_name']) && empty($n['share_percentage'])){
				continue;
			}
			$this->db->insert('form1_nominee', array(
				'form1_id'         => $form1_id,
				'nominee_name'     => isset($n['nominee_name']) ? trim($n['nominee_name']) : '',
				'nominee_address'  => isset($n['nominee_address']) ? $n['nominee_address'] : null,
				'dob'              => isset($n['dob']) ? $n['dob'] : null,
				'relationship'     => isset($n['relationship']) ? $n['relationship'] : null,
				'share_percentage' => isset($n['share_percentage']) && $n['share_percentage'] !== '' ? $n['share_percentage'] : 0,
				'guardian_name'    => isset($n['guardian_name']) ? $n['guardian_name'] : null,
				'created_by'       => $uid,
				'created_date'     => $now,
			));
		}
	}

	/* convenience: designations for the dropdown */
	public function getDesignations(){
		return $this->db->select('id, designation_name')
			->from('designation')
			->order_by('designation_name', 'asc')
			->get()->result_array();
	}
}
