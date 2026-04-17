<div class="content-wrapper" style="min-height: 970.3px; height: auto !important;">
	<section class="content-header">
		<h1>Edit Gr Management</h1>
		<!-- <ol class="breadcrumb">
			<li><a href="<?=base_url('admin/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
			<li><a href="<?=base_url($routeUrl)?>">Employee Master</a></li>
			<li class="active"><?=($this->router->method=="add")?"Add":"Edit";?> Employee</li>
		</ol> -->
	</section>
	<section class="content" style="height: auto !important; min-height: 0px !important;">
		<div class="row">
			<div class="col-lg-12">
				<div class="box">
					<div class="box-header with-border">
						<h4>Edit Gr Management</h4>
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
						
						<form action="<?php echo base_url() ?>admin/masterdata/editGrManagementData/<?php echo $results['id']; ?>" method="post" name="typicaltypes" id="typicaltypes" enctype="multipart/form-data" novalidate="novalidate">
							<?php 
								$grDate = date("d.m.Y", substr($results['gr_date'], 0, 10));
								$grFromDate = date("d.m.Y", substr($results['gr_from_date'], 0, 10));
								$grToDate = date("d.m.Y", substr($results['gr_to_date'], 0, 10));						
							 ?>
							<div class="form-row">
							    <div class="form-group col-md-4">
									<label for="inputCity">Gr Number</label>
									<input type="text" name="gr_no" id="gr_no" class="form-control" value="<?php echo $results['gr_no']; ?>" placeholder="Gr Number">
							    </div>
							    <div class="form-group col-md-4">
									<label for="inputCity">Gr Date</label>
									<input type="text" name="gr_date" id="gr_date" class="form-control" value="<?php echo $grDate; ?>" placeholder="Gr Date">
							    </div>
							    <div class="form-group col-md-4">
									<label for="inputCity">Gr From Date</label>
									<input type="text" name="gr_from_date" id="gr_from_date" class="form-control" value="<?php echo $grFromDate; ?>" placeholder="Gr From Date">
							    </div>
							    
							    <div class="clearfix"></div>
							    <div class="form-group col-md-4">
									<label for="inputCity">Gr To Date</label>
									<input type="text" name="gr_to_date" id="gr_to_date" class="form-control" value="<?php echo $grToDate; ?>" placeholder="Gr To Date">
							    </div>
							    <div class="form-group col-md-4">
									<label for="inputCity">Gr Month</label>
									<input type="text" name="gr_month" id="gr_month" class="form-control" value="<?php echo $results['gr_month']; ?>" placeholder="Gr Month">
							    </div>
							    <div class="form-group col-md-4">
									<label for="inputCity">Gr Year</label>
									<input type="text" name="gr_year" id="gr_year" class="form-control" value="<?php echo $results['gr_year']; ?>" placeholder="Gr Year">
							    </div>
							    <div class="clearfix"></div>
							    <div class="form-group col-md-4">
									<label for="inputCity">Gr Percentage</label>
									<input type="text" name="gr_percentage" id="gr_percentage" class="form-control" value="<?php echo $results['gr_percentage']; ?>" placeholder="Gr Percentage">
							    </div>
							    <div class="form-group col-md-4">
									<label for="inputCity">Gr By</label>
									<input type="text" name="gr_by" id="gr_by" class="form-control" value="<?php echo $results['gr_by']; ?>" placeholder="Gr By">
							    </div>
							    <!-- <div class="form-group col-md-4">
									<label for="inputCity">DCPS Percentage In Gr</label>
									<input type="text" name="dcps_per_in_gr" id="dcps_per_in_gr" class="form-control" value="<?php echo $results['dcps_per_in_gr']; ?>" placeholder="DCPS Percentage In Gr">
							    </div> -->
							    <!-- <div class="clearfix"></div> -->
							    
							    <div class="clearfix"></div>
							    
							</div>
							<div class="col-sm-12" style="text-align: right;">
								<input type="hidden" name="id" value="<?php echo $results['id']; ?>" id="id">   
								<input type="submit" class="btn btn-primary" value="Submit">
								<!-- <a href="<?=base_url($routeUrl)?>" class="btn btn-primary"><i class="fa fa-arrow-circle-left"></i> Back</a> -->
							</div>
						</form>
					</div>
				</div>
			</div> 
		</div>
	</section>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		// $("#wef_date").datepicker({ dateFormat: "dd/mm/yy" });
		$("#gr_date").datepicker({ format: 'dd.mm.yyyy',orientation: "bottom" }); 
		$("#gr_from_date").datepicker({ format: 'dd.mm.yyyy',orientation: "bottom" }); 
		$("#gr_to_date").datepicker({ format: 'dd.mm.yyyy',orientation: "bottom" }); 
		
	});
</script>