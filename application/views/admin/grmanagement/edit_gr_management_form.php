<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-datepicker.min.css'); ?>">

<div class="content-wrapper" style="min-height: 970.3px; height: auto !important;">
	<section class="content-header">
		<div class="heading-icon-badge"><img src="<?php echo base_url('assets/images/file.png'); ?>" alt="Edit Gr Management"></div>
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
								$grDate = is_numeric($results['gr_date']) ? date("d.m.Y", (int)$results['gr_date']) : $results['gr_date'];
								$grFromDate = is_numeric($results['gr_from_date']) ? date("d.m.Y", (int)$results['gr_from_date']) : $results['gr_from_date'];
								$grToDate = is_numeric($results['gr_to_date']) ? date("d.m.Y", (int)$results['gr_to_date']) : $results['gr_to_date'];
							 ?>
							<div class="form-row">
							    <div class="form-group col-md-4">
									<label for="inputCity">Gr Number</label>
									<input type="text" name="gr_no" id="gr_no" class="form-control" value="<?php echo $results['gr_no']; ?>" placeholder="Gr Number">
							    </div>
							    <div class="form-group col-md-4">
									<label for="inputCity">Gr Date</label>
									<input type="text" name="gr_date" id="gr_date" class="form-control datepick" data-provide="datepicker" data-date-format="dd.mm.yyyy" data-date-autoclose="true" value="<?php echo $grDate; ?>" placeholder="Gr Date" autocomplete="off">
							    </div>
							    <div class="form-group col-md-4">
									<label for="inputCity">Gr From Date</label>
									<input type="text" name="gr_from_date" id="gr_from_date" class="form-control datepick" data-provide="datepicker" data-date-format="dd.mm.yyyy" data-date-autoclose="true" value="<?php echo $grFromDate; ?>" placeholder="Gr From Date" autocomplete="off">
							    </div>
							    
							    <div class="clearfix"></div>
							    <div class="form-group col-md-4">
									<label for="inputCity">Gr To Date</label>
									<input type="text" name="gr_to_date" id="gr_to_date" class="form-control datepick" data-provide="datepicker" data-date-format="dd.mm.yyyy" data-date-autoclose="true" value="<?php echo $grToDate; ?>" placeholder="Gr To Date" autocomplete="off">
							    </div>
							    <div class="form-group col-md-4">
									<label for="gr_month">Gr Month</label>
									<select name="gr_month" id="gr_month" class="form-control">
										<option value="">Select Month</option>
										<?php if(!empty($month)): foreach($month as $m): 
											$selectedM = (isset($results['gr_month']) && ((string)$results['gr_month'] === (string)$m['id'] || strtolower((string)$results['gr_month']) === strtolower((string)$m['month']))) ? 'selected' : '';
										?>
											<option value="<?php echo $m['id']; ?>" <?php echo $selectedM; ?>><?php echo $m['month']; ?></option>
										<?php endforeach; endif; ?>
									</select>
							    </div>
							    <div class="form-group col-md-4">
									<label for="gr_year">Gr Year</label>
									<select name="gr_year" id="gr_year" class="form-control">
										<option value="">Select Year</option>
										<?php if(!empty($year)): foreach($year as $y): 
											$selectedY = (isset($results['gr_year']) && ((string)$results['gr_year'] === (string)$y['year'] || (string)$results['gr_year'] === (string)$y['id'])) ? 'selected' : '';
										?>
											<option value="<?php echo $y['year']; ?>" <?php echo $selectedY; ?>><?php echo $y['year']; ?></option>
										<?php endforeach; endif; ?>
									</select>
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
								<a href="<?php echo base_url('admin/gr-management'); ?>" class="btn btn-default" style="margin-left: 5px;"><i class="fa fa-arrow-circle-left"></i> Cancel</a>
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
		var $dates = $('#gr_date, #gr_from_date, #gr_to_date, .datepick');
		if (typeof $.fn.datepicker !== 'undefined') {
			$dates.datepicker({
				format: 'dd.mm.yyyy',
				orientation: 'bottom auto',
				autoclose: true,
				todayHighlight: true
			});
		}
		$(document).on('click focus', '#gr_date, #gr_from_date, #gr_to_date, .datepick', function(){
			if (typeof $(this).datepicker === 'function') {
				$(this).datepicker('show');
			}
		});
	});
</script>