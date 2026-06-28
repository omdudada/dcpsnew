<?php 
	defined('BASEPATH') OR exit('no direct script access allowed');
	
	class Misreport extends CI_Controller{
		
		public function __construct(){ 
			parent::__construct();
			$this->load->model('admin/MisreportModel','mrModel');
			$this->load->library('session');
		}
		
		public function ledger_report()
		{
			//echo 14; exit;
			
			$postData = $this->input->post();
			
			
			
			if($postData){
				//echo "<pre>"; print_r($postData); exit;
				
				$searchData = array();
				list($searchData['emp_name'], $searchData['emp_id']) = explode("-", $postData['emp_id']);
				$searchData['emp_name'] = trim($searchData['emp_name']);
				$searchData['emp_id'] = trim($searchData['emp_id']);
				if($postData['year']){
					$searchData['first_year'] = $postData['year']; 
					$searchData['second_year'] = ($postData['year']+1); 
					$searchData['f_year'] = $searchData['first_year']."-".$searchData['second_year'];
				}
				
				$ownerDetails = $this->mrModel->getMasterData($searchData['emp_id']);
				$data['ownerDetail'] = $ownerDetails[0];
				//echo $this->db->last_query(); exit;
				//echo "<pre>"; print_r($searchData); exit;
				$dcpsDetails = $this->mrModel->getdcpsDetails($searchData);
				//echo $this->db->last_query(); exit;
				foreach($dcpsDetails as $dcpsDetail){
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
			$this->load->view('admin/misbroadsheetreport/listing',$data);
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
			if($postData){
				//echo "<pre>"; print_r($postData); exit;
				
				/*list($searchData['emp_name'], $searchData['emp_id']) = explode("-", $postData['emp_id']);
				$searchData['emp_name'] = trim($searchData['emp_name']);*/
				
				$searchData = $postData;
				
				$searchData['emp_id'] = trim($postData['emp_id']);
				if($postData['year']){
					$searchData['first_year'] = $postData['year']; 
					$searchData['second_year'] = ($postData['year']+1); 
					$searchData['f_year'] = $searchData['first_year']."-".$searchData['second_year'];
				}
			}
			
			if(isset($urlAry['option']) && $urlAry['option'] == "print"){
				if($urlAry['year']){
					$searchData['first_year'] = $urlAry['year']; 
					$searchData['second_year'] = ($urlAry['year']+1); 
					$searchData['f_year'] = $searchData['first_year']."-".$searchData['second_year'];
				}
				$data['urlAry'] = $urlAry;
			}
			
			/*if(is_array($searchData) && $searchData['f_year']){*/
		    
			if(is_array($searchData)){		    
				$data['searchData'] = $searchData;
				
				/*$ownerDetails = $this->mrModel->getMasterData($searchData['emp_id']);
				$data['ownerDetail'] = $ownerDetails[0];*/
				//echo $this->db->last_query(); exit;
				//echo "<pre>SearchData =>"; print_r($searchData); exit;
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
			
			//echo "<pre>"; print_r($data); exit;
			
			
			$this->load->view('admin/common/header');
			$this->load->view('admin/misbroadsheetreport/listingnew',$data);
		}

		public function provisional_ledger_report()
		{
			$postData = $this->input->post();
			
			$data['urlAry'] = array();
			$urlAry = $this->uri->uri_to_assoc(4);
			
			$searchData = array();
			if($postData){
				$searchData = $postData;
				$searchData['emp_id'] = trim($postData['emp_id']);
				if($postData['year']){
					$searchData['first_year'] = $postData['year']; 
					$searchData['second_year'] = ($postData['year']+1); 
					$searchData['f_year'] = $searchData['first_year']."-".$searchData['second_year'];
				}
			}
			
			if(isset($urlAry['option']) && in_array($urlAry['option'], array("print","excel"), true)){
				if(isset($urlAry['year']) && $urlAry['year']){
					$searchData['first_year'] = $urlAry['year']; 
					$searchData['second_year'] = ($urlAry['year']+1); 
					$searchData['f_year'] = $searchData['first_year']."-".$searchData['second_year'];
				}
				$data['urlAry'] = $urlAry;
			}
			
			if(is_array($searchData)){		    
				$data['searchData'] = $searchData;
				
				$dcpsDetails = $this->mrModel->getdcpsDetailsNew($searchData);
				
				if(!empty($dcpsDetails)){
					//echo "<pre>"; print_r($dcpsDetails); exit;
				}
				
				$processedEmpTDs = [];
				foreach ($dcpsDetails as $dcpsDetail) {
					$data['dcpsDetails'][$dcpsDetail['emp_td']][$dcpsDetail['for_month']] = $dcpsDetail;
					if (!in_array($dcpsDetail['emp_td'], $processedEmpTDs)) {
						$data['ownerDetails'][$dcpsDetail['emp_td']] = [
                        'emp_id' => $dcpsDetail['emp_td'],
                        'designation_name' => $dcpsDetail['designation_name'],
                        'emp_name' => $dcpsDetail['emp_name'],
                        'joining_date' => $dcpsDetail['joining_date'],
                        'pay_center' => $dcpsDetail['pay_center'],
						];
						$processedEmpTDs[] = $dcpsDetail['emp_td'];
					}
				}
				
				$data['interestRates'] = $this->mrModel->getInterestRates($searchData['first_year'], $searchData['second_year']);
				//echo "<pre>"; print_r($data['interestRates']); exit;
				
				// Final ledger calculated rows (Excel-style)
				$data['finalLedger'] = $this->mrModel->getProvisionalLedgerCumulativeRows($searchData); 
				//echo "<pre>"; print_r($data['finalLedger']); exit;
				//exit;
			}
			
			$data['paycenterData'] = $this->mrModel->getPayCenterData();
			$data['employeeData'] = $this->mrModel->gerMasterDetails();
			
			//echo "<pre>"; print_r($data['employeeData']); exit;
			
			// Excel export: output as .xls (HTML table) for compatibility.
			if(isset($urlAry['option']) && $urlAry['option'] === "excel"){
				$filename = "final_ledger_report_".date("Ymd_His").".xls";
				header("Content-Type: application/vnd.ms-excel; charset=utf-8");
				header("Content-Disposition: attachment; filename=".$filename);
				header("Pragma: no-cache");
				header("Expires: 0");
				$this->load->view('admin/misbroadsheetreport/provisional_ledger_report',$data);
				return;
			}
			
			$this->load->view('admin/common/header');
			//echo "<pre>"; print_r($data); exit;
			$this->load->view('admin/misbroadsheetreport/provisional_ledger_report',$data);
		}
		
		public function final_ledger_report()
		{
			$postData = $this->input->post();
			
			$data['urlAry'] = array();
			$urlAry = $this->uri->uri_to_assoc(4);
			
			$searchData = array();
			if($postData){
				$searchData = $postData;
				$searchData['emp_id'] = trim($postData['emp_id']);
				if($postData['year']){
					$searchData['first_year'] = $postData['year']; 
					$searchData['second_year'] = ($postData['year']+1); 
					$searchData['f_year'] = $searchData['first_year']."-".$searchData['second_year'];
				}
			}
			
			if(isset($urlAry['option']) && in_array($urlAry['option'], array("print","excel"), true)){
				if(isset($urlAry['year']) && $urlAry['year']){
					$searchData['first_year'] = $urlAry['year']; 
					$searchData['second_year'] = ($urlAry['year']+1); 
					$searchData['f_year'] = $searchData['first_year']."-".$searchData['second_year'];
				}
				$data['urlAry'] = $urlAry;
			}
			
			if(is_array($searchData)){		    
				$data['searchData'] = $searchData;
				
				$dcpsDetails = $this->mrModel->getdcpsDetailsNew($searchData);
				
				if(!empty($dcpsDetails)){
					//echo "<pre>"; print_r($dcpsDetails); exit;
				}
				
				$processedEmpTDs = [];
				foreach ($dcpsDetails as $dcpsDetail) {
					$data['dcpsDetails'][$dcpsDetail['emp_td']][$dcpsDetail['for_month']] = $dcpsDetail;
					if (!in_array($dcpsDetail['emp_td'], $processedEmpTDs)) {
						$data['ownerDetails'][$dcpsDetail['emp_td']] = [
                        'emp_id' => $dcpsDetail['emp_td'],
                        'designation_name' => $dcpsDetail['designation_name'],
                        'emp_name' => $dcpsDetail['emp_name'],
                        'joining_date' => $dcpsDetail['joining_date'],
                        'pay_center' => $dcpsDetail['pay_center'],
						];
						$processedEmpTDs[] = $dcpsDetail['emp_td'];
					}
				}
				
				$data['interestRates'] = $this->mrModel->getInterestRates($searchData['first_year'], $searchData['second_year']);
				//echo "<pre>"; print_r($data['interestRates']); exit;
				
				// Final ledger calculated rows (Excel-style)
				$data['finalLedger'] = $this->mrModel->getFinalLedgerCumulativeRows($searchData); 
				//echo "<pre>"; print_r($data['finalLedger']); exit;
				//exit;
			}
			
			$data['paycenterData'] = $this->mrModel->getPayCenterData();
			$data['employeeData'] = $this->mrModel->gerMasterDetails();
			
			//echo "<pre>"; print_r($data['employeeData']); exit;
			
			// Excel export: output as .xls (HTML table) for compatibility.
			if(isset($urlAry['option']) && $urlAry['option'] === "excel"){
				$filename = "final_ledger_report_".date("Ymd_His").".xls";
				header("Content-Type: application/vnd.ms-excel; charset=utf-8");
				header("Content-Disposition: attachment; filename=".$filename);
				header("Pragma: no-cache");
				header("Expires: 0");
				$this->load->view('admin/misbroadsheetreport/final_ledger_report',$data);
				return;
			}
			
			$this->load->view('admin/common/header');
			//echo "<pre>"; print_r($data); exit;
			$this->load->view('admin/misbroadsheetreport/final_ledger_report',$data);
		}
		
		public function generate_final_ledger_report_mpdf()
		{
			$postData = $this->input->post();
			$data['urlAry'] = array();
			$urlAry = $this->uri->uri_to_assoc(4);
			
			$searchData = array();
			if($postData){
				$searchData = $postData;
				$searchData['emp_id'] = trim($postData['emp_id']);
				if($postData['year']){
					$searchData['first_year'] = $postData['year']; 
					$searchData['second_year'] = ($postData['year']+1); 
					$searchData['f_year'] = $searchData['first_year']."-".$searchData['second_year'];
				}
			}
			
			if(is_array($searchData) && !empty($searchData)){		    
				$data['searchData'] = $searchData;
				
				$dcpsDetails = $this->mrModel->getdcpsDetailsNew($searchData);
				
				$processedEmpTDs = [];
				if(!empty($dcpsDetails)){
					foreach ($dcpsDetails as $dcpsDetail) {
						$data['dcpsDetails'][$dcpsDetail['emp_td']][$dcpsDetail['for_month']] = $dcpsDetail;
						if (!in_array($dcpsDetail['emp_td'], $processedEmpTDs)) {
							$data['ownerDetails'][$dcpsDetail['emp_td']] = [
                            'emp_id' => $dcpsDetail['emp_td'],
                            'designation_name' => $dcpsDetail['designation_name'],
                            'emp_name' => $dcpsDetail['emp_name'],
                            'joining_date' => $dcpsDetail['joining_date'],
                            'pay_center' => $dcpsDetail['pay_center'],
							];
							$processedEmpTDs[] = $dcpsDetail['emp_td'];
						}
					}
				}
				
				$data['interestRates'] = $this->mrModel->getInterestRates($searchData['first_year'], $searchData['second_year']);
				$data['finalLedger'] = $this->mrModel->getFinalLedgerCumulativeRows($searchData); 
				} else {
				show_404();
			}
			
			$config = [
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 15,
            'margin_bottom' => 15,
            'margin_header' => 0,
            'margin_footer' => 0,
            'autoScriptToLang' => true,
            'autoLangToFont' => true,
			];
			
			$this->load->library('m_pdf', $config);
			
			$this->m_pdf->pdf->SetTitle('Final Ledger Report');
			$this->m_pdf->pdf->SetAuthor('NMC');
			$this->m_pdf->pdf->SetCreator('Pension System');
			
			$html = $this->load->view('admin/misbroadsheetreport/final_ledger_report_pdf', $data, TRUE);
			
			$this->m_pdf->pdf->WriteHTML($html);
			
			$this->m_pdf->pdf->Output('Final_Ledger_Report.pdf', 'I');
		}

		public function generate_provisional_ledger_report_mpdf()
		{
			$postData = $this->input->post();
			$data['urlAry'] = array();
			$urlAry = $this->uri->uri_to_assoc(4);
			
			$searchData = array();
			if($postData){
				$searchData = $postData;
				$searchData['emp_id'] = trim($postData['emp_id']);
				if($postData['year']){
					$searchData['first_year'] = $postData['year']; 
					$searchData['second_year'] = ($postData['year']+1); 
					$searchData['f_year'] = $searchData['first_year']."-".$searchData['second_year'];
				}
			}
			
			if(is_array($searchData) && !empty($searchData)){		    
				$data['searchData'] = $searchData;
				
				$dcpsDetails = $this->mrModel->getdcpsDetailsNew($searchData);
				
				$processedEmpTDs = [];
				if(!empty($dcpsDetails)){
					foreach ($dcpsDetails as $dcpsDetail) {
						$data['dcpsDetails'][$dcpsDetail['emp_td']][$dcpsDetail['for_month']] = $dcpsDetail;
						if (!in_array($dcpsDetail['emp_td'], $processedEmpTDs)) {
							$data['ownerDetails'][$dcpsDetail['emp_td']] = [
                            'emp_id'           => $dcpsDetail['emp_td'],
                            'designation_name' => $dcpsDetail['designation_name'],
                            'emp_name'         => $dcpsDetail['emp_name'],
                            'joining_date'     => $dcpsDetail['joining_date'],
                            'pay_center'       => $dcpsDetail['pay_center'],
							];
							$processedEmpTDs[] = $dcpsDetail['emp_td'];
						}
					}
				}
				
				$data['interestRates'] = $this->mrModel->getInterestRates($searchData['first_year'], $searchData['second_year']);
				$data['finalLedger']   = $this->mrModel->getProvisionalLedgerCumulativeRows($searchData);
				} else {
				show_404();
			}
			
			$config = [
            'mode'             => 'utf-8',
            'format'           => 'A4-L',
            'margin_left'      => 8,
            'margin_right'     => 8,
            'margin_top'       => 10,
            'margin_bottom'    => 10,
            'margin_header'    => 0,
            'margin_footer'    => 0,
            'autoScriptToLang' => true,
            'autoLangToFont'   => true,
			];
			
			$this->load->library('m_pdf', $config);
			
			$this->m_pdf->pdf->SetTitle('Provisional Ledger Report');
			$this->m_pdf->pdf->SetAuthor('NMC');
			$this->m_pdf->pdf->SetCreator('Pension System');
			
			$html = $this->load->view('admin/misbroadsheetreport/provisional_ledger_report_pdf', $data, TRUE);
			
			$this->m_pdf->pdf->WriteHTML($html);
			
			$this->m_pdf->pdf->Output('Provisional_Ledger_Report.pdf', 'I');
		}
		
		public function deduction_report_27052026()
		{
			//echo 14; exit;
			$postData = $this->input->post();
			
			$data['urlAry'] = array();
			$notice_number = 1;
			$urlAry = $this->uri->uri_to_assoc(4);
			//echo "<pre>"; print_r($urlAry); exit;
			
			$searchData = array();
			if($postData){
				//echo "<pre>"; print_r($postData); exit;
				
				/*list($searchData['emp_name'], $searchData['emp_id']) = explode("-", $postData['emp_id']);
					$searchData['emp_name'] = trim($searchData['emp_name']);
				$searchData['emp_id'] = trim($searchData['emp_id']);*/
				$searchData = $postData;
				$searchData['pay_center'] = $postData['pay_center'];
				$searchData['emp_id'] = $postData['emp_id'];
				if($postData['year']){
					$searchData['first_year'] = $postData['year']; 
					$searchData['second_year'] = ($postData['year']+1); 
					$searchData['f_year'] = $searchData['first_year']."-".$searchData['second_year'];
				}
			}
			
			if(isset($urlAry['option']) && $urlAry['option'] == "print"){
				if($urlAry['year']){
					$searchData['first_year'] = $urlAry['year']; 
					$searchData['second_year'] = ($urlAry['year']+1); 
					$searchData['f_year'] = $searchData['first_year']."-".$searchData['second_year'];
				}
				$data['urlAry'] = $urlAry;
			}
			
			if(is_array($searchData)){
				
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
				
				//$data['interestRates'] = $this->mrModel->getInterestRates($searchData['first_year'], $searchData['second_year']);
				
				if(isset($searchData['first_year']) && isset($searchData['second_year'])){
					$data['interestRates'] = $this->mrModel->getInterestRates($searchData['first_year'], $searchData['second_year']);
					$searchData['f_year'] = $searchData['first_year'];
					} else {
					$currentYear = date('Y');
					$financialYear = $currentYear - 1;
					$data['interestRates'] = $this->mrModel->getInterestRates($financialYear, $currentYear);
					$searchData['f_year'] = $financialYear;
				}
				
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
			
			//echo "<pre>"; print_r($data); exit;
			
			
			$this->load->view('admin/common/header');
			/*if(isset($urlAry['option']) && $urlAry['option'] == "print"){
				//echo "<pre>"; print_r($data); exit;
				
				$this->load->view('admin/misbroadsheetreport/print_deduction_report',$data);
				}
				else{
				$this->load->view('admin/misbroadsheetreport/deduction_report',$data);
			}*/
			$this->load->view('admin/misbroadsheetreport/deduction_report',$data);
		}
		
		public function deduction_report()
		{
			//echo 14; exit;
			$postData = $this->input->post();
			
			$data['urlAry'] = array();
			$notice_number = 1;
			$urlAry = $this->uri->uri_to_assoc(4);
			//echo "<pre>"; print_r($urlAry); exit;
			
			$searchData = array();
			if($postData){
				//echo "<pre>"; print_r($postData); exit;
				
				/*list($searchData['emp_name'], $searchData['emp_id']) = explode("-", $postData['emp_id']);
					$searchData['emp_name'] = trim($searchData['emp_name']);
				$searchData['emp_id'] = trim($searchData['emp_id']);*/
				$searchData = $postData;
				$searchData['pay_center'] = $postData['pay_center'];
				$searchData['emp_id'] = $postData['emp_id'];
				if($postData['year']){
					$searchData['first_year'] = $postData['year']; 
					$searchData['second_year'] = ($postData['year']+1); 
					$searchData['f_year'] = $searchData['first_year']."-".$searchData['second_year'];
				}
			}
			
			if(isset($urlAry['option']) && in_array($urlAry['option'], ["print", "csv", "excel"])){ 
				if($urlAry['year']){
					$searchData['first_year'] = $urlAry['year']; 
					$searchData['second_year'] = ($urlAry['year']+1); 
					$searchData['f_year'] = $searchData['first_year']."-".$searchData['second_year'];
				}
				$data['urlAry'] = $urlAry;
			}
			
			if(is_array($searchData)){
				
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
				
				//$data['interestRates'] = $this->mrModel->getInterestRates($searchData['first_year'], $searchData['second_year']);
				
				if(isset($searchData['first_year']) && isset($searchData['second_year'])){
					$data['interestRates'] = $this->mrModel->getInterestRates($searchData['first_year'], $searchData['second_year']);
					$searchData['f_year'] = $searchData['first_year'];
					} else {
					$currentYear = date('Y');
					$financialYear = $currentYear - 1;
					$data['interestRates'] = $this->mrModel->getInterestRates($financialYear, $currentYear);
					$searchData['f_year'] = $financialYear;
				}
				
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
			
			//echo "<pre>"; print_r($data); exit;
			
			
			
			
			if(isset($urlAry['option']) && $urlAry['option'] == "excel"){
				$filename = "deduction_report_".date("Ymd_His").".xls";
				header("Content-Type: application/vnd.ms-excel; charset=utf-8");
				header("Content-Disposition: attachment; filename=".$filename);
				header("Pragma: no-cache");
				header("Expires: 0");
				
				echo $this->load->view('admin/misbroadsheetreport/deduction_report_pdf', $data, true);
				exit;
			}
			
			$this->load->view('admin/common/header');
			/*if(isset($urlAry['option']) && $urlAry['option'] == "print"){
				//echo "<pre>"; print_r($data); exit;
				
				$this->load->view('admin/misbroadsheetreport/print_deduction_report',$data);
				}
				else{
				$this->load->view('admin/misbroadsheetreport/deduction_report',$data);
			}*/
			$this->load->view('admin/misbroadsheetreport/deduction_report',$data);
		}
		
		public function generate_deduction_report_mpdf()
		{
			$postData = $this->input->post();
			$data['urlAry'] = array();
			$urlAry = $this->uri->uri_to_assoc(4);
			
			$searchData = array();
			if($postData){
				$searchData = $postData;
				$searchData['pay_center'] = $postData['pay_center'];
				$searchData['emp_id'] = $postData['emp_id'];
				if($postData['year']){
					$searchData['first_year'] = $postData['year']; 
					$searchData['second_year'] = ($postData['year']+1); 
					$searchData['f_year'] = $searchData['first_year']."-".$searchData['second_year'];
				}
			}
			
			if(is_array($searchData) && !empty($searchData)){		    
				$data['searchData'] = $searchData;
				
				$dcpsDetails = $this->mrModel->getdcpsAllDetailsForDeduction($searchData);
				
				$processedEmpTDs = [];
				if(!empty($dcpsDetails)){
					foreach ($dcpsDetails as $dcpsDetail) {
						$data['dcpsDetails'][$dcpsDetail['emp_td']][$dcpsDetail['for_year']][$dcpsDetail['for_month']][] = $dcpsDetail;
						if (!in_array($dcpsDetail['emp_td'], $processedEmpTDs)) {
							$data['ownerDetails'][$dcpsDetail['emp_td']] = [
	                        'emp_id' => $dcpsDetail['emp_td'],
	                        'designation_name' => $dcpsDetail['designation_name'],
	                        'emp_name' => $dcpsDetail['emp_name'],
	                        'joining_date' => $dcpsDetail['joining_date'],
	                        'pay_center' => $dcpsDetail['pay_center'],
	                        'fixed_pay' => $dcpsDetail['fixed_pay'],
							];
							$processedEmpTDs[] = $dcpsDetail['emp_td'];
						}
					}
				}
				
				if(isset($searchData['first_year']) && isset($searchData['second_year'])){
					$data['interestRates'] = $this->mrModel->getInterestRates($searchData['first_year'], $searchData['second_year']);
					$searchData['f_year'] = $searchData['first_year'];
					} else {
					$currentYear = date('Y');
					$financialYear = $currentYear - 1;
					$data['interestRates'] = $this->mrModel->getInterestRates($financialYear, $currentYear);
					$searchData['f_year'] = $financialYear;
				}
				
				$interestDetails = $this->mrModel->getYearlyInterestNew($searchData);
				
				foreach ($interestDetails as $interestDetail) {
					$data['interestDetail'][$interestDetail['employee_id']] = $interestDetail;
				}
				} else {
				show_404();
			}
			
			$config = [
	        'mode' => 'utf-8',
	        'format' => 'A4',
	        'margin_left' => 15,
	        'margin_right' => 15,
	        'margin_top' => 15,
	        'margin_bottom' => 15,
	        'margin_header' => 0,
	        'margin_footer' => 0,
	        'autoScriptToLang' => true,
	        'autoLangToFont' => true,
			];
			
			$this->load->library('m_pdf', $config);
			
			$this->m_pdf->pdf->SetTitle('Deduction Report');
			$this->m_pdf->pdf->SetAuthor('NMC');
			$this->m_pdf->pdf->SetCreator('Pension System');
			
			$html = $this->load->view('admin/misbroadsheetreport/deduction_report_pdf', $data, TRUE);
			
			$this->m_pdf->pdf->WriteHTML($html);
			
			$this->m_pdf->pdf->Output('Deduction_Report.pdf', 'I');
		}
		
		public function get_employee_details(){
			$payCenter = $this->input->post('pay_center');
			$employees = $this->mrModel->gerMasterDetails("", $payCenter);
			echo json_encode($employees);
		}
		
		public function broad_sheet_report_28052026()
		{
			//echo 14; exit;
			
			$postData = $this->input->post();
			
			
			
			if($postData){
				//echo "<pre>"; print_r($postData); exit;
				
				$searchData = array();
				if($postData['year']){
					$searchData['first_year'] = $postData['year']; 
					$searchData['second_year'] = ($postData['year']+1); 
					$searchData['f_year'] = $searchData['first_year']."-".$searchData['second_year'];
				}
				
				$ownerDetails = $this->mrModel->getMasterData($searchData['emp_id']);
				$data['ownerDetail'] = $ownerDetails[0];
				//echo $this->db->last_query(); exit;
				//echo "<pre>"; print_r($searchData); exit;
				$dcpsDetails = $this->mrModel->getdcpsDetailsNew($searchData);
				//echo $this->db->last_query(); exit;
				foreach($dcpsDetails as $dcpsDetail){
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
			
			
			$this->load->view('admin/common/header');
			$this->load->view('admin/misbroadsheetreport/broad_sheet',$data);
		}
		
		
		public function broad_sheet_report()
		{
			//echo 14; exit;
			
			$postData = $this->input->post();
			$data = array();
			
			if($postData && isset($postData['year'])){
				//echo "<pre>"; print_r($postData); exit;
				
				$firstYear = (int)$postData['year']; 
				$secondYear = ($firstYear + 1);
				$fYear = $firstYear . "-" . $secondYear;
				
				// Get year-wise broad sheet summary (aggregated across all employees)
				$broadSheetSummary = $this->mrModel->getYearWiseBroadSheetSummary($firstYear, $secondYear);
				
				//echo "<pre>"; print_r($broadSheetSummary); exit;
				
				$data['broadSheetSummary'] = $broadSheetSummary;
				$data['firstYear'] = $firstYear;
				$data['secondYear'] = $secondYear;
				$data['fYear'] = $fYear;
				
				// Get interest rates for display
				$data['interestRates'] = $this->mrModel->getInterestRates($firstYear, $secondYear);
			}
			
			//echo "<pre>"; print_r($data); exit;
			
			$this->load->view('admin/common/header');
			$this->load->view('admin/misbroadsheetreport/broad_sheet',$data);
		}
		
		public function employee_contribution_excess_report()
		{
			$postData = $this->input->post();
			
			$data['urlAry'] = array();
			$urlAry = $this->uri->uri_to_assoc(4);
			
			$searchData = array();
			if($postData){
				$searchData = $postData;
				$searchData['pay_center'] = $postData['pay_center'];
				$searchData['emp_id'] = $postData['emp_id'];
			}
			
			if(isset($urlAry['option']) && in_array($urlAry['option'], ["print", "csv", "excel"])){ 
				$data['urlAry'] = $urlAry;
			}
			
			if(is_array($searchData) && !empty($searchData['emp_id'])){
				$data['searchData'] = $searchData;
				
				$dcpsDetails = $this->mrModel->getdcpsAllDetailsForDeduction($searchData);
				
				$processedEmpTDs = [];
				if(!empty($dcpsDetails)){
					foreach ($dcpsDetails as $dcpsDetail) {
						$data['dcpsDetails'][$dcpsDetail['emp_td']][] = $dcpsDetail;
						if (!in_array($dcpsDetail['emp_td'], $processedEmpTDs)) {
							$data['ownerDetails'][$dcpsDetail['emp_td']] = [
								'emp_id' => $dcpsDetail['emp_td'],
								'designation_name' => $dcpsDetail['designation_name'],
								'emp_name' => $dcpsDetail['emp_name'],
								'joining_date' => $dcpsDetail['joining_date'],
								'pay_center' => $dcpsDetail['pay_center'],
								'fixed_pay' => $dcpsDetail['fixed_pay'],
							];
							$processedEmpTDs[] = $dcpsDetail['emp_td'];
						}
					}
				}
			}
			$data['paycenterData'] = $this->mrModel->getPayCenterData();
			$data['employeeData'] = $this->mrModel->gerMasterDetails();
			
			if(isset($urlAry['option']) && $urlAry['option'] == "excel"){
				$filename = "employee_contribution_excess_report_".date("Ymd_His").".xls";
				header("Content-Type: application/vnd.ms-excel; charset=utf-8");
				header("Content-Disposition: attachment; filename=".$filename);
				header("Pragma: no-cache");
				header("Expires: 0");
				
				echo $this->load->view('admin/misbroadsheetreport/employee_contribution_excess_report_pdf', $data, true);
				exit;
			}
			
			$this->load->view('admin/common/header');
			$this->load->view('admin/misbroadsheetreport/employee_contribution_excess_report', $data);
		}
		
		public function generate_excess_report_mpdf()
		{
			$postData = $this->input->post();
			$data['urlAry'] = array();
			$urlAry = $this->uri->uri_to_assoc(4);
			
			$searchData = array();
			if($postData){
				$searchData = $postData;
				$searchData['pay_center'] = $postData['pay_center'];
				$searchData['emp_id'] = $postData['emp_id'];
			}
			
			if(is_array($searchData) && !empty($searchData['emp_id'])){		    
				$data['searchData'] = $searchData;
				
				$dcpsDetails = $this->mrModel->getdcpsAllDetailsForDeduction($searchData);
				
				$processedEmpTDs = [];
				if(!empty($dcpsDetails)){
					foreach ($dcpsDetails as $dcpsDetail) {
						$data['dcpsDetails'][$dcpsDetail['emp_td']][] = $dcpsDetail;
						if (!in_array($dcpsDetail['emp_td'], $processedEmpTDs)) {
							$data['ownerDetails'][$dcpsDetail['emp_td']] = [
								'emp_id' => $dcpsDetail['emp_td'],
								'designation_name' => $dcpsDetail['designation_name'],
								'emp_name' => $dcpsDetail['emp_name'],
								'joining_date' => $dcpsDetail['joining_date'],
								'pay_center' => $dcpsDetail['pay_center'],
								'fixed_pay' => $dcpsDetail['fixed_pay'],
							];
							$processedEmpTDs[] = $dcpsDetail['emp_td'];
						}
					}
				}
			} else {
				show_404();
			}
			
			$config = [
				'mode' => 'utf-8',
				'format' => 'A4',
				'margin_left' => 15,
				'margin_right' => 15,
				'margin_top' => 15,
				'margin_bottom' => 15,
				'margin_header' => 0,
				'margin_footer' => 0,
				'autoScriptToLang' => true,
				'autoLangToFont' => true,
			];
			
			$this->load->library('m_pdf', $config);
			
			$this->m_pdf->pdf->SetTitle('Employee Contribution Excess Deduction Recovery Report');
			$this->m_pdf->pdf->SetAuthor('NMC');
			$this->m_pdf->pdf->SetCreator('Pension System');
			
			$html = $this->load->view('admin/misbroadsheetreport/employee_contribution_excess_report_pdf', $data, TRUE);
			
			$this->m_pdf->pdf->WriteHTML($html);
			
			$this->m_pdf->pdf->Output('Employee_Contribution_Excess_Report.pdf', 'I');
		}
		
	}
	
?>