<?php if(!defined('BASEPATH')) exit('no direct script Access allowed'); 

class ReportModel extends CI_Model
{
	
	public function __construct(){
		parent::__construct();
	}

	public function getMonthData(){
	    $this->db->select('*');
		$this->db->from('month');
		$query = $this->db->get();
		if ($query) {
			return $query->result_array();
		}
		return false;
	}

	public function getYearData(){
	    $this->db->select('*');
		$this->db->from('for_year');
		$query = $this->db->get();
		if ($query) {
			return $query->result_array();
		}
		return false;
	}

	public function getDetailsOfEmp($year){
		if($year){
			$nxtYear = $year + 1;
			// echo $nxtYear;die();
			$this->db->select('
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 4 ) THEN md.basic ELSE 0 END) as basic_apr,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 5 ) THEN md.basic ELSE 0 END) as basic_may,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 6 ) THEN md.basic ELSE 0 END) as basic_june,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 7 ) THEN md.basic ELSE 0 END) as basic_july,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 8 ) THEN md.basic ELSE 0 END) as basic_aug,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 9 ) THEN md.basic ELSE 0 END) as basic_sept,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 10 ) THEN md.basic ELSE 0 END) as basic_oct,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 11 ) THEN md.basic ELSE 0 END) as basic_nov,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 12 ) THEN md.basic ELSE 0 END) as basic_dec,
				sum(CASE WHEN (md.for_year = '.$nxtYear.' and md.for_month = 1 ) THEN md.basic ELSE 0 END) as basic_jan,
				sum(CASE WHEN (md.for_year = '.$nxtYear.' and md.for_month = 2 ) THEN md.basic ELSE 0 END) as basic_feb,
				sum(CASE WHEN (md.for_year = '.$nxtYear.' and md.for_month = 3 ) THEN md.basic ELSE 0 END) as basic_mar,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 4 ) THEN md.grade_pay ELSE 0 END) as grade_pay_apr,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 5 ) THEN md.grade_pay ELSE 0 END) as grade_pay_may,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 6 ) THEN md.grade_pay ELSE 0 END) as grade_pay_june,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 7 ) THEN md.grade_pay ELSE 0 END) as grade_pay_july,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 8 ) THEN md.grade_pay ELSE 0 END) as grade_pay_aug,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 9 ) THEN md.grade_pay ELSE 0 END) as grade_pay_sept,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 10 ) THEN md.grade_pay ELSE 0 END) as grade_pay_oct,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 11 ) THEN md.grade_pay ELSE 0 END) as grade_pay_nov,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 12 ) THEN md.grade_pay ELSE 0 END) as grade_pay_dec,
				sum(CASE WHEN (md.for_year = '.$nxtYear.' and md.for_month = 1 ) THEN md.grade_pay ELSE 0 END) as grade_pay_jan,
				sum(CASE WHEN (md.for_year = '.$nxtYear.' and md.for_month = 2 ) THEN md.grade_pay ELSE 0 END) as grade_pay_feb,
				sum(CASE WHEN (md.for_year = '.$nxtYear.' and md.for_month = 3 ) THEN md.grade_pay ELSE 0 END) as grade_pay_mar,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 4 ) THEN md.da ELSE 0 END) as da_apr,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 5 ) THEN md.da ELSE 0 END) as da_may,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 6 ) THEN md.da ELSE 0 END) as da_june,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 7 ) THEN md.da ELSE 0 END) as da_july,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 8 ) THEN md.da ELSE 0 END) as da_aug,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 9 ) THEN md.da ELSE 0 END) as da_sept,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 10 ) THEN md.da ELSE 0 END) as da_oct,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 11 ) THEN md.da ELSE 0 END) as da_nov,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 12 ) THEN md.da ELSE 0 END) as da_dec,
				sum(CASE WHEN (md.for_year = '.$nxtYear.' and md.for_month = 1 ) THEN md.da ELSE 0 END) as da_jan,
				sum(CASE WHEN (md.for_year = '.$nxtYear.' and md.for_month = 2 ) THEN md.da ELSE 0 END) as da_feb,
				sum(CASE WHEN (md.for_year = '.$nxtYear.' and md.for_month = 3 ) THEN md.da ELSE 0 END) as da_mar,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 4 ) THEN md.emp_DCPS_contribution ELSE 0 END) as emp_DCPS_contribution_apr,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 5 ) THEN md.emp_DCPS_contribution ELSE 0 END) as emp_DCPS_contribution_may,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 6 ) THEN md.emp_DCPS_contribution ELSE 0 END) as emp_DCPS_contribution_june,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 7 ) THEN md.emp_DCPS_contribution ELSE 0 END) as emp_DCPS_contribution_july,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 8 ) THEN md.emp_DCPS_contribution ELSE 0 END) as emp_DCPS_contribution_aug,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 9 ) THEN md.emp_DCPS_contribution ELSE 0 END) as emp_DCPS_contribution_sept,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 10 ) THEN md.emp_DCPS_contribution ELSE 0 END) as emp_DCPS_contribution_oct,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 11 ) THEN md.emp_DCPS_contribution ELSE 0 END) as emp_DCPS_contribution_nov,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 12 ) THEN md.emp_DCPS_contribution ELSE 0 END) as emp_DCPS_contribution_dec,
				sum(CASE WHEN (md.for_year = '.$nxtYear.' and md.for_month = 1 ) THEN md.emp_DCPS_contribution ELSE 0 END) as emp_DCPS_contribution_jan,
				sum(CASE WHEN (md.for_year = '.$nxtYear.' and md.for_month = 2 ) THEN md.emp_DCPS_contribution ELSE 0 END) as emp_DCPS_contribution_feb,
				sum(CASE WHEN (md.for_year = '.$nxtYear.' and md.for_month = 3 ) THEN md.emp_DCPS_contribution ELSE 0 END) as emp_DCPS_contribution_mar,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 4 ) THEN md.emp_DCPS_supplimentory_contribution ELSE 0 END) as emp_DCPS_supplimentory_contribution_apr,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 5 ) THEN md.emp_DCPS_supplimentory_contribution ELSE 0 END) as emp_DCPS_supplimentory_contribution_may,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 6 ) THEN md.emp_DCPS_supplimentory_contribution ELSE 0 END) as emp_DCPS_supplimentory_contribution_june,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 7 ) THEN md.emp_DCPS_supplimentory_contribution ELSE 0 END) as emp_DCPS_supplimentory_contribution_july,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 8 ) THEN md.emp_DCPS_supplimentory_contribution ELSE 0 END) as emp_DCPS_supplimentory_contribution_aug,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 9 ) THEN md.emp_DCPS_supplimentory_contribution ELSE 0 END) as emp_DCPS_supplimentory_contribution_sept,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 10 ) THEN md.emp_DCPS_supplimentory_contribution ELSE 0 END) as emp_DCPS_supplimentory_contribution_oct,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 11 ) THEN md.emp_DCPS_supplimentory_contribution ELSE 0 END) as emp_DCPS_supplimentory_contribution_nov,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 12 ) THEN md.emp_DCPS_supplimentory_contribution ELSE 0 END) as emp_DCPS_supplimentory_contribution_dec,
				sum(CASE WHEN (md.for_year = '.$nxtYear.' and md.for_month = 1 ) THEN md.emp_DCPS_supplimentory_contribution ELSE 0 END) as emp_DCPS_supplimentory_contribution_jan,
				sum(CASE WHEN (md.for_year = '.$nxtYear.' and md.for_month = 2 ) THEN md.emp_DCPS_supplimentory_contribution ELSE 0 END) as emp_DCPS_supplimentory_contribution_feb,
				sum(CASE WHEN (md.for_year = '.$nxtYear.' and md.for_month = 3 ) THEN md.emp_DCPS_supplimentory_contribution ELSE 0 END) as emp_DCPS_supplimentory_contribution_mar,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 4 ) THEN md.NMC_DCPS_contribution ELSE 0 END) as NMC_DCPS_contribution_apr,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 5 ) THEN md.NMC_DCPS_contribution ELSE 0 END) as NMC_DCPS_contribution_may,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 6 ) THEN md.NMC_DCPS_contribution ELSE 0 END) as NMC_DCPS_contribution_june,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 7 ) THEN md.NMC_DCPS_contribution ELSE 0 END) as NMC_DCPS_contribution_july,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 8 ) THEN md.NMC_DCPS_contribution ELSE 0 END) as NMC_DCPS_contribution_aug,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 9 ) THEN md.NMC_DCPS_contribution ELSE 0 END) as NMC_DCPS_contribution_sept,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 10 ) THEN md.NMC_DCPS_contribution ELSE 0 END) as NMC_DCPS_contribution_oct,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 11 ) THEN md.NMC_DCPS_contribution ELSE 0 END) as NMC_DCPS_contribution_nov,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 12 ) THEN md.NMC_DCPS_contribution ELSE 0 END) as NMC_DCPS_contribution_dec,
				sum(CASE WHEN (md.for_year = '.$nxtYear.' and md.for_month = 1 ) THEN md.NMC_DCPS_contribution ELSE 0 END) as NMC_DCPS_contribution_jan,
				sum(CASE WHEN (md.for_year = '.$nxtYear.' and md.for_month = 2 ) THEN md.NMC_DCPS_contribution ELSE 0 END) as NMC_DCPS_contribution_feb,
				sum(CASE WHEN (md.for_year = '.$nxtYear.' and md.for_month = 3 ) THEN md.NMC_DCPS_contribution ELSE 0 END) as NMC_DCPS_contribution_mar,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 4 ) THEN md.NMC_supplimentory_DCPS_contribution ELSE 0 END) as NMC_supplimentory_DCPS_contribution_apr,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 5 ) THEN md.NMC_supplimentory_DCPS_contribution ELSE 0 END) as NMC_supplimentory_DCPS_contribution_may,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 6 ) THEN md.NMC_supplimentory_DCPS_contribution ELSE 0 END) as NMC_supplimentory_DCPS_contribution_june,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 7 ) THEN md.NMC_supplimentory_DCPS_contribution ELSE 0 END) as NMC_supplimentory_DCPS_contribution_july,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 8 ) THEN md.NMC_supplimentory_DCPS_contribution ELSE 0 END) as NMC_supplimentory_DCPS_contribution_aug,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 9 ) THEN md.NMC_supplimentory_DCPS_contribution ELSE 0 END) as NMC_supplimentory_DCPS_contribution_sept,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 10 ) THEN md.NMC_supplimentory_DCPS_contribution ELSE 0 END) as NMC_supplimentory_DCPS_contribution_oct,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 11 ) THEN md.NMC_supplimentory_DCPS_contribution ELSE 0 END) as NMC_supplimentory_DCPS_contribution_nov,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 12 ) THEN md.NMC_supplimentory_DCPS_contribution ELSE 0 END) as NMC_supplimentory_DCPS_contribution_dec,
				sum(CASE WHEN (md.for_year = '.$nxtYear.' and md.for_month = 1 ) THEN md.NMC_supplimentory_DCPS_contribution ELSE 0 END) as NMC_supplimentory_DCPS_contribution_jan,
				sum(CASE WHEN (md.for_year = '.$nxtYear.' and md.for_month = 2 ) THEN md.NMC_supplimentory_DCPS_contribution ELSE 0 END) as NMC_supplimentory_DCPS_contribution_feb,
				sum(CASE WHEN (md.for_year = '.$nxtYear.' and md.for_month = 3 ) THEN md.NMC_supplimentory_DCPS_contribution ELSE 0 END) as NMC_supplimentory_DCPS_contribution_mar,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 4 ) THEN md.DCPS_loan_taken_by_an_employee ELSE 0 END) as DCPS_loan_taken_by_an_employee_apr,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 5 ) THEN md.DCPS_loan_taken_by_an_employee ELSE 0 END) as DCPS_loan_taken_by_an_employee_may,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 6 ) THEN md.DCPS_loan_taken_by_an_employee ELSE 0 END) as DCPS_loan_taken_by_an_employee_june,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 7 ) THEN md.DCPS_loan_taken_by_an_employee ELSE 0 END) as DCPS_loan_taken_by_an_employee_july,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 8 ) THEN md.DCPS_loan_taken_by_an_employee ELSE 0 END) as DCPS_loan_taken_by_an_employee_aug,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 9 ) THEN md.DCPS_loan_taken_by_an_employee ELSE 0 END) as DCPS_loan_taken_by_an_employee_sept,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 10 ) THEN md.DCPS_loan_taken_by_an_employee ELSE 0 END) as DCPS_loan_taken_by_an_employee_oct,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 11 ) THEN md.DCPS_loan_taken_by_an_employee ELSE 0 END) as DCPS_loan_taken_by_an_employee_nov,
				sum(CASE WHEN (md.for_year = '.$year.' and md.for_month = 12 ) THEN md.DCPS_loan_taken_by_an_employee ELSE 0 END) as DCPS_loan_taken_by_an_employee_dec,
				sum(CASE WHEN (md.for_year = '.$nxtYear.' and md.for_month = 1 ) THEN md.DCPS_loan_taken_by_an_employee ELSE 0 END) as DCPS_loan_taken_by_an_employee_jan,
				sum(CASE WHEN (md.for_year = '.$nxtYear.' and md.for_month = 2 ) THEN md.DCPS_loan_taken_by_an_employee ELSE 0 END) as DCPS_loan_taken_by_an_employee_feb,
				sum(CASE WHEN (md.for_year = '.$nxtYear.' and md.for_month = 3 ) THEN md.DCPS_loan_taken_by_an_employee ELSE 0 END) as DCPS_loan_taken_by_an_employee_mar

				');
			$this->db->from('master_dcps as md');
			//$this->db->where('is_deleted as md','0');
			// $this->db->join('gr_management as gr','gr.gr_month = md.for_month AND gr.gr_year = md.for_year','left');
// 			$this->db->join('month as m','m.id = md.for_month');
// 			$this->db->join('for_year as y','y.id = md.for_year');
			
			// NOTE: ensure is_deleted applies to BOTH years (operator precedence fix)
			$this->db->where("((md.for_year = {$year}) OR (md.for_year = {$nxtYear}))");
			$this->db->where('md.is_deleted', 0);
			// $this->db->where('for_year',$year);
			// $this->db->where('for_year',$nxtYear);
			// $this->db->order_by('m.id','asc');
			$query = $this->db->get();
			// print_r($this->db->last_query());die();
			if ($query) {
				return $query->row_array();
			}
			
		}
		return 0;
	}

	public function getLastOpBal($year){
		$lastYear = $year - 1;
		// echo $lastYear;die();
		// echo $year;die();
		// $lastMonth = 3;
		$this->db->select('sum(opening_balance),for_month,for_year');
		$this->db->from('master_dcps');
		// $this->db->join('month as m','m.id = md.for_month');
		// $this->db->where('md.emp_td',$id);
		$this->db->where('((for_year = '.$lastYear.' AND for_month >=4) OR (for_year = '.$year.' AND for_month <=3)) AND is_deleted = 0');
		$this->db->order_by('for_year','asc');
		$this->db->order_by('for_month','asc');
		// $this->db->where('md.for_year',$year);
		// $this->db->where('md.for_month',$lastMonth);
		// $this->db->order_by('m.id','asc');
		$query = $this->db->get();
		if ($query) {
			return $query->result_array();
		}
		return 0;
	}

	public function getGrManageData($year){
		$nxtYear = $year + 1;
	    $this->db->select('*');
		$this->db->from('gr_management as gr');
		$where = 'gr.gr_year = '.$nxtYear.' OR gr.gr_year='.$year;    
		$this->db->where($where);
		$query = $this->db->get();
		// print_r($this->db->last_query());die();
		if ($query) {
			return $query->result_array();
		}
		return false;
	}

	public function getDeductionRecord($id,$year){
		// echo "<pre>";print($id);
		// echo "<pre>";print($year);die();
	    $this->db->select('md.id,md.emp_td,md.joining_date,md.emp_name,md.basic,md.da,md.grade_pay,md.for_year,md.for_month,m.month');
		$this->db->from('master_dcps as md');
		$this->db->join('month as m','m.id = md.for_month');
		$this->db->where('md.emp_td',$id);
		$this->db->where('md.for_year',$year);
		$this->db->where('md.is_deleted',0);
		$this->db->order_by('m.id','asc');
		// $this->db->limit(10);
		$query = $this->db->get();
		if ($query) {
			return $query->result_array();
		}
		return false;
	}
	public function getMonthlyRecord($for_month,$year){
		// echo "<pre>";print($for_month);
		// echo "<pre>";print($year);die();
	    $this->db->select('md.id,md.emp_td,md.joining_date,md.emp_name,md.basic,md.da,md.grade_pay,md.for_year,md.for_month,md.recovered_DCPS_with_voucher_no,md.recovered_DCPS_with_voucher_date,md.emp_DCPS_contribution,md.emp_DCPS_supplimentory_contribution,m.month');
		$this->db->from('master_dcps as md');
		$this->db->join('month as m','m.id = md.for_month');
		$this->db->where('md.for_month',$for_month);
		$this->db->where('md.for_year',$year);
		$this->db->where('md.is_deleted',0);
		$this->db->order_by('md.emp_td','ASC');
		// $this->db->limit(10);
		$query = $this->db->get();
		//echo  $this->db->last_query();exit;
		if ($query) {
			return $query->result_array();
		}
		return false;
	}

	public function getAllEmployeeDetails($id){
	    $this->db->select('*');
		$this->db->from('master_dcps');
		$this->db->where('id',$id);
		$this->db->where('is_deleted',0);
		$query = $this->db->get();
		if ($query) {
			return $query->row_array();
		}
		return false;
	}
	
	public function getMissingMonthYearRecordsOld(){
		$this->db->select('id, emp_td, `joining_date`, `emp_name`, `basic`, `da`, `total_salary`, `grade_pay`, `bunch_no`, `file_no`, `recovered_DCPS_with_voucher_no`, `recovered_DCPS_with_voucher_date`,`salary_start_date`, `salary_end_date`, for_month, for_year, joining_date, pay_center, designation_id, remark');
		$this->db->from('dpt_master_dcps');
		$this->db->where('is_deleted', 0);
		$this->db->where('emp_td > 0 ');
		$this->db->where('(for_month = 0 OR for_month IS NULL OR for_year = 0 OR for_year IS NULL)');
		$this->db->order_by('emp_td','ASC');
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		if ($query) {
			return $query->result_array();
		}
		return false;
	}
	
	public function getMissingMonthYearRecords()
{
    $this->db->select('
        id,
        emp_td,
        joining_date,
        emp_name,
        basic,
        da,
        total_salary,
        grade_pay,
        bunch_no,
        file_no,
        recovered_DCPS_with_voucher_no,
        recovered_DCPS_with_voucher_date,
        salary_start_date,
        salary_end_date,
        for_month,
        for_year,
        pay_center,
        designation_id,
        remark
    ');
    
    $this->db->from('dpt_master_dcps');
    $this->db->where('is_deleted', 0);
    $this->db->where('emp_td >', 0);

    // BOTH month AND year must be missing or zero
    $this->db->group_start()
        ->group_start()
            ->where('for_month', 0)
            ->or_where('for_month IS NULL', null, false)
        ->group_end()
        ->group_start()
            ->where('for_year', 0)
            ->or_where('for_year IS NULL', null, false)
        ->group_end()
    ->group_end();

    $this->db->order_by('emp_td', 'ASC');

    $query = $this->db->get();
    // echo $this->db->last_query(); exit;

    if ($query && $query->num_rows() > 0) {
        return $query->result_array();
    }

    return [];
}


	public function updateDeductionRecordOld($postData,$id){
		if($postData){
			// echo $postdata['id'];
			// echo "test==>".$id."<pre>";print_r($postData);die();
			
			$propCreatedBy = $this->session->userdata('id');
			$rec_month = implode(",",$_POST['recovered_month']);
			// $date1 = $postData['to_be_recovered_for_voucher_date'];
			// $dtes1 = explode(".",$date1);
			// $to_be_recovered_for_voucher_date = mktime(0,0,0,$dtes1[1],$dtes1[0],$dtes1[2]);
			
			$updateArray['joining_date'] = $postData['wef_date'];
			$updateArray['pay_center'] = $postData['pay_center'];
			$updateArray['basic'] = $postData['basic'];
			$updateArray['da'] = $postData['da'];
			$updateArray['grade_pay'] = $postData['grade_pay'];
			$updateArray['Ideal_contribution_of_employee_for_DCPS'] = $postData['Ideal_contribution_of_employee_for_DCPS'];
			$updateArray['Ideal_contribution_of_NMC_for_DCPS'] = $postData['Ideal_contribution_of_NMC_for_DCPS'];
			$updateArray['opening_balance'] = $postData['opening_balance'];
			
			$updateArray['bunch_no'] = $postData['bunch_no'];
			$updateArray['file_no'] = $postData['file_no'];
			
			$updateArray['recovered_DCPS_with_voucher_no'] = $postData['recovered_DCPS_with_voucher_no'];
			$updateArray['for_month'] = $postData['for_month'];
			$updateArray['for_year'] = $postData['year'];
			$updateArray['recovered_DCPS_with_voucher_date'] = $postData['recovered_DCPS_with_voucher_date'];
			
			$updateArray['emp_DCPS_contribution'] = $postData['emp_DCPS_contribution'];
			$updateArray['emp_DCPS_supplimentory_contribution'] = $postData['emp_DCPS_supplimentory_contribution'];
			$updateArray['NMC_DCPS_contribution'] = $postData['NMC_DCPS_contribution'];
			$updateArray['NMC_supplimentory_DCPS_contribution'] = $postData['NMC_supplimentory_DCPS_contribution'];
			$updateArray['DCPS_loan_taken_by_an_employee'] = $postData['DCPS_loan_taken_by_an_employee'];
			$updateArray['loan_installment_paid_through_salary'] = $postData['loan_installment_paid_through_salary'];
			$updateArray['loan_installment_paid_in_cash'] = $postData['loan_installment_paid_in_cash'];
			$updateArray['supplimentory_loan_installment_paid'] = $postData['supplimentory_loan_installment_paid'];
			$updateArray['total_amount_of_loan_installments_paid'] = $postData['total_amount_of_loan_installments_paid'];
			$updateArray['amount_to_be_recovered_from_emp'] = $postData['amount_to_be_recovered_from_emp'];
			$updateArray['to_be_recovered_for_voucher_no'] = $postData['to_be_recovered_for_voucher_no'];
			// $updateArray['to_be_recovered_for_voucher_date'] = $to_be_recovered_for_voucher_date;
			$updateArray['to_be_recovered_for_voucher_date'] = $postData['to_be_recovered_for_voucher_date'];
			$updateArray['gr_percentage'] = $postData['gr_percentage'];
			$updateArray['recovered_with_voucher_no'] = $postData['recovered_with_voucher_no'];
			$updateArray['recovered_date'] = $postData['recovered_date'];
			$updateArray['recovered_month'] = $rec_month;
			$updateArray['recovered_year'] = $postData['recovered_year'];
			$updateArray['remark'] = $postData['remark'];
			$updateArray['remark'] = $postData['remark'];
			$updateArray['remark'] = $postData['remark'];
			$updateArray['remark'] = $postData['remark'];
			
			$updateArray['last_modified'] = $propCreatedBy;
			$updateArray['last_modified_date'] = time();
			echo "<pre>"; print_r($updateArray); exit;
			
			$this->db->where('id', $id);
			$this->db->update('master_dcps', $updateArray);
			// print_r($this->db->last_query());die();
			if($this->db->affected_rows() > 0){
				// echo "string Ravi 1";die();
				return 1;
			}
			// echo "string Ravi 2";die();
			return 0;
				
		}
	}
	
	public function updateDeductionRecord($postData, $id) {
        if ($postData) {
    
            $propCreatedBy = $this->session->userdata('id');
            $rec_month = isset($_POST['recovered_month']) ? implode(",", $_POST['recovered_month']) : '';
    
            $updateArray['joining_date'] = isset($postData['wef_date']) ? $postData['wef_date'] : '';
            $updateArray['pay_center'] = isset($postData['pay_center']) ? $postData['pay_center'] : '';
            $updateArray['basic'] = isset($postData['basic']) ? $postData['basic'] : '';
            $updateArray['da'] = isset($postData['da']) ? $postData['da'] : '';
            $updateArray['grade_pay'] = isset($postData['grade_pay']) ? $postData['grade_pay'] : '';
            
            $updateArray['total_salary'] = 
            $updateArray['basic'] + $updateArray['da'] + $updateArray['grade_pay'];
            
            $updateArray['Ideal_contribution_of_employee_for_DCPS'] = isset($postData['Ideal_contribution_of_employee_for_DCPS']) ? $postData['Ideal_contribution_of_employee_for_DCPS'] : '';
            $updateArray['Ideal_contribution_of_NMC_for_DCPS'] = isset($postData['Ideal_contribution_of_NMC_for_DCPS']) ? $postData['Ideal_contribution_of_NMC_for_DCPS'] : '';
            $updateArray['opening_balance'] = isset($postData['opening_balance']) ? $postData['opening_balance'] : '';
    
            $updateArray['bunch_no'] = isset($postData['bunch_no']) ? $postData['bunch_no'] : '';
            $updateArray['file_no'] = isset($postData['file_no']) ? $postData['file_no'] : '';
    
            $updateArray['recovered_DCPS_with_voucher_no'] = isset($postData['recovered_DCPS_with_voucher_no']) ? $postData['recovered_DCPS_with_voucher_no'] : '';
            $updateArray['for_month'] = isset($postData['for_month']) ? $postData['for_month'] : '';
            //$updateArray['for_year'] = isset($postData['year']) ? $postData['year'] : '';
            
            if (!empty($postData['for_month']) && !empty($postData['for_year'])) {
                $month = (int)$postData['for_month'];
                list($startYear, $endYear) = explode('-', $postData['for_year']);
            
                // जर महिना >= 4 असेल तर तो current financial year मध्ये येईल
                if ($month >= 4) {
                    $finalYear = $startYear;
                } else {
                    // महिना 1,2,3 (Jan, Feb, Mar) असेल तर previous financial year
                    $finalYear = $endYear;
                }
            
                $updateArray['for_month'] = $month;
                $updateArray['for_year']  = $finalYear;
            }

            $updateArray['recovered_DCPS_with_voucher_date'] = isset($postData['recovered_DCPS_with_voucher_date']) ? $postData['recovered_DCPS_with_voucher_date'] : '';
    
            $updateArray['emp_DCPS_contribution'] = isset($postData['emp_DCPS_contribution']) ? $postData['emp_DCPS_contribution'] : '';
            $updateArray['emp_DCPS_supplimentory_contribution'] = isset($postData['emp_DCPS_supplimentory_contribution']) ? $postData['emp_DCPS_supplimentory_contribution'] : '';
            $updateArray['NMC_DCPS_contribution'] = isset($postData['NMC_DCPS_contribution']) ? $postData['NMC_DCPS_contribution'] : '';
            $updateArray['NMC_supplimentory_DCPS_contribution'] = isset($postData['NMC_supplimentory_DCPS_contribution']) ? $postData['NMC_supplimentory_DCPS_contribution'] : '';
            $updateArray['DCPS_loan_taken_by_an_employee'] = isset($postData['DCPS_loan_taken_by_an_employee']) ? $postData['DCPS_loan_taken_by_an_employee'] : '';
            $updateArray['loan_installment_paid_through_salary'] = isset($postData['loan_installment_paid_through_salary']) ? $postData['loan_installment_paid_through_salary'] : '';
            $updateArray['loan_installment_paid_in_cash'] = isset($postData['loan_installment_paid_in_cash']) ? $postData['loan_installment_paid_in_cash'] : '';
            $updateArray['supplimentory_loan_installment_paid'] = isset($postData['supplimentory_loan_installment_paid']) ? $postData['supplimentory_loan_installment_paid'] : '';
            $updateArray['total_amount_of_loan_installments_paid'] = isset($postData['total_amount_of_loan_installments_paid']) ? $postData['total_amount_of_loan_installments_paid'] : '';
            $updateArray['amount_to_be_recovered_from_emp'] = isset($postData['amount_to_be_recovered_from_emp']) ? $postData['amount_to_be_recovered_from_emp'] : '';
            $updateArray['to_be_recovered_for_voucher_no'] = isset($postData['to_be_recovered_for_voucher_no']) ? $postData['to_be_recovered_for_voucher_no'] : '';
            $updateArray['to_be_recovered_for_voucher_date'] = isset($postData['to_be_recovered_for_voucher_date']) ? $postData['to_be_recovered_for_voucher_date'] : '';
            $updateArray['gr_percentage'] = isset($postData['gr_percentage']) ? $postData['gr_percentage'] : '';
            $updateArray['recovered_with_voucher_no'] = isset($postData['recovered_with_voucher_no']) ? $postData['recovered_with_voucher_no'] : '';
            $updateArray['recovered_date'] = isset($postData['recovered_date']) ? $postData['recovered_date'] : '';
            $updateArray['recovered_month'] = $rec_month;
            $updateArray['recovered_year'] = isset($postData['recovered_year']) ? $postData['recovered_year'] : '';
            
            $updateArray['salary_type'] = isset($postData['salary_type']) ? $postData['salary_type'] : '';
            $updateArray['salary_start_date'] = isset($postData['salary_start_date']) ? $postData['salary_start_date'] : '';
            $updateArray['salary_end_date'] = isset($postData['salary_end_date']) ? $postData['salary_end_date'] : '';
            $updateArray['remark'] = isset($postData['remark']) ? $postData['remark'] : '';
            $updateArray['reason'] = isset($postData['reason']) ? $postData['reason'] : '';
    
            $updateArray['updated_by'] = $propCreatedBy;
            $updateArray['updated_date'] = time();
            
            //echo "<pre>updateData=>"; print_r($updateArray); exit;
    
            $this->db->where('id', $id);
            $this->db->update('master_dcps', $updateArray);
    
            return ($this->db->affected_rows() > 0) ? 1 : 0;
        }
    }


	public function getDeatailsOfEmployee($id){
	    $this->db->select('master_dcps.*, dpt_emp_master.joining_date');
		$this->db->from('master_dcps');
		$this->db->join('dpt_emp_master', 'dpt_emp_master.emp_id = master_dcps.emp_td', 'inner');
		$this->db->where('master_dcps.id',$id);
		$this->db->where('master_dcps.is_deleted in (0,3)');
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		if ($query) {
			return $query->row_array();
		}
		return false;
	}
	public function getYearsOfEmp($postdata){
		if($postdata['id']){
			return $this->db->select('md.id,md.emp_td, md.emp_name, m.id,md.for_month, md.for_year,m.month')->from('master_dcps as md')->join('month as m','m.id = md.for_month')->where('emp_td',$postdata['id'])->where('for_year',$postdata['year'])->order_by('m.id','asc')->get()->result();
		}
		return 0;
	}

	public function getDetailsOfEmpForSlipAndLeadger($id,$year){
		// echo $id;die();
		$nxtYear = $year + 1;

		$this->db->select('md.id as md_id, md.emp_td, md.emp_name, md.for_month, md.for_year, md.opening_balance, md.joining_date, md.basic, md.grade_pay, md.da, md.emp_DCPS_contribution, md.emp_DCPS_supplimentory_contribution, md.NMC_DCPS_contribution, md.NMC_supplimentory_DCPS_contribution, m.id as m_id,m.month, gr.gr_percentage, md.DCPS_loan_taken_by_an_employee as withdrawal');
		$this->db->from('master_dcps as md');
		$this->db->join('month as m','m.id = md.for_month');
		$this->db->join('gr_management as gr','gr.gr_month = md.for_month AND gr.gr_year = md.for_year');
		// $this->db->join('gr_management as gr','gr.gr_year = md.for_year');
		
		// $where = 'md.emp_td = '.$id.' AND ((md.for_year = '.$year.' AND md.for_month >=4) OR (md.for_year = '.$nxtYear.' AND md.for_month <=3))';
		// $where_to = 'md.for_year = '.$nxtYear.' AND md.for_month <=3';    
		// $this->db->where($where);
		$this->db->where('((md.for_year = '.$year.' AND md.for_month >=4) OR (md.for_year = '.$nxtYear.' AND md.for_month <=3))');
		$this->db->where('md.emp_td',$id);
		$this->db->where('md.is_deleted',0);
		$this->db->order_by('md.for_year','asc');
		$this->db->order_by('m_id','asc');
		$query = $this->db->get();
		// print_r($this->db->last_query());die();
		if ($query) {
			return $query->result_array();
		}
		return 0;
	}

	public function getDataForOpenigBalTable($id,$year){
		
		$nextYear = $year + 1;
		// echo $year;die();
		// $lastMonth = 3;
		$this->db->select('md.opening_balance,md.for_month,md.for_year');
		$this->db->from('master_dcps as md');
		// $this->db->join('month as m','m.id = md.for_month');
		$this->db->where('md.emp_td',$id);
		$this->db->where('md.is_deleted',0);
		$this->db->where('((md.for_year = '.$year.' AND md.for_month >=4) OR (md.for_year = '.$nextYear.' AND md.for_month <=3))');
		$this->db->order_by('md.for_year','asc');
		$this->db->order_by('md.for_month','asc');
		// $this->db->where('md.for_year',$year);
		// $this->db->where('md.for_month',$lastMonth);
		// $this->db->order_by('m.id','asc');
		$query = $this->db->get();
		// print_r($this->db->last_query());die();
		if ($query) {
			return $query->result_array();
		}
		return 0;
	}

	public function getCustomerDetails($id){
		if($id){
			return $this->db->select('id,emp_td, emp_name, for_month, for_year')->from('master_dcps')->where('emp_td',$id)->where('is_deleted',0)->get()->result();
		}
		return 0;
	}
	
	public function getCustomerDetailsNew($id="", $year=""){
		$this->db->select('id,emp_td, emp_name, for_month, for_year');
		$this->db->from('master_dcps');
		if(isset($id) && $id){
		    $this->db->where('emp_td',$id);
		}
		if(isset($month) && $month){
		    $this->db->where('emp_td',$month);
		}
		if(isset($year) && $year){
		    $nextYear = $year + 1;
		    $this->db->where('((for_year = '.$year.' AND for_month >=4) OR (for_year = '.$nextYear.' AND for_month <=3))');
		}
		$this->db->where('is_deleted',0);
		$query = $this->db->get();
		if ($query) {
			return $query->result();
		}
		return 0;
	}

	public function getcustomerinfo($data=array()){
		// echo "<pre>";print_r($data);die();

		$this->db->select('md.*');
		$this->db->from('master_dcps as md');
		// $this->db->join('month as m','m.id = md.for_month');
		$this->db->where('md.emp_td',$data['id']);
		$this->db->where('md.is_deleted',0);
		$this->db->where('md.for_month',$data['month']);
		$this->db->where('md.for_year',$data['year']);
		
		
		$query = $this->db->get();
		// print_r($this->db->last_query());die();
		// echo "<pre>";print_r($query->row_array());die();
		// $count = $query->num_rows();
		// echo $count;
		if ($query) {
			// echo "<pre>";print_r($query->row_array());die();
			return $query->row_array();
		}
		return false;
		
	}

	public function getDataOfYearWise($year){
		// echo $year;die();
		$nxtYear = $year + 1;
		// echo $lastYear;die();
		// echo $year;die();
		// $lastMonth = 3;
		$this->db->select('*');
		$this->db->from('master_dcps');
		// $this->db->join('month as m','m.id = md.for_month');
		// $this->db->where('md.emp_td',$id);
		$this->db->where('((for_year = '.$year.' AND for_month >=4) OR (for_year = '.$nxtYear.' AND for_month <=3))');
		$this->db->where('is_deleted',0);
		$this->db->order_by('for_year','asc');
		$this->db->order_by('for_month','asc');
		// $this->db->where('md.for_year',$year);
		// $this->db->where('md.for_month',$lastMonth);
		// $this->db->order_by('m.id','asc');
		$query = $this->db->get();
		// print_r($this->db->last_query());die();
		if ($query) {
			return $query->result();
		}
		return 0;	
		
	}

	public function getDeductionRecordForYear_14082025($year="", $empId="", $month=""){
		//echo $year;die();
		$nxtYear = $year + 1;
		// echo $lastYear;die();
		// echo $year;die();
		// $lastMonth = 3;
		$this->db->select('master_dcps.*, dpt_emp_master.joining_date');
		$this->db->from('master_dcps');
		$this->db->join('dpt_emp_master', 'dpt_emp_master.emp_id = master_dcps.emp_td', 'left');
		// $this->db->join('month as m','m.id = md.for_month');
		// $this->db->where('md.emp_td',$id);
		$this->db->where('((for_year = '.$year.' AND for_month >=4) OR (for_year = '.$nxtYear.' AND for_month <=3))');
		if($month){
		    $this->db->where('for_month = '.$month);
		}
		$this->db->where('is_deleted',0);
		if(isset($empId) && $empId !=""){
		    $this->db->where('emp_td',$empId);
		}
		$this->db->order_by('for_year','asc');
		$this->db->order_by('for_month','asc');
		// $this->db->where('md.for_year',$year);
		// $this->db->where('md.for_month',$lastMonth);
		// $this->db->order_by('m.id','asc');
		$query = $this->db->get();
		// print_r($this->db->last_query());die();
		if ($query) {
			return $query->result_array();
		}
		return 0;	
		
	}
	
	public function getDeductionRecordForYear($year = "", $empId = "", $month = "")
    {
        //echo $month; exit;
        if (empty($year)) {
            return 0; 
        }
    
        $nxtYear = $year + 1;
    
        $this->db->select('master_dcps.*, dpt_emp_master.joining_date');
        $this->db->from('master_dcps');
        $this->db->join('dpt_emp_master', 'dpt_emp_master.emp_id = master_dcps.emp_td', 'left');
    
        
        if (!empty($month)) {
            if ($month >= 4) {
                $this->db->where("(for_year = " . $this->db->escape_str($year) . " AND for_month = ".$month.")");
            } else {
                $this->db->where("(for_year = " . $this->db->escape_str($nxtYear) . " AND for_month = ".$month.")");
            }
        } else {
            $this->db->where("((for_year = " . $this->db->escape_str($year) . " AND for_month >= 4) 
                              OR (for_year = " . $this->db->escape_str($nxtYear) . " AND for_month <= 3))");
        }

    
        $this->db->where('is_deleted', 0);
        $this->db->where('emp_td > 0');
    
        if (!empty($empId)) {
            $this->db->where('emp_td', (int)$empId);
        }
    
        /*$this->db->order_by('for_year', 'asc');
        $this->db->order_by('for_month', 'asc');*/
        //$this->db->order_by('recovered_DCPS_with_voucher_no ASC, recovered_DCPS_with_voucher_date ASC, emp_td ASC');
        
        $this->db->order_by('emp_td asc, recovered_DCPS_with_voucher_no ASC, recovered_DCPS_with_voucher_date ASC, emp_td ASC');

    
        $query = $this->db->get();
    
        //echo $this->db->last_query(); exit;
    
        if ($query && $query->num_rows() > 0) {
            return $query->result_array();
        }
        return 0;
    }


	public function getPdfDataWithYear($year){
		// echo $year;die();
		$nxtYear = $year + 1;
		// echo $lastYear;die();
		// echo $year;die();
		// $lastMonth = 3;
		$this->db->select('*');
		$this->db->from('master_dcps');
		// $this->db->join('month as m','m.id = md.for_month');
		// $this->db->where('md.emp_td',$id);
		$this->db->where('((for_year = '.$year.' AND for_month >=4) OR (for_year = '.$nxtYear.' AND for_month <=3))');
		$this->db->where('is_deleted',0);
		//$this->db->order_by('for_year','asc');
		$this->db->order_by('file_no','asc');
		//$this->db->order_by('for_month','asc');
		// $this->db->where('md.for_year',$year);
		// $this->db->where('md.for_month',$lastMonth);
		// $this->db->order_by('m.id','asc');
		$query = $this->db->get();
		// print_r($this->db->last_query());die();
		if ($query) {
			return $query->result_array();
		}
		return 0;	
		
	}
    public function hasMonthlyRecord($emp_td, $for_month, $year)
    {
        $this->db->select('id');
        $this->db->from('master_dcps');
        $this->db->where([
            'emp_td'     => $emp_td,
            'for_month'  => $for_month,
            'for_year'   => $year,
            'is_deleted' => 0
        ]);
        return ($this->db->count_all_results() > 0);
    }
	
	public function getAllEmployees()
    {
        $query = $this->db
            ->select('emp_td, emp_name')
            ->from('master_dcps')
            ->where('is_deleted', 0)
            ->group_by(['emp_td', 'emp_name'])
            ->order_by('emp_td', 'ASC')
            ->get();
    
        if ($query === false) {
			log_message('error', 'getAllEmployees query failed: '.print_r($this->db->error(), true));
            return [];
        }
        return $query->result_array();
    }

    public function getEmployeesMissingForMonthYear($month, $for_year){
		if(!$month || !$for_year) return [];
		// determine last day of month for joining date check
		$month_padded = str_pad($month,2,'0',STR_PAD_LEFT);
		$lastDay = date('Y-m-t', strtotime($for_year.'-'.$month_padded.'-01'));

		$this->db->select('em.emp_id, em.emp_name, em.joining_date');
		$this->db->from('dpt_emp_master as em');
		// left join to find employees WITHOUT an entry for this month/year
		$this->db->join('master_dcps as md', "md.emp_td = em.emp_id AND md.for_month = {$month} AND md.for_year = {$for_year} AND md.is_deleted = 0", 'left');
		$this->db->where('em.emp_id >', 0);
		// only consider employees who joined on or before this month end (or joining_date NULL)
		$this->db->where('(em.joining_date IS NULL OR em.joining_date <= "'.$lastDay.'")');
		$this->db->where('md.emp_td IS NULL');
		$this->db->order_by('em.emp_id','ASC');
		$query = $this->db->get();
		if($query){
			return $query->result_array();
		}
		return [];
	}

}
?>