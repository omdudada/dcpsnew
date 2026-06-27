<link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>">

<div class="content-wrapper" style="min-height:970px;height:auto !important;">
	<section class="content-header"><div class="heading-icon-badge"><img src="<?php echo base_url('assets/images/file.png'); ?>" alt="FORM-3 — State Record Keeping Agency Register"></div><h1>FORM-3 &ndash; State Record Keeping Agency Register</h1></section>
	<section class="content"><div class="box"><div class="box-body">

		<?php $this->load->view('admin/statutoryforms/_filter', array(
			'action' => base_url('admin/statutory-forms/form3-register'),
			'show'   => array('pay_center'),
			'months' => $months, 'years' => $years, 'pay_centers' => $pay_centers,
			'pay_center' => $pay_center,
		)); ?>

		<div class="text-center">
			<h4 style="margin:0;">REGISTER TO BE MAINTAINED IN THE OFFICE OF THE STATE RECORD KEEPING AGENCY</h4>
		</div>

		<div class="table-responsive">
			<table class="table table-bordered" style="font-size:13px;">
				<thead class="bg-primary">
					<tr>
						<th>Sr.</th><th>PRAN</th><th>Name of Employee</th><th>Date of Birth</th>
						<th>Date of Joining</th><th>Designation</th><th>Pay Center</th>
						<th>Nominee(s) [Name / Relationship / Share %]</th>
					</tr>
				</thead>
				<tbody>
					<?php if(!empty($apps)): $i=1; foreach($apps as $a):
						$full = trim($a['first_name'].' '.$a['middle_name'].' '.$a['last_name']); ?>
					<tr>
						<td><?php echo $i++; ?></td>
						<td><?php echo html_escape($a['pran_no']); ?></td>
						<td><?php echo html_escape($full); ?></td>
						<td><?php echo html_escape($a['dob']); ?></td>
						<td><?php echo html_escape($a['date_of_joining']); ?></td>
						<td><?php echo html_escape($a['designation_name']); ?></td>
						<td><?php echo html_escape($a['pay_center']); ?></td>
						<td>
							<?php if(!empty($a['nominees'])): foreach($a['nominees'] as $n): ?>
								<?php echo html_escape($n['nominee_name'].' / '.$n['relationship'].' / '.$n['share_percentage'].'%'); ?><br>
							<?php endforeach; else: echo '&ndash;'; endif; ?>
						</td>
					</tr>
					<?php endforeach; else: ?>
					<tr><td colspan="8" class="text-center">No FORM-1 records found. Add applications under <strong>FORM-1</strong> first.</td></tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
		<div style="margin-top:40px;text-align:right;"><strong>Signature</strong><br>Authorised Officer, S.R.K.A.</div>
	</div></div></section>
</div>
