<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_Pengeluaran extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('all_model');
	}

	public function index()
	{
		$from = date('Y-m-d');
		$to = date('Y-m-d');
		$data['report'] = $this->all_model->getReportPengeluaranDate($from, $to)->result();
		$data['user'] = $this->all_model->getAllData('user')->result();
		$data['from'] = $from;
		$data['to'] = $to;
		$this->load->view('report-pengeluaran/index', $data);
	}

	public function search()
	{
		$from = date('Y-m-d', strtotime($this->input->post('from_date')));
		$to = date('Y-m-d', strtotime(strtr($this->input->post('to_date'), '-', '-')));
		$status = ($this->input->post('status')  == -99) ? 0 : $this->input->post('status');
		// var_dump($invoice);exit();
		if($from != '' && $to != '' && $status == -99){
			$data['report'] = $this->all_model->getReportPengeluaranDate($from, $to)->result();
		}else{
			$data['report'] = $this->all_model->getReportPengeluaranByCondition($from, $to, (int)$status)->result();
		}
		// var_dump($data['report']);exit();
		$data['user'] = $this->all_model->getAllData('user')->result();
		$data['from'] = $from;
		$data['to'] = $to;
		$data['status'] = $this->input->post('status');
		$this->load->view('report-pengeluaran/index', $data);
		// return redirect(base_url() . 'report_penjualan/index');
	}

	public function export(){
		$from = date('Y-m-d', strtotime($this->input->get('from_date')));
		$to = date('Y-m-d', strtotime(strtr($this->input->get('to_date'), '-', '-')));
		$status = ($this->input->get('status') == -99) ? 0 : $this->input->get('status');
		// var_dump($invoice);exit();
		if($from != '' && $to != '' && $status == -99){
			$report = $this->all_model->getReportPengeluaranDate($from, $to)->result();
		}else{
			$report = $this->all_model->getReportPengeluaranByCondition($from, $to, (int)$status)->result();
		}

		$user = $this->all_model->getAllData('user')->result();
		$this->load->library('excel');

		// Panggil class PHPExcel nya
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "Transaksi Pengeluaran"); // Set kolom A1 dengan tulisan "DATA SISWA"
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
        $objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Nomor Pengeluaran');
        $objPHPExcel->getActiveSheet()->SetCellValue('C5', 'Tgl Pengeluaran');
		$objPHPExcel->getActiveSheet()->SetCellValue('D5', 'Total');
		$objPHPExcel->getActiveSheet()->SetCellValue('E5', 'Status Pengeluaran');
		$objPHPExcel->getActiveSheet()->SetCellValue('F5', 'Tgl Dibuat');
		$objPHPExcel->getActiveSheet()->SetCellValue('G5', 'Dibuat Oleh');
        $objPHPExcel->getActiveSheet()->SetCellValue('H5', 'Tgl Diubah');
        $objPHPExcel->getActiveSheet()->SetCellValue('I5', 'Diubah Oleh');

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

			if($list->status == 1){
				$stat = 'Close';
			}else{
				$stat = 'Open';
			}

			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $no);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $list->id_header_pengeluaran);
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, date('d-m-Y', strtotime($list->tgl_pengeluaran)));
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, 'Rp ' . number_format($list->total, 0, '', '.'));
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $stat);
			$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, date('d-m-Y', strtotime($list->created_date)));
			if(!empty($user)){
				foreach ($user as $keys => $values) {
					if($values->id_user == $list->created_by){
						$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $values->nama);
					}
				}
			}
			$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, date('d-m-Y', strtotime($list->updated_date)));
			if(!empty($user)){
				foreach ($user as $keys => $values) {
					if($values->id_user == $list->updated_by){
						$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $values->nama);
					}
				}
			}
			$rowCount++;
			$no++;
		}
		
		$rowCount_tot = $rowCount + 1;

		$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount_tot, 'SUM Total');
		$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount_tot, 'Rp ' . number_format($total, 0, '', '.'));
		
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Laporan Pengeluaran ' . date('d-m-Y') . '.xls"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$write->save('php://output');	
	}
}
