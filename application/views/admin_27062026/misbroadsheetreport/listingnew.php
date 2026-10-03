

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
    
    <?php
	    if(isset($urlAry['option']) && $urlAry['option'] == "print"){ 
	?>
    #header{
				font-size: 12px;
			}
			.bodyContent{#header {
    font-size: 12px;
}
.bodyContent {
    margin: 0 auto;
    line-height: 24px;
    font-size: 15px;
}

@page {
    margin-top: 2.50cm;
    margin-bottom: 3cm;
    margin-left: 3.175cm;
    margin-right: 3.175cm;
}

#taxDetails {
    width: 100%;
}

#contactDetails {
    line-height: 5px;
    font-size: 15px;
    width: 100%;
}

.btnPrint {
    background: url(<?=base_url('assets/front/images/print_ic.gif');?>) no-repeat scroll 5px center #F4F4F4;
    border: 1px solid #8C8C8C;
    cursor: pointer;
    font-weight: bold;
    padding: 5px 10px 5px 35px;
    margin-top: 2px;
}

#watermarkImg {
    display: none;
    position: absolute;
    z-index: 100;
    opacity: 0.1;
    top: 50%;
    left: 50%;
    width: 300px;
    height: 393px;
    margin-top: -196.5px;
    margin-left: -150px;
}

@media print {
    @page {
        size: auto;
        margin: 20mm; /* Default margin */
    }

    table {
        margin-bottom: 0px !important;
        width: 100%;
        border-collapse: separate !important;
    }

    table th, table td {
        border: 1px solid black !important;
        padding: 5px;
        text-align: center;
    }

    #watermarkImg {
        display: block !important;
    }

    .new-page {
        page-break-before: always; /* Ensures a new page starts */
        break-before: always;
    }
}

				margin: 0 auto;
				line-height: 24px;
				font-size: 15px;
			}
			@page *{
				margin-top: 2.50cm;
				margin-bottom: 3cm;
				margin-left: 3.175cm;
				margin-right: 3.175cm;
			}
			#taxDetails{
				width: 100%;
			}
			#contactDetails{
				line-height:5px;
				font-size:15px;
				width:100%;
			}
			.btnPrint {
				background: url(<?=base_url('assets/front/images/print_ic.gif');?>) no-repeat scroll 5px center #F4F4F4;
				border: 1px solid #8C8C8C;
				cursor: pointer;
				font-weight: bold;
				padding: 5px 10px 5px 35px;
				margin-top: 2px;
			}
			#watermarkImg{		
				display: none;
				position: absolute;
				z-index:100;
				opacity: 0.1;
				top:50%;
				left:50%;
				Width: 300px;
				height: 393px;
				margin-top:-196.5px;
				margin-left: -150px;
			}
			@media print {
            @page {
                size: auto;
                /*margin: 10mm 5mm -2mm 8mm;*/
            }
            table {
                margin-bottom: 0px !important;
                width: 100%;
                border-collapse: collapse; /* Ensures borders are merged properly */
                border: 0px solid black !important;
            }
            table th, table td {
                border: 1px solid black !important; /* Adds border to th and td */
                padding: 5px; /* Optional, adds space inside cells */
                text-align: center; /* Optional, centers the content */
            }
            table .clsTable {
                margin-top: 0px;
            }
            #watermarkImg {
                display: block;
                position: absolute;
                z-index: 100;
                opacity: 0.1;
                top: 50%;
                left: 50%;
                width: 300px;
                height: 393px;
                margin-top: -196.5px;
                margin-left: -150px;
            }
            @page {
                margin-top: 20mm; /* Default margin for the first page */
            }
        
            @page :nth(2) {
                margin-top: 50mm; /* Apply margin only from the second page onwards */
            }
            .new-page {
                page-break-after: always; /* Forces the element to start on a new page */
                break-after: always; /* Modern alternative */
                
            }
        }

	<?php } ?>	
	
</style>
<?php //echo "<pre>";print_r($data);die(); ?>
<div class="content-wrapper" style="min-height: 970.3px; height: auto !important;">
    <section class="content-header">
        <h1>Ledger Report</h1>
        
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
                        <?php
                		    if(!isset($urlAry['option']) && $urlAry['option'] != "print"){ 
                		?>
                            <h3 class="box-title">Ledger Report</h3>
                			<a class="btn btn-primary btnPrint" style="float:right;" href="<?=base_url();?>admin/misreport/ledger_report_new/year/<?=$this->input->post('year');?>/option/print">प्रिंट
                			</a>
                		<?php
                		    }
                		?>
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
							<?php /*<div class="form-row">
							    <div class="form-group col-md-3">
                                    <label for="inputState">Pay Center</label>
                                    <select id="pay_center" name="pay_center" class="form-control" required="required">
                                        <option selected value="">Select Pay Center</option>
                                        <?php
                                        foreach($paycenterData as $row) {
                                            echo '<option value="' . htmlspecialchars($row['pay_center']) . '">' . htmlspecialchars($row['pay_center']) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
							    <div class="form-group col-md-3">
							     	<label for="inputState" >Employee Name (Employee Id) </label>
							     	<select id="employee" name="emp_id" class="form-control" required = "required">
							       		<option name="emp_id" selected value="">Select Employee Name / Employee Id</option>
										<?php
											foreach($employeeData as $row)
											{
												echo '<option value="'.$row['emp_name']." - ".$row['emp_id'].'">'.$row['emp_name']." (".$row['emp_id'].") ".'</option>';
											}
										?>
									</select>
								</div>
								<?php
                        		    if(is_array($urlAry) && $urlAry['option'] != "print"){ 
                        		?>
    							    <div class="form-group col-md-3">
    							     	<label for="inputState" >Year</label>
                                        <select id="year" name="year" class="form-control" required="required">
                                            <option value="" selected>Select Year</option>
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
    							<?php 
                        		    }
                        		?>
							</div>*/?>
							<div class="form-row no-print">
							    
								<?php
                        		    if(is_array($urlAry) && $urlAry['option'] != "print"){ 
                        		?>
                        		    <div class="form-group col-md-2">
                                    <label for="inputState">Pay Center</label>
                                    <select id="pay_center" name="pay_center" class="form-control" >
                                        <option selected value="">Select Pay Center</option>
                                        <?php
                                        foreach($paycenterData as $row) {
                                            echo '<option value="' . htmlspecialchars($row['pay_center']) . '">' . htmlspecialchars($row['pay_center']) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
							    <div class="form-group col-md-2">
							     	<label for="inputState" >Employee Name (Employee Id) </label>
							     	<select id="employee" name="emp_id" class="form-control" >
							       		<option name="emp_id" selected value="">Select Employee Name / Employee Id</option>
										<?php
											foreach($employeeData as $row)
											{
												echo '<option value="'.$row['emp_id'].'">'.$row['emp_name']." (".$row['emp_id'].") ".'</option>';
											}
										?>
									</select>
								</div>
    							    <div class="form-group col-md-2">
    							     	<label for="inputState" >Year</label>
                                        <select id="year" name="year" class="form-control" >
                                            <option value="" selected>Select Year</option>
                                            <?php
                                            for ($start = 2005; $start <= 2014; $start++) {
                                                $end = $start + 1;
                                                echo '<option value="' . htmlspecialchars($start) . '">' . htmlspecialchars($start . '-' . $end) . '</option>';
                                            }
                                            ?>
                                        </select>
    								</div>
    								<div class="form-group col-md-2">
                                        <label for="inputState">From Month</label>
                                        <select id="from_month" name="from_month" class="form-control" >
                                            <option selected value="">Select From Month</option>
                                            <?php
                                            foreach($months as $monthNo => $monthName) {
                                                echo '<option value="' . $monthNo . '">' . $monthName . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputState">From Month</label>
                                        <select id="to_month" name="to_month" class="form-control" >
                                            <option selected value="">Select To Month</option>
                                            <?php
                                            foreach($months as $monthNo => $monthName) {
                                                echo '<option value="' . $monthNo . '">' . $monthName . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
    									<label for="inputCity">Voucher No.</label>
    									<input type="text" name="voucher_no" id="voucher_no" class="form-control" placeholder="Voucher No." value="<?=$this->input->post("voucher_no");?>">
    							    </div>
                                    <div class="form-group col-md-2">
    									<label for="inputCity">Voucher Date</label>
    									<input type="text" name="voucher_date" id="voucher_date" class="form-control" placeholder="Voucher Date" value="<?=$this->input->post("voucher_date");?>">
    							    </div>
    							    <div class="col-sm-1">
    									<label for="inputState" class=""></label>
    									<input type="submit" class="btn btn-primary" id="search" value="Search" style="margin: 12px 0px 0px 0px">
    								</div>
    							<?php 
                        		    }
                        		?>
							</div>
							<br/><br/>
							<?php 
							    $months = [
                                    4 => "एप्रिल", 5 => "मे", 6 => "जुन", 7 => "जुलै", 8 => "ऑगस्ट", 
                                    9 => "सप्टेंबर", 10 => "ऑक्टोबर", 11 => "नोव्हेंबर", 12 => "डिसेंबर", 
                                    1 => "जानेवारी", 2 => "फेब्रुवारी", 3 => "मार्च"
                                ];
							?>
							<?php
							    if(!empty($ownerDetails) && $ownerDetails){
							    foreach ($ownerDetails as $ownerDetail) { 
							?>
                                <div class="searchTable new-page">
                                    <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                        <thead class="bg-primary123">
                                            <tr>
                                                <th style="text-align:center;" colspan="10">
                                                    नाशिक महानगरपालिका,नाशिक			</th>
                                            </tr>
                                            <tr>
                                                <th style="text-align:center;" colspan="10">
                                                    परिभाषित अंशदान निवृत्ती वेतन योजना - वार्षिक विवरण
(<?= $searchData['f_year']; ?>)                                                </th>
                                            </tr>
                                            <tr>
                                                <th>कर्मचारी क्रमांक</th>
                                                <td><?= !empty($ownerDetail['emp_id']) ? $ownerDetail['emp_id'] : ''; ?></td>
                                                <th>कर्मचारी नाव</th>
                                                <td colspan="7"><?= !empty($ownerDetail['emp_name']) ? $ownerDetail['emp_name'] : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <th>कर्मचारी नियुक्ती दिनांक</th>
                                                <td><?= !empty($ownerDetail['joining_date']) ? $ownerDetail['joining_date'] : ''; ?></td>
                                                <th>पे सेंटर</th>
                                                <td><?= !empty($ownerDetail['pay_center']) ? $ownerDetail['pay_center'] : ''; ?></td>
                                                <th colspan="1">हुद्दा</th>
                                                <td><?= !empty($ownerDetail['designation_name']) ? $ownerDetail['designation_name'] : ''; ?></td>
                                                <!--<th colspan="2">सुरुवातीची शिल्लक</th>-->
                                                <td colspan="4"></td>
                                            </tr>
                                            <tr>
                                                <th rowspan="2">महिना</th>
                                                
                                                <th colspan="2">कर्मचारी वर्गणी</th>
                                                <th colspan="2">मनपा वर्गणी</th>
                                                <th rowspan="2">कर्मचाऱ्याने काढलेल्या कर्ज रक्कमेचा हप्ता</th>
                                                <th rowspan="2">एकूण जमा</th>
                                                <th rowspan="2">अपेक्षित वर्गणी</th>
                                                <th rowspan="2">फरक </th>
                                                <th rowspan="2">काढलेल्या कर्जाची रक्कम</th>
                                            </tr>
                                            <tr>
                                                <th>नियमित वेतन</th>
                                                <th>पुरवणी वेतन</th>
                                                <th>नियमित वेतन</th>
                                                <th>पुरवणी वेतन</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            
                                            //echo "<pre>"; print_r($dcpsDetails); exit;
                                            $mo = 1;
                                            $totalIdealContribution = $totalEmpContri = $totalGovContri = $totalLoanInstallment = $totalTotAmount = $totalLoanAmount = 0;
                                            $totalEmpSuplimentoryContri = 0;
                                            $totalGovSuplimentoryContri = 0;
                                            $fromMonth = (isset($searchData['from_month']) && $searchData['from_month'] !== '') ? (int)$searchData['from_month'] : null;
                                            $toMonth = (isset($searchData['to_month']) && $searchData['to_month'] !== '') ? (int)$searchData['to_month'] : null;
                            
                                            foreach ($months as $monthNo => $monthName) {
                                                if ($fromMonth !== null && $toMonth !== null) {
                                                    if ($monthNo < $fromMonth || $monthNo > $toMonth) {
                                                        continue;
                                                    }
                                                } elseif ($fromMonth !== null) {
                                                    if ($monthNo !== $fromMonth) {
                                                        continue;
                                                    }
                                                } elseif ($toMonth !== null) {
                                                    if ($monthNo !== $toMonth) {
                                                        continue;
                                                    }
                                                }
                                                //echo $ownerDetail['emp_id']; 
                                                if($ownerDetail['emp_id'] == 8905){
                                            /*echo "<pre>";
                                            print_r($dcpsDetails[$ownerDetail['emp_id']]); exit;*/
                                                }
                                                if (empty($dcpsDetails[$ownerDetail['emp_id']][$monthNo])) {
                                                    continue; // skip blank months with no data
                                                }
                                                $idealContribution = !empty($dcpsDetails[$ownerDetail['emp_id']][$monthNo]['ideal_contribution']) 
                                                    ? $dcpsDetails[$ownerDetail['emp_id']][$monthNo]['ideal_contribution'] 
                                                    : 0;
                                                $empContri = !empty($dcpsDetails[$ownerDetail['emp_id']][$monthNo]['emp_DCPS_contribution']) 
                                                    ? $dcpsDetails[$ownerDetail['emp_id']][$monthNo]['emp_DCPS_contribution'] 
                                                    : 0;
                                                    $empSuplimentoryContri = !empty($dcpsDetails[$ownerDetail['emp_id']][$monthNo]['emp_DCPS_supplimentory_contribution']) 
                                                    ? $dcpsDetails[$ownerDetail['emp_id']][$monthNo]['emp_DCPS_supplimentory_contribution'] 
                                                    : 0;
                                                    
                                                $govContri = !empty($dcpsDetails[$ownerDetail['emp_id']][$monthNo]['NMC_DCPS_contribution']) 
                                                    ? $dcpsDetails[$ownerDetail['emp_id']][$monthNo]['NMC_DCPS_contribution'] 
                                                    : 0;
                                                    $govSuplimentoryContri = !empty($dcpsDetails[$ownerDetail['emp_id']][$monthNo]['NMC_supplimentory_DCPS_contribution']) 
                                                    ? $dcpsDetails[$ownerDetail['emp_id']][$monthNo]['NMC_supplimentory_DCPS_contribution'] 
                                                    : 0;
                                                    
                                                $loanInstallment = !empty($dcpsDetails[$ownerDetail['emp_id']][$monthNo]['loan_installment_paid_through_salary']) 
                                                    ? $dcpsDetails[$ownerDetail['emp_id']][$monthNo]['loan_installment_paid_through_salary'] 
                                                    : 0;
                                                /* $totalAmount = $empContri + $empSuplimentoryContri + $govContri + $govSuplimentoryContri + $loanInstallment */ ;
                                                $totalAmount = ($empContri + $empSuplimentoryContri);
                                                $loanAmount = !empty($dcpsDetails[$ownerDetail['emp_id']][$monthNo]['DCPS_loan_taken_by_an_employee']) 
                                                    ? $dcpsDetails[$ownerDetail['emp_id']][$monthNo]['DCPS_loan_taken_by_an_employee'] 
                                                    : 0;
                                                $totalIdealContribution+= $idealContribution;
                                                $totalEmpContri+= $empContri;
                                                $totalEmpSuplimentoryContri+= $empSuplimentoryContri;
                                                $totalGovContri+= $govContri;
                                                $totalGovSuplimentoryContri+= $govSuplimentoryContri;
                                                $totalLoanInstallment += $loanInstallment;
                                                $totalTotAmount += $totalAmount;
                                                $totalLoanAmount += $loanAmount;
                                            ?>
                                                <tr>
                                                    <td><?= $monthName; ?> <?= ($monthNo >= 1 && $monthNo <= 3) ? ($searchData['second_year']) : $searchData['first_year']; ?></td>
                                                    
                                                    <td><?= $empContri; ?></td>
                                                    <td><?=$empSuplimentoryContri;?></td>
                                                    <td><?= $govContri; ?></td>
                                                    <td><?=$govSuplimentoryContri;?></td>
                                                    <td><?= $loanInstallment; ?></td>
                                                    <td><?= $totalAmount; ?></td>
                                                    <td><?=$idealContribution;?></td>
                                                    <td><?=($totalAmount-$idealContribution);?></td>
                                                    <td><?= $loanAmount; ?></td>
                                                </tr>
                                            <?php 
                                            $mo++; 
                                            } 
                                        
                                        ?>
                                            <tr>
                                                <th>एकुण <?= $searchData['f_year']; ?></th>
                                                
                                                <th><?=$totalEmpContri;?></th>
                                                <th><?=$totalEmpSuplimentoryContri;?></th>
                                                <th><?= $totalGovContri; ?></th>
                                                <th><?=$totalGovSuplimentoryContri;?></th>
                                                <th><?= $totalLoanInstallment; ?></th>
                                                <th><?= $totalTotAmount; ?></th>
                                                <th><?= $totalIdealContribution; ?></th>
                                                <th><?=($totalTotAmount-$totalIdealContribution);?></th>
                                                <th><?= $totalLoanAmount; ?></th>
                                            </tr>
                                            <!--<tr>
                                                <th colspan="8" style="text-align: right">एकुण कर्मचारी वर्गणी व कर्मचाऱ्याने काढलेल्या कर्ज रक्कमेचा हप्ता : जमा (+)</th>
                                                <th><?= $interestDetail[$ownerDetail['emp_id']]['emp_contri']; ?></th>
                                            </tr>
                                            <tr>
                                                <th colspan="8" style="text-align: right">शासकीय वर्गणी</th>
                                                <th><?= $interestDetail[$ownerDetail['emp_id']]['nmc_contri']; ?></th>
                                            </tr>
                                            <tr>
                                                <th colspan="8" style="text-align: right">एकुण जमा</th>
                                                <th><?= $interestDetail[$ownerDetail['emp_id']]['total_contri']; ?></th>
                                            </tr>
                                            <tr>
                                                <th colspan="8" style="text-align: right">काढलेल्या कर्जाची रक्कम (-)</th>
                                                <th><?= $interestDetail[$ownerDetail['emp_id']]['loan_amount']; ?></th>
                                            </tr>-->
                                        </tbody>
                                    </table>
                                </div>
                            <?php 
							    }
							  } 
                            ?>

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
<script language="javascript" src="<?=base_url();?>assets/javascript/jquery.printPage.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
	    $(document).ready(function() {
			$(".btnPrint").printPage();
		});
		
		 $("#voucher_date").datepicker({ format: 'dd-mm-yyyy',orientation: "bottom" }); 
        
			
		$('#employee, #pay_center').select2();
		<?php if($this->input->post('emp_id')){?>
		    $('#employee').val('<?=$this->input->post('emp_id');?>').select2();
		    /*$("#employee").select().select2("val", "<?=$this->input->post('emp_id');?>"); */
		<?php } ?>
		
		<?php if($this->input->post('year')){?>
		    //alert(<?=$this->input->post('year');?>);
		    $('#year').val('<?=$this->input->post('year');?>');
		<?php } ?>
		
		// Set pay center value (must be set before calling getEmployeeDetails)
        <?php if($this->input->post('pay_center')) { ?>
            $('#pay_center').val('<?= $this->input->post('pay_center'); ?>').trigger('change');
        <?php } ?>
        
        <?php if($this->input->post('from_month')) { ?>
            $('#from_month').val('<?= $this->input->post('from_month'); ?>').trigger('change');
        <?php } ?>
        
        <?php if($this->input->post('to_month')) { ?>
            $('#to_month').val('<?= $this->input->post('to_month'); ?>').trigger('change');
        <?php } ?>
    
        // Set year if needed
        <?php if($this->input->post('year')){?>
            $('#year').val('<?= $this->input->post('year'); ?>');
        <?php } ?>
    
        // On change, fetch employee details
        $('#pay_center').on('change', function() {
            getEmployeeDetails(); 
        });
    
        // Function to fetch employee details based on pay center
        function getEmployeeDetails() {
            
            var payCenter = $("#pay_center").val();
            var selectedEmpId = '<?= $this->input->post('emp_id') ?>'; 
            $('#employee').val(selectedEmpId).trigger('change');
    
            return true;
            if (payCenter !== "") {
                $.ajax({
                    url: '<?= base_url("get-employee-details") ?>',
                    type: 'POST',
                    data: { pay_center: payCenter },
                    dataType: 'json',
                    success: function(response) {
                        $('#employee').empty().append('<option value="">Select Employee Name / Employee Id</option>');
                        
                        if (response && response.length > 0) {
                            $.each(response, function(index, employee) {
                                var optionValue = employee.emp_id;
                                var optionText = employee.emp_name + " (" + employee.emp_id + ")";
                                var selected = (optionValue === selectedEmpId) ? ' selected' : '';
                                $('#employee').append('<option value="' + optionValue + '"' + selected + '>' + optionText + '</option>');
                            });
    
                            // Trigger change for Select2 UI update
                            $('#employee').val(selectedEmpId).trigger('change');
                        }
                    },
                    error: function(xhr) {
                        console.error("Error:", xhr.responseText);
                    }
                });
            } else {
                //$('#employee').html('<option value="">Select Employee Name / Employee Id</option>');
            }
            $('#employee').val(selectedEmpId).trigger('change');
        }
    
        // Initial call to load employee list based on pay center
        getEmployeeDetails();
		
	});
	</script>						
