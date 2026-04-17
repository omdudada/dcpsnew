<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public $count_visitor;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('default/HomeModel');
        $this->load->helper('counter');
        $this->count_visitor = count_visitor();
    } 

    protected function render_page($view,$data)
		{
		    $data['headermenu'] = $this->HomeModel->getheadermenu();
        $data['slider'] = $this->HomeModel->getslider();
        $data['footermenu'] = $this->HomeModel->getfootermenu();
		   $this->load->view('default/common/header', $data);
		   $this->load->view($view, $data);
		   $this->load->view('default/common/footer', $data);
		}   
}
?>