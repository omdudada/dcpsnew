<?php //echo "<pre>";print_r($year);die(); ?>
<div class="container">
<!-- <form action="" method="post" name="typicaltypes" id="typicaltypes" enctype="multipart/form-data" novalidate="novalidate">
  <div class="form-row">
     
    <div class="form-group col-md-4">
      <label for="title" class="form-label">Opening Balance</label>
      <div class="controls">
        <input type="text" value="<?php $end = end($opBalData); echo round($end['opening_balance'],2); ?>" class="form-control" size="54" placeholder="" readonly>
      </div>
    </div>  
  </div>
    
</form> -->
  
</div>
<div class="searchTable">
<table id="" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	<!--<thead class="bg-primary">-->
	<!--	<tr>-->
	<!--		<th class="">Month</th>-->
	<!--		<th class="">Year</th>-->
	<!--		<th class="">Basic</th>-->
	<!--		<th class="">Grade Pay</th>-->
	<!--		<th class="">Da</th>-->
	<!--		<th class="">Total Basic</th>-->
	<!--		<th class="">Cont Emp10%</th>-->
	<!--		<th class="">Cont NMC10%</th>-->
	<!--		<th class="">Withdrawal</th>-->
	<!--		<th class="">Bal</th>-->
	<!--		<th class="">Int%</th>-->
	<!--		<th class="">Int-Amt</th>-->
	<!--		<th class="">Balwithint</th>-->
	<!--	</tr>-->
	<!--</thead>-->
	
	
	<table class="table table-striped table-bordered table-hover">

  <tbody>
    <tr>
      <th scope="row" style="background-color:#3C8DBC;color:#fff"> Month </th>
      <td>Apr</td>
      <td>May</td>
      <td>June </td>
      <td>July </td>
      <td>Aug</td>
      <td>Sept </td>
      <td>Oct</td>
      <td>Nov</td>
      <td>Dec</td>
      <td>Jan</td>
      <td>Feb</td>
      <td>Mar</td>
    </tr>
    <tr>
    	<th scope="row" style="background-color:#3C8DBC;color:#fff"> Year </th>
    	<td><?php echo $year; ?></td>
      <td><?php echo $year; ?></td>
      <td><?php echo $year; ?></td>
      <td><?php echo $year; ?></td>
      <td><?php echo $year; ?></td>
      <td><?php echo $year; ?></td>
      <td><?php echo $year; ?></td>
      <td><?php echo $year; ?></td>
      <td><?php echo $year; ?></td>
      <td><?php echo $year + 1; ?></td>
      <td><?php echo $year + 1; ?></td>
      <td><?php echo $year + 1; ?></td>
    	
    </tr>

    <tr>
      <th scope="row" style="background-color:#3C8DBC;color:#fff"> Rate Of Interest  </th>
      <td><?php foreach ($grData as  $row) { 
            if ($row['gr_month'] == 4 && $row['gr_year'] == $year) {
              echo $row['gr_percentage'];
              $grApr = $row['gr_percentage'];
            }
          } ?>%</td>
      <td><?php foreach ($grData as  $row) { 
            if ($row['gr_month'] == 5 && $row['gr_year'] == $year) {
              echo $row['gr_percentage'];
              $grMay = $row['gr_percentage'];
            }
          } ?>%</td>
      <td><?php foreach ($grData as  $row) { 
            if ($row['gr_month'] == 6 && $row['gr_year'] == $year) {
              echo $row['gr_percentage'];
              $grJune = $row['gr_percentage'];
            }
          } ?>%</td>
      <td><?php foreach ($grData as  $row) { 
            if ($row['gr_month'] == 7 && $row['gr_year'] == $year) {
              echo $row['gr_percentage'];
              $grJuly = $row['gr_percentage'];
            }
          } ?>%</td>
      <td><?php foreach ($grData as  $row) { 
            if ($row['gr_month'] == 8 && $row['gr_year'] == $year) {
              echo $row['gr_percentage'];
              $grAug = $row['gr_percentage'];
            }
          } ?>%</td>
      <td><?php foreach ($grData as  $row) { 
            if ($row['gr_month'] == 9 && $row['gr_year'] == $year) {
              echo $row['gr_percentage'];
              $grSept = $row['gr_percentage'];
            }
          } ?>%</td>
      <td><?php foreach ($grData as  $row) { 
            if ($row['gr_month'] == 10 && $row['gr_year'] == $year) {
              echo $row['gr_percentage'];
              $grOct = $row['gr_percentage'];
            }
          } ?>%</td>
      <td><?php foreach ($grData as  $row) { 
            if ($row['gr_month'] == 11 && $row['gr_year'] == $year) {
              echo $row['gr_percentage'];
              $grNov = $row['gr_percentage'];
            }
          } ?>%</td>
      <td><?php foreach ($grData as  $row) { 
            if ($row['gr_month'] == 12 && $row['gr_year'] == $year) {
              echo $row['gr_percentage'];
              $grDec = $row['gr_percentage'];
            }
          } ?>%</td>
      <td><?php foreach ($grData as  $row) { 
          $nxtYear = $year +1;
            if ($row['gr_month'] == 1 && $row['gr_year'] == $nxtYear) {
              echo $row['gr_percentage'];
              $grJan = $row['gr_percentage'];
            }
          } ?>%</td>
      <td><?php foreach ($grData as  $row) { 
            if ($row['gr_month'] == 2 && $row['gr_year'] == $nxtYear) {
              echo $row['gr_percentage'];
              $grFeb = $row['gr_percentage'];
            }
          } ?>%</td>
      <td><?php foreach ($grData as  $row) { 
            if ($row['gr_month'] == 3 && $row['gr_year'] == $nxtYear) {
              echo $row['gr_percentage'];
              $grMar = $row['gr_percentage'];
            }
          } ?>%</td>
      
    </tr>

    <tr>
      <th scope="row" style="background-color:#3C8DBC;color:#fff">Basic</th>
      <td><?php echo $data['basic_apr']; ?></td>
      <td><?php echo $data['basic_may']; ?></td>
      <td><?php echo $data['basic_june']; ?></td>
      <td><?php echo $data['basic_july']; ?></td>
      <td><?php echo $data['basic_aug']; ?></td>
      <td><?php echo $data['basic_sept']; ?></td>
      <td><?php echo $data['basic_oct']; ?></td>
      <td><?php echo $data['basic_nov']; ?></td>
      <td><?php echo $data['basic_dec']; ?></td>
      <td><?php echo $data['basic_jan']; ?></td>
      <td><?php echo $data['basic_feb']; ?></td>
      <td><?php echo $data['basic_mar']; ?></td>
      
    </tr>

    <tr>
      <th scope="row" style="background-color:#3C8DBC;color:#fff">Grade Pay</th>
      <td><?php echo $data['grade_pay_apr']; ?></td>
      <td><?php echo $data['grade_pay_may']; ?></td>
      <td><?php echo $data['grade_pay_june']; ?></td>
      <td><?php echo $data['grade_pay_july']; ?></td>
      <td><?php echo $data['grade_pay_aug']; ?></td>
      <td><?php echo $data['grade_pay_sept']; ?></td>
      <td><?php echo $data['grade_pay_oct']; ?></td>
      <td><?php echo $data['grade_pay_nov']; ?></td>
      <td><?php echo $data['grade_pay_dec']; ?></td>
      <td><?php echo $data['grade_pay_jan']; ?></td>
      <td><?php echo $data['grade_pay_feb']; ?></td>
      <td><?php echo $data['grade_pay_mar']; ?></td>
    </tr>

    <tr>
      <th scope="row" style="background-color:#3C8DBC;color:#fff">D.A.</th>
      <td><?php echo $data['da_apr']; ?></td>
      <td><?php echo $data['da_may']; ?></td>
      <td><?php echo $data['da_june']; ?></td>
      <td><?php echo $data['da_july']; ?></td>
      <td><?php echo $data['da_aug']; ?></td>
      <td><?php echo $data['da_sept']; ?></td>
      <td><?php echo $data['da_oct']; ?></td>
      <td><?php echo $data['da_nov']; ?></td>
      <td><?php echo $data['da_dec']; ?></td>
      <td><?php echo $data['da_jan']; ?></td>
      <td><?php echo $data['da_feb']; ?></td>
      <td><?php echo $data['da_mar']; ?></td>
    </tr>

    <tr>
      <th scope="row" style="background-color:#3C8DBC;color:#fff">Total Pay</th>
      <td><?php $aprTotal = $data['basic_apr']+$data['grade_pay_apr']+$data['da_apr'];echo $aprTotal; ?></td>
      <td><?php $mayTotal = $data['basic_may']+$data['grade_pay_may']+$data['da_may'];echo $mayTotal; ?></td>
      <td><?php $juneTotal = $data['basic_june']+$data['grade_pay_june']+$data['da_june'];echo $juneTotal; ?></td>
      <td><?php $julyTotal = $data['basic_july']+$data['grade_pay_july']+$data['da_july'];echo $julyTotal; ?></td>
      <td><?php $augTotal = $data['basic_aug']+$data['grade_pay_aug']+$data['da_aug'];echo $augTotal; ?></td>
      <td><?php $septTotal = $data['basic_sept']+$data['grade_pay_sept']+$data['da_sept'];echo $septTotal; ?></td>
      <td><?php $octTotal = $data['basic_oct']+$data['grade_pay_oct']+$data['da_oct'];echo $octTotal; ?></td>
      <td><?php $novTotal = $data['basic_nov']+$data['grade_pay_nov']+$data['da_nov'];echo $novTotal; ?></td>
      <td><?php $decTotal = $data['basic_dec']+$data['grade_pay_dec']+$data['da_dec'];echo $decTotal; ?></td>
      <td><?php $janTotal = $data['basic_jan']+$data['grade_pay_jan']+$data['da_jan'];echo $janTotal; ?></td>
      <td><?php $febTotal = $data['basic_feb']+$data['grade_pay_feb']+$data['da_feb'];echo $febTotal; ?></td>
      <td><?php $marTotal = $data['basic_mar']+$data['grade_pay_mar']+$data['da_mar'];echo $marTotal; ?></td>
    </tr>

    <tr>
      <th scope="row" style="background-color:#3C8DBC;color:#fff">Employee Contribution (10%)</th>
      <td><?php $conEmpApr = $data['emp_DCPS_contribution_apr']+$data['emp_DCPS_supplimentory_contribution_apr']; echo $conEmpApr;?></td>
      <td><?php $conEmpMay = $data['emp_DCPS_contribution_may']+$data['emp_DCPS_supplimentory_contribution_may']; echo $conEmpMay;?></td>
      <td><?php $conEmpJune = $data['emp_DCPS_contribution_june']+$data['emp_DCPS_supplimentory_contribution_june']; echo $conEmpJune;?></td>
      <td><?php $conEmpJuly = $data['emp_DCPS_contribution_july']+$data['emp_DCPS_supplimentory_contribution_july']; echo $conEmpJuly;?></td>
      <td><?php $conEmpAug = $data['emp_DCPS_contribution_aug']+$data['emp_DCPS_supplimentory_contribution_aug'];echo $conEmpAug;?></td>
      <td><?php $conEmpSept = $data['emp_DCPS_contribution_sept']+$data['emp_DCPS_supplimentory_contribution_sept'];echo $conEmpSept;?></td>
      <td><?php $conEmpOct = $data['emp_DCPS_contribution_oct']+$data['emp_DCPS_supplimentory_contribution_oct'];echo $conEmpOct;?></td>
      <td><?php $conEmpNov = $data['emp_DCPS_contribution_nov']+$data['emp_DCPS_supplimentory_contribution_nov'];echo $conEmpNov;?></td>
      <td><?php $conEmpDec = $data['emp_DCPS_contribution_dec']+$data['emp_DCPS_supplimentory_contribution_dec'];echo $conEmpDec;?></td>
      <td><?php $conEmpJan = $data['emp_DCPS_contribution_jan']+$data['emp_DCPS_supplimentory_contribution_jan'];echo $conEmpJan;?></td>
      <td><?php $conEmpFeb = $data['emp_DCPS_contribution_feb']+$data['emp_DCPS_supplimentory_contribution_feb'];echo $conEmpFeb;?></td>
      <td><?php $conEmpMar = $data['emp_DCPS_contribution_mar']+$data['emp_DCPS_supplimentory_contribution_mar'];echo $conEmpMar;?></td>
      
    </tr>

    <tr>
      <th scope="row" style="background-color:#3C8DBC;color:#fff">NMC Contribution (10%)</th>
      <td><?php $conNMCApr = $data['NMC_DCPS_contribution_apr']+$data['NMC_supplimentory_DCPS_contribution_apr'];echo $conNMCApr;?></td>
      <td><?php $conNMCMay = $data['NMC_DCPS_contribution_may']+$data['NMC_supplimentory_DCPS_contribution_may'];echo $conNMCMay;?></td>
      <td><?php $conNMCJune = $data['NMC_DCPS_contribution_june']+$data['NMC_supplimentory_DCPS_contribution_june'];echo $conNMCJune;?></td>
      <td><?php $conNMCJuly = $data['NMC_DCPS_contribution_july']+$data['NMC_supplimentory_DCPS_contribution_july'];echo $conNMCJuly;?></td>
      <td><?php $conNMCAug = $data['NMC_DCPS_contribution_aug']+$data['NMC_supplimentory_DCPS_contribution_aug'];echo $conNMCAug;?></td>
      <td><?php $conNMCSept = $data['NMC_DCPS_contribution_sept']+$data['NMC_supplimentory_DCPS_contribution_sept'];echo $conNMCSept;?></td>
      <td><?php $conNMCOct = $data['NMC_DCPS_contribution_oct']+$data['NMC_supplimentory_DCPS_contribution_oct'];echo $conNMCOct;?></td>
      <td><?php $conNMCNov = $data['NMC_DCPS_contribution_nov']+$data['NMC_supplimentory_DCPS_contribution_nov'];echo $conNMCNov;?></td>
      <td><?php $conNMCDec = $data['NMC_DCPS_contribution_dec']+$data['NMC_supplimentory_DCPS_contribution_dec'];echo $conNMCDec;?></td>
      <td><?php $conNMCJan = $data['NMC_DCPS_contribution_jan']+$data['NMC_supplimentory_DCPS_contribution_jan'];echo $conNMCJan;?></td>
      <td><?php $conNMCFeb = $data['NMC_DCPS_contribution_feb']+$data['NMC_supplimentory_DCPS_contribution_feb'];echo $conNMCFeb;?></td>
      <td><?php $conNMCMar = $data['NMC_DCPS_contribution_mar']+$data['NMC_supplimentory_DCPS_contribution_mar'];echo $conNMCMar;?></td>
    </tr>

    <tr>
      <th scope="row" style="background-color:#3C8DBC;color:#fff">Total Contribution</th>
      <td><?php $totalContApr = $conEmpApr+$conNMCApr;echo $totalContApr; ?></td>
      <td><?php $totalContMay = $conEmpMay+$conNMCMay;echo $totalContMay; ?></td>
      <td><?php $totalContJune = $conEmpJune+$conNMCJune;echo $totalContJune; ?></td>
      <td><?php $totalContJuly = $conEmpJuly+$conNMCJuly;echo $totalContJuly; ?></td>
      <td><?php $totalContAug = $conEmpAug+$conNMCAug;echo $totalContAug; ?></td>
      <td><?php $totalContSept = $conEmpSept+$conNMCSept;echo $totalContSept; ?></td>
      <td><?php $totalContOct = $conEmpOct+$conNMCOct;echo $totalContOct; ?></td>
      <td><?php $totalContNov = $conEmpNov+$conNMCNov;echo $totalContNov; ?></td>
      <td><?php $totalContDec = $conEmpDec+$conNMCDec;echo $totalContDec; ?></td>
      <td><?php $totalContJan = $conEmpJan+$conNMCJan;echo $totalContJan; ?></td>
      <td><?php $totalContFeb = $conEmpFeb+$conNMCFeb;echo $totalContFeb; ?></td>
      <td><?php $totalContMar = $conEmpMar+$conNMCMar;echo $totalContMar; ?></td>
      
    </tr>

    <tr>
      <th scope="row" style="background-color:#3C8DBC;color:#fff">Withdrawal (Retire/Volintary/Death)</th>
      <td><?php echo $data['DCPS_loan_taken_by_an_employee_apr']; ?></td>
      <td><?php echo $data['DCPS_loan_taken_by_an_employee_may']; ?></td>
      <td><?php echo $data['DCPS_loan_taken_by_an_employee_june']; ?></td>
      <td><?php echo $data['DCPS_loan_taken_by_an_employee_july']; ?></td>
      <td><?php echo $data['DCPS_loan_taken_by_an_employee_aug']; ?></td>
      <td><?php echo $data['DCPS_loan_taken_by_an_employee_sept']; ?></td>
      <td><?php echo $data['DCPS_loan_taken_by_an_employee_oct']; ?></td>
      <td><?php echo $data['DCPS_loan_taken_by_an_employee_nov']; ?></td>
      <td><?php echo $data['DCPS_loan_taken_by_an_employee_dec']; ?></td>
      <td><?php echo $data['DCPS_loan_taken_by_an_employee_jan']; ?></td>
      <td><?php echo $data['DCPS_loan_taken_by_an_employee_feb']; ?></td>
      <td><?php echo $data['DCPS_loan_taken_by_an_employee_mar']; ?></td>
      
    </tr>

    <tr>
      <th scope="row" style="background-color:#3C8DBC;color:#fff">Total</th>
      <td><?php $opBal = 0; $totalApr = $opBal + $totalContApr - $data['DCPS_loan_taken_by_an_employee_apr']; echo $totalApr;?></td>
      <td><?php $totalMay = $totalApr + $totalContMay - $data['DCPS_loan_taken_by_an_employee_may']; echo $totalMay;?></td>
      <td><?php $totalJune = $totalMay + $totalContJune - $data['DCPS_loan_taken_by_an_employee_june']; echo $totalJune;?></td>
      <td><?php $totalJuly = $totalJune + $totalContJuly - $data['DCPS_loan_taken_by_an_employee_july']; echo $totalJuly;?></td>
      <td><?php $totalAug = $totalJuly + $totalContAug - $data['DCPS_loan_taken_by_an_employee_aug']; echo $totalAug;?></td>
      <td><?php $totalSept = $totalAug + $totalContSept - $data['DCPS_loan_taken_by_an_employee_sept']; echo $totalSept;?></td>
      <td><?php $totalOct = $totalSept + $totalContOct - $data['DCPS_loan_taken_by_an_employee_oct']; echo $totalOct;?></td>
      <td><?php $totalNov = $totalOct + $totalContNov - $data['DCPS_loan_taken_by_an_employee_nov']; echo $totalNov;?></td>
      <td><?php $totalDec = $totalNov + $totalContDec - $data['DCPS_loan_taken_by_an_employee_dec']; echo $totalDec;?></td>
      <td><?php $totalJan = $totalDec + $totalContJan - $data['DCPS_loan_taken_by_an_employee_jan']; echo $totalJan;?></td>
      <td><?php $totalFeb = $totalJan + $totalContFeb - $data['DCPS_loan_taken_by_an_employee_feb']; echo $totalFeb;?></td>
      <td><?php $totalMar = $totalFeb + $totalContMar - $data['DCPS_loan_taken_by_an_employee_mar']; echo $totalMar;?></td>
                                  
    </tr>

    <tr>
      <th scope="row" style="background-color:#3C8DBC;color:#fff">Interest Amount</th>
      <td><?php $intAmtApr = ((($totalApr/100)/12)*$grApr);echo round($intAmtApr,2); ?></td>
      <td><?php $intAmtMay = ((($totalMay/100)/12)*$grMay);echo round($intAmtMay,2); ?></td>
      <td><?php $intAmtJune = ((($totalJune/100)/12)*$grJune);echo round($intAmtJune,2); ?></td>
      <td><?php $intAmtJuly = ((($totalJuly/100)/12)*$grJuly);echo round($intAmtJuly,2); ?></td>
      <td><?php $intAmtAug = ((($totalAug/100)/12)*$grAug);echo round($intAmtAug,2); ?></td>
      <td><?php $intAmtSept = ((($totalSept/100)/12)*$grSept);echo round($intAmtSept,2); ?></td>
      <td><?php $intAmtOct = ((($totalOct/100)/12)*$grOct);echo round($intAmtOct,2); ?></td>
      <td><?php $intAmtNov = ((($totalNov/100)/12)*$grNov);echo round($intAmtNov,2);?></td>
      <td><?php $intAmtDec = ((($totalDec/100)/12)*$grDec);echo round($intAmtDec,2); ?></td>
      <td><?php $intAmtJan = ((($totalJan/100)/12)*$grJan);echo round($intAmtJan,2); ?></td>
      <td><?php $intAmtFeb = ((($totalFeb/100)/12)*$grFeb);echo round($intAmtFeb,2); ?></td>
      <td><?php $intAmtMar = ((($totalMar/100)/12)*$grMar);echo round($intAmtMar,2); ?></td>
      
    </tr>

    <tr>
      <th scope="row" style="background-color:#3C8DBC;color:#fff">Balance With Interest</th>
      <td><?php $balwithintApr = $totalApr + $intAmtApr; echo round($balwithintApr,2); ?></td>
      <td><?php $balwithintMay = $balwithintApr + $totalContMay + $intAmtMay; echo round($balwithintMay,2); ?></td>
      <td><?php $balwithintJune = $balwithintMay + $totalContJune + $intAmtJune; echo round($balwithintJune,2); ?></td>
      <td><?php $balwithintJuly = $balwithintJune + $totalContJuly + $intAmtJuly; echo round($balwithintJuly,2); ?></td>
      <td><?php $balwithintAug = $balwithintJuly + $totalContAug + $intAmtAug; echo round($balwithintAug,2); ?></td>
      <td><?php $balwithintSept = $balwithintAug + $totalContSept + $intAmtSept; echo round($balwithintSept,2); ?></td>
      <td><?php $balwithintOct = $balwithintSept + $totalContOct + $intAmtOct; echo round($balwithintOct,2); ?></td>
      <td><?php $balwithintNov = $balwithintOct + $totalContNov + $intAmtNov; echo round($balwithintNov,2); ?></td>
      <td><?php $balwithintDec = $balwithintNov + $totalContDec + $intAmtDec; echo round($balwithintDec,2); ?></td>
      <td><?php $balwithintJan = $balwithintDec + $totalContJan + $intAmtJan; echo round($balwithintJan,2); ?></td>
      <td><?php $balwithintFeb = $balwithintJan + $totalContFeb + $intAmtFeb; echo round($balwithintFeb,2); ?></td>
      <td><?php $balwithintMar = $balwithintFeb + $totalContMar + $intAmtMar; echo round($balwithintMar,2); ?></td>
      
    </tr>

  </tbody>
</table>
	

</table>

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

<script type="text/javascript">
	$(document).ready(function(){
		$('#example').DataTable({
			"lengthMenu": [20, 40, 60, 80, 100]
		});

		
		

	});
	
</script>


