<link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>">

<div class="content-wrapper" style="min-height:970px;height:auto !important;">
	<section class="content-header"><div class="heading-icon-badge"><img src="<?php echo base_url('assets/images/file.png'); ?>" alt="FORM-R-2 — Consolidated Receipt-cum-Schedule"></div><h1>FORM-R-2 &ndash; Consolidated Receipt-cum-Schedule</h1></section>
	<section class="content"><div class="box"><div class="box-body">

		<?php $this->load->view('admin/statutoryforms/_filter', array(
			'action' => base_url('admin/statutory-forms/form-r2'),
			'show'   => array('month','year'),
			'months' => $months, 'years' => $years, 'pay_centers' => $pay_centers,
			'month'  => $month, 'year' => $year,
		)); ?>

		<?php if($month && $year): ?>
		<div class="text-center">
			<h4 style="margin:0;">CONSOLIDATED RECEIPT-CUM-SCHEDULE FOR S.A.G. &ndash; 120 MISCELLANEOUS DEPOSITS</h4>
			<p>For the month of <strong><?php echo html_escape($month_name.' '.$year); ?></strong></p>
		</div>

		<div class="table-responsive">
			<table class="table table-bordered" style="font-size:13px;">
				<thead class="bg-primary">
					<tr>
						<th>Sr.</th><th>PRAN</th><th>Name of Employee</th>
						<th class="text-right">Employee Contribution</th>
						<th class="text-right">Employer (NMC) Contribution</th>
						<th class="text-right">Total</th>
						<th>Voucher No. / Date</th>
					</tr>
				</thead>
				<tbody>
					<?php $gEmp=0; $gNmc=0; $sr=1;
					if(!empty($grouped)): foreach($grouped as $ddo => $g): ?>
					<tr class="bg-info"><td colspan="7"><strong>DDO / Pay Center: <?php echo html_escape($ddo); ?></strong></td></tr>
					<?php foreach($g['rows'] as $r): $tot=(float)$r['emp_contribution']+(float)$r['nmc_contribution']; ?>
					<tr>
						<td><?php echo $sr++; ?></td>
						<td><?php echo html_escape($r['emp_td']); ?></td>
						<td><?php echo html_escape($r['emp_name']); ?></td>
						<td class="text-right"><?php echo number_format((float)$r['emp_contribution'],2); ?></td>
						<td class="text-right"><?php echo number_format((float)$r['nmc_contribution'],2); ?></td>
						<td class="text-right"><?php echo number_format($tot,2); ?></td>
						<td><?php echo html_escape($r['voucher_no'].' / '.$r['voucher_date']); ?></td>
					</tr>
					<?php endforeach; ?>
					<tr class="active">
						<th colspan="3" class="text-right">Sub-total (<?php echo html_escape($ddo); ?>)</th>
						<th class="text-right"><?php echo number_format($g['emp_total'],2); ?></th>
						<th class="text-right"><?php echo number_format($g['nmc_total'],2); ?></th>
						<th class="text-right"><?php echo number_format($g['emp_total']+$g['nmc_total'],2); ?></th>
						<th></th>
					</tr>
					<?php $gEmp += $g['emp_total']; $gNmc += $g['nmc_total']; endforeach; ?>
				</tbody>
				<tfoot>
					<tr class="bg-primary">
						<th colspan="3" class="text-right">GRAND TOTAL</th>
						<th class="text-right"><?php echo number_format($gEmp,2); ?></th>
						<th class="text-right"><?php echo number_format($gNmc,2); ?></th>
						<th class="text-right"><?php echo number_format($gEmp+$gNmc,2); ?></th>
						<th></th>
					</tr>
				</tfoot>
				<?php else: ?>
				<tbody><tr><td colspan="7" class="text-center">No records for the selected month/year.</td></tr></tbody>
				<?php endif; ?>
			</table>
		</div>
		<div style="margin-top:40px;text-align:right;"><strong>Signature</strong><br>Treasury Officer</div>
		<?php endif; ?>
	</div></div></section>
</div>
