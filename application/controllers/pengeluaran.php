<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengeluaran extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('all_model');
	}

	public function index()
	{
		$condition = array('status' => 1);
		$data['header_pengeluaran'] = $this->all_model->getDataByCondition('header_pengeluaran', $condition)->result();
		$this->load->view('pengeluaran/index', $data);
	}

	public function add(){
		$order = "id_header_pengeluaran desc";
		$header_pengeluaran = $this->all_model->getDataByLimit(1, $order, 'header_pengeluaran')->row();

		if(empty($header_pengeluaran)){
			$data['id_header_pengeluaran'] = 1;
			$data['tgl_pengeluaran'] = date('Y-m-d');
		}else{
			// $data['id_header_penjualan'] = $header_penjualan->id_header_penjualan + 1;
			// $data['tgl_penjualan'] = date('Y-m-d');
			if($header_pengeluaran->tgl_pengeluaran == date('Y-m-d')){
				$this->session->set_flashdata('error', 'Data pengeluaran untuk hari ini sudah tersedia');
				redirect(base_url() . 'pengeluaran/index');
			}else{
				$data['id_header_pengeluaran'] = $header_pengeluaran->id_header_pengeluaran + 1;
				$data['tgl_pengeluaran'] = date('Y-m-d');
			}
		}

		$data['item'] = $this->all_model->getAllData('item')->result();
		$data['satuan'] = $this->all_model->getAllData('satuan')->result();

		$condition = array('id_user' => $this->session->userdata('id'));
		$data['user'] = $this->all_model->getDataByCondition('user', $condition)->row();
		$this->load->view('pengeluaran/add_pengeluaran_header', $data);
	}

	public function processAdd(){
		$data = array(
			'id_header_pengeluaran' => $this->input->post('id_header_pengeluaran'),
			'tgl_pengeluaran' => date('Y-m-d', strtotime($this->input->post('tgl_pengeluaran'))),
			'status'  => 1,
			'created_by' => $this->session->userdata('id'),
			'created_date' => date('Y-m-d H:i:s', strtotime(strtr($this->input->post('createdDate'), '-', '-')))
		);

		$result = $this->all_model->insertData('header_pengeluaran', $data);
		if($result == true){
			$order = "id_header_pengeluaran desc";
		    $header_pengeluaran = $this->all_model->getDataByLimit(1, $order, 'header_pengeluaran')->row();
		    return redirect(base_url().'pengeluaran/detail/' . $header_pengeluaran->id_header_pengeluaran);
		}
		return redirect(base_url() . 'pengeluaran/add');
	}

	public function detail($id){
		$condition = array('id_header_pengeluaran' => $id);
		$data['header_pengeluaran'] = $this->all_model->getDataByCondition('header_pengeluaran', $condition)->row();

		$condition = array('id_user' => $this->session->userdata('id'));
		$data['user'] = $this->all_model->getDataByCondition('user', $condition)->row();
		$this->load->view('pengeluaran/add_pengeluaran', $data);
	}
}
