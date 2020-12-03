<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_Penjualan extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('all_model');
		if($this->session->userdata('logged_in') != 1){
			return redirect(base_url() . 'login');
		}
	}

	public function index()
	{
		$from = date('Y-m-d');
		$to = date('Y-m-d');
		$data['report'] = $this->all_model->getReportPenjualan($from, $to)->result();
		$data['user'] = $this->all_model->getAllData('user')->result();
		$data['from'] = $from;
		$data['to'] = $to;
		$condition = array('status' => 1, 'is_deleted' => 0);
		$data['location'] = $this->all_model->getDataByCondition('location', $condition)->result();
		var_dump($data);exit();
		$this->load->view('report-penjualan/index', $data);
	}

	public function search()
	{
		$from = date('Y-m-d', strtotime($this->input->post('from_date')));
		$to = date('Y-m-d', strtotime(strtr($this->input->post('to_date'), '-', '-')));
		$no_invoice = $this->input->post('no_invoice');
		$customer = ($this->input->post('customer')  == 0) ? 0 : $this->input->post('customer');
		$invoice = ($this->input->post('invoice') == -99) ? 0 : $this->input->post('invoice');
		$status_pembayaran = ((int)$this->input->post('status_pembayaran') == -99) ? 0 : $this->input->post('status_pembayaran');
		$location = $this->input->post('id_location');

		if($from != '1970-01-01' && $to != '1970-01-01' && $no_invoice == '' && $customer == 0 && $this->input->post('invoice') == -99 && 
			$this->input->post('status_pembayaran')== -99 && $location == ''){
			$data['from'] = $from;
			$data['to'] = $to;
			$data['report'] = $this->all_model->getReportPenjualanByDate($from, $to, $customer, $no_invoice, (int)$invoice, (int)$status_pembayaran)->result();
		}else if($from == '1970-01-01' && $to == '1970-01-01'){
				if($from == '1970-01-01' || $to == '1970-01-01'){
					$froms = '';
					$from = '';
					$to = '';
				}

				if ($this->input->post('invoice') == -99){
					$s_invoice = "p.status >= 0 ";
				}else{
					$s_invoice = "p.status = " . $invoice . " " ; 
				}
	
				if ($this->input->post('status_pembayaran') == -99){
					$s_pembayaran = "p.status_pembayaran >= 0";
				}else{
					$s_pembayaran = "p.status_pembayaran = " . $status_pembayaran; 
				}
	
				if ($customer == 0){
					$c_customer = "p.id_customer >= 0 ";
				}else{
					$c_customer = "p.id_customer = " . $customer . " "; 
				}

				if ($location == ''){
					$c_location = "l.id_location ilike %" . $location . "% ";
				}else{
					$c_location = "l.id_location = " . $location . " "; 
				}
	
				$data['from'] = $from;
				$data['to'] = $to;
				$data['report'] = $this->all_model->getReportPenjualanByWithoutDate($c_customer, $no_invoice, $s_invoice, $s_pembayaran, $c_location)->result();
		}else if($from != '1970-01-01' && $to != '1970-01-01'){
			// var_dump($from);exit();
			if($from == '1970-01-01' || $to == '1970-01-01'){
				$froms = '';
				$from = '';
				$to = '';
			}

			if($from != '1970-01-01' || $to != '1970-01-01'){
				$froms = " and p.tgl_penjualan between '".$from."' and '".$to."' ";
			}

			if ($this->input->post('invoice') == -99){
				$s_invoice = "p.status >= 0 ";
			}else{
				$s_invoice = "p.status = " . $invoice . " " ; 
			}

			if ($this->input->post('status_pembayaran') == -99){
				$s_pembayaran = "p.status_pembayaran >= 0";
			}else{
				$s_pembayaran = "p.status_pembayaran = " . $status_pembayaran; 
			}

			if ($customer == 0){
				$c_customer = "p.id_customer >= 0 ";
			}else{
				$c_customer = "p.id_customer = " . $customer . " "; 
			}

			if ($location == ''){
				$c_location = "l.id_location ilike %" . $location . "% ";
			}else{
				$c_location = "l.id_location = " . $location . " "; 
			}

			$data['from'] = $from;
			$data['to'] = $to;
			$data['report'] = $this->all_model->getReportPenjualanByCondition($froms, $c_customer, $no_invoice, $s_invoice, $s_pembayaran, $c_location)->result();
			// var_dump($c_customer . " and " . $s_invoice . "and " . $s_pembayaran);exit();
			// var_dump($data['report']);exit();
		}
		// var_dump($data['report']);exit();
		$data['user'] = $this->all_model->getAllData('user')->result();
		$data['no_invoice'] = $no_invoice;
		$data['status_pembayaran'] = $status_pembayaran;
		$data['status_invoice'] = $this->input->post('invoice');
		$data['customer'] = $this->all_model->getDataByCondition("customer", array("id_customer" => $this->input->post('customer')))->row();
		$condition = array('status' => 1, 'is_deleted' => 0);
		$data['locations'] = $this->all_model->getDataByCondition('location', $condition)->result();
		$data['location'] = $location;
		// var_dump($data['report']);exit();
		$this->load->view('report-penjualan/index', $data);
		// return redirect(base_url() . 'report_penjualan/index');
	}

	public function get_autocomplete(){
		if (isset($_GET['term'])) {
            // $result = $this->blog_model->search_blog($_GET['term']);
            // if (count($result) > 0) {
            // foreach ($result as $row)
            //     $arr_result[] = $row->blog_title;
            //     echo json_encode($arr_result);
			// }
			// $condition = array('nama_project' => $_GET['term']);
			// $result = $this->all_model->getDataByCondition('project', $condition)->result();
			// if(count($result) > 0){
			// 	foreach($result as $row){
			// 		$arr_result[] = $row->nama_project;
			// 		echo json_encode($arr_result);
			// 	}
			// }
			// var_dump($_GET['term']);exit();
			
			$result = $this->all_model->getSearchNama($this->input->get('term'))->result();
			if (count($result) > 0) {
			foreach ($result as $row)
				$arr_result[] = array('label' => $row->first_name . ' ' . $row->last_name, 'value' => $row->id_customer);
				echo json_encode($arr_result);
			}
        }
	}

	public function export(){
		$from = date('Y-m-d', strtotime($this->input->get('from_date')));
		$to = date('Y-m-d', strtotime(strtr($this->input->get('to_date'), '-', '-')));
		$no_invoice = $this->input->get('no_invoice');
		$customer = ($this->input->get('customer')  == 0) ? 0 : $this->input->get('customer');
		$invoice = ($this->input->get('invoice') == -99) ? 0 : $this->input->get('invoice');
		$status_pembayaran = ((int)$this->input->get('status_pembayaran') == -99) ? 0 : $this->input->get('status_pembayaran');
		// var_dump($invoice);exit();
		if($from != '1970-01-01' && $to != '1970-01-01' && $no_invoice == '' && $customer == 0 && $this->input->get('invoice') == -99 && 
			$this->input->get('status_pembayaran')== -99){
			$report = $this->all_model->getReportPenjualanByDate($from, $to, $customer, $no_invoice, (int)$invoice, (int)$status_pembayaran)->result();
		}else if($from == '1970-01-01' && $to == '1970-01-01'){
				if($from == '1970-01-01' || $to == '1970-01-01'){
					$froms = '';
					$from = '';
					$to = '';
				}

				if ($this->input->get('invoice') == -99){
					$s_invoice = "p.status >= 0 ";
				}else{
					$s_invoice = "p.status = " . $invoice . " " ; 
				}
	
				if ($this->input->get('status_pembayaran') == -99){
					$s_pembayaran = "p.status_pembayaran >= 0";
				}else{
					$s_pembayaran = "p.status_pembayaran = " . $status_pembayaran; 
				}

				if ($customer == 0){
					$c_customer = "p.id_customer >= 0 ";
				}else{
					$c_customer = "p.id_customer = " . $customer . " "; 
				}
				$report = $this->all_model->getReportPenjualanByWithoutDate($c_customer, $no_invoice, $s_invoice, $s_pembayaran)->result();
		}else if($from != '1970-01-01' && $to != '1970-01-01'){
			// var_dump('oi');exit();
			if($from == '1970-01-01' || $to == '1970-01-01'){
				$froms = '';
				$from = '';
				$to = '';
			}

			if($from != '1970-01-01' || $to != '1970-01-01'){
				$froms = " and p.tgl_penjualan between '".$from."' and '".$to."' ";
			}

			if ($this->input->get('invoice') == -99){
				$s_invoice = "p.status >= 0 ";
			}else{
				$s_invoice = "p.status = " . $invoice . " " ; 
			}

			if ($this->input->get('status_pembayaran') == -99){
				$s_pembayaran = "p.status_pembayaran >= 0";
			}else{
				$s_pembayaran = "p.status_pembayaran = " . $status_pembayaran; 
			}
			// var_dump($s_pembayaran);exit();
			if ($customer == 0){
				$c_customer = "p.id_customer >= 0 ";
			}else{
				$c_customer = "p.id_customer = " . $customer . " "; 
			}
			$report = $this->all_model->getReportPenjualanByCondition($froms, $c_customer, $no_invoice, $s_invoice, $s_pembayaran)->result();
		}

		$user = $this->all_model->getAllData('user')->result();
		$this->load->library('excel');

		// Panggil class PHPExcel nya
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "Transaksi Penjualan"); // Set kolom A1 dengan tulisan "DATA SISWA"
		$objPHPExcel->getActiveSheet()->mergeCells('A1:O1'); // Set Merge Cell pada kolom A1 sampai E1
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', "Periode " . $this->input->get('from_date') . " s/d " . $this->input->get('to_date')); // Set kolom A1 dengan tulisan "DATA SISWA"
		$objPHPExcel->getActiveSheet()->mergeCells('A2:O2'); // Set Merge Cell pada kolom A1 sampai E1
		$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'No.');
        $objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Nomor Invoice');
        $objPHPExcel->getActiveSheet()->SetCellValue('C5', 'Tgl Invoice');
		$objPHPExcel->getActiveSheet()->SetCellValue('D5', 'Nama Customer');
		$objPHPExcel->getActiveSheet()->SetCellValue('E5', 'Total');
        $objPHPExcel->getActiveSheet()->SetCellValue('F5', 'Discount');
        $objPHPExcel->getActiveSheet()->SetCellValue('G5', 'GrandTotal');
		$objPHPExcel->getActiveSheet()->SetCellValue('H5', 'DP 1');
		$objPHPExcel->getActiveSheet()->SetCellValue('I5', 'DP 2');
        $objPHPExcel->getActiveSheet()->SetCellValue('J5', 'Status Pembayaran');
        $objPHPExcel->getActiveSheet()->SetCellValue('K5', 'Status Invoice');
		$objPHPExcel->getActiveSheet()->SetCellValue('L5', 'Tgl Dibuat');
		$objPHPExcel->getActiveSheet()->SetCellValue('M5', 'Dibuat Oleh');
        $objPHPExcel->getActiveSheet()->SetCellValue('N5', 'Tgl Diubah');
        $objPHPExcel->getActiveSheet()->SetCellValue('O5', 'Diubah Oleh');

		$rowCount = 6;
		$no = 1;
		$total = 0;
		$discount = 0;
		$grandtotal = 0;
		$dp1 = 0;
		$dp2 = 0;
		foreach ($report as $list) {
			// $created_by = $this->all_model->getDataByCondition("customer", array("id_customer" => $list->createdBy))->row();
			// $updated_by = $this->all_model->getDataByCondition("customer", array("id_customer" => $list->updatedBy))->row();
			$total = $total + $list->total;
			$discount = $discount + $list->discount;
			$grandtotal = $grandtotal + $list->grandtotal;
			$dp1 = $dp1 + $list->dp1;
			$dp2 = $dp2 + $list->dp2;

			if($list->status_pembayaran != 0){
				$nomor_invoice = $list->nomor_penjualan;
			}else{
				$nomor_invoice = $list->id_header_penjualan;
			}

			if((int)$list->status_pembayaran == 2){
				$stat_payment = 'DP';
			}else if((int)$list->status_pembayaran == 1){
				$stat_payment = 'Lunas';
			}else{
				$stat_payment = 'Belum Bayar';
			}

			// if($list->metode_pembayaran == "2"){
			// 	$stat_payment =  'DP';
			// }else if($list->metode_pembayaran == "1" && ($list->dp1 != "" && $list->dp2 != "")){
			// 	$stat_payment = 'Lunas';
			// }else if($list->metode_pembayaran == "0"){
			// 	$stat_payment = 'Belum Bayar';
			// }else if($list->metode_pembayaran == "1") {
			// 	$stat_payment = 'Lunas';
			// }else if($list->dp1 != "" && $list->dp2 != ""){
			// 	$stat_payment =  'Lunas';
			// }

			// if ((int)$list->status_invoice == 0 || empty($list->status_invoice)){
			// 	$stat_invoice = 'Belum checkout';
			// }else{
			// 	$stat_invoice = 'Sudah checkout';
			// }

			if((int)$list->status_invoice == 0){
				$stat_invoice =  'Belum Checkout';
			}else if((int)$list->status_invoice == 1){
				$stat_invoice =  'Sudah Checkout';
			}else{
				$stat_invoice =  "Belum Checkout";
			}

			$list->tgl_penjualan = explode(" ", $list->tgl_penjualan);
			$list->updatedDate = explode(" ", $list->updatedDate);
			$list->createdDate = explode(" ", $list->createdDate);

			if($list->tgl_penjualan[0] == '1970-01-01' || $list->tgl_penjualan[0] == '0000-00-00'){
				$tgl_penjualan = '';
			}else{
				$tgl_penjualan = date('d-m-Y', strtotime($list->tgl_penjualan[0]));
			}

			if($list->updatedDate[0] == '1970-01-01' || $list->updatedDate[0] == '0000-00-00'){
				$updatedDate = '';
			}else{
				$updatedDate = date('d-m-Y', strtotime($list->updatedDate[0]));
			}

			if($list->createdDate[0] == '1970-01-01' || $list->createdDate[0] == '0000-00-00'){
				$createdDate = '';
			}else{
				$createdDate = date('d-m-Y', strtotime($list->createdDate[0]));
			}

			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $no);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $nomor_invoice);
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $tgl_penjualan);
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $list->first_name . ' ' . $list->last_name);
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, 'Rp ' . number_format($list->total, 0, '', '.'));
			$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, 'Rp ' . number_format($list->discount, 0, '', '.'));
			$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, 'Rp ' . number_format($list->grandtotal, 0, '', '.'));
			$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, 'Rp ' . number_format($list->dp1, 0, '', '.'));
			$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, 'Rp ' . number_format($list->dp2, 0, '', '.'));
			$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $stat_payment);
			$objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $stat_invoice);
			$objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $createdDate);
			if(!empty($user)){
				foreach ($user as $keys => $values) {
					if($values->id_user == $list->createdBy){
						$objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $values->nama);
					}
				}
			}
			$objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $updatedDate);
			if(!empty($user)){
				foreach ($user as $keys => $values) {
					if($values->id_user == $list->updatedBy){
						$objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $values->nama);
					}
				}
			}
			$rowCount++;
			$no++;
		}
		
		$rowCount_tot = $rowCount + 1;
		// $rowCount_discount = $rowCount_tot + 1;
		// $rowCount_grandtotal = $rowCount_discount + 1;
		// $rowCount_dp1 = $rowCount_grandtotal + 1;
		// $rowCount_dp2 = $rowCount_dp1 + 1;

		$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount_tot, 'Total');
		$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount_tot, 'Rp ' . number_format($total, 0, '', '.'));

		// $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount_discount, 'SUM Total Diskon');
		$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount_tot, 'Rp ' . number_format($discount, 0, '', '.'));

		// $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount_grandtotal, 'SUM Total GrandTotal');
		$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount_tot, 'Rp ' . number_format($grandtotal, 0, '', '.'));

		// $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount_dp1, 'SUM DP 1');
		$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount_tot, 'Rp ' . number_format($dp1, 0, '', '.'));

		// $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount_dp2, 'SUM DP 2');
		$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount_tot, 'Rp ' . number_format($dp2, 0, '', '.'));

		
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Laporan Penjualan ' . date('d-m-Y') . '.xls"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$write->save('php://output');	
	}

	public function detail($id){
		// $condition = array('id_header_penjualan' => $id);
		// $data['header_penjualan'] = $this->all_model->getDataByCondition('header_penjualan', $condition)->row();
		// // var_dump($data);exit();
		// $data['penjualan'] = $this->all_model->getPenjualanByHeaderPenjualan($id)->result();
		// $data['counts'] = $this->all_model->getPenjualanByStatusHeaderPenjualan($id)->num_rows();
		// $data['item'] = $this->all_model->getAllData('item')->result();
		// $data['satuan'] = $this->all_model->getAllData('satuan')->result();

		// $condition = array('id_user' => $this->session->userdata('id'));
		// $data['user'] = $this->all_model->getDataByCondition('user', $condition)->row();
		// $data['customer'] = $this->all_model->getDataByCondition('customer', array('status' => 1))->result();
		$data['report'] = $this->all_model->getReportPenjualanDetail($id)->result();

		$data['user'] = $this->all_model->getAllData('user')->result();
		$this->load->view('report-penjualan/detail', $data);
	}

	public function printDetail($id){
		$from = date('Y-m-d', strtotime($this->input->get('from_date')));
		$to = date('Y-m-d', strtotime(strtr($this->input->get('to_date'), '-', '-')));

		if($from == '1970-01-01' || $to == '1970-01-01'){
			$from = '';
			$to = '';
		}

		$report = $this->all_model->getReportPenjualanDetail($id)->result();

		$user = $this->all_model->getAllData('user')->result();
		$this->load->library('excel');

		// Panggil class PHPExcel nya
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "Transaksi Penjualan"); 
		$objPHPExcel->getActiveSheet()->mergeCells('A1:O1'); // Set Merge Cell pada kolom A1 sampai E1
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		if($from != '' && $to == ''){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', "Periode " . $this->input->get('from_date') . " s/d " . $this->input->get('to_date')); 
		}

		$objPHPExcel->getActiveSheet()->mergeCells('A2:O2'); // Set Merge Cell pada kolom A1 sampai E1
		$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'No.');
        $objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Nomor Invoice');
        $objPHPExcel->getActiveSheet()->SetCellValue('C5', 'Tgl Invoice');
		$objPHPExcel->getActiveSheet()->SetCellValue('D5', 'Nama Customer');
		$objPHPExcel->getActiveSheet()->SetCellValue('E5', 'Total');
        $objPHPExcel->getActiveSheet()->SetCellValue('F5', 'Discount');
        $objPHPExcel->getActiveSheet()->SetCellValue('G5', 'GrandTotal');
		$objPHPExcel->getActiveSheet()->SetCellValue('H5', 'DP 1');
		$objPHPExcel->getActiveSheet()->SetCellValue('I5', 'DP 2');
        $objPHPExcel->getActiveSheet()->SetCellValue('J5', 'Status Pembayaran');
        $objPHPExcel->getActiveSheet()->SetCellValue('K5', 'Status Invoice');
		$objPHPExcel->getActiveSheet()->SetCellValue('L5', 'Tgl Dibuat');
		$objPHPExcel->getActiveSheet()->SetCellValue('M5', 'Dibuat Oleh');
        $objPHPExcel->getActiveSheet()->SetCellValue('N5', 'Tgl Diubah');
		$objPHPExcel->getActiveSheet()->SetCellValue('O5', 'Diubah Oleh');
		$objPHPExcel->getActiveSheet()->SetCellValue('P5', 'Item');
		$objPHPExcel->getActiveSheet()->SetCellValue('Q5', 'Unit');
		$objPHPExcel->getActiveSheet()->SetCellValue('R5', 'Jumlah');
		$objPHPExcel->getActiveSheet()->SetCellValue('S5', 'Harga Satuan');
		$objPHPExcel->getActiveSheet()->SetCellValue('T5', 'Total Harga');
		$objPHPExcel->getActiveSheet()->SetCellValue('U5', 'Keterangan');

		$rowCount = 6;
		$no = 1;
		$total = 0;
		$discount = 0;
		$grandtotal = 0;
		$dp1 = 0;
		$dp2 = 0;
		foreach ($report as $list) {
			// $created_by = $this->all_model->getDataByCondition("customer", array("id_customer" => $list->createdBy))->row();
			// $updated_by = $this->all_model->getDataByCondition("customer", array("id_customer" => $list->updatedBy))->row();
			$total = $total + $list->total;
			$discount = $discount + $list->discount;
			$grandtotal = $grandtotal + $list->grandtotal;
			$dp1 = $dp1 + $list->dp1;
			$dp2 = $dp2 + $list->dp2;

			if($list->status_pembayaran != 0){
				$nomor_invoice = $list->nomor_penjualan;
			}else{
				$nomor_invoice = $list->id_header_penjualan;
			}

			if((int)$list->status_pembayaran == 2){
				$stat_payment = 'DP';
			}else if((int)$list->status_pembayaran == 1){
				$stat_payment = 'Lunas';
			}else{
				$stat_payment = 'Belum Bayar';
			}

			if((int)$list->status_invoice == 0){
				$stat_invoice =  'Belum Checkout';
			}else if((int)$list->status_invoice == 1){
				$stat_invoice =  'Sudah Checkout';
			}else{
				$stat_invoice =  "Belum Checkout";
			}

			$list->tgl_penjualan = explode(" ", $list->tgl_penjualan);
			$list->updatedDate = explode(" ", $list->updatedDate);
			$list->createdDate = explode(" ", $list->createdDate);

			if($list->tgl_penjualan[0] == '1970-01-01' || $list->tgl_penjualan[0] == '0000-00-00'){
				$tgl_penjualan = '';
			}else{
				$tgl_penjualan = date('d-m-Y', strtotime($list->tgl_penjualan[0]));
			}

			if($list->updatedDate[0] == '1970-01-01' || $list->updatedDate[0] == '0000-00-00'){
				$updatedDate = '';
			}else{
				$updatedDate = date('d-m-Y', strtotime($list->updatedDate[0]));
			}

			if($list->createdDate[0] == '1970-01-01' || $list->createdDate[0] == '0000-00-00'){
				$createdDate = '';
			}else{
				$createdDate = date('d-m-Y', strtotime($list->createdDate[0]));
			}

			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $no);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $nomor_invoice);
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $tgl_penjualan);
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $list->first_name . ' ' . $list->last_name);
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, 'Rp ' . number_format($list->total, 0, '', '.'));
			$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, 'Rp ' . number_format($list->discount, 0, '', '.'));
			$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, 'Rp ' . number_format($list->grandtotal, 0, '', '.'));
			$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, 'Rp ' . number_format($list->dp1, 0, '', '.'));
			$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, 'Rp ' . number_format($list->dp2, 0, '', '.'));
			$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $stat_payment);
			$objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $stat_invoice);
			$objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $createdDate);
			if(!empty($user)){
				foreach ($user as $keys => $values) {
					if($values->id_user == $list->createdBy){
						$objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $values->nama);
					}
				}
			}
			$objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $updatedDate);
			if(!empty($user)){
				foreach ($user as $keys => $values) {
					if($values->id_user == $list->updatedBy){
						$objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $values->nama);
					}
				}
			}
			$objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $list->item);
			$objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $list->unit);
			$objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $list->qty_item);
			$objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, 'Rp ' . number_format($list->harga_satuan, 0, '', '.'));
			$objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, 'Rp ' . number_format($list->total_harga, 0, '', '.'));
			$objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $list->keterangan);
			$rowCount++;
			$no++;
		}
		
		$rowCount_tot = $rowCount + 1;
		// $rowCount_discount = $rowCount_tot + 1;
		// $rowCount_grandtotal = $rowCount_discount + 1;
		// $rowCount_dp1 = $rowCount_grandtotal + 1;
		// $rowCount_dp2 = $rowCount_dp1 + 1;

		$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount_tot, 'Total');
		$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount_tot, 'Rp ' . number_format($total, 0, '', '.'));

		// $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount_discount, 'SUM Total Diskon');
		$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount_tot, 'Rp ' . number_format($discount, 0, '', '.'));

		// $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount_grandtotal, 'SUM Total GrandTotal');
		$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount_tot, 'Rp ' . number_format($grandtotal, 0, '', '.'));

		// $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount_dp1, 'SUM DP 1');
		$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount_tot, 'Rp ' . number_format($dp1, 0, '', '.'));

		// $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount_dp2, 'SUM DP 2');
		$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount_tot, 'Rp ' . number_format($dp2, 0, '', '.'));

		
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Detail Laporan Penjualan ' . date('d-m-Y') . '.xls"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$write->save('php://output');	
	}
}
