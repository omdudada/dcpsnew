<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Ajax extends CI_Controller 
	{
		public function __construct(){
			parent::__construct();
		}
		
		public function changePer(){
			$this->load->model('admin/AddeditModel','aModel');
			$v_date = $this->input->post('v_date');
			$dtes1 = explode(".",$v_date);
			$voucher_date = mktime(0,0,0,$dtes1[1],$dtes1[0],$dtes1[2]);
		    $perChange = $this->aModel->getPerChange($voucher_date);	
		    echo json_encode($perChange);
		}

		public function broadSheetReport(){
			$this->load->model('admin/ReportModel','rModel');
			$data['year'] = $this->input->post('year');
			if($data['year']){
				$customerInfos['data'] = $this->rModel->getDetailsOfEmp($data['year']);
				$customerInfos['grData'] = $this->rModel->getGrManageData($data['year']);
				$customerInfos['year'] = $data['year'];
			}
			if(count($customerInfos['data']) > 1){
				$result['customer_detail'] = $this->load->view('admin/broadsheetreport/details_of_broadsheet', $customerInfos, true); 
			}
			echo json_encode($result);
		}

		public function getDeatailsOfDeductionRec(){ 
		    
			$this->load->model('admin/ReportModel','rModel');
			$data['id'] = $this->input->post('id');
			$data['year'] = $this->input->post('year');
			$data['month'] = $this->input->post('month');
			
			if($data['id'] && $data['year']){
				//$customerInfos['data'] = $this->rModel->getDeductionRecord($data['id'],$data['year']);
				$customerInfos['data'] = $this->rModel->getDeductionRecordForYear($data['year'], $data['id'], $data['month']);
			}
			if(count($customerInfos['data']) >= 1){
			    $result['customer_detail'] = $this->load->view('admin/deductionrecord/display_data_of_year', $customerInfos, true); 
			}
			if($data['id'] == '' && $data['year']){
				$customerInfos['data'] = $this->rModel->getDeductionRecordForYear($data['year'], '', $data['month']);
			}
			//echo "<pre>"; print_r($customerInfos); exit;
			if(count($customerInfos['data']) >= 1){
				$result['customer_detail'] = $this->load->view('admin/deductionrecord/display_data_of_year', $customerInfos, true); 
			}
			
			echo json_encode($result);
		}
		
		public function getDeatailsOfMonthRec(){
			$this->load->model('admin/ReportModel','rModel');
			$data['for_month'] = $this->input->post('for_month');
			$data['year'] = $this->input->post('year');
			if($data['for_month'] && $data['year']){
				$customerInfos['data'] = $this->rModel->getMonthlyRecord($data['for_month'],$data['year']);
			}
			if(count($customerInfos['data']) >= 1){
			    $result['customer_detail'] = $this->load->view('admin/monthlyrecord/display_data_of_year', $customerInfos, true); echo json_encode($result);
			}
		    
			/*if(count($customerInfos['data']) >= 1){
				$result['customer_detail'] = $this->load->view('admin/monthlyrecord/display_data_of_year', $customerInfos, true); 
			}*/
			
			
		}

		public function getEmpMonthsDetails(){
			$this->load->model('admin/ReportModel','rModel');
			$postdata = $this->input->post();
			if($postdata){
				$customerInfos['data'] = $this->rModel->getYearsOfEmp($postdata);
			}
			if(count($customerInfos['data']) > 0){
				$result['customer_detail'] = $this->load->view('admin/deductionrecord/view_details_of_emp', $customerInfos, true);
			}
			echo json_encode($result);
		}

		public function getcustomerdetail(){
			$this->load->model('admin/ReportModel','rModel');
			$data['id'] = $this->input->post('id');
			$data['month'] = $this->input->post('month');
			$data['year'] = $this->input->post('year');
			//echo "<pre>"; print_r($data); exit;
			if($data['id'] && $data['month'] == '' && $data['year'] == ''){
				$customerInfos['data'] = $this->rModel->getCustomerDetails($data['id']);
			}
			if($data['id'] && $data['year']){
				$customerInfos['data'] = $this->rModel->getCustomerDetailsNew($data['id'], $data['year']);
			}
			//echo "<pre>"; print_r($customerInfos); exit;
			if(count($customerInfos['data']) > 1){
				$result['customer_detail'] = $this->load->view('admin/masterdata/view_details_of_emp', $customerInfos, true); 
				
			}
			if($data['id'] == '' && $data['month'] == '' && $data['year']){
				$customerInfos['data'] = $this->rModel->getDataOfYearWise($data['year']);
			}
			if(count($customerInfos['data']) > 1){
				$result['customer_detail'] = $this->load->view('admin/masterdata/view_details_of_emp', $customerInfos, true);
			}
			else{
				if(!$data['id']){
					$data['id'] = $customerInfos[0]->emp_td;
				}
				$customerDetails['cdata'] = $this->rModel->getcustomerinfo($data);
				$result['customer_detail'] = $this->load->view('admin/masterdata/displaymasterdata', $customerDetails, true); 
			}
			echo json_encode($result);
		}

		public function checkByEmpForDetails(){
			$this->load->model('admin/MasterdModel','mModel');
			$data['id'] = $this->input->post('id');
			if($data['id']){
				$customerInfos['data'] = $this->mModel->getData($data['id']);
			}
			if(count($customerInfos['data']) > 1){
				$result['customer_detail'] = $this->load->view('admin/openingbal/details_of_emp_for_opening_bal', $customerInfos, true); 
			}
			echo json_encode($result);
		}

		public function usingTableCalculateOpenBal(){
			$this->load->model('admin/MasterdModel','mModel');
			$data['id'] = $this->input->post('id');
			if($data['id']){
				$customerInfos['data'] = $this->mModel->getDetailsForOpeningBal($data['id']);
			}
			if(count($customerInfos['data']) > 1){
				$update['id'] = $customerInfos['data']['id'];
				$update['emp_td'] = $customerInfos['data']['emp_td'];
				$update['month'] = $customerInfos['data']['for_month'];
				$update['year'] = $customerInfos['data']['for_year'];
				$date = $this->mModel->recoverVoucherDate($customerInfos['data']['recovered_DCPS_with_voucher_date']);
				$empCon = $customerInfos['data']['emp_DCPS_contribution'] + $customerInfos['data']['emp_DCPS_supplimentory_contribution'];
				$nmcCon = $customerInfos['data']['NMC_DCPS_contribution'] + $customerInfos['data'][' NMC_supplimentory_DCPS_contribution '];

				$update['totalOpBal'] = $customerInfos['data']['opening_balance']+ $empCon + $nmcCon - $customerInfos['data']['DCPS_loan_taken_by_an_employee'];
				$dis = ((($update['totalOpBal'] / 100)/12)*$date['gr_percentage']);
				$update['final'] = $dis + $update['totalOpBal'];
				$data = $this->mModel->updateOpBal($update);
				if ($data>0) {
					$res = 1;
				}else{
					$res = 0;
				}
			}
			echo json_encode(array('status' => $res));
		}

		public function searchForEmpId(){
			$this->load->model('admin/ReportModel','rModel');
			$data['id'] = $this->input->post('id');
			$data['year'] = $this->input->post('year');
			if($data['id'] && $data['year']){
				$customerInfos['data'] = $this->rModel->getDetailsOfEmpForSlipAndLeadger($data['id'],$data['year']);
				$customerInfos['opBalData'] = $this->rModel->getDataForOpenigBalTable($data['id'],$data['year']);
			}
			if(count($customerInfos['data']) > 1){
				$result['customer_detail'] = $this->load->view('admin/slipandledger/view_details_of_emp', $customerInfos, true); 
			}
			echo json_encode($result);
		}
	}
?>