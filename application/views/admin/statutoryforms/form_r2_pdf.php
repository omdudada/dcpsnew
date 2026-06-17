<style>
	body{ font-family: sans-serif; font-size: 10px; }
	table{ width:100%; border-collapse: collapse; }
	th,td{ border:1px solid #444; padding:3px 4px; }
	th{ background:#e6e6e6; }
	.r{ text-align:right; } .c{ text-align:center; }
	.ddo{ background:#dceffb; } .sub{ background:#f2f2f2; }
	h3,h4,p{ margin:2px 0; }
</style>
<div class="c">
	<h3>CONSOLIDATED RECEIPT-CUM-SCHEDULE FOR S.A.G. &ndash; 120 MISCELLANEOUS DEPOSITS (FORM-R-2)</h3>
	<h4>For the month of <?php echo html_escape($month_name.' '.$year); ?></h4>
</div>
<table>
	<thead>
		<tr>
			<th>Sr.</th><th>PRAN</th><th>Name of Employee</th>
			<th class="r">Employee Contribution</th><th class="r">Employer (NMC) Contribution</th>
			<th class="r">Total</th><th>Voucher No./Date</th>
		</tr>
	</thead>
	<tbody>
		<?php $gEmp=0; $gNmc=0; $sr=1;
		if(!empty($grouped)): foreach($grouped as $ddo => $g): ?>
		<tr class="ddo"><td colspan="7"><strong>DDO / Pay Center: <?php echo html_escape($ddo); ?></strong></td></tr>
		<?php foreach($g['rows'] as $r): $tot=(float)$r['emp_contribution']+(float)$r['nmc_contribution']; ?>
		<tr>
			<td class="c"><?php echo $sr++; ?></td>
			<td><?php echo html_escape($r['emp_td']); ?></td>
			<td><?php echo html_escape($r['emp_name']); ?></td>
			<td class="r"><?php echo number_format((float)$r['emp_contribution'],2); ?></td>
			<td class="r"><?php echo number_format((float)$r['nmc_contribution'],2); ?></td>
			<td class="r"><?php echo number_format($tot,2); ?></td>
			<td><?php echo html_escape($r['voucher_no'].' / '.$r['voucher_date']); ?></td>
		</tr>
		<?php endforeach; ?>
		<tr class="sub">
			<th colspan="3" class="r">Sub-total (<?php echo html_escape($ddo); ?>)</th>
			<th class="r"><?php echo number_format($g['emp_total'],2); ?></th>
			<th class="r"><?php echo number_format($g['nmc_total'],2); ?></th>
			<th class="r"><?php echo number_format($g['emp_total']+$g['nmc_total'],2); ?></th>
			<th></th>
		</tr>
		<?php $gEmp += $g['emp_total']; $gNmc += $g['nmc_total']; endforeach; ?>
		<tr>
			<th colspan="3" class="r">GRAND TOTAL</th>
			<th class="r"><?php echo number_format($gEmp,2); ?></th>
			<th class="r"><?php echo number_format($gNmc,2); ?></th>
			<th class="r"><?php echo number_format($gEmp+$gNmc,2); ?></th>
			<th></th>
		</tr>
		<?php else: ?>
		<tr><td colspan="7" class="c">No records.</td></tr>
		<?php endif; ?>
	</tbody>
</table>
<p style="margin-top:40px; text-align:right;"><strong>Signature</strong><br>Treasury Officer</p>
