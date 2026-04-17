<?php
$months = [
    1  => "January",
    2  => "February",
    3  => "March",
    4  => "April",
    5  => "May",
    6  => "June",
    7  => "July",
    8  => "August",
    9  => "September",
    10 => "October",
    11 => "November",
    12 => "December"
];
?>
<div class="content-wrapper" style="min-height: 970.3px; height: auto !important;">
    <section class="content-header">
        <h1>Edit Monthly Record</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Record</h3>
                    </div>
                    <div class="box-body">
                        <?php if(!empty($record)) { ?>
                            <form method="post" action="" class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Employee TD</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="emp_td" class="form-control" value="<?= !empty($record['emp_td'])? $record['emp_td'] : '';?>" readonly>
                                    </div>
                                    <label class="col-sm-2 control-label">Employee Name</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="emp_name" class="form-control" value="<?= !empty($record['emp_name'])? $record['emp_name'] : '';?>" readonly>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Month</label>
                                    <div class="col-sm-4">
                                        <select name="for_month" class="form-control">
                                            <option value="">Select Month</option>
                                            <?php foreach($months as $k=>$m){
                                                $sel = (isset($record['for_month']) && $record['for_month']==$k)?'selected':'';
                                                echo '<option value="'.$k.'" '.$sel.'>'.$m.'</option>';
                                            } ?>
                                        </select>
                                    </div>
                                    <label class="col-sm-2 control-label">Year</label>
                                    <div class="col-sm-4">
                                        <select name="for_year" class="form-control">
                                            <option value="">Select Year</option>
                                            <?php
                                            // populate years from $year or fallback
                                            if(!empty($year) && is_array($year)){
                                                foreach($year as $y){
                                                    $val = $y['id'];
                                                    $label = $y['name'];
                                                    echo '<option value="'.$label.'" '.((isset($record['for_year']) && $record['for_year']==$val)?'selected':'').'>'.$label.'</option>';
                                                }
                                            } else {
                                                for ($start = 2005; $start <= 2014; $start++) {
                                                    $end = $start + 1;
                                                    $label = $start . '-' . $end;
                                                    echo '<option value="'.$label.'" '.((isset($record['for_year']) && $record['for_year']==$start)?'selected':'').'>'.$label.'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Bunch No</label>
                                    <div class="col-sm-4"><input type="text" name="bunch_no" class="form-control" value="<?= !empty($record['bunch_no'])? $record['bunch_no'] : '';?>"></div>
                                    <label class="col-sm-2 control-label">File No</label>
                                    <div class="col-sm-4"><input type="text" name="file_no" class="form-control" value="<?= !empty($record['file_no'])? $record['file_no'] : '';?>"></div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Voucher No</label>
                                    <div class="col-sm-4"><input type="text" name="recovered_DCPS_with_voucher_no" class="form-control" value="<?= !empty($record['recovered_DCPS_with_voucher_no'])? $record['recovered_DCPS_with_voucher_no'] : '';?>"></div>
                                    <label class="col-sm-2 control-label">Voucher Date</label>
                                    <div class="col-sm-4"><input type="text" name="recovered_DCPS_with_voucher_date" class="form-control" value="<?= !empty($record['recovered_DCPS_with_voucher_date'])? $record['recovered_DCPS_with_voucher_date'] : '';?>"></div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Employee Contribution</label>
                                    <div class="col-sm-4"><input type="text" name="emp_DCPS_contribution" class="form-control" value="<?= !empty($record['emp_DCPS_contribution'])? $record['emp_DCPS_contribution'] : '';?>"></div>
                                    <label class="col-sm-2 control-label">Supplementary Contribution</label>
                                    <div class="col-sm-4"><input type="text" name="emp_DCPS_supplimentory_contribution" class="form-control" value="<?= !empty($record['emp_DCPS_supplimentory_contribution'])? $record['emp_DCPS_supplimentory_contribution'] : '';?>"></div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Salary Type</label>
                                    <div class="col-sm-4">
                                        <select name="salary_type" class="form-control">
                                            <option value="">Select</option>
                                            <option value="Regular" <?= (isset($record['salary_type']) && $record['salary_type']=='Regular')?'selected':'';?>>Regular</option>
                                            <option value="Suplimentory" <?= (isset($record['salary_type']) && $record['salary_type']=='Suplimentory')?'selected':'';?>>Suplimentory</option>
                                        </select>
                                    </div>
                                    <label class="col-sm-2 control-label">Salary Start</label>
                                    <div class="col-sm-4"><input type="text" name="salary_start_date" class="form-control" value="<?= !empty($record['salary_start_date'])? $record['salary_start_date'] : '';?>"></div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Salary End</label>
                                    <div class="col-sm-4"><input type="text" name="salary_end_date" class="form-control" value="<?= !empty($record['salary_end_date'])? $record['salary_end_date'] : '';?>"></div>
                                    <label class="col-sm-2 control-label">Remark</label>
                                    <div class="col-sm-4"><input type="text" name="remark" class="form-control" value="<?= !empty($record['remark'])? $record['remark'] : '';?>"></div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <a href="<?= base_url('admin/edit-missing-month-year-records');?>" class="btn btn-default">Cancel</a>
                                    </div>
                                </div>

                            </form>
                        <?php } else { ?>
                            <div class="alert alert-danger">Record not found.</div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function(){
        $('select[name="for_year"]').select2();
    });
</script>
