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
}
