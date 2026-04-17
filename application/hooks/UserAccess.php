<?php
	class UserAccess
	{
		public function checkAccess() { 
			return true;
			$CI =& get_instance();
			if(!$CI->session->userdata('fyear')){
				$CI->session->set_userdata('fyear', date("Y")."-".(date("Y")+1));
			}
			// $userLoginDetails = $CI->session->userdata('logged_in');
			//echo '<pre>';print_r($CI->router);exit;
			$CI->load->model('admin/settingModel', 'setModel');
			if($CI->router->class=='ajax'){
				return true;
			}
			if(!$CI->setModel->checkAccess($CI->router->class, $CI->router->method, $CI->session->userdata('id')) && $CI->session->userdata('level') != 1){
				$CI->load->view("admin/unauthorised/index.php", true); 
			}
		}
	}
?>