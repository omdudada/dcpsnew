<?php
class LoginModel extends CI_Model{
	public function checklogin(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		// echo $password;die();

		$this->db->select('id,name,username,email,level,user_role,mobile_no');
		$this->db->from('adminuser');
		$this->db->where(array('username'=>$username,'password'=>md5($password)));
		$this->db->limit(1);
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		if ($query) {
			return $query->row_array();
		}
		return false;

	}

	public function changepassword($postData){
		// $session_data = $this->session->userdata('logged_in');
  //           $user_id = $session_data['id'];
  //           $updata  = array('password' =>$postData['new_pass'], );
  //        $this->db->where('id',$user_id);
  //        $this->db->update('admin_user',$updata);
  //         $aftrow = $this->db->affected_rows();
  //        if ($aftrow >0) {
  //        	return true;
  //        } else{
  //        	return false;
  //        }
        
	}

	public function updatelogintime($user_id){
		//$name = $_SESSION['logged_in'];
			//echo 'hereiiii';
			//echo  '<pre>'; print_r($this->session->flashdata('logged_in'));exit;
		$last_login_time = now();
		$last_login_ip = $_SERVER['REMOTE_ADDR'];
		$updatelogin = array('login_time'=>$last_login_time,
								'login_ip'=>$last_login_ip);
		 $this->db->where('id',$user_id);
         $this->db->update('adminuser',$updatelogin);
          $aftrow = $this->db->affected_rows();
		//echo  '<pre>'; print_r($user_id);exit;
         if ($aftrow >0) {
         	return true;
         } else{
         	return false;
         }
	}

	


	
}

?>