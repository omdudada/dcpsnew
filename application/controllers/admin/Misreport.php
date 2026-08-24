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
				$filename = "provisional_ledger_report_".date("Ymd_His").".xls";
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
				
				$dcpsDetails = $this->mrModel->getdcpsDetailsNewFinalLedger($searchData);
				
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
			ini_set('pcre.backtrack_limit', '50000000');
			ini_set('memory_limit', '2048M');
			set_time_limit(1800);

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
				
				$dcpsDetails = $this->mrModel->getdcpsDetailsNewFinalLedger($searchData);
				
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
			
			/*$config = [
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
			
			$this->m_pdf->pdf->Output('Final_Ledger_Report.pdf', 'I');*/

			
			$config = [
				'mode'             => 'utf-8',
				'format'           => 'Legal-L',
				'margin_left'      => 15,
				'margin_right'     => 15,
				'margin_top'       => 15,
				'margin_bottom'    => 20,   // ← increase bottom to make room for footer
				'margin_header'    => 0,
				'margin_footer'    => 10,   // ← add footer margin
				'autoScriptToLang' => true,
				'autoLangToFont'   => true,
			];

			$this->load->library('m_pdf', $config);

			$this->m_pdf->pdf->SetTitle('Deduction Report');
			$this->m_pdf->pdf->SetAuthor('NMC');
			$this->m_pdf->pdf->SetCreator('Pension System');

			// ── Page number footer ──────────────────────────────────────
			$this->m_pdf->pdf->SetFooter('||पृष्ठ {PAGENO} / {nb}||');
			// {PAGENO} = current page, {nb} = total pages
			// Format: left | center | right  (pipe-separated)
			// Above puts it in the center. Change position as needed:
			// Left:   'पृष्ठ {PAGENO} / {nb}||'
			// Right:  '||पृष्ठ {PAGENO} / {nb}'

			// ── Must call AddPage first, then SetHTMLFooter ──
			$this->m_pdf->pdf->AddPage();

			$this->m_pdf->pdf->SetHTMLFooter('
				<div style="text-align:right">Page No. {PAGENO} / {nb}</div>
			');

			$html = $this->load->view('admin/misbroadsheetreport/final_ledger_report_pdf', $data, TRUE);
			
			$this->m_pdf->pdf->WriteHTML($html);
			
			$this->m_pdf->pdf->Output('Final_Ledger_Report.pdf', 'I');
		}

		public function generate_provisional_ledger_report_mpdf()
		{
			ini_set('pcre.backtrack_limit', '50000000');
			ini_set('memory_limit', '2048M');
			set_time_limit(1800);

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
				'format'           => 'Legal-L',
				'margin_left'      => 15,
				'margin_right'     => 15,
				'margin_top'       => 15,
				'margin_bottom'    => 20,
				'margin_header'    => 0,
				'margin_footer'    => 10,
				'autoScriptToLang' => true,
				'autoLangToFont'   => true,
			];

			$this->load->library('m_pdf', $config);

			$this->m_pdf->pdf->SetTitle('Provisional Ledger Report');
			$this->m_pdf->pdf->SetAuthor('NMC');
			$this->m_pdf->pdf->SetCreator('Pension System');

			$this->m_pdf->pdf->SetFooter('||पृष्ठ {PAGENO} / {nb}||');

			$this->m_pdf->pdf->AddPage();

			$this->m_pdf->pdf->SetHTMLFooter('
				<div style="text-align:right">Page No. {PAGENO} / {nb}</div>
			');

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
			ini_set('pcre.backtrack_limit', '50000000');
			ini_set('memory_limit', '2048M');
			set_time_limit(1800);

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
				'mode'             => 'utf-8',
				'format'           => 'Legal-L',
				'margin_left'      => 15,
				'margin_right'     => 15,
				'margin_top'       => 15,
				'margin_bottom'    => 20,   // ← increase bottom to make room for footer
				'margin_header'    => 0,
				'margin_footer'    => 10,   // ← add footer margin
				'autoScriptToLang' => true,
				'autoLangToFont'   => true,
			];

			$this->load->library('m_pdf', $config);

			$this->m_pdf->pdf->SetTitle('Deduction Report');
			$this->m_pdf->pdf->SetAuthor('NMC');
			$this->m_pdf->pdf->SetCreator('Pension System');

			$this->m_pdf->pdf->SetHTMLFooter('
				<div style="text-align:right">Page No. {PAGENO} / {nb}</div>
			');

			// Write CSS styles once to avoid repeating in every chunk
			$css = '
				body {
					font-family: "freesans", sans-serif;
					margin: 0;
					padding: 0;
				}
				table {
					width: 100%;
					border-collapse: collapse;
					font-size: 11px;
					margin-bottom: 0px;
				}
				th, td {
					border: 1px solid #000;
					padding: 4px;
					text-align: center;
					word-wrap: break-word;
					white-space: normal;
				}
				th {
					font-weight: bold;
				}
				table td.clsCenter, table th.clsCenter {
					text-align: center;
					vertical-align: middle;
				}
				table td.clsRight, table th.clsRight {
					text-align: right;
					vertical-align: middle;
				}
				table td.clsLeft {
					text-align: left;
					vertical-align: middle;
				}
				.final-ledger-bottom-wrap {
					width: 100%;
					margin-top: 16px;
					border-collapse: collapse;
					table-layout: fixed;
				}
				.final-ledger-bottom-wrap td {
					vertical-align: top;
					border: 1px solid #000;
					padding: 10px;
				}
				.final-ledger-summary-wrap {
					width: 62%;
				}
				.final-ledger-summary-table {
					width: 100%;
					border-collapse: collapse;
				}
				.final-ledger-summary-table th,
				.final-ledger-summary-table td {
					border: 1px solid #000 !important;
					padding: 4px 6px !important;
					font-size: 10px;
					vertical-align: middle;
				}
				.final-ledger-summary-table th {
					text-align: center;
					font-weight: bold;
				}
				.final-ledger-summary-table .fls-month {
					text-align: center;
				}
				.final-ledger-summary-table .fls-amt {
					text-align: right;
					white-space: nowrap;
				}
				.final-ledger-cert-box {
					width: 100%;
					font-size: 13px;
					line-height: 1.45;
					text-align: justify;
				}
				.final-ledger-cert-box strong {
					display: block;
					text-align: center;
					margin-bottom: 10px;
					font-size: 14px;
				}
				.final-ledger-cert-signs {
					margin-top: 20px;
					padding-top: 8px;
				}
				.final-ledger-sign-line {
					border-top: 1px solid #000;
					margin-top: 36px;
					padding-top: 6px;
					text-align: center;
					font-size: 12px;
					line-height: 1.35;
				}
				.final-ledger-cert-signs .final-ledger-sign-line:first-child {
					margin-top: 16px;
				}
				.new-page {
					page-break-after: always;
				}
				.deduction-report-header {
					text-align: center;
					margin-bottom: 10px;
					font-weight: bold;
				}
			';
			$this->m_pdf->pdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);

			// Filter only owners with actual deduction data
			$validOwners = [];
			if(!empty($data['ownerDetails'])){
				foreach ($data['ownerDetails'] as $empId => $ownerDetail) {
					if(!empty($data['dcpsDetails'][$empId])){
						$validOwners[$empId] = $ownerDetail;
					}
				}
			}

			if(!empty($validOwners)){
				$chunkSize = 10; // Process in chunks of 10 employees to avoid pcre.backtrack_limit
				$ownerChunks = array_chunk($validOwners, $chunkSize, true);
				$totalChunks = count($ownerChunks);
				$chunkIdx = 0;

				foreach ($ownerChunks as $chunk) {
					$chunkIdx++;
					$chunkData = $data;
					$chunkData['ownerDetails'] = $chunk;
					$chunkData['is_chunk'] = true;
					$chunkData['force_page_break_last'] = ($chunkIdx < $totalChunks);

					$html = $this->load->view('admin/misbroadsheetreport/deduction_report_pdf', $chunkData, TRUE);
					$this->m_pdf->pdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
				}
			} else {
				$html = '<div style="text-align:center; padding:50px; font-size:16px;">माहिती उपलब्ध नाही (No Data Available)</div>';
				$this->m_pdf->pdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
			}

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
			$postData = $this->input->post();
			$data = array();
			
			$searchData = array();
			if($postData){
				$searchData = $postData;
				$searchData['pay_center'] = $postData['pay_center'];
				$searchData['emp_id'] = $postData['emp_id'];
				$searchData['year'] = $postData['year'];
				
				$searchData['first_year'] = $postData['year'];
				$searchData['second_year'] = $postData['year'] + 1;
				$searchData['f_year'] = $searchData['first_year'] . "-" . $searchData['second_year'];
			}
			
			if(is_array($searchData) && !empty($searchData['emp_id']) && !empty($searchData['year'])){
				$data['searchData'] = $searchData;
				
				$empDetails = $this->mrModel->gerMasterDetails($searchData['emp_id']);
				if(!empty($empDetails)){
					$data['ownerDetail'] = $empDetails[0];
				}
				
				$finalLedgerData = $this->mrModel->getFinalLedgerCumulativeRows($searchData);
				
				if(!empty($finalLedgerData) && isset($finalLedgerData[$searchData['emp_id']])){
					$ledger = $finalLedgerData[$searchData['emp_id']];
					
					$opening = (int)$ledger['opening_balance'];
					$tot = $ledger['totals'];
					
					$dcpsDetails = array();
					$monthsOrder = array(4, 5, 6, 7, 8, 9, 10, 11, 12, 1, 2, 3);
					foreach ($monthsOrder as $m) {
						$dcpsDetails[$m] = array(
							'emp_DCPS_contribution' => 0,
							'NMC_DCPS_contribution' => 0,
							'loan_installment_paid_through_salary' => 0,
							'total_contribution' => 0,
							'DCPS_loan_taken_by_an_employee' => 0,
							'interest_base' => 0,
							'interest' => 0
						);
					}
					
					// Running balance starting at opening
					$runningTotalBase = $opening;
					
					// Group by month
					$monthGroups = array();
					foreach ($ledger['rows'] as $row) {
						$m = (int)$row['month'];
						if (!isset($monthGroups[$m])) {
							$monthGroups[$m] = array();
						}
						$monthGroups[$m][] = $row;
					}
					
					foreach ($monthsOrder as $m) {
						if (!isset($monthGroups[$m])) {
							continue;
						}
						
						$mRows = $monthGroups[$m];
						
						$emp_reg_supp = 0;
						$nmc_reg_supp = 0;
						$loan_installment = 0;
						$loan_taken = 0;
						$month_interest = 0;
						
						foreach ($mRows as $row) {
							$emp_reg_supp += ($row['emp_regular'] + $row['emp_supp']);
							$nmc_reg_supp += ($row['nmc_regular'] + $row['nmc_supp']);
							$loan_installment += $row['loan_installment'];
							$loan_taken += $row['loan_taken'];
							$month_interest += $row['total_interest'];
						}
						
						$dcpsDetails[$m]['emp_DCPS_contribution'] = $emp_reg_supp;
						$dcpsDetails[$m]['NMC_DCPS_contribution'] = $nmc_reg_supp;
						$dcpsDetails[$m]['loan_installment_paid_through_salary'] = $loan_installment;
						$dcpsDetails[$m]['total_contribution'] = $emp_reg_supp + $nmc_reg_supp;
						$dcpsDetails[$m]['DCPS_loan_taken_by_an_employee'] = $loan_taken;
						$dcpsDetails[$m]['interest'] = $month_interest;
						
						// In final ledger, the base is computed month-wise based on running balance:
						// Let's compute the monthly base using the same math:
						// Month base = opening balance of this month + deposits for this month
						$monthDeposits = $emp_reg_supp + $nmc_reg_supp + $loan_installment;
						$dcpsDetails[$m]['interest_base'] = $runningTotalBase + $monthDeposits;
						
						// Update running total base for next month
						$runningTotalBase = $runningTotalBase + $monthDeposits - $loan_taken + $month_interest;
					}
					
					$data['dcpsDetails'] = $dcpsDetails;
					
					$data['interestDetail'] = array(
						'opening_balance' => $opening,
						'emp_contri' => (int)$tot['emp_regular'] + (int)$tot['emp_supp'] + (int)$tot['loan_installment'],
						'nmc_contri' => (int)$tot['nmc_regular'] + (int)$tot['nmc_supp'],
						'total_contri' => $opening + (int)$tot['emp_regular'] + (int)$tot['emp_supp'] + (int)$tot['loan_installment'] + (int)$tot['nmc_regular'] + (int)$tot['nmc_supp'],
						'loan_amount' => (int)$tot['loan_taken'],
						'interest' => (int)$tot['total_interest'],
						'grand_total' => $opening + (int)$tot['emp_regular'] + (int)$tot['emp_supp'] + (int)$tot['loan_installment'] + (int)$tot['nmc_regular'] + (int)$tot['nmc_supp'] - (int)$tot['loan_taken'] + (int)$tot['total_interest']
					);
				}
				
				$data['interestRates'] = $this->mrModel->getInterestRates($searchData['first_year'], $searchData['second_year']);
			}
			
			$data['paycenterData'] = $this->mrModel->getPayCenterData();
			$data['employeeData'] = $this->mrModel->gerMasterDetails();
			
			$this->load->view('admin/common/header');
			$this->load->view('admin/misbroadsheetreport/broad_sheet', $data);
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
			ini_set('pcre.backtrack_limit', '50000000');
			ini_set('memory_limit', '2048M');
			set_time_limit(1800);

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
		
		public function yearwise_ledger_summary_report()
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
				
				// Fetch the single employee master details
				$empDetails = $this->mrModel->gerMasterDetails($searchData['emp_id']);
				if(!empty($empDetails)){
					$data['ownerDetails'][$searchData['emp_id']] = [
						'emp_id' => $empDetails[0]['emp_id'],
						'designation_name' => $empDetails[0]['designation_name'],
						'emp_name' => $empDetails[0]['emp_name'],
						'joining_date' => $empDetails[0]['joining_date'],
						'pay_center' => $empDetails[0]['pay_center'],
					];
				}
				
				// Fetch year-wise ledger summary values for the employee
				$data['yearwiseSummary'] = $this->mrModel->getYearwiseLedgerSummary($searchData['emp_id']);
			}
			$data['paycenterData'] = $this->mrModel->getPayCenterData();
			$data['employeeData'] = $this->mrModel->gerMasterDetails();
			
			if(isset($urlAry['option']) && $urlAry['option'] == "excel"){
				$filename = "yearwise_ledger_summary_report_".date("Ymd_His").".xls";
				header("Content-Type: application/vnd.ms-excel; charset=utf-8");
				header("Content-Disposition: attachment; filename=".$filename);
				header("Pragma: no-cache");
				header("Expires: 0");
				
				echo $this->load->view('admin/misbroadsheetreport/yearwise_ledger_summary_report_pdf', $data, true);
				exit;
			}

			//echo "<pre>"; print_r($data); exit;
			
			$this->load->view('admin/common/header');
			$this->load->view('admin/misbroadsheetreport/yearwise_ledger_summary_report', $data);
		}
		
		public function generate_yearwise_summary_report_mpdf()
		{
			ini_set('pcre.backtrack_limit', '50000000');
			ini_set('memory_limit', '2048M');
			set_time_limit(1800);

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
				
				$empDetails = $this->mrModel->gerMasterDetails($searchData['emp_id']);
				if(!empty($empDetails)){
					$data['ownerDetails'][$searchData['emp_id']] = [
						'emp_id' => $empDetails[0]['emp_id'],
						'designation_name' => $empDetails[0]['designation_name'],
						'emp_name' => $empDetails[0]['emp_name'],
						'joining_date' => $empDetails[0]['joining_date'],
						'pay_center' => $empDetails[0]['pay_center'],
					];
				}
				
				$data['yearwiseSummary'] = $this->mrModel->getYearwiseLedgerSummary($searchData['emp_id']);
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
			
			$this->m_pdf->pdf->SetTitle('Year-wise Ledger Summary Report');
			$this->m_pdf->pdf->SetAuthor('NMC');
			$this->m_pdf->pdf->SetCreator('Pension System');
			
			$html = $this->load->view('admin/misbroadsheetreport/yearwise_ledger_summary_report_pdf', $data, TRUE);
			
			$this->m_pdf->pdf->WriteHTML($html);
			
			$this->m_pdf->pdf->Output('Yearwise_Ledger_Summary_Report.pdf', 'I');
		}
		
	}
	
?>