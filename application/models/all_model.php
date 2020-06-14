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

	public function getDataByLimit($limit, $order, $table){
		$this->db->limit($limit);
		$this->db->order_by($order);
		return $this->db->get($table);
	}

	public function getDataByLimitPengeluaran($condition,$limit, $order, $table){
		$this->db->where($condition);
		$this->db->limit($limit);
		$this->db->order_by($order);
		return $this->db->get($table);
	}

	public function getPenjualanByHeaderPenjualan($id){
		$query = "SELECT p.*, i.nama, s.satuan from penjualan p left join item i on i.id_item = p.id_item left join satuan s on s.id_satuan = p.id_satuan where p.status_delete =0 and p.id_header_penjualan = " . $id;
		return $this->db->query($query);
	}

	public function getPenjualanByStatusHeaderPenjualan($id){
		$query = "SELECT p.*, i.nama, s.satuan from penjualan p left join item i on i.id_item = p.id_item left join satuan s on s.id_satuan = p.id_satuan where p.status = 0  and p.id_header_penjualan = " . $id;
		return $this->db->query($query);
	}

	public function getListDataByNama($table, $column, $name){
		$result = $this->db->like('LOWER('.$column.')', strtolower($name))
						   ->get($table);
		return $result;
	}

	public function getIsDesign($id){
		$query = "SELECT i.is_design from penjualan p left join item i on i.id_item = p.id_item left join satuan s on s.id_satuan = p.id_satuan where p.id_penjualan = " . $id;
		return $this->db->query($query);
	}

	public function getFirstAndLast($first, $last){
		$query = "SELECT c.* from customer c where c.first_name = '" . $first . "' and c.last_name = '" . $last ."'";
		return $this->db->query($query);
	}
}
