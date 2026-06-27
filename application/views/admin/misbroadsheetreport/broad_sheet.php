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
<?php //echo "<pre>";print_r($broadSheetSummary);die(); ?>
<div class="content-wrapper" style="min-height: 970.3px; height: auto !important;">
    <section class="content-header">
        <div class="heading-icon-badge"><img src="<?php echo base_url('assets/images/broadsheet_report.jpg'); ?>" alt="Broad Sheet Report (Year-Wise)"></div>
        <h1>Broad Sheet Report (Year-Wise)</h1>
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
                        <h3 class="box-title">Broad Sheet Report - Financial Year Summary</h3>
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
                        <form action="" method="post" name="broadsheet_form" id="broadsheet_form" enctype="multipart/form-data" >
							<div class="form-row">
							    <div class="form-group col-md-3">
							     	<label for="inputState" >Financial Year</label>
							     	<select id="year" name="year" class="form-control" required="required">
                                    	<option value="">-- Select Year --</option>
                                    	<?php
                                            for ($start = 2005; $start <= 2014; $start++) {
                                                $end = $start + 1;
                                                $selected = (isset($firstYear) && $firstYear == $start) ? 'selected' : '';
                                                echo '<option value="' . htmlspecialchars($start) . '" ' . $selected . '>' . htmlspecialchars($start . '-' . $end) . '</option>';
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
							
							<?php if(isset($broadSheetSummary) && !empty($broadSheetSummary)): ?>
							
							<!-- Interest Rates Header -->
							<div class="searchTable">
                        		<table class="table table-striped table-bordered" cellspacing="0" width="100%">
                        			<tr class="bg-primary">
										<th colspan="8" style="text-align: center; padding: 10px; font-weight: bold;">
											Financial Year: <?=$broadSheetSummary['financial_year'];?>
										</th>
									</tr>
                        			<tr>
										<th width="20%">Interest Rate (Apr-Nov <?=$broadSheetSummary['first_year'];?>)</th>
										<td width="15%" style="text-align: center;"><strong><?=isset($interestRates[4]) ? $interestRates[4] : 0;?>%</strong></td>
										<th width="20%">Interest Rate (Dec <?=$broadSheetSummary['first_year'];?> - Mar <?=$broadSheetSummary['second_year'];?>)</th>
										<td width="15%" style="text-align: center;"><strong><?=isset($interestRates[12]) ? $interestRates[12] : 0;?>%</strong></td>
										<th width="20%">Opening Balance</th>
										<td colspan="3" style="text-align: right; font-weight: bold; padding-right: 20px;">
											₹ <?=number_format($broadSheetSummary['opening_balance'], 0);?>
										</td>
									</tr>
								</table>
							</div>
							
							<!-- Month-wise Breakdown -->
							<div class="searchTable" style="margin-top: 20px;">
                        		<table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                        			<thead class="bg-info">
										<tr>
											<th>Month</th>
											<th style="text-align: right;">Employee Contribution</th>
											<th style="text-align: right;">Corporation Contribution</th>
											<th style="text-align: right;">Loan Installment</th>
											<th style="text-align: right;">Total Deposits</th>
											<th style="text-align: right;">Loan Withdrawn</th>
											<th style="text-align: right;">Interest</th>
											<th style="text-align: right;">Balance</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										$months = array(
											4=>"April", 5=>"May", 6=>"June", 7=>"July", 
											8=>"August", 9=>"September", 10=>"October", 11=>"November", 
											12=>"December", 1=>"January", 2=>"February", 3=>"March"
										);
										
										$totalEmpContri = 0;
										$totalNmcContri = 0;
										$totalLoanInst = 0;
										$totalDeposits = 0;
										$totalLoanWithdrawn = 0;
										$totalInterest = 0;
										
										foreach($months as $monthNo => $monthName){
											$monthData = isset($broadSheetSummary['monthly_details'][$monthNo]) 
												? $broadSheetSummary['monthly_details'][$monthNo] 
												: array();
											
											$emp = isset($monthData['emp_regular']) ? $monthData['emp_regular'] : 0;
											$emp += isset($monthData['emp_supp']) ? $monthData['emp_supp'] : 0;
											$nmc = isset($monthData['nmc_regular']) ? $monthData['nmc_regular'] : 0;
											$nmc += isset($monthData['nmc_supp']) ? $monthData['nmc_supp'] : 0;
											$loanInst = isset($monthData['loan_installment']) ? $monthData['loan_installment'] : 0;
											$loanTaken = isset($monthData['loan_taken']) ? $monthData['loan_taken'] : 0;
											$interest = isset($monthData['interest']) ? $monthData['interest'] : 0;
											$closing = isset($monthData['monthly_closing']) ? $monthData['monthly_closing'] : 0;
											
											$deposits = $emp + $nmc + $loanInst;
											
											$totalEmpContri += $emp;
											$totalNmcContri += $nmc;
											$totalLoanInst += $loanInst;
											$totalDeposits += $deposits;
											$totalLoanWithdrawn += $loanTaken;
											$totalInterest += $interest;
											
											$year = ($monthNo >= 4) ? $broadSheetSummary['first_year'] : $broadSheetSummary['second_year'];
										?>
										<tr>
											<td><strong><?=$monthName . ' ' . $year;?></strong></td>
											<td style="text-align: right;">₹ <?=number_format($emp, 0);?></td>
											<td style="text-align: right;">₹ <?=number_format($nmc, 0);?></td>
											<td style="text-align: right;">₹ <?=number_format($loanInst, 0);?></td>
											<td style="text-align: right;">₹ <?=number_format($deposits, 0);?></td>
											<td style="text-align: right;">₹ <?=number_format($loanTaken, 0);?></td>
											<td style="text-align: right;">₹ <?=number_format($interest, 0);?></td>
											<td style="text-align: right; font-weight: bold;">₹ <?=number_format($closing, 0);?></td>
										</tr>
										<?php 
										}
										?>
									</tbody>
									<tfoot class="bg-light">
										<tr style="font-weight: bold; background-color: #f5f5f5;">
											<td>TOTAL <?=$broadSheetSummary['financial_year'];?></td>
											<td style="text-align: right;">₹ <?=number_format($totalEmpContri, 0);?></td>
											<td style="text-align: right;">₹ <?=number_format($totalNmcContri, 0);?></td>
											<td style="text-align: right;">₹ <?=number_format($totalLoanInst, 0);?></td>
											<td style="text-align: right;">₹ <?=number_format($totalDeposits, 0);?></td>
											<td style="text-align: right;">₹ <?=number_format($totalLoanWithdrawn, 0);?></td>
											<td style="text-align: right;">₹ <?=number_format($totalInterest, 0);?></td>
											<td style="text-align: right;">₹ <?=number_format($broadSheetSummary['closing_balance'], 0);?></td>
										</tr>
									</tfoot>
								</table>
							</div>
							
							<!-- Summary Section -->
							<div class="searchTable" style="margin-top: 20px;">
                        		<table class="table table-striped table-bordered" cellspacing="0" width="100%">
                        			<thead class="bg-success">
										<tr>
											<th colspan="2" style="text-align: center; font-weight: bold; font-size: 16px;">FINANCIAL SUMMARY</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td width="70%"><strong>Opening Balance (Prev. Year Closing)</strong></td>
											<td style="text-align: right; padding-right: 20px;">₹ <?=number_format($broadSheetSummary['opening_balance'], 0);?></td>
										</tr>
										<tr>
											<td><strong>Total Employee Contribution</strong></td>
											<td style="text-align: right; padding-right: 20px;">₹ <?=number_format($broadSheetSummary['total_emp_contribution'], 0);?></td>
										</tr>
										<tr>
											<td><strong>Total Corporation Contribution</strong></td>
											<td style="text-align: right; padding-right: 20px;">₹ <?=number_format($broadSheetSummary['total_corp_contribution'], 0);?></td>
										</tr>
										<tr>
											<td><strong>Total Loan Installment (Repayment)</strong></td>
											<td style="text-align: right; padding-right: 20px;">₹ <?=number_format($broadSheetSummary['loan_installment'], 0);?></td>
										</tr>
										<tr style="background-color: #e8f5e9; font-weight: bold;">
											<td><strong>Total Deposits (+)</strong></td>
											<td style="text-align: right; padding-right: 20px;">₹ <?=number_format($broadSheetSummary['total_deposits'], 0);?></td>
										</tr>
										<tr>
											<td><strong>Total Withdrawals / Loans Taken (-)</strong></td>
											<td style="text-align: right; padding-right: 20px;">₹ <?=number_format($broadSheetSummary['total_withdrawals'], 0);?></td>
										</tr>
										<tr>
											<td><strong>Total Interest Accrued (+)</strong></td>
											<td style="text-align: right; padding-right: 20px;">₹ <?=number_format($broadSheetSummary['total_interest'], 0);?></td>
										</tr>
										<tr style="background-color: #fff3cd; font-weight: bold; font-size: 16px;">
											<td><strong>Closing Balance (March <?=$broadSheetSummary['second_year'];?>)</strong></td>
											<td style="text-align: right; padding-right: 20px; font-size: 16px;">₹ <?=number_format($broadSheetSummary['closing_balance'], 0);?></td>
										</tr>
									</tbody>
								</table>
							</div>
							
							<!-- Calculation Note -->
							<div class="alert alert-info" style="margin-top: 20px;">
								<strong>Calculation Logic:</strong><br/>
								Closing Balance = Opening Balance + Total Deposits - Total Withdrawals + Total Interest<br/>
								= ₹ <?=number_format($broadSheetSummary['opening_balance'], 0);?> + ₹ <?=number_format($broadSheetSummary['total_deposits'], 0);?> - ₹ <?=number_format($broadSheetSummary['total_withdrawals'], 0);?> + ₹ <?=number_format($broadSheetSummary['total_interest'], 0);?> = <strong>₹ <?=number_format($broadSheetSummary['closing_balance'], 0);?></strong>
							</div>
							
							<?php else: ?>
							<div class="alert alert-info">
								<strong>Info:</strong> Select a financial year and click 'Search' to view the Broad Sheet Report.
							</div>
							<?php endif; ?>
							
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
		<?php if($this->input->post('year')){?>
		    $('#year').val('<?=$this->input->post('year');?>');
		<?php } ?>
	});
	</script>						