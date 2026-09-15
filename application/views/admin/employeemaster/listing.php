<!-- local plugin assets -->
<link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/datatables.min.css'); ?>">

<div class="content-wrapper" style="min-height: 970.3px; height: auto !important;">
	<section class="content-header">
		<div class="heading-icon-badge"><img src="<?php echo base_url('assets/images/user_edit.png'); ?>" alt="Employee Master"></div>
		<h1>Employee Master</h1>
		<!-- <ol class="breadcrumb">
			<li><a href="<?=base_url('admin/dashboard')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
			<li class="active">Employee Master</li>
		</ol> -->
	</section>
	<section class="content" style="height: auto !important; min-height: 0px !important;">
		<div class="row">
			<div class="col-lg-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Employee Master</h3>
						<div style="float:right;">
							<a href="<?php echo base_url('admin/export-emp-csv');?>" class="btn btn-success" style="margin-right: 5px;"> <i class="fa fa-file-excel-o"></i> Export CSV</a>
							<a href="<?php echo base_url('admin/add-emp');?>" class="btn btn-primary"> <i class="fa fa-plus-circle"></i> Add New</a>
						</div>
					</div>
					
					<?php if($this->session->flashdata('success')):?>
					<div class="alert alert-success alert-dismissible fade in">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
						<strong>Success: </strong><?=$this->session->flashdata('success');?>
					</div>
					<?php endif; 
					if($this->session->flashdata('fail')):?>
					<div class="alert alert-danger alert-dismissible fade in">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
						<strong>Error: </strong><?=$this->session->flashdata('fail');?>
					</div>
					<?php endif; ?>
					
					
					<div class="box-body">
						<div class="table-responsive">
							
								<table id="dataTables-example" class="table table-striped table-bordered table-hover dataTable no-footer" aria-describedby="dataTables-example_info">
									
									<thead class="bg-primary">
										<tr role="row">
											<th width="5%">Sr. No.</th>
											<th>Employee Name</th>
											<th>Employee ID</th>
											<th>Joining Date</th>
											<th>Pay Center</th>
											<th width="8%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											if(!empty($results))
											{
												$i=1;
												foreach($results as $row) { ?>
												<tr role="row">
													<td style="text-align: center;"><?=$i++?></td>
													<td style="text-align: center;"><?php echo html_escape($row['emp_name']); ?></td>
													<td style="text-align: center;"><?php echo html_escape($row['emp_id']); ?></td>
													<td style="text-align: center;"><?php echo html_escape($row['joining_date']); ?></td>
													<td style="text-align: center;"><?php echo html_escape($row['pay_center']); ?></td>
													<td style="text-align: center;"><a href="<?php echo base_url('admin/edit-emp/'.$row['id']); ?>" title="Edit" class="btn btn-primary btn-circle"><i class="fa fa-edit"></i></a></td>
												</tr>
												<?php }
											} ?>
									</tbody>
									
								</table>
							
						</div>
					</div>
					<!-- <div class="row">
						<div class="col-sm-12">
							<div class="dataTables_info" id="dataTables-example_info" role="alert" aria-live="polite" aria-relevant="all">&nbsp;</div>
						</div>
						<div class="col-sm-12">
							<div class="pagi">
								<?php if(!empty($links)) { echo $links; } ?>
							</div>
						</div>
					</div> -->
				</div>
			</div>
			
			
			
		</div>
	</section>
</div>
<script src="<?php echo base_url('assets/js/datatables.min.js'); ?>"></script>
<script type="text/javascript">
	$(document).ready( function () {
		$('#dataTables-example').DataTable();
	});
</script>