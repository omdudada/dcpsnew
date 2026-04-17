<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Cronjob extends CI_Controller {
		
		public function __construct(){
			parent::__construct();
			$this->load->model('admin/MasterdModel','mModel');
			$this->load->library('session');
		}
		
		public function index()
		{
			$interstDatas = array();
			
			$i =  $this->uri->segment(4); 
			
			if(!($i > 0)){
				echo "Please add financial year"; exit;
			}
			
			$fYear = $i."-".($i+1);
			$this->db->select('*');
			$this->db->from('dpt_yearly_interest');
			$this->db->where("f_year = '".$fYear."'");
			//$this->db->where("employee_id = 9086");
			$this->db->where('is_calculated = 0');
			//$this->db->limit(100);
			$query = $this->db->get();
			if ($query) {
				$interestDetails = $query->result_array();
			}
			
			if(isset($interestDetails) && is_array($interestDetails)){
				foreach($interestDetails as $interestDetail){
					$interstDatas[$fYear][$interestDetail['employee_id']] = $interestDetail;
				}
			}
			
			
			
			//echo $this->db->last_query(); exit;
			
			$monthDatas = array(4,5,6,7,8,9,10,11,12,1,2,3);
			//echo "<pre>"; print_r($monthArray); exit;
			//echo "<pre>"; print_r($interstDatas); exit;
			if(isset($interstDatas) && is_array($interstDatas) && !empty($interstDatas)){
				foreach($interstDatas as $year => $interstData){
					//echo "<pre>"; print_r($interstData); exit;
					list($firstYear, $secondYear) = explode("-", $year);
					//echo "firstYear=>".$firstYear.", secondYear=>".$secondYear; exit;
					
					$previousFinancialYear = ($firstYear-1)."-".$firstYear;
					
					
					# Code to get interest rate.
					$interestRateByMonths = array();
					$monthSql = "SELECT gr_month, gr_percentage FROM `dpt_gr_management` where  ((gr_month >= 4 && gr_month <= 12 and gr_year =".$firstYear.") or (gr_month >= 1 && gr_month <= 3 and gr_year =".$secondYear."))";
					//echo $monthSql; exit;
					$query = $this->db->query($monthSql);
					
					if($query){
						//echo "<pre>"; print_r($query->result()); exit;
						foreach($query->result() as $mresult){
							$interestRateByMonths[$mresult->gr_month] = $mresult->gr_percentage;
						}
					}
					
					
					foreach($interstData as $empId => $interestDetail){
						$prevOpeningBalance = $this->db->get_where('dpt_yearly_interest',array('f_year' => $previousFinancialYear, 'employee_id'=>$interestDetail['employee_id']))->row()->grand_total;
						//echo "<pre>"; print_r($interestDetail); exit;
						//echo $this->db->last_query(); exit;
						
						$prevOpeningBalanceAmount = $openingBalance = 0;
						if($prevOpeningBalance){
							$openingBalance = $prevOpeningBalanceAmount = $prevOpeningBalance;
						}
						
						//echo "prevbalance=>".$prevOpeningBalanceAmount; exit;
						
						$employeeDatas = array();
						
						$mon = 1; $monthTotalAmount = 0; $grandTotal = 0;
						
						
						
						//echo "<pre>"; print_r($interestRateByMonths); exit; 
						
						foreach($monthDatas as $monthNo){
							$sql = "SELECT `emp_td`, 
							(sum(`emp_DCPS_contribution`)+sum(emp_DCPS_supplimentory_contribution)) as emp_DCPS_contribution, 
							(sum(`NMC_DCPS_contribution`)+sum(NMC_supplimentory_DCPS_contribution)) as `NMC_DCPS_contribution`, 
							((sum(`emp_DCPS_contribution`)+sum(emp_DCPS_supplimentory_contribution))+(sum(`NMC_DCPS_contribution`)+sum(NMC_supplimentory_DCPS_contribution))+sum(loan_installment_paid_through_salary)) as total_contribution, 
							sum(`loan_installment_paid_through_salary`) as loan_installment_paid_through_salary, 
							sum(`DCPS_loan_taken_by_an_employee`) as `DCPS_loan_taken_by_an_employee`, 
							`for_month`, 
							`for_year` 
							FROM `dpt_master_dcps` where is_deleted = 0 ";
							if($monthNo >= 4 && $monthNo <= 12){
								$sql .=" and  `for_month` = ".$monthNo;
								$sql .=" and  `for_year` = ".$firstYear;
							}
							elseif($monthNo >= 1 && $monthNo <= 3){
								$sql .=" and   `for_month` = ".$monthNo;
								$sql .=" and   `for_year` = ".$secondYear;
							}
							$sql.=" AND `emp_td` = ".$interestDetail['employee_id'];
							$sql.=" group by emp_td ";
							
							$query = $this->db->query($sql);
							//echo "<br/>". $sql; 
							
							//$this->db->where('emp_td', 5914);
							
							//echo "<br/>query=>".$this->db->last_query(); //exit;
							$dcpsRow = array();
							if ($query) {
								$dcpsRow = $query->row_array();
							}
							
							//echo "<br/><pre>122222222222"; print_r($dcpsRow); exit;
							
							
							$totalAmount = $interst = 0;
							if(isset($dcpsRow) && is_array($dcpsRow) && !empty($dcpsRow)){
								
								$employeeDatas[$interestDetail['employee_id']]['id'] = $interestDetail['employee_id'];
								$employeeDatas[$interestDetail['employee_id']]['opening_balance'] = $prevOpeningBalanceAmount;
								$employeeDatas[$interestDetail['employee_id']]['emp_contri'] += $dcpsRow['emp_DCPS_contribution'];
								$employeeDatas[$interestDetail['employee_id']]['nmc_contri'] += $dcpsRow['NMC_DCPS_contribution'];
								$employeeDatas[$interestDetail['employee_id']]['total_contri'] += $dcpsRow['total_contribution'];
								$employeeDatas[$interestDetail['employee_id']]['loan_installment'] += $dcpsRow['loan_installment_paid_through_salary'];
								$employeeDatas[$interestDetail['employee_id']]['loan_amount'] += $dcpsRow['DCPS_loan_taken_by_an_employee'];
								
								$totalAmount = (($dcpsRow['total_contribution']+$openingBalance) - $dcpsRow['DCPS_loan_taken_by_an_employee']);
								
								$employeeDatas[$interestDetail['employee_id']]['total_amount'] += $totalAmount;
								
								
								$interst = ((($totalAmount+$monthTotalAmount)*($interestRateByMonths[$monthNo]/100))/12);
								
								//echo "<br/>totalAmount=>".$totalAmount.", monthTotalAmount=>".$monthTotalAmount;
								
								$employeeDatas[$interestDetail['employee_id']]['interest'] += ($interst);
								$employeeDatas[$interestDetail['employee_id']]['grand_total'] += round($totalAmount+$interst);
								
								$grandTotal += $totalAmount;
								
								
								
								$monthTotalAmount += $totalAmount;
								
								echo "<br/>Line no. 149=>totalAmount=>".$totalAmount.", monthTotalAmount=>".$monthTotalAmount;
							}
							else{
							//echo "else"; exit;	$employeeDatas[$interestDetail['employee_id']]['id'] = $interestDetail['employee_id'];
								$employeeDatas[$interestDetail['employee_id']]['emp_contri'] += 0;
								$employeeDatas[$interestDetail['employee_id']]['nmc_contri'] += 0;
								$employeeDatas[$interestDetail['employee_id']]['total_contri'] += 0;
								$employeeDatas[$interestDetail['employee_id']]['loan_installment'] += 0;
								$employeeDatas[$interestDetail['employee_id']]['loan_amount'] += 0;
								
								$totalAmount = 0;
								
								$employeeDatas[$interestDetail['employee_id']]['total_amount'] += $totalAmount;
								echo "<br/>Else Condition, line no. 167=> GrandTotal=>".$grandTotal;
								
								$interst = ((($grandTotal)*($interestRateByMonths[$monthNo]/100))/12);
								
								echo "<br/> Month No=>".$monthNo.", year=>".$secondYear; 
								
								echo "<br>Else Condition, Line No. 171=>".$interst;
								
								//echo "<br/>totalAmount=>".$totalAmount.", monthTotalAmount=>".$monthTotalAmount;
								
								$employeeDatas[$interestDetail['employee_id']]['interest'] += ($interst);
								$employeeDatas[$interestDetail['employee_id']]['grand_total'] += ($totalAmount+$interst);
								
								//$grandTotal += $totalAmount;
								
							}
							$mon++;
							
							if($mon > 1){
								$openingBalance = 0;
								
							}
							
						}
						
						//echo "<pre>"; print_r($employeeDatas); exit;
						
						$updateData = array();
						if(is_array($employeeDatas) && !empty($employeeDatas)){
							foreach($employeeDatas as $employeeData){
								$updateData['emp_contri'] =  $employeeData['emp_contri'];
								$updateData['nmc_contri'] =  $employeeData['nmc_contri'];
								$updateData['total_contri'] =  $employeeData['total_contri'];
								$updateData['loan_installment'] =  $employeeData['loan_installment'];
								$updateData['loan_amount'] =  $employeeData['loan_amount'];
								//$updateData['total_amount'] =  $employeeData['total_amount'];
								$updateData['interest'] =  round($employeeData['interest']);
								$updateData['grand_total'] =  (round($employeeData['total_amount'])+round($employeeData['interest']));
								$updateData['opening_balance'] =  ($employeeData['opening_balance']>0)?$employeeData['opening_balance']:0;
								$updateData['is_calculated'] = 1;
							}
						}
						
						//echo "<pre>"; print_r($updateData); exit;
						
						$this->db->where("id", $interestDetail['id']);
						$this->db->update("dpt_yearly_interest", $updateData);
						//echo $this->db->last_query(); exit;
						
						if($this->db->affected_rows()){
							echo "<br/><br/><br/><br/>Updated";
						}
					}
					//exit;
				}
			}
			else{
			    echo "No Data"; exit;
			}
		}
		
	}
?>