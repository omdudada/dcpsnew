<?php
	class checkLoggedIn
	{
		public function index() { 
			$CI =& get_instance();
			//echo '<pre>';print_r($CI->router);exit;	
			
			//echo "<pre>"; print_r($CI->session->all_userdata()); exit;
			//echo "session value=>".$CI->session->userdata('id'); 
			//echo "<br/>routerClass=>".$CI->router->class;
			
			# Code to allow the web services like CURL, RESTAPI.
			if(!$CI->session->userdata('validated') && $CI->router->class !="login"){ 
				//$CI->session->set_userdata('rediect_url', array("url"=>base_url().$CI->uri->uri_string()));
				redirect('admin/login');
			}
		}
	}
?>