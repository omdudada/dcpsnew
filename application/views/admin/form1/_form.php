<?php
/**
 * Shared FORM-1 form body, included by add.php and edit.php.
 * Expects:
 *   $mode          'add' | 'edit'
 *   $record        existing record array (edit) or empty (add)
 *   $designations  array of {id, designation_name}
 *   $formAction    full URL the form posts to
 */
$record = isset($record) ? $record : array();
$nominees = (isset($record['nominees']) && !empty($record['nominees'])) ? $record['nominees'] : array();

// value helper: prefer saved record (edit), else repopulate old POST (add)
$v = function($field, $default = '') use ($record){
	if(!empty($record) && isset($record[$field]) && $record[$field] !== null){
		return html_escape($record[$field]);
	}
	return html_escape(set_value($field, $default));
};
$selected = function($field, $option) use ($record){
	$cur = (!empty($record) && isset($record[$field])) ? $record[$field] : set_value($field);
	return ((string)$cur === (string)$option) ? 'selected' : '';
};
?>
<link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-datepicker.min.css'); ?>">

<div class="content-wrapper" style="min-height: 970.3px; height: auto !important;">
	<section class="content-header">
		<div class="heading-icon-badge"><img src="<?php echo base_url('assets/images/file.png'); ?>" alt="FORM-1 Application"></div>
		<h1><?php echo ($mode === 'edit') ? 'Edit' : 'Add'; ?> FORM-1 Application</h1>
	</section>
	<section class="content" style="height:auto !important; min-height:0 !important;">
		<div class="row"><div class="col-lg-12"><div class="box">
			<div class="box-header with-border">
				<h4>FORM-1 &ndash; Application for Pension Account No. (employee appointed on/after 01-11-2005)</h4>
				<a href="<?php echo base_url('admin/form1'); ?>" class="btn btn-default" style="float:right;"><i class="fa fa-arrow-circle-left"></i> Back</a>
			</div>

			<?php if(validation_errors()): ?>
			<div class="alert alert-danger alert-dismissible fade in">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php echo validation_errors(); ?>
			</div>
			<?php endif;
			if(!empty($share_error)): ?>
			<div class="alert alert-danger alert-dismissible fade in">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php echo html_escape($share_error); ?>
			</div>
			<?php endif;
			if($this->session->flashdata('fail')): ?>
			<div class="alert alert-danger"><?php echo html_escape($this->session->flashdata('fail')); ?></div>
			<?php endif; ?>

			<div class="box-body">
				<form action="<?php echo $formAction; ?>" method="post" id="form1" enctype="multipart/form-data" novalidate>

					<h4 class="text-primary">Employee Details</h4>
					<div class="form-row row">
						<div class="form-group col-md-2">
							<label>Salutation</label>
							<select name="salutation" class="form-control">
								<?php foreach(array('','Shri','Smt','Kum','Dr') as $s): ?>
								<option value="<?php echo $s; ?>" <?php echo $selected('salutation',$s); ?>><?php echo $s ?: '--'; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group col-md-4">
							<label>First Name <span class="text-danger">*</span></label>
							<input type="text" name="first_name" class="form-control" value="<?php echo $v('first_name'); ?>" required>
						</div>
						<div class="form-group col-md-3">
							<label>Middle Name</label>
							<input type="text" name="middle_name" class="form-control" value="<?php echo $v('middle_name'); ?>">
						</div>
						<div class="form-group col-md-3">
							<label>Surname</label>
							<input type="text" name="last_name" class="form-control" value="<?php echo $v('last_name'); ?>">
						</div>

						<div class="form-group col-md-3">
							<label>Gender</label>
							<select name="gender" class="form-control">
								<?php foreach(array('','Male','Female','Other') as $g): ?>
								<option value="<?php echo $g; ?>" <?php echo $selected('gender',$g); ?>><?php echo $g ?: '--'; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group col-md-3">
							<label>Date of Birth <span class="text-danger">*</span></label>
							<input type="text" name="dob" class="form-control datepick" value="<?php echo $v('dob'); ?>" placeholder="dd.mm.yyyy" required>
						</div>
						<div class="form-group col-md-3">
							<label>Date of Joining Service <span class="text-danger">*</span></label>
							<input type="text" name="date_of_joining" class="form-control datepick" value="<?php echo $v('date_of_joining'); ?>" placeholder="dd.mm.yyyy" required>
						</div>
						<div class="form-group col-md-3">
							<label>Date of Appointment</label>
							<input type="text" name="date_of_appointment" class="form-control datepick" value="<?php echo $v('date_of_appointment'); ?>" placeholder="dd.mm.yyyy">
						</div>

						<div class="form-group col-md-3">
							<label>PRAN / Pension A/C No.</label>
							<input type="text" name="pran_no" class="form-control" value="<?php echo $v('pran_no'); ?>">
						</div>
						<div class="form-group col-md-3">
							<label>Employee ID</label>
							<input type="text" name="emp_id" class="form-control" value="<?php echo $v('emp_id'); ?>">
						</div>
						<div class="form-group col-md-3">
							<label>Designation</label>
							<select name="designation_id" class="form-control">
								<option value="">-- Select --</option>
								<?php foreach($designations as $d): ?>
								<option value="<?php echo $d['id']; ?>" <?php echo $selected('designation_id',$d['id']); ?>><?php echo html_escape($d['designation_name']); ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group col-md-3">
							<label>Pay &amp; Scale of Pay</label>
							<input type="text" name="pay_scale" class="form-control" value="<?php echo $v('pay_scale'); ?>">
						</div>
					</div>

					<h4 class="text-primary">Office &amp; Contact</h4>
					<div class="form-row row">
						<div class="form-group col-md-6">
							<label>Name of Office</label>
							<input type="text" name="office_name" class="form-control" value="<?php echo $v('office_name'); ?>">
						</div>
						<div class="form-group col-md-6">
							<label>Office Address</label>
							<input type="text" name="office_address" class="form-control" value="<?php echo $v('office_address'); ?>">
						</div>
						<div class="form-group col-md-6">
							<label>Residential Address</label>
							<input type="text" name="residential_address" class="form-control" value="<?php echo $v('residential_address'); ?>">
						</div>
						<div class="form-group col-md-3">
							<label>Phone No.</label>
							<input type="text" name="phone_no" class="form-control" value="<?php echo $v('phone_no'); ?>">
						</div>
						<div class="form-group col-md-3">
							<label>Mobile No.</label>
							<input type="text" name="mobile_no" class="form-control" value="<?php echo $v('mobile_no'); ?>" placeholder="10-digit">
						</div>
						<div class="form-group col-md-4">
							<label>Email</label>
							<input type="text" name="email" class="form-control" value="<?php echo $v('email'); ?>">
						</div>
						<div class="form-group col-md-2">
							<label>Pay Center</label>
							<input type="text" name="pay_center" class="form-control" value="<?php echo $v('pay_center'); ?>">
						</div>
						<div class="form-group col-md-2">
							<label>DDO Code</label>
							<input type="text" name="ddo_code" class="form-control" value="<?php echo $v('ddo_code'); ?>">
						</div>
						<div class="form-group col-md-2">
							<label>Department Code</label>
							<input type="text" name="dept_code" class="form-control" value="<?php echo $v('dept_code'); ?>">
						</div>
						<div class="form-group col-md-2">
							<label>Treasury Code</label>
							<input type="text" name="treasury_code" class="form-control" value="<?php echo $v('treasury_code'); ?>">
						</div>
					</div>

					<h4 class="text-primary">Previous Service</h4>
					<div class="form-row row">
						<div class="form-group col-md-3">
							<label>Previously in another DCPS office?</label>
							<select name="prev_govt_service" class="form-control">
								<option value="0" <?php echo $selected('prev_govt_service','0'); ?>>No</option>
								<option value="1" <?php echo $selected('prev_govt_service','1'); ?>>Yes</option>
							</select>
						</div>
						<div class="form-group col-md-9">
							<label>If yes, details</label>
							<input type="text" name="prev_service_details" class="form-control" value="<?php echo $v('prev_service_details'); ?>">
						</div>
						<div class="form-group col-md-6">
							<label>Scanned FORM-1 (pdf/jpg/png, max 4MB)</label>
							<input type="file" name="form_scan" class="form-control-file">
							<?php if(!empty($record['form_scan'])): ?>
								<small>Current: <a href="<?php echo base_url('assets/uploads/form1/'.$record['form_scan']); ?>" target="_blank"><?php echo html_escape($record['form_scan']); ?></a></small>
							<?php endif; ?>
						</div>
					</div>

					<h4 class="text-primary">Nominee Details <small>(total share must equal 100%)</small></h4>
					<div class="table-responsive">
						<table class="table table-bordered" id="nominee-table">
							<thead class="bg-primary">
								<tr>
									<th>Name &amp; Address</th>
									<th width="12%">Date of Birth</th>
									<th width="14%">Relationship</th>
									<th width="10%">Share %</th>
									<th width="14%">Guardian (if minor)</th>
									<th width="6%"></th>
								</tr>
							</thead>
							<tbody>
								<?php
								$renderRow = function($n = array()){ ?>
								<tr>
									<td>
										<input type="text" name="nominee_name[]" class="form-control" placeholder="Name" value="<?php echo html_escape(isset($n['nominee_name'])?$n['nominee_name']:''); ?>">
										<input type="text" name="nominee_address[]" class="form-control" placeholder="Address" style="margin-top:4px;" value="<?php echo html_escape(isset($n['nominee_address'])?$n['nominee_address']:''); ?>">
									</td>
									<td><input type="text" name="nominee_dob[]" class="form-control datepick" placeholder="dd.mm.yyyy" value="<?php echo html_escape(isset($n['dob'])?$n['dob']:''); ?>"></td>
									<td><input type="text" name="nominee_relationship[]" class="form-control" value="<?php echo html_escape(isset($n['relationship'])?$n['relationship']:''); ?>"></td>
									<td><input type="number" step="0.01" min="0" max="100" name="nominee_share[]" class="form-control share" value="<?php echo html_escape(isset($n['share_percentage'])?$n['share_percentage']:''); ?>"></td>
									<td><input type="text" name="nominee_guardian[]" class="form-control" value="<?php echo html_escape(isset($n['guardian_name'])?$n['guardian_name']:''); ?>"></td>
									<td style="text-align:center;"><button type="button" class="btn btn-danger btn-sm rm-nominee"><i class="fa fa-times"></i></button></td>
								</tr>
								<?php };
								if(!empty($nominees)){ foreach($nominees as $n){ $renderRow($n); } }
								else { $renderRow(); }
								?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="3" style="text-align:right;"><strong>Total Share %</strong></td>
									<td><input type="text" id="share-total" class="form-control" readonly></td>
									<td colspan="2"><button type="button" class="btn btn-success btn-sm" id="add-nominee"><i class="fa fa-plus"></i> Add Nominee</button></td>
								</tr>
							</tfoot>
						</table>
					</div>

					<div class="col-sm-12" style="text-align:right;">
						<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo ($mode === 'edit') ? 'Update' : 'Save'; ?></button>
					</div>
				</form>
			</div>
		</div></div></div>
	</section>
</div>

<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap-datepicker.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.validate.js'); ?>"></script>
<script type="text/javascript">
$(function(){
	function bindDatepick(ctx){
		$(ctx).find('.datepick').datepicker({ format:'dd.mm.yyyy', orientation:'bottom', autoclose:true });
	}
	bindDatepick(document);

	function recalc(){
		var t = 0;
		$('#nominee-table .share').each(function(){ t += parseFloat($(this).val()) || 0; });
		$('#share-total').val(t.toFixed(2));
		$('#share-total').css('color', (Math.abs(t-100) < 0.01 || t === 0) ? '#000' : '#d9534f');
	}
	$('#nominee-table').on('input', '.share', recalc);
	recalc();

	$('#add-nominee').on('click', function(){
		var $row = $('#nominee-table tbody tr:first').clone();
		$row.find('input').val('');
		$('#nominee-table tbody').append($row);
		bindDatepick($row);
		recalc();
	});
	$('#nominee-table').on('click', '.rm-nominee', function(){
		if($('#nominee-table tbody tr').length > 1){ $(this).closest('tr').remove(); }
		else { $(this).closest('tr').find('input').val(''); }
		recalc();
	});

	// client-side validation mirrors the server rules
	$('#form1').validate({
		rules: {
			first_name: { required:true, maxlength:100 },
			dob: { required:true },
			date_of_joining: { required:true },
			mobile_no: { pattern: /^[0-9]{10}$/ },
			email: { email:true }
		},
		messages: {
			mobile_no: { pattern: 'Enter a valid 10-digit mobile number.' }
		},
		submitHandler: function(form){
			var t = 0, has = false;
			$('#nominee-table .share').each(function(){ var x=parseFloat($(this).val())||0; if(x>0) has=true; t+=x; });
			if(has && Math.abs(t-100) > 0.01){
				alert('Total nominee share must equal 100% (currently '+t.toFixed(2)+'%).');
				return false;
			}
			form.submit();
		}
	});
	// jQuery Validate "pattern" method (from additional-methods); fallback if absent
	if($.validator && !$.validator.methods.pattern){
		$.validator.addMethod('pattern', function(value, el, param){
			if(this.optional(el)) return true;
			return param.test(value);
		});
	}
});
</script>
