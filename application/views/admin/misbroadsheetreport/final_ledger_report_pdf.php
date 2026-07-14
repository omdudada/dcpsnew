<?php
$months = [
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
];

if (!function_exists('_n0')) {
    function _n0($v)
    {
        return number_format((int) $v, 0, '.', '');
    }
}
if (!function_exists('_nf')) {
    function _nf($v)
    {
        return number_format((int) $v, 2, '.', '');
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style type="text/css">
        body {
            font-family: 'freesans', sans-serif;
        }

        .emp-pill {
            display: inline-block;
            padding: 3px 10px;
            border: 1px solid #333;
            border-radius: 999px;
            font-weight: 700;
            background: #f7f7f7;
            min-width: 70px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
        }

        table td.clsCenter,
        table th.clsCenter {
            text-align: center;
            vertical-align: middle;
        }

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

        .new-page {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <?php if (!empty($ownerDetails) && !empty($finalLedger) && !empty($searchData['f_year'])) { ?>
        <?php
        $total_employees = count($ownerDetails);
        $emp_count = 0;
        foreach ($ownerDetails as $ownerDetail) {
            $empId = (int) $ownerDetail['emp_id'];
            if (empty($finalLedger[$empId])) {
                continue;
            }
            $ledger = $finalLedger[$empId];
            $opening = (int) $ledger['opening_balance'];
            $tot = $ledger['totals'];
            $closing = (($opening) + ($tot['emp_regular'] + $tot['emp_supp'] + $tot['loan_installment']) + ($tot['nmc_regular'] + $tot['nmc_supp'])) - $tot['loan_taken'] + $tot['total_interest'];

            // NEW (additive): Employee Contribution opening/closing — independent of $opening/$closing
            $employeeContributionOpening = isset($ledger['ec_opening_balance']) ? (int) $ledger['ec_opening_balance'] : 0;
            $employeeContributionClosing = $employeeContributionOpening + (int) $tot['emp_regular'] + (int) $tot['emp_interest'];
            $emp_count++;
            ?>
            <div class="searchTable <?= ($emp_count < $total_employees) ? 'new-page' : ''; ?>" style="margin-top:15px;">
                <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="text-align:center;" colspan="21">नाशिक महानगरपालिका,नाशिक</th>
                        </tr>
                        <tr>
                            <th style="text-align:center;" colspan="21">परिभाषित अंशदान निवृत्ती वेतन योजना - वार्षिक विवरणपत्र
                                (<?= $searchData['f_year']; ?>)</th>
                        </tr>
                        <tr>
                            <th>कर्मचारी क्रमांक</th>
                            <td><span
                                    class="emp-pill"><?= !empty($ownerDetail['emp_id']) ? $ownerDetail['emp_id'] : ''; ?></span>
                            </td>
                            <th>कर्मचारी नाव</th>
                            <td colspan="8"><?= !empty($ownerDetail['emp_name']) ? $ownerDetail['emp_name'] : ''; ?></td>
                            <th colspan="3">सुरवातीची शिल्लक</th>
                            <td colspan="7" style="text-align:right;"><?= _n0($opening); ?></td>
                        </tr>
                        <tr>
                            <th>कर्मचारी नियुक्ती दिनांक</th>
                            <td><?= !empty($ownerDetail['joining_date']) ? $ownerDetail['joining_date'] : ''; ?></td>
                            <th>पे सेंटर</th>
                            <td><?= !empty($ownerDetail['pay_center']) ? $ownerDetail['pay_center'] : ''; ?></td>
                            <th>हुद्दा</th>
                            <td colspan="16">
                                <?= !empty($ownerDetail['designation_name']) ? $ownerDetail['designation_name'] : ''; ?>
                            </td>
                        </tr>
                        <tr>
                            <th rowspan="2">महिना</th>
                            <th rowspan="2">गठ्ठा क्रमांक</th>
                            <th rowspan="2">फाईल क्रमांक</th>
                            <th rowspan="2">प्रमाणक क्रमांक</th>
                            <th rowspan="2">प्रमाणक दिनांक</th>
                            <th colspan="3">कर्मचारी वर्गणी</th>
                            <th colspan="3">मनपा वर्गणी</th>
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
                            <th>एकूण</th>
                            <th>नियमित वेतन</th>
                            <th>पुरवणी वेतन</th>
                            <th>एकूण</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $fromMonth = isset($searchData['from_month']) && $searchData['from_month'] !== '' ? (int) $searchData['from_month'] : null;
                        $toMonth = isset($searchData['to_month']) && $searchData['to_month'] !== '' ? (int) $searchData['to_month'] : null;

                        $totShow = array(
                            'emp_regular' => 0,
                            'emp_supp' => 0,
                            'nmc_regular' => 0,
                            'nmc_supp' => 0,
                            'loan_installment' => 0,
                            'total_deposit' => 0,
                            'loan_taken' => 0,
                            'emp_base' => 0,
                            'nmc_base' => 0,
                            'total_base' => 0,
                            'emp_interest' => 0,
                            'nmc_interest' => 0,
                            'total_interest' => 0,
                        );

                        $fltRows = array();
                        foreach ($ledger['rows'] as $row) {
                            $m = (int) $row['month'];
                            if ($fromMonth !== null && $toMonth !== null) {
                                if ($m < $fromMonth || $m > $toMonth)
                                    continue;
                            } elseif ($fromMonth !== null) {
                                if ($m !== $fromMonth)
                                    continue;
                            } elseif ($toMonth !== null) {
                                if ($m !== $toMonth)
                                    continue;
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
                            $totShow['emp_regular'] += (int) $row['emp_regular'];
                            $totShow['emp_supp'] += (int) $row['emp_supp'];
                            $totShow['nmc_regular'] += (int) $row['nmc_regular'];
                            $totShow['nmc_supp'] += (int) $row['nmc_supp'];
                            $totShow['loan_installment'] += (int) $row['loan_installment'];
                            $totShow['total_deposit'] += (int) $row['total_deposit'];
                            $totShow['loan_taken'] += (int) $row['loan_taken'];
                            $totShow['emp_base'] += (int) $row['emp_base'];
                            $totShow['nmc_base'] += (int) $row['nmc_base'];
                            $totShow['total_base'] += (int) $row['total_base'];
                            $totShow['emp_interest'] += (int) $row['emp_interest'];
                            $totShow['nmc_interest'] += (int) $row['nmc_interest'];
                            $totShow['total_interest'] += (int) $row['total_interest'];

                            $monthText = $months[$m] . ' ' . $row['year'];
                            $rateLabel = !empty($row['rate']) ? ('व्याज दर ' . number_format($row['rate'], 2) . '%') : '';

                            $bunchDisp = (isset($row['bunch_no']) && $row['bunch_no'] !== '' && $row['bunch_no'] !== null) ? htmlspecialchars((string) $row['bunch_no']) : '';
                            $fileDisp = (isset($row['file_no']) && $row['file_no'] !== '' && $row['file_no'] !== null) ? htmlspecialchars((string) $row['file_no']) : '';
                            $voucherNo = isset($row['recovered_DCPS_with_voucher_no']) ? trim((string) $row['recovered_DCPS_with_voucher_no']) : '';
                            $voucherDt = isset($row['recovered_DCPS_with_voucher_date']) ? trim((string) $row['recovered_DCPS_with_voucher_date']) : '';
                            $rsMonth = isset($monthRowspan[$i]) ? (int) $monthRowspan[$i] : 1;
                            ?>
                            <tr>
                                <?php if ($rsMonth > 0) { ?>
                                    <td class="final-ledger-month-cell" rowspan="<?= $rsMonth; ?>"><?= htmlspecialchars($monthText); ?>
                                    </td>
                                <?php } ?>
                                <td class="clsCenter"><?= $bunchDisp; ?></td>
                                <td class="clsCenter"><?= $fileDisp; ?></td>
                                <td class="clsCenter"><?= $voucherNo !== '' ? htmlspecialchars($voucherNo) : ''; ?></td>
                                <td class="clsCenter"><?= $voucherDt !== '' ? htmlspecialchars($voucherDt) : ''; ?></td>
                                <td style="text-align:right;"><?= _n0($row['emp_regular']); ?></td>
                                <td style="text-align:right;"><?= _n0($row['emp_supp']); ?></td>
                                <td style="text-align:right; font-weight:600;">
                                    <?= _n0((int) $row['emp_regular'] + (int) $row['emp_supp']); ?></td>
                                <td style="text-align:right;"><?= _n0($row['nmc_regular']); ?></td>
                                <td style="text-align:right;"><?= _n0($row['nmc_supp']); ?></td>
                                <td style="text-align:right; font-weight:600;">
                                    <?= _n0((int) $row['nmc_regular'] + (int) $row['nmc_supp']); ?></td>
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
                            <td colspan="5" style="text-align:center;"><strong>एकुण
                                    <?= htmlspecialchars((string) $searchData['f_year']); ?></strong></td>
                            <td style="text-align:right;"><strong><?= _n0($totShow['emp_regular']); ?></strong></td>
                            <td style="text-align:right;"><strong><?= _n0($totShow['emp_supp']); ?></strong></td>
                            <td style="text-align:right;">
                                <strong><?= _n0($totShow['emp_regular'] + $totShow['emp_supp']); ?></strong></td>
                            <td style="text-align:right;"><strong><?= _n0($totShow['nmc_regular']); ?></strong></td>
                            <td style="text-align:right;"><strong><?= _n0($totShow['nmc_supp']); ?></strong></td>
                            <td style="text-align:right;">
                                <strong><?= _n0($totShow['nmc_regular'] + $totShow['nmc_supp']); ?></strong></td>
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
                $sumRow6 = ($opening) + $sumRow4 + $sumNmcContrib;
                ?>
                <table class="final-ledger-bottom-wrap" cellspacing="0">
                    <tr>
                        <td class="final-ledger-cert-box">
                            <strong>प्रमाणपत्र</strong>
                            <p style="margin:0;">
                                १. कर्मचारी अंशदान वर्गणी कपात नमुना - २, आणि / किंवा<br>
                                २. वेतन देयक, आणि / किंवा<br>
                                ३. वेतन पत्रिका, आणि / किंवा<br>
                                ४. पगार बिल ओ.सी. (Payment OC) इत्यादी<br>

                                अन्वये सदर कर्मचाऱ्यांच्या नवीन परिभाषित अंशदान निवृत्तीवेतन योजनेबाबतच्या प्रति माह अंशदान
                                वर्गणी कपाती विभागामार्फत प्रमाणित करण्यात येत असून, त्यानुसार सदर लेखांकन अचूक व बरोबर आहे. सदर
                                बाबतीत भविष्यात काही आक्षेप आल्यास किंवा काही बदल असल्यास त्याची सर्वस्वी जबाबदारी कार्यकारी
                                विभागाची राहील.
                            </p><br /><br />
                            <div class="final-ledger-cert-signs">
                                <div class="final-ledger-sign-line">
                                    कर्मचारी स्वाक्षरी / अंगठा<br>

                                </div><br /><br />
                                <div class="final-ledger-sign-line">
                                    बिल लिपिक / कनिष्ठ लिपिक<br>

                                </div><br /><br />
                                <div class="final-ledger-sign-line">
                                    वरिष्ठ लिपिक / सहाय्यक अधीक्षक / अधीक्षक<br>
                                </div><br /><br />
                                <div class="final-ledger-sign-line">
                                    कार्यालय प्रमुख / विभाग प्रमुख / आहरण व संवितरण अधिकारी (सही व शिक्का)<br>
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
                                    <td class="fls-desc">एकूण कर्मचारी वर्गणी व कर्मचाऱ्याने काढलेल्या कर्ज रक्कमेचा हप्ता : जमा
                                        (2+3)</td>
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
                                    <td class="fls-desc">मार्च
                                        <?= $fyMarchYear ? htmlspecialchars((string) $fyMarchYear) : ''; ?> अखेर शिल्लक (6-7+10)
                                    </td>
                                    <td class="fls-amt" style="font-weight:700;"><?= _nf($closing); ?></td>
                                </tr>
                                <!--<tr>
                                    <td class="fls-num">12</td>
                                    <td class="fls-desc">कर्मचारी वर्गणी सुरुवातीची शिल्लक</td>
                                    <td class="fls-amt"><?= _nf($employeeContributionOpening); ?></td>
                                </tr>
                                <tr>
                                    <td class="fls-num">13</td>
                                    <td class="fls-desc">कर्मचारी वर्गणी अखेर शिल्लक (कर्मचारी वर्गणी + व्याज)</td>
                                    <td class="fls-amt" style="font-weight:700;"><?= _nf($employeeContributionClosing); ?></td>
                                </tr>-->
                            </table>
                            <table class="final-ledger-sign-row" cellspacing="0">
                                <tr>
                                    <td style="width: 33%">
                                        <div class="final-ledger-sign-line">
                                            कनिष्ठ लिपिक / कनिष्ठ लेखापाल
                                        </div>
                                    </td>

                                    <td style="width: 33%">
                                        <div class="final-ledger-sign-line">
                                            उपलेखापाल / वरीष्ठ लेखापाल
                                        </div>
                                    </td>
                                    <td style="width: 33%">
                                        <div class="final-ledger-sign-line">
                                            उप मुख्य लेखा व वित्त अधिकारी
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 33%">&nbsp;</td>
                                    <td style="width: 33%">
                                        <div class="final-ledger-sign-line">
                                            मुख्य लेखा व वित्त अधिकारी (सही व शिक्का)
                                        </div>
                                    </td>
                                    <td style="width: 33%">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        <?php } ?>
    <?php } ?>
</body>

</html>