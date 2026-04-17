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
        <h1>Master Record</h1>
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
                        <h3 class="box-title">Search Master Record</h3>
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
                        <form action="<?php echo base_url('admin/report/generatePdfWithYear'); ?>" method="post" name="typicaltypes" id="typicaltypes" enctype="multipart/form-data" novalidate="novalidate" target="_blank">
							<div class="form-row">
							    
							    
							    <div class="form-group col-md-3">
							     	<label for="inputState" class="">Year</label>
							     	<select id="year" name="year" class="form-control">
							       		<option name="year" selected value="">Select Year</option>
							        <?php
				                        foreach($year as $row)
				                        {
				                        	$nxtYear = $row['year']+1;
				                            echo '<option value="'.$row['id'].'">'.$row['year'].'-'.$nxtYear.'</option>';
				                        }
				                        ?>
							      </select>
							    </div>
							    <div class="col-sm-1">
								      
									<label for="inputState" class=""></label>      <button class="btn btn-primary" id="search" value="Search" style="margin: 24px 0px 0px 0px">Search</button>
									<!-- <input type="button" class="btn btn-primary" id="search" value="Search" style="margin: 5px 0px 0px 0px"> -->
								
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
