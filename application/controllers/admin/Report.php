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
            //echo "<pre>"; print_r($employees); exit;
        
            $eligibleEmployees = [];
            $eligibleEmployees = $employees;
        
            /*foreach ($employees as $emp) {
        
                if (empty($emp['joining_date'])) {
                    continue;
                }
        
                // joining_date format: dd.mm.yyyy
                $joinDate = DateTime::createFromFormat('d.m.Y', $emp['joining_date']);
                if (!$joinDate) {
                    continue;
                }
        
                $joinYear  = (int)$joinDate->format('Y');
                $joinMonth = (int)$joinDate->format('n');
        
                // check eligibility
                if (
                    $joinYear < $checkYear ||
                    ($joinYear == $checkYear && $joinMonth <= $month)
                ) {
                    //$eligibleEmployees[] = $emp;
                }
            }*/
        
            // add only if eligible employees exist
            if (!empty($eligibleEmployees)) {
                $missing[] = [
                    'financial_year' => $y . '-' . ($y + 1),
                    'for_year'       => $checkYear,
                    'month_name'     => $monthNames[$month],
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
	
	// =========================================================================
	// Team Tasks (Data-quality): Missing Record
	// =========================================================================
	public function missingRecord()
	{
		$data = [];
		$data['title'] = 'Team Tasks - Missing Record';

		$team = (int) $this->input->get('team');
		if ($team < 0 || $team > 12) {
			$team = 0; // 0 = All
		}
		$search = trim((string) $this->input->get('q'));
		$page = max(1, (int) $this->input->get('page'));
		$perPage = (int) $this->input->get('per_page');
		if ($perPage <= 0 || $perPage > 500) {
			$perPage = 50;
		}
		$offset = ($page - 1) * $perPage;

		$teamMonth = $this->_teamToMonth($team);

		// Export (CSV)
		$export = (int) $this->input->get('export');
		if ($export === 1) {
			$rows = $this->rModel->fetchMissingRecords($teamMonth, $search, 100000, 0);
			$this->_downloadCsv('missing_records.csv', $rows);
			return;
		}

		$total = $this->rModel->countMissingRecords($teamMonth, $search);
		$records = $this->rModel->fetchMissingRecords($teamMonth, $search, $perPage, $offset);

		$data['team'] = $team;
		$data['teamMonth'] = $teamMonth;
		$data['search'] = $search;
		$data['perPage'] = $perPage;
		$data['page'] = $page;
		$data['total'] = $total;
		$data['records'] = $records;
		$data['missingCountsByTeam'] = $this->rModel->getMissingCountsByTeam($search);

		$data['pagination'] = $this->_buildPaginationLinks(
			base_url('admin/team-tasks/missing-record'),
			$total,
			$perPage,
			$page,
			['team' => $team, 'q' => $search, 'per_page' => $perPage]
		);

		$this->load->view('admin/common/header', $data);
		$this->load->view('admin/teamtasks/missing_record', $data);
		$this->load->view('admin/common/footer');
	}

	// =========================================================================
	// Team Tasks (Data-quality): Duplicate Record
	// =========================================================================
	public function duplicateRecord()
	{
		$data = [];
		$data['title'] = 'Team Tasks - Duplicate Record';

		$team = (int) $this->input->get('team');
		if ($team < 0 || $team > 12) {
			$team = 0; // 0 = All
		}
		$search = trim((string) $this->input->get('q'));
		$page = max(1, (int) $this->input->get('page'));
		$perPage = (int) $this->input->get('per_page');
		if ($perPage <= 0 || $perPage > 500) {
			$perPage = 50;
		}
		$offset = ($page - 1) * $perPage;

		$teamMonth = $this->_teamToMonth($team);

		// Export (CSV)
		$export = (int) $this->input->get('export');
		if ($export === 1) {
			$rows = $this->rModel->fetchDuplicateRecords($teamMonth, $search, 100000, 0);
			$this->_downloadCsv('duplicate_records.csv', $rows);
			return;
		}

		$total = $this->rModel->countDuplicateRecords($teamMonth, $search);
		$records = $this->rModel->fetchDuplicateRecords($teamMonth, $search, $perPage, $offset);

		$data['team'] = $team;
		$data['teamMonth'] = $teamMonth;
		$data['search'] = $search;
		$data['perPage'] = $perPage;
		$data['page'] = $page;
		$data['total'] = $total;
		$data['records'] = $records;
		$data['duplicateCountsByTeam'] = $this->rModel->getDuplicateCountsByTeam($search);

		$data['pagination'] = $this->_buildPaginationLinks(
			base_url('admin/team-tasks/duplicate-record'),
			$total,
			$perPage,
			$page,
			['team' => $team, 'q' => $search, 'per_page' => $perPage]
		);

		$this->load->view('admin/common/header', $data);
		$this->load->view('admin/teamtasks/duplicate_record', $data);
		$this->load->view('admin/common/footer');
	}

	// =========================================================================
	// Helpers
	// =========================================================================
	private function _teamToMonth($team)
	{
		$team = (int) $team;
		if ($team < 1 || $team > 12) {
			return 0; // 0 = All months
		}
		// mapping team -> month (Apr..Mar)
		$map = [1=>4,2=>5,3=>6,4=>7,5=>8,6=>9,7=>10,8=>11,9=>12,10=>1,11=>2,12=>3];
		return isset($map[$team]) ? (int)$map[$team] : 0;
	}

	private function _buildPaginationLinks($baseUrl, $totalRows, $perPage, $currentPage, $query = [])
	{
		$totalRows = (int)$totalRows;
		$perPage = max(1, (int)$perPage);
		$currentPage = max(1, (int)$currentPage);
		$totalPages = (int) ceil($totalRows / $perPage);
		if ($totalPages <= 1) {
			return '';
		}

		$buildUrl = function($page) use ($baseUrl, $query) {
			$q = $query;
			$q['page'] = $page;
			$qs = http_build_query($q);
			return $baseUrl . ($qs ? ('?' . $qs) : '');
		};

		$start = max(1, $currentPage - 3);
		$end = min($totalPages, $currentPage + 3);

		$html = '<div class="pagination">';
		if ($currentPage > 1) {
			$html .= '<a href="' . htmlspecialchars($buildUrl(1)) . '">First</a>';
			$html .= '<a href="' . htmlspecialchars($buildUrl($currentPage - 1)) . '">Prev</a>';
		}
		for ($p = $start; $p <= $end; $p++) {
			$class = ($p === $currentPage) ? ' class="active"' : '';
			$html .= '<a' . $class . ' href="' . htmlspecialchars($buildUrl($p)) . '">' . $p . '</a>';
		}
		if ($currentPage < $totalPages) {
			$html .= '<a href="' . htmlspecialchars($buildUrl($currentPage + 1)) . '">Next</a>';
			$html .= '<a href="' . htmlspecialchars($buildUrl($totalPages)) . '">Last</a>';
		}
		$html .= '</div>';
		return $html;
	}

	private function _downloadCsv($filename, $rows)
	{
		$filename = $filename ?: 'export.csv';
		$this->output
			->set_content_type('text/csv')
			->set_header('Content-Disposition: attachment; filename="' . $filename . '"')
			->set_header('Pragma: no-cache')
			->set_header('Expires: 0');

		$out = fopen('php://output', 'w');
		if (!is_array($rows) || empty($rows)) {
			fputcsv($out, ['No records']);
			fclose($out);
			return;
		}

		$headers = array_keys($rows[0]);
		fputcsv($out, $headers);
		foreach ($rows as $r) {
			$line = [];
			foreach ($headers as $h) {
				$line[] = isset($r[$h]) ? $r[$h] : '';
			}
			fputcsv($out, $line);
		}
		fclose($out);
	}

}
 ?>