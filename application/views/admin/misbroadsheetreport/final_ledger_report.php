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

    table td.clsCenter, table th.clsCenter {
        text-align: center;
        vertical-align: middle;
    }

    /* Bottom section: certificate (left) + summary table (right), print-friendly */
    .final-ledger-bottom-wrap {
        width: 100%;
        margin-top: 16px;
        border-collapse: collapse;
        table-layout: fixed;
    }
    .final-ledger-bottom-wrap td {
        vertical-align: top;
        border: 1px solid #000;
        padding: 10px;
    }
    .final-ledger-cert-box {
        width: 38%;
        font-size: 13px;
        line-height: 1.45;
        text-align: justify;
    }
    .final-ledger-cert-box strong {
        display: block;
        text-align: center;
        margin-bottom: 10px;
        font-size: 14px;
    }
    .final-ledger-summary-wrap {
        width: 62%;
    }
    .final-ledger-summary-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 28px;
    }
    .final-ledger-summary-table th,
    .final-ledger-summary-table td {
        border: 1px solid #000;
        padding: 6px 8px;
    }
    .final-ledger-summary-table .fls-num {
        width: 36px;
        text-align: center;
        vertical-align: middle;
    }
    .final-ledger-summary-table .fls-desc {
        text-align: center;
        vertical-align: middle;
    }
    .final-ledger-summary-table .fls-amt {
        width: 110px;
        text-align: right;
        vertical-align: middle;
        white-space: nowrap;
    }
    .final-ledger-sign-row {
        width: 100%;
        border-collapse: collapse;
        margin-top: 8px;
    }
    .final-ledger-sign-row td {
        border: none;
        padding: 24px 12px 8px;
        vertical-align: bottom;
        font-size: 13px;
        width: 50%;
    }
    .final-ledger-sign-line {
        border-top: 1px solid #000;
        margin-top: 36px;
        padding-top: 6px;
        text-align: center;
    }
    .final-ledger-cert-signs {
        margin-top: 20px;
        padding-top: 8px;
    }
    .final-ledger-cert-signs .final-ledger-sign-line {
        margin-top: 28px;
        font-size: 12px;
        line-height: 1.35;
    }
    .final-ledger-cert-signs .final-ledger-sign-line:first-child {
        margin-top: 16px;
    }
    .final-ledger-month-cell {
        vertical-align: middle;
        text-align: center;
    }

    @media print {
        .no-print { display:none; }
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #000 !important; padding:4px; text-align:center; }
        .final-ledger-sign-row td { border: none !important; }
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
    function _nf($v){ return number_format((float)$v, 2, '.', ''); }
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
                                                <th style="text-align:center;" colspan="19">नाशिक महानगरपालिका,नाशिक</th>
                                            </tr>
                                            <tr>
                                                <th style="text-align:center;" colspan="19">परिभाषित अंशदान निवृत्ती वेतन योजना - वार्षिक विवरणपत्र (<?= $searchData['f_year']; ?>)</th>
                                            </tr>
                                            <tr>
                                                <th>कर्मचारी क्रमांक</th>
                                                <td><span class="emp-pill"><?= !empty($ownerDetail['emp_id']) ? $ownerDetail['emp_id'] : ''; ?></span></td>
                                                <th>कर्मचारी नाव</th>
                                                <td colspan="6"><?= !empty($ownerDetail['emp_name']) ? $ownerDetail['emp_name'] : ''; ?></td>
                                                <th colspan="3">सुरवातीची शिल्लक</th>
                                                <td colspan="7" style="text-align:right;"><?= _n0($opening); ?></td>
                                            </tr>
                                            <tr>
                                                <th>कर्मचारी नियुक्ती दिनांक</th>
                                                <td><?= !empty($ownerDetail['joining_date']) ? $ownerDetail['joining_date'] : ''; ?></td>
                                                <th>पे सेंटर</th>
                                                <td><?= !empty($ownerDetail['pay_center']) ? $ownerDetail['pay_center'] : ''; ?></td>
                                                <th>हुद्दा</th>
                                                <td colspan="14"><?= !empty($ownerDetail['designation_name']) ? $ownerDetail['designation_name'] : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <th rowspan="2">महिना</th>
                                                <th rowspan="2">गठ्ठा क्रमांक</th>
                                                <th rowspan="2">फाईल क्रमांक</th>
                                                <th rowspan="2">प्रमाणक क्रमांक</th>
                                                <th rowspan="2">प्रमाणक दिनांक</th>
                                                
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
                                                    'emp_base' => 0.0,
                                                    'nmc_base' => 0.0,
                                                    'total_base' => 0.0,
                                                    'emp_interest' => 0.0,
                                                    'nmc_interest' => 0.0,
                                                    'total_interest' => 0.0,
                                                );

                                                $lastRowShown = null;

                                                $fltRows = array();
                                                foreach ($ledger['rows'] as $row) {
                                                    $m = (int) $row['month'];
                                                    if ($fromMonth !== null && $toMonth !== null) {
                                                        if ($m < $fromMonth || $m > $toMonth) {
                                                            continue;
                                                        }
                                                    } elseif ($fromMonth !== null) {
                                                        if ($m !== $fromMonth) {
                                                            continue;
                                                        }
                                                    } elseif ($toMonth !== null) {
                                                        if ($m !== $toMonth) {
                                                            continue;
                                                        }
                                                    }
                                                    $fltRows[] = $row;
                                                }

                                                $monthCounts = array();
                                                foreach ($fltRows as $row) {
                                                    $mk = (int) $row['month'] . '|' . (int) $row['year'];
                                                    $monthCounts[$mk] = isset($monthCounts[$mk]) ? $monthCounts[$mk] + 1 : 1;
                                                }
                                                $monthSeen = array();
                                                $monthRowspan = array();
                                                foreach ($fltRows as $i => $row) {
                                                    $mk = (int) $row['month'] . '|' . (int) $row['year'];
                                                    if (!isset($monthSeen[$mk])) {
                                                        $monthSeen[$mk] = true;
                                                        $monthRowspan[$i] = $monthCounts[$mk];
                                                    } else {
                                                        $monthRowspan[$i] = 0;
                                                    }
                                                }
                                            ?>

                                            <?php foreach ($fltRows as $i => $row) {
                                                $m = (int) $row['month'];
                                                $totShow['emp_regular'] += (float) $row['emp_regular'];
                                                $totShow['emp_supp'] += (float) $row['emp_supp'];
                                                $totShow['nmc_regular'] += (float) $row['nmc_regular'];
                                                $totShow['nmc_supp'] += (float) $row['nmc_supp'];
                                                $totShow['loan_installment'] += (float) $row['loan_installment'];
                                                $totShow['total_deposit'] += (float) $row['total_deposit'];
                                                $totShow['loan_taken'] += (float) $row['loan_taken'];
                                                $totShow['emp_base'] += (float) $row['emp_base'];
                                                $totShow['nmc_base'] += (float) $row['nmc_base'];
                                                $totShow['total_base'] += (float) $row['total_base'];
                                                $totShow['emp_interest'] += (float) $row['emp_interest'];
                                                $totShow['nmc_interest'] += (float) $row['nmc_interest'];
                                                $totShow['total_interest'] += (float) $row['total_interest'];

                                                $lastRowShown = $row;
                                                $monthText = $months[$m] . ' ' . $row['year'];
                                                $rateLabel = !empty($row['rate']) ? ('व्याज दर ' . number_format((float) $row['rate'], 2) . '%') : '';

                                                $bunchDisp = (isset($row['bunch_no']) && $row['bunch_no'] !== '' && $row['bunch_no'] !== null) ? htmlspecialchars((string) $row['bunch_no']) : '';
                                                $fileDisp = (isset($row['file_no']) && $row['file_no'] !== '' && $row['file_no'] !== null) ? htmlspecialchars((string) $row['file_no']) : '';
                                                $voucherNo = isset($row['recovered_DCPS_with_voucher_no']) ? trim((string) $row['recovered_DCPS_with_voucher_no']) : '';
                                                $voucherDt = isset($row['recovered_DCPS_with_voucher_date']) ? trim((string) $row['recovered_DCPS_with_voucher_date']) : '';
                                                $rsMonth = isset($monthRowspan[$i]) ? (int) $monthRowspan[$i] : 1;
                                            ?>
                                                <tr>
                                                    <?php if ($rsMonth > 0) { ?>
                                                        <td class="final-ledger-month-cell" rowspan="<?= $rsMonth; ?>"><?= htmlspecialchars($monthText); ?></td>
                                                    <?php } ?>
                                                    <td class="clsCenter"><?= $bunchDisp; ?></td>
                                                    <td class="clsCenter"><?= $fileDisp; ?></td>
                                                    <td class="clsCenter"><?= $voucherNo !== '' ? htmlspecialchars($voucherNo) : ''; ?></td>
                                                    <td class="clsCenter"><?= $voucherDt !== '' ? htmlspecialchars($voucherDt) : ''; ?></td>
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
                                                    <td><?= htmlspecialchars($rateLabel); ?></td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td colspan="5" style="text-align:center;"><strong>एकुण <?= htmlspecialchars((string) $searchData['f_year']); ?></strong></td>
                                                <td style="text-align:right;"><strong><?= _n0($totShow['emp_regular']); ?></strong></td>
                                                <td style="text-align:right;"><strong><?= _n0($totShow['emp_supp']); ?></strong></td>
                                                <td style="text-align:right;"><strong><?= _n0($totShow['nmc_regular']); ?></strong></td>
                                                <td style="text-align:right;"><strong><?= _n0($totShow['nmc_supp']); ?></strong></td>
                                                <td style="text-align:right;"><strong><?= _n0($totShow['loan_installment']); ?></strong></td>
                                                <td style="text-align:right;"><strong><?= _n0($totShow['total_deposit']); ?></strong></td>
                                                <td style="text-align:right;"><strong><?= _n0($totShow['loan_taken']); ?></strong></td>
                                                <td style="text-align:right;"><strong><?= _n0($totShow['emp_base']); ?></strong></td>
                                                <td style="text-align:right;"><strong><?= _n0($totShow['nmc_base']); ?></strong></td>
                                                <td style="text-align:right;"><strong><?= _n0($totShow['total_base']); ?></strong></td>
                                                <td style="text-align:right;"><strong><?= _n0($totShow['emp_interest']); ?></strong></td>
                                                <td style="text-align:right;"><strong><?= _n0($totShow['nmc_interest']); ?></strong></td>
                                                <td style="text-align:right;"><strong><?= _n0($totShow['total_interest']); ?></strong></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <?php
                                        $fyMarchYear = isset($searchData['second_year']) ? (int) $searchData['second_year'] : 0;
                                        $sumEmpContrib = $tot['emp_regular'] + $tot['emp_supp'];
                                        $sumNmcContrib = $tot['nmc_regular'] + $tot['nmc_supp'];
                                        $sumRow4 = $sumEmpContrib + $tot['loan_installment'];
                                        $sumRow6 = $opening + $sumRow4 + $sumNmcContrib;
                                    ?>
                                    <table class="final-ledger-bottom-wrap" cellspacing="0">
                                        <tr>
                                            <td class="final-ledger-cert-box">
                                                <strong>प्रमाणपत्र</strong>
                                                <p style="margin:0;">उपरोक्त कर्मचाऱ्याच्या परिभाषित अंशदान निवृत्तीवेतन योजनेच्या वर्गण्या फॉर्म नं. २, वेतनपत्रिका, वेतन बिल व संबंधित दस्तऐवजांच्या आधारे तपासून बरोबर असल्याची खात्री करण्यात आली आहे.</p>
                                                <div class="final-ledger-cert-signs">
                                                    <div class="final-ledger-sign-line">
                                                        बिल लिपिक<br>
                                                        <span style="font-weight:600;">&nbsp;</span>
                                                    </div><br/>
                                                    <div class="final-ledger-sign-line">
                                                        वरिष्ठ  लिपिक / सहाय्यक अधीक्षक / अधीक्षक<br>
                                                        <span style="font-weight:600;">&nbsp;</span>
                                                    </div></br/>
                                                    <div class="final-ledger-sign-line">
                                                        कार्यालय प्रमुख/ विभाग प्रमुख / आहारण व संवितरण अधिकारी<br>
                                                        <span style="font-weight:600;">&nbsp;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="final-ledger-summary-wrap">
                                                <table class="final-ledger-summary-table" cellspacing="0">
                                                    <tr>
                                                        <td class="fls-num">1</td>
                                                        <td class="fls-desc">सुरुवातीची शिल्लक</td>
                                                        <td class="fls-amt"><?= _nf($opening); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fls-num">2</td>
                                                        <td class="fls-desc">एकूण कर्मचारी वर्गणी</td>
                                                        <td class="fls-amt"><?= _nf($sumEmpContrib); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fls-num">3</td>
                                                        <td class="fls-desc">कर्मचाऱ्याने काढलेल्या कर्ज रक्कमेचा एकूण हप्ता (जमा)</td>
                                                        <td class="fls-amt"><?= _nf($tot['loan_installment']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fls-num">4</td>
                                                        <td class="fls-desc">एकूण कर्मचारी वर्गणी व कर्मचाऱ्याने काढलेल्या कर्ज रक्कमेचा हप्ता : जमा (2+3)</td>
                                                        <td class="fls-amt"><?= _nf($sumRow4); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fls-num">5</td>
                                                        <td class="fls-desc">मनपा वर्गणी</td>
                                                        <td class="fls-amt"><?= _nf($sumNmcContrib); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fls-num">6</td>
                                                        <td class="fls-desc">एकूण जमा (सुरुवातीची शिल्लकसह) (1+4+5)</td>
                                                        <td class="fls-amt"><?= _nf($sumRow6); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fls-num">7</td>
                                                        <td class="fls-desc">काढलेल्या कर्जाची रक्कम (-)</td>
                                                        <td class="fls-amt"><?= _nf($tot['loan_taken']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fls-num">8</td>
                                                        <td class="fls-desc">कर्मचारी वर्गणी - मिळणाऱ्या व्याजाची रक्कम</td>
                                                        <td class="fls-amt"><?= _nf($tot['emp_interest']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fls-num">9</td>
                                                        <td class="fls-desc">मनपा वर्गणी - मिळणाऱ्या व्याजाची रक्कम</td>
                                                        <td class="fls-amt"><?= _nf($tot['nmc_interest']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fls-num">10</td>
                                                        <td class="fls-desc">एकूण मिळणाऱ्या व्याजाची रक्कम (8+9)</td>
                                                        <td class="fls-amt"><?= _nf($tot['total_interest']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fls-num">11</td>
                                                        <td class="fls-desc">मार्च <?= $fyMarchYear ? htmlspecialchars((string) $fyMarchYear) : ''; ?> अखेर शिल्लक (6-7+10)</td>
                                                        <td class="fls-amt" style="font-weight:700;"><?= _nf($closing); ?></td>
                                                    </tr>
                                                </table>
                                                <table class="final-ledger-sign-row" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                            <div class="final-ledger-sign-line">
                                                                क. लिपीक
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="final-ledger-sign-line">
                                                                उपमुख्यलेखाधिकारी, सो.                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
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

