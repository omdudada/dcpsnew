<?php
$this->load->view('admin/form1/_form', array(
	'mode'         => 'edit',
	'record'       => isset($record) ? $record : array(),
	'designations' => isset($designations) ? $designations : array(),
	'formAction'   => base_url('admin/form1/edit/'.$record['id']),
	'share_error'  => isset($share_error) ? $share_error : '',
));
