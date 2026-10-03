<?php
// $records variable contains the missing month/year records
?>
<style>
    .table-listing th,
    .table-listing td {
        text-align: left;
    }
</style>
<div class="content-wrapper" style="min-height: 970.3px; height: auto !important;">
    <section class="content-header">
        <h1>Pending Month & Year Records</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Missing Month/Year Records</h3>
                    </div>
                    <div class="box-body">
                        <?php if (!empty($records) && is_array($records)) { ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover table-listing"
                                    id="missingRecordsTable">
                                    <thead>
                                        <tr>
                                            <th>Bunch No.</th>
                                            <th>File No.</th>
                                            <th>Voucher No</th>
                                            <th>Voucher Date</th>
                                            <th>Pay Center</th>
                                            <th>Employee ID</th>
                                            <th>Employee Name</th>
                                            <th>Basic</th>
                                            <th>Grade Pay</th>
                                            <th>DA</th>
                                            <th>Total Salary</th>
                                            <th>Salary Start Date</th>
                                            <th>Salary End Date</th>
                                            <th>For Month</th>
                                            <th>For Year</th>
                                            <!--<th>Joining Date</th>-->
                                            <th>Remark</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($records as $row) { ?>
                                            <tr>
                                                <td><?= !empty($row['bunch_no'])
                                                    ? $row['bunch_no']
                                                    : '<span style="color:#d9534f;">Missing</span>'; ?>
                                                </td>

                                                <td><?= !empty($row['file_no'])
                                                    ? $row['file_no']
                                                    : '<span style="color:#d9534f;">Missing</span>'; ?>
                                                </td>

                                                <td><?= !empty($row['recovered_DCPS_with_voucher_no'])
                                                    ? $row['recovered_DCPS_with_voucher_no']
                                                    : '<span style="color:#d9534f;">Missing</span>'; ?>
                                                </td>

                                                <td><?= !empty($row['recovered_DCPS_with_voucher_date'])
                                                    ? date('d-m-Y', strtotime($row['recovered_DCPS_with_voucher_date']))
                                                    : '<span style="color:#d9534f;">Missing</span>'; ?>
                                                </td>
                                                <td><?= !empty($row['pay_center']) ? $row['pay_center'] : ''; ?></td>
                                                <td><?= !empty($row['emp_td']) ? $row['emp_td'] : ''; ?></td>
                                                <td><?= !empty($row['emp_name'])
                                                    ? $row['emp_name']
                                                    : '<span style="color:#d9534f;">Missing</span>'; ?>
                                                </td>

                                                <td><?= !empty($row['basic'])
                                                    ? $row['basic']
                                                    : '0'; ?>
                                                </td>
                                                 <td><?= !empty($row['grade_pay'])
                                                    ? $row['grade_pay']
                                                    : '0'; ?>
                                                </td>

                                                <td><?= !empty($row['da'])
                                                    ? $row['da']
                                                    : '0'; ?>
                                                </td>

                                                <td><?= !empty($row['total_salary'])
                                                    ? $row['total_salary']
                                                    : '0'; ?>
                                                </td>

                                                <td><?= !empty($row['salary_start_date'])
                                                    ? date('d-m-Y', strtotime($row['salary_start_date']))
                                                    : '<span style="color:#d9534f;">Missing</span>'; ?>
                                                </td>

                                                <td><?= !empty($row['salary_end_date'])
                                                    ? date('d-m-Y', strtotime($row['salary_end_date']))
                                                    : '<span style="color:#d9534f;">Missing</span>'; ?>
                                                </td>
                                                <td><?= (isset($row['for_month']) && $row['for_month']) ? $row['for_month'] : '<span style="color:#d9534f;">Missing</span>'; ?>
                                                </td>
                                                <td><?= (isset($row['for_year']) && $row['for_year']) ? $row['for_year'] : '<span style="color:#d9534f;">Missing</span>'; ?>
                                                </td>
                                                <!--<td><?= !empty($row['joining_date']) ? $row['joining_date'] : ''; ?></td>-->
                                                <td><?= !empty($row['remark']) ? $row['remark'] : ''; ?></td>
                                                <td>
                                                    <a href="<?= base_url('admin/edit-dcps-deduction-record/') . $row['id']; ?>"
                                                        class="btn btn-xs btn-primary">Edit</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } else { ?>
                            <div class="alert alert-info">No missing records found.</div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function () {
        $('#missingRecordsTable').DataTable();
    });
</script>