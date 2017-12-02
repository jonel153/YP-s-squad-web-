<?php
class Third_party extends CI_Controller{


	public function __construct() {
    	parent::__construct();
    	//$this->require_login();
    	$this->load->model('thirdparty_model', 'thirdparty');
	}

	public function require_login(){
		$login = $this->session->userdata('uhack');

		if(isset($login)){
			if($login['session_type'] == "3"){
				return $login;
			}elseif($login['session_type'] == "2"){
				redirect('branch');
			}elseif($login['session_type'] == "1"){
				if($login['company_type'] == '3'){
					redirect('admin');
				}elseif($login['company_type'] == '1'){
					redirect('corporation');
				}
			}
		}else{
			redirect('login');
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

	public function create_id($format, $tbl){
		$info = $this->require_login();
		$count = $this->admin->get_count($tbl) + 1;
		
		if($count > 0 && $count < 10){
			$id = $format . '00000' . $count;
		}elseif($count >= 10 && $count <= 99){
			$id = $format . '0000' . $count;
		}elseif($count >= 100 && $count <= 999){
			$id = $format . '000' . $count;
		}elseif($count >= 1000 && $count <= 9999){
			$id = $format . '00' . $count;
		}elseif($count >= 10000 && $count <= 99999){
			$id = $format . '0' . $count;
		}else{
			$id = $format . $count;
		}
		return $id;
	}

	public function index(){
		$info = $this->require_login();
		$data['name'] = $info['party_name'];
		$this->load->library('excel');
		$objPHPExcel = PHPExcel_IOFactory::load('assets/sample.xls');
		//$this->load->view('admin/sidebar_view');
		//$this->load->view('admin/member_view');

		$this->load->view('template/main');
		// $this->load->view('admin/navbar_view');
		$this->load->view('thirdparty/sidebar_view', $data);
		$this->load->view('thirdparty/home_view');
		$this->load->view('template/footer');
	}

	public function issue_check(){
		$info = $this->require_login();
		$data['name'] = $info['party_name'];
		$this->load->view('template/main');
		$party_id = $info['party_id'];
		// $this->load->view('admin/navbar_view');
		$data['company'] = $this->thirdparty->get_data('tblcompany', array('company_type' => 1, 'company_status' => 1));
		$data['check'] = $this->thirdparty->get_check($party_id);

		$this->load->view('thirdparty/sidebar_view', $data);
		$this->load->view('thirdparty/issuecheck_view', $data);
		$this->load->view('template/footer');
	}

	public function check_preparing(){
		$info = $this->require_login();
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$id = $this->_clean_data($this->_decode($this->input->post('id')));
			
			$update_data = array(
				'check_status' => 2
			);
			$where = array('check_id' => $id);
			$result = $this->admin->update_data('tbl_check', $update_data, $where);
			$check_id = $this->admin->check_info($id);
			if($check_id['result'] == TRUE){
				if($result == TRUE){
					$msg = '<div id="login_status" class="alert alert-success">Check is preparing.</div>';
					$this->session->set_flashdata('message', $msg);
					redirect('third-party/issue-check');
				}else{
					$msg = '<div id="login_status" class="alert alert-danger">Error please try again!</div>';
					$this->session->set_flashdata('message', $msg);
					redirect('third-party/issue-check');
				}
			}else{
				redirect('third-party');
			}
		}else{
			redirect('third-party');
		}
	}

	public function history(){
		$info = $this->require_login();
		$this->load->view('template/main');
		$data['name'] = $info['party_name'];
		// $this->load->view('admin/navbar_view');
		$this->load->view('thirdparty/sidebar_view', $data);
		$this->load->view('thirdparty/history_view');
		$this->load->view('template/footer');
	}

	public function logout(){
		$this->session->unset_userdata('uhack');
		$this->session->sess_destroy();
		redirect('login');
	}

}