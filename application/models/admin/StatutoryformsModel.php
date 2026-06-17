<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * StatutoryformsModel
 * Read-only queries that render the statutory DCPS forms from data the
 * application already holds:
 *   FORM-2          : monthly schedule of employee Tier-I contribution
 *   FORM-R-2        : treasury consolidated receipt-cum-schedule (by DDO)
 *   FORM-3 Register : SRKA employee register incl. nominee details
 *   Day Book        : treasury day book for a month
 *
 * Uses raw SQL with fully `dpt_`-prefixed table names, matching the
 * convention already used by MisreportModel for reporting queries.
 */
class StatutoryformsModel extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	/* ---------------------------------------------------------------
	 * FORM-2 : schedule of employee contribution (Tier-I) for a month.
	 * One row per employee. Ordered by pay-centre (DDO) then name.
	 * ------------------------------------------------------------- */
	public function getForm2Schedule($month, $year, $pay_center = ''){
		$sql = "SELECT
				mst.emp_td,
				em.emp_name,
				dd.designation_name,
				mst.pay_center,
				SUM(CAST(mst.basic AS DECIMAL(12,2)))      AS basic,
				SUM(CAST(mst.grade_pay AS DECIMAL(12,2)))  AS dp,
				SUM(CAST(mst.da AS DECIMAL(12,2)))         AS da,
				SUM(CAST(mst.emp_DCPS_contribution AS DECIMAL(12,2)))               AS emp_contribution,
				SUM(CAST(mst.Ideal_contribution_of_employee_for_DCPS AS DECIMAL(12,2))) AS ideal_contribution,
				MAX(mst.recovered_DCPS_with_voucher_no)    AS voucher_no,
				MAX(mst.recovered_DCPS_with_voucher_date)  AS voucher_date
			FROM dpt_master_dcps AS mst
			LEFT JOIN dpt_emp_master  AS em ON em.emp_id = mst.emp_td
			LEFT JOIN dpt_designation AS dd ON dd.id     = mst.designation_id
			WHERE mst.is_deleted = 0
			  AND mst.emp_td > 0
			  AND mst.for_month = " . (int)$month . "
			  AND mst.for_year  = " . (int)$year;
		if($pay_center !== '' && $pay_center !== null){
			$sql .= " AND mst.pay_center = " . $this->db->escape($pay_center);
		}
		$sql .= " GROUP BY mst.emp_td, mst.pay_center
			ORDER BY mst.pay_center ASC, em.emp_name ASC";
		$q = $this->db->query($sql);
		return $q ? $q->result_array() : array();
	}

	/* ---------------------------------------------------------------
	 * FORM-R-2 : consolidated receipt-cum-schedule grouped by DDO.
	 * Same grain as FORM-2 but also exposes the employer (NMC) share.
	 * ------------------------------------------------------------- */
	public function getFormR2($month, $year){
		$sql = "SELECT
				mst.pay_center,
				mst.emp_td,
				em.emp_name,
				SUM(CAST(mst.emp_DCPS_contribution AS DECIMAL(12,2))) AS emp_contribution,
				SUM(CAST(mst.NMC_DCPS_contribution AS DECIMAL(12,2))) AS nmc_contribution,
				MAX(mst.recovered_DCPS_with_voucher_no)   AS voucher_no,
				MAX(mst.recovered_DCPS_with_voucher_date) AS voucher_date
			FROM dpt_master_dcps AS mst
			LEFT JOIN dpt_emp_master AS em ON em.emp_id = mst.emp_td
			WHERE mst.is_deleted = 0
			  AND mst.emp_td > 0
			  AND mst.for_month = " . (int)$month . "
			  AND mst.for_year  = " . (int)$year . "
			GROUP BY mst.pay_center, mst.emp_td
			ORDER BY mst.pay_center ASC, em.emp_name ASC";
		$q = $this->db->query($sql);
		$rows = $q ? $q->result_array() : array();

		// group by DDO (pay-centre) for the view, with subtotals
		$grouped = array();
		foreach($rows as $r){
			$dd = $r['pay_center'] !== '' ? $r['pay_center'] : 'NA';
			if(!isset($grouped[$dd])){
				$grouped[$dd] = array('rows' => array(), 'emp_total' => 0, 'nmc_total' => 0);
			}
			$grouped[$dd]['rows'][]      = $r;
			$grouped[$dd]['emp_total']  += (float)$r['emp_contribution'];
			$grouped[$dd]['nmc_total']  += (float)$r['nmc_contribution'];
		}
		return $grouped;
	}

	/* ---------------------------------------------------------------
	 * FORM-3 Register : SRKA register of employees + nominee details.
	 * Sourced from the FORM-1 master/nominee tables.
	 * ------------------------------------------------------------- */
	public function getForm3Register($pay_center = ''){
		$this->db->select('f.*, d.designation_name');
		$this->db->from('form1_application as f');
		$this->db->join('designation as d', 'd.id = f.designation_id', 'left');
		$this->db->where('f.is_deleted', 0);
		if($pay_center !== '' && $pay_center !== null){
			$this->db->where('f.pay_center', $pay_center);
		}
		$this->db->order_by('f.pran_no', 'asc');
		$apps = $this->db->get()->result_array();

		foreach($apps as &$a){
			$a['nominees'] = $this->db->select('*')
				->from('form1_nominee')
				->where('form1_id', $a['id'])
				->where('is_deleted', 0)
				->order_by('id', 'asc')
				->get()->result_array();
		}
		return $apps;
	}

	/* ---------------------------------------------------------------
	 * Day Book : treasury day book for a month. Contributions grouped
	 * by the recovery/voucher date; the view computes the running total.
	 * ------------------------------------------------------------- */
	public function getDayBook($month, $year, $pay_center = ''){
		$sql = "SELECT
				mst.recovered_DCPS_with_voucher_date AS voucher_date,
				SUM(CAST(mst.emp_DCPS_contribution AS DECIMAL(12,2))
				  + CAST(mst.NMC_DCPS_contribution AS DECIMAL(12,2))) AS amount
			FROM dpt_master_dcps AS mst
			WHERE mst.is_deleted = 0
			  AND mst.emp_td > 0
			  AND mst.for_month = " . (int)$month . "
			  AND mst.for_year  = " . (int)$year;
		if($pay_center !== '' && $pay_center !== null){
			$sql .= " AND mst.pay_center = " . $this->db->escape($pay_center);
		}
		$sql .= " GROUP BY mst.recovered_DCPS_with_voucher_date
			ORDER BY mst.recovered_DCPS_with_voucher_date ASC";
		$q = $this->db->query($sql);
		return $q ? $q->result_array() : array();
	}

	/* ---------------------------------------------------------------
	 * Dropdown helpers
	 * ------------------------------------------------------------- */
	public function getPayCenters(){
		$q = $this->db->query("SELECT DISTINCT pay_center FROM dpt_master_dcps
			WHERE pay_center <> '' AND pay_center IS NOT NULL ORDER BY pay_center ASC");
		return $q ? $q->result_array() : array();
	}

	public function getMonths(){
		return $this->db->select('id, month')->from('month')->order_by('id','asc')->get()->result_array();
	}

	public function getYears(){
		return $this->db->select('year')->from('for_year')->order_by('year','asc')->get()->result_array();
	}
}
