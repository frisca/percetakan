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

	public function getReportPenjualan($from, $to){
		$query = "SELECT p.*, c.*, p.status as status_invoice from header_penjualan p left join customer c on c.id_customer = p.id_customer 
		where p.status_delete = 0 and (p.tgl_penjualan between '".$from."' and '".$to."') group by p.id_header_penjualan order by p.tgl_penjualan desc";
		return $this->db->query($query);
	}

	public function getReportPengeluaranByCondition($from_date, $to, $status){
		$query = "SELECT p.* from header_pengeluaran p where p.status_delete = 0 " . $status . " and p.tgl_pengeluaran between '".$from_date."' and '".$to."' 
		order by p.tgl_pengeluaran desc";
		return $this->db->query($query);
	}

	public function getReportPenjualanByCondition($froms, $customer,  $no_invoice, $status_invoice, $status_pembayaran){
		// var_dump($status_invoice);exit();
		$query = "SELECT p.*, p.status as status_invoice, c.* from header_penjualan p left join customer c on c.id_customer = p.id_customer 
				where p.status_delete = 0 and (".$customer." and p.nomor_penjualan like '%".$no_invoice."'
				and ".$status_invoice." and ".$status_pembayaran.") " . $froms . " group by p.id_header_penjualan order by p.tgl_penjualan desc";
				// var_dump($query);exit();
		return $this->db->query($query);
	}

	public function getReportPenjualanByDate($from_date, $to, $customer,  $no_invoice, $status_invoice, $status_pembayaran){
		// var_dump($from_date);exit();
		$query = "SELECT p.*, p.status as status_invoice, c.* from header_penjualan p left join customer c on c.id_customer = p.id_customer 
				where p.status_delete = 0 and p.tgl_penjualan between '".$from_date."' and '".$to."' group by p.id_header_penjualan order by p.tgl_penjualan desc";
		return $this->db->query($query);
	}

	public function getSearchNama($nama){
		// $this->db->like('nama', $nama , 'both');
        // $this->db->order_by('nama_project', 'ASC');
		// return $this->db->get($table);
		$query = "SELECT c.* from customer c where first_name = '".$nama."' or last_name = '".$nama."' 
		order by first_name or last_name asc";
		return $this->db->query($query);
	}

	public function getReportPengeluaranDate($from, $to){
		$query = "SELECT p.* from header_pengeluaran p where p.status_delete = 0 and p.tgl_pengeluaran between '".$from."' and '".$to."'
		order by p.tgl_pengeluaran desc";
		// var_dump($query);exit();
		return $this->db->query($query);
	}

	public function getReportPenjualanByWithoutDate($customer,  $no_invoice, $status_invoice, $status_pembayaran){
		// var_dump($status_invoice);exit();
		$query = "SELECT p.*, p.status as status_invoice, c.* from header_penjualan p left join customer c on c.id_customer = p.id_customer 
				where p.status_delete = 0 and (".$customer." and p.nomor_penjualan like '%".$no_invoice."'
				and ".$status_invoice." and ".$status_pembayaran.") group by p.id_header_penjualan order by p.tgl_penjualan desc ";
				// var_dump($query);exit();
		return $this->db->query($query);
	}

	public function getReportPenjualanDetail($id){
		// var_dump($status_invoice);exit();
		$query = "SELECT p.*, sum(pj.qty) as qty_item, sum(pj.total_harga) as total_harga, pj.harga_satuan, s.satuan as unit, i.nama as item, pj.keterangan, p.status as status_invoice, c.* from header_penjualan p left join customer c on c.id_customer = p.id_customer 
				 left join penjualan pj on pj.id_header_penjualan = p.id_header_penjualan
				 left join item i on i.id_item = pj.id_item
				 left join satuan s on s.id_satuan = i.id_satuan
				 where pj.id_header_penjualan = ".$id." and pj.status_delete = 0 group by pj.id_item order by p.tgl_penjualan desc";
				// var_dump($query);exit();
		return $this->db->query($query);
	}

	public function getReportPengeluaranWithoutDate($status){
		$query = "SELECT p.* from header_pengeluaran p where p.status_delete = 0 ".$status."
		order by p.tgl_pengeluaran desc";
		// var_dump($query);exit();
		return $this->db->query($query);
	}

	public function getReportPengeluaranDetail($id){
		$query = "SELECT p.*, sum(pg.price) as total_harga, pg.item, pg.keterangan from header_pengeluaran p 
				 left join pengeluaran pg on pg.id_header_pengeluaran = p.id_header_pengeluaran 
				 where p.id_header_pengeluaran = ".$id." and pg.status_delete = 0 group by pg.item
		         order by p.tgl_pengeluaran desc";
		return $this->db->query($query);
	}

	public function getHeaderPenjualan(){
		$query = "select hp.*, hp.status as status_invoice, c.* from header_penjualan hp 
				left join customer c on c.id_customer = hp.id_customer where hp.status_delete = 0";
		return $this->db->query($query);
	}

	public function getHeaderPenjualanByOperator($location){
		$query = "select hp.*, hp.status as status_invoice, c.* from header_penjualan hp 
				left join customer c on c.id_customer = hp.id_customer left join user u on u.id_user = hp.createdBy
				where hp.status_delete = 0 and u.id_location = " . $location;
		return $this->db->query($query);
	}

	public function getHeaderPengeluaran(){
		$query = "select hp.* from header_pengeluaran hp where hp.status_delete = 0";
		return $this->db->query($query);
	}

	public function getHeaderPengeluaranByOperator($location){
		$query = "select hp.*, u.* from header_pengeluaran hp left join user u on u.id_user = hp.created_by 
				 where hp.status_delete = 0 and u.id_location = " . $location;
		return $this->db->query($query);
	}

	public function getHeaderPenjualanByLimit($nmr){
		$query = "select p.* from header_penjualan p where p.status = 1 and  p.status_delete = 0 and
		p.nomor_penjualan like '%" . $nmr . "%' order by p.id_header_penjualan desc limit 1";
		// var_dump($query);exit();
		return $this->db->query($query);
	}

	public function getHeaderPenjualanByLimitDesc($nmr){
		$query = "select p.* from header_penjualan p where p.nomor_penjualan like '%" . $nmr . "%' and p.status = 1 
		and p.status_delete = 0 order by p.id_header_penjualan desc limit 1";
		// var_dump($query);exit();
		return $this->db->query($query);
	}
	
	public function getCountHeaderPenjualan($nmr){
		$query = "select p.* from header_penjualan p where p.nomor_penjualan = '" . $nmr . "' and p.status_delete = 0
		and p.status = 1";
		// var_dump($query);exit();
		return $this->db->query($query);
	}

	public function getCountHeaderPenjualans($nmr){
		$query = "select p.* from header_penjualan p where p.nomor_penjualan = '" . $nmr . "' and p.status_delete = 0
		and p.status = 1";
		return $this->db->query($query);
	}

	public function getHeaderPengeluaranByLimit($nmr){
		$query = "select p.* from header_pengeluaran p where p.status = 1 and  p.status_delete = 0 and
		p.nomor_pengeluaran like '%" . $nmr . "%' order by p.id_header_pengeluaran desc limit 1";
		// var_dump($query);exit();
		return $this->db->query($query);
	}

	public function getHeaderPengeluaranByLimitDesc($nmr){
		$query = "select p.* from header_pengeluaran p where p.nomor_pengeluaran like '%" . $nmr . "%' and p.status = 1 
		and p.status_delete = 0 order by p.id_header_pengeluaran desc limit 1";
		// var_dump($query);exit();
		return $this->db->query($query);
	}
	
	public function getCountHeaderPengeluaran($nmr){
		$query = "select p.* from header_pengeluaran p where p.nomor_pengeluaran = '" . $nmr . "' and p.status_delete = 0
		and p.status = 1";
		// var_dump($query);exit();
		return $this->db->query($query);
	}

	public function getCountHeaderPengeluarans($nmr){
		$query = "select p.* from header_pengeluaran p where p.nomor_pengeluaran = '" . $nmr . "' and p.status_delete = 0
		and p.status = 1";
		return $this->db->query($query);
	}

	public function getHeaderPengeluaransByOperator($location, $month, $year){
		$query = "select hp.*, u.* from header_pengeluaran hp left join user u on u.id_user = hp.created_by 
				 where hp.status_delete = 0 and u.id_location = " . $location . " and month(hp.tgl_pengeluaran) = '".$month."' 
				 and day(hp.tgl_pengeluaran) = '".$year."'";
		return $this->db->query($query);
	}

	public function getPengeluaranByDesc(){
		$query = "select p.* from header_pengeluaran p order by p.id_header_pengeluaran desc";
		return $this->db->query($query);
	}
}
