<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_Penjualan extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('all_model');
	}

	public function index()
	{
		$from = date('Y-m-d');
		$to = date('Y-m-d');
		$data['report'] = $this->all_model->getReportPenjualan($from, $to)->result();
		$data['user'] = $this->all_model->getAllData('user')->result();
		$data['from'] = $from;
		$data['to'] = $to;
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
		// var_dump($invoice);exit();
		
		if($from != '1970-01-01' && $to != '1970-01-01' && $no_invoice == '' && $customer == 0 && $this->input->post('invoice') == -99 && 
			$this->input->post('status_pembayaran')== -99){
			$data['from'] = $from;
			$data['to'] = $to;
			$data['report'] = $this->all_model->getReportPenjualanByDate($from, $to, $customer, $no_invoice, (int)$invoice, (int)$status_pembayaran)->result();
		}else{
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

			$data['from'] = $from;
			$data['to'] = $to;
			$data['report'] = $this->all_model->getReportPenjualanByCondition($froms, $c_customer, $no_invoice, $s_invoice, $s_pembayaran)->result();
			// var_dump($c_customer . " and " . $s_invoice . "and " . $s_pembayaran);exit();
			// var_dump($data['report']);exit();
		}
		// var_dump($data['report']);exit();
		$data['user'] = $this->all_model->getAllData('user')->result();
		$data['no_invoice'] = $no_invoice;
		$data['status_pembayaran'] = $status_pembayaran;
		$data['status_invoice'] = $this->input->post('invoice');
		$data['customer'] = $this->all_model->getDataByCondition("customer", array("id_customer" => $this->input->post('customer')))->row();
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
		$status_pembayaran = ((int)$this->input->get('status_pembayaran') == -99) ? 0 : $this->input->post('status_pembayaran');
		// var_dump($invoice);exit();
		if($from != '' && $to != '' && $no_invoice == '' && $customer == 0 && $this->input->get('invoice') == -99 && 
		$this->input->get('status_pembayaran')== -99){
			$report = $this->all_model->getReportPenjualanByDate($from, $to, $customer, $no_invoice, (int)$invoice, (int)$status_pembayaran)->result();
		}else{
			$report = $this->all_model->getReportPenjualanByCondition($from, $to, $customer, $no_invoice, (int)$invoice, (int)$status_pembayaran)->result();
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

			if($list->metode_pembayaran == 2){
				$stat_payment = 'DP';
			}else{
				$stat_payment = 'Lunas';
			}

			if((int)$list->status_invoice == 1){
				$stat_invoice = 'Sudah checkout';
			}else{
				$stat_invoice = 'Belum checkout';
			}

			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $no);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $nomor_invoice);
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, date('d-m-Y', strtotime($list->tgl_penjualan)));
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $list->first_name . ' ' . $list->last_name);
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, 'Rp ' . number_format($list->total, 0, '', '.'));
			$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, 'Rp ' . number_format($list->discount, 0, '', '.'));
			$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, 'Rp ' . number_format($list->grandtotal, 0, '', '.'));
			$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, 'Rp ' . number_format($list->dp1, 0, '', '.'));
			$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, 'Rp ' . number_format($list->dp2, 0, '', '.'));
			$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $stat_payment);
			$objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $stat_invoice);
			$objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, date('d-m-Y', strtotime($list->createdDate)));
			if(!empty($user)){
				foreach ($user as $keys => $values) {
					if($values->id_user == $list->createdBy){
						$objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $values->nama);
					}
				}
			}
			$objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, date('d-m-Y', strtotime($list->updatedDate)));
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
		$rowCount_discount = $rowCount_tot + 1;
		$rowCount_grandtotal = $rowCount_discount + 1;
		$rowCount_dp1 = $rowCount_grandtotal + 1;
		$rowCount_dp2 = $rowCount_dp1 + 1;

		$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount_tot, 'SUM Total');
		$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount_tot, 'Rp ' . number_format($total, 0, '', '.'));

		$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount_discount, 'SUM Total Diskon');
		$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount_discount, 'Rp ' . number_format($discount, 0, '', '.'));

		$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount_grandtotal, 'SUM Total GrandTotal');
		$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount_grandtotal, 'Rp ' . number_format($grandtotal, 0, '', '.'));

		$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount_dp1, 'SUM DP 1');
		$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount_dp1, 'Rp ' . number_format($dp1, 0, '', '.'));

		$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount_dp2, 'SUM DP 2');
		$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount_dp2, 'Rp ' . number_format($dp2, 0, '', '.'));

		
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Laporan Penjualan ' . date('d-m-Y') . '.xls"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$write->save('php://output');	
	}
}
