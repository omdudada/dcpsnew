<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html xmlns="http://www.w3.org/1999/xhtml">
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>Nashik Municipal Corporation</title>
		<link href="<?=base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?=base_url();?>assets/css/datepicker3.css" rel="stylesheet">
		<link href="<?=base_url();?>assets/css/styles.css" rel="stylesheet">
		<!--[if lt IE 9]>
			<script src="<?=base_url();?>assets/js/html5shiv.js"></script>
			<script src="<?=base_url();?>assets/js/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<div class="row" style="margin-top: 200px">
			<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
				<div class="login-panel panel panel-default">
					<div class="panel-heading">Admin Panel Login</div>
					<div class="panel-body"><?php
						if($this->session->flashdata('msg')): ?>
							<div id="successMsg" class="alert alert-success alert-dismissible fade in">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
								<strong>Success: </strong><?=$this->session->flashdata('msg')?>
							</div><?php
						endif; 
						if($errmsg): ?>
							<div class="alert alert-danger alert-dismissible fade in">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
								<strong>Error: </strong><?php echo $errmsg;?>
							</div><?php
						endif; ?>
						<form action="" role="form" method="post" name="loginform" id="loginform" enctype="" autocomplete="off">
							<fieldset>
								<div class="form-group">
									<input type="text" name="username" id="username" value="" class="form-control" placeholder="Username">
								</div>
								<div class="form-group">
									<input type="password" name="password" id="password" value="" class="form-control" placeholder="Password">
									<?php //if($redirect_url){?>
										<!-- <input type="hidden" name="redirect_url" value="<?=$redirect_url;?>" /> -->
									<?php //} ?>
								</div>
								<div class="form-group">
									<!-- <a href="<?=base_url();?>admin/login/forgotpassword" style="margin-bottom:10px;display:block;float:left;">पासवर्ड विसरलात ?</a> -->
									<?php /*?><a href="<?=base_url();?>admin/login/registernewuser" style="margin-bottom:10px;display:block;float:right;">नवीन वापरकर्ता नोंदणी</a><?php*/ ?>
									<!-- <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" /> -->
								</div>
                                <input style="float: right;" type="submit" class="btn btn-primary" value="Login">
							</fieldset>
						</form>
					</div>
				</div>
			</div><!-- /.col-->
		</div><!-- /.row -->
		<script src="<?=base_url();?>assets/js/jquery.min.js"></script>
		<script src="<?=base_url();?>assets/js/bootstrap.min.js"></script>
		<script src="<?=base_url();?>assets/javascript/jquery.alphanumeric.js" charset="UTF-8" type="text/javascript"></script>
		<script src="<?=base_url();?>assets/js/jquery.validate.js"></script>
		
		
		<script type="text/javascript">
			$(document).ready(function()
			{
				$(function validate(){
					var rules = 
					{
						rules: 
						{
							username:{required: true},
							password:{required: true},
						},
						messages:
						{
							username:'Username is required.',
							password:'Password is required.',
						},
					};
					$('#loginform').validate(rules);
				});
			});
		</script>
	</body>
</html>