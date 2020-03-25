<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class All_model extends CI_Model {
	public function getDataByCondition($table, $where){
		$this->db->where($where);
		return $this->db->get($table);
	}

	public function insertData($table, $data){
		$this->db->insert($table, $data);
		return true;
	}

	public function updateData($table, $where, $data){
		$this->db->where($where);
		$this->db->update($table, $data);
		return true;
	}

	public function deleteData($table, $condition){
		$this->db->where($condition);
		return $this->db->delete($table, $data);
	}

	public function getAllData($table){
		return $this->db->get($table);
	}

	public function getListItem(){
		$query = "SELECT i.*, s.* from item i left join satuan s on s.id_satuan = i.id_satuan";
		return $this->db->query($query);
	}

	public function getItemById($id){
		$query = "SELECT i.*, s.* from item i left join satuan s on s.id_satuan = i.id_satuan where id_item = " . $id;
		return $this->db->query($query);
	}
}
