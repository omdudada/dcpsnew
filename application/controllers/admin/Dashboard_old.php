<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('admin/DashboardModel','dModel');
		$this->load->library('session');

	}

	public function index()
	{
		$this->load->view('admin/common/header');
		$this->load->view('admin/dashboard');
		
	}
	
        
}
?>
