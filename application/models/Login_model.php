<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

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

	public function check_credentials($email, $password){
		$query = $this->db->get_where('tblcompany', array('company_email' => $email, 'company_password' => $password));
		$result = $query->num_rows();

		if($result > 0){
			$info = $query->row();
			$result_data['result'] = 1;
			$result_data['user_type'] = 1;
			$result_data['info'] = $info;
		}else{

			$query_branch = $this->db->get_where('tblbranch', array('branch_email' => $email, 'branch_password' => $password));
			
			$result_branch = $query_branch->num_rows();
			if($result_branch > 0){
				$result_data['result'] = 1;
				$result_data['user_type'] = 2;
				$result_data['info'] = $query_branch->row();
			}else{
				$query_third = $this->db->get_where('tblthirdparty', array('party_email' => $email, 'party_password' => $password));
				$result_third = $query_third->num_rows();
				if($result_third > 0){
					$result_data['result'] = 1;
					$result_data['user_type'] = 3;
					$result_data['info'] = $query_third->row();	
				}else{
					$result_data['result'] = 0;	
				}
			}
			
		}

		return $result_data;
	}

	public function check_change($id){
		$this->db->where(array('user_id' => $id, 'user_reset' => 1));
		$query = $this->db->get('user_tbl');
		$result = $query->num_rows();

		if($result > 0){
			return TRUE;
		}else{
			return FALSE;
		}

	}
	public function update_data($tbl, $set, $where){
		$this->db->trans_start();

		$this->db->set($set);
		$this->db->where($where);
		$this->db->update($tbl);

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return FALSE;
		}else{
			$this->db->trans_commit();
			return TRUE;
		}	
	}
}
