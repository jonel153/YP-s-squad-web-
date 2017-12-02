<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Branch_model extends CI_Model {

	public function get_data($tbl, $where=null, $row=FALSE){

		if($where != null){
			$this->db->where($where);
		}

		$query = $this->db->get($tbl);
		if($row == TRUE){
			$result_data = $query->row();	
		}else{
			$result_data= $query->result();
		}
		return $result_data;
	}

	public function check_info($id){
		$query = $this->db->query('SELECT * FROM tbl_check, tblcompany, tblaccount, tblbranch, tblthirdparty, tblstatus WHERE tbl_check.account_id=tblaccount.ACCOUNT_ID AND tblaccount.company_id=tblcompany.company_id AND tbl_check.branch_id=tblbranch.BRANCH_ID AND tbl_check.party_id=tblthirdparty.party_id AND tbl_check.check_status=tblstatus.STATUS_ID AND tblstatus.STATUS_ID!=5 AND tbl_check.check_id=' . $id);

		$rows = $query->num_rows();
		if($rows > 0){
			$result['result'] = TRUE;
			$result['info'] = $query->row();
		}else{
			$result['result'] = FALSE;
		}
		
		return $result;
	}

	public function insert_data($tbl, $set){
		$this->db->trans_start();

		$this->db->set($set);
		$this->db->insert($tbl);

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return FALSE;
		}else{
			$this->db->trans_commit();
			return TRUE;
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

	public function check_id($tbl, $where, $row=FALSE){
		$query = $this->db->get_where($tbl, $where);

		$result = $query->num_rows();

		if($result > 0){
			if($row == TRUE){
				$data['info'] = $query->row();
			}
			$data['result'] = TRUE;
		}else{
			$data['result'] = FALSE;
		}
		return $data;
	}

	public function get_company(){
		$query = $this->db->query('SELECT * FROM tblcompany, tblcompanytype WHERE tblcompany.company_type=tblcompanytype.type_id');

		$result = $query->result();
		return $result;
	}

	public function get_count($tbl){
		$query = $this->db->get($tbl);
		$num = $query->num_rows();
		return $num;
	}

	public function get_check($id){
		$query = $this->db->query('SELECT * FROM tbl_check, tblcompany, tblaccount, tblbranch, tblthirdparty, tblstatus WHERE tbl_check.account_id=tblaccount.ACCOUNT_ID AND tblaccount.company_id=tblcompany.company_id AND tbl_check.branch_id=tblbranch.BRANCH_ID AND tbl_check.party_id=tblthirdparty.party_id AND tbl_check.check_status=tblstatus.STATUS_ID AND tblstatus.STATUS_ID!=5 AND tblbranch.branch_id=' .$id);
		$result = $query->result();
		return $result;
	}

	public function check_party($tbl, $where){
		$this->db->where($where);
		$query = $this->db->get($tbl);
		echo 'num:' . $num = $query->num_rows();
		if($num > 0){
			$info = $query->row();
			echo 'id'. $name = $info->party_id;
		}else{
			$name = 0;
		}
		return $name;
	}

	public function function_add_thirdparty()
	{
		$Company_ID = $_POST['company_name'];
		$Name = $_POST['thirdparty_name'];
		$Email = $_POST['thirdparty_email'];
		$ContactNumber = $_POST['thirdparty_contactnumber'];
		$Password = $_POST['thirdparty_password'];

		$insert_query = $this->db->query("INSERT INTO tblthirdparty (company_id,party_name,party_email,party_number,party_password) VALUES ('$Company_ID','$Name','$Email','$ContactNumber','$Password')");
	}

	public function mythird_party()
	{
		$select_query = $this->db->query("SELECT * FROM tblthirdparty, tblcompany WHERE tblthirdparty.company_id=tblcompany.company_id");
		return $select_query->result();
	}
}
