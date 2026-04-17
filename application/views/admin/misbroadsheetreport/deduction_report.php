<?php
//echo "<pre>"; print_r($this->input->post()); exit;
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

    label.form-label {
        display: table-cell;
        float: left;
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
        content: " *";
        color: red;
        font-size: 18px;
    }

    table td {
        text-align: center;
    }

    table td.clsCenter {
        text-align: center;
    }

    table td.clsRight,
    table th.clsRight {
        text-align: right;
    }

    table td.clsLeft {
        text-align: left;
    }

    <?php
    if (isset($urlAry['option']) && $urlAry['option'] == "print") {
        ?>
        <style>#header {
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

        th,
        td {
            border: 1px solid black !important;
            padding: 5px;
            font-size: 12px;
            word-wrap: break-word;
            white-space: normal;
        }

        .table-bordered,
        .table-bordered>thead>tr>th,
        .table-bordered>tbody>tr>th,
        .table-bordered>tfoot>tr>th,
        .table-bordered>thead>tr>td,
        .table-bordered>tbody>tr>td,
        .table-bordered>tfoot>tr>td {
            border: 1px solid #000 !important;
            border-collapse: collapse !important;
        }

        @media print {
            @page :first {
                margin-top: 10mm;
                /* Adjust as needed */
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

            table th,
            table td {
                border: 1px solid #000;
                padding: 6px;
                text-align: left;
                /* or center/right if needed */
                vertical-align: middle;
            }

            table thead th {
                font-weight: bold;
                background-color: #f2f2f2;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            /*table {
              width: 100% !important;
              border-collapse: separate !important;
              border-spacing: 0;
            }
    
          th, td {
            border: 1px solid black !important;
            padding: 5px;
            font-size: 12px;
            word-wrap: break-word;
            white-space: normal;
            text-align: center;
          }
      
      
    
          .table-bordered,
          .table-bordered > thead > tr > th,
          .table-bordered > tbody > tr > td {
            border: 1px solid #000 !important;
            border-collapse: separate !important;
            border-spacing: 0;
          }*/

            #watermarkImg {
                display: block !important;
            }

            .new-page {
                position: relative;
                top: 50px;
                page-break-after: always;
                break-after: always;
            }

            .new-page:first {
                top: 0px;
            }

            /* Remove or comment out scaling unless absolutely needed */
            /*.print-wrapper {
            transform: scale(1); 
            transform-origin: top left; 
            }*/
        }
    </style>
<?php } ?>


</style>
<?php //echo "<pre>";print_r($data);die(); ?>
<div class="content-wrapper" style="min-height: 970.3px; height: auto !important;">
    <section class="content-header">
        <h1>Deduction Report</h1>

        <!-- <ol class="breadcrumb">
            <li><a href="<?= base_url('admin/index') ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            
            <li class="active">Call Center Form</li>
        </ol> -->
    </section>

    <?php if (validation_errors()) { ?>
        <!-- Alert message -->
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo validation_errors(); ?>
        </div>
        <!--/ Alert message -->
    <?php } ?>
    <section class="content" style="height: auto !important; min-height: 0px !important;">
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-header with-border">
                        <?php
                        if (!isset($urlAry['option']) && $urlAry['option'] != "print") {
                            ?>
                            <h3 class="box-title">Deduction Report</h3>
                            <a class="btn btn-primary btnPrint" style="float:right;"
                                href="<?= base_url(); ?>admin/misreport/deduction_report/year/<?= $this->input->post('year'); ?>/option/print">प्रिंट
                            </a>
                            <?php
                        }
                        ?>
                    </div>

                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade in">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">x</span></button>
                            <strong>Success: </strong><?= $this->session->flashdata('success'); ?>
                        </div>
                    <?php endif;
                    if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade in">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">x</span></button>
                            <strong>Error: </strong><?= $this->session->flashdata('error'); ?>
                        </div>
                    <?php endif; ?>
                    <div class="box-body ">
                        <?php //echo "<pre>";print_r($hospitals);die(); ?>
                        <form action="" method="post" name="typicaltypes" id="typicaltypes"
                            enctype="multipart/form-data">
                            <div class="form-row no-print">

                                <?php
                                if (is_array($urlAry) && $urlAry['option'] != "print") {
                                    ?>
                                    <div class="form-group col-md-2">
                                        <label for="inputState">Pay Center</label>
                                        <select id="pay_center" name="pay_center" class="form-control">
                                            <option selected value="">Select Pay Center</option>
                                            <?php
                                            foreach ($paycenterData as $row) {
                                                echo '<option value="' . htmlspecialchars($row['pay_center']) . '">' . htmlspecialchars($row['pay_center']) . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputState">Employee Name (Employee Id) </label>
                                        <select id="employee" name="emp_id" class="form-control">
                                            <option name="emp_id" selected value="">Select Employee Name / Employee Id
                                            </option>
                                            <?php
                                            foreach ($employeeData as $row) {
                                                echo '<option value="' . $row['emp_id'] . '">' . $row['emp_name'] . " (" . $row['emp_id'] . ") " . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputState">Year</label>
                                        <select id="year" name="year" class="form-control">
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
                                        <select id="from_month" name="from_month" class="form-control">
                                            <option selected value="">Select From Month</option>
                                            <?php
                                            foreach ($months as $monthNo => $monthName) {
                                                echo '<option value="' . $monthNo . '">' . $monthName . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputState">From Month</label>
                                        <select id="to_month" name="to_month" class="form-control">
                                            <option selected value="">Select To Month</option>
                                            <?php
                                            foreach ($months as $monthNo => $monthName) {
                                                echo '<option value="' . $monthNo . '">' . $monthName . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputCity">Voucher No.</label>
                                        <input type="text" name="voucher_no" id="voucher_no" class="form-control"
                                            placeholder="Voucher No." value="<?= $this->input->post("voucher_no"); ?>">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputCity">Voucher Date</label>
                                        <input type="text" name="voucher_date" id="voucher_date" class="form-control"
                                            placeholder="Voucher Date" value="<?= $this->input->post("voucher_date"); ?>">
                                    </div>
                                    <div class="col-sm-1">
                                        <label for="inputState" class=""></label>
                                        <input type="submit" class="btn btn-primary" id="search" value="Search"
                                            style="margin: 12px 0px 0px 0px">
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                            <br /><br />

                            <?php
                            if (!empty($ownerDetails) && $ownerDetails) {
                                foreach ($ownerDetails as $ownerDetail) {
                                    ?>
                                    <div class="searchTable new-page print-wrapper" id="print-wrapper">

                                        <table
                                            class="<?= (!(isset($urlAry['option']) && $urlAry['option'] == "print")) ? 'table table-striped table-bordered table-hover' : ''; ?>"
                                            cellspacing="0" width="100%">
                                            <?/*<table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">*/ ?>
                                            <thead class="bg-primary123">
                                                <tr>
                                                    <th style="text-align:center;" colspan="18">
                                                        <strong>Form R-3</strong>
                                                        <div>(As referred to in Para no. 18 & 23 of Government Resolution -
                                                            Finance Departmeny, No. CPS 1007/18/SER-4, dated 7 July, 2007)</div>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th style="text-align:center;" colspan="18">
                                                        नाशिक महानगरपालिका,नाशिक </th>
                                                </tr>
                                                <tr>
                                                    <th style="text-align:center;" colspan="18">
                                                        परिभाषित अंशदान निवृत्ती वेतन योजना - वार्षिक विवरण
                                                        (<?= $searchData['f_year']; ?>) </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="3">कर्मचारी क्रमांक</th>
                                                    <td colspan="3">
                                                        <?= !empty($ownerDetail['emp_id']) ? $ownerDetail['emp_id'] : ''; ?>
                                                    </td>
                                                    <th colspan="3">कर्मचारी नाव</th>
                                                    <td colspan="9">
                                                        <?= !empty($ownerDetail['emp_name']) ? $ownerDetail['emp_name'] : ''; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th colspan="3">कर्मचारी नियुक्ती दिनांक</th>
                                                    <td colspan="3">
                                                        <?= !empty($ownerDetail['joining_date']) ? $ownerDetail['joining_date'] : ''; ?>
                                                    </td>
                                                    <th colspan="3">पे सेंटर</th>
                                                    <td><?= !empty($ownerDetail['pay_center']) ? $ownerDetail['pay_center'] : ''; ?>
                                                    </td>
                                                    <th colspan="1">हुद्दा</th>
                                                    <td><?= !empty($ownerDetail['designation_name']) ? $ownerDetail['designation_name'] : ''; ?>
                                                    </td>
                                                    <!--<th colspan="2">सुरुवातीची शिल्लक</th>-->
                                                    <td colspan="6"></td>
                                                </tr>
                                                <tr>
                                                    <th>महिना</th>
                                                    <th>गठ्ठा क्रमांक</th>
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

                                                $empId = $ownerDetail['emp_id'];

                                                if (isset($dcpsDetails[$empId])) {
                                                    // First Year: April to December
                                                    for ($monthNo = 4; $monthNo <= 12; $monthNo++) {
                                                        /*$year = $searchData['first_year'];
                                                        $records = isset($dcpsDetails[$empId][$year][$monthNo]) ? $dcpsDetails[$empId][$year][$monthNo] : [];*/



                                                        if (!empty($searchData['first_year'])) {
                                                            $year = $searchData['first_year'];
                                                        } else {
                                                            $yearKeys = isset($dcpsDetails[$empId]) ? array_keys($dcpsDetails[$empId]) : [];

                                                            $year = !empty($yearKeys) ? reset($yearKeys) : null;
                                                        }
                                                        //echo $year; exit;
                                        
                                                        $records = isset($dcpsDetails[$empId][$year][$monthNo])
                                                            ? $dcpsDetails[$empId][$year][$monthNo]
                                                            : [];

                                                        // If records exist, loop through and display each
                                                        if (!empty($records)) {
                                                            $rowspan = count($records); // Count of rows for rowspan
                                                            $firstRow = true;
                                                            //echo "<pre>"; print_r($records); exit;
                                                            foreach ($records as $row) {

                                                                $basic = (float) (isset($row['basic']) && $row['basic'] !== '' ? $row['basic'] : 0);
                                                                $grade_pay = (float) (isset($row['grade_pay']) && $row['grade_pay'] !== '' ? $row['grade_pay'] : 0);
                                                                $da = (float) (isset($row['da']) && $row['da'] !== '' ? $row['da'] : 0);
                                                                $total_salary = (float) (isset($row['total_salary']) && $row['total_salary'] !== '' ? $row['total_salary'] : 0);

                                                                $ideal_contri = (float) (
                                                                    isset($row['Ideal_contribution_of_employee_for_DCPS'])
                                                                    && $row['Ideal_contribution_of_employee_for_DCPS'] !== ''
                                                                    ? $row['Ideal_contribution_of_employee_for_DCPS']
                                                                    : 0
                                                                );

                                                                $emp_sup_contri = (float) (
                                                                    isset($row['salary_type']) && $row['salary_type'] === 'Regular'
                                                                    ? (isset($row['emp_DCPS_contribution']) && $row['emp_DCPS_contribution'] !== ''
                                                                        ? $row['emp_DCPS_contribution']
                                                                        : 0)
                                                                    : (isset($row['emp_DCPS_supplimentory_contribution']) && $row['emp_DCPS_supplimentory_contribution'] !== ''
                                                                        ? $row['emp_DCPS_supplimentory_contribution']
                                                                        : 0)
                                                                );

                                                                $difference = $emp_sup_contri - $ideal_contri;

                                                                /* Safe totals initialization */
                                                                $totalBasic = (float) (isset($totalBasic) ? $totalBasic : 0);
                                                                $totalGradePay = (float) (isset($totalGradePay) ? $totalGradePay : 0);
                                                                $totalDA = (float) (isset($totalDA) ? $totalDA : 0);
                                                                $totalTotalSalary = (float) (isset($totalTotalSalary) ? $totalTotalSalary : 0);
                                                                $totalIdealContribution = (float) (isset($totalIdealContribution) ? $totalIdealContribution : 0);
                                                                $totalEmpSupContri = (float) (isset($totalEmpSupContri) ? $totalEmpSupContri : 0);
                                                                $totalDifference = (float) (isset($totalDifference) ? $totalDifference : 0);

                                                                /* Totals */
                                                                $totalBasic += $basic;
                                                                $totalGradePay += $grade_pay;
                                                                $totalDA += $da;
                                                                $totalTotalSalary += $total_salary;
                                                                $totalIdealContribution += $ideal_contri;
                                                                $totalEmpSupContri += $emp_sup_contri;
                                                                $totalDifference += $difference;

                                                                $monthName = isset($months[$monthNo]) ? $months[$monthNo] : $monthNo;
                                                                ?>
                                                                <tr>
                                                                    <?php
                                                                    if ($firstRow) {
                                                                        echo '<td rowspan="' . $rowspan . '" style="vertical-align:middle;">' . $monthName . ' ' . $year . '</td>';
                                                                        $firstRow = false;
                                                                    }

                                                                    ?>
                                                                    <td class="clsCenter"><?= isset($row['bunch_no']) ? $row['bunch_no'] : '' ?>
                                                                    </td>
                                                                    <td><?= isset($row['file_no']) ? $row['file_no'] : '' ?></td>
                                                                    <td><?= isset($row['recovered_DCPS_with_voucher_no']) ? $row['recovered_DCPS_with_voucher_no'] : '' ?>
                                                                    </td>
                                                                    <td><?= isset($row['recovered_DCPS_with_voucher_date']) ? $row['recovered_DCPS_with_voucher_date'] : '' ?>
                                                                    </td>
                                                                    <td class="clsRight"><?= $basic ?></td>
                                                                    <td class="clsRight"><?= $grade_pay ?></td>
                                                                    <td class="clsRight"><?= $da ?></td>
                                                                    <td class="clsRight"><?= $total_salary ?></td>
                                                                    <td class="clsRight"><?= $ideal_contri ?></td>
                                                                    <td class="clsRight"><?= $emp_sup_contri ?></td>
                                                                    <td class="clsRight"><?= $difference ?></td>
                                                                    <td><?= isset($row['salary_start_date']) ? $row['salary_start_date'] : '' ?>
                                                                    </td>
                                                                    <td><?= isset($row['salary_end_date']) ? $row['salary_end_date'] : '' ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        if ((isset($row['basic']) && $row['grade_pay'] != 0) && (isset($row['grade_pay']) && $row['grade_pay'] != 0) && (isset($row['da']) && $row['da'] != 0)) {
                                                                            echo "Regular";
                                                                        } else {
                                                                            echo 'Suplimentory';
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td class="clsLeft"><?= isset($row['remark']) ? $row['remark'] : '' ?></td>
                                                                    <td class="clsLeft"><?= isset($row['reason']) ? $row['reason'] : ""; ?></td>
                                                                    <td><a href="<?= base_url('admin/edit-dcps-deduction-record/' . $row['id']); ?>"
                                                                            target="_blank">Edit Record</a></td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        } else {
                                                            // No record, render zero-filled or blank row
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
                                                                <td><a href="<?= base_url('admin/add-edit-master-record'); ?>"
                                                                        target="_blank">Add Record</a></td>
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

                                                        //echo "<pre>"; print_r($records); echo "</pre>"; //exit;
                                        
                                                        // If records exist, loop through and display each
                                                        if (!empty($records)) {
                                                            $rowspan = count($records); // Count of rows for rowspan
                                                            $firstRow = true;
                                                            foreach ($records as $row) {
                                                                $basic = (float) (isset($row['basic']) && $row['basic'] !== '' ? $row['basic'] : 0);
                                                                $grade_pay = (float) (isset($row['grade_pay']) && $row['grade_pay'] !== '' ? $row['grade_pay'] : 0);
                                                                $da = (float) (isset($row['da']) && $row['da'] !== '' ? $row['da'] : 0);
                                                                $total_salary = (float) (isset($row['total_salary']) && $row['total_salary'] !== '' ? $row['total_salary'] : 0);

                                                                $ideal_contri = (float) (
                                                                    isset($row['Ideal_contribution_of_employee_for_DCPS'])
                                                                    && $row['Ideal_contribution_of_employee_for_DCPS'] !== ''
                                                                    ? $row['Ideal_contribution_of_employee_for_DCPS']
                                                                    : 0
                                                                );

                                                                $emp_sup_contri =
                                                                    (float) (isset($row['emp_DCPS_contribution']) && $row['emp_DCPS_contribution'] !== ''
                                                                        ? $row['emp_DCPS_contribution']
                                                                        : 0)
                                                                    + (float) (isset($row['emp_DCPS_supplimentory_contribution']) && $row['emp_DCPS_supplimentory_contribution'] !== ''
                                                                        ? $row['emp_DCPS_supplimentory_contribution']
                                                                        : 0);

                                                                $difference = $emp_sup_contri - $ideal_contri;

                                                                /* Initialize totals safely */
                                                                $totalBasic = (float) (isset($totalBasic) ? $totalBasic : 0);
                                                                $totalGradePay = (float) (isset($totalGradePay) ? $totalGradePay : 0);
                                                                $totalDA = (float) (isset($totalDA) ? $totalDA : 0);
                                                                $totalTotalSalary = (float) (isset($totalTotalSalary) ? $totalTotalSalary : 0);
                                                                $totalIdealContribution = (float) (isset($totalIdealContribution) ? $totalIdealContribution : 0);
                                                                $totalEmpSupContri = (float) (isset($totalEmpSupContri) ? $totalEmpSupContri : 0);
                                                                $totalDifference = (float) (isset($totalDifference) ? $totalDifference : 0);

                                                                /* Add values */
                                                                $totalBasic += $basic;
                                                                $totalGradePay += $grade_pay;
                                                                $totalDA += $da;
                                                                $totalTotalSalary += $total_salary;
                                                                $totalIdealContribution += $ideal_contri;
                                                                $totalEmpSupContri += $emp_sup_contri;
                                                                $totalDifference += $difference;

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
                                                                    <td><?= isset($row['recovered_DCPS_with_voucher_no']) ? $row['recovered_DCPS_with_voucher_no'] : '' ?>
                                                                    </td>
                                                                    <td><?= isset($row['recovered_DCPS_with_voucher_date']) ? $row['recovered_DCPS_with_voucher_date'] : '' ?>
                                                                    </td>
                                                                    <td class="clsRight"><?= $basic ?></td>
                                                                    <td class="clsRight"><?= $grade_pay ?></td>
                                                                    <td class="clsRight"><?= $da ?></td>
                                                                    <td class="clsRight"><?= $total_salary ?></td>
                                                                    <td class="clsRight"><?= $ideal_contri ?></td>
                                                                    <td class="clsRight"><?= $emp_sup_contri ?></td>
                                                                    <td class="clsRight"><?= $difference ?></td>
                                                                    <td><?= isset($row['salary_start_date']) ? $row['salary_start_date'] : '' ?>
                                                                    </td>
                                                                    <td><?= isset($row['salary_end_date']) ? $row['salary_end_date'] : '' ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        if ((isset($row['basic']) && $row['grade_pay'] != 0) && (isset($row['grade_pay']) && $row['grade_pay'] != 0) && (isset($row['da']) && $row['da'] != 0)) {
                                                                            echo "Regular";
                                                                        } else {
                                                                            echo 'Suplimentory';
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td class="clsLeft"><?= isset($row['remark']) ? $row['remark'] : '' ?></td>
                                                                    <td class="clsLeft"><?= isset($row['reason']) ? $row['reason'] : ""; ?></td>
                                                                    <td><a href="<?= base_url('admin/edit-dcps-deduction-record/' . $row['id']); ?>"
                                                                            target="_blank">Edit Record</a></td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        } else {
                                                            // No record, render zero-filled or blank row
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
                                                                <td><a href="<?= base_url('admin/add-edit-master-record'); ?>"
                                                                        target="_blank">Add Record</a></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>

                                                <tr>
                                                    <th colspan="5">एकूण <?= $searchData['f_year']; ?></th>
                                                    <th class="clsRight"><?= $totalBasic; ?></th>
                                                    <th class="clsRight"><?= $totalGradePay; ?></th>
                                                    <th class="clsRight"><?= $totalDA; ?></th>
                                                    <th class="clsRight"><?= $totalTotalSalary; ?></th>
                                                    <th class="clsRight"><?= $totalIdealContribution; ?></th>
                                                    <th class="clsRight"><?= $totalEmpSupContri; ?></th>
                                                    <th class="clsRight"><?= $totalDifference; ?></th>
                                                    <th colspan="5"></th>
                                                </tr>
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
<script language="javascript" src="<?= base_url(); ?>assets/javascript/jquery.printPage.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".btnPrint").printPage();

        $("#voucher_date").datepicker({ format: 'dd-mm-yyyy', orientation: "bottom" });

        /*$(".btnPrint").on("click", function() {
            html2pdf().from(document.getElementById('print-wrapper')).save();
        });*/

        // Initialize Select2
        $('#employee, #pay_center').select2();

        // Set pay center value (must be set before calling getEmployeeDetails)
        <?php if ($this->input->post('pay_center')) { ?>
            $('#pay_center').val('<?= $this->input->post('pay_center'); ?>').trigger('change');
        <?php } ?>

        <?php if ($this->input->post('from_month')) { ?>
            $('#from_month').val('<?= $this->input->post('from_month'); ?>').trigger('change');
        <?php } ?>

        <?php if ($this->input->post('to_month')) { ?>
            $('#to_month').val('<?= $this->input->post('to_month'); ?>').trigger('change');
        <?php } ?>

        // Set year if needed
        <?php if ($this->input->post('year')) { ?>
            $('#year').val('<?= $this->input->post('year'); ?>');
        <?php } ?>

        // On change, fetch employee details
        $('#pay_center').on('change', function () {
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
                    success: function (response) {
                        $('#employee').empty().append('<option value="">Select Employee Name / Employee Id</option>');

                        if (response && response.length > 0) {
                            $.each(response, function (index, employee) {
                                var optionValue = employee.emp_id;
                                var optionText = employee.emp_name + " (" + employee.emp_id + ")";
                                var selected = (optionValue === selectedEmpId) ? ' selected' : '';
                                $('#employee').append('<option value="' + optionValue + '"' + selected + '>' + optionText + '</option>');
                            });

                            // Trigger change for Select2 UI update
                            $('#employee').val(selectedEmpId).trigger('change');
                        }
                    },
                    error: function (xhr) {
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