<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masterdata extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('admin/MasterdModel','mModel');
		$this->load->library('session');
		
		//echo "<pre>"; print_r($this->session->all_userdata()); exit;
		//echo "<pre>"; print_r($_SESSION); exit;
        if(!$this->session->userdata('validated') && $this->router->class !="login"){ 
			//$CI->session->set_userdata('rediect_url', array("url"=>base_url().$CI->uri->uri_string()));
			//redirect('admin/login');
		}
	}

	public function index()
	{
		
		$data['month'] = $this->mModel->getMonthData();
		$data['year'] = $this->mModel->getYearData();
		$this->load->view('admin/common/header');
		$this->load->view('admin/masterdata/listing',$data);
		
	}
	

	private function _checkAdminAccess(){
		$username = $this->session->userdata('username');
		$level = $this->session->userdata('level');
		$role = strtolower((string)$this->session->userdata('user_role'));

		$isAdmin = ($username === 'admin' || $level == 1 || in_array($role, ['1', 'admin']));
		if (!$isAdmin) {
			$this->session->set_flashdata('fail', 'Access Denied. Only Admin users can access this page.');
			redirect('admin/dashboard');
			exit;
		}
	}

	public function empMaster(){
		$this->_checkAdminAccess();
		$data['results'] = $this->mModel->getEmpMasterData();
		$this->load->view('admin/common/header');
		$this->load->view('admin/employeemaster/listing',$data);
		
	}

	public function exportEmpCsv(){
		$this->_checkAdminAccess();
		$results = $this->mModel->getEmpMasterData();
		
		$filename = 'Employee_Master_' . date('Ymd_His') . '.csv';
		
		$this->output
			->set_content_type('text/csv')
			->set_header('Content-Disposition: attachment; filename="' . $filename . '"')
			->set_header('Pragma: no-cache')
			->set_header('Expires: 0');

		$out = fopen('php://output', 'w');
		
		$headers = ['Sr. No.', 'Employee Name', 'Employee ID', 'Joining Date', 'Pay Center', 'Fixed Pay', 'Grade Pay', 'Basic', 'DA'];
		fputcsv($out, $headers);
		
		if (!empty($results)) {
			$i = 1;
			foreach ($results as $r) {
				$line = [
					$i++,
					isset($r['emp_name']) ? $r['emp_name'] : '',
					isset($r['emp_id']) ? $r['emp_id'] : '',
					isset($r['joining_date']) ? $r['joining_date'] : '',
					isset($r['pay_center']) ? $r['pay_center'] : '',
					isset($r['fixed_pay']) ? $r['fixed_pay'] : '',
					isset($r['grade_pay']) ? $r['grade_pay'] : '',
					isset($r['basic']) ? $r['basic'] : '',
					isset($r['da']) ? $r['da'] : ''
				];
				fputcsv($out, $line);
			}
		} else {
			fputcsv($out, ['No employee records found']);
		}
		
		fclose($out);
	}
	public function addEmp(){
		$this->_checkAdminAccess();
		$postdata = $this->input->post();
		
		if ($postdata) {
			// echo "<pre>";print_r($postdata);die();
			$res = $this->mModel->addEmpData($postdata);
			// echo $res;die();
			if ($res == 1) {
				$this->session->set_flashdata('success', "Employee Details Added successfully.");
				redirect('admin/emp-master');	
			}
		}else{
			$this->load->view('admin/common/header');
			$this->load->view('admin/employeemaster/add_employee_form');
		}
	}
	public function editEmp($id){
		$this->_checkAdminAccess();
		$postdata = $this->input->post();
		
		if ($postdata) {
			// echo "<pre>";print_r($postdata);die();
			$res = $this->mModel->updateEmpData($postdata);
			// echo $res;die();
			if ($res == 1) {
				$this->session->set_flashdata('success', "Employee Details Updated successfully.");
				redirect('admin/emp-master');	
			}
		}else{
			
			$data['results'] = $this->mModel->getEmployeeDataForEdit($id);
			// echo "<pre>";print_r($res);die();
			$this->load->view('admin/common/header');
			$this->load->view('admin/employeemaster/edit_employee_form',$data);
		}
	}

	
	
	public function getEmpMonthsDetails(){
		// echo "string";die();
		$postdata = $this->input->post();
		// $data['id'] = $this->input->post('id');
		// $data['month'] = $this->input->post('month');
		// $data['year'] = $this->input->post('year');
		// echo $data['month'];die();
		if($postdata){
			$customerInfos['data'] = $this->mModel->getYearsOfEmp($postdata);
			// echo "<pre>";print_r($customerInfos['data']);die();
		}
		if(count($customerInfos['data']) > 0){
				// echo "<pre>";print_r($customerInfos);die();
			$result['customer_detail'] = $this->load->view('admin/deductionrecord/view_details_of_emp', $customerInfos, true); 
			
		}
		
		echo json_encode($result);
	}

	public function viewMonthlyDataEmp($id)
	{
		
		$data['cdata'] = $this->mModel->getAllEmployeeDetailsForMonths($id);
		// echo "<pre>"; print_r($data['cdata']); exit;
		// $data['year'] = $this->mModel->getYearData();
		$this->load->view('admin/common/header');
		$this->load->view('admin/deductionrecord/display_months_record_using_year',$data);
		
	}

	public function grManagement(){
		$this->_checkAdminAccess();
		$grData['grResults'] = $this->mModel->getGrManagementData();
		$this->load->view('admin/common/header');
		$this->load->view('admin/grmanagement/listing',$grData);
		
	}

	public function addGrManagement(){
		$this->_checkAdminAccess();
		$postdata = $this->input->post();
		
		if ($postdata) {
			// echo "<pre>";print_r($_FILES);die();
			$res = $this->mModel->addGRManData($postdata);
			// echo $res;die();
			if ($res == 1) {
				$this->session->set_flashdata('success', "GR Management Details Added successfully.");
				redirect('admin/gr-management');	
			}
		}else{
			$data['month'] = $this->mModel->getMonthData();
			$data['year'] = $this->mModel->getYearData();
			$this->load->view('admin/common/header');
			$this->load->view('admin/grmanagement/add_gr_management_form', $data);
		}
	}

	public function editGrManagementData($id){
		$this->_checkAdminAccess();
		$postdata = $this->input->post();
		
		if ($postdata) {
			// echo "<pre>";print_r($postdata);die();
			$res = $this->mModel->updateGrManagementData($postdata);
			// echo $res;die();
			if ($res == 1) {
				$this->session->set_flashdata('success', "Gr Management Details Updated successfully.");
				redirect('admin/gr-management');	
			}
		}else{
			$data['month'] = $this->mModel->getMonthData();
			$data['year'] = $this->mModel->getYearData();
			$data['results'] = $this->mModel->getAllGrManagementData($id);
			// echo "<pre>";print_r($res);die();
			$this->load->view('admin/common/header');
			$this->load->view('admin/grmanagement/edit_gr_management_form', $data);
		}
	}

	public function calOpeningBal()
	{
		$this->load->view('admin/common/header');
		$this->load->view('admin/openingbal/listing',$data);
		
	}

	

	
        
}
?>
