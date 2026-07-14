<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style type="text/css">
        body {
            font-family: 'freesans', sans-serif;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin-bottom: 0px;
        }

        th, td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
            word-wrap: break-word;
            white-space: normal;
        }

        th {
            font-weight: bold;
        }

        table td.clsCenter, table th.clsCenter {
            text-align: center;
            vertical-align: middle;
        }

        table td.clsRight, table th.clsRight {
            text-align: right;
            vertical-align: middle;
        }

        table td.clsLeft {
            text-align: left;
            vertical-align: middle;
        }

        .new-page {
            page-break-after: always;
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

        .final-ledger-sign-row {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        .final-ledger-sign-row td {
            border: none !important;
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
    </style>
</head>
<body>
    <?php if(!empty($ownerDetails) && !empty($dcpsDetails)){ ?>
        <?php 
        $total_employees = count($ownerDetails);
        $emp_count = 0;
        foreach ($ownerDetails as $ownerDetail) { 
            $empId = $ownerDetail['emp_id'];
            if(empty($dcpsDetails[$empId])){
                continue;
            }
            $emp_count++;
            
            // Calculate the year-wise values
            $yearSummary = [];
            $min_f_year = 2005;
            $max_f_year = 2014;
            
            foreach ($dcpsDetails[$empId] as $row) {
                $f_year = ($row['for_month'] >= 4 && $row['for_month'] <= 12) ? (int)$row['for_year'] : (int)$row['for_year'] - 1;
                
                $ideal_contri = (float)(
                    isset($row['Ideal_contribution_of_employee_for_DCPS']) && $row['Ideal_contribution_of_employee_for_DCPS'] !== ''
                    ? $row['Ideal_contribution_of_employee_for_DCPS']
                    : 0
                );
                
                if ($row['for_month'] >= 4 && $row['for_month'] <= 12) {
                    $emp_sup_contri = (float)(
                        isset($row['salary_type']) && $row['salary_type'] === 'Regular'
                        ? (isset($row['emp_DCPS_contribution']) && $row['emp_DCPS_contribution'] !== '' ? $row['emp_DCPS_contribution'] : 0)
                        : (isset($row['emp_DCPS_supplimentory_contribution']) && $row['emp_DCPS_supplimentory_contribution'] !== '' ? $row['emp_DCPS_supplimentory_contribution'] : 0)
                    );
                } else {
                    $emp_sup_contri = (float)(isset($row['emp_DCPS_contribution']) && $row['emp_DCPS_contribution'] !== '' ? $row['emp_DCPS_contribution'] : 0)
                                    + (float)(isset($row['emp_DCPS_supplimentory_contribution']) && $row['emp_DCPS_supplimentory_contribution'] !== '' ? $row['emp_DCPS_supplimentory_contribution'] : 0);
                }
                
                $difference = $emp_sup_contri - $ideal_contri;
                
                if (!isset($yearSummary[$f_year])) {
                    $yearSummary[$f_year] = ['neg' => 0, 'pos' => 0];
                }
                
                if ($row['is_deleted'] != 3) {
                    if ($difference < 0) {
                        $yearSummary[$f_year]['neg'] += $difference;
                    } elseif ($difference > 0) {
                        $yearSummary[$f_year]['pos'] += $difference;
                    }
                }
            }
        ?>
            <div class="searchTable <?= ($emp_count < $total_employees) ? 'new-page' : ''; ?>" style="margin-top:15px;">
                <!-- Basic Information Table -->
                <table cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="text-align:center;" colspan="4">
                                <strong>Employee Contribution Excess Deduction / Excess Recovery Report</strong>
                            </th>
                        </tr>
                        <tr>
                            <th style="text-align:center;" colspan="4">
                                नाशिक महानगरपालिका,नाशिक
                            </th>
                        </tr>
                        <tr>
                            <th style="text-align:center;" colspan="4">
                                परिभाषित अंशदान निवृत्ती वेतन योजना
                            </th>
                        </tr>
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
                
                <!-- Year-Wise Values Table -->
                <table cellspacing="0" width="100%" style="margin-top: 15px;">
                    <thead>
                        <tr>
                            <th style="text-align:center; font-weight:bold;">आर्थिक वर्ष</th>
                            <th style="text-align:center; font-weight:bold;">कपात न केलेली कर्मचारी अंशदान रक्कम</th>
                            <th style="text-align:center; font-weight:bold;">जादा कपात केलेली कर्मचारी अंशदान रक्कम</th>
                            <th style="text-align:center; font-weight:bold;">कपात न केलेली कर्मचारी अंशदान व जादा कपात केलेली कर्मचारी अंशदान रक्कम यातील फरक</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $grandNeg = $grandPos = 0;
                            for ($y = $min_f_year; $y <= $max_f_year; $y++) {
                                $negAmt = isset($yearSummary[$y]['neg']) ? $yearSummary[$y]['neg'] : 0;
                                $posAmt = isset($yearSummary[$y]['pos']) ? $yearSummary[$y]['pos'] : 0;
                                $diffAmt = $posAmt + $negAmt;
                                $grandNeg += $negAmt;
                                $grandPos += $posAmt;
                        ?>
                        <tr>
                            <td class="clsCenter">सन <?= $y . '-' . sprintf("%02d", ($y + 1) % 100); ?></td>
                            <td class="clsRight"><?= number_format($negAmt, 2, '.', ''); ?></td>
                            <td class="clsRight"><?= number_format($posAmt, 2, '.', ''); ?></td>
                            <td class="clsRight"><?= number_format($diffAmt, 2, '.', ''); ?></td>
                        </tr>
                        <?php
                            }
                        ?>
                        <tr style="font-weight: bold; background-color: #f2f2f2;">
                            <td class="clsCenter"><strong>एकूण</strong></td>
                            <td class="clsRight"><strong><?= number_format($grandNeg, 2, '.', ''); ?></strong></td>
                            <td class="clsRight"><strong><?= number_format($grandPos, 2, '.', ''); ?></strong></td>
                            <td class="clsRight"><strong><?= number_format($grandNeg + $grandPos, 2, '.', ''); ?></strong></td>
                        </tr>
                    </tbody>
                </table>
                <table class="final-ledger-bottom-wrap" cellspacing="0">
                    <tr>
                        <td class="final-ledger-cert-box">
                            <strong>प्रमाणपत्र</strong>
                            <p style="margin:0;">
                                १. कर्मचारी अंशदान वर्गणी कपात नमुना - २, आणि / किंवा<br>
                                २. वेतन देयक, आणि / किंवा<br>
                                ३. वेतन पत्रिका, आणि / किंवा<br>
                                ४. पगार बिल ओ.सी. (Payment OC) इत्यादी<br>
                            
                                अन्वये सदर कर्मचाऱ्यांच्या नवीन परिभाषित अंशदान निवृत्तीवेतन योजनेबाबतच्या प्रति माह अंशदान वर्गणी कपाती विभागामार्फत प्रमाणित करण्यात येत असून, त्यानुसार सदर लेखांकन अचूक व बरोबर आहे. सदर बाबतीत भविष्यात काही आक्षेप आल्यास किंवा काही बदल असल्यास त्याची सर्वस्वी जबाबदारी कार्यकारी विभागाची राहील.
                            </p><br/><br/>
                            <div class="final-ledger-cert-signs">
                                <div class="final-ledger-sign-line">
                                    कर्मचारी स्वाक्षरी / अंगठा <br>
                                    <span style="font-weight:600;">&nbsp;</span>
                                </div><br/>
                                <div class="final-ledger-sign-line">
                                    बिल लिपिक / कनिष्ठ लिपिक<br>
                                    <span style="font-weight:600;">&nbsp;</span>
                                </div><br/>
                                <div class="final-ledger-sign-line">
                                    वरिष्ठ  लिपिक / सहाय्यक अधीक्षक / अधीक्षक<br>
                                    <span style="font-weight:600;">&nbsp;</span>
                                </div></br/>
                                <div class="final-ledger-sign-line">
                                    कार्यालय प्रमुख / विभाग प्रमुख / आहरण व संवितरण अधिकारी (सही व शिक्का)<br>
                                    <span style="font-weight:600;">&nbsp;</span>
                                </div>
                            </div>
                        </td>                        
                    </tr>
                </table>
            </div>
        <?php } ?>
    <?php } ?>
</body>
</html>
