<?php //echo "<pre>";print_r($data);die(); ?>
<?php 
//$end = end($opBalData); echo "<pre>";print_r($end['opening_balance']);die; 
// $end = reset($opBalData); echo "<pre>";print_r($end['opening_balance']);die;
$start = reset($opBalData); 
$yearStartOpBal = round($start['opening_balance'],2);
// echo $yearStartOpBal;die();
?>
<div class="container">
	<form action="" method="post" name="typicaltypes" id="typicaltypes" enctype="multipart/form-data" novalidate="novalidate">
		<div class="form-row">
			<div class="form-group col-md-4">
				<label for="title" class="form-label">Employee Number</label>
				<div class="controls">
					<input type="text" name="patient_name" id="patient_name" value="<?php echo $data[0]['emp_td']; ?>" class="form-control" size="54" placeholder="" readonly>
				</div>
			</div>
            
            
			<div class="form-group col-md-8">
				<label for="title" class="form-label">Employee Name</label>
				<div class="controls">
					<input type="text" name="mobile_number" id="mobile_number" value="<?php echo $data[0]['emp_name']; ?>" class="form-control" size="54" placeholder="" readonly>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="form-group col-md-4">
				<label for="title" class="form-label">Percentage</label>
				<div class="controls">
					<input type="text" name="patient_name" id="patient_name" value="" class="form-control" size="54" placeholder="" readonly>
				</div>
			</div>
            
            
			<div class="form-group col-md-4">
				<label for="title" class="form-label">Designation</label>
				<div class="controls">
					<input type="text" name="mobile_number" id="mobile_number" value="" class="form-control" size="54" placeholder="" readonly>
				</div>
			</div>
			<div class="form-group col-md-4">
				<label for="title" class="form-label">Date Of Birth</label>
				<div class="controls">
					<input type="text" name="patient_name" id="patient_name" value="" class="form-control" size="54" placeholder="" readonly>
				</div>
			</div>
			<div class="clearfix"></div>
			
            
            
			<div class="form-group col-md-4">
				<label for="title" class="form-label">Date Of Joining</label>
				<div class="controls">
					<input type="text" name="mobile_number" id="mobile_number" value="<?php echo $data[0]['joining_date']; ?>" class="form-control" size="54" placeholder="" readonly>
				</div>
			</div>
			<div class="form-group col-md-4">
				<label for="title" class="form-label">Retirnment Date</label>
				<div class="controls">
					<input type="text" name="mobile_number" id="mobile_number" value="" class="form-control" size="54" placeholder="" readonly>
				</div>
			</div>	
			<div class="form-group col-md-4">
				<label for="title" class="form-label">Opening Balance</label>
				<div class="controls">
					<input type="text" name="mobile_number" id="mobile_number" value="<?php echo $yearStartOpBal; ?>" class="form-control" size="54" placeholder="" readonly>
				</div>
			</div>	
			
		</form>
		
	</div>
	<!-- <br><br><br><br> -->
	<div class="searchTable">
		<table id="" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
			<thead class="bg-primary">
				<tr>
					<th class="">Month</th>
					<th class="">Year</th>
					<th class="">Opening Balance</th>
					<th class="">Basic</th>
					<th class="">Grade Pay</th>
					<th class="">D.A.</th>
					<th class="">Total Basic</th>
					<th class="">Cont. Emp10%</th>
					<th class="">Cont. NMC10%</th>
					<th class="">Total</th>
					<th class="">Withdrawal</th>
					<th class="">Bal</th>
					<th class="">Int%</th>
					<th class="">Int-Amt</th>
					<th class="">Balwithint</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					//echo "<pre>";print_r($opBalData); exit;
					// $start = reset($opBalData);
					$balance = $yearStartOpBal;
					foreach ($data as $row) {?>
					<tr>
						<td><?php echo $row['month']; ?></td>
						<td><?php echo $row['for_year']; ?></td>
						<td><?php echo $balance; ?></td>
						<td><?php if($row['basic']) { echo $row['basic']; }else{echo "0";} ?></td>
						<td><?php if($row['grade_pay']){echo $row['grade_pay']; }else{echo "0";} ?></td>
						<td><?php if($row['da']) { echo $row['da']; }else{echo "0";} ?></td>
						<td><?php $totBasicGpDa = $row['basic']+$row['grade_pay']+$row['da'];echo $totBasicGpDa; ?></td>
						<td><?php $empCont = $row['emp_DCPS_contribution']+$row['emp_DCPS_supplimentory_contribution']; echo $empCont;?></td>
						<td><?php $nmcCont = $row['NMC_DCPS_contribution']+$row['NMC_supplimentory_DCPS_contribution']; echo $nmcCont;?></td>
						<td><?php $totalCon = $empCont+$nmcCont; echo $totalCon;?></td>
						<td><?php echo $data['withdrawal']; ?></td>
						<td>
							<?php 
								// echo "<br>Bal=>".$balance;
								$recBal = $balance + $totalCon; 
								echo $recBal;
							?>
						</td>
						<td><?php echo $row['gr_percentage']; ?></td>
						<td><?php 	$a = $recBal / 100; 
							$b = $a / 12;
							$intamt = $b * $row['gr_percentage'];
							$final = round($intamt,2); echo $final;
						?></td>
						<td><?php $balWithInt = $balance+$totalCon+$final;
						echo $balWithInt; ?></td>
					</tr>
					<?php 
						$totalRecBal += $recBal;
						$sumInt += $final; 
						$balance = $balWithInt;
					} 
				?>
				
				<?php   
					$totalOpBal = 0;
					$totalBasic = 0;
					$totalGradePay = 0;
					$totalDa = 0;
					$totalEmpCont = 0;
					$totalNMCCount = 0;
					$totalCon = 0;
					$totalIntAmt = 0;
					$withdrawal = 0;
					
					
					
					foreach($data as $row){
						$totalOpBal += $row['opening_balance']; 
						$totalBasic += $row['basic']; 
						$totalGradePay += $row['grade_pay']; 
						// $totalGradePay += $row['grade_pay'];
						$totalDa += $row['da'];
						$withdrawal += $row['withdrawal'];
						$totalEmpCont += $row['emp_DCPS_contribution']+$row['emp_DCPS_supplimentory_contribution'];
						$totalNMCCont += $row['NMC_DCPS_contribution']+$row['NMC_supplimentory_DCPS_contribution'];
						// $totalCon += $totalEmpCont+$totalNMCCont;
						$totalIntAmt += $final;
					}
					
				?>
			</tbody>
			<tfoot class="bg-primary">
				<tr>
					<th rowspan="2" colspan="2" style="text-align: center;">Total</th>
					
					<th class="" style="text-align: center;"></th>
					<th class="" style="text-align: center;"><?php echo $totalBasic; ?></th>
					<th style="text-align: center;"><?php echo $totalGradePay; ?></th>                                 
					<th style="text-align: center;"><?php echo $totalDa; ?></th>
					<th style="text-align: center;"><?php $grandTot = $totalBasic+$totalGradePay+$totalDa;echo $grandTot; ?></th>
					<th style="text-align: center;"><?php echo $totalEmpCont; ?></th>
					<th style="text-align: center;"><?php echo $totalNMCCont; ?></th>
					<th style="text-align: center;"><?php $totalCon = $totalEmpCont + $totalNMCCont; echo $totalCon;?></th>
					<th style="text-align: center;"><?php echo $withdrawal; ?></th>
					<th style="text-align: center;"><?php echo $totalRecBal; ?></th>
					<th style="text-align: center;"></th>
					<th style="text-align: center;"><?php echo $sumInt; ?></th>
					<th style="text-align: center;"></th>
					
				</tr>
			</tfoot>
			<!-- <tfoot class="bg-primary">
				<tr>
				<th class="th-sm">Employee Id
				</th>
				<th class="th-sm">Employee Name
				</th>
				<th class="th-sm">Month
				<th class="th-sm">Year
				</th>
				
				</tr>
			</tfoot> -->
		</table>
		
		<div class="container">
			<div class="col-md-4">
				<table id="" class="table table-striped table-bordered table-hover" cellspacing="0">
					
					<tr>
						<th style="text-align: center; background-color:#3C8DBC;color:#fff">Opening Balance</th>
						<td rowspan="" colspan="2"><?php echo $yearStartOpBal; ?></td>
					</tr>
					<tr>
						<th style="text-align: center; background-color:#3C8DBC;color:#fff">Employee Contribution (10%)</th>
						<td><?php echo $totalEmpCont; ?></td>
						<td></td>
					</tr>
					<tr>
						<th style="text-align: center; background-color:#3C8DBC;color:#fff">NMC Contribution (10%)</th>
						<td><?php echo $totalNMCCont; ?></td>
						<td></td>
					</tr>
					<tr>
						<th style="text-align: center; background-color:#3C8DBC;color:#fff">Total Contribution</th>
						<td>(+)</td>
						<td><?php echo $totCount = $totalEmpCont + $totalNMCCont; ?></td>
					</tr>
					<tr>
						<th style="text-align: center; background-color:#3C8DBC;color:#fff">Total-1</th>
						<td></td>
						<td><?php $total1 = $yearStartOpBal + $totCount; 
						echo round($total1, 2); ?>
						
						</td>
					</tr>
					<tr>
						<th style="text-align: center; background-color:#3C8DBC;color:#fff">Interest</th>
						<td>(+)</td>
						<td><?php echo $sumInt;?></td>
					</tr>
					<tr>
						<th style="text-align: center; background-color:#3C8DBC;color:#fff">Total-2</th>
						<td></td>
						<td><?php $total2 = $total1 + $sumInt; echo $total2;?></td>
					</tr>
					<tr>
						<th style="text-align: center; background-color:#3C8DBC;color:#fff">Withdrawal</th>
						<td>(-)</td>
						<td><?php echo $withdrawal; ?></td>
					</tr>
					<tr>
						<th style="text-align: center; background-color:#3C8DBC;color:#fff">Closing Balance</th>
						<td></td>
						<td><?php $closeBal =  $total2 - $withdrawal; echo $closeBal;?></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	
	<style type="text/css">
		.sorting{
		color: #fff;
		}
		.searchTable{
		text-align: center;
		margin-bottom: 10px;
		}
		.searchTable .table-bordered {
		margin-bottom: 15px;
		}
		.searchTable .table-bordered>tbody>tr>td{
		border:solid 1px #0000001a;
		}
		
		.searchTable .dataTable tfoot th, table.dataTable tfoot td{
		border-top: none !important;
		text-align: center;
		}
		.searchTable table.dataTable thead th, table.dataTable thead td{
		border-bottom: #347ab6;
		}
		.searchTable .dataTables_paginate{
		border-radius:10px;
		border: solid 2px #dee2e6;
		padding-top: 5px;
		padding-bottom:5px; 
		}
		.searchTable .dataTables_wrapper .dataTables_paginate .paginate_button.current{
		background: linear-gradient(to bottom, #007aff 0%, #007aff 100%) !important;
		color: #fff !important;
		border-color: #007bff;
		margin-left:0px;
		}
		.dataTables_wrapper .dataTables_paginate .paginate_button:hover{
		background:#007bff !important;
		border:solid 1px #e9ecef;
		color: #000;
		}
		/*.searchTable .dataTables_wrapper .dataTables_paginate .paginate_button
		:hover{
		color: #fff !important;
		background: linear-gradient(to bottom, #007aff 0%, #007aff 100%) !important;
		border:none;
		}*/
		
		.searchTable .dataTables_paginate span{
		/*border-right: solid 2px #dee2e6;*/
		/*padding: 12px;*/
		}
		.searchTable .paginate_button{
		border-right: solid 2px #dee2e6 !important;
		}
		
	</style>
	
	
	
