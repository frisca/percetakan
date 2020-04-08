<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penjualan extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('all_model');
	}

	public function index()
	{
		$data['header_penjualan'] = $this->all_model->getAllData('header_penjualan')->result();
		$this->load->view('penjualan/index', $data);
	}

	public function add(){
		$order = "id_header_penjualan desc";
		$header_penjualan = $this->all_model->getDataByLimit(1, $order, 'header_penjualan')->row();

		if(empty($header_penjualan)){
			$data['id_header_penjualan'] = 1;
			$data['tgl_penjualan'] = date('Y-m-d');
		}else{
			$data['id_header_penjualan'] = $header_penjualan->id_header_penjualan + 1;
			$data['tgl_penjualan'] = date('Y-m-d');
		}

		$data['item'] = $this->all_model->getAllData('item')->result();
		$data['satuan'] = $this->all_model->getAllData('satuan')->result();
		$this->load->view('penjualan/add_penjualan_header', $data);
	}

	public function processAdd(){
		$data = array(
			'id_header_penjualan' => $this->input->post('id_header_penjualan'),
			'tgl_penjualan' => date('Y-m-d', strtotime($this->input->post('tgl_penjualan'))),
			'discount' => $this->input->post('discount')
		);

		$result = $this->all_model->insertData('header_penjualan', $data);
		if($result == true){
			$order = "id_header_penjualan desc";
		    $header_penjualan = $this->all_model->getDataByLimit(1, $order, 'header_penjualan')->row();
		    return redirect(base_url().'penjualan/detail/' . $header_penjualan->id_header_penjualan);
		}
		return redirect(base_url() . 'penjualan/add');
	}

	public function detail($id){
		$condition = array('id_header_penjualan' => $id);
		$data['header_penjualan'] = $this->all_model->getDataByCondition('header_penjualan', $condition)->row();
		$data['penjualan'] = $this->all_model->getPenjualanByHeaderPenjualan($id)->result();
		$data['item'] = $this->all_model->getAllData('item')->result();
		$data['satuan'] = $this->all_model->getAllData('satuan')->result();
		$this->load->view('penjualan/add_penjualan', $data);
	}

	public function processAddPenjualan(){
		$this->form_validation->set_rules('id_item', 'Nama item', 'required');
		$this->form_validation->set_rules('id_satuan', 'Satuan', 'required');
		$this->form_validation->set_rules('harga_satuan', 'Harga Satuan', 'required');
		$this->form_validation->set_rules('qty', 'Jumlah', 'required');
		$this->form_validation->set_rules('total_harga', 'Total Harga', 'required');

		$datas = array(
			'id_item' => $this->input->post('id_item'),
			'id_satuan' => $this->input->post('id_satuan'),
			'qty' => $this->input->post('qty'),
			'harga_satuan' => $this->input->post('harga_satuan'),
			'total_harga' => $this->input->post('total_harga'),
			'status' => 0,
			'created_date' => date('Y-m-d'),
			'created_by' => $this->session->userdata('id'),
			'id_header_penjualan' => $this->input->post('id_header_penjualan'),
			'id_user' => $this->session->userdata('id')
		);

		if($this->form_validation->run() == false){
			return redirect(base_url() . 'penjualan/detail/' . $this->input->post('id_header_penjualan'));
		}else{ 
			$new_name                   = time().$_FILES["line_item"]['name'];
	        $config['file_name']        = $new_name;
			$config['upload_path']      = './gambar/';
			$config['allowed_types']    = 'gif|jpg|png';

			$this->load->library('upload', $config);
	 
			if ( ! $this->upload->do_upload('line_item')){
				$this->session->set_flashdata('error', 'Data item tidak berhasil disimpan');
				redirect(base_url() . 'penjualan/detail/' . $this->input->post('id_header_penjualan'));
			}

			$datas = array(
				'id_item' => $this->input->post('id_item'),
				'id_satuan' => $this->input->post('id_satuan'),
				'qty' => $this->input->post('qty'),
				'harga_satuan' => $this->input->post('harga_satuan'),
				'total_harga' => $this->input->post('total_harga'),
				'status' => 0,
				'created_date' => date('Y-m-d'),
				'created_by' => $this->session->userdata('id'),
				'id_header_penjualan' => $this->input->post('id_header_penjualan'),
				'id_user' => $this->session->userdata('id'),
				'line_item' => $new_name
			);

			$result = $this->all_model->insertData("penjualan", $datas);
			if($result  == true){
				$condition = array('id_header_penjualan' => $this->input->post('id_header_penjualan'));
				$res = $this->all_model->getDataByCondition('header_penjualan', $condition)->row();

				$total = $res->total + $this->input->post('total_harga');
				$grandTotal = $total - $res->discount;

				$dataHeaderPenjualan = array(
					'total' => $total,
					'grandtotal' => $grandTotal
				);

				$headerPenjualan = $this->all_model->updateData('header_penjualan', $condition, $dataHeaderPenjualan);
				if($headerPenjualan == true){
					$this->session->set_flashdata('success', 'Data item berhasil disimpan');
					redirect(base_url() . 'penjualan/detail/' . $this->input->post('id_header_penjualan'));
				}
				$this->session->set_flashdata('error', 'Data item tidak berhasil disimpan');
				redirect(base_url() . 'penjualan/detail/' . $this->input->post('id_header_penjualan'));
			}else{
				$this->session->set_flashdata('error', 'Data item tidak berhasil disimpan');
				redirect(base_url() . 'penjualan/detail/' . $this->input->post('id_header_penjualan'));
			}
		}	
	}


	public function checkout($id, $id_header_penjualan){
		$condition = array('id_penjualan' => $id);
		$data = array('status' => 1);
		$res = $this->all_model->updateData('penjualan', $condition, $data);
		if($res == false){
			return redirect(base_url().'penjualan/detail/' . $id_header_penjualan);
		}
		return redirect(base_url().'penjualan/detail/' . $id_header_penjualan);
	}

	public function edit(){
		$condition = array('id_penjualan' => $this->input->get('id'));
    	$data['penjualan'] = $this->all_model->getDataByCondition('penjualan', $condition)->row();
    	$data['item'] = $this->all_model->getAllData('item')->result();
    	$data['satuan'] = $this->all_model->getAllData('satuan')->result();
    	echo json_encode($data); 
	}

	public function processEditPenjualan(){
		$condition = array('id_penjualan' => $this->input->post('id_penjualan'));

		$this->form_validation->set_rules('id_item', 'Nama item', 'required');
		$this->form_validation->set_rules('id_satuan', 'Satuan', 'required');
		$this->form_validation->set_rules('harga_satuan', 'Harga Satuan', 'required');
		$this->form_validation->set_rules('qty', 'Jumlah', 'required');
		$this->form_validation->set_rules('total_harga', 'Total Harga', 'required');

		if($this->form_validation->run() == false){
			return redirect(base_url() . 'penjualan/detail/' . $this->input->post('id_header_penjualan'));
		}else{
			$datas = array(
				'id_item' => $this->input->post('id_item'),
				'id_satuan' => $this->input->post('id_satuan'),
				'qty' => $this->input->post('qty'),
				'harga_satuan' => $this->input->post('harga_satuan'),
				'total_harga' => $this->input->post('total_harga'),
				'updated_date' => date('Y-m-d'),
				'updated_by' => $this->session->userdata('id')
			);
			$result = $this->all_model->updateData("penjualan", $condition, $datas);
			if($result  == true){
				$this->session->set_flashdata('success', 'Data penjualan berhasil diubah');
				redirect(base_url() . 'penjualan/detail/' . $this->input->post('id_header_penjualan'));
			}else{
				$this->session->set_flashdata('error', 'Data penjualan tidak berhasil diubah');
				redirect(base_url() . 'penjualan/detail/' . $this->input->post('id_header_penjualan'));
			}
		}	
	}

	public function delete($id, $header_penjualan){
		$condition = array("id_penjualan" => $id);
		$res  = $this->all_model->deleteData("penjualan", $condition);
		if($res == false){
			$this->session->set_flashdata('error', 'Data penjualan berhasil dihapus');
			redirect(base_url() . "penjualan/detail/" . $header_penjualan);
		}

		$this->session->set_flashdata('success', 'Data penjualan berhasil dihapus');
		redirect(base_url() . "penjualan/detail/" . $header_penjualan);
	}

	public function view($id){
		$condition = array('id_header_penjualan' => $id);
		$data['header_penjualan'] = $this->all_model->getDataByCondition('header_penjualan', $condition)->row();
		$data['penjualan'] = $this->all_model->getPenjualanByHeaderPenjualan($id)->result();
		$data['item'] = $this->all_model->getAllData('item')->result();
		$data['satuan'] = $this->all_model->getAllData('satuan')->result();
		$this->load->view('penjualan/view_penjualan', $data);
	}

	public function deletes($id){
		$condition = array("id_header_penjualan" => $id);
		$res  = $this->all_model->deleteData("penjualan", $condition);
		if($res == true){
			// $this->session->set_flashdata('error', 'Data penjualan tidak berhasil dihapus');
			// redirect(base_url() . "penjualan/index");
			$result  = $this->all_model->deleteData("header_penjualan", $condition);
			if($result == true){
				$this->session->set_flashdata('success', 'Data penjualan berhasil dihapus');
			    redirect(base_url() . "penjualan/index");
			}
		}

		$this->session->set_flashdata('error', 'Data penjualan tidak berhasil dihapus');
		redirect(base_url() . "penjualan/index/" . $header_penjualan);
	}

	public function getItem(){
		$condition = array('id_item' => $this->input->get('id'));
    	$data = $this->all_model->getDataByCondition('item', $condition)->row();
    	echo json_encode($data); 
	}

	// public function edit_penjualan($id)
	// {
	// 	$condition = array('role' => 3, 'id_user' => $id);
	// 	$data['user'] = $this->all_model->getDataByCondition('user', $condition)->row();
	// 	$this->load->view('operator/edit', $data);
	// }
}
