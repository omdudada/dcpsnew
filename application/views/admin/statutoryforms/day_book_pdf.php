<style>
	body{ font-family: sans-serif; font-size: 11px; }
	table{ width:80%; border-collapse: collapse; margin:auto; }
	th,td{ border:1px solid #444; padding:4px 6px; }
	th{ background:#e6e6e6; }
	.r{ text-align:right; } .c{ text-align:center; }
	h3,h4,p{ margin:2px 0; }
</style>
<div class="c">
	<h3>DAY BOOK FOR THE MONTH OF <?php echo strtoupper(html_escape($month_name.' '.$year)); ?> (DCPS)</h3>
	<h4>(To be filled in from List of Receipts)
		<?php if(!empty($pay_center)) echo ' | Pay Center / DDO: '.html_escape($pay_center); ?></h4>
</div>
<table>
	<thead>
		<tr><th>Sr.</th><th>Date</th><th class="r">Contribution Received</th><th class="r">Progressive Total</th><th>Remarks</th></tr>
	</thead>
	<tbody>
		<?php $i=1; $prog=0;
		if(!empty($rows)): foreach($rows as $r): $prog += (float)$r['amount']; ?>
		<tr>
			<td class="c"><?php echo $i++; ?></td>
			<td><?php echo html_escape($r['voucher_date'] ?: 'Unspecified'); ?></td>
			<td class="r"><?php echo number_format((float)$r['amount'],2); ?></td>
			<td class="r"><?php echo number_format($prog,2); ?></td>
			<td></td>
		</tr>
		<?php endforeach; else: ?>
		<tr><td colspan="5" class="c">No receipts.</td></tr>
		<?php endif; ?>
	</tbody>
	<?php if(!empty($rows)): ?>
	<tfoot>
		<tr><th colspan="2" class="r">TOTAL Rs.</th><th class="r"><?php echo number_format($prog,2); ?></th><th colspan="2"></th></tr>
	</tfoot>
	<?php endif; ?>
</table>
<p style="margin-top:40px; text-align:right;"><strong>Signature</strong><br>Treasury Officer</p>
