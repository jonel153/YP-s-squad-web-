<?php
class Admin extends CI_Controller{


	public function __construct() {
    	parent::__construct();
    	//$this->require_login();
    	$this->load->model('admin_model', 'admin');
	}

	public function require_login(){
		$login = $this->session->userdata('uhack');

		if(isset($login)){
			if($login['company_type'] == "3"){
				return $login;
			}elseif($login['company_type'] == "2"){
				redirect('company');
			}elseif($login['company_type'] == "1"){
				redirect('corporation');
			}
		}else{
			redirect('login');
		}
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
		$data['name'] = $info['company_name'];
		$this->load->library('excel');
		$objPHPExcel = PHPExcel_IOFactory::load('assets/sample.xls');
		//$this->load->view('admin/sidebar_view');
		//$this->load->view('admin/member_view');

		$this->load->view('template/main');
		// $this->load->view('admin/navbar_view');
		$this->load->view('admin/sidebar_view', $data);
		$this->load->view('admin/home_view');
		$this->load->view('template/footer');
	}

	public function issue_check(){
		$info = $this->require_login();
		$data['name'] = $info['company_name'];
		$this->load->view('template/main');
		// $this->load->view('admin/navbar_view');
		$data['company'] = $this->admin->get_data('tblcompany', array('company_type' => 1, 'company_status' => 1));
		$data['check'] = $this->admin->get_check();

		$this->load->view('admin/sidebar_view', $data);
		$this->load->view('admin/issuecheck_view', $data);
		$this->load->view('template/footer');
	}

	public function check_preparing(){
		$info = $this->require_login();
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$id = $this->_clean_data($this->_decode($this->input->post('id')));
			
			$update_data = array(
				'check_status' => 2
			);

			$check_id = $this->admin->check_info($id);
			if($check_id['result'] == TRUE){
				$where = array('check_id' => $id);
				$result = $this->admin->update_data('tbl_check', $update_data, $where);
				if($result == TRUE){

					if($this->input->post('sms') == 'yes'){
						$number = $check_id['info']->party_number;
						$name = $check_id['info']->party_name;
						$sms_message = 'Hi ' . $name . ' this message is to inform you that your check is being prepared. Have a nice day.';
						$this->sms($number, $sms_message);
					}
					$msg = '<div id="login_status" class="alert alert-success">Check is preparing.</div>';
					$this->session->set_flashdata('message', $msg);
					redirect('admin/issue-check');
				}else{
					$msg = '<div id="login_status" class="alert alert-danger">Error please try again!</div>';
					$this->session->set_flashdata('message', $msg);
					redirect('admin/issue-check');
				}
			}else{
				$msg = '<div id="login_status" class="alert alert-danger">Error please try again!</div>';
				$this->session->set_flashdata('message', $msg);
				redirect('admin/issue-check');
			}
		}else{
			redirect('admin');
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
			$check_id = $this->admin->check_info($id);
			if($check_id['result'] == TRUE){
				$result = $this->admin->update_data('tbl_check', $update_data, $where);
				if($result == TRUE){

					if($this->input->post('sms') == 'yes'){
						$number = $check_id['info']->party_number;
						$name = $check_id['info']->party_name;
						$sms_message = 'Hi ' . $name . ' this message is to inform you that your check is being transferred. Have a nice day.';
						$this->sms($number, $sms_message);
					}

					$msg = '<div id="login_status" class="alert alert-success">Check is transferred.</div>';
					$this->session->set_flashdata('message', $msg);
					redirect('admin/issue-check');
				}else{
					$msg = '<div id="login_status" class="alert alert-danger">Error please try again!</div>';
					$this->session->set_flashdata('message', $msg);
					redirect('admin/issue-check');
				}
			}else{
				$msg = '<div id="login_status" class="alert alert-danger">Error please try again!</div>';
				$this->session->set_flashdata('message', $msg);
				redirect('admin/issue-check');
			}
		}else{
			redirect('admin');
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
			$check_id = $this->admin->check_info($id);
			if($check_id['result'] == TRUE){
				$result = $this->admin->update_data('tbl_check', $update_data, $where);
				if($result == TRUE){
					$number = $check_id['info']->party_number;
					$name = $check_id['info']->party_name;
					$sms_message = 'Hi ' . $name . ' this message is to inform you that your check is ready for pick-up. Have a nice day.';
					$this->sms($number, $sms_message);
					$msg = '<div id="login_status" class="alert alert-success">Check is received.</div>';
					$this->session->set_flashdata('message', $msg);
					redirect('admin/issue-check');
				}else{
					$msg = '<div id="login_status" class="alert alert-danger">Error please try again!</div>';
					$this->session->set_flashdata('message', $msg);
					redirect('admin/issue-check');
				}
			}
		}else{
			redirect('admin');
		}
	}

	public function check_claim(){
		$info = $this->require_login();
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$id = $this->_clean_data($this->_decode($this->input->post('id')));
			
			$update_data = array(
				'check_status' => 5
			);
			$check_id = $this->admin->check_info($id);
			if($check_id['result'] == TRUE){

				$where = array('check_id' => $id);
				$result = $this->admin->update_data('tbl_check', $update_data, $where);
				if($result == TRUE){

					if($this->input->post('sms') == 'yes'){
						$number = $check_id['info']->party_number;
						$name = $check_id['info']->party_name;
						$sms_message = 'Hi ' . $name . ' this message is to inform you that your check has been claimed. Have a nice day.';
						$this->sms($number, $sms_message);
					}

					$msg = '<div id="login_status" class="alert alert-success">Check is claimed.</div>';
					$this->session->set_flashdata('message', $msg);
					redirect('admin/issue-check');
				}else{
					$msg = '<div id="login_status" class="alert alert-danger">Error please try again!</div>';
					$this->session->set_flashdata('message', $msg);
					redirect('admin/issue-check');
				}
			}else{
				$msg = '<div id="login_status" class="alert alert-danger">Error please try again!</div>';
				$this->session->set_flashdata('message', $msg);
				redirect('admin/issue-check');
			}
		}else{
			redirect('admin');
		}
	}	

	public function upload_check(){
		$info = $this->require_login();
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$this->load->library('excel');
			$temp_code = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);

			$config['upload_path']   = './assets/tmp'; 
	        $config['allowed_types'] = 'xls|xlsx';
	        $config['file_name'] = 'tmp_' . $temp_code;

	        $this->load->library('upload', $config);
			
	        if (! $this->upload->do_upload('file')) {
	            $error = array('error' => $this->upload->display_errors()); 
	            echo $this->upload->display_errors();
	        }else{ 
	            $data = array('upload_data' => $this->upload->data());
	        } 

	        $file_name = $data['upload_data']['file_name'];

			$file = './assets/tmp/' . $file_name;
			$data['file'] = $file_name;
			$objPHPExcel = PHPExcel_IOFactory::load($file);
			PHPExcel_Style_NumberFormat::toFormattedString(39984,PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
			//get only the Cell Collection
			$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
			
			$data['excel_data'] = '';
			$data['excel_data'] .= '
					<thead>
						<tr class="bg-grey-dark text-light">
							<th>Account #</th>
							<th>CV/Ref no.</th>
							<th>Payee Name</th>
							<th>Amount</th>
							<th>Particulars</th>
							<th>Check Date</th>
							<th>WTaxAmt</th>
							<th>ATC</th>
							<th>ATDescription</th>
							<th>TaxableAmt</th>
							<th>BeneTIN</th>
							<th>Notify Name</th>
							<th>Notify Address1</th>
							<th>Notify Address2</th>
							<th>INV NO.</th>
							<th>INV DATE</th>
							<th>INV AMT.</th>
							<th>WTax.</th>
							<th>NET AMT.</th>
						</tr>
					</thead>
					<tbody>';
			
			$high = $objPHPExcel->getActiveSheet()->getHighestRow();
			$data['account'] = $this->input->post('account');
			$account_name = $this->admin->get_data('tblaccount', array('account_id' => $data['account']), TRUE);
			for($a = 2; $a <= $high; $a++){
				$cv = $objPHPExcel->getActiveSheet()->getCell('A' . $a)->getValue();
				if($cv != ""){					
					$payee = $objPHPExcel->getActiveSheet()->getCell('B' . $a)->getValue();
					$amt = $objPHPExcel->getActiveSheet()->getCell('C' . $a)->getValue();
					$particulars = $objPHPExcel->getActiveSheet()->getCell('D' . $a)->getValue();
					$check_date =  PHPExcel_Style_NumberFormat::toFormattedString($objPHPExcel->getActiveSheet()->getCell('E' . $a)->getValue(),'YYYY-MM-DD' );
					$WTaxAmt = $objPHPExcel->getActiveSheet()->getCell('F' . $a)->getValue();
					$ATC = $objPHPExcel->getActiveSheet()->getCell('G' . $a)->getCalculatedValue();
					$ATDescription = $objPHPExcel->getActiveSheet()->getCell('H' . $a)->getValue();
					$TaxableAmt = $objPHPExcel->getActiveSheet()->getCell('I' . $a)->getCalculatedValue();
					$BeneTIN = $objPHPExcel->getActiveSheet()->getCell('J' . $a)->getCalculatedValue();
					$name = $objPHPExcel->getActiveSheet()->getCell('K' . $a)->getValue();
					$add1 = $objPHPExcel->getActiveSheet()->getCell('L' . $a)->getValue();
					$add2 = $objPHPExcel->getActiveSheet()->getCell('M' . $a)->getValue();
					$inv_no = $objPHPExcel->getActiveSheet()->getCell('N' . $a)->getValue();
					$inv_date = PHPExcel_Style_NumberFormat::toFormattedString($objPHPExcel->getActiveSheet()->getCell('E' . $a)->getValue(),'YYYY-MM-DD' );
					$inv_amt = $objPHPExcel->getActiveSheet()->getCell('P' . $a)->getValue();
					$wtax = $objPHPExcel->getActiveSheet()->getCell('Q' . $a)->getValue();
					$net_amount = $objPHPExcel->getActiveSheet()->getCell('R' . $a)->getValue();

					$data['excel_data'] .=
					'<tr>
						<td>' . $account_name->ACCOUNT_NUMBER . '</td>
						<td>' . $cv . '</td>
						<td>' . $payee . '</td>
						<td>' . $amt  . '</td>
						<td>' . $particulars . '</td>
						<td>' . $check_date . ' </td>
						<td>' . $WTaxAmt . '</td>
						<td>' . $ATC . '</td>
						<td>' . $ATDescription . '</td>
						<td>' . $TaxableAmt . '</td>
						<td>' . $BeneTIN . '</td>
						<td>' . $name . '</td>
						<td>' . $add1 . '</td>
						<td>' . $add2 . '</td>
						<td>' . $inv_no . '</td>
						<td>' . $inv_date . '</td>
						<td>' . $inv_amt . '</td>
						<td>' . $wtax . '</td>
						<td>' . $net_amount . '</td>
					</tr>';
				}else{
					$a = $high+1;
				}
			}
			$data['name'] = $info['company_name'];
			$data['company'] = $this->input->post('company');
			$data['account'] = $this->input->post('account');
			$data['excel_data'] .= '</tbody>'; 
			$this->load->view('template/main');
			$this->load->view('admin/sidebar_view', $data);
			$this->load->view('admin/review_check_view', $data);
			$this->load->view('template/footer');
		}else{
			redirect('admin');
		}
	}

	public function confirm(){
		$info = $this->require_login();
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$file = $this->input->post('file_path');
			echo $company = $this->_decode($this->input->post('company'));
			echo $account = $this->input->post('account');
			$this->confirm_process($file, $company, $account);
			/*if(is_file($file)){
				echo 'wew';
			}else{
				echo 'not found';
			}*/
		}else{

		}
	}

	public function confirm_process($path, $company, $account){
			$info = $this->require_login();
			$this->load->library('excel');
			echo $acc = $account;
			
			/*$file = './assets/tmp/' . $file_name;*/
			$file = './assets/tmp/' . $path;
			$objPHPExcel = PHPExcel_IOFactory::load($file);
			PHPExcel_Style_NumberFormat::toFormattedString(39984,PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
			//get only the Cell Collection
			$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
			$data['excel_data'] = '';
			$data['excel_data'] .= '
					<thead>
						<tr class="bg-grey-dark text-light">
							<th>Account #</th>
							<th>CV/Ref no.</th>
							<th>Payee Name</th>
							<th>Amount</th>
							<th>Particulars</th>
							<th>Check Date</th>
							<th>WTaxAmt</th>
							<th>ATC</th>
							<th>ATDescription</th>
							<th>TaxableAmt</th>
							<th>BeneTIN</th>
							<th>Notify Name</th>
							<th>Notify Address1</th>
							<th>Notify Address2</th>
							<th>INV NO.</th>
							<th>INV DATE</th>
							<th>INV AMT.</th>
							<th>WTax.</th>
							<th>NET AMT.</th>
						</tr>
					</thead>
					<tbody>';
			
			$high = $objPHPExcel->getActiveSheet()->getHighestRow();
			
			for($a = 2; $a <= $high; $a++){
				$cv = $objPHPExcel->getActiveSheet()->getCell('A' . $a)->getValue();
				if($cv != ""){					
					$payee = $objPHPExcel->getActiveSheet()->getCell('B' . $a)->getValue();
					$amt = $objPHPExcel->getActiveSheet()->getCell('C' . $a)->getValue();
					$particulars = $objPHPExcel->getActiveSheet()->getCell('D' . $a)->getValue();
					$check_date = PHPExcel_Style_NumberFormat::toFormattedString($objPHPExcel->getActiveSheet()->getCell('E' . $a)->getValue(),'YYYY-MM-DD' );
					$WTaxAmt = $objPHPExcel->getActiveSheet()->getCell('F' . $a)->getValue();
					$ATC = $objPHPExcel->getActiveSheet()->getCell('G' . $a)->getCalculatedValue();
					$ATDescription = $objPHPExcel->getActiveSheet()->getCell('H' . $a)->getValue();
					$TaxableAmt = $objPHPExcel->getActiveSheet()->getCell('I' . $a)->getCalculatedValue();
					$BeneTIN = $objPHPExcel->getActiveSheet()->getCell('J' . $a)->getCalculatedValue();
					$name = $objPHPExcel->getActiveSheet()->getCell('K' . $a)->getValue();
					$check_name = $this->admin->check_party('tblthirdparty', array('party_name' => $payee));
					$add1 = $objPHPExcel->getActiveSheet()->getCell('L' . $a)->getValue();
					$add2 = $objPHPExcel->getActiveSheet()->getCell('M' . $a)->getValue();
					$inv_no = $objPHPExcel->getActiveSheet()->getCell('N' . $a)->getValue();
					$inv_date = PHPExcel_Style_NumberFormat::toFormattedString($objPHPExcel->getActiveSheet()->getCell('O' . $a)->getValue(),'YYYY-MM-DD' );
					$inv_amt = $objPHPExcel->getActiveSheet()->getCell('P' . $a)->getValue();
					$wtax = $objPHPExcel->getActiveSheet()->getCell('Q' . $a)->getValue();
					$net_amount = $objPHPExcel->getActiveSheet()->getCell('R' . $a)->getValue();
					$branch = $objPHPExcel->getActiveSheet()->getCell('S' . $a)->getValue();

					$check_branch = $this->admin->check_id('tblbranch', array('branch' => $branch), TRUE);
					if($check_branch['result'] == TRUE){
						$branch_id = $check_branch['info']->branch_id;
					}else{
						$msg = '<div id="login_status" class="alert alert-danger">Error branch name not exist!</div>';
						$this->session->set_flashdata('message', $msg);
						redirect('admin/issue-check');
					}

					$set = array(
						'account_id' => $acc,
						'check_no' => $this->create_id('', 'tbl_check'),
						'check_status' => 1,
						'cv' => $cv,
						'branch_id' => $branch_id,
						'payee_name' => $payee,
						'party_id' => $check_name,
						'check_amt' => $amt,
						'particulars' => $particulars,
						'check_date' => date('Y-m-d', strtotime($check_date)),
						'wtaxamt' => $WTaxAmt,
						'atc' => $ATC,
						'atdescription' => $ATDescription,
						'taxable_amt' => $TaxableAmt,
						'bene_tin' => $BeneTIN,
						'add1' => $add1,
						'add2' => $add2,
						'inv_no' => $inv_no,
						'inv_date' => $inv_date,
						'inv_amt' => $inv_amt,
						'wtax' => $wtax,
						'net_amount' => $net_amount,
					);
					$insert_data = $this->admin->insert_data('tbl_check',$set);

					if($insert_data == TRUE){
						$msg = '<div id="login_status" class="alert alert-success">Check successfully added.</div>';
						$this->session->set_flashdata('message', $msg);
						redirect('admin/issue-check');
					}else{
						$msg = '<div id="login_status" class="alert alert-danger">Error please try again!</div>';
						$this->session->set_flashdata('message', $msg);
						redirect('admin/issue-check');
					}
				}else{
					$a = $high+1;
				}
			}
	}

	public function company(){
		$info = $this->require_login();
		$data['name'] = $info['company_name'];
		$this->load->view('template/main');
		// $this->load->view('admin/navbar_view');
		$data['type'] = $this->admin->get_data('tblcompanytype');
		$data['company'] = $this->admin->get_company();
		$this->load->view('admin/sidebar_view', $data);
		$this->load->view('admin/thirdparty_view', $data);
		$this->load->view('template/footer');
	}

	public function add_corporation(){
		$info = $this->require_login();
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$corporation = $this->input->post('corporation');
			$address = $this->_clean_data($this->input->post('address'));
			$pnum = $this->_clean_data($this->input->post('pnum'));
			$email = $this->_clean_data($this->input->post('email'));
			/*$type = $this->_decode($this->input->post('type'));*/
			$password = $this->input->post('password');

			$insert_data = array(
				'company_name' => $corporation,
				'company_type' => 1,
				'company_number' => $pnum,
				'company_email' => $email,
				'company_password' => $password,
				'company_status' => 1
			);
			$msg = 'Hi ' . $corporation . ' your account has been created, your email: '. $email . ' password: '. $password . ' Thank you!';
			$this->sms($pnum, $msg);
			$result = $this->admin->insert_data('tblcompany', $insert_data);
			if($result == TRUE){
				$msg = '<div id="login_status" class="alert alert-success">Corporation successfully added.</div>';
				$this->session->set_flashdata('message', $msg);
				redirect('admin/company');
			}else{
				$msg = '<div id="login_status" class="alert alert-danger">Error please try again!</div>';
				$this->session->set_flashdata('message', $msg);
				redirect('admin/company');
			}
		}else{
			redirect('admin');
		}
	}

	public function history(){
		$info = $this->require_login();
		$this->load->view('template/main');
		$data['name'] = $info['company_name'];
		// $this->load->view('admin/navbar_view');
		$this->load->view('admin/sidebar_view', $data);
		$this->load->view('admin/history_view');
		$this->load->view('template/footer');
	}

	public function logout(){
		$this->session->unset_userdata('uhack');
		$this->session->sess_destroy();
		redirect('login');
	}

	public function get_account($data){
		$info = $this->require_login();
		$company = $this->_clean_data($this->_decode($data));
		$where = array('company_id' => $company);
		$account = $this->admin->get_data('tblaccount', $where);
		echo '<option value="">Select...</option>';
		foreach($account as $row){
			$id = $row->ACCOUNT_ID;
			echo '<option value="' . $id . '">' . $row->ACCOUNT_NUMBER . '</option>';
		}
	}

	public function function_add_thirdparty(){
		$info = $this->require_login();
		$this->admin->function_add_thirdparty();
		redirect("admin/third_party");
	}

	public function third_party(){
		$info = $this->require_login();
		$data['name'] = $info['company_name'];
		$this->load->view('template/main');
		$this->load->view('admin/sidebar_view', $data);

      	$mydata['thirdparty'] = $this->admin->mythird_party();
		$mydata['company'] = $this->admin->get_company();

		$this->load->view('admin/mythirdparty_view', $mydata);
		$this->load->view('template/footer');
	}

	public function account(){
		$info = $this->require_login();
		$data['name'] = $info['company_name'];
		$this->load->view('template/main');
		$this->load->view('admin/sidebar_view', $data);

 
		$mydata['company'] = $this->admin->get_company();
		$mydata['account'] = $this->admin->get_account();


		$this->load->view('admin/account_view', $mydata);
		$this->load->view('template/footer');
	}

	public function add_account(){
		$info = $this->require_login();
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$company_name = $this->input->post('company_name');
			$account = $this->input->post('account');

			$insert_data = array(
				'ACCOUNT_NUMBER' => $account,
				'company_id' => $company_name
			);

			$result = $this->admin->insert_data('tblaccount', $insert_data);
			if($result == TRUE){
				$msg = '<div id="login_status" class="alert alert-success">Account successfully added.</div>';
				$this->session->set_flashdata('message', $msg);
				redirect('admin/account');
			}else{
				$msg = '<div id="login_status" class="alert alert-danger">Error please try again!</div>';
				$this->session->set_flashdata('message', $msg);
				redirect('admin/account');
			}
		}else{
			redirect('admin');
		}
	}

	public function branch(){
		$info = $this->require_login();
		$this->load->view('template/main');
		// $this->load->view('admin/navbar_view');
		$data['name'] = $info['company_name'];
		$data['branch'] = $this->admin->get_data('tblbranch');
		$this->load->view('admin/sidebar_view', $data);
		$this->load->view('admin/branch_view', $data);
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

			$result = $this->admin->insert_data('tblbranch', $insert_data);
			if($result == TRUE){
				$msg = '<div id="login_status" class="alert alert-success">Branch successfully added.</div>';
				$this->session->set_flashdata('message', $msg);
				redirect('admin/branch');
			}else{
				$msg = '<div id="login_status" class="alert alert-danger">Error please try again!</div>';
				$this->session->set_flashdata('message', $msg);
				redirect('admin/branch');
			}
		}else{
			redirect('admin');
		}
	}
}