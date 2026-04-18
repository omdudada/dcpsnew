<?php
$monthNames = [
    1 => 'January',  2 => 'February', 3 => 'March',    4 => 'April',
    5 => 'May',       6 => 'June',     7 => 'July',      8 => 'August',
    9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
];
$mNum    = (int) $for_month;
$yr      = (int) $for_year;
$mName   = isset($monthNames[$mNum]) ? $monthNames[$mNum] : $mNum;
$fyStart = ($mNum >= 4) ? $yr : ($yr - 1);
$fyLabel = $fyStart . '-' . ($fyStart + 1);
$total   = count($records);
?>

<style>
    .table-listing th,
    .table-listing td { text-align: left; }
    .col-num { text-align: right !important; }
    .missing-val { color: #c0392b; font-style: italic; }
    .fy-badge {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 10px;
        background: #d6eaf8;
        color: #1a5276;
        font-size: 11px;
        font-weight: 600;
    }
    .info-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 14px;
    }
    .info-pill {
        background: #f4f6f9;
        border-left: 4px solid #3c8dbc;
        padding: 8px 16px;
        border-radius: 4px;
        font-size: 13px;
    }
    .info-pill strong { color: #3c8dbc; font-size: 18px; }
</style>

<div class="content-wrapper" style="min-height: 970px; height: auto !important;">

    <!-- Page Header -->
    <section class="content-header">
        <h1>
            Records &mdash; <?php echo $mName . ' ' . $yr; ?>
            <small>Financial Year: <span class="fy-badge"><?php echo $fyLabel; ?></span></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?php echo $mName . ' ' . $yr; ?></li>
        </ol>
    </section>

    <section class="content">

        <!-- Summary Pills -->
        <div class="info-pills">
            <div class="info-pill">
                Month &amp; Year: <strong><?php echo $mName . ' ' . $yr; ?></strong>
            </div>
            <div class="info-pill">
                Total Records: <strong><?php echo number_format($total); ?></strong>
            </div>
            <div class="info-pill">
                Financial Year: <strong><?php echo $fyLabel; ?></strong>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <i class="fa fa-list"></i>
                            DCPS Records &mdash; <?php echo $mName . ' ' . $yr; ?>
                        </h3>
                        <div class="box-tools pull-right">
                            <a href="<?php echo base_url('admin/dashboard'); ?>"
                               class="btn btn-default btn-sm">
                                <i class="fa fa-arrow-left"></i> Back to Dashboard
                            </a>
                        </div>
                    </div><!-- /.box-header -->

                    <div class="box-body">
                        <?php if (!empty($records) && is_array($records)): ?>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover table-listing"
                                       id="recordsTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Emp ID</th>
                                            <th>Employee Name</th>
                                            <th>Pay Center</th>
                                            <th>Bunch No</th>
                                            <th>File No</th>
                                            <th>Voucher No</th>
                                            <th>Voucher Date</th>
                                            <th>Basic</th>
                                            <th>Grade Pay</th>
                                            <th>DA</th>
                                            <th>Total Salary</th>
                                            <th>Ideal Contribution</th>
                                            <th>Emp Contribution</th>
                                            <th>Salary Type</th>
                                            <th>Salary Start</th>
                                            <th>Salary End</th>
                                            <th>Remark</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($records as $i => $row): ?>
                                        <tr>
                                            <td><?php echo $i + 1; ?></td>

                                            <td><strong><?php echo htmlspecialchars($row['emp_td']); ?></strong></td>

                                            <td>
                                                <?php echo !empty($row['emp_name'])
                                                    ? htmlspecialchars($row['emp_name'])
                                                    : '<span class="missing-val">Missing</span>'; ?>
                                            </td>

                                            <td>
                                                <?php echo !empty($row['pay_center'])
                                                    ? htmlspecialchars($row['pay_center'])
                                                    : '&mdash;'; ?>
                                            </td>

                                            <td>
                                                <?php echo !empty($row['bunch_no'])
                                                    ? htmlspecialchars($row['bunch_no'])
                                                    : '<span class="missing-val">&mdash;</span>'; ?>
                                            </td>

                                            <td>
                                                <?php echo !empty($row['file_no'])
                                                    ? htmlspecialchars($row['file_no'])
                                                    : '<span class="missing-val">&mdash;</span>'; ?>
                                            </td>

                                            <td>
                                                <?php echo !empty($row['recovered_DCPS_with_voucher_no'])
                                                    ? htmlspecialchars($row['recovered_DCPS_with_voucher_no'])
                                                    : '<span class="missing-val">Missing</span>'; ?>
                                            </td>

                                            <td>
                                                <?php echo !empty($row['recovered_DCPS_with_voucher_date'])
                                                    ? date('d-m-Y', strtotime($row['recovered_DCPS_with_voucher_date']))
                                                    : '<span class="missing-val">Missing</span>'; ?>
                                            </td>

                                            <td class="col-num">
                                                <?php echo number_format((float) ($row['basic'] ?? 0), 2); ?>
                                            </td>

                                            <td class="col-num">
                                                <?php echo number_format((float) ($row['grade_pay'] ?? 0), 2); ?>
                                            </td>

                                            <td class="col-num">
                                                <?php echo number_format((float) ($row['da'] ?? 0), 2); ?>
                                            </td>

                                            <td class="col-num">
                                                <?php echo number_format((float) ($row['total_salary'] ?? 0), 2); ?>
                                            </td>

                                            <td class="col-num">
                                                <?php echo number_format((float) ($row['Ideal_contribution_of_employee_for_DCPS'] ?? 0), 2); ?>
                                            </td>

                                            <td class="col-num">
                                                <?php echo number_format((float) ($row['emp_DCPS_contribution'] ?? 0), 2); ?>
                                            </td>

                                            <td>
                                                <?php echo !empty($row['salary_type'])
                                                    ? '<span class="label label-info">' . htmlspecialchars($row['salary_type']) . '</span>'
                                                    : '&mdash;'; ?>
                                            </td>

                                            <td>
                                                <?php echo !empty($row['salary_start_date'])
                                                    ? date('d-m-Y', strtotime($row['salary_start_date']))
                                                    : '&mdash;'; ?>
                                            </td>

                                            <td>
                                                <?php echo !empty($row['salary_end_date'])
                                                    ? date('d-m-Y', strtotime($row['salary_end_date']))
                                                    : '&mdash;'; ?>
                                            </td>

                                            <td style="max-width:160px;white-space:normal;">
                                                <?php echo !empty($row['remark'])
                                                    ? htmlspecialchars($row['remark'])
                                                    : '&mdash;'; ?>
                                            </td>

                                            <td>
                                                <a href="<?php echo base_url('admin/edit-dcps-deduction-record/' . $row['id']); ?>"
                                                   class="btn btn-xs btn-primary">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div><!-- /.table-responsive -->

                        <?php else: ?>
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle"></i>
                                No DCPS records found for <strong><?php echo $mName . ' ' . $yr; ?></strong>.
                            </div>
                        <?php endif; ?>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<script>
    $(document).ready(function () {
        $('#recordsTable').DataTable({
            "order": [[1, "asc"]],
            "pageLength": 25,
            "language": {
                "search": "Search records:"
            }
        });
    });
</script>
