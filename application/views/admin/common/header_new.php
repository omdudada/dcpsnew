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
    <a href="<?php echo base_url('admin/misreport/ledger_report_new'); ?>">Ledger Report</a>
    <a href="<?php echo base_url('admin/monthly-record'); ?>">Edit Month Wise Deduction Record</a>
    <a href="<?php echo base_url('admin/edit-missing-month-year-records'); ?>">Pending Month &amp; Year Records</a>
    <a href="<?php echo base_url('admin/misreport/deduction_report'); ?>">Deduction Report</a>
    <a href="<?php echo base_url('admin/dcps-deduction-record'); ?>">Edit Employee Wise Deduction Record</a>
    <a href="<?php echo base_url('admin/add-edit-master-record'); ?>">Add Master</a>
    <div class="dropdown">
        <a href="#">Team Tasks &#9660;</a>
        <ul class="dropdown-menu">
            <?php for($i=1; $i<=12; $i++): ?>
                <li><a href="<?php echo base_url('admin/team-wise-tasks/team/'.$i); ?>">Team <?php echo $i; ?></a></li>
            <?php endfor; ?>
        </ul>
    </div>
</nav>

<!-- CONTENT START -->
<div class="wrapper">
    <div class="content-wrapper">
