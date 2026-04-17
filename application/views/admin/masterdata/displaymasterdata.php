<?php //echo "<pre>";print_r($cdata);die(); ?>
<?php if (is_array($cdata)) {?>
	<div class="table-demand">
		<div class="table-responsive">
	<table border="0" cellpadding="0" cellspacing="0"  id="id-form" style="width:100%; margin: 20px auto; text-align: center; border-radius: 10px; border:solid 2px #347ab652; border-collapse: unset; background: #337ab742; 
	padding:15px;font-size: 15px;">
	    
		<tr style="padding:  18px; text-align: center;
    border: solid 1px #000;">
		    
			<th style="padding:  10px; text-align: left;
    border: solid 1px #000;"> Employee Id : </th>
			
			<td style="border: solid 1px #000; text-align: center;">
			    <div id="emp_td">
			        <?php echo $cdata['emp_td'];?>
			    </div>
			</td>
			
			<th style="padding:  10px; text-align: left;
    border: solid 1px #000;"> Employee Name : </th>
			<td id="emp_name" style="border: solid 1px #000; text-align: center;"><?php echo $cdata['emp_name'];?></td>
			<th style="padding:  10px; text-align: left;
    border: solid 1px #000;"> Joining Date : </th>
			<td style="border: solid 1px #000; text-align: center;"><div id= "joining_date"><?php echo $cdata['joining_date'];?></div>
			</td>
			<th style="padding:  10px; text-align: left;
    border: solid 1px #000;"> Pay Center : </th>
			<td style="border: solid 1px #000; text-align: center;"><div id="pay_center"><?php echo $cdata['pay_center'];?></div></td>
		</tr>
		<tr style="padding:  18px;">
			<th style="padding:  10px; text-align: left;
    border: solid 1px #000;"> Basic : </th>
			<td id="basic" style="border: solid 1px #000; text-align: center;"><?php echo $cdata['basic'];?></td>
			<th style="padding:  10px; text-align: left;
    border: solid 1px #000;"> Da : </th>
			<td id="da" style="border: solid 1px #000; text-align: center;"><?php echo $cdata['da'];?></td>
			<th style="padding:  10px; text-align: left;
    border: solid 1px #000;"> Grade Pay : </th>
			<td id="grade_pay" style="border: solid 1px #000; text-align: center;"><?php echo $cdata['grade_pay'];?></td>
			<th style="padding:  10px; text-align: left;
    border: solid 1px #000;"> Ideal Contribution Of Employee For DCPS : </th>
			<td id="Ideal_contribution_of_employee_for_DCPS" style="border: solid 1px #000; text-align: center;"><?php echo $cdata['Ideal_contribution_of_employee_for_DCPS'];?></td>
		</tr>
		<tr style="padding:  18px;">
			
			<th style="padding:  10px; text-align: left;
    border: solid 1px #000;"> Ideal Contribution Of NMC For DCPS : </th>
			<td id="Ideal_contribution_of_NMC_for_DCPS" style="border: solid 1px #000; text-align: center;"><?php echo $cdata['Ideal_contribution_of_NMC_for_DCPS'];?></td>
			<th style="padding:  10px; text-align: left;
    border: solid 1px #000;">Opening Balance : </th>
			<td id="opening_balance" style="border: solid 1px #000; text-align: center;"><?php echo $cdata['opening_balance'];?>
			</td>
			<th style="padding:  10px; text-align: left;
    border: solid 1px #000;">Bunch No : </th>
			<td id="bunch_no" style="border: solid 1px #000; text-align: center;"><?php echo $cdata['bunch_no'];?></td>			
			<th style="padding:  10px; text-align: left;
    border: solid 1px #000;">File No : </th>
			<td id="file_no" style="border: solid 1px #000; text-align: center;"><?php echo $cdata['file_no'];?></td>
		</tr>
		<tr style="padding:  18px;">
			
			<th style="padding:  10px; text-align: left;
    border: solid 1px #000;">Recovered DCPS  with Voucher No : </th>
			<td id="recovered_DCPS_with_voucher_no" style="border: solid 1px #000; text-align: center;"><?php echo $cdata['recovered_DCPS_with_voucher_no'];?></td>
			<th style="padding:  10px; text-align: left;
    border: solid 1px #000;"> For Month : </th>
			<td id="for_month" style="border: solid 1px #000; text-align: center;"><?php echo $cdata['for_month'];?></td>
			<th style="padding:  10px; text-align: left;
    border: solid 1px #000;">For Year : </th>
			<td id="for_year" style="border: solid 1px #000; text-align: center;"><?php echo $cdata['for_year'];?></td>
			<th style="padding:  10px; text-align: left;
    border: solid 1px #000;">Recovered DCPS  with Voucher Date : </th>
			<td id="recovered_DCPS_with_voucher_date" style="border: solid 1px #000; text-align: center;"><?php echo $cdata['recovered_DCPS_with_voucher_date'];?></td>
		</tr>
		<tr style="padding:  18px;">
			
			<th style="padding:  10px; text-align: left;
    border: solid 1px #000;">Employee's DCPS Contribution : </th>
			<td id="emp_DCPS_contribution" style="border: solid 1px #000; text-align: center;"><?php echo $cdata['emp_DCPS_contribution'];?></td>
			<th style="padding:  10px; text-align: left;
    border: solid 1px #000;"> Employee's DCPS Supplimentory Contribution : </th>
			<td id="emp_DCPS_supplimentory_contribution" style="border: solid 1px #000; text-align: center;"><?php echo $cdata['emp_DCPS_supplimentory_contribution'];?></td>
			<th style="padding:  10px; text-align: left;
    border: solid 1px #000;"> NMC's DCPS Contribution : </th>
			<td id=" NMC_DCPS_contribution " style="border: solid 1px #000; text-align: center;"><?php echo $cdata['NMC_DCPS_contribution'];?></td>
			<th style="padding:  10px; text-align: left;
    border: solid 1px #000;">NMC's Supplimentory DCPS Contribution : </th>
			<td id="NMC_supplimentory_DCPS_contribution" style="border: solid 1px #000; text-align: center;"><?php echo $cdata['NMC_supplimentory_DCPS_contribution'];?></td>
		</tr>
		<tr style="padding:  18px;">
			
			<th style="padding:  10px; text-align: left;
    border: solid 1px #000;">DCPS Loan Taken by an Employee : </th>
			<td id="DCPS_loan_taken_by_an_employee" style="border: solid 1px #000; text-align: center;"><?php echo $cdata['DCPS_loan_taken_by_an_employee'];?></td>
			<th style="padding:  10px; text-align: left;
    border: solid 1px #000;"> Loan Installment Paid Through Salary : </th>
			<td id="loan_installment_paid_through_salary" style="border: solid 1px #000; text-align: center;"><?php echo $cdata['loan_installment_paid_through_salary'];?></td>
			<th style="padding:  10px; text-align: left;
    border: solid 1px #000;"> Loan Installment Paid In Cash : </th>
			<td id=" loan_installment_paid_in_cash" style="border: solid 1px #000; text-align: center;"><?php echo $cdata['loan_installment_paid_in_cash'];?></td>
			<th style="padding:  10px; text-align: left;
    border: solid 1px #000;">Supplimentory Loan Installment Paid : </th>
			<td id="supplimentory_loan_installment_paid" style="border: solid 1px #000; text-align: center;"><?php echo $cdata['supplimentory_loan_installment_paid'];?></td>
		</tr>
		<tr style="padding:  18px;">
			
			<th style="padding:  10px; text-align: left;
    border: solid 1px #000;">Total Amount Of Loan Installments Paid : </th>
			<td id="total_amount_of_loan_installments_paid" style="border: solid 1px #000; text-align: center;"><?php echo $cdata['total_amount_of_loan_installments_paid'];?></td>
			<th style="padding:  10px; text-align: left;
    border: solid 1px #000;"> Amount To be recovered From Emp : </th>
			<td id="amount_to_be_recovered_from_emp" style="border: solid 1px #000; text-align: center;"><?php echo $cdata['amount_to_be_recovered_from_emp'];?></td>
			<th style="padding:  10px; text-align: left;
    border: solid 1px #000;"> To be recovered for voucher No : </th>
			<td id=" to_be_recovered_for_voucher_no" style="border: solid 1px #000; text-align: center;"><?php echo $cdata['to_be_recovered_for_voucher_no'];?></td>
			<th style="padding:  10px; text-align: left;
    border: solid 1px #000;">To be recovered for voucher Date : </th>
			<td id="to_be_recovered_for_voucher_date" style="border: solid 1px #000; text-align: center;"><?php echo $cdata['to_be_recovered_for_voucher_date'];?></td>
		</tr>
		<tr style="padding:  18px;">
			
			<th style="padding:  10px; text-align: left;
    border: solid 1px #000;">NMC Share to be Given : </th>
			<td id="NMC_share_to_be_given" style="border: solid 1px #000; text-align: center;"><?php echo $cdata['NMC_share_to_be_given'];?></td>
			<th style="padding:  10px; text-align: left;
    border: solid 1px #000;">  Recovered with Voucher No  : </th>
			<td id=" recovered_with_voucher_no" style="border: solid 1px #000; text-align: center;"><?php echo $cdata['recovered_with_voucher_no'];?></td>
			<th style="padding:  10px; text-align: left;
    border: solid 1px #000;"> Recovered Date : </th>
			<td id=" recovered_date" style="border: solid 1px #000; text-align: center;"><?php echo $cdata['recovered_date'];?></td>
			<th style="padding:  10px; text-align: left;
    border: solid 1px #000;"> Remark : </th>
			<td id=" recovered_date" style="border: solid 1px #000; text-align: center;"><?php echo $cdata['remark'];?></td>
			
		</tr>
	</table>
	</div>
	
	<style>
		
		#consumer_no, #usage, #size_label, #owner_name, #size_label, #total_arrears{
		text-align: left;
		}
		.table-demand th{
		text-align: right;
		padding: 12px !important;
		}
		
		.table-demand td{
		text-align: left;
		}
	</style>
	
</div>


<!-- Customer recipt details -->








<?php } else{?>
	<div class="record">
		<h1>Record Not found</h1>
	</div>
<?php }
?>
<style type="text/css">
	.demandTable .table-bordered>tbody>tr>td{
		border:solid 1px #0000001a;
	}
	.record h1{
		background: #28609082;
		text-align: center;
		padding: 15px;
		color: #fff;
	}
</style>
