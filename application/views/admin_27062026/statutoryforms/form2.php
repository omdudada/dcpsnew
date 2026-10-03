<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>">

<div class="content-wrapper" style="min-height:970px;height:auto !important;">
	<section class="content-header"><h1>FORM-2 &ndash; Schedule of Employee Contribution (Tier-I)</h1></section>
	<section class="content">
		<div class="box"><div class="box-body">

			<?php $this->load->view('admin/statutoryforms/_filter', array(
				'action' => base_url('admin/statutory-forms/form2'),
				'show'   => array('month','year','pay_center'),
				'months' => $months, 'years' => $years, 'pay_centers' => $pay_centers,
				'month'  => $month, 'year' => $year, 'pay_center' => $pay_center,
			)); ?>

			<?php if($month && $year): ?>
			<div class="text-center">
				<h4 style="margin:0;">SCHEDULE SHOWING EMPLOYEE'S CONTRIBUTION TOWARDS TIER-I OF THE DCPS</h4>
				<p>For the month of <strong><?php echo html_escape($month_name.' '.$year); ?></strong>
				   <?php if($pay_center): ?> &nbsp;|&nbsp; Pay Center / DDO: <strong><?php echo html_escape($pay_center); ?></strong><?php endif; ?>
				</p>
			</div>

			<div class="table-responsive">
				<table class="table table-bordered" style="font-size:13px;">
					<thead class="bg-primary">
						<tr>
							<th>Sr.</th>
							<th>Pension A/C No. (PRAN)</th>
							<th>Name of Employee</th>
							<th>Designation</th>
							<th>Pay Center</th>
							<th class="text-right">Basic Pay</th>
							<th class="text-right">DP</th>
							<th class="text-right">DA</th>
							<th class="text-right">Contribution (Tier-I)</th>
							<th>Voucher No. / Date</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1; $tBasic=$tDp=$tDa=$tCon=0;
						if(!empty($rows)): foreach($rows as $r):
							$con = ((float)$r['emp_contribution'] > 0) ? (float)$r['emp_contribution'] : (float)$r['ideal_contribution'];
							$tBasic += (float)$r['basic']; $tDp += (float)$r['dp']; $tDa += (float)$r['da']; $tCon += $con; ?>
						<tr>
							<td><?php echo $i++; ?></td>
							<td><?php echo html_escape($r['emp_td']); ?></td>
							<td><?php echo html_escape($r['emp_name']); ?></td>
							<td><?php echo html_escape($r['designation_name']); ?></td>
							<td><?php echo html_escape($r['pay_center']); ?></td>
							<td class="text-right"><?php echo number_format((float)$r['basic'],2); ?></td>
							<td class="text-right"><?php echo number_format((float)$r['dp'],2); ?></td>
							<td class="text-right"><?php echo number_format((float)$r['da'],2); ?></td>
							<td class="text-right"><?php echo number_format($con,2); ?></td>
							<td><?php echo html_escape($r['voucher_no'].' / '.$r['voucher_date']); ?></td>
						</tr>
						<?php endforeach; else: ?>
						<tr><td colspan="10" class="text-center">No records for the selected month/year.</td></tr>
						<?php endif; ?>
					</tbody>
					<?php if(!empty($rows)): ?>
					<tfoot>
						<tr class="bg-primary">
							<th colspan="5" class="text-right">TOTAL</th>
							<th class="text-right"><?php echo number_format($tBasic,2); ?></th>
							<th class="text-right"><?php echo number_format($tDp,2); ?></th>
							<th class="text-right"><?php echo number_format($tDa,2); ?></th>
							<th class="text-right"><?php echo number_format($tCon,2); ?></th>
							<th></th>
						</tr>
					</tfoot>
					<?php endif; ?>
				</table>
			</div>

			<p style="margin-top:30px;">Certified that the amount of individual's deduction and the total shown above have been
			checked with reference to the bill and the rate of pay shown has been verified with the amount actually drawn.</p>
			<div style="margin-top:40px;text-align:right;">
				<strong>Signature</strong><br>Drawing &amp; Disbursing Officer
			</div>
			<?php endif; ?>
		</div></div>
	</section>
</div>
