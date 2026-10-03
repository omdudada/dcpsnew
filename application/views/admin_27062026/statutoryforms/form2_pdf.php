<style>
	body{ font-family: sans-serif; font-size: 10px; }
	table{ width:100%; border-collapse: collapse; }
	th,td{ border:1px solid #444; padding:3px 4px; }
	th{ background:#e6e6e6; }
	.r{ text-align:right; } .c{ text-align:center; }
	h3,h4,p{ margin:2px 0; }
</style>
<div class="c">
	<h3>SCHEDULE SHOWING EMPLOYEE'S CONTRIBUTION TOWARDS TIER-I OF THE DCPS (FORM-2)</h3>
	<h4>For the month of <?php echo html_escape($month_name.' '.$year); ?>
		<?php if(!empty($pay_center)) echo ' &nbsp; | &nbsp; Pay Center / DDO: '.html_escape($pay_center); ?></h4>
</div>
<table>
	<thead>
		<tr>
			<th>Sr.</th><th>PRAN</th><th>Name of Employee</th><th>Designation</th><th>Pay Center</th>
			<th class="r">Basic Pay</th><th class="r">DP</th><th class="r">DA</th>
			<th class="r">Contribution (Tier-I)</th><th>Voucher No./Date</th>
		</tr>
	</thead>
	<tbody>
		<?php $i=1; $tBasic=$tDp=$tDa=$tCon=0;
		if(!empty($rows)): foreach($rows as $r):
			$con = ((float)$r['emp_contribution'] > 0) ? (float)$r['emp_contribution'] : (float)$r['ideal_contribution'];
			$tBasic += (float)$r['basic']; $tDp += (float)$r['dp']; $tDa += (float)$r['da']; $tCon += $con; ?>
		<tr>
			<td class="c"><?php echo $i++; ?></td>
			<td><?php echo html_escape($r['emp_td']); ?></td>
			<td><?php echo html_escape($r['emp_name']); ?></td>
			<td><?php echo html_escape($r['designation_name']); ?></td>
			<td><?php echo html_escape($r['pay_center']); ?></td>
			<td class="r"><?php echo number_format((float)$r['basic'],2); ?></td>
			<td class="r"><?php echo number_format((float)$r['dp'],2); ?></td>
			<td class="r"><?php echo number_format((float)$r['da'],2); ?></td>
			<td class="r"><?php echo number_format($con,2); ?></td>
			<td><?php echo html_escape($r['voucher_no'].' / '.$r['voucher_date']); ?></td>
		</tr>
		<?php endforeach; else: ?>
		<tr><td colspan="10" class="c">No records.</td></tr>
		<?php endif; ?>
	</tbody>
	<?php if(!empty($rows)): ?>
	<tfoot>
		<tr>
			<th colspan="5" class="r">TOTAL</th>
			<th class="r"><?php echo number_format($tBasic,2); ?></th>
			<th class="r"><?php echo number_format($tDp,2); ?></th>
			<th class="r"><?php echo number_format($tDa,2); ?></th>
			<th class="r"><?php echo number_format($tCon,2); ?></th>
			<th></th>
		</tr>
	</tfoot>
	<?php endif; ?>
</table>
<p style="margin-top:20px;">Certified that the amount of individual's deduction and the total shown above have been checked
with reference to the bill and the rate of pay shown has been verified with the amount actually drawn in the bill.</p>
<p style="margin-top:40px; text-align:right;"><strong>Signature</strong><br>Drawing &amp; Disbursing Officer</p>
