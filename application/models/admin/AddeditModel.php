<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class AddeditModel extends CI_Model
{
	public function __construct(){
		parent::__construct();
	}
	// get data for month dropdown
	public function getMonthData(){
	    $this->db->select('*');
		$this->db->from('month');
		$query = $this->db->get();
		if ($query) {
			return $query->result_array();
		}
		return false;
	}

	// get data for year dropdown
	public function getYearData(){
	    $this->db->select('*');
		$this->db->from('for_year');
		$query = $this->db->get();
		if ($query) {
			return $query->result_array();
		}
		return false;
	}

	public function addDCPSMasterData_10082025($postData){
		$rec_month = implode(",",$_POST['recovered_month']);
		// echo $hb;die();
		if($postData){

			$propCreatedBy = $this->session->userdata('id');
			
			$date1 = $postData['to_be_recovered_for_voucher_date'];
			$dtes1 = explode(".",$date1);
			$to_be_recovered_for_voucher_date = mktime(0,0,0,$dtes1[1],$dtes1[0],$dtes1[2]);
			
			$insertArray = array(
			'emp_td' => $postData['emp_td'],
			'emp_name' => $postData['emp_name'],
			'joining_date' => $postData['wef_date'],
			'pay_center' => $postData['pay_center'],
			'basic' => $postData['basic'],
			'da' => $postData['da'],
			'grade_pay' => $postData['grade_pay'],
			'Ideal_contribution_of_employee_for_DCPS' => $postData['Ideal_contribution_of_employee_for_DCPS'],
			'Ideal_contribution_of_NMC_for_DCPS' => $postData['Ideal_contribution_of_NMC_for_DCPS'],
			'opening_balance' => $postData['opening_balance'],
			
			'bunch_no' => $postData['bunch_no'],
			'file_no' => $postData['file_no'],
			
			'recovered_DCPS_with_voucher_no' => $postData['recovered_DCPS_with_voucher_no'],
			'for_month' => $postData['for_month'],
			'for_year' => $postData['year'],
			'recovered_DCPS_with_voucher_date' => $postData['recovered_DCPS_with_voucher_date'],
			
			'emp_DCPS_contribution' => $postData['emp_DCPS_contribution'],
			'emp_DCPS_supplimentory_contribution' => $postData['emp_DCPS_supplimentory_contribution'],
			'NMC_DCPS_contribution' => $postData['NMC_DCPS_contribution'],
			'NMC_supplimentory_DCPS_contribution' => $postData['NMC_supplimentory_DCPS_contribution'],
			'DCPS_loan_taken_by_an_employee' => $postData['DCPS_loan_taken_by_an_employee'],
			'loan_installment_paid_through_salary' => $postData['loan_installment_paid_through_salary'],
			'loan_installment_paid_in_cash' => $postData['loan_installment_paid_in_cash'],
			'supplimentory_loan_installment_paid' => $postData['supplimentory_loan_installment_paid'],
			'total_amount_of_loan_installments_paid' => $postData['total_amount_of_loan_installments_paid'],
			'amount_to_be_recovered_from_emp' => $postData['amount_to_be_recovered_from_emp'],
			'to_be_recovered_for_voucher_no' => $postData['to_be_recovered_for_voucher_no'],
			'to_be_recovered_for_voucher_date' => $to_be_recovered_for_voucher_date,
			'gr_percentage' => $postData['gr_percentage'],
			'recovered_with_voucher_no' => $postData['recovered_with_voucher_no'],
			'recovered_date' => $postData['recovered_date'],
			'recovered_month' => $rec_month,
			'recovered_year' => $postData['recovered_year'],
			'remark' => $postData['remark'],
			
			
			
			'created_by' => $propCreatedBy,
			'created_date' => time()
			);
			$this->db->insert('master_dcps', $insertArray);
			
			$res = $this->db->insert_id();
			if($res){
				return 1;
			}
			else {
				return 0;
			}
		}
	}
	
	public function addDCPSMasterData($postData){
		$rec_month = implode(",",$_POST['recovered_month']);
		// echo $hb;die();
		if($postData){

			$propCreatedBy = $this->session->userdata('id');
			
			$date1 = $postData['to_be_recovered_for_voucher_date'];
			$dtes1 = explode(".",$date1);
			$to_be_recovered_for_voucher_date = mktime(0,0,0,$dtes1[1],$dtes1[0],$dtes1[2]);
			
			$insertArray = array(
            'emp_td' => isset($postData['emp_td']) ? $postData['emp_td'] : null,
            'emp_name' => isset($postData['emp_name']) ? $postData['emp_name'] : null,
            'joining_date' => isset($postData['wef_date']) ? $postData['wef_date'] : null,
            'pay_center' => isset($postData['pay_center']) ? $postData['pay_center'] : null,
            'basic' => isset($postData['basic']) ? $postData['basic'] : null,
            'da' => isset($postData['da']) ? $postData['da'] : null,
            'grade_pay' => isset($postData['grade_pay']) ? $postData['grade_pay'] : null,
            'total_salary'=> (isset($postData['grade_pay']) ? $postData['grade_pay'] : 0)+(isset($postData['basic']) ? $postData['basic'] : 0)+(isset($postData['da']) ? $postData['da'] : 0),
            'Ideal_contribution_of_employee_for_DCPS' => isset($postData['Ideal_contribution_of_employee_for_DCPS']) ? $postData['Ideal_contribution_of_employee_for_DCPS'] : null,
            'Ideal_contribution_of_NMC_for_DCPS' => isset($postData['Ideal_contribution_of_NMC_for_DCPS']) ? $postData['Ideal_contribution_of_NMC_for_DCPS'] : null,
            'opening_balance' => isset($postData['opening_balance']) ? $postData['opening_balance'] : null,
        
            'bunch_no' => isset($postData['bunch_no']) ? $postData['bunch_no'] : null,
            'file_no' => isset($postData['file_no']) ? $postData['file_no'] : null,
        
            'recovered_DCPS_with_voucher_no' => isset($postData['recovered_DCPS_with_voucher_no']) ? $postData['recovered_DCPS_with_voucher_no'] : null,
            'for_month' => isset($postData['for_month']) ? $postData['for_month'] : null,
            'for_year' => isset($postData['year']) ? $postData['year'] : null,
            'recovered_DCPS_with_voucher_date' => isset($postData['recovered_DCPS_with_voucher_date']) ? $postData['recovered_DCPS_with_voucher_date'] : null,
        
            'emp_DCPS_contribution' => isset($postData['emp_DCPS_contribution']) ? $postData['emp_DCPS_contribution'] : null,
            'emp_DCPS_supplimentory_contribution' => isset($postData['emp_DCPS_supplimentory_contribution']) ? $postData['emp_DCPS_supplimentory_contribution'] : null,
            'NMC_DCPS_contribution' => isset($postData['NMC_DCPS_contribution']) ? $postData['NMC_DCPS_contribution'] : null,
            'NMC_supplimentory_DCPS_contribution' => isset($postData['NMC_supplimentory_DCPS_contribution']) ? $postData['NMC_supplimentory_DCPS_contribution'] : null,
            'DCPS_loan_taken_by_an_employee' => isset($postData['DCPS_loan_taken_by_an_employee']) ? $postData['DCPS_loan_taken_by_an_employee'] : null,
            'loan_installment_paid_through_salary' => isset($postData['loan_installment_paid_through_salary']) ? $postData['loan_installment_paid_through_salary'] : null,
            'loan_installment_paid_in_cash' => isset($postData['loan_installment_paid_in_cash']) ? $postData['loan_installment_paid_in_cash'] : null,
            'supplimentory_loan_installment_paid' => isset($postData['supplimentory_loan_installment_paid']) ? $postData['supplimentory_loan_installment_paid'] : null,
            'total_amount_of_loan_installments_paid' => isset($postData['total_amount_of_loan_installments_paid']) ? $postData['total_amount_of_loan_installments_paid'] : null,
            'amount_to_be_recovered_from_emp' => isset($postData['amount_to_be_recovered_from_emp']) ? $postData['amount_to_be_recovered_from_emp'] : null,
            'to_be_recovered_for_voucher_no' => isset($postData['to_be_recovered_for_voucher_no']) ? $postData['to_be_recovered_for_voucher_no'] : null,
            'to_be_recovered_for_voucher_date' => isset($to_be_recovered_for_voucher_date) ? $to_be_recovered_for_voucher_date : null,
            'gr_percentage' => isset($postData['gr_percentage']) ? $postData['gr_percentage'] : null,
            'recovered_with_voucher_no' => isset($postData['recovered_with_voucher_no']) ? $postData['recovered_with_voucher_no'] : null,
            'recovered_date' => isset($postData['recovered_date']) ? $postData['recovered_date'] : null,
            'recovered_month' => isset($rec_month) ? $rec_month : null,
            'recovered_year' => isset($postData['recovered_year']) ? $postData['recovered_year'] : null,
            'remark' => isset($postData['remark']) ? $postData['remark'] : null,
            'salary_type' => isset($postData['salary_type']) ? $postData['salary_type'] : '',
        	'salary_start_date' => isset($postData['salary_start_date']) ? $postData['salary_start_date'] : '',
        	'salary_end_date'=> isset($postData['salary_end_date']) ? $postData['salary_end_date'] : '',
        	'reason'=> isset($postData['reason']) ? $postData['reason'] : '',
            'created_by' => isset($propCreatedBy) ? $propCreatedBy : null,
            'created_date' => time()
        );
        //echo "<pre>154=>Inserted Array=>"; print_r($insertArray); exit;
        
        if (!empty($insertArray['for_month']) && !empty($insertArray['for_year'])) {
            
            $month = (int)$postData['for_month'];
            list($startYear, $endYear) = explode('-', $insertArray['for_year']);
        
            // जर महिना >= 4 असेल तर तो current financial year मध्ये येईल
            if ($month >= 4) {
                $finalYear = $startYear;
            } else {
                // महिना 1,2,3 (Jan, Feb, Mar) असेल तर previous financial year
                $finalYear = $endYear;
            }
            //echo "here"; exit;
        
            $insertArray['for_month'] = $month;
            $insertArray['for_year']  = $finalYear;
        }

        //echo "<pre>Inserted Array=>"; print_r($insertArray); exit;

			$this->db->insert('master_dcps', $insertArray);
			
			$res = $this->db->insert_id();
			if($res){
				return 1;
			}
			else {
				return 0;
			}
		}
	}
	
	

	public function getPerChange($voucher_date){
		if($voucher_date){
			// echo $voucher_date;die();
			$this->db->select('gr_from_date,gr_to_date,gr_percentage'); 
			$this->db->from('gr_management');
			$this->db->where('gr_from_date <=', $voucher_date);
			$this->db->where('gr_to_date >=', $voucher_date);
			$query = $this->db->get();
			// print_r($this->db->last_query()); die();
			if ($query) {
				return $query->row_array();
			}
			return 0;
		}
		return 0;
	    
	}
}

?>