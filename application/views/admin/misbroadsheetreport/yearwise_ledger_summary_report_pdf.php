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
    </style>
</head>
<body>
    <?php if(!empty($ownerDetails) && !empty($yearwiseSummary)){ ?>
        <?php 
        $total_employees = count($ownerDetails);
        $emp_count = 0;
        foreach ($ownerDetails as $ownerDetail) { 
            $empId = $ownerDetail['emp_id'];
            if(empty($yearwiseSummary)){
                continue;
            }
            $emp_count++;
        ?>
            <div class="searchTable <?= ($emp_count < $total_employees) ? 'new-page' : ''; ?>" style="margin-top:15px;">
                <!-- Basic Information Table -->
                <table cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="text-align:center;" colspan="4">
                                <strong>Year-wise Ledger Summary Report</strong>
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
                            <th style="text-align:center; font-weight:bold;">सुरवातीची शिल्लक</th>
                            <th style="text-align:center; font-weight:bold;">कर्मचारी अंशदान</th>
                            <th style="text-align:center; font-weight:bold;">प्रती वर्ष कर्मचारी अंशदानावर मिळणारे व्याज</th>
                            <th style="text-align:center; font-weight:bold;">नियोक्त्याचे (नाशिक म.न.पा.) अंशदान</th>
                            <th style="text-align:center; font-weight:bold;">प्रती वर्ष नियोक्त्याच्या (नाशिक म.न.पा.) अंशदानावर मिळणारे व्याज</th>
                            <th style="text-align:center; font-weight:bold;">अखेर शिल्लक</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $totalOpening = $totalEmpContrib = $totalEmpInterest = $totalNmcContrib = $totalNmcInterest = $totalClosing = 0;
                            
                            // Display only years from 2005-2006 to 2014-2015
                            for ($y = 2005; $y <= 2014; $y++) {
                                $row = isset($yearwiseSummary[$y]) ? $yearwiseSummary[$y] : [
                                    'opening_balance' => 0,
                                    'employee_contribution' => 0,
                                    'employee_interest' => 0,
                                    'nmc_contribution' => 0,
                                    'nmc_interest' => 0,
                                    'closing_balance' => 0
                                ];
                                
                                $opening = $row['opening_balance'];
                                $empContrib = $row['employee_contribution'];
                                $empInterest = $row['employee_interest'];
                                $nmcContrib = $row['nmc_contribution'];
                                $nmcInterest = $row['nmc_interest'];
                                $closing = $row['closing_balance'];
                                
                                $totalEmpContrib += $empContrib;
                                $totalEmpInterest += $empInterest;
                                $totalNmcContrib += $nmcContrib;
                                $totalNmcInterest += $nmcInterest;
                        ?>
                        <tr>
                            <td class="clsCenter"><?= $y . '-' . ($y + 1); ?></td>
                            <td class="clsRight"><?= number_format($opening, 2, '.', ''); ?></td>
                            <td class="clsRight"><?= number_format($empContrib, 2, '.', ''); ?></td>
                            <td class="clsRight"><?= number_format($empInterest, 2, '.', ''); ?></td>
                            <td class="clsRight"><?= number_format($nmcContrib, 2, '.', ''); ?></td>
                            <td class="clsRight"><?= number_format($nmcInterest, 2, '.', ''); ?></td>
                            <td class="clsRight"><?= number_format($closing, 2, '.', ''); ?></td>
                        </tr>
                        <?php
                            }
                        ?>
                        <tr style="font-weight: bold; background-color: #f2f2f2;">
                            <td class="clsCenter"><strong>एकूण</strong></td>
                            <td class="clsRight"></td>
                            <td class="clsRight"><strong><?= number_format($totalEmpContrib, 2, '.', ''); ?></strong></td>
                            <td class="clsRight"><strong><?= number_format($totalEmpInterest, 2, '.', ''); ?></strong></td>
                            <td class="clsRight"><strong><?= number_format($totalNmcContrib, 2, '.', ''); ?></strong></td>
                            <td class="clsRight"><strong><?= number_format($totalNmcInterest, 2, '.', ''); ?></strong></td>
                            <td class="clsRight"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    <?php } ?>
</body>
</html>
