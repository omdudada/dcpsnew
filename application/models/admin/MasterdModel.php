<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class MasterdModel extends CI_Model
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

	

	

	public function getAllEmployeeDetails($id){
	    $this->db->select('*');
		$this->db->from('master_dcps');
		$this->db->where('id',$id);
		$query = $this->db->get();
		if ($query) {
			return $query->row_array();
		}
		return false;
	}

	public function getDeatailsOfEmployee($id){
	    $this->db->select('*');
		$this->db->from('master_dcps');
		$this->db->where('id',$id);
		$query = $this->db->get();
		if ($query) {
			return $query->row_array();
		}
		return false;
	}

	public function getEmpMasterData(){
	    $this->db->select('*');
		$this->db->from('emp_master');
		$query = $this->db->get();
		if ($query) {
			return $query->result_array();
		}
		return false;
	}



	public function addEmpData($postdata){
		if($postdata){
			$propCreatedBy = $this->session->userdata('id');
			// echo $propCreatedBy;die();
			// $date = $postdata['wef_date'];
			// $dtes = explode("/",$date);
			
			// $epocDate = mktime(0,0,0,$dtes[1],$dtes[0],$dtes[2]);
			$insertArray = array(
				'emp_name' => $postdata['emp_name'],
				'emp_id' => $postdata['emp_id'],
				'joining_date' => $postdata['wef_date'],
				'pay_center' => $postdata['pay_center'],
				'fixed_pay' => $postdata['fixed_pay'],
				'grade_pay' => $postdata['grade_pay'],
				'basic' => $postdata['basic'],
				'da' => $postdata['da'],
				'created_by' => $propCreatedBy,
				'created_date' => time()
			);
			// echo "<pre>";print_r($insertArray);die();
			
			$this->db->insert('emp_master', $insertArray);
			$res = $this->db->insert_id();
			if($res){
				return 1;
			}
			else {
				return 0;
			}
		}
	}
	public function getEmployeeDataForEdit($id){
	    $this->db->select('*');
		$this->db->from('emp_master');
		$this->db->where('id',$id);
		$query = $this->db->get();
		if ($query) {
			return $query->row_array();
		}
		return false;
	}
	public function updateEmpData($postdata){
		if($postdata){
			$updateArray = array(
				'emp_name' => $postdata['emp_name'],
				'emp_id' => $postdata['emp_id'],
				'joining_date' => $postdata['wef_date'],
				'pay_center' => $postdata['pay_center'],
				'fixed_pay' => $postdata['fixed_pay'],
				'grade_pay' => $postdata['grade_pay'],
				'basic' => $postdata['basic'],
				'da' => $postdata['da'],
				'last_modified' => time()
			);
			$this->db->where('id', $postdata['id']);
			$this->db->update('emp_master', $updateArray);
			if($this->db->affected_rows() > 0){
				// echo "string Ravi 1";die();
				return 1;
			}
			else {
				// echo "string Ravi 0";die();
				return 0;
			}	
		}
	}

	public function deleteEmpData($id){
		if($id){
            // Using soft delete if column exists, otherwise hard delete
            // For now, let's try soft delete by setting is_deleted=1
            // Check if column exists first or just try update
            $this->db->where('id', $id);
            $this->db->update('emp_master', array('is_deleted' => 1));
            if($this->db->affected_rows() > 0){
                return 1;
            }
            // If update failed (maybe no is_deleted column), try hard delete
            $this->db->where('id', $id);
            $this->db->delete('emp_master');
            return ($this->db->affected_rows() > 0) ? 1 : 0;
		}
        return 0;
	}

	public function getDeductionRecord($id,$year){
		// echo "<pre>";print($id);
		// echo "<pre>";print($year);die();
	    $this->db->select('md.id,md.emp_td,md.joining_date,md.emp_name,md.basic,md.da,md.grade_pay,md.for_year,md.for_month,m.month');
		$this->db->from('master_dcps as md');
		$this->db->join('month as m','m.id = md.for_month');
		$this->db->where('md.emp_td',$id);
		$this->db->where('md.for_year',$year);
		$this->db->order_by('m.id','asc');
		// $this->db->limit(10);
		$query = $this->db->get();
		if ($query) {
			return $query->result_array();
		}
		return false;
	}

	public function getMonthsRecord(){
	    $this->db->select('md.id,md.for_month');
		$this->db->from('master_dcps as md');
		$this->db->group_by('md.for_year');
		$query = $this->db->get();
		if ($query) {
			return $query->result_array();
		}
		return false;
	}

	public function getYearsOfEmp($postdata){
		if($postdata['id']){
			return $this->db->select('md.id,md.emp_td, md.emp_name, m.id,md.for_month, md.for_year,m.month')->from('master_dcps as md')->join('month as m','m.id = md.for_month')->where('emp_td',$postdata['id'])->where('for_year',$postdata['year'])->order_by('m.id','asc')->get()->result();
		}
		return 0;
	}
	public function getAllEmployeeDetailsForMonths($id){
	    $this->db->select('*');
		$this->db->from('master_dcps');
		$this->db->where('id',$id);
		$query = $this->db->get();
		if ($query) {
			return $query->row_array();
		}
		return false;
	}

	public function getGrManagementData(){
	    $this->db->select('*');
		$this->db->from('gr_management');
		$this->db->order_by('id','desc');
		$query = $this->db->get();
		if ($query) {
			return $query->result_array();
		}
		return false;
	}

	public function addGRManData($postdata){
		if($postdata){
			// $propCreatedBy = $this->session->userdata('id');
			// echo $propCreatedBy;die();
			$date1 = $postdata['gr_date'];
			$dtes1 = explode(".",$date1);
			$gr_date = mktime(0,0,0,$dtes1[1],$dtes1[0],$dtes1[2]);

			$date2 = $postdata['gr_from_date'];
			$dtes2 = explode(".",$date2);
			$gr_from_date = mktime(0,0,0,$dtes2[1],$dtes2[0],$dtes2[2]);

			$date3 = $postdata['gr_to_date'];
			$dtes3 = explode(".",$date3);
			$gr_to_date = mktime(0,0,0,$dtes3[1],$dtes3[0],$dtes3[2]);
			

			$insertArray = array(
				'gr_no' => $postdata['gr_no'],
				'gr_date' => $gr_date,
				'gr_from_date' => $gr_from_date,
				'gr_to_date' => $gr_to_date,
				'gr_month' => $postdata['gr_month'],
				'gr_year' => $postdata['gr_year'],
				'gr_percentage' => $postdata['gr_percentage'],
				// 'dcps_per_in_gr' => $postdata['dcps_per_in_gr'],
				'gr_by' => $postdata['gr_by']
			);
			// echo "<pre>";print_r($insertArray);die();
			
			$this->db->insert('gr_management', $insertArray);
			$res = $this->db->insert_id();
			if($res){
				return 1;
			}
			else {
				return 0;
			}
		}
	}

	public function getAllGrManagementData($id){
	    $this->db->select('*');
		$this->db->from('gr_management');
		$this->db->where('id',$id);
		$query = $this->db->get();
		if ($query) {
			return $query->row_array();
		}
		return false;
	}

	public function updateGrManagementData($postdata){
		if($postdata){

			$date1 = $postdata['gr_date'];
			$dtes1 = explode(".",$date1);
			$gr_date = mktime(0,0,0,$dtes1[1],$dtes1[0],$dtes1[2]);

			$date2 = $postdata['gr_from_date'];
			$dtes2 = explode(".",$date2);
			$gr_from_date = mktime(0,0,0,$dtes2[1],$dtes2[0],$dtes2[2]);

			$date3 = $postdata['gr_to_date'];
			$dtes3 = explode(".",$date3);
			$gr_to_date = mktime(0,0,0,$dtes3[1],$dtes3[0],$dtes3[2]);
			
			$updateArray = array(
				'gr_no' => $postdata['gr_no'],
				'gr_date' => $gr_date,
				'gr_from_date' => $gr_from_date,
				'gr_to_date' => $gr_to_date,
				'gr_month' => $postdata['gr_month'],
				'gr_year' => $postdata['gr_year'],
				'gr_percentage' => $postdata['gr_percentage'],
				// 'dcps_per_in_gr' => $postdata['dcps_per_in_gr'],
				'gr_by' => $postdata['gr_by']
			);
			$this->db->where('id', $postdata['id']);
			$this->db->update('gr_management', $updateArray);
			if($this->db->affected_rows() > 0){
				// echo "string Ravi 1";die();
				return 1;
			}
			return 0;
			
		}
	}
	

	

	public function getData($id){
		if($id){
			// echo "ID = ".$id;exit();

			$this->db->select('md.id,md.emp_td,md.emp_name,md.opening_balance,md.emp_DCPS_contribution,md.emp_DCPS_supplimentory_contribution,md.NMC_DCPS_contribution,md.NMC_supplimentory_DCPS_contribution,md.for_month,md.for_year');
			$this->db->from('master_dcps as md');
			$this->db->where('md.emp_td',$id);
			$this->db->join('month as m','m.id = md.for_month');
			$this->db->join('for_year as y','y.id = md.for_year');
			// $this->db->where('md.emp_td',$id);
			$this->db->order_by('y.id','asc');
			$this->db->order_by('m.id','asc');

			$query = $this->db->get();
			// print_r($this->db->last_query());die();
			if ($query) {
				return $query->result_array();
			}
			return false;
		}

	}
	public function getDetailsForOpeningBal($id){
		if($id){
			// echo "ID = ".$id;exit();

			$this->db->select('md.id,md.emp_td,md.emp_name,md.opening_balance,md.emp_DCPS_contribution,md.emp_DCPS_supplimentory_contribution,md.NMC_DCPS_contribution,md.NMC_supplimentory_DCPS_contribution,md.for_month,md.for_year,md.recovered_DCPS_with_voucher_date,md.DCPS_loan_taken_by_an_employee');
			$this->db->from('master_dcps as md');
			$this->db->join('month as m','m.id = md.for_month');
			$this->db->join('for_year as y','y.id = md.for_year');
			$this->db->where('md.id',$id);
			// $this->db->where('md.emp_td',$id);
			$this->db->order_by('y.id','asc');
			$this->db->order_by('m.id','asc');

			$query = $this->db->get();
			// print_r($this->db->last_query());die();
			if ($query) {
				return $query->row_array();
			}
			return false;
		}

	}
	public function updateOpBal($update,$inc=0){
		if($update){
				if ($update['month'] == 12) {
					// echo "12";die();
					$update['month'] = 1;
					$update['year'] = $update['year']+1;

				}elseif($inc){
					// echo "1";die();
					$update['month'] = $update['month']+1;
				}else{
					// echo "1";die();
					$update['month'] = $update['month']+1;
				}
				
				// $updateRow['opening_balance'] = $update['totalOpBal'];
				$updateRow['opening_balance'] = $update['final'];
				

				$this->db->where('emp_td', $update['emp_td']);
				$this->db->where('for_month', $update['month']);
				$this->db->where('for_year', $update['year']);
				
				$this->db->update('master_dcps', $updateRow);
				//print_r($this->db->last_query());die();
				
			}
			// if ($inc == 1 ) {
				
			// print_r($this->db->last_query());die();
			// }
			if($this->db->affected_rows() > 0){
				// echo "string";die();
				return 1;
			}else{

				$this->updateOpBal($update,1);
				return 1;
			}
			// echo "hi";die();
			return 0;
	}

	public function recoverVoucherDate($date){
		// echo $date;die();
		$dtes3 = explode(".",$date);
		$gr_to_date = mktime(0,0,0,$dtes3[1],$dtes3[0],$dtes3[2]);
		// echo $gr_to_date;die();
		$this->db->select('gr.id,gr.gr_percentage,gr.gr_by,gr.gr_date');
		$this->db->from('gr_management as gr');
		$this->db->where('gr.gr_from_date <=',$gr_to_date);
		$this->db->where('gr.gr_to_date >=',$gr_to_date);
		$query = $this->db->get();
		// print_r($this->db->last_query());die();
		if ($query) {
			return $query->row_array();
		}
		return false;
		

	}

	public function updateDeductionRecord($postData,$id){
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
			
			$updateArray['last_modified'] = $propCreatedBy;
			$updateArray['last_modified_date'] = time();
			
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
}

?>