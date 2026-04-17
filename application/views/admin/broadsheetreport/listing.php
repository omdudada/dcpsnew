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
                        <h3 class="box-title">Broad Sheet Report</h3>
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
                        <form action="" method="post" name="typicaltypes" id="typicaltypes" enctype="multipart/form-data" novalidate="novalidate">
							<div class="form-row">
							    <!-- <div class="form-group col-md-3">
									<label for="inputCity" class="required">Employee ID</label>
									<input type="text" name="employee_id" id="employee_id" class="form-control" placeholder="Employee ID" required>
							    </div> -->
							    <!-- <div class="form-group col-md-3">
							     	<label for="inputState" class="required">Month</label>
							     	<select id="month" name="month" class="form-control">
							       		<option name="month" selected value="">Select Month</option>
							        <?php
				                        foreach($month as $row)
				                        {
				                            echo '<option value="'.$row['id'].'">'.$row['month'].'</option>';
				                        }
				                        ?>
							      </select>
							    </div> -->
							    <div class="form-group col-md-3">
							     	<label for="inputState" class="required">Year</label>
							     	<select id="year" name="year" class="form-control">
							       		<option name="year" selected value="">Select Year</option>
							        <?php
				                        foreach($year as $row)
				                        {
				                        	$y = $row['year']+1;
				                            echo '<option value="'.$row['id'].'">'.$row['year'].'-'.$y.'</option>';
				                        }
				                        ?>
							      </select>
							    </div>
							    <div class="col-sm-1">
								      
									<label for="inputState" class=""></label>      
									<input type="button" class="btn btn-primary" id="search" value="Search" style="margin: 12px 0px 0px 0px">
								
								</div>
							</div>
							
							
							
							<div class="clearfix"></div>
							<div id="allViewDemandData">
								
							</div>
							<div id="viewDataTables">
								
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
<script type="text/javascript">
	$(document).ready(function(){
		$('#search').click(function(e){
			getCustomerDetails();
			
		});
		
		function getCustomerDetails(){
			
			//var employee_id = $('#employee_id').val();
			//var month = $('#month').val();
			var year = $('#year').val();
			// alert(year);
			$.ajax({
				type : 'POST',
				url    : '<?php echo base_url("ajax/broadSheetReport"); ?>',
				data : {year:year },
				success: function(responce){
					
					//alert(responce);
					var obj = jQuery.parseJSON(responce);
					//$("#clsTitle").text("Today's Recovery Status");
					//$('#zonerecoverystatus').show();
					
					//var table_data = JSON.parse(responce);
					
					$("#allViewDemandData").html(obj.customer_detail);
					//$("#customer_detail").html(obj.customer_detail);
					
					
					//var table = $('#example').DataTable();
				},
				error: function (jqXHR, textStatus, errorThrown) {
					if (jqXHR.status == 500) {
						alert('Internal error: ' + errorThrown);
					} 
					else {
						alert('Unexpected error.');
					}
				}
			});
		}

	});
</script>