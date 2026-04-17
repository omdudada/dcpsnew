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
		$data['title'] = 'Dashboard - DCPS Nashik';
		
		// Optional: Fetch actual counts from model
		// $data['total_employees'] = $this->dModel->get_total_employees();
		
		$this->load->view('admin/common/header_new', $data);
		$this->load->view('admin/dashboard', $data);
		$this->load->view('admin/common/footer_new');
	}
	
        
}
?>
