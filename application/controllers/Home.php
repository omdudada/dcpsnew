<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('default/HomeModel','hModel');
	}
	public function index()
	{
		$this->load->view('default/common/header');
		//if ($_SESSION['logged_in']['user_role'] == 1 || $_SESSION['logged_in']['user_role'] == 2) {
		$result['data'] = $this->hModel->getAllData();
		$result['totalCountBeds'] = $this->hModel->getTotalCountOfHospitalList();
		
		$this->load->view('default/home',$result);
		//}elseif ($_SESSION['logged_in']['user_role'] == 4) {
		
			//$this->load->view('admin/hospitaldashboard');
		//}
		
	}
	public function hospitalSummary()
	{
		
		$this->load->view('default/common/header');
// 		$this->load->view('default/common/header2');
		
		$result['data'] = $this->hModel->getHospitalAllData();
		$result['totalData'] = $this->hModel->getAllData();
		// echo "<pre>";print_r($result['data']);die();
		$this->load->view('default/hospital_dashboard',$result);
				
	}
	
	
}
