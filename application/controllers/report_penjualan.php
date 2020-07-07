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
		if($from != '' && $to != '' && $no_invoice == '' && $customer == 0 && $this->input->post('invoice') == -99 && 
		$this->input->post('status_pembayaran')== -99){
			$data['report'] = $this->all_model->getReportPenjualanByDate($from, $to, $customer, $no_invoice, (int)$invoice, (int)$status_pembayaran)->result();
		}else{
			$data['report'] = $this->all_model->getReportPenjualanByCondition($from, $to, $customer, $no_invoice, (int)$invoice, (int)$status_pembayaran)->result();
		}
		// var_dump($data['report']);exit();
		$data['user'] = $this->all_model->getAllData('user')->result();
		$data['from'] = $from;
		$data['to'] = $to;
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
}
