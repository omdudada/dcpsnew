<?php
    $months = [
        4 => "एप्रिल", 5 => "मे", 6 => "जुन", 7 => "जुलै", 8 => "ऑगस्ट", 
        9 => "सप्टेंबर", 10 => "ऑक्टोबर", 11 => "नोव्हेंबर", 12 => "डिसेंबर", 
        1 => "जानेवारी", 2 => "फेब्रुवारी", 3 => "मार्च"
    ];
?>
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
    
    <?php
        if (isset($urlAry['option']) && $urlAry['option'] == "print") {
        ?>
        <style>
            #header {
                font-size: 12px;
            }
            
            .bodyContent {
                margin: 0 auto;
                line-height: 24px;
                font-size: 15px;
            }
            
            #taxDetails,
            #contactDetails {
                width: 100%;
            }
            
            #contactDetails {
                line-height: 5px;
                font-size: 15px;
            }
            
            .btnPrint {
                background: url(<?= base_url('assets/front/images/print_ic.gif'); ?>) no-repeat scroll 5px center #F4F4F4;
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
            
            table {
                width: 100% !important;
                margin-bottom: 0px !important;
                border-collapse: collapse !important;
            }
            
            th, td {
                border: 1px solid black !important;
                padding: 5px;
                font-size: 12px;
                word-wrap: break-word;
                white-space: normal;
            }
            
            .table-bordered,
            .table-bordered > thead > tr > th,
            .table-bordered > tbody > tr > th,
            .table-bordered > tfoot > tr > th,
            .table-bordered > thead > tr > td,
            .table-bordered > tbody > tr > td,
            .table-bordered > tfoot > tr > td {
                border: 1px solid #000 !important;
                border-collapse: collapse !important;
            }
            
            @media print {
                @page :first {
                    margin-top: 10mm;
                    margin-bottom: 20mm;
                    margin-left: 20mm;
                    margin-right: 20mm;
                }
                @page {
                    size: A4;
                    margin: 20mm;
                }
                
                .no-print {
                    display: none !important;
                }
                
                body {
                    margin: 0;
                    padding: 0;
                    font-size: 12px;
                }
                
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 1rem;
                }
                
                table th, table td {
                    border: 1px solid #000;
                    padding: 6px;
                    text-align: left;
                    vertical-align: middle;
                }
                
                table thead th {
                    font-weight: bold;
                    background-color: #f2f2f2;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                }
                
                #watermarkImg {
                    display: block !important;
                }
                
                .new-page {
                    position:relative;
                    top: 50px;
                    page-break-after: always;
                    break-after: always;
                }
                .new-page:first{
                    top: 0px;
                }
            }
        </style>
    <?php } ?>
</style>

<div class="content-wrapper" style="min-height: 970.3px; height: auto !important;">
    <section class="content-header">
        <div class="clsHeading"><img src="<?php echo base_url('assets/images/deduction_report.jpg'); ?>" alt="Deduction Report"></div>
        <h1>Employee Contribution Excess Deduction / Excess Recovery Report</h1>
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
                        <?php
                            if(!isset($urlAry['option']) || $urlAry['option'] != "print"){ 
                            ?>
                            <h3 class="box-title">Search Filter</h3>
                            <?php if(!empty($this->input->post('emp_id'))){ ?>
                                <a class="btn btn-primary" style="float:right; margin-left:8px;" href="javascript:void(0);" onclick="printPdfExcessReport();">Print</a>
                                <!--<a class="btn btn-success" style="float:right;" href="javascript:void(0);" onclick="exportExcelExcessReport();">Export Excel</a>-->
                            <?php } ?>
                            <?php
                            }
                        ?>
                    </div>
                    
                    <div class="box-body ">
                        <form action="" method="post" name="typicaltypes" id="typicaltypes" enctype="multipart/form-data" >
                            <div class="form-row no-print">
                                <?php
                                    if(!isset($urlAry['option']) || $urlAry['option'] != "print"){ 
                                    ?>
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
                                    <div class="col-sm-2">
                                        <label class=""></label>
                                        <input type="submit" class="btn btn-primary" id="search" value="Search" style="margin: 25px 0px 0px 10px">
                                    </div>
                                    <?php 
                                    }
                                ?>
                            </div>
                            <br/><br/>
                            
                            <?php
                                if(!empty($ownerDetails) && !empty($dcpsDetails)){
                                    foreach ($ownerDetails as $ownerDetail) { 
                                        $empId = $ownerDetail['emp_id'];
                                        if (empty($dcpsDetails[$empId])) {
                                            continue;
                                        }
                                        
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
                                    <div class="searchTable new-page print-wrapper" id="print-wrapper" style="margin-top: 20px;">
                                        
                                        <!-- Basic Information Table -->
                                        <table class="<?=(!isset($urlAry['option']) || $urlAry['option'] != "print")?'table table-striped table-bordered table-hover':'';?>" cellspacing="0" width="100%">
                                            <thead class="bg-primary123">
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
                                        <table class="<?=(!isset($urlAry['option']) || $urlAry['option'] != "print")?'table table-striped table-bordered table-hover':'';?>" cellspacing="0" width="100%" style="margin-top: 15px;">
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
                                                
                                                    अन्वये सदर कर्मचाऱ्यांच्या नवीन परिभाषित अंशदान निवृत्तीवेतन योजनेबाबतच्या प्रति माह अंशदान वर्गणी कपाती विभागामार्फत प्रमाणित करण्यात येत असून, त्यानुसार सदर लेखांकन अचूक व बरोबर आहे.                                                     सदर बाबतीत भविष्यात काही आक्षेप आल्यास किंवा काही बदल असल्यास त्याची सर्वस्वी जबाबदारी कार्यकारी विभागाची राहील.
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        // Initialize Select2
        $('#employee, #pay_center').select2();
        
        // Set pay center value
        <?php if($this->input->post('pay_center')) { ?>
            $('#pay_center').val('<?= $this->input->post('pay_center'); ?>').trigger('change');
        <?php } ?>
        
        // Set employee value
        <?php if($this->input->post('emp_id')) { ?>
            $('#employee').val('<?= $this->input->post('emp_id'); ?>').trigger('change');
        <?php } ?>
        
        // On change, fetch employee details
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

    function printPdfExcessReport() {
        var frm = document.getElementById('typicaltypes');
        if(!frm) return;
        var oldAction = frm.action;
        var oldTarget = frm.target;
        frm.action = "<?=base_url();?>admin/misreport/generate_excess_report_mpdf";
        frm.target = "_blank";
        frm.submit();
        setTimeout(function(){
            frm.action = oldAction;
            frm.target = oldTarget;
        }, 500);
    }

    function exportExcelExcessReport() {
        var frm = document.getElementById('typicaltypes');
        if(!frm) return;
        var oldAction = frm.action;
        var oldTarget = frm.target;
        frm.action = "<?=base_url();?>admin/misreport/employee_contribution_excess_report/option/excel";
        frm.target = "_blank";
        frm.submit();
        setTimeout(function(){
            frm.action = oldAction;
            frm.target = oldTarget;
        }, 500);
    }
</script>
