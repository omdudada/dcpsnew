<?php
$full = trim($record['first_name'].' '.$record['middle_name'].' '.$record['last_name']);
$nominees = isset($record['nominees']) ? $record['nominees'] : array();
?>
<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>">

<div class="content-wrapper" style="min-height: 970.3px; height: auto !important;">
	<section class="content-header">
		<h1>FORM-1 Application &ndash; <?php echo html_escape($full); ?></h1>
	</section>
	<section class="content">
		<div class="row"><div class="col-lg-12"><div class="box">
			<div class="box-header with-border">
				<h4>FORM-1 Details</h4>
				<span style="float:right;">
					<a href="<?php echo base_url('admin/form1/edit/'.$record['id']); ?>" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a>
					<a href="<?php echo base_url('admin/form1'); ?>" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Back</a>
				</span>
			</div>
			<div class="box-body">
				<table class="table table-bordered">
					<?php
					$rows = array(
						'Salutation'            => $record['salutation'],
						'Name'                  => $full,
						'Gender'                => $record['gender'],
						'Date of Birth'         => $record['dob'],
						'Date of Joining'       => $record['date_of_joining'],
						'Date of Appointment'   => $record['date_of_appointment'],
						'PRAN / Pension A/C No.' => $record['pran_no'],
						'Employee ID'           => $record['emp_id'],
						'Designation'           => $record['designation_name'],
						'Pay &amp; Scale'        => $record['pay_scale'],
						'Office Name'           => $record['office_name'],
						'Office Address'        => $record['office_address'],
						'Residential Address'   => $record['residential_address'],
						'Phone No.'             => $record['phone_no'],
						'Mobile No.'            => $record['mobile_no'],
						'Email'                 => $record['email'],
						'Pay Center'            => $record['pay_center'],
						'DDO Code'              => $record['ddo_code'],
						'Department Code'       => $record['dept_code'],
						'Treasury Code'         => $record['treasury_code'],
						'Previously in DCPS'    => ($record['prev_govt_service'] ? 'Yes' : 'No'),
						'Previous Details'      => $record['prev_service_details'],
					);
					foreach($rows as $label => $value): ?>
					<tr>
						<th width="30%"><?php echo $label; ?></th>
						<td><?php echo html_escape($value); ?></td>
					</tr>
					<?php endforeach; ?>
					<?php if(!empty($record['form_scan'])): ?>
					<tr>
						<th>Scanned FORM-1</th>
						<td><a href="<?php echo base_url('assets/uploads/form1/'.$record['form_scan']); ?>" target="_blank"><?php echo html_escape($record['form_scan']); ?></a></td>
					</tr>
					<?php endif; ?>
				</table>

				<h4 class="text-primary">Nominee(s)</h4>
				<table class="table table-bordered">
					<thead class="bg-primary">
						<tr><th>#</th><th>Name &amp; Address</th><th>Date of Birth</th><th>Relationship</th><th>Share %</th><th>Guardian</th></tr>
					</thead>
					<tbody>
						<?php if(!empty($nominees)): $i=1; foreach($nominees as $n): ?>
						<tr>
							<td><?php echo $i++; ?></td>
							<td><?php echo html_escape($n['nominee_name']); ?><br><small><?php echo html_escape($n['nominee_address']); ?></small></td>
							<td><?php echo html_escape($n['dob']); ?></td>
							<td><?php echo html_escape($n['relationship']); ?></td>
							<td><?php echo html_escape($n['share_percentage']); ?></td>
							<td><?php echo html_escape($n['guardian_name']); ?></td>
						</tr>
						<?php endforeach; else: ?>
						<tr><td colspan="6" style="text-align:center;">No nominees recorded.</td></tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div></div></div>
	</section>
</div>
