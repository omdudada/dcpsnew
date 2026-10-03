<div class="content-wrapper" style="min-height: 970.3px; height: auto !important;">
	<section class="content-header">
		<h1>Edit Employee</h1>
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
						<h4>Edit Employee</h4>
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
						
						<form action="<?php echo base_url() ?>admin/masterdata/editEmp/<?php echo $results['id']; ?>" method="post" name="typicaltypes" id="typicaltypes" enctype="multipart/form-data" novalidate="novalidate">
							<div class="form-row">
							    <div class="form-group col-md-4">
									<label for="inputCity">Employee Name</label>
									<input type="text" name="emp_name" id="emp_name" class="form-control" value="<?php echo $results['emp_name']; ?>" placeholder="Employee Name">
							    </div>
							    <div class="form-group col-md-4">
									<label for="inputCity">Employee ID</label>
									<input type="text" name="emp_id" id="emp_id" class="form-control" value="<?php echo $results['emp_id']; ?>" placeholder="Employee ID">
							    </div>
							    <div class="form-group col-md-4">
									<label for="inputCity">Joining Date</label>
									<input type="text" name="wef_date" id="wef_date" class="form-control" value="<?php echo $results['joining_date']; ?>" placeholder="Joining Date">
							    </div>
							    <div class="clearfix"></div>
							    <div class="form-group col-md-4">
									<label for="inputCity">Pay Center</label>
									<input type="text" name="pay_center" id="pay_center" class="form-control" value="<?php echo $results['pay_center']; ?>" placeholder="Pay Center">
							    </div>
							    <div class="form-group col-md-4">
									<label for="inputCity">Fixed Pay</label>
									<input type="text" name="fixed_pay" id="fixed_pay" class="form-control" value="<?php echo $results['fixed_pay']; ?>" placeholder="Fixed Pay">
							    </div>
							    <div class="form-group col-md-4">
									<label for="inputCity">Grade Pay</label>
									<input type="text" name="grade_pay" id="grade_pay" class="form-control" value="<?php echo $results['grade_pay']; ?>" placeholder="Grade Pay">
							    </div>
							    <div class="clearfix"></div>
							    <div class="form-group col-md-4">
									<label for="inputCity">Basic</label>
									<input type="text" name="basic" id="basic" class="form-control" value="<?php echo $results['basic']; ?>" placeholder="Basic">
							    </div>
							    <div class="form-group col-md-4">
									<label for="inputCity">da</label>
									<input type="text" name="da" id="da" class="form-control" value="<?php echo $results['da']; ?>" placeholder="da">
							    </div>
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
		$("#wef_date").datepicker({ format: 'dd.mm.yyyy',orientation: "bottom"  }); 
		
	});
</script>								