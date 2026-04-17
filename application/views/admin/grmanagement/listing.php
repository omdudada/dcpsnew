<?php //echo "<pre>";print_r($grResults);die();?>
<div class="content-wrapper" style="min-height: 970.3px; height: auto !important;">
	<section class="content-header">
		<h1>Gr Management</h1>
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
						<h3 class="box-title">Gr Management</h3>
						<a href="<?php echo base_url('admin/add-gr-management');?>" class="btn btn-primary" style="float:right;"> <i class="fa fa-plus-circle"></i> Add New</a>
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
											<th>Gr Number</th>
											<th>Gr Date</th>
											<th>Gr From Date</th>
											<th>Gr To Date</th>
											<th>Gr Month</th>
											<th>Gr Year</th>
											<th>Gr Percentage</th>
											<!-- <th>DCPS Percentage In Gr</th> -->
											<th>Gr By</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											if(!empty($grResults))
											{
												// echo "<pre>";print_r($results);die();
												$i=1;
												foreach($grResults as $row) { ?>
												<tr role="row">
													<td style="text-align: center;"><?=$i++?></td>
													<td style="text-align: center;"><?php echo $row['gr_no']; ?></td>
													<!-- <td style="text-align: center;"><?php echo $row['gr_date']; ?></td> -->
													<td style="text-align: center;"><?php $grDate = date("d.m.Y", substr($row['gr_date'], 0, 10));
														echo $grDate; ?>
													</td>
													<td style="text-align: center;"><?php $grFromDate = date("d.m.Y", substr($row['gr_from_date'], 0, 10));
														echo $grFromDate; ?>
													</td>
													<td style="text-align: center;"><?php $grToDate = date("d.m.Y", substr($row['gr_to_date'], 0, 10));
														echo $grToDate; ?>
													</td>
													<td style="text-align: center;"><?php echo $row['gr_month']; ?></td>
													<td style="text-align: center;"><?php echo $row['gr_year']; ?></td>
													<td style="text-align: center;"><?php echo $row['gr_percentage']; ?></td>
													<!-- <td style="text-align: center;"><?php echo $row['dcps_per_in_gr']; ?></td> -->
													<td style="text-align: center;"><?php echo $row['gr_by']; ?></td>
													<td style="text-align: center;"><a href="<?php echo base_url();?>admin/edit-gr-management/<?php echo $row['id']; ?>" title="Edit" class="btn btn-primary btn-circle"><i class="fa fa-edit"></i></a></td>
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
<script type="text/javascript">
	$(document).ready( function () {
		$('#dataTables-example').DataTable();
	});
</script>