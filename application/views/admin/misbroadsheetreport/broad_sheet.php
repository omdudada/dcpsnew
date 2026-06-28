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
	
	table td{
        text-align: center;
    }
    table td.clsCenter{
        text-align: center;   
    }
    
    table td.clsRight, table th.clsRight{
        text-align: right;
    }
    table td.clsLeft{
        text-align: left;
    }
    .broad-sheet-summary-cell {
        /*border: 1px solid #ccc !important;*/
    }
    table tfoot th, table tfoot td, table tfoot td.broad-sheet-summary-cell{
       border: 1px solid #1a4a7a !important;
       background: none !important;
    }
</style>

<div class="content-wrapper" style="min-height: 970.3px; height: auto !important;">
     <section class="content-header">
        <div class="clsHeading"><img src="<?php echo base_url('assets/images/broadsheet_report.jpg'); ?>" alt="Broad Sheet Report (Year-Wise)"></div>
        <h1>Broad Sheet Report (Year-Wise)</h1>
	</section>
	
    <?php if(validation_errors()){?>
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<?php echo validation_errors();?>
		</div>
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
                        <form action="" method="post" name="typicaltypes" id="typicaltypes" enctype="multipart/form-data" >
							<div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="pay_center">Pay Center</label>
                                        <select id="pay_center" name="pay_center" class="form-control" >
                                            <option selected value="">Select Pay Center</option>
                                            <?php
                                                foreach($paycenterData as $row) {
                                                    echo '<option value="' . htmlspecialchars($row['pay_center']) . '">' . htmlspecialchars($row['pay_center']) . '</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="employee">Employee Name (Employee Id) </label>
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
							    <div class="form-group col-md-3">
							     	<label for="year" >Year</label>
							     	<select id="year" name="year" class="form-control" required ="required">
                                     	<option value="">Select Year</option>
                                     	<?php
                                             for ($start = 2005; $start <= 2014; $start++) {
                                                 $end = $start + 1;
                                                 echo '<option value="' . htmlspecialchars($start) . '">' . htmlspecialchars($start . '-' . $end) . '</option>';
                                             }
                                             ?>
                                     </select>
								</div>
							    <div class="col-sm-1">
									<label class=""></label>
									<input type="submit" class="btn btn-primary" id="search" value="Search" style="margin: 25px 0px 0px 0px">
								</div>
							</div>
							<br/><br/>
							
                            <?php if(!empty($ownerDetail) && !empty($dcpsDetails)){ ?>
                                <div class="searchTable" style="margin-top: 20px;">
                                    
                                    <!-- Basic Information Table -->
                                    <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                        <thead class="bg-primary123">
                                            <tr>
                                                <th style="text-align:left; width:25%;">कर्मचारी क्रमांक</th>
                                                <td style="text-align:left; width:25%;"><?= !empty($ownerDetail['emp_id']) ? $ownerDetail['emp_id'] : ''; ?></td>
                                                <th style="text-align:left; width:25%;">कर्मचारी नाव</th>
                                                <td style="text-align:left; width:25%;"><?= !empty($ownerDetail['emp_name']) ? $ownerDetail['emp_name'] : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <th style="text-align:left;">कर्मचारी नियुक्ती दिनांक</th>
                                                <td style="text-align:left;"><?= !empty($ownerDetail['joining_date']) ? $ownerDetail['joining_date'] : ''; ?></td>
                                                <th style="text-align:left;">पे सेंटर</th>
                                                <td style="text-align:left;"><?= !empty($ownerDetail['pay_center']) ? $ownerDetail['pay_center'] : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <th style="text-align:left;">हुद्दा</th>
                                                <td style="text-align:left;" colspan="3"><?= !empty($ownerDetail['designation_name']) ? $ownerDetail['designation_name'] : ''; ?></td>
                                            </tr>
                                        </thead>
                                    </table>
                                    
                                    <!-- Broad Sheet Table -->
                                    <table id="" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="margin-top: 15px;">
                                        <thead class="bg-primary123">
                                            <tr>
                                                <th class="">व्याज दर (1) (एप्रिल <?=$this->input->post("year");?> ते नोव्हेंबर <?=$this->input->post("year");?>)</th>
                                                <td><?=isset($interestRates[4]) ? $interestRates[4] : '';?>%</td>
                                                <th class="">व्याज दर (2) (डिसेंबर <?=$this->input->post("year");?> ते मार्च <?=((int)$this->input->post("year")+1);?>)</th>
                                                <td><?=isset($interestRates[12]) ? $interestRates[12] : '';?>%</td>
                                                <th class="" colspan="3">सुरवातीची शिल्लक</th>
                                                <td class="clsRight"><?=number_format($interestDetail['opening_balance'], 2, '.', '');?></td>
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
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $months = array(
                                                    4 => "एप्रिल",
                                                    5 => "मे",
                                                    6 => "जुन",
                                                    7 => "जुलै",
                                                    8 => "ऑगस्ट",
                                                    9 => "सप्टेंबर",
                                                    10 => "ऑक्टोबर",
                                                    11 => "नोव्हेंबर",
                                                    12 => "डिसेंबर",
                                                    1 => "जानेवारी",
                                                    2 => "फेब्रुवारी",
                                                    3 => "मार्च"
                                                );
                                                
                                                $totalEmpContri = $totalGovContri = $totalLoanInstallment = $totalTotAmount = $totalLoanAmount = $totalMonthlyAmount = $totalInterestAmount = 0;
                                                
                                                foreach($months as $monthNo => $monthName){
                                                    $empContri = isset($dcpsDetails[$monthNo]['emp_DCPS_contribution']) ? $dcpsDetails[$monthNo]['emp_DCPS_contribution'] : 0;
                                                    $govContri = isset($dcpsDetails[$monthNo]['NMC_DCPS_contribution']) ? $dcpsDetails[$monthNo]['NMC_DCPS_contribution'] : 0;
                                                    $loanInstallment = isset($dcpsDetails[$monthNo]['loan_installment_paid_through_salary']) ? $dcpsDetails[$monthNo]['loan_installment_paid_through_salary'] : 0;
                                                    
                                                    $totalAmount = $empContri + $govContri + $loanInstallment;
                                                    $loanAmount = isset($dcpsDetails[$monthNo]['DCPS_loan_taken_by_an_employee']) ? $dcpsDetails[$monthNo]['DCPS_loan_taken_by_an_employee'] : 0;
                                                    
                                                    $grandAmount = isset($dcpsDetails[$monthNo]['interest_base']) ? $dcpsDetails[$monthNo]['interest_base'] : 0;
                                                    $interest = isset($dcpsDetails[$monthNo]['interest']) ? $dcpsDetails[$monthNo]['interest'] : 0;
                                                    
                                                    $totalEmpContri += $empContri;
                                                    $totalGovContri += $govContri;
                                                    $totalLoanInstallment += $loanInstallment;
                                                    $totalTotAmount += $totalAmount;
                                                    $totalLoanAmount += $loanAmount;
                                                    $totalMonthlyAmount += $grandAmount;
                                                    $totalInterestAmount += $interest;
                                                ?>
                                                    <tr>
                                                        <td class="clsCenter"><?=$monthName;?> <?=($monthNo >= 1 && $monthNo <= 3) ? ((int)$this->input->post('year') + 1) : $this->input->post('year');?></td>
                                                        <td class="clsRight"><?=number_format($empContri, 2, '.', '');?></td>
                                                        <td class="clsRight"><?=number_format($govContri, 2, '.', '');?></td>
                                                        <td class="clsRight"><?=number_format($loanInstallment, 2, '.', '');?></td>
                                                        <td class="clsRight"><?=number_format($totalAmount, 2, '.', '');?></td>
                                                        <td class="clsRight"><?=number_format($loanAmount, 2, '.', '');?></td>
                                                        <td class="clsRight"><?=number_format($grandAmount, 2, '.', '');?></td>
                                                        <td class="clsRight"><?=number_format($interest, 2, '.', '');?></td>
                                                    </tr>
                                                <?php 
                                                }
                                            ?>
                                        </tbody>
                                        <tfoot>                                                <tr style="background-color: #e6f7ff; font-weight: bold;">
                                                <th class="broad-sheet-summary-cell">एकुण <?=$this->input->post('year');?>-<?=((int)$this->input->post('year') + 1);?></th>
                                                <th class="clsRight broad-sheet-summary-cell"><?=number_format($totalEmpContri, 2, '.', '');?></th>
                                                <th class="clsRight broad-sheet-summary-cell"><?=number_format($totalGovContri, 2, '.', '');?></th>
                                                <th class="clsRight broad-sheet-summary-cell"><?=number_format($totalLoanInstallment, 2, '.', '');?></th>
                                                <th class="clsRight broad-sheet-summary-cell"><?=number_format($totalTotAmount, 2, '.', '');?></th>
                                                <th class="clsRight broad-sheet-summary-cell"><?=number_format($totalLoanAmount, 2, '.', '');?></th>
                                                <th class="clsRight broad-sheet-summary-cell"><?=number_format($totalMonthlyAmount, 2, '.', '');?></th>
                                                <th class="clsRight broad-sheet-summary-cell"><?=number_format($totalInterestAmount, 2, '.', '');?></th>
                                            </tr>	
                                            <tr>
                                                <th colspan="7" class="broad-sheet-summary-cell" style="text-align: right">सुरुवातीची शिल्लक</th>
                                                <th class="clsRight broad-sheet-summary-cell"><?=number_format($interestDetail['opening_balance'], 2, '.', '');?></th>
                                            </tr>
                                            <tr>
                                                <th colspan="7" class="broad-sheet-summary-cell" style="text-align: right">एकुण कर्मचारी वर्गणी व कर्मचाऱ्याने काढलेल्या कर्ज रक्कमेचा हप्ता : जमा (+)</th>
                                                <th class="clsRight broad-sheet-summary-cell"><?=number_format($interestDetail['emp_contri'], 2, '.', '');?></th>
                                            </tr>
                                            <tr>
                                                <th colspan="7" class="broad-sheet-summary-cell" style="text-align: right">शासकीय वर्गणी</th>
                                                <th class="clsRight broad-sheet-summary-cell"><?=number_format($interestDetail['nmc_contri'], 2, '.', '');?></th>
                                            </tr>
                                            <tr>
                                                <th colspan="7" class="broad-sheet-summary-cell" style="text-align: right">एकुण जमा (सुरवातीची शिलकेसह)</th>
                                                <th class="clsRight broad-sheet-summary-cell"><?=number_format($interestDetail['total_contri'], 2, '.', '');?></th>
                                            </tr>
                                            <tr>
                                                <th colspan="7" class="broad-sheet-summary-cell" style="text-align: right">काढलेल्या कर्जाची रक्कम (-)</th>
                                                <th class="clsRight broad-sheet-summary-cell"><?=number_format($interestDetail['loan_amount'], 2, '.', '');?></th>
                                            </tr>
                                            <tr>
                                                <th colspan="7" class="broad-sheet-summary-cell" style="text-align: right">मिळणाऱ्या व्याजाची रक्कम (+)</th>
                                                <th class="clsRight broad-sheet-summary-cell"><?=number_format($interestDetail['interest'], 2, '.', '');?></th>
                                            </tr>
                                            <tr style="background-color: #e6f7ff; font-weight: bold;">
                                                <th colspan="7" class="broad-sheet-summary-cell" style="text-align: right; font-size: 14px;">मार्च अखेर शिल्लक (+)</th>
                                                <th class="clsRight broad-sheet-summary-cell" style="font-size: 14px;"><?=number_format($interestDetail['grand_total'], 2, '.', '');?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            <?php 
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#employee, #pay_center').select2();
        
        <?php if($this->input->post('pay_center')) { ?>
            $('#pay_center').val('<?= $this->input->post('pay_center'); ?>').trigger('change');
        <?php } ?>
        
        <?php if($this->input->post('emp_id')) { ?>
            $('#employee').val('<?= $this->input->post('emp_id'); ?>').trigger('change');
        <?php } ?>
        
        <?php if($this->input->post('year')) { ?>
            $('#year').val('<?= $this->input->post('year'); ?>');
        <?php } ?>
        
        $('#pay_center').on('change', function() {
            getEmployeeDetails(); 
        });
        
        function getEmployeeDetails() {
            var payCenter = $("#pay_center").val();
            var selectedEmpId = '<?= $this->input->post('emp_id') ?>'; 
            $('#employee').val(selectedEmpId).trigger('change');
            return true;
        }
        
        getEmployeeDetails();
	});
</script>