<?php 
    $months = [
    1  => "January",
    2  => "February",
    3  => "March",
    4  => "April",
    5  => "May",
    6  => "June",
    7  => "July",
    8  => "August",
    9  => "September",
    10 => "October",
    11 => "November",
    12 => "December"
];
?>
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
        <h1>DCPS Month Wise Deduction Record</h1>
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
                        <h3 class="box-title">Search DCPS Monthly Record</h3>
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
							    <!--<div class="form-group col-md-3">
									<label for="inputCity" class="required">Month</label>
									<input type="text" name="for_month" id="for_month" class="form-control" placeholder="Month" required>
							    </div>-->
							    <div class="form-group col-md-3">
							     	<label for="inputState" class="required">Month</label>
							     	<select id="for_month" name="for_month" class="form-control">
							       		<option name="month" selected value="">Select Month</option>
							        <?php
                                        foreach($months as $id => $month) {
                                            echo '<option value="'.$id.'">'.$month.'</option>';
                                        }
                                        ?>
							      </select>
							    </div>
							    <div class="form-group col-md-3">
							     	<label for="inputState" class="required">Year</label>
							     	<select id="year" name="year" class="form-control">
							       		<option name="year" selected value="">Select Year</option>
							        <?php
                                            for ($start = 2005; $start <= 2014; $start++) {
                                                $end = $start + 1;
                                                echo '<option value="' . htmlspecialchars($start) . '">' . htmlspecialchars($start . '-' . $end) . '</option>';
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
			var for_month = $('#for_month').val();
			var year = $('#year').val();
			// alert(year);
			$.ajax({
				type : 'POST',
				url    : '<?php echo base_url("ajax/getDeatailsOfMonthRec"); ?>',
				data : { for_month: for_month,year:year },
			
				success: function(responce){
					//alert(responce);
					if(responce){
					var obj = jQuery.parseJSON(responce);
					$("#allViewDemandData").html(obj.customer_detail);
					var table = $('#example').DataTable();
					}
					else{
					    //alert('No data found');
					    $("#allViewDemandData").html('<h2>No Record Found</h2>');
					    var table = $('#example').DataTable();
					   
					}
					
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