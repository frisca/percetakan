<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_Penjualan extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('all_model');
	}

	public function index()
	{
		$data['report'] = $this->all_model->getReportPenjualan()->result();
		$data['user'] = $this->all_model->getAllData('user')->result();
		$this->load->view('report-penjualan/index', $data);
	}
}
