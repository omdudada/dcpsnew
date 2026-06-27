<link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>">

<div class="content-wrapper" style="min-height:970px;height:auto !important;">
	<section class="content-header"><div class="heading-icon-badge"><img src="<?php echo base_url('assets/images/file.png'); ?>" alt="Treasury Day Book"></div><h1>Treasury Day Book</h1></section>
	<section class="content"><div class="box"><div class="box-body">

		<?php $this->load->view('admin/statutoryforms/_filter', array(
			'action' => base_url('admin/statutory-forms/day-book'),
			'show'   => array('month','year','pay_center'),
			'months' => $months, 'years' => $years, 'pay_centers' => $pay_centers,
			'month'  => $month, 'year' => $year, 'pay_center' => $pay_center,
		)); ?>

		<?php if($month && $year): ?>
		<div class="text-center">
			<h4 style="margin:0;">DAY BOOK FOR THE MONTH OF <?php echo strtoupper(html_escape($month_name.' '.$year)); ?></h4>
			<p>(To be filled in from List of Receipts)
			   <?php if($pay_center): ?> &nbsp;|&nbsp; Pay Center / DDO: <strong><?php echo html_escape($pay_center); ?></strong><?php endif; ?></p>
		</div>

		<div class="table-responsive">
			<table class="table table-bordered" style="font-size:13px; max-width:800px; margin:auto;">
				<thead class="bg-primary">
					<tr>
						<th>Sr.</th><th>Date</th>
						<th class="text-right">Contribution Received (Current Month)</th>
						<th class="text-right">Progressive Total</th>
						<th>Remarks</th>
					</tr>
				</thead>
				<tbody>
					<?php $i=1; $prog=0;
					if(!empty($rows)): foreach($rows as $r): $prog += (float)$r['amount']; ?>
					<tr>
						<td><?php echo $i++; ?></td>
						<td><?php echo html_escape($r['voucher_date'] ?: 'Unspecified'); ?></td>
						<td class="text-right"><?php echo number_format((float)$r['amount'],2); ?></td>
						<td class="text-right"><?php echo number_format($prog,2); ?></td>
						<td></td>
					</tr>
					<?php endforeach; else: ?>
					<tr><td colspan="5" class="text-center">No receipts for the selected month/year.</td></tr>
					<?php endif; ?>
				</tbody>
				<?php if(!empty($rows)): ?>
				<tfoot>
					<tr class="bg-primary">
						<th colspan="2" class="text-right">TOTAL Rs.</th>
						<th class="text-right"><?php echo number_format($prog,2); ?></th>
						<th colspan="2"></th>
					</tr>
				</tfoot>
				<?php endif; ?>
			</table>
		</div>
		<div style="margin-top:40px;text-align:right;"><strong>Signature</strong><br>Treasury Officer</div>
		<?php endif; ?>
	</div></div></section>
</div>
