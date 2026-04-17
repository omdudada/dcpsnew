<div class="page-header">
    <h1>Add Employee</h1>
    <ul class="breadcrumb">
        <li><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
        <li><a href="<?php echo base_url('admin/emp-master'); ?>">Employee Master</a></li>
        <li>Add Employee</li>
    </ul>
</div>

<div class="box">
    <div class="box-header">
        <h3>New Employee Details</h3>
    </div>
    <div class="box-body">
        <form action="<?php echo base_url('admin/masterdata/addEmp') ?>" method="post" id="addEmpForm">
            <div class="form-row">
                <div class="form-group">
                    <label for="emp_name" class="required">Employee Name</label>
                    <input type="text" name="emp_name" id="emp_name" class="form-control" placeholder="Employee Name" required>
                </div>
                <div class="form-group">
                    <label for="emp_id" class="required">Employee ID</label>
                    <input type="text" name="emp_id" id="emp_id" class="form-control" placeholder="Employee ID" required>
                </div>
                <div class="form-group">
                    <label for="wef_date" class="required">Joining Date</label>
                    <input type="text" name="wef_date" id="wef_date" class="form-control" placeholder="dd.mm.yyyy" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="pay_center">Pay Center</label>
                    <input type="text" name="pay_center" id="pay_center" class="form-control" placeholder="Pay Center">
                </div>
                <div class="form-group">
                    <label for="fixed_pay">Fixed Pay</label>
                    <input type="number" step="0.01" name="fixed_pay" id="fixed_pay" class="form-control" placeholder="Fixed Pay">
                </div>
                <div class="form-group">
                    <label for="grade_pay">Grade Pay</label>
                    <input type="number" step="0.01" name="grade_pay" id="grade_pay" class="form-control" placeholder="Grade Pay">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="basic">Basic</label>
                    <input type="number" step="0.01" name="basic" id="basic" class="form-control" placeholder="Basic">
                </div>
                <div class="form-group">
                    <label for="da">DA</label>
                    <input type="number" step="0.01" name="da" id="da" class="form-control" placeholder="DA">
                </div>
                <div class="form-group" style="visibility: hidden;">
                </div>
            </div>

            <div style="margin-top: 20px; text-align: right;">
                <a href="<?php echo base_url('admin/emp-master'); ?>" class="btn btn-danger">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Employee</button>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function(){
    if ($.fn.datepicker) {
        $("#wef_date").datepicker({ 
            format: 'dd.mm.yyyy',
            orientation: "bottom",
            autoclose: true
        });
    }
});
</script>