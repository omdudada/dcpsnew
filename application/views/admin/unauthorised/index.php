<?php $this->load->view('admin/common/header');?>  
<section class="pageheader-default" style="margin-top:150px;padding:20px;">
	<div class="semitransparentbg">
		<div class="row">
			<div class="col-sm-8">
				<h1 class="animated fadeInLeftBig notransition">Unauthorized Access</h1>
			</div>	
			<div class="col-sm-4">
				<div class="float-right m-top">
				</div>
			</div>
		</div>
	</div>
</section>
<div class="panel panel-info" >
	<div class="alert alert-danger" style="margin: 10px;">
		<p>You have attempted to access a page that you are not authorized to view.</p>
		<br>
		<p>If you have any question, please contact the site administrator.</p>
	</div>
</div>
<div class="clearfix"> </div>
<?php 
	$this->load->view('admin/common/footer'); exit;
?>	