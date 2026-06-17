<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Form1
 * CRUD controller for FORM-1 (DCPS application for Pension Account No. / PRAN).
 *
 * Routes (see config/routes.php):
 *   admin/form1              -> index   (listing)
 *   admin/form1/add          -> add     (GET form / POST save)
 *   admin/form1/edit/$id     -> edit    (GET form / POST update)
 *   admin/form1/view/$id     -> view
 *   admin/form1/delete/$id   -> delete  (soft)
 */
class Form1 extends CI_Controller {

	/** Set by validate() when nominee shares do not total 100%. */
	private $shareError = '';

	public function __construct(){
		parent::__construct();
		$this->load->model('admin/Form1Model', 'f1');
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->helper(array('url', 'form'));

		// keep the same guard style the other admin controllers use
		if(!$this->session->userdata('validated') && $this->router->class != 'login'){
			// redirect('admin/login');
		}
	}

	/* ------------------------------------------------------------ LIST */
	public function index(){
		$search = array(
			'keyword'    => $this->input->get('keyword', TRUE),
			'pay_center' => $this->input->get('pay_center', TRUE),
		);
		$data['results']    = $this->f1->getAll($search);
		$data['search']     = $search;
		$this->load->view('admin/common/header');
		$this->load->view('admin/form1/listing', $data);
		$this->load->view('admin/common/footer');
	}

	/* ------------------------------------------------------------- ADD */
	public function add(){
		if($this->input->post()){
			if($this->validate()){
				$id = $this->f1->insert($this->input->post(), $this->collectNominees());
				if($id){
					$this->handleUpload($id);
					$this->session->set_flashdata('success', 'FORM-1 application saved successfully.');
					redirect('admin/form1');
					return;
				}
				$this->session->set_flashdata('fail', 'Could not save the application. Please try again.');
			}
			// validation failed -> fall through and re-render with errors + old input
			$data['designations'] = $this->f1->getDesignations();
			$data['share_error']  = $this->shareError;
			$this->load->view('admin/common/header');
			$this->load->view('admin/form1/add', $data);
			$this->load->view('admin/common/footer');
			return;
		}

		$data['designations'] = $this->f1->getDesignations();
		$this->load->view('admin/common/header');
		$this->load->view('admin/form1/add', $data);
		$this->load->view('admin/common/footer');
	}

	/* ------------------------------------------------------------ EDIT */
	public function edit($id = 0){
		$id = (int)$id;
		if($this->input->post()){
			if($this->validate()){
				$res = $this->f1->update($id, $this->input->post(), $this->collectNominees());
				if($res){
					$this->handleUpload($id);
					$this->session->set_flashdata('success', 'FORM-1 application updated successfully.');
					redirect('admin/form1');
					return;
				}
				$this->session->set_flashdata('fail', 'Could not update the application.');
			}
		}

		$data['record'] = $this->f1->getById($id);
		if(!$data['record']){
			show_404();
			return;
		}
		$data['designations'] = $this->f1->getDesignations();
		$data['share_error']  = $this->shareError;
		$this->load->view('admin/common/header');
		$this->load->view('admin/form1/edit', $data);
		$this->load->view('admin/common/footer');
	}

	/* ------------------------------------------------------------ VIEW */
	public function view($id = 0){
		$data['record'] = $this->f1->getById((int)$id);
		if(!$data['record']){
			show_404();
			return;
		}
		$this->load->view('admin/common/header');
		$this->load->view('admin/form1/view', $data);
		$this->load->view('admin/common/footer');
	}

	/* ---------------------------------------------------------- DELETE */
	public function delete($id = 0){
		$res = $this->f1->softDelete((int)$id);
		if($res){
			$this->session->set_flashdata('success', 'FORM-1 application deleted.');
		}else{
			$this->session->set_flashdata('fail', 'Could not delete the application.');
		}
		redirect('admin/form1');
	}

	/* ====================================================== helpers === */

	/** Server-side validation rules (CI form_validation). */
	private function validate(){
		$this->form_validation->set_rules('first_name', 'First Name', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('dob', 'Date of Birth', 'required');
		$this->form_validation->set_rules('date_of_joining', 'Date of Joining', 'required');
		$this->form_validation->set_rules('mobile_no', 'Mobile No', 'trim|regex_match[/^[0-9]{10}$/]',
			array('regex_match' => 'The {field} must be a valid 10-digit number.'));
		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');

		$ok = $this->form_validation->run();

		// nominee share total must equal 100 when nominees are supplied
		$nominees = $this->collectNominees();
		if(!empty($nominees)){
			$sum = 0;
			foreach($nominees as $n){
				$sum += (float)(isset($n['share_percentage']) ? $n['share_percentage'] : 0);
			}
			if(abs($sum - 100) > 0.01){
				$this->shareError = 'Total nominee share must add up to 100% (currently '.$sum.'%).';
				$ok = FALSE;
			}
		}

		return $ok;
	}

	/** Re-shape the parallel nominee_* arrays from POST into row objects. */
	private function collectNominees(){
		$names = $this->input->post('nominee_name');
		if(empty($names) || !is_array($names)){
			return array();
		}
		$addr  = $this->input->post('nominee_address');
		$dob   = $this->input->post('nominee_dob');
		$rel   = $this->input->post('nominee_relationship');
		$share = $this->input->post('nominee_share');
		$guard = $this->input->post('nominee_guardian');

		$rows = array();
		foreach($names as $i => $name){
			if(trim($name) === '' && (empty($share[$i]) || $share[$i] === '')){
				continue;
			}
			$rows[] = array(
				'nominee_name'     => $name,
				'nominee_address'  => isset($addr[$i]) ? $addr[$i] : '',
				'dob'              => isset($dob[$i]) ? $dob[$i] : '',
				'relationship'     => isset($rel[$i]) ? $rel[$i] : '',
				'share_percentage' => isset($share[$i]) ? $share[$i] : 0,
				'guardian_name'    => isset($guard[$i]) ? $guard[$i] : '',
			);
		}
		return $rows;
	}

	/** Optional upload of the scanned FORM-1 into assets/uploads/form1/. */
	private function handleUpload($id){
		if(empty($_FILES['form_scan']['name'])){
			return;
		}
		$dir = FCPATH.'assets/uploads/form1/';
		if(!is_dir($dir)){
			@mkdir($dir, 0775, TRUE);
		}
		$config = array(
			'upload_path'   => $dir,
			'allowed_types' => 'pdf|jpg|jpeg|png',
			'max_size'      => 4096,
			'file_name'     => 'form1_'.$id.'_'.time(),
		);
		$this->load->library('upload', $config);
		if($this->upload->do_upload('form_scan')){
			$up = $this->upload->data();
			$this->db->where('id', (int)$id)
				->update('form1_application', array('form_scan' => $up['file_name']));
		}
	}
}
