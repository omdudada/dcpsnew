<!-- local plugin assets (the base header only loads jQuery) -->
<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/datatables.min.css'); ?>">

<div class="content-wrapper" style="min-height: 970.3px; height: auto !important;">
	<section class="content-header">
		<div class="heading-icon-badge"><img src="<?php echo base_url('assets/images/file.png'); ?>" alt="FORM-1 — DCPS Application (Pension Account No.)"></div>
		<h1>FORM-1 &ndash; DCPS Application (Pension Account No.)</h1>
	</section>
	<section class="content" style="height: auto !important; min-height: 0px !important;">
		<div class="row">
			<div class="col-lg-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">FORM-1 Applications</h3>
						<a href="<?php echo base_url('admin/form1/add'); ?>" class="btn btn-primary" style="float:right;">
							<i class="fa fa-plus-circle"></i> Add New
						</a>
					</div>

					<?php if($this->session->flashdata('success')): ?>
					<div class="alert alert-success alert-dismissible fade in">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>Success: </strong><?php echo html_escape($this->session->flashdata('success')); ?>
					</div>
					<?php endif;
					if($this->session->flashdata('fail')): ?>
					<div class="alert alert-danger alert-dismissible fade in">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>Error: </strong><?php echo html_escape($this->session->flashdata('fail')); ?>
					</div>
					<?php endif; ?>

					<div class="box-body">
						<div class="table-responsive">
							<table id="form1-table" class="table table-striped table-bordered table-hover">
								<thead class="bg-primary">
									<tr>
										<th width="5%">Sr. No.</th>
										<th>PRAN No.</th>
										<th>Employee Name</th>
										<th>Emp ID</th>
										<th>Designation</th>
										<th>Pay Center</th>
										<th>Mobile</th>
										<th width="14%">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($results)): $i = 1; foreach($results as $row):
										$full = trim($row['first_name'].' '.$row['middle_name'].' '.$row['last_name']); ?>
									<tr>
										<td style="text-align:center;"><?php echo $i++; ?></td>
										<td><?php echo html_escape($row['pran_no']); ?></td>
										<td><?php echo html_escape($full); ?></td>
										<td><?php echo html_escape($row['emp_id']); ?></td>
										<td><?php echo html_escape($row['designation_name']); ?></td>
										<td><?php echo html_escape($row['pay_center']); ?></td>
										<td><?php echo html_escape($row['mobile_no']); ?></td>
										<td style="text-align:center;">
											<a href="<?php echo base_url('admin/form1/view/'.$row['id']); ?>" title="View" class="btn btn-info btn-circle"><i class="fa fa-eye"></i></a>
											<a href="<?php echo base_url('admin/form1/edit/'.$row['id']); ?>" title="Edit" class="btn btn-primary btn-circle"><i class="fa fa-edit"></i></a>
											<a href="<?php echo base_url('admin/form1/delete/'.$row['id']); ?>" title="Delete" class="btn btn-danger btn-circle js-del"><i class="fa fa-trash"></i></a>
										</td>
									</tr>
									<?php endforeach; else: ?>
									<tr><td colspan="8" style="text-align:center;">No FORM-1 applications found.</td></tr>
									<?php endif; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<script src="<?php echo base_url('assets/js/datatables.min.js'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#form1-table').DataTable();
		$('.js-del').on('click', function(e){
			if(!confirm('Are you sure you want to delete this FORM-1 application?')){
				e.preventDefault();
			}
		});
	});
</script>
