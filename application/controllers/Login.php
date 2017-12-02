<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
    	parent::__construct();
    	$this->load->model('login_model');
	}

	public function require_login(){
		$login = $this->session->userdata('uhack');

		if(isset($login)){
			if($login['session_type'] == "3"){
				redirect('third-party');
			}elseif($login['session_type'] == "2"){
				redirect('branch');
			}elseif($login['session_type'] == "1"){
				redirect('admin');
			}
		}else{
			//redirect('login');
		}
	}

	private function _encode($data){
		$id = $this->encrypt->encode($data);
		$encode_id= strtr(
		    $id,
		    array(
	            '+' => '.',
	            '=' => '-',
		        '/' => '~'
		    )
	    );
	   	return $encode_id;
	}

	private function _decode($data){
		$decode_id= strtr(
		    $data,
		    array(
	            '.' => '+',
	            '-' => '=',
		        '~' => '/'
		    )
	    );
	   	$id = $this->encrypt->decode($decode_id);

	   	return $id;
	}

	public function _clean_data($data){
		$clean = $this->security->xss_clean($this->db->escape_str($data));
		return $clean;
	}

	public function index(){
		$this->require_login();
		$this->load->view('admin/login_view');
	}

	public function login_process(){

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$email = $this->_clean_data($this->input->post('email'));
			$password = $this->_clean_data($this->input->post('password'));

			$login_info = array('company_email' => $email);
			$result = $this->login_model->check_credentials($email, $password);

			if($result['result'] == 0){
				$msg = '<div id="login_status" class="alert alert-danger">Invalid Username and Password!</div>';
				$this->session->set_flashdata('message', $msg);
				redirect('login');
			}elseif($result['result'] == 1){
				if($result['user_type'] == 1){
					$session_data = array(
						'company_id' => $result['info']->company_id,
						'company_type' => $result['info']->company_type,
						'company_name' => $result['info']->company_name,
						'company_number' => $result['info']->company_number,
						'company_email' => $result['info']->company_email,
						'company_password' => $result['info']->company_password,
						'company_status' => $result['info']->company_status,
						'session_type' => 1
					);
					
					
					$this->session->set_userdata('uhack', $session_data);
					if($result['info']->company_type == 3){
						redirect('admin');
					}elseif($result['info']->company_type == 1){
						redirect('corporation');
					}
				}elseif($result['user_type'] == 2){
					$session_data = array(
						'branch_id' => $result['info']->branch_id,
						'branch_number' => $result['info']->branch_number,
						'status' => $result['info']->status,
						'branch' => $result['info']->BRANCH,
						'branch_address' => $result['info']->branch_address,
						'branch_email' => $result['info']->branch_email,
						'branch_password' => $result['info']->branch_password,
						'session_type' => 2
					);					
					$this->session->set_userdata('uhack', $session_data);
					redirect('branch');
				}elseif($result['user_type'] == 3){
					$session_data = array(
						'party_id' => $result['info']->party_id,
						'company_id' => $result['info']->company_id,
						'party_name' => $result['info']->party_name,
						'party_password' => $result['info']->party_password,
						'party_email' => $result['info']->party_email,
						'party_number' => $result['info']->party_number,
						'party_status' => $result['info']->party_status,
						'date_created' => $result['info']->date_created,
						'session_type' => 3
					);					
					$this->session->set_userdata('uhack', $session_data);
					redirect('third-party');
				}
			}
		}else{
			redirect('login');
		}
	}

	public function change_password($id){
		$user_id = $this->_decode($id);
		$check_user_id = $this->login_model->check_change($user_id);

		if($check_user_id == TRUE){
			$this->require_login();
			$data['id'] = $id;
			$this->load->view('login/change_view' ,$data);
		}else{
			redirect('login');
		}
	}

	public function change_process(){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$password = $this->input->post('password');
			$cpassword = $this->input->post('cpassword');
			$user_id = $this->_decode($this->input->post('id'));
			if($password != '' && $cpassword != ''){
				if($password == $cpassword){
					$set = array('user_reset' => 0, 'password' => $this->_encode($password));
					$where = array('user_id' => $user_id);
					$result = $this->login_model->update_data('user_tbl', $set, $where);

					if($result == TRUE){
						$msg = '<div id="login_status" class="alert alert-success">Your password successfully changed. Please try to login.</div>';
						$this->session->set_flashdata('message', $msg);
						redirect('login');
					}
				}
			}
		}else{
			redirect('login');
		}
	}


	public function logout(){
		$this->session->unset_userdata('uhack');
		$this->session->sess_destroy();
		redirect('login');
	}
}
