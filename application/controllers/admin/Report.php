<?php 
defined('BASEPATH') OR exit('no direct script access allowed');

class Report extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('admin/ReportModel','rModel');
		$this->load->library('session');
	}

	public function index(){
		
		$data['year'] = $this->rModel->getYearData();
		$this->load->view('admin/common/header');
		$this->load->view('admin/broadsheetreport/listing',$data);
	}

	

	public function masterReocrd()
	{
		
		$data['month'] = $this->rModel->getMonthData();
		$data['year'] = $this->rModel->getYearData();
		$this->load->view('admin/common/header');
		$this->load->view('admin/masterdata/listing',$data);
		
	}

	public function getcustomerdetail(){
		// echo "string";die();
		$data['id'] = $this->input->post('id');
		$data['month'] = $this->input->post('month');
		$data['year'] = $this->input->post('year');
		// echo $data['month'];die();
		if($data['id'] && $data['month'] == '' && $data['year'] == ''){
			$customerInfos['data'] = $this->rModel->getCustomerDetails($data['id']);
			// echo "<pre>";print_r($customerInfos['data']);die();
		}
		if(count($customerInfos['data']) > 1){
				// echo "<pre>";print_r($customerInfos);die();
			$result['customer_detail'] = $this->load->view('admin/masterdata/view_details_of_emp', $customerInfos, true);
			
		}
		else{
			if(!$data['id']){
				$data['id'] = $customerInfos[0]->emp_td;
			}
			$customerDetails['cdata'] = $this->rModel->getcustomerinfo($data);
			// echo "<pre>";print_r($customerDetails);die();	
			$result['customer_detail'] = $this->load->view('admin/masterdata/displaymasterdata', $customerDetails, true); 
		}
		
		// echo "<pre>"; print_r($result); exit;
		echo json_encode($result);
	}

	public function deductionRecord(){
		$data['year'] = $this->rModel->getYearData();
		//echo "<pre>"; print_r($data); exit;
		$this->load->view('admin/common/header');
		$this->load->view('admin/deductionrecord/deduction_listing',$data);
		
	}
	public function monthlyRecord(){
		$data['year'] = $this->rModel->getYearData();
		$this->load->view('admin/common/header');
		$this->load->view('admin/monthlyrecord/monthly_listing',$data);
		
	}
	
	public function editMissingMonthYearRecords()
	{
		$data['records'] = $this->rModel->getMissingMonthYearRecords();
		//echo $this->db->last_query(); exit;
		$this->load->view('admin/common/header');
		$this->load->view('admin/monthlyrecord/missing_month_year_listing', $data);
	}

	public function viewEmployeeData($id)
	{
		
		$data['cdata'] = $this->rModel->getAllEmployeeDetails($id);
		// echo "<pre>"; print_r($data['cdata']); exit;
		// $data['year'] = $this->mModel->getYearData();
		$this->load->view('admin/common/header');
		$this->load->view('admin/masterdata/single_emp_data',$data);
		
	}

	public function editDeductionRecord($id)
	{
		$postData = $this->input->post();
		//echo "<pre>";print_r($postdata);die();
		if ($postData) {
			//echo "<pre>postData=>";print_r($postData);die();
			$res = $this->rModel->updateDeductionRecord($postData,$id);
			// echo $res;die();
			if ($res == 1) {
				$this->session->set_flashdata('success', "Employee Details Updated successfully.");
				//redirect('admin/dcps-deduction-record');	
				$referrer = $this->input->server('HTTP_REFERER');

                /*if ($referrer) {
                    redirect($referrer);
                } else {
                    redirect('admin/dcps-deduction-record');	
                }*/
                redirect('admin/dcps-deduction-record');
				
			}
		}else{
			
			$data['editData'] = $this->rModel->getDeatailsOfEmployee($id);
			$data['month'] = $this->rModel->getMonthData();
			$data['year'] = $this->rModel->getYearData();
			// echo "<pre>"; print_r($data['editData']); exit;
			// $data['year'] = $this->mModel->getYearData();
			$this->load->view('admin/common/header');
			$this->load->view('admin/deductionrecord/edit_deduction_emp_record',$data);
		}
		
	}

	

	public function slipAndLedger()
	{
		
		// $data['month'] = $this->mModel->getMonthData();
		$data['year'] = $this->rModel->getYearData();
		$this->load->view('admin/common/header');
		$this->load->view('admin/slipandledger/listing',$data);
		
	}

	public function generatePDF()
	{
		
		// $data['month'] = $this->rModel->getMonthData();
		$data['year'] = $this->rModel->getYearData();
		$this->load->view('admin/common/header');
		$this->load->view('admin/generatepdf/listing',$data);
		
	}

	public function generatePdfWithYear(){
		// $this->load->model('admin/ReportModel','rModel');
		$data['year'] = $this->input->post('year');
		// echo $data['year'];die();
		// echo $data['month'];die();
		if($data['year']){
			$customerInfos['data'] = $this->rModel->getPdfDataWithYear($data['year']);
			// echo "<pre>";print_r($customerInfos['data']);die();
			$this->load->view('admin/generatepdf/single_emp_data_of_year', $customerInfos);
		}
		// if(count($customerInfos['data']) > 1){
				// echo "<pre>";print_r($customerInfos);die();
			// foreach ($customerInfos['data'] as $cdata) {
				// echo "<pre>";print_r($cdata);die();
				// $result['customer_detail'] = $this->load->view('admin/generatepdf/single_emp_data_of_year', $customerInfos, true);
			// }
			// $html = $this->output->get_output();
			// $this->load->library('pdf');
			// $this->dompdf->loadHtml($html);
			// $this->dompdf->setPaper('A4', 'landscape');
			// $this->dompdf->render();
			// $this->dompdf->stream("welcome.pdf", array("Attachment"=>0));
			// exit;
			
		// }
	}
	
	/**
	 * Show missing month entries for a given team (team -> month mapping)
	 * Teams 1..12 map to months Apr..Mar respectively.
	 */
	public function teamwisetasks_old($team = null){
		$team = (int)$team;
		// mapping team -> month number (1=Jan .. 12=Dec)
		$map = [1=>4,2=>5,3=>6,4=>7,5=>8,6=>9,7=>10,8=>11,9=>12,10=>1,11=>2,12=>3];
		if(!isset($map[$team])){
			show_404();
		}
		$month = $map[$team];
		$monthNames = [1=>'January',2=>'February',3=>'March',4=>'April',5=>'May',6=>'June',7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December'];
		$startYear = 2006;
		$endYear = 2014;
		$missing = [];
		for($y = $startYear; $y <= $endYear; $y++){
			// for months Jan-Mar the for_year is next year in database (see other queries)
			$checkYear = ($month >= 4) ? $y : ($y + 1);
			$records = $this->rModel->getMonthlyRecord($month, $checkYear);
			echo $this->db->last_query(); exit;
			if(!$records || count($records) == 0){
				$missing[] = ($y).'-'.($y+1);
			}
		}
		$data = [];
		$data['team'] = $team;
		$data['month'] = $month;
		$data['month_name'] = isset($monthNames[$month]) ? $monthNames[$month] : '';
		$data['missing_years'] = $missing;
		$this->load->view('admin/common/header');
		$this->load->view('admin/report/team_wise_tasks',$data);
	}
	
	public function teamwisetasks($team = null){
		$team = (int)$team;
		// mapping team -> month number (1=Jan .. 12=Dec)
		$map = [1=>4,2=>5,3=>6,4=>7,5=>8,6=>9,7=>10,8=>11,9=>12,10=>1,11=>2,12=>3];
		if(!isset($map[$team])){
			show_404();
		}
		$month = $map[$team];
		$monthNames = [1=>'January',2=>'February',3=>'March',4=>'April',5=>'May',6=>'June',7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December'];
		$startYear = 2006;
		$endYear = 2014;
		$missing = [];
		//echo $month; exit;
		/*for($y = $startYear; $y <= $endYear; $y++){
			// for months Jan-Mar the for_year is next year in database (see other queries)
			$checkYear = ($month >= 4) ? $y : ($y + 1);
			$employeesMissing = $this->rModel->getEmployeesMissingForMonthYear($month, $checkYear);
			if($employeesMissing && count($employeesMissing) > 0){
				$missing[] = [
					'financial_year' => ($y).'-'.($y+1),
					'for_year' => $checkYear,
					'month_name'=> $monthNames[$month],
					'employees' => $employeesMissing
				];
			}
		}*/
		
		for($y = $startYear; $y <= $endYear; $y++){

			// DB year logic
			$checkYear = ($month >= 4) ? $y : ($y + 1);

			// get all employees who DON'T have entry for this month/year
			$employees = $this->rModel->getEmployeesMissingForMonthYear($month, $checkYear);

			$eligibleEmployees = [];

			// Extra safety filter: only include employees who joined on/before this month/year
			// (Model already does this, but keep here to be robust against data-format issues)
			foreach ($employees as $emp) {
				if (empty($emp['joining_date'])) {
					// if joining_date missing, include (can't prove ineligible)
					$eligibleEmployees[] = $emp;
					continue;
				}

				// joining_date format in db dump: dd.mm.yyyy
				$joinDate = DateTime::createFromFormat('d.m.Y', trim($emp['joining_date']));
				if (!$joinDate) {
					// unknown format -> include to avoid false negatives
					$eligibleEmployees[] = $emp;
					continue;
				}

				$joinYear  = (int)$joinDate->format('Y');
				$joinMonth = (int)$joinDate->format('n');

				if ($joinYear < $checkYear || ($joinYear == $checkYear && $joinMonth <= $month)) {
					$eligibleEmployees[] = $emp;
				}
			}

			if (!empty($eligibleEmployees)) {
				$missing[] = [
					'financial_year' => $y . '-' . ($y + 1),
					'for_year'       => $checkYear,
					'month_name'     => isset($monthNames[$month]) ? $monthNames[$month] : '',
					'employees'      => $eligibleEmployees
				];
			}
		}

		$data = [];
		$data['team'] = $team;
		$data['month'] = $month;
		$data['month_name'] = isset($monthNames[$month]) ? $monthNames[$month] : '';
		$data['missing'] = $missing; // array of fiscal-year => employees
		$this->load->view('admin/common/header');
		$this->load->view('admin/report/team_wise_tasks',$data);
	}

}
 ?>
