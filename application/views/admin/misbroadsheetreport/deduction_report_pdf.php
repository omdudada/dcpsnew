<?php
$months = [
    4 => "एप्रिल", 5 => "मे", 6 => "जुन", 7 => "जुलै", 8 => "ऑगस्ट", 
    9 => "सप्टेंबर", 10 => "ऑक्टोबर", 11 => "नोव्हेंबर", 12 => "डिसेंबर", 
    1 => "जानेवारी", 2 => "फेब्रुवारी", 3 => "मार्च"
];
?>
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
            background-color: #f2f2f2;
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
            width: 100%;
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

        .final-ledger-cert-signs {
            margin-top: 20px;
            padding-top: 8px;
        }

        .final-ledger-sign-line {
            border-top: 1px solid #000;
            margin-top: 36px;
            padding-top: 6px;
            text-align: center;
            font-size: 12px;
            line-height: 1.35;
        }

        .final-ledger-cert-signs .final-ledger-sign-line:first-child {
            margin-top: 16px;
        }

        .new-page {
            page-break-after: always;
        }

        .deduction-report-header {
            text-align: center;
            margin-bottom: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php if(!empty($ownerDetails) && !empty($dcpsDetails) && !empty($searchData['f_year'])){ ?>
        <?php 
        $total_employees = count($ownerDetails);
        $emp_count = 0;
        foreach ($ownerDetails as $ownerDetail) { 
            $empId = $ownerDetail['emp_id'];
            if(empty($dcpsDetails[$empId])){
                continue;
            }
            $emp_count++;
        ?>
            <div class="searchTable <?= ($emp_count < $total_employees) ? 'new-page' : ''; ?>" style="margin-top:15px;">
                <table cellspacing="0" width="100%">
                    <thead class="bg-primary123">
                        <tr>
                            <th style="text-align:center;" colspan="18">
                                <strong>Form R-3</strong>
                                <div style="font-size:10px;">(As referred to in Para no. 18 & 23 of Government Resolution - Finance Departmeny, No. CPS 1007/18/SER-4, dated 7 July, 2007)</div>
                            </th>
                        </tr>
                        <tr>
                            <th style="text-align:center;" colspan="18">
                                नाशिक महानगरपालिका,नाशिक			
                            </th>
                        </tr>
                        <tr>
                            <th style="text-align:center;" colspan="18">
                                परिभाषित अंशदान निवृत्ती वेतन योजना - वार्षिक विवरण
                                (<?= $searchData['f_year']; ?>)
                            </th>
                        </tr>
                        <tr>
                            <th colspan="3">कर्मचारी क्रमांक</th>
                            <td colspan="2"><?= !empty($ownerDetail['emp_id']) ? $ownerDetail['emp_id'] : ''; ?></td>
                            <th colspan="4">कर्मचारी नाव</th>
                            <td colspan="9"><?= !empty($ownerDetail['emp_name']) ? $ownerDetail['emp_name'] : ''; ?></td>
                        </tr>
                        <tr>
                            <th colspan="3">कर्मचारी नियुक्ती दिनांक</th>
                            <td colspan="2"><?= !empty($ownerDetail['joining_date']) ? $ownerDetail['joining_date'] : ''; ?></td>
                            <th colspan="4">पे सेंटर</th>
                            <td colspan ="2"><?= !empty($ownerDetail['pay_center']) ? $ownerDetail['pay_center'] : ''; ?></td>
                            <th colspan="1">हुद्दा</th>
                            <td><?= !empty($ownerDetail['designation_name']) ? $ownerDetail['designation_name'] : ''; ?></td>
                            <td colspan="6"></td>
                        </tr>
                        <tr>
                            <th>महिना</th>
                            <th>गठ्ठा  क्रमांक</th>
                            <th>फाईल क्रमांक</th>
                            <th>प्रमाणक क्रमांक</th>
                            <th>प्रमाणक दिनांक</th>
                            <th>मूळ वेतन</th>
                            <th>ग्रेड पे</th>
                            <th>महागाई भत्ता</th>
                            <th>एकूण</th>
                            <th>१०% कर्मचारी अपेक्षित अंशदान </th>
                            <th>१०% कर्मचारी प्रत्यक्ष कपात केलेले अंशदान </th>
                            <th>कर्मचारी अंशदानातील फरक</th>
                            <th>वेतन कालावधी पासून</th>
                            <th>वेतन कालावधी पर्यंत</th>
                            <th>वेतन प्रकार</th>
                            <th>शेरा </th>
                            <th>तपशील </th>
                            <th>कृती</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $totalBasic = $totalGradePay = $totalDA = $totalTotalSalary = $totalIdealContribution = $totalEmpSupContri = $totalDifference = 0;
                            
                            if (isset($dcpsDetails[$empId])) {
                                // First Year: April to December
                                for ($monthNo = 4; $monthNo <= 12; $monthNo++) {
                                    if (!empty($searchData['first_year'])) {
                                        $year = $searchData['first_year'];
                                    } else {
                                        $yearKeys = isset($dcpsDetails[$empId]) ? array_keys($dcpsDetails[$empId]) : [];
                                        $year = !empty($yearKeys) ? reset($yearKeys) : null;
                                    }
                                    
                                    $records = isset($dcpsDetails[$empId][$year][$monthNo])
                                    ? $dcpsDetails[$empId][$year][$monthNo]
                                    : [];
                                    
                                    if (!empty($records)) {
                                        usort($records, function ($a, $b) {
                                            $dateA = DateTime::createFromFormat('d-m-Y', $a['recovered_DCPS_with_voucher_date']);
                                            $dateB = DateTime::createFromFormat('d-m-Y', $b['recovered_DCPS_with_voucher_date']);
                                            if ($dateA == $dateB) return 0;
                                            return ($dateA < $dateB) ? -1 : 1;
                                        });
                                        $rowspan = count($records);
                                        $firstRow = true;
                                        foreach ($records as $row) {
                                            $basic = (float)(isset($row['basic']) && $row['basic'] !== '' ? $row['basic'] : 0);
                                            $grade_pay = (float)(isset($row['grade_pay']) && $row['grade_pay'] !== '' ? $row['grade_pay'] : 0);
                                            $da = (float)(isset($row['da']) && $row['da'] !== '' ? $row['da'] : 0);
                                            $total_salary = (float)(isset($row['total_salary']) && $row['total_salary'] !== '' ? $row['total_salary'] : 0);
                                            
                                            $ideal_contri = (float)(
                                            isset($row['Ideal_contribution_of_employee_for_DCPS']) 
                                            && $row['Ideal_contribution_of_employee_for_DCPS'] !== ''
                                            ? $row['Ideal_contribution_of_employee_for_DCPS']
                                            : 0
                                            );
                                            
                                            $emp_sup_contri = (float)(
                                            isset($row['salary_type']) && $row['salary_type'] === 'Regular'
                                            ? (isset($row['emp_DCPS_contribution']) && $row['emp_DCPS_contribution'] !== ''
                                            ? $row['emp_DCPS_contribution']
                                            : 0)
                                            : (isset($row['emp_DCPS_supplimentory_contribution']) && $row['emp_DCPS_supplimentory_contribution'] !== ''
                                            ? $row['emp_DCPS_supplimentory_contribution']
                                            : 0)
                                            );
                                            
                                            $difference = $emp_sup_contri - $ideal_contri;
                                            
                                            $totalBasic = (float)(isset($totalBasic) ? $totalBasic : 0);
                                            $totalGradePay = (float)(isset($totalGradePay) ? $totalGradePay : 0);
                                            $totalDA = (float)(isset($totalDA) ? $totalDA : 0);
                                            $totalTotalSalary = (float)(isset($totalTotalSalary) ? $totalTotalSalary : 0);
                                            $totalIdealContribution = (float)(isset($totalIdealContribution) ? $totalIdealContribution : 0);
                                            $totalEmpSupContri = (float)(isset($totalEmpSupContri) ? $totalEmpSupContri : 0);
                                            $totalDifference = (float)(isset($totalDifference) ? $totalDifference : 0);
                                            
                                            $totalBasic += ($row['is_deleted'] != 3) ? $basic : 0;
                                            $totalGradePay += ($row['is_deleted'] != 3) ? $grade_pay : 0;
                                            $totalDA += ($row['is_deleted'] != 3) ? $da : 0;
                                            $totalTotalSalary += ($row['is_deleted'] != 3) ? $total_salary : 0;
                                            $totalIdealContribution += ($row['is_deleted'] != 3) ? $ideal_contri : 0;
                                            $totalEmpSupContri += ($row['is_deleted'] != 3) ? $emp_sup_contri : 0;
                                            $totalDifference += ($row['is_deleted'] != 3) ? $difference : 0;
                                            
                                            $monthName = isset($months[$monthNo]) ? $months[$monthNo] : $monthNo;
                                        ?>
                                        <tr>
                                            <?php
                                                if ($firstRow) {
                                                    echo '<td rowspan="' . $rowspan . '" style="vertical-align:middle;">' . $monthName . ' ' . $year . '</td>';
                                                    $firstRow = false;
                                                }
                                            ?>
                                            <td class="clsCenter"><?= isset($row['bunch_no']) ? $row['bunch_no'] : '' ?></td>
                                            <td><?= isset($row['file_no']) ? $row['file_no'] : '' ?></td>
                                            <td><?= isset($row['recovered_DCPS_with_voucher_no']) ? $row['recovered_DCPS_with_voucher_no'] : '' ?></td>
                                            <td><?= isset($row['recovered_DCPS_with_voucher_date']) ? $row['recovered_DCPS_with_voucher_date'] : '' ?></td>
                                            <td class="clsRight"><?= $basic ?></td>
                                            <td class="clsRight"><?= $grade_pay ?></td>
                                            <td class="clsRight"><?= $da ?></td>
                                            <td class="clsRight"><?= $total_salary ?></td>
                                            <td class="clsRight"><?= $ideal_contri ?></td>
                                            <td class="clsRight"><?= $emp_sup_contri ?></td>
                                            <td class="clsRight"><?= $difference ?></td>
                                            <td><?= isset($row['salary_start_date']) ? $row['salary_start_date'] : '' ?></td>
                                            <td><?= isset($row['salary_end_date']) ? $row['salary_end_date'] : '' ?></td>
                                            <td>
                                                <?php 
                                                    if((isset($row['basic']) &&  $row['grade_pay'] != 0) && (isset($row['grade_pay']) &&  $row['grade_pay'] != 0) && (isset($row['da']) &&  $row['da'] != 0)) {
                                                    echo "Regular";                                   
                                                    }
                                                    else{
                                                        echo 'Suplimentory';
                                                    }
                                                ?>
                                            </td>
                                            <td class="clsLeft"><?= isset($row['remark']) ? $row['remark']: '' ?></td>
                                            <td class="clsLeft"><?=isset($row['reason'])?$row['reason']:"";?></td>
                                            <td>-</td>
                                        </tr>
                                        <?php
                                        }
                                    } else {
                                        $monthName = isset($months[$monthNo]) ? $months[$monthNo] : $monthNo;
                                    ?>
                                    <tr>
                                        <td><?= $monthName . ' ' . $year ?></td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td class="clsRight">0</td>
                                        <td class="clsRight">0</td>
                                        <td class="clsRight">0</td>
                                        <td class="clsRight">0</td>
                                        <td class="clsRight">0</td>
                                        <td class="clsRight">0</td>
                                        <td class="clsRight">0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>-</td>
                                    </tr>
                                    <?php
                                    }
                                }
                                
                                // Second Year: January to March
                                for ($monthNo = 1; $monthNo <= 3; $monthNo++) {
                                    $year = !empty($searchData['second_year']) 
                                    ? $searchData['second_year'] 
                                    : (isset($yearKeys[1]) ? $yearKeys[1] + 1 : null);
                                    $records = isset($dcpsDetails[$empId][$year][$monthNo]) ? $dcpsDetails[$empId][$year][$monthNo] : [];
                                    
                                    if (!empty($records)) {
                                        usort($records, function ($a, $b) {
                                            $dateA = DateTime::createFromFormat('d-m-Y', $a['recovered_DCPS_with_voucher_date']);
                                            $dateB = DateTime::createFromFormat('d-m-Y', $b['recovered_DCPS_with_voucher_date']);
                                            if ($dateA == $dateB) return 0;
                                            return ($dateA < $dateB) ? -1 : 1;
                                        });
                                        $rowspan = count($records);
                                        $firstRow = true;
                                        foreach ($records as $row) {
                                            $basic = (float)(isset($row['basic']) && $row['basic'] !== '' ? $row['basic'] : 0);
                                            $grade_pay = (float)(isset($row['grade_pay']) && $row['grade_pay'] !== '' ? $row['grade_pay'] : 0);
                                            $da = (float)(isset($row['da']) && $row['da'] !== '' ? $row['da'] : 0);
                                            $total_salary = (float)(isset($row['total_salary']) && $row['total_salary'] !== '' ? $row['total_salary'] : 0);
                                            
                                            $ideal_contri = (float)(
                                            isset($row['Ideal_contribution_of_employee_for_DCPS']) 
                                            && $row['Ideal_contribution_of_employee_for_DCPS'] !== '' 
                                            ? $row['Ideal_contribution_of_employee_for_DCPS'] 
                                            : 0
                                            );
                                            
                                            $emp_sup_contri =
                                            (float)(isset($row['emp_DCPS_contribution']) && $row['emp_DCPS_contribution'] !== ''
                                            ? $row['emp_DCPS_contribution']
                                            : 0)
                                            + (float)(isset($row['emp_DCPS_supplimentory_contribution']) && $row['emp_DCPS_supplimentory_contribution'] !== ''
                                            ? $row['emp_DCPS_supplimentory_contribution']
                                            : 0);
                                            
                                            $difference = $emp_sup_contri - $ideal_contri;
                                            
                                            $totalBasic = (float)(isset($totalBasic) ? $totalBasic : 0);
                                            $totalGradePay = (float)(isset($totalGradePay) ? $totalGradePay : 0);
                                            $totalDA = (float)(isset($totalDA) ? $totalDA : 0);
                                            $totalTotalSalary = (float)(isset($totalTotalSalary) ? $totalTotalSalary : 0);
                                            $totalIdealContribution = (float)(isset($totalIdealContribution) ? $totalIdealContribution : 0);
                                            $totalEmpSupContri = (float)(isset($totalEmpSupContri) ? $totalEmpSupContri : 0);
                                            $totalDifference = (float)(isset($totalDifference) ? $totalDifference : 0);
                                            
                                            $totalBasic += ($row['is_deleted'] != 3) ? $basic : 0;
                                            $totalGradePay += ($row['is_deleted'] != 3) ? $grade_pay : 0;
                                            $totalDA += ($row['is_deleted'] != 3) ? $da : 0;
                                            $totalTotalSalary += ($row['is_deleted'] != 3) ? $total_salary : 0;
                                            $totalIdealContribution += ($row['is_deleted'] != 3) ? $ideal_contri : 0;
                                            $totalEmpSupContri += ($row['is_deleted'] != 3) ? $emp_sup_contri : 0;
                                            $totalDifference += ($row['is_deleted'] != 3) ? $difference : 0;
                                            
                                            $monthName = isset($months[$monthNo]) ? $months[$monthNo] : $monthNo;
                                        ?>
                                        <tr>
                                            <?php
                                                if ($firstRow) {
                                                    echo '<td rowspan="' . $rowspan . '" style="vertical-align:middle;">' . $monthName . ' ' . $year . '</td>';
                                                    $firstRow = false;
                                                }
                                            ?>
                                            <td><?= isset($row['bunch_no']) ? $row['bunch_no'] : '' ?></td>
                                            <td><?= isset($row['file_no']) ? $row['file_no'] : '' ?></td>
                                            <td><?= isset($row['recovered_DCPS_with_voucher_no']) ? $row['recovered_DCPS_with_voucher_no'] : '' ?></td>
                                            <td><?= isset($row['recovered_DCPS_with_voucher_date']) ? $row['recovered_DCPS_with_voucher_date'] : '' ?></td>
                                            <td class="clsRight"><?= $basic ?></td>
                                            <td class="clsRight"><?= $grade_pay ?></td>
                                            <td class="clsRight"><?= $da ?></td>
                                            <td class="clsRight"><?= $total_salary ?></td>
                                            <td class="clsRight"><?= $ideal_contri ?></td>
                                            <td class="clsRight"><?= $emp_sup_contri ?></td>
                                            <td class="clsRight"><?= $difference ?></td>
                                            <td><?= isset($row['salary_start_date']) ? $row['salary_start_date'] : '' ?></td>
                                            <td><?= isset($row['salary_end_date']) ? $row['salary_end_date'] : '' ?></td>
                                            <td>
                                                <?php 
                                                    if((isset($row['basic']) &&  $row['grade_pay'] != 0) && (isset($row['grade_pay']) &&  $row['grade_pay'] != 0) && (isset($row['da']) &&  $row['da'] != 0)) {
                                                    echo "Regular";                                   
                                                    }
                                                    else{
                                                        echo 'Suplimentory';
                                                    }
                                                ?>
                                            </td>
                                            <td class="clsLeft"><?= isset($row['remark']) ? $row['remark']: '' ?></td>
                                            <td class="clsLeft"><?=isset($row['reason'])?$row['reason']:"";?></td>
                                            <td>-</td>
                                        </tr>
                                        <?php
                                        }
                                    } else {
                                        $monthName = isset($months[$monthNo]) ? $months[$monthNo] : $monthNo;
                                    ?>
                                    <tr>
                                        <td><?= $monthName . ' ' . $year ?></td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td class="clsRight">0</td>
                                        <td class="clsRight">0</td>
                                        <td class="clsRight">0</td>
                                        <td class="clsRight">0</td>
                                        <td class="clsRight">0</td>
                                        <td class="clsRight">0</td>
                                        <td class="clsRight">0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>-</td>
                                    </tr>
                                    <?php
                                    }
                                }
                            }
                        ?>
                        
                        <tr>
                            <td colspan="5"><strong>एकूण <?= $searchData['f_year']; ?></strong></td>
                            <td class="clsRight"><strong><?= $totalBasic; ?></strong></td>
                            <td class="clsRight"><strong><?= $totalGradePay; ?></strong></td>
                            <td class="clsRight"><strong><?= $totalDA; ?></strong></td>
                            <td class="clsRight"><strong><?= $totalTotalSalary; ?></strong></td>
                            <td class="clsRight"><strong><?= $totalIdealContribution; ?></strong></td>
                            <td class="clsRight"><strong><?= $totalEmpSupContri; ?></strong></td>
                            <td class="clsRight"><strong><?= $totalDifference; ?></strong></td>
                            <td colspan="6"></td>
                        </tr>
                    </tbody>
                </table>

                <!-- Certificate Block -->
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
                            </p><br/>
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
                                </div></br>
                                <div class="final-ledger-sign-line">
                                    कार्यालय प्रमुख / विभाग प्रमुख / आहारण व संवितरण अधिकारी<br>
                                    <span style="font-weight:600;">&nbsp;</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        <?php 
        }
    } 
    ?>
</body>
</html>
