<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/LoginModel');
		$this->load->library('session');
	}
	public function index()
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('username', 'UserName', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			if ($this->form_validation->run() == FALSE) {
				$this->load->view('admin/login');

			} else {
				$data = $this->LoginModel->checklogin();
				// echo  '<pre>'; print_r($data);exit;
				if ($data) {
					// foreach ($data as $key) {
					$sess_array = array
					(
						'id' => $data['id'],
						'name' => $data['name'],
						'username' => $data['username'],
						'email' => $data['email'],
						'level' => $data['level'],
						'user_role' => $data['user_role'],
						'mobile_no' => $data['mobile_no'],
						'validated' => true
					);
					// }
					$this->session->set_userdata($sess_array);
					//echo "<pre>";print_r($this->session->userdata('id'));die();
					//echo "<pre>"; print_r($this->session->all_userdata()); exit;
					//	$user_id = $_SESSION['id'];
					// echo $user_id;die();

					/*date_default_timezone_set('Asia/Kolkata');
					$last_login_time = date('d-m-Y h:i:sa');

					$updatelogin = array('login_time'=>$last_login_time);
					$this->db->where('id',$user_id);
					$this->db->update('adminuser',$updatelogin);*/

					redirect('admin/dashboard');
				} else {
					$data['errmsg'] = 'Invalid username or password';
					$this->load->view('admin/login', $data);

				}

				# code...
			}

			//echo 'hi';


		} else {
			$data['errmsg'] = '';
			$this->load->view('admin/login', $data);
		}
	}

	public function logout()
	{
		// $session_data = $this->session->userdata('logged_in');
		$session_data = $this->session->userdata();
		// echo "<pre>";print_r($session_data);die();
		$user_id = $session_data['id'];
		date_default_timezone_set('Asia/Kolkata');
		$last_login_time = date('d-m-Y h:i:sa');
		$last_login_ip = $_SERVER['REMOTE_ADDR'];
		$updatelogin = array(
			'login_time' => $last_login_time,
			'login_ip' => $last_login_ip
		);
		$this->db->where('id', $user_id);
		$this->db->update('adminuser', $updatelogin);
		$aftrow = $this->db->affected_rows();
		if ($aftrow) {
			// echo "<pre>";print_r($session_data);die();
			$this->session->unset_userdata($session_data);
			$this->session->sess_destroy();
			redirect('admin/');
			// session_destroy();
			// redirect('admin/login', 'refresh');
		}

	}

	public function loginadmin()
	{
		$data['title'] = 'Dashboard';
		$this->load->view('admin/common/header', $data);
		$this->load->view('admin/dashboard');
		$this->load->view('admin/common/footer');
		//echo 'hi';

	}

	public function changepassword()
	{
		$postData = $this->input->post();
		$session_data = $this->session->userdata();
		// echo "<pre>";print_r($this->session->userdata());die();
		$user_id = $session_data['id'];
		if ($postData) {
			//echo '<pre>'; print_r($postData);exit;

			if (!empty($postData['password']) && $postData['password'] == $postData['cfmpassword']) {
				//echo "succ";die();
				$updata = array('password' => md5($postData['password']));
				//echo  '<pre>'; print_r($user_id);//exit;
				//echo  '<pre>'; print_r($updata);exit;
				$this->db->where('id', $user_id);
				$this->db->update('adminuser', $updata);
				$aftrow = $this->db->affected_rows();
				if ($aftrow) {
					$data['update_msg'] = 'Password changed Successfully';
					$data['title'] = 'Change Password';
					$this->load->view('admin/common/header', $data);
					$this->load->view('admin/changepassword', $data);
					$this->load->view('admin/common/footer');
				}
			} else {
				// echo "failed";die();
				$data['update_msg'] = 'Password Not Updated, Please Check!!!';
				$data['title'] = 'Change Password';
				$this->load->view('admin/common/header', $data);
				$this->load->view('admin/changepassword', $data);
				$this->load->view('admin/common/footer');
			}
			//$result = $this->LoginModel->changepassword($postData,$user_id);
		} else {
			$session_data = $this->session->userdata();
			if (!$session_data) {
				redirect('admin/login');
			}
			$data['title'] = 'Change Password';
			$this->load->view('admin/common/header', $data);
			$this->load->view('admin/changepassword');
			$this->load->view('admin/common/footer');
		}
	}
}
?>