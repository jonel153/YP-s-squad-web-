<?php
class Branch extends CI_Controller{


	public function __construct() {
    	parent::__construct();
    	//$this->require_login();
    	$this->load->model('branch_model', 'branch');
	}

	public function require_login(){
		$login = $this->session->userdata('uhack');
		if(isset($login)){
			if($login['session_type'] == "1"){
				redirect('admin');
			}elseif($login['session_type'] == "2"){
				return $login;
			}elseif($login['company_type'] == "3"){
				redirect('third-party');
			}
		}else{
			redirect('login');
		}
	}

	/*public function require_login(){
		$login = $this->session->userdata('uhack');
		if(isset($login)){
			$user_type = $login['user_type'];
			if($login['user_reset'] != 1){
				if($login['user_type'] == "1"){
					return $login;
				}elseif($login['user_type'] == "2"){
					redirect('coordinator');
				}
			}else{
				$this->session->unset_userdata('bavi_bulletin');
				$this->session->sess_destroy();
				redirect('login/change-password' . $this->_encode($login['user_id']));
			}
		}else{
			redirect('login');
		}
	}*/

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
		$count = $this->branch->get_count($tbl) + 1;
		
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

	public function sms($number, $message){
		/*$number = '09752942028';
		$message = 'sample message';*/
		$curl = curl_init();
		$verificationcode = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://post.chikka.com/smsapi/request",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_SSL_VERIFYPEER => false,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "message_type=SEND&mobile_number=" . $number . "&shortcode=29290546526&client_Id=53da47e7f756b3e903c504610d489db14a788bfc993a50a9dcbaf1527fd5351f&secret_key=2784fc0353ca069da79ca8499a09c65675584b439673f11b53aa103d9d44a4d7&message=" . $message . "&message_id=x12312312333". $verificationcode,
		  CURLOPT_HTTPHEADER => array(
		    "cache-control: no-cache",
		    "content-type: application/x-www-form-urlencoded",
		    "postman-token: 80ee916c-5ad7-6c5f-00f9-757227bebba3"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $response;
		}
	}

	public function index(){
		$info = $this->require_login();
		$data['name'] = $info['branch'];
		$this->load->library('excel');
		$objPHPExcel = PHPExcel_IOFactory::load('assets/sample.xls');
		//$this->load->view('admin/sidebar_view');
		//$this->load->view('admin/member_view');

		$this->load->view('template/main');
		// $this->load->view('admin/navbar_view');
		$this->load->view('branch/sidebar_view', $data);
		$this->load->view('branch/home_view');
		$this->load->view('template/footer');
	}

	public function issue_check(){
		$info = $this->require_login();
		$branch_id = $info['branch_id'];
		$data['name'] = $info['branch'];
		$this->load->view('template/main');
		// $this->load->view('admin/navbar_view');
		$data['company'] = $this->branch->get_data('tblcompany', array('company_type' => 1, 'company_status' => 1));
		$data['check'] = $this->branch->get_check($branch_id);

		$this->load->view('branch/sidebar_view', $data);
		$this->load->view('branch/issuecheck_view', $data);
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
			$result = $this->branch->update_data('tbl_check', $update_data, $where);
			if($result == TRUE){
				$msg = '<div id="login_status" class="alert alert-success">Check is preparing.</div>';
				$this->session->set_flashdata('message', $msg);
				redirect('branch/issue-check');
			}else{
				$msg = '<div id="login_status" class="alert alert-danger">Error please try again!</div>';
				$this->session->set_flashdata('message', $msg);
				redirect('branch/issue-check');
			}
		}else{
			redirect('branch');
		}
	}

	public function check_transfer(){
		$info = $this->require_login();
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$id = $this->_clean_data($this->_decode($this->input->post('id')));
			
			$update_data = array(
				'check_status' => 3
			);
			$where = array('check_id' => $id);
			$result = $this->branch->update_data('tbl_check', $update_data, $where);
			if($result == TRUE){
				$msg = '<div id="login_status" class="alert alert-success">Check is transferred.</div>';
				$this->session->set_flashdata('message', $msg);
				redirect('branch/issue-check');
			}else{
				$msg = '<div id="login_status" class="alert alert-danger">Error please try again!</div>';
				$this->session->set_flashdata('message', $msg);
				redirect('branch/issue-check');
			}
		}else{
			redirect('branch');
		}
	}

	public function check_receive(){
		$info = $this->require_login();
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$id = $this->_clean_data($this->_decode($this->input->post('id')));
			
			$update_data = array(
				'check_status' => 4
			);
			$where = array('check_id' => $id);
			$check_id = $this->branch->check_info($id);
			if($check_id['result'] == TRUE){
				$number = $check_id['info']->party_number;
				$name = $check_id['info']->party_name;
				$sms_message = 'Hi ' . $name . ' this to inform you that your check is available now. Thank you!';
				$this->sms($number, $sms_message);
				$result = $this->branch->update_data('tbl_check', $update_data, $where);
				if($result == TRUE){
					$msg = '<div id="login_status" class="alert alert-success">Check is received.</div>';
					$this->session->set_flashdata('message', $msg);
					redirect('branch/issue-check');
				}else{
					$msg = '<div id="login_status" class="alert alert-danger">Error please try again!</div>';
					$this->session->set_flashdata('message', $msg);
					redirect('branch/issue-check');
				}
			}else{

			}
		}else{
			redirect('branch');
		}
	}

	public function check_claim(){
		$info = $this->require_login();
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$id = $this->_clean_data($this->_decode($this->input->post('id')));
			
			$update_data = array(
				'check_status' => 5
			);
			$where = array('check_id' => $id);
			$result = $this->branch->update_data('tbl_check', $update_data, $where);
			if($result == TRUE){
				$msg = '<div id="login_status" class="alert alert-success">Check is claimed.</div>';
				$this->session->set_flashdata('message', $msg);
				redirect('branch/issue-check');
			}else{
				$msg = '<div id="login_status" class="alert alert-danger">Error please try again!</div>';
				$this->session->set_flashdata('message', $msg);
				redirect('branch/issue-check');
			}
		}else{
			redirect('branch');
		}
	}	

	/*public function company(){
		$info = $this->require_login();
		$this->load->view('template/main');
		// $this->load->view('admin/navbar_view');
		$data['type'] = $this->branch->get_data('tblcompanytype');
		$data['company'] = $this->branch->get_company();
		$this->load->view('branch/sidebar_view');
		$this->load->view('branch/thirdparty_view', $data);
		$this->load->view('template/footer');
	}*/

	/*public function add_corporation(){
		$info = $this->require_login();
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$corporation = $this->input->post('corporation');
			$address = $this->_clean_data($this->input->post('address'));
			$pnum = $this->_clean_data($this->input->post('pnum'));
			$email = $this->_clean_data($this->input->post('email'));
			$type = $this->_decode($this->input->post('type'));

			$insert_data = array(
				'company_name' => $corporation,
				'company_type' => $type,
				'company_number' => $pnum,
				'company_email' => $email,
				'company_password' => 'jonel',
				'company_status' => 1
			);

			$result = $this->branch->insert_data('tblcompany', $insert_data);
			if($result == TRUE){
				$msg = '<div id="login_status" class="alert alert-success">Item successfully added.</div>';
				$this->session->set_flashdata('message', $msg);
				redirect('branch/company');
			}else{
				$msg = '<div id="login_status" class="alert alert-danger">Error please try again!</div>';
				$this->session->set_flashdata('message', $msg);
				redirect('branch/company');
			}
		}else{
			redirect('branch');
		}
	}*/

	public function history(){
		$info = $this->require_login();
		$data['name'] = $info['branch'];
		$this->load->view('template/main');
		// $this->load->view('admin/navbar_view');
		$this->load->view('branch/sidebar_view', $data);
		$this->load->view('branch/history_view');
		$this->load->view('template/footer');
	}

	public function logout(){
		$this->session->unset_userdata('uhack');
		$this->session->sess_destroy();
		redirect('login');
	}

	/*public function get_account($data){
		$info = $this->require_login();
		$company = $this->_clean_data($this->_decode($data));
		$where = array('company_id' => $company);
		$account = $this->branch->get_data('tblaccount', $where);
		echo '<option value="">Select...</option>';
		foreach($account as $row){
			$id = $row->ACCOUNT_ID;
			echo '<option value="' . $id . '">' . $row->ACCOUNT_NUMBER . '</option>';
		}
	}

	public function function_add_thirdparty(){
		$info = $this->require_login();
		$this->branch->function_add_thirdparty();
		redirect("branch/third_party");
	}

	public function third_party(){
		$info = $this->require_login();
		$this->load->view('template/main');
		$this->load->view('branch/sidebar_view');

      	$mydata['thirdparty'] = $this->branch->mythird_party();
		$mydata['company'] = $this->branch->get_company();

		$this->load->view('branch/mythirdparty_view', $mydata);
		$this->load->view('template/footer');
	}

	public function branch(){
		$info = $this->require_login();
		$this->load->view('template/main');
		// $this->load->view('branch/navbar_view');
		$data['branch'] = $this->branch->get_data('tblbranch');
		$this->load->view('branch/sidebar_view');
		$this->load->view('branch/branch_view', $data);
		$this->load->view('template/footer');
	}

	public function add_branch(){
		$info = $this->require_login();
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$branch = $this->input->post('branch');
			$address = $this->_clean_data($this->input->post('address'));
			$branch_password = $this->_clean_data($this->input->post('password'));
			$branch_email = $this->_clean_data($this->input->post('email'));
			$branch_no = $this->create_id('BR-', 'tblbranch');

			$insert_data = array(
				'branch_number' => $branch_no,
				'branch' => $branch,
				'branch_address' => $address,
				'branch_password' => $branch_password,
				'branch_email' => $branch_email,
				'branch_number' => $branch_no
			);

			$result = $this->branch->insert_data('tblbranch', $insert_data);
			if($result == TRUE){
				$msg = '<div id="login_status" class="alert alert-success">Branch successfully added.</div>';
				$this->session->set_flashdata('message', $msg);
				redirect('branch/branch');
			}else{
				$msg = '<div id="login_status" class="alert alert-danger">Error please try again!</div>';
				$this->session->set_flashdata('message', $msg);
				redirect('branch/branch');
			}
		}else{
			redirect('branch');
		}
	}*/
}