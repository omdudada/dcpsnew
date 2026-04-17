<div class="page-header">
    <h1>Dashboard</h1>
    <ul class="breadcrumb">
        <li><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
        <li>Dashboard</li>
    </ul>
</div>

<!-- Stats Cards -->
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-info">
            <h3><?php echo isset($total_employees) ? $total_employees : '1,248'; ?></h3>
            <p>Total Employees</p>
        </div>
        <div class="stat-icon">&#128100;</div>
    </div>
    <div class="stat-card green">
        <div class="stat-info">
            <h3><?php echo isset($active_records) ? $active_records : '1,192'; ?></h3>
            <p>Active Records</p>
        </div>
        <div class="stat-icon">&#9989;</div>
    </div>
    <div class="stat-card orange">
        <div class="stat-info">
            <h3><?php echo isset($pending_records) ? $pending_records : '56'; ?></h3>
            <p>Pending Month Records</p>
        </div>
        <div class="stat-icon">&#9203;</div>
    </div>
    <div class="stat-card red">
        <div class="stat-info">
            <h3><?php echo isset($missing_entries) ? $missing_entries : '14'; ?></h3>
            <p>Missing Entries</p>
        </div>
        <div class="stat-icon">&#9888;</div>
    </div>
</div>

<!-- Welcome Banner -->
<div class="box">
    <div class="box-header">
        <h3>Welcome to DCPS Admin Panel</h3>
    </div>
    <div class="box-body" style="text-align:center;padding:40px;">
        <div style="font-size:60px;margin-bottom:16px;">&#127979;</div>
        <h2 style="color:var(--primary);margin-bottom:10px;">Nashik Municipal Corporation</h2>
        <p style="color:#555;font-size:15px;">Defined Contribution Pension Scheme (DCPS) Management System</p>
        <p style="color:#888;margin-top:8px;font-size:13px;">Manage employee pension records, monthly deductions, ledger reports, and more.</p>
        <div style="margin-top:24px;display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
            <a href="<?php echo base_url('admin/emp-master'); ?>" class="btn btn-primary">View Employees</a>
            <a href="<?php echo base_url('admin/monthly-record'); ?>" class="btn btn-success">Monthly Records</a>
            <a href="<?php echo base_url('admin/misreport/ledger_report_new'); ?>" class="btn btn-warning">Ledger Report</a>
        </div>
    </div>
</div>

<!-- Quick Links -->
<div class="box">
    <div class="box-header">
        <h3>Quick Links</h3>
    </div>
    <div class="box-body">
        <div style="display:flex;flex-wrap:wrap;gap:12px;">
            <a href="<?php echo base_url('admin/emp-master'); ?>" class="btn btn-primary">&#128100; Employee Master</a>
            <a href="<?php echo base_url('admin/add-employee'); ?>" class="btn btn-success">&#43; Add Employee</a>
            <a href="<?php echo base_url('admin/monthly-record'); ?>" class="btn btn-primary">&#128197; Monthly Record</a>
            <a href="<?php echo base_url('admin/dcps-deduction-record'); ?>" class="btn btn-primary">&#128203; Deduction Record</a>
            <a href="<?php echo base_url('admin/misreport/ledger_report_new'); ?>" class="btn btn-primary">&#128196; Ledger Report</a>
            <a href="<?php echo base_url('admin/misreport/deduction_report'); ?>" class="btn btn-primary">&#128202; Deduction Report</a>
            <a href="<?php echo base_url('admin/add-edit-master-record'); ?>" class="btn btn-warning">&#9998; Add Master</a>
            <a href="<?php echo base_url('admin/edit-missing-month-year-records'); ?>" class="btn btn-danger">&#9888; Pending Records</a>
        </div>
    </div>
</div>