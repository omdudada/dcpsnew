<style type="text/css">
    .no-print { }
    <?php if(isset($urlAry['option']) && in_array($urlAry['option'], array('print','excel'), true)){ ?>
    .no-print { display:none; }
    <?php } ?>

    .emp-pill{
        display:inline-block;
        padding:3px 10px;
        border:1px solid #333;
        border-radius:999px;
        font-weight:700;
        background:#f7f7f7;
        min-width:70px;
        text-align:center;
    }

    @media print {
        .no-print { display:none; }
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #000 !important; padding:4px; text-align:center; }
    }
</style>

<?php
    $months = [
        4 => "एप्रिल", 5 => "मे", 6 => "जुन", 7 => "जुलै", 8 => "ऑगस्ट",
        9 => "सप्टेंबर", 10 => "ऑक्टोबर", 11 => "नोव्हेंबर", 12 => "डिसेंबर",
        1 => "जानेवारी", 2 => "फेब्रुवारी", 3 => "मार्च"
    ];

    $isPrint = (isset($urlAry['option']) && $urlAry['option'] === 'print');
    $isExcel = (isset($urlAry['option']) && $urlAry['option'] === 'excel');

    function _n0($v){ return number_format((float)$v, 0, '.', ''); }
?>

<div class="content-wrapper" style="min-height: 970.3px; height: auto !important;">
    <section class="content-header">
        <h1>Final Ledger Report</h1>
    </section>

	<section class="content" style="height: auto !important; min-height: 0px !important;">
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-header with-border no-print">
                        <h3 class="box-title">Final Ledger Report</h3>
                        <?php if(!empty($this->input->post('year'))){ ?>
                            <a class="btn btn-primary" style="float:right; margin-left:8px;" href="<?=base_url();?>admin/misreport/final_ledger_report/year/<?=$this->input->post('year');?>/option/print">Print</a>
                            <a class="btn btn-success" style="float:right;" href="<?=base_url();?>admin/misreport/final_ledger_report/year/<?=$this->input->post('year');?>/option/excel">Export Excel</a>
                        <?php } ?>
					</div>

                    <div class="box-body">
                        <form action="" method="post" name="finalLedgerForm" id="finalLedgerForm" enctype="multipart/form-data" class="no-print">
							<div class="form-row">
                        		<div class="form-group col-md-2">
                                    <label for="pay_center">Pay Center</label>
                                    <select id="pay_center" name="pay_center" class="form-control" >
                                        <option selected value="">Select Pay Center</option>
                                        <?php if(!empty($paycenterData)){ foreach($paycenterData as $row){ ?>
                                            <option value="<?=htmlspecialchars($row['pay_center']);?>"><?=htmlspecialchars($row['pay_center']);?></option>
                                        <?php }} ?>
                                    </select>
                                </div>
							    <div class="form-group col-md-2">
							     	<label for="employee">Employee Name (Employee Id)</label>
							     	<select id="employee" name="emp_id" class="form-control" >
							       		<option name="emp_id" selected value="">Select Employee Name / Employee Id</option>
										<?php if(!empty($employeeData)){ 
										    //echo "<pre>"; print_r($employeeData); exit; 
										    foreach($employeeData as $row){ ?>
											    <option value="<?=$row['emp_id'];?>"><?=$row['emp_name'];?> (<?=$row['emp_id'];?>)
											    </option>
										<?php }} ?>
									</select>
								</div>
    							<div class="form-group col-md-2">
    								<label for="year">Year</label>
                                    <select id="year" name="year" class="form-control" >
                                        <option value="" selected>Select Year</option>
                                        <?php for ($start = 2005; $start <= 2014; $start++){ $end = $start + 1; ?>
                                            <option value="<?=htmlspecialchars($start);?>"><?=htmlspecialchars($start . '-' . $end);?></option>
                                        <?php } ?>
                                    </select>
    							</div>
    							<div class="form-group col-md-2">
                                    <label for="from_month">From Month</label>
                                    <select id="from_month" name="from_month" class="form-control" >
                                        <option selected value="">Select From Month</option>
                                        <?php foreach($months as $monthNo => $monthName) { ?>
                                            <option value="<?=$monthNo;?>"><?=$monthName;?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="to_month">To Month</label>
                                    <select id="to_month" name="to_month" class="form-control" >
                                        <option selected value="">Select To Month</option>
                                        <?php foreach($months as $monthNo => $monthName) { ?>
                                            <option value="<?=$monthNo;?>"><?=$monthName;?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
									<label for="voucher_no">Voucher No.</label>
									<input type="text" name="voucher_no" id="voucher_no" class="form-control" placeholder="Voucher No." value="<?=$this->input->post("voucher_no");?>">
							    </div>
                                <div class="form-group col-md-2">
									<label for="voucher_date">Voucher Date</label>
									<input type="text" name="voucher_date" id="voucher_date" class="form-control" placeholder="Voucher Date" value="<?=$this->input->post("voucher_date");?>">
							    </div>
                                <div class="col-sm-1">
									<label class=""></label>
									<input type="submit" class="btn btn-primary" id="search" value="Search" style="margin: 12px 0px 0px 0px">
								</div>
							</div>
                        </form>

                        <?php if(!empty($ownerDetails) && !empty($finalLedger) && !empty($searchData['f_year'])){ ?>
                            <?php foreach ($ownerDetails as $ownerDetail) {
                                $empId = (int)$ownerDetail['emp_id'];
                                if(empty($finalLedger[$empId])){ continue; }
                                $ledger = $finalLedger[$empId];
                                //echo "<Pre>"; print_r($ledger); exit;
                                $opening = (float)$ledger['opening_balance'];
                                $tot = $ledger['totals'];
                                $closing = ($opening + ($tot['emp_regular']+$tot['emp_supp']+$tot['loan_installment']) + ($tot['nmc_regular']+$tot['nmc_supp'])) - $tot['loan_taken'] + $tot['total_interest'];
                            ?>
                                <div class="searchTable new-page" style="margin-top:15px;">
                                    <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th style="text-align:center;" colspan="18">नाशिक महानगरपालिका,नाशिक</th>
                                            </tr>
                                            <tr>
                                                <th style="text-align:center;" colspan="18">परिभाषित अंशदान निवृत्ती वेतन योजना - वार्षिक विवरणपत्र (<?= $searchData['f_year']; ?>)</th>
                                            </tr>
                                            <tr>
                                                <th>कर्मचारी क्रमांक</th>
                                                <td><span class="emp-pill"><?= !empty($ownerDetail['emp_id']) ? $ownerDetail['emp_id'] : ''; ?></span></td>
                                                <th>कर्मचारी नाव</th>
                                                <td colspan="6"><?= !empty($ownerDetail['emp_name']) ? $ownerDetail['emp_name'] : ''; ?></td>
                                                <th colspan="3">सुरवातीची शिल्लक</th>
                                                <td colspan="6" style="text-align:right;"><?= _n0($opening); ?></td>
                                            </tr>
                                            <tr>
                                                <th>कर्मचारी नियुक्ती दिनांक</th>
                                                <td><?= !empty($ownerDetail['joining_date']) ? $ownerDetail['joining_date'] : ''; ?></td>
                                                <th>पे सेंटर</th>
                                                <td><?= !empty($ownerDetail['pay_center']) ? $ownerDetail['pay_center'] : ''; ?></td>
                                                <th>हुद्दा</th>
                                                <td colspan="13"><?= !empty($ownerDetail['designation_name']) ? $ownerDetail['designation_name'] : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <th rowspan="2">महिना</th>
                                                <th colspan="2">कर्मचारी वर्गणी</th>
                                                <th colspan="2">मनपा वर्गणी</th>
                                                <th rowspan="2">कर्मचाऱ्याने काढलेल्या कर्ज रक्कमेचा हप्ता (जमा)</th>
                                                <th rowspan="2">एकूण जमा</th>
                                                <th rowspan="2">काढलेल्या कर्जाची रक्कम</th>
                                                <th rowspan="2">कर्मचारी वर्गणी - व्याज आकारली जाते ती मासिक रक्कम</th>
                                                <th rowspan="2">मनपा वर्गणी - व्याज आकारली जाते ती मासिक रक्कम</th>
                                                <th rowspan="2">व्याज आकारली जाते ती मासिक एकूण रक्कम</th>
                                                <th rowspan="2">कर्मचारी वर्गणी - मिळणाऱ्या व्याजाची रक्कम</th>
                                                <th rowspan="2">मनपा वर्गणी - मिळणाऱ्या व्याजाची रक्कम</th>
                                                <th rowspan="2">मिळणाऱ्या व्याजाची एकूण रक्कम</th>
                                                <th rowspan="2">व्याज दर</th>
                                                <th rowspan="2">Bunch No</th>
                                                <th rowspan="2">File No</th>
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
                                                $fromMonth = ($this->input->post('from_month') !== null && $this->input->post('from_month') !== '') ? (int)$this->input->post('from_month') : null;
                                                $toMonth = ($this->input->post('to_month') !== null && $this->input->post('to_month') !== '') ? (int)$this->input->post('to_month') : null;

                                                $totShow = array(
                                                    'emp_regular' => 0.0,
                                                    'emp_supp' => 0.0,
                                                    'nmc_regular' => 0.0,
                                                    'nmc_supp' => 0.0,
                                                    'loan_installment' => 0.0,
                                                    'total_deposit' => 0.0,
                                                    'loan_taken' => 0.0,
                                                    'emp_interest' => 0.0,
                                                    'nmc_interest' => 0.0,
                                                    'total_interest' => 0.0,
                                                );

                                                $lastRowShown = null;
                                            ?>

                                            <?php foreach($ledger['rows'] as $row){
                                                $m = (int)$row['month'];
                                                if ($fromMonth !== null && $toMonth !== null) {
                                                    if ($m < $fromMonth || $m > $toMonth) { continue; }
                                                } elseif ($fromMonth !== null) {
                                                    if ($m !== $fromMonth) { continue; }
                                                } elseif ($toMonth !== null) {
                                                    if ($m !== $toMonth) { continue; }
                                                }

                                                $totShow['emp_regular'] += (float)$row['emp_regular'];
                                                $totShow['emp_supp'] += (float)$row['emp_supp'];
                                                $totShow['nmc_regular'] += (float)$row['nmc_regular'];
                                                $totShow['nmc_supp'] += (float)$row['nmc_supp'];
                                                $totShow['loan_installment'] += (float)$row['loan_installment'];
                                                $totShow['total_deposit'] += (float)$row['total_deposit'];
                                                $totShow['loan_taken'] += (float)$row['loan_taken'];
                                                $totShow['emp_interest'] += (float)$row['emp_interest'];
                                                $totShow['nmc_interest'] += (float)$row['nmc_interest'];
                                                $totShow['total_interest'] += (float)$row['total_interest'];

                                                $lastRowShown = $row;
                                                $monthText = $months[$m]." ".$row['year'];
                                                $rateLabel = $row['rate'] ? ("व्याज दर ".number_format((float)$row['rate'],2)."%") : "";
                                            ?>
                                                <tr>
                                                    <td><?= $monthText; ?></td>
                                                    <td style="text-align:right;"><?= _n0($row['emp_regular']); ?></td>
                                                    <td style="text-align:right;"><?= _n0($row['emp_supp']); ?></td>
                                                    <td style="text-align:right;"><?= _n0($row['nmc_regular']); ?></td>
                                                    <td style="text-align:right;"><?= _n0($row['nmc_supp']); ?></td>
                                                    <td style="text-align:right;"><?= _n0($row['loan_installment']); ?></td>
                                                    <td style="text-align:right;"><?= _n0($row['total_deposit']); ?></td>
                                                    <td style="text-align:right;"><?= _n0($row['loan_taken']); ?></td>
                                                    <td style="text-align:right;"><?= _n0($row['emp_base']); ?></td>
                                                    <td style="text-align:right;"><?= _n0($row['nmc_base']); ?></td>
                                                    <td style="text-align:right;"><?= _n0($row['total_base']); ?></td>
                                                    <td style="text-align:right; font-weight:600;"><?= _n0($row['emp_interest']); ?></td>
                                                    <td style="text-align:right; font-weight:600;"><?= _n0($row['nmc_interest']); ?></td>
                                                    <td style="text-align:right; font-weight:600;"><?= _n0($row['total_interest']); ?></td>
                                                    <td><?= $rateLabel; ?></td>
                                                    <td><?= !empty($row['bunch_no']) ? htmlspecialchars((string)$row['bunch_no']) : 0; ?></td>
                                                    <td><?= !empty($row['file_no']) ? htmlspecialchars((string)$row['file_no']) : 0; ?></td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <th>एकुण <?= $searchData['f_year']; ?></th>
                                                <th style="text-align:right;"><?= _n0($totShow['emp_regular']); ?></th>
                                                <th style="text-align:right;"><?= _n0($totShow['emp_supp']); ?></th>
                                                <th style="text-align:right;"><?= _n0($totShow['nmc_regular']); ?></th>
                                                <th style="text-align:right;"><?= _n0($totShow['nmc_supp']); ?></th>
                                                <th style="text-align:right;"><?= _n0($totShow['loan_installment']); ?></th>
                                                <th style="text-align:right;"><?= _n0($totShow['total_deposit']); ?></th>
                                                <th style="text-align:right;"><?= _n0($totShow['loan_taken']); ?></th>
                                                <th style="text-align:right;"><?= _n0(!empty($lastRowShown) ? $lastRowShown['emp_base'] : 0); ?></th>
                                                <th style="text-align:right;"><?= _n0(!empty($lastRowShown) ? $lastRowShown['nmc_base'] : 0); ?></th>
                                                <th style="text-align:right;"><?= _n0(!empty($lastRowShown) ? $lastRowShown['total_base'] : 0); ?></th>
                                                <th style="text-align:right;"><?= _n0($totShow['emp_interest']); ?></th>
                                                <th style="text-align:right;"><?= _n0($totShow['nmc_interest']); ?></th>
                                                <th style="text-align:right;"><?= _n0($totShow['total_interest']); ?></th>
                                                <th colspan="3"></th>
                                            </tr>

                                            <!-- Bottom summary block (as in Excel) -->
                                            <tr><td colspan="18" style="height:8px; background:#fff;"></td></tr>
                                            <tr>
                                                <td colspan="5"></td><td>1</td><td colspan="4">सुरुवातीची शिल्लक</td><td style="text-align:right;"><?= _n0($opening); ?></td><td colspan="7"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5"></td><td>2</td><td colspan="4">एकुण कर्मचारी वर्गणी</td><td style="text-align:right;"><?= _n0($tot['emp_regular']+$tot['emp_supp']); ?></td><td colspan="7"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5"></td><td>3</td><td colspan="4">कर्मचाऱ्याने काढलेल्या कर्ज रक्कमेचा एकुण हप्ता (जमा)</td><td style="text-align:right;"><?= _n0($tot['loan_installment']); ?></td><td colspan="7"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5"></td><td>4</td><td colspan="4">एकुण कर्मचारी वर्गणी व कर्मचाऱ्याने काढलेल्या कर्ज रक्कमेचा हप्ता : जमा (2+3)</td>
                                                <td style="text-align:right;"><?= _n0(($tot['emp_regular']+$tot['emp_supp']) + $tot['loan_installment']); ?></td><td colspan="7"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5"></td><td>5</td><td colspan="4">मनपा वर्गणी</td><td style="text-align:right;"><?= _n0($tot['nmc_regular']+$tot['nmc_supp']); ?></td><td colspan="7"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5"></td><td>6</td><td colspan="4">एकुण जमा (सुरवातीची शिलकेसह) (1+4+5)</td>
                                                <td style="text-align:right;"><?= _n0($opening + (($tot['emp_regular']+$tot['emp_supp']) + $tot['loan_installment']) + ($tot['nmc_regular']+$tot['nmc_supp'])); ?></td><td colspan="7"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5"></td><td>7</td><td colspan="4">काढलेल्या कर्जाची रक्कम (-)</td><td style="text-align:right;"><?= _n0($tot['loan_taken']); ?></td><td colspan="7"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5"></td><td>8</td><td colspan="4">कर्मचारी वर्गणी - मिळणाऱ्या व्याजाची रक्कम</td><td style="text-align:right;"><?= _n0($tot['emp_interest']); ?></td><td colspan="7"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5"></td><td>9</td><td colspan="4">मनपा वर्गणी - मिळणाऱ्या व्याजाची रक्कम</td><td style="text-align:right;"><?= _n0($tot['nmc_interest']); ?></td><td colspan="7"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5"></td><td>10</td><td colspan="4">एकुण मिळणाऱ्या व्याजाची रक्कम (8+9)</td><td style="text-align:right;"><?= _n0($tot['total_interest']); ?></td><td colspan="7"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5"></td><td>11</td><td colspan="4">मार्च अखेर शिल्लक (6-7+10)</td><td style="text-align:right; font-weight:700;"><?= _n0($closing); ?></td><td colspan="7"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <div class="alert alert-info no-print">Please select Year (and optionally Employee) and click Search.</div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#employee, #pay_center').select2();
        $("#voucher_date").datepicker({ format: 'dd-mm-yyyy',orientation: "bottom" });

        <?php if($this->input->post('emp_id')){?>
            $('#employee').val('<?=$this->input->post('emp_id');?>').trigger('change');
        <?php } ?>
        <?php if($this->input->post('pay_center')) { ?>
            $('#pay_center').val('<?= $this->input->post('pay_center'); ?>').trigger('change');
        <?php } ?>
        <?php if($this->input->post('year')){?>
            $('#year').val('<?=$this->input->post('year');?>');
        <?php } ?>
        <?php if($this->input->post('from_month')) { ?>
            $('#from_month').val('<?= $this->input->post('from_month'); ?>').trigger('change');
        <?php } ?>
        <?php if($this->input->post('to_month')) { ?>
            $('#to_month').val('<?= $this->input->post('to_month'); ?>').trigger('change');
        <?php } ?>
    });
</script>

