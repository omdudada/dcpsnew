<?php
$monthNames = [
    1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
    5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
    9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
];

$mNum    = isset($for_month) ? (int)$for_month : 0;
$yr      = isset($for_year) ? (int)$for_year : date('Y');
$mName   = isset($monthNames[$mNum]) ? $monthNames[$mNum] : 'Unknown';
$fyStart = ($mNum >= 4) ? $yr : ($yr - 1);
$fyLabel = $fyStart . '-' . ($fyStart + 1);
$total   = !empty($records) ? count($records) : 0;
?>

<style>
.table-listing th, .table-listing td { text-align: left; }
.col-num { text-align: right !important; }
.missing-val { color: #c0392b; font-style: italic; }
.fy-badge {
    display: inline-block; padding: 2px 8px; border-radius: 10px;
    background: #d6eaf8; color: #1a5276; font-size: 11px; font-weight: 600;
}
.info-pills { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 14px; }
.info-pill {
    background: #f4f6f9; border-left: 4px solid #3c8dbc;
    padding: 8px 16px; border-radius: 4px; font-size: 13px;
}
.info-pill strong { color: #3c8dbc; font-size: 18px; }
</style>

<div class="content-wrapper">

<section class="content-header">
    <h1>
        Records — <?php echo htmlspecialchars($mName . ' ' . $yr); ?>
        <small>Financial Year:
            <span class="fy-badge"><?php echo htmlspecialchars($fyLabel); ?></span>
        </small>
    </h1>
</section>

<section class="content">

<!-- Summary -->
<div class="info-pills">
    <div class="info-pill">
        Month & Year: <strong><?php echo htmlspecialchars($mName . ' ' . $yr); ?></strong>
    </div>
    <div class="info-pill">
        Total Records: <strong><?php echo number_format($total); ?></strong>
    </div>
    <div class="info-pill">
        Financial Year: <strong><?php echo htmlspecialchars($fyLabel); ?></strong>
    </div>
</div>

<div class="box">
<div class="box-header with-border">
    <h3 class="box-title">
        DCPS Records — <?php echo htmlspecialchars($mName . ' ' . $yr); ?>
    </h3>
    <div class="box-tools pull-right">
        <a href="<?php echo base_url('admin/dashboard'); ?>" class="btn btn-default btn-sm">
            Back
        </a>
    </div>
</div>

<div class="box-body">

<?php if (!empty($records) && is_array($records)): ?>

<div class="table-responsive">
<table class="table table-bordered table-striped table-hover table-listing" id="recordsTable">
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

<td>
    <strong>
        <?php echo htmlspecialchars(isset($row['emp_td']) ? $row['emp_td'] : '-'); ?>
    </strong>
</td>

<td>
    <?php echo !empty($row['emp_name'])
        ? htmlspecialchars($row['emp_name'])
        : '<span class="missing-val">Missing</span>'; ?>
</td>

<td>
    <?php echo !empty($row['pay_center'])
        ? htmlspecialchars($row['pay_center'])
        : '—'; ?>
</td>

<td>
    <?php echo !empty($row['bunch_no'])
        ? htmlspecialchars($row['bunch_no'])
        : '—'; ?>
</td>

<td>
    <?php echo !empty($row['file_no'])
        ? htmlspecialchars($row['file_no'])
        : '—'; ?>
</td>

<td>
    <?php echo !empty($row['recovered_DCPS_with_voucher_no'])
        ? htmlspecialchars($row['recovered_DCPS_with_voucher_no'])
        : '<span class="missing-val">Missing</span>'; ?>
</td>

<td>
<?php
if (!empty($row['recovered_DCPS_with_voucher_date']) && strtotime($row['recovered_DCPS_with_voucher_date'])) {
    echo date('d-m-Y', strtotime($row['recovered_DCPS_with_voucher_date']));
} else {
    echo '<span class="missing-val">Missing</span>';
}
?>
</td>

<td class="col-num">
    <?php echo number_format((float)(isset($row['basic']) ? $row['basic'] : 0), 2); ?>
</td>

<td class="col-num">
    <?php echo number_format((float)(isset($row['grade_pay']) ? $row['grade_pay'] : 0), 2); ?>
</td>

<td class="col-num">
    <?php echo number_format((float)(isset($row['da']) ? $row['da'] : 0), 2); ?>
</td>

<td class="col-num">
    <?php echo number_format((float)(isset($row['total_salary']) ? $row['total_salary'] : 0), 2); ?>
</td>

<td class="col-num">
    <?php echo number_format((float)(isset($row['Ideal_contribution_of_employee_for_DCPS']) ? $row['Ideal_contribution_of_employee_for_DCPS'] : 0), 2); ?>
</td>

<td class="col-num">
    <?php echo number_format((float)(isset($row['emp_DCPS_contribution']) ? $row['emp_DCPS_contribution'] : 0), 2); ?>
</td>

<td>
    <?php echo !empty($row['salary_type'])
        ? '<span class="label label-info">'.htmlspecialchars($row['salary_type']).'</span>'
        : '—'; ?>
</td>

<td>
    <?php echo !empty($row['salary_start_date'])
        ? date('d-m-Y', strtotime($row['salary_start_date']))
        : '—'; ?>
</td>

<td>
    <?php echo !empty($row['salary_end_date'])
        ? date('d-m-Y', strtotime($row['salary_end_date']))
        : '—'; ?>
</td>

<td>
    <?php echo !empty($row['remark'])
        ? htmlspecialchars($row['remark'])
        : '—'; ?>
</td>

<td>
    <a href="<?php echo base_url('admin/edit-dcps-deduction-record/' . (isset($row['id']) ? $row['id'] : 0)); ?>"
       class="btn btn-xs btn-primary">
        Edit
    </a>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>

<?php else: ?>
<div class="alert alert-info">
    No records found for <strong><?php echo htmlspecialchars($mName . ' ' . $yr); ?></strong>
</div>
<?php endif; ?>

</div>
</div>

</section>
</div>

<script>
$(function () {
    if ($.fn.DataTable) {
        $('#recordsTable').DataTable({
            order: [[1, "asc"]],
            pageLength: 25,
            responsive: true,
            language: {
                search: "Search:"
            }
        });
    }
});
</script>