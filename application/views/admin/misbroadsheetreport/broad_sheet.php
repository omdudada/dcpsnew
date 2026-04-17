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
                        <form action="" method="post" name="typicaltypes" id="typicaltypes" enctype="multipart/form-data" >
							<div class="form-row">
							    <div class="form-group col-md-3">
							     	<label for="inputState" >Year</label>
							     	<select id="year" name="year" class="form-control" required ="required">
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
									<input type="submit" class="btn btn-primary" id="search" value="Search" style="margin: 12px 0px 0px 0px">
								</div>
							</div>
							<br/><br/>
							<div class="searchTable">
                        		<table id="" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                        			<thead class="bg-primary123">
										<tr>
											<th class="">व्याज दर (1) (एप्रिल <?=$this->input->post("year");?> ते नोव्हेंबर <?=$this->input->post("year");?>)</th>
											<td><?=$interestRates[4];?></td>
											<th class="">व्याज दर (2) (डिसेंबर <?=$this->input->post("year");?> ते मार्च <?=$this->input->post("year")+1;?>)</th>
											<td><?=$interestRates[12];?></td>
											<th class=""  colspan="3">सुरवातीची शिल्लक	</th>
											<td><?=(isset($interestDetail['opening_balance']) && $interestDetail['opening_balance'] !="")? $interestDetail['opening_balance']:0 ?></td>
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
											
											$mo =1; $openingBalance = (isset($interestDetail['opening_balance']) && $interestDetail['opening_balance'] !="")? $interestDetail['opening_balance']:0;
											
											$empContri = $totalEmpContri = $govContri = $totalGovContri = $loanInstallment = $totalLoanInstallment = $totAmount = $totalTotAmount = $loanAmount = $totalLoanAmount = $monthlyAmount = $totalMonthlyAmount = $interestAmount = $totalInterestAmount = 0;
											
											
											foreach($months as $monthNo => $monthName){
											    $totalAmount= 0;
											    //if($mo > 1) { $openingBalance = 0; }
											?>
												<tr>
													<td><?=$monthName;?> <?=($monthNo >=1 && $monthNo <= 3)?($this->input->post('year')+1):$this->input->post('year');?></td>
													<td>
													    <?php
											echo $empContri =		    ($dcpsDetails[$monthNo]['emp_DCPS_contribution'] > 0)?$dcpsDetails[$monthNo]['emp_DCPS_contribution']:0;
											$totalEmpContri+= $empContri;
											?>
											</td>
													<td>
													    <?php
													    echo $govContri= ($dcpsDetails[$monthNo]['NMC_DCPS_contribution'] > 0)?$dcpsDetails[$monthNo]['NMC_DCPS_contribution']:0;
													    $totalGovContri += $govContri;
													    ?>
													    </td>
													<td>
													<?php
													echo $loanInstallment =  ($dcpsDetails[$monthNo]['loan_installment_paid_through_salary'] > 0)?$dcpsDetails[$monthNo]['loan_installment_paid_through_salary']:0;
													 $totalLoanInstallment += $loanInstallment;
													
													?>
													</td>
													<td>
													    <?php 
										$totalAmount = 			    (($dcpsDetails[$monthNo]['total_contribution']+$dcpsDetails[$monthNo]['loan_installment_paid_through_salary']) > 0)?($dcpsDetails[$monthNo]['total_contribution']+$dcpsDetails[$monthNo]['loan_installment_paid_through_salary']):0;
										
										echo $totalAmount;
										
										$totalTotAmount += $totalAmount;
										
										?>
										</td>
													<td>
													    <?php    echo $loanAmount = ($dcpsDetails[$monthNo]['DCPS_loan_taken_by_an_employee'] > 0)?$dcpsDetails[$monthNo]['DCPS_loan_taken_by_an_employee']:0;
													    $totalLoanAmount+= $loanAmount;
													    
													    ?>
													    </td>
													<td>
													    <?php 
										        //$monthlyAmount+=$totalAmount;
										//echo "Line no. 182=>".$monthlyAmount;			    
													   $grandAmount = round($totalAmount + $openingBalance + ( ($dcpsDetails[$monthNo]['DCPS_loan_taken_by_an_employee'] > 0)?$dcpsDetails[$monthNo]['DCPS_loan_taken_by_an_employee']:0)) ;
													   echo $grandAmount;
													   
													   $totalMonthlyAmount += $grandAmount;
													   ?>
													</td>
													<td>
													    <?php 
													    $interest = round($grandAmount*($interestRates[$monthNo] /100)/12,2);
													    echo $interest;
													    
													    $totalInterestAmount+=$interest;
													    
													    $openingBalance+= $totalAmount +  ( ($dcpsDetails[$monthNo]['DCPS_loan_taken_by_an_employee'] > 0)?$dcpsDetails[$monthNo]['DCPS_loan_taken_by_an_employee']:0);
													    
													    
													    ?>
													</td>
												</tr>
											<?php 
											$mo++;
											}
										?>
									</thead>
									<tr>
									    <th>एकुण <?=$this->input->post('year');?>-<?=$this->input->post('year')+1;?></th>
									    <th><?=$totalEmpContri;?></th>
									    <th><?=$totalGovContri;?></th>
									    <th><?=$totalLoanInstallment;?></th>
									    <th><?=$totalTotAmount;?></th>
									    <th><?=$totalLoanAmount;?></th>
									    <th><?=$totalMonthlyAmount;?></th>
									    <th><?=round($totalInterestAmount);?></th>
									</tr>	
									<tr>
									    <th colspan="7" style="text-align: right">सुरुवातीची शिल्लक		</th>
									    <th><?=$interestDetail['opening_balance'];?></th>
									</tr>
									<tr>
									    <th colspan="7" style="text-align: right">एकुण कर्मचारी वर्गणी व कर्मचाऱ्याने काढलेल्या कर्ज रक्कमेचा हप्ता : जमा (+)	</th>
									    <th><?=$interestDetail['emp_contri'];?></th>
									</tr>
									<tr>
									    <th colspan="7" style="text-align: right">शासकीय वर्गणी</th>
									    <th><?=$interestDetail['nmc_contri'];?></th>
									</tr>
									<tr>
									    <th colspan="7" style="text-align: right">एकुण जमा (सुरवातीची शिलकेसह)			</th>
									    <th><?=$interestDetail['total_contri'];?></th>
									</tr>
									<tr>
									    <th colspan="7" style="text-align: right">काढलेल्या कर्जाची रक्कम (-)			</th>
									    <th><?=$interestDetail['loan_amount'];?></th>
									</tr>
									<tr>
									    <th colspan="7" style="text-align: right">मिळणाऱ्या व्याजाची रक्कम (+)			</th>
									    <th><?=$interestDetail['interest'];?></th>
									</tr>
									<tr>
									    <th colspan="7" style="text-align: right">मार्च अखेर शिल्लक (+)			</th>
									    <th><?=$interestDetail['grand_total'];?></th>
									</tr>
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
		$('#employee').select2();
		<?php if($this->input->post('emp_id')){?>
		    $('#employee').val('<?=$this->input->post('emp_id');?>').select2();
		    /*$("#employee").select().select2("val", "<?=$this->input->post('emp_id');?>"); */
		<?php } ?>
		
		<?php if($this->input->post('year')){?>
		    //alert(<?=$this->input->post('year');?>);
		    $('#year').val('<?=$this->input->post('year');?>');
		<?php } ?>
		
	});
	</script>						