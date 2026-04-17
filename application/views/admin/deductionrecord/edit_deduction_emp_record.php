<?php //echo "<pre>";print_r($editData);exit;?>
<div class="content-wrapper" style="min-height: 970.3px; height: auto !important;">
	<section class="content-header">
		<h1>Edit DCPS Master Data</h1>
		<!-- <ol class="breadcrumb">
			<li><a href="<?=base_url('admin/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
			<li><a href="<?=base_url($routeUrl)?>">Employee Master</a></li>
			<li class="active"><?=($this->router->method=="add")?"Add":"Edit";?> Employee</li>
		</ol> -->
	</section>
	<section class="content" style="height: auto !important; min-height: 0px !important;">
		<div class="row">
			<div class="col-lg-12">
				<div class="box">
					<div class="box-header with-border">
						<h4>Edit DCPS Master Data</h4>
					</div>
					
					<?php if($this->session->flashdata('success')):?>
					<div class="alert alert-success alert-dismissible fade in">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
						<strong>Success: </strong><?=$this->session->flashdata('success');?>
					</div>
					<?php endif; 
					if($this->session->flashdata('fail')):?>
					<div class="alert alert-danger alert-dismissible fade in">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
						<strong>Error: </strong><?=$this->session->flashdata('fail');?>
					</div>
					<?php endif; ?>
					<div class="box-body">
						
						<form action="<?php echo base_url(); ?>admin/report/editDeductionRecord/<?php echo $editData['id']; ?>" method="post" name="typicaltypes" id="typicaltypes" enctype="multipart/form-data" novalidate="novalidate">
							<div class="form-row">
								<div class="form-group col-md-4">
									<label for="inputCity">Employee ID</label>
									<input type="text" name="emp_td" id="emp_td" class="form-control" placeholder="Employee ID" value="<?php echo $editData['emp_td']; ?>" readonly>
							    </div>
							    <div class="form-group col-md-4">
									<label for="inputCity">Employee Name</label>
									<input type="text" name="emp_name" id="emp_name" class="form-control" placeholder="Employee Name" value="<?php echo $editData['emp_name']; ?>" readonly>
							    </div>
							    
							    <div class="form-group col-md-4">
									<label for="inputCity">Joining Date</label>
									<input type="text" name="wef_date" id="wef_date" class="form-control" placeholder="Joining Date" value="<?php echo $editData['joining_date']; ?>">
							    </div>
							    
							    <div class="form-group col-md-4">
									<label for="inputCity">Pay Center</label>
									<input type="text" name="pay_center" id="pay_center" class="form-control" placeholder="Pay Center" value="<?php echo $editData['pay_center']; ?>">
							    </div>
							    <div class="form-group col-md-4">
									<label for="inputCity">Basic</label>
									<input type="text" name="basic" id="basic" class="form-control" placeholder="Basic" value="<?php echo $editData['basic']; ?>">
							    </div>
							    <div class="form-group col-md-4">
									<label for="inputCity">DA</label>
									<input type="text" name="da" id="da" class="form-control" placeholder="da" value="<?php echo $editData['da']; ?>">
							    </div>
							    
							    <div class="form-group col-md-4">
									<label for="inputCity">Grade Pay</label>
									<input type="text" name="grade_pay" id="grade_pay" class="form-control" placeholder="Grade Pay" value="<?php echo $editData['grade_pay']; ?>">
							    </div>
							    <div class="form-group col-md-4">
									<label for="inputCity">Ideal Contribution Of Employee For DCPS</label>
									<input type="text" name="Ideal_contribution_of_employee_for_DCPS" id="Ideal_contribution_of_employee_for_DCPS" class="form-control" placeholder="Ideal Contribution Of Employee For DCPS" value="<?php echo $editData['Ideal_contribution_of_employee_for_DCPS']; ?>" readonly="readonly">
							    </div>
							    <div class="form-group col-md-4">
									<label for="inputCity">Ideal Contribution Of NMC For DCPS</label>
									<input type="text" name="Ideal_contribution_of_NMC_for_DCPS" id="Ideal_contribution_of_NMC_for_DCPS" class="form-control" placeholder="Ideal Contribution Of NMC For DCPS" value="<?php echo $editData['Ideal_contribution_of_NMC_for_DCPS']; ?>"  readonly="readonly">
							    </div>
							    
							    <div class="form-group col-md-4">
									<label for="inputCity">Opening Balance</label>
									<input type="text" name="opening_balance" id="opening_balance" class="form-control" placeholder="Opening Balance" value="<?php echo $editData['opening_balance']; ?>">
							    </div>
							    <div class="form-group col-md-4">
									<label for="inputCity">Bunch No</label>
									<input type="text" name="bunch_no" id="bunch_no" class="form-control" placeholder="Bunch No" value="<?php echo $editData['bunch_no']; ?>">
							    </div>
							    <div class="form-group col-md-4">
									<label for="inputCity">File No</label>
									<input type="text" name="file_no" id="file_no" class="form-control" placeholder="File No" value="<?php echo $editData['file_no']; ?>">
							    </div>
							    
							    <div class="form-group col-md-4">
									<label for="inputCity">Recovered DCPS with Voucher No</label>
									<input type="text" name="recovered_DCPS_with_voucher_no" id="recovered_DCPS_with_voucher_no" class="form-control" placeholder="Recovered DCPS with Voucher No" value="<?php echo $editData['recovered_DCPS_with_voucher_no']; ?>">
							    </div>
							    <?php //echo "<pre>";print_r($month);die(); ?>
							    <div class="form-group col-md-4">
							     	<label for="inputState">Salary Month</label>
							     	<select id="for_month" name="for_month" class="form-control">
							       		<option name="for_month" value="0" selected>--Select Month--</option>
							        <?php
				                        foreach($month as $row)
				                        { //echo "<pre>";print_r($row);die(); ?>
				                        	<option value="<?php echo $row['id']; ?>" <?php if ($editData['for_month'] == $row['id']) {echo 'selected="selected"';} ?> ><?php echo $row['month']; ?></option>
				                        <?php }
				                        ?>
							      </select>
							    </div>
							    <?php /* <div class="form-group col-md-4">
							     	<label for="inputState">Salary Year</label>
							     	<select id="year" name="year" class="form-control">
							       		<option name="year" value="0" selected>--Select Year--</option>
							        <?php
				                        foreach($year as $row)
				                        {?>
				                            <option value="<?php echo $row['id']; ?>" <?php if ($editData['for_year'] == $row['id']) {echo 'selected="selected"';} ?> ><?php echo $row['year']; ?></option>
				                        <?php }
				                        ?>
							      	</select>
							    </div> */?> 
							    <div class="form-group col-md-4">
                                    <label for="for_year">Financial Year</label>
                                    <select id="for_year" name="for_year" class="form-control">
                                        <option value="0">--Select Year--</option>
                                        <?php
                                        $startYear = 2005;
                                        $endYear   = 2015; // current year + 1
                                
                                        // editData मधून current financial year काढणे
                                        $editMonth = isset($editData['for_month']) ? (int)$editData['for_month'] : 0;
                                        $editYear  = isset($editData['for_year']) ? (int)$editData['for_year'] : 0;
                                
                                        // फाइनान्शियल वर्ष ठरवणे
                                        if ($editMonth >= 4) {
                                            $currentFY = $editYear . "-" . ($editYear + 1);
                                        } elseif ($editMonth > 0) {
                                            $currentFY = ($editYear - 1) . "-" . $editYear;
                                        } else {
                                            $currentFY = "";
                                        }
                                
                                        // ड्रॉपडाऊन भरणे
                                        for ($year = $startYear; $year <= $endYear; $year++) {
                                            $fy = $year . "-" . ($year + 1);
                                            $selected = ($fy == $currentFY) ? "selected" : "";
                                            echo "<option value='$fy' $selected>$fy</option>";
                                        }
                                        ?>
                                    </select>
                                </div>


							    
							    <div class="form-group col-md-4">
									<label for="inputCity">Salary Start Date</label>
									<input type="text" name="salary_start_date" id="salary_start_date" class="form-control" placeholder="Salary Start Date" value="<?php echo $editData['salary_start_date']; ?>">
							    </div>
							    <div class="form-group col-md-4">
									<label for="inputCity">Salary End Date</label>
									<input type="text" name="salary_end_date" id="salary_end_date" class="form-control" placeholder="Salary End Date" value="<?php echo $editData['salary_end_date']; ?>">
							    </div>
							    <div class="form-group col-md-4">
									<label for="inputCity">Recovered DCPS with Voucher Date</label>
									<input type="text" name="recovered_DCPS_with_voucher_date" id="recovered_DCPS_with_voucher_date" class="form-control" placeholder="Recovered DCPS with Voucher Date" value="<?php echo $editData['recovered_DCPS_with_voucher_date']; ?>">
							    </div>
							    <div class="form-group col-md-4">
                                    <label>Salary Type</label><br>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" 
                                               name="salary_type" 
                                               id="salary_type_regular" 
                                               value="Regular" 
                                               class="form-check-input"
                                               <?php if (!empty($editData['salary_type']) && $editData['salary_type'] === 'Regular') echo 'checked'; ?>>
                                        <label class="form-check-label" for="salary_type_regular">Regular</label>
                                    </div>
                                
                                    <div class="form-check form-check-inline">
                                        <input type="radio" 
                                               name="salary_type" 
                                               id="salary_type_supplementary" 
                                               value="Suplimentory" 
                                               class="form-check-input"
                                               <?php if (!empty($editData['salary_type']) && $editData['salary_type'] === 'Suplimentory') echo 'checked'; ?>>
                                        <label class="form-check-label" for="salary_type_supplementary">Supplementary</label>
                                    </div>
                                </div>
							    <div class="form-group col-md-4">
									<label for="inputCity">Employee DCPS Regular Contribution</label>
									<input type="text" name="emp_DCPS_contribution" id="emp_DCPS_contribution" class="form-control" placeholder="Employee DCPS Regular Contribution" value="<?php echo $editData['emp_DCPS_contribution']; ?>" <?php if (!empty($editData['salary_type']) && $editData['salary_type'] === 'Suplimentory') echo 'readonly'; ?>>
							    </div>
							    <div class="form-group col-md-4">
									<label for="inputCity">NMC's DCPS Regular Contribution</label>
									<input type="text" name="NMC_DCPS_contribution" id="NMC_DCPS_contribution" class="form-control" placeholder="NMC's DCPS Regular Contribution" value="<?php echo $editData['NMC_DCPS_contribution']; ?>" <?php if (!empty($editData['salary_type']) && $editData['salary_type'] === 'Suplimentory') echo 'readonly'; ?> readonly>
							    </div>
							    
							    <div class="form-group col-md-4">
									<label for="inputCity">Employee DCPS Supplementary Contribution</label>
									<input type="text" name="emp_DCPS_supplimentory_contribution" id="emp_DCPS_supplimentory_contribution" class="form-control" placeholder="Employee DCPS Supplementary Contribution" value="<?php echo $editData['emp_DCPS_supplimentory_contribution']; ?>" <?php if (!empty($editData['salary_type']) && $editData['salary_type'] === 'Regular') echo 'readonly'; ?>>
							    </div>
							    
							    
							    <div class="form-group col-md-4">
									<label for="inputCity">NMC's DCPS Supplementary  Contribution</label>
									<input type="text" name="NMC_supplimentory_DCPS_contribution" id="NMC_supplimentory_DCPS_contribution" class="form-control" placeholder="NMC's DCPS Supplementary Contributio" value="<?php echo $editData['NMC_supplimentory_DCPS_contribution']; ?>" <?php if (!empty($editData['salary_type']) && $editData['salary_type'] === 'Regular') echo 'readonly'; ?> readonly>
							    </div>
							    <div class="form-group col-md-4">
									<label for="inputCity">DCPS Loan Taken by an Employee</label>
									<input type="text" name="DCPS_loan_taken_by_an_employee" id="DCPS_loan_taken_by_an_employee" class="form-control" placeholder="DCPS Loan Taken by an Employee" value="<?php echo $editData['DCPS_loan_taken_by_an_employee']; ?>">
							    </div>
							    
							    <div class="form-group col-md-4">
									<label for="inputCity">Loan Installment Paid Through Regular Salary</label>
									<input type="text" name="loan_installment_paid_through_salary" id="loan_installment_paid_through_salary" class="form-control" placeholder="Loan Installment Paid Through Salary" value="<?php echo $editData['loan_installment_paid_through_salary']; ?>">
							    </div>
							    <div class="form-group col-md-4">
									<label for="inputCity">Loan Installment Paid In Cash</label>
									<input type="text" name="loan_installment_paid_in_cash" id="loan_installment_paid_in_cash" class="form-control" placeholder="Loan Installment Paid In Cash" value="<?php echo $editData['loan_installment_paid_in_cash']; ?>">
							    </div>
							    <div class="form-group col-md-4">
									<label for="inputCity">Loan Installment Paid Through Supplementary Salary</label>
									<input type="text" name="supplimentory_loan_installment_paid" id="supplimentory_loan_installment_paid" class="form-control" placeholder="Supplementary Loan Installment Paid" value="<?php echo $editData['supplimentory_loan_installment_paid']; ?>">
							    </div>
							    
							    <div class="form-group col-md-4">
									<label for="inputCity">Total Amount Of Loan Installments Paid</label>
									<input type="text" name="total_amount_of_loan_installments_paid" id="total_amount_of_loan_installments_paid" class="form-control" placeholder="Total Amount Of Loan Installments Paid" value="<?php echo $editData['total_amount_of_loan_installments_paid']; ?>">
							    </div>
							    <?/*<div class="form-group col-md-4">
									<label for="inputCity">Amount To be recovered From Employee</label>
									<input type="text" name="amount_to_be_recovered_from_emp" id="amount_to_be_recovered_from_emp" class="form-control" placeholder="Amount To be recovered From Employee" value="<?php echo $editData['amount_to_be_recovered_from_emp']; ?>">
							    </div>
							    <div class="form-group col-md-4">
									<label for="inputCity">To be recovered for voucher No</label>
									<input type="text" name="to_be_recovered_for_voucher_no" id="to_be_recovered_for_voucher_no" class="form-control" placeholder="To be recovered for voucher No" value="<?php echo $editData['to_be_recovered_for_voucher_no']; ?>">
							    </div>
							    
							    <div class="form-group col-md-4">
									<label for="inputCity">To be recovered for voucher Date</label>
									<input type="text" name="to_be_recovered_for_voucher_date" id="to_be_recovered_for_voucher_date" class="form-control" placeholder="To be recovered for voucher Date" value="<?php echo $editData['to_be_recovered_for_voucher_date']; ?>">
							    </div>
							    <div class="form-group col-md-4">
									<label for="inputCity">Gr Percentage</label>
									<input type="text" name="gr_percentage" id="gr_percentage" class="form-control" placeholder="Gr Percentage" readonly="" value="<?php echo $editData['gr_percentage']; ?>">
							    </div>
							    <div class="form-group col-md-4">
									<label for="inputCity">NMC Share to be Given</label>
									<input type="text" name="NMC_share_to_be_given" id="NMC_share_to_be_given" class="form-control" placeholder="NMC Share to be Given" value="<?php echo $editData['NMC_share_to_be_given']; ?>">
							    </div>
							    <div class="clearfix"></div>
							    <div class="form-group col-md-4">
									<label for="inputCity">Recovered with Voucher No</label>
									<input type="text" name="recovered_with_voucher_no" id="recovered_with_voucher_no" class="form-control" placeholder="Recovered with Voucher No" value="<?php echo $editData['recovered_with_voucher_no']; ?>">
							    </div>
							    
							    <div class="form-group col-md-4">
									<label for="inputCity">Recovered Date</label>
									<input type="text" name="recovered_date" id="recovered_date" class="form-control" placeholder="Recovered Date" value="<?php echo $editData['recovered_date']; ?>">
							    </div>
							    <div class="form-group col-md-4">
							     	<label for="inputState">Recovered Month</label><br>
							     	<input type="checkbox" name="recovered_month[]" id="chk_chess" value="0" checked >
							     	<label for="checkbox_php"/>No Recovered Month</label>
							     	<br>
							     	<input type="checkbox" name="recovered_month[]" id="chk_chess" value="1">
							     	<label for="checkbox_php"/>Jan</label>
            						<input type="checkbox" name="recovered_month[]" id="chk_games" value="2">
            						<label for="checkbox_php">Feb</label>
            						<input type="checkbox" name="recovered_month[]" id="chk_cricket" value="3">
            						<label for="checkbox_php">Mar</label>
            						<input type="checkbox" name="recovered_month[]" id="chk_chess" value="4">
							     	<label for="checkbox_php"/>Apr</label>
            						<input type="checkbox" name="recovered_month[]" id="chk_games" value="5">
            						<label for="checkbox_php">May</label>
            						<input type="checkbox" name="recovered_month[]" id="chk_cricket" value="6">
            						<label for="checkbox_php">June</label>
            						<br>
							     	<input type="checkbox" name="recovered_month[]" id="chk_chess" value="7">
							     	<label for="checkbox_php"/>July</label>
            						<input type="checkbox" name="recovered_month[]" id="chk_games" value="8">
            						<label for="checkbox_php">Aug</label>
            						<input type="checkbox" name="recovered_month[]" id="chk_cricket" value="9">
            						<label for="checkbox_php">Sept</label>
            						<input type="checkbox" name="recovered_month[]" id="chk_chess" value="10">
							     	<label for="checkbox_php"/>Oct</label>
            						<input type="checkbox" name="recovered_month[]" id="chk_games" value="11">
            						<label for="checkbox_php">Nov</label>
            						<input type="checkbox" name="recovered_month[]" id="chk_cricket" value="12">
            						<label for="checkbox_php">Dec</label>
							    </div>
							    <div class="clearfix"></div>
							    <div class="form-group col-md-4">
							     	<label for="inputState">Recovered Year</label>
							     	<select id="recovered_year" name="recovered_year" class="form-control">
							       		<option name="recovered_year" value="0" selected>--Select Year--</option>
							        <?php
				                        foreach($year as $row)
				                        {?>
				                            <option value="<?php echo $row['id']; ?>" <?php if ($editData['recovered_year'] == $row['id']) {echo 'selected="selected"';} ?> ><?php echo $row['year']; ?></option>
				                        <?php }
				                        ?>
							      	</select>
							    </div>*/?>
							    
							    <?/*<div class="form-group col-md-4">
									<label for="inputCity">Remark</label>
									<input type="text" name="remark" id="remark" class="form-control" placeholder="Remark" value="<?php echo $editData['remark']; ?>">
							    </div>*/?>
							    <div class="form-group col-md-4">
                                    <label for="remark">Remark</label>
                                    <select id="remark" name="remark" class="form-control">
                                        <option value="" selected>--Select Remark--</option>
                                        <option value="Correct Entry. Checked and Verified." 
                                            <?php if ($editData['remark'] == "Correct Entry. Checked and Verified.") {echo 'selected="selected"';} ?>>
                                            Correct Entry. Checked and Verified.
                                        </option>
                                        <option value="New Entry Added. Checked and Verified." 
                                            <?php if ($editData['remark'] == "New Entry Added. Checked and Verified.") {echo 'selected="selected"';} ?>>
                                            New Entry Added. Checked and Verified.
                                        </option>
                                        <option value="Entry Updated. Checked and Verified." 
                                            <?php if ($editData['remark'] == "Entry Updated. Checked and Verified.") {echo 'selected="selected"';} ?>>
                                            Entry Updated. Checked and Verified.
                                        </option>
                                        <option value="Entry to be Deleted. Checked and Verified." 
                                            <?php if ($editData['remark'] == "Entry to be Deleted. Checked and Verified.") {echo 'selected="selected"';} ?>>
                                            Entry to be Deleted. Checked and Verified.
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
									<label for="inputCity">Reason</label>
									<input type="text" name="reason" id="reason" class="form-control" placeholder="Reason" value="<?=$editData['reason'];?>">
							    </div>

							    <div class="clearfix"></div>
							</div>
							<div class="col-sm-12" style="text-align: right;">
								<input type="hidden" name="id" value="<?php echo $editData['id']; ?>" id="id">   
								<input type="submit" class="btn btn-primary" value="Submit">
								<!-- <a href="<?=base_url($routeUrl)?>" class="btn btn-primary"><i class="fa fa-arrow-circle-left"></i> Back</a> -->
							</div>
						</form>
					</div>
				</div>
			</div> 
		</div>
	</section>
</div>

<script type="text/javascript">
	$(document).ready(function(){
        $('#emp_DCPS_supplimentory_contribution').on('input change', function () {
            let value = $(this).val();
            $('#NMC_supplimentory_DCPS_contribution').val(value);
            $('#NMC_DCPS_contribution, #emp_DCPS_contribution').val('');
        });
        
        $('#emp_DCPS_contribution').on('input change', function () {
            let value = $(this).val();
            $('#NMC_DCPS_contribution').val(value);
            $('#NMC_supplimentory_DCPS_contribution, #emp_DCPS_supplimentory_contribution').val('');
        });
        
        
	    
	    function toggleContributionFields() {
            if ($('#salary_type_regular').is(':checked')) {
                // Regular selected → Supplementary fields readonly, Regular fields editable
                $('#emp_DCPS_supplimentory_contribution, #NMC_supplimentory_DCPS_contribution').prop('readonly', true);
                $('#emp_DCPS_contribution').prop('readonly', false);
            } 
            else if ($('#salary_type_supplementary').is(':checked')) {
                // Supplementary selected → Regular fields readonly, Supplementary fields editable
                $('#emp_DCPS_contribution, #NMC_DCPS_contribution').prop('readonly', true);
                $('#emp_DCPS_supplimentory_contribution').prop('readonly', false);
            }
        }
    
        // Trigger when radio changes
        $('input[name="salary_type"]').change(function () {
            toggleContributionFields();
        });
    
        // Run on page load in case data is pre-filled
        toggleContributionFields();
        
        function calculateContributions() {
            // Get values as numbers (treat empty as 0)
            let basic = parseFloat($('#basic').val()) || 0;
            let da = parseFloat($('#da').val()) || 0;
            let gradePay = parseFloat($('#grade_pay').val()) || 0;
    
            // Sum them
            let total = basic + da + gradePay;
    
            // Calculate 10%
            let contribution = Math.round((total * 10) / 100);
    
            // Show in both fields (fixed to 2 decimals)
            $('#Ideal_contribution_of_employee_for_DCPS').val(contribution);
            $('#Ideal_contribution_of_NMC_for_DCPS').val(contribution);
        }
    
        // Trigger calculation whenever input changes
        $('#basic, #da, #grade_pay').on('input', function () {
            calculateContributions();
        });
        
        calculateContributions();

		// $("#wef_date").datepicker({ dateFormat: "dd/mm/yy" });
		$("#wef_date, #salary_start_date, #salary_end_date").datepicker({ format: 'dd-mm-yyyy',orientation: "bottom" }); 
		$("#recovered_DCPS_with_voucher_date").datepicker({ format: 'dd-mm-yyyy',orientation: "bottom" }); 
		$("#to_be_recovered_for_voucher_date").datepicker({ format: 'dd-mm-yyyy',orientation: "bottom" });

		$("#to_be_recovered_for_voucher_date").on('change',function(e){
			e.preventDefault(); 
			var v_date = $("#to_be_recovered_for_voucher_date").val();
			alert(v_date);
			var url = "<?php echo base_url('ajax/changePer'); ?>";
			
			$.ajax(
			{
				type:"post",
				url: url,
				data:{ v_date:v_date},
				success:function(response)
				{
					
					var obj = jQuery.parseJSON(response);
					// alert(obj);
					$("#gr_percentage").val(obj.gr_percentage);
					// var options = '';
					// $("#sub_ward").html("");
					// options += '<option value="\'\'">--Select Sub Ward--</option>';
					// $.each( obj, function( key, wardDetails ) {
					// 	//alert(wardDetails.optionValue);
					// 	options += '<option value="' + wardDetails.optionValue + '">' + wardDetails.optionText + '</option>';
					// });
					// $("#sub_ward").html(options);
					
					
					
					
				}
			});
		}); 
		
	});
</script>								