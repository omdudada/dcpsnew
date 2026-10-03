<?php
$mode       = 'add';
$record     = array();
$formAction = base_url('admin/form1/add');
$this->load->view('admin/form1/_form', array(
	'mode'         => $mode,
	'record'       => $record,
	'designations' => isset($designations) ? $designations : array(),
	'formAction'   => $formAction,
	'share_error'  => isset($share_error) ? $share_error : '',
));
