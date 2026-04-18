<?php
defined('BASEPATH') OR exit('no direct script access allowed');

class Misreport extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/MisreportModel', 'mrModel');
		$this->load->library('session');
	}

	public function ledger_report()
	{
		//echo 14; exit;

		$postData = $this->input->post();



		if ($postData) {
			//echo "<pre>"; print_r($postData); exit;

			$searchData = array();
			list($searchData['emp_name'], $searchData['emp_id']) = explode("-", $postData['emp_id']);
			$searchData['emp_name'] = trim($searchData['emp_name']);
			$searchData['emp_id'] = trim($searchData['emp_id']);
			if ($postData['year']) {
				$searchData['first_year'] = $postData['year'];
				$searchData['second_year'] = ($postData['year'] + 1);
				$searchData['f_year'] = $searchData['first_year'] . "-" . $searchData['second_year'];
			}

			$ownerDetails = $this->mrModel->getMasterData($searchData['emp_id']);
			$data['ownerDetail'] = $ownerDetails[0];
			//echo $this->db->last_query(); exit;
			//echo "<pre>"; print_r($searchData); exit;
			$dcpsDetails = $this->mrModel->getdcpsDetails($searchData);
			//echo $this->db->last_query(); exit;
			foreach ($dcpsDetails as $dcpsDetail) {
				$data['dcpsDetails'][$dcpsDetail['for_month']] = $dcpsDetail;
			}
			$data['interestRates'] = $this->mrModel->getInterestRates($searchData['first_year'], $searchData['second_year']);

			$data['interestDetail'] = $this->mrModel->getYearlyInterest($searchData);
			//echo $this->db->last_query(); exit;
			//echo "<pre>"; print_r($data); exit;
		}
		$data['employeeData'] = $this->mrModel->getMasterData();

		//echo "<pre>"; print_r($data); exit;


		$this->load->view('admin/common/header');
		$this->load->view('admin/misbroadsheetreport/listing', $data);
	}

	public function ledger_report_new()
	{
		//echo 14; exit;



		$postData = $this->input->post();

		$data['urlAry'] = array();
		$notice_number = 1;
		$urlAry = $this->uri->uri_to_assoc(4);
		//echo "<pre>"; print_r($urlAry); exit;

		$searchData = array();
		if ($postData) {
			//echo "<pre>"; print_r($postData); exit;

			/*list($searchData['emp_name'], $searchData['emp_id']) = explode("-", $postData['emp_id']);
			$searchData['emp_name'] = trim($searchData['emp_name']);*/

			$searchData = $postData;

			$searchData['emp_id'] = trim($postData['emp_id']);
			if ($postData['year']) {
				$searchData['first_year'] = $postData['year'];
				$searchData['second_year'] = ($postData['year'] + 1);
				$searchData['f_year'] = $searchData['first_year'] . "-" . $searchData['second_year'];
			}
		}

		if (isset($urlAry['option']) && $urlAry['option'] == "print") {
			if ($urlAry['year']) {
				$searchData['first_year'] = $urlAry['year'];
				$searchData['second_year'] = ($urlAry['year'] + 1);
				$searchData['f_year'] = $searchData['first_year'] . "-" . $searchData['second_year'];
			}
			$data['urlAry'] = $urlAry;
		}

		/*if(is_array($searchData) && $searchData['f_year']){*/

		if (is_array($searchData)) {
			$data['searchData'] = $searchData;

			/*$ownerDetails = $this->mrModel->getMasterData($searchData['emp_id']);
			$data['ownerDetail'] = $ownerDetails[0];*/
			//echo $this->db->last_query(); exit;
			//echo "<pre>"; print_r($searchData); exit;
			$dcpsDetails = $this->mrModel->getdcpsDetailsNew($searchData);
			//echo $this->db->last_query(); exit;
			//echo "<br/><pre>"; print_r($dcpsDetails); exit;
			//echo $this->db->last_query(); exit;
			/*foreach($dcpsDetails as $dcpsDetail){
				$data['dcpsDetails'][$dcpsDetail['emp_td']][$dcpsDetail['for_month']] = $dcpsDetail;
			} */

			$processedEmpTDs = []; // To track which emp_td has been processed

			foreach ($dcpsDetails as $dcpsDetail) {
				// Grouping data into dcpsDetails based on emp_td and for_month
				$data['dcpsDetails'][$dcpsDetail['emp_td']][$dcpsDetail['for_month']] = $dcpsDetail;

				// Adding ownerDetail only for the first record of emp_td
				if (!in_array($dcpsDetail['emp_td'], $processedEmpTDs)) {
					$data['ownerDetails'][$dcpsDetail['emp_td']] = [
						'emp_id' => $dcpsDetail['emp_td'],
						'designation_name' => $dcpsDetail['designation_name'],
						'emp_name' => $dcpsDetail['emp_name'],
						'joining_date' => $dcpsDetail['joining_date'],
						'pay_center' => $dcpsDetail['pay_center'],
						'fixed_pay' => $dcpsDetail['fixed_pay'],
					];

					// Mark emp_td as processed
					$processedEmpTDs[] = $dcpsDetail['emp_td'];
				}
			}

			$data['interestRates'] = $this->mrModel->getInterestRates($searchData['first_year'], $searchData['second_year']);

			$interestDetails = $this->mrModel->getYearlyInterestNew($searchData);

			foreach ($interestDetails as $interestDetail) {
				// Grouping data into dcpsDetails based on emp_td and for_month
				$data['interestDetail'][$interestDetail['employee_id']] = $interestDetail;
			}
			//echo $this->db->last_query(); exit;
			//echo "<pre>"; print_r($data['interestDetail']); exit;
		}
		$data['paycenterData'] = $this->mrModel->getPayCenterData();
		$data['employeeData'] = $this->mrModel->getMasterData();
		$data['title'] = 'Ledger Report';

		$this->load->view('admin/common/header', $data);
		$this->load->view('admin/misbroadsheetreport/listingnew', $data);
		$this->load->view('admin/common/footer');
	}

	public function deduction_report()
	{
		// keep production noise low; errors should be logged by CI config
		//echo 14; exit;
		$postData = $this->input->post();

		$data['urlAry'] = array();
		$notice_number = 1;
		$urlAry = $this->uri->uri_to_assoc(4);
		//echo "<pre>"; print_r($urlAry); exit;

		$searchData = array();
		if ($postData) {
			//echo "<pre>"; print_r($postData); exit;

			/*list($searchData['emp_name'], $searchData['emp_id']) = explode("-", $postData['emp_id']);
			$searchData['emp_name'] = trim($searchData['emp_name']);
			$searchData['emp_id'] = trim($searchData['emp_id']);*/
			$searchData = $postData;
			$searchData['pay_center'] = $postData['pay_center'];
			$searchData['emp_id'] = $postData['emp_id'];
			if ($postData['year']) {
				$searchData['first_year'] = $postData['year'];
				$searchData['second_year'] = ($postData['year'] + 1);
				$searchData['f_year'] = $searchData['first_year'] . "-" . $searchData['second_year'];
			}
		}

		if (isset($urlAry['option']) && $urlAry['option'] == "print") {
			if ($urlAry['year']) {
				$searchData['first_year'] = $urlAry['year'];
				$searchData['second_year'] = ($urlAry['year'] + 1);
				$searchData['f_year'] = $searchData['first_year'] . "-" . $searchData['second_year'];
			}
			$data['urlAry'] = $urlAry;
		}

		if (is_array($searchData)) {

			$data['searchData'] = $searchData;

			/*$ownerDetails = $this->mrModel->getMasterData($searchData['emp_id']);
			$data['ownerDetail'] = $ownerDetails[0];*/
			//echo $this->db->last_query(); exit;
			//echo "<pre>"; print_r($searchData); exit;

			$dcpsDetails = $this->mrModel->getdcpsAllDetailsForDeduction($searchData);
			//echo $this->db->last_query(); exit;
			//echo "<br/><pre>"; print_r($dcpsDetails); exit;
			//echo $this->db->last_query(); exit;
			/*foreach($dcpsDetails as $dcpsDetail){
				$data['dcpsDetails'][$dcpsDetail['emp_td']][$dcpsDetail['for_month']] = $dcpsDetail;
			} */

			//$data['dcpsDetails'] = $dcpsDetails;

			$processedEmpTDs = []; // To track which emp_td has been processed

			foreach ($dcpsDetails as $dcpsDetail) {
				// Grouping data into dcpsDetails based on emp_td and for_month
				$data['dcpsDetails'][$dcpsDetail['emp_td']][$dcpsDetail['for_year']][$dcpsDetail['for_month']][] = $dcpsDetail;

				// Adding ownerDetail only for the first record of emp_td
				if (!in_array($dcpsDetail['emp_td'], $processedEmpTDs)) {
					$data['ownerDetails'][$dcpsDetail['emp_td']] = [
						'emp_id' => $dcpsDetail['emp_td'],
						'designation_name' => $dcpsDetail['designation_name'],
						'emp_name' => $dcpsDetail['emp_name'],
						'joining_date' => $dcpsDetail['joining_date'],
						'pay_center' => $dcpsDetail['pay_center'],
						'fixed_pay' => $dcpsDetail['fixed_pay'],
					];
					// Mark emp_td as processed
					$processedEmpTDs[] = $dcpsDetail['emp_td'];
				}

			}


			//echo "<pre>"; print_r($data); exit;

			$data['interestRates'] = $this->mrModel->getInterestRates($searchData['first_year'], $searchData['second_year']);

			$interestDetails = $this->mrModel->getYearlyInterestNew($searchData);

			foreach ($interestDetails as $interestDetail) {
				// Grouping data into dcpsDetails based on emp_td and for_month
				$data['interestDetail'][$interestDetail['employee_id']] = $interestDetail;
			}
			//echo $this->db->last_query(); exit;
			//echo "<pre>"; print_r($data['interestDetail']); exit;
			//echo "<pre>"; print_r($data); exit;
		}
		$data['paycenterData'] = $this->mrModel->getPayCenterData();
		$data['employeeData'] = $this->mrModel->gerMasterDetails();
		$data['title'] = 'Deduction Report';

		$this->load->view('admin/common/header', $data);
		$this->load->view('admin/misbroadsheetreport/deduction_report', $data);
		$this->load->view('admin/common/footer');
	}

	public function get_employee_details()
	{
		$payCenter = $this->input->post('pay_center');
		$employees = $this->mrModel->gerMasterDetails("", $payCenter);
		echo json_encode($employees);
	}

	public function broad_sheet_report()
	{
		//echo 14; exit;

		$postData = $this->input->post();



		if ($postData) {
			//echo "<pre>"; print_r($postData); exit;

			$searchData = array();
			if ($postData['year']) {
				$searchData['first_year'] = $postData['year'];
				$searchData['second_year'] = ($postData['year'] + 1);
				$searchData['f_year'] = $searchData['first_year'] . "-" . $searchData['second_year'];
			}

			$ownerDetails = $this->mrModel->getMasterData($searchData['emp_id']);
			$data['ownerDetail'] = $ownerDetails[0];
			//echo $this->db->last_query(); exit;
			//echo "<pre>"; print_r($searchData); exit;
			$dcpsDetails = $this->mrModel->getdcpsDetailsNew($searchData);
			//echo $this->db->last_query(); exit;
			foreach ($dcpsDetails as $dcpsDetail) {
				$data['dcpsDetails'][$dcpsDetail['for_month']] = $dcpsDetail;
			}

			$data['interestRates'] = $this->mrModel->getInterestRates($searchData['first_year'], $searchData['second_year']);
			//echo $this->db->last_query(); exit;
			$data['interestDetail'] = $this->mrModel->getYearlyInterest($searchData);
			//echo $this->db->last_query(); exit;
			//echo "<pre>"; print_r($data); exit;
		}
		//$data['employeeData'] = $this->mrModel->getMasterData();

		//echo "<pre>"; print_r($data); exit;


		$data['title'] = 'Broad Sheet Report';
		$this->load->view('admin/common/header', $data);
		$this->load->view('admin/misbroadsheetreport/broad_sheet', $data);
		$this->load->view('admin/common/footer');
	}


}

?>