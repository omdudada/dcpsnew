<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'DCPS - Nashik Municipal Corporation'; ?></title>
    <link rel="stylesheet" href="<?php echo base_url('assets/custom/css/style.css'); ?>">
    <!-- jQuery -->
    <script src="<?php echo base_url('assets/js/jquery.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/sweetalert.min.js'); ?>"></script>
</head>
<body>

<!-- TOP BAR -->
<div class="top-bar">
    <div class="logo-section">
        <div class="logo-circle">NMC</div>
        <div class="org-info">
            <h1>Nashik Municipal Corporation</h1>
            <p>DCPS (Defined Contribution Pension Scheme) Management System</p>
        </div>
    </div>
    <div class="user-menu">
        <div class="user-icon"><?php echo strtoupper(substr($this->session->userdata('name'), 0, 1)); ?></div>
        <span>Welcome, <?php echo $this->session->userdata('name'); ?></span>
        <a href="<?php echo base_url('admin/change-password'); ?>">Change Password</a>
        <a href="<?php echo base_url('admin/login/logout'); ?>" style="background:#dc3545;padding:5px 12px;border-radius:4px;">Sign Out</a>
    </div>
</div>

<!-- NAVIGATION -->
<nav class="main-nav">
    <a href="<?php echo base_url('admin/dashboard'); ?>">Home</a>
    <a href="<?php echo base_url('admin/add-edit-master-record'); ?>">Add Master</a>

    <div class="dropdown">
        <a href="#">Deduction Record &#9660;</a>
        <ul class="dropdown-menu">
            <li><a href="<?php echo base_url('admin/monthly-record'); ?>">Edit Month Wise Deduction Record</a></li>
            <li><a href="<?php echo base_url('admin/dcps-deduction-record'); ?>">Edit Employee Wise Deduction Record</a></li>
            <li><a href="<?php echo base_url('admin/edit-missing-month-year-records'); ?>">Pending Month &amp; Year Records</a></li>
        </ul>
    </div>

    <div class="dropdown">
        <a href="#">Report &#9660;</a>
        <ul class="dropdown-menu">
            <li><a href="<?php echo base_url('admin/misreport/deduction_report'); ?>">Deduction Report</a></li>
            <li><a href="<?php echo base_url('admin/misreport/employee_contribution_excess_report'); ?>">Employee Contribution Excess Deduction / Recovery Report</a></li>
            <li><a href="<?php echo base_url('admin/misreport/yearwise_ledger_summary_report'); ?>">Year-wise Ledger Summary Report</a></li>
            <?php /*<li><a href="<?php echo base_url('admin/misreport/provisional_ledger_report'); ?>">Provisional Ledger Report</a></li>*/ ?>
            <li><a href="<?php echo base_url('admin/misreport/final_ledger_report'); ?>">Final Ledger Report</a></li>            
            <?/*<li><a href="<?php echo base_url('admin/misreport/ledger_report_new'); ?>">Ledger Report</a></li>*/?>
            <li><a href="<?php echo base_url('admin/misreport/broad_sheet_report'); ?>">Broad Sheet Report</a></li>
        </ul>
    </div>

    <div class="dropdown">
        <a href="#">Team Tasks &#9660;</a>
        <ul class="dropdown-menu">
            <li><a href="<?php echo base_url('admin/team-tasks/missing-record'); ?>">Missing Record</a></li>
            <li><a href="<?php echo base_url('admin/team-tasks/duplicate-record'); ?>">Duplicate Record</a></li>
        </ul>
    </div>

    <div class="dropdown">
        <a href="#">DCPS Forms &#9660;</a>
        <ul class="dropdown-menu">
            <li><a href="<?php echo base_url('admin/form1'); ?>">FORM-1 &ndash; Application (PRAN)</a></li>
            <li><a href="<?php echo base_url('admin/statutory-forms/form2'); ?>">FORM-2 &ndash; Contribution Schedule</a></li>
            <li><a href="<?php echo base_url('admin/statutory-forms/form-r2'); ?>">FORM-R-2 &ndash; Consolidated Schedule</a></li>
            <li><a href="<?php echo base_url('admin/statutory-forms/form3-register'); ?>">FORM-3 &ndash; SRKA Register</a></li>
            <li><a href="<?php echo base_url('admin/statutory-forms/day-book'); ?>">Treasury Day Book</a></li>
        </ul>
    </div>
</nav>

<!-- CONTENT START -->
<div class="wrapper">
    <div class="content-wrapper">
