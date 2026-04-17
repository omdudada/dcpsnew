<style type="text/css">
    .spaceTot label.form-label {
    display: none;
    }
    .spaceArr label.form-label {
    display: none;
    }
    .spaceCurr label.form-label {
    display: none;
    }
    
    .form-error p {
    color: #ff8080;
    font-size: 12px;
    }
    label.form-label{
	display: table-cell;   
    float:left;
    width: 246px;
    
    }
    .container {
	display: table;
	width: 100%
	}
    .controls {
	display: table-cell;
	overflow: hidden;
	padding: 0 4px 0 6px
	}
	input {
	width: 100%;
	}
	.required:after {
	content:" *";
	color: red;
	font-size: 18px;
    }
	
	
	
</style>
<?php //echo "<pre>";print_r($data);die(); ?>
<div class="content-wrapper" style="min-height: 970.3px; height: auto !important;">
    <section class="content-header">
        <h1>Broad Sheet Report</h1>
        <!-- <ol class="breadcrumb">
            <li><a href="<?=base_url('admin/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            
            <li class="active">Call Center Form</li>
		</ol> -->
	</section>
	
    <?php if(validation_errors()){?>
		<!-- Alert message -->
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<?php echo validation_errors();?>
		</div>
		<!--/ Alert message -->
	<?php }?>  
	<section class="content" style="height: auto !important; min-height: 0px !important;">
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Ledger Report</h3>
					</div>
                    
                    <?php if($this->session->flashdata('success')):?>
                    <div class="alert alert-success alert-dismissible fade in">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                        <strong>Success: </strong><?=$this->session->flashdata('success');?>
					</div>
                    <?php endif; 
					if($this->session->flashdata('error')):?>
                    <div class="alert alert-danger alert-dismissible fade in">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                        <strong>Error: </strong><?=$this->session->flashdata('error');?>
					</div>
                    <?php endif; ?>
                    <div class="box-body">
                        <?php //echo "<pre>";print_r($hospitals);die(); ?>
                        <form action="" method="post" name="typicaltypes" id="typicaltypes" enctype="multipart/form-data" >
							<div class="form-row">
							    
							    <div class="form-group col-md-3">
							     	<label for="inputState" >Employee Name</label>
							     	<select id="employee" name="emp_id" class="form-control">
							       		<option name="emp_id" selected value="">Select Employee Name / Employee Id</option>
										<?php
											foreach($employeeData as $row)
											{
												echo '<option value="'.$row['emp_name']." - ".$row['emp_id'].'">'.$row['emp_name']." (".$row['emp_id'].") ".'</option>';
											}
										?>
									</select>
								</div>
							    <div class="col-sm-1">
									
									<label for="inputState" class=""></label>      
									<input type="submit" class="btn btn-primary" id="search" value="Search" style="margin: 12px 0px 0px 0px">
									
								</div>
							</div>
							<br/><br/>
							<div class="searchTable">
                        		<table id="" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                        			<thead class="bg-primary123">
                        				<tr>
                        					<th class="">कर्मचारी क्रमांक</th>
                        					<td>9982</td>
                        					<th class="">कर्मचारी नाव</th>
                        					<td colspan ="5">Test</td>
										</tr>	
										<tr>
                        					<th class="">कर्मचारी नियुक्ती दिनांक</th>
                        					<td>D.A.</td>
                        					<th class="">पे सेंटर</th>
                        					<td></td>
                        					<th class="" colspan="3">हुद्दा</th>
                        					<td></td>
										</tr>
										<tr>
											<th class="">व्याज दर (1) (एप्रिल 2011 ते नोव्हेंबर 2011)</th>
											<td>Bal</td>
											<th class="">व्याज दर (2) (डिसेंबर 2011 ते मार्च 2012)</th>
											<td>Int-Amt</td>
											<th class=""  colspan="3">सुरवातीची शिल्लक	</th>
											<td>	</td>
										</tr>
										<tr>
											<th>महिना</th>
											<th>कर्मचारी वर्गणी</th>
											<th>शासकीय वर्गणी</th>
											<th>कर्मचाऱ्याने काढलेल्या कर्ज रक्कमेचा हप्ता</th>
											<th>एकूण जमा</th>
											<th>काढलेल्या कर्जाची रक्कम</th>
											<th>व्याज आकारली जाते ती मासिक रक्कम</th>
											<th>मिळणाऱ्या व्याजाची रक्कम</th>
										</tr>
										<?php 
											$months = array(4=>"एप्रिल",5=>"मे",6=>"जुन",7=>"जुलै",8=>"ऑगस्ट",9=>"सप्टेंबर",10=>"ऑक्टोबर",11=>"नोव्हेंबर",12=>"डिसेंबर",1=>"जानेवारी",2=>"फेब्रुवारी",3=>"मार्च");
											foreach($months as $month){
											?>
												<tr>
													<td><?=$month;?></td>
													<td><?=$month;?></td>
													<td><?=$month;?></td>
													<td><?=$month;?></td>
													<td><?=$month;?></td>
													<td><?=$month;?></td>
													<td><?=$month;?></td>
													<td><?=$month;?></td>
												</tr>
											<?php 
											}
										?>
									</thead>
									<tbody>
									</tbody>	
								</table>
							</div>
							
						
						<div class="clearfix"></div>
						
					</form>
					
				</div>
			</div>
		</div>
	</div>
</section>
</div>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#employee').select2({
		    selectOnClose: true
		});
	});
	</script>						