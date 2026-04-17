<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Addeditmaster extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('admin/AddeditModel','aModel');
		$this->load->library('session');

	}

	public function index(){
		
		$postdata = $this->input->post();
		if ($postdata) {
			
			$res = $this->aModel->addDCPSMasterData($postdata);
			
			if ($res == 1) {
				$this->session->set_flashdata('success', "DCPS data added Successfully.");
				redirect('admin/add-edit-master-record');	
				//redirect('admin/monthly-record');	
			}
		}else{
			
			$data['month'] = $this->aModel->getMonthData();
			$data['year'] = $this->aModel->getYearData();
			$this->load->view('admin/common/header');
			$this->load->view('admin/addeditmaster/add_dcps_master_data',$data);
		}
		
	}

	
	    
}
?>
