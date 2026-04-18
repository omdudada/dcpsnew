<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masterdata extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/MasterdModel', 'mModel');
		$this->load->library('session');

		//echo "<pre>"; print_r($this->session->all_userdata()); exit;
		//echo "<pre>"; print_r($_SESSION); exit;
		if (!$this->session->userdata('validated') && $this->router->class != "login") {
			//$CI->session->set_userdata('rediect_url', array("url"=>base_url().$CI->uri->uri_string()));
			//redirect('admin/login');
		}
	}

	public function index()
	{

		$data['month'] = $this->mModel->getMonthData();
		$data['year'] = $this->mModel->getYearData();
		$data['title'] = 'Master Data Listing';
		$this->load->view('admin/common/header', $data);
		$this->load->view('admin/masterdata/listing', $data);
		$this->load->view('admin/common/footer');
	}


	public function empMaster()
	{
		$data['results'] = $this->mModel->getEmpMasterData();
		$data['title'] = 'Employee Master';
		$this->load->view('admin/common/header', $data);
		$this->load->view('admin/employeemaster/listing', $data);
		$this->load->view('admin/common/footer');
	}
	public function addEmp()
	{

		$postdata = $this->input->post();

		if ($postdata) {
			// echo "<pre>";print_r($postdata);die();
			$res = $this->mModel->addEmpData($postdata);
			// echo $res;die();
			if ($res == 1) {
				$this->session->set_flashdata('success', "Employee Details Added successfully.");
				redirect('admin/emp-master');
			}
		} else {
			$data['title'] = 'Add Employee';
			$this->load->view('admin/common/header', $data);
			$this->load->view('admin/employeemaster/add_employee_form');
			$this->load->view('admin/common/footer');
		}
	}
	public function editEmp($id)
	{

		$postdata = $this->input->post();

		if ($postdata) {
			// echo "<pre>";print_r($postdata);die();
			$res = $this->mModel->updateEmpData($postdata);
			// echo $res;die();
			if ($res == 1) {
				$this->session->set_flashdata('success', "Employee Details Updated successfully.");
				redirect('admin/emp-master');
			}
		} else {

			$data['results'] = $this->mModel->getEmployeeDataForEdit($id);
			// echo "<pre>";print_r($res);die();
			$this->load->view('admin/common/header');
			$this->load->view('admin/employeemaster/edit_employee_form', $data);
			$this->load->view('admin/common/footer');
		}
	}

	public function deleteEmp($id)
	{
		$res = $this->mModel->deleteEmpData($id);
		if ($res == 1) {
			$this->session->set_flashdata('success', "Employee Details Deleted successfully.");
		} else {
			$this->session->set_flashdata('error', "Failed to delete employee details.");
		}
		redirect('admin/emp-master');
	}



	public function getEmpMonthsDetails()
	{
		// echo "string";die();
		$postdata = $this->input->post();
		// $data['id'] = $this->input->post('id');
		// $data['month'] = $this->input->post('month');
		// $data['year'] = $this->input->post('year');
		// echo $data['month'];die();
		if ($postdata) {
			$customerInfos['data'] = $this->mModel->getYearsOfEmp($postdata);
			// echo "<pre>";print_r($customerInfos['data']);die();
		}
		if (count($customerInfos['data']) > 0) {
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
		$this->load->view('admin/deductionrecord/display_months_record_using_year', $data);

	}

	public function grManagement()
	{

		$grData['grResults'] = $this->mModel->getGrManagementData();
		$this->load->view('admin/common/header');
		$this->load->view('admin/grmanagement/listing', $grData);

	}

	public function addGrManagement()
	{

		$postdata = $this->input->post();

		if ($postdata) {
			// echo "<pre>";print_r($_FILES);die();
			$res = $this->mModel->addGRManData($postdata);
			// echo $res;die();
			if ($res == 1) {
				$this->session->set_flashdata('success', "GR Management Details Added successfully.");
				redirect('admin/gr-management');
			}
		} else {

			$this->load->view('admin/common/header');
			$this->load->view('admin/grmanagement/add_gr_management_form');
		}
	}

	public function editGrManagementData($id)
	{

		$postdata = $this->input->post();

		if ($postdata) {
			// echo "<pre>";print_r($postdata);die();
			$res = $this->mModel->updateGrManagementData($postdata);
			// echo $res;die();
			if ($res == 1) {
				$this->session->set_flashdata('success', "Gr Management Details Updated successfully.");
				redirect('admin/gr-management');
			}
		} else {

			$data['results'] = $this->mModel->getAllGrManagementData($id);
			// echo "<pre>";print_r($res);die();
			$this->load->view('admin/common/header');
			$this->load->view('admin/grmanagement/edit_gr_management_form', $data);
		}
	}

	public function calOpeningBal()
	{
		$data['title'] = 'Calculate Opening Balance';
		$this->load->view('admin/common/header', $data);
		$this->load->view('admin/openingbal/listing', $data);
		$this->load->view('admin/common/footer');
	}





}
?>