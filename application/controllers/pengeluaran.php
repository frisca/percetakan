<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengeluaran extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('all_model');
	}

	public function index()
	{
		$condition = array('status_delete' => 0);
		$data['header_pengeluaran'] = $this->all_model->getDataByCondition('header_pengeluaran', $condition)->result();
		$this->load->view('pengeluaran/index', $data);
	}

	public function add(){
		$order = "id_header_pengeluaran desc";
		$header_pengeluaran = $this->all_model->getDataByLimitPengeluaran(array('status_delete'=>0), 1, $order, 'header_pengeluaran')->row();

		if(empty($header_pengeluaran)){
			$pengeluaran = $this->all_model->getDataByLimitPengeluaran(array('status_delete'=>1), 1, $order, 'header_pengeluaran')->row();
			if(empty($pengeluaran)){
				$data['id_header_pengeluaran'] = 1;
				$data['tgl_pengeluaran'] = date('Y-m-d');
			}else{
				$data['id_header_pengeluaran'] = $pengeluaran->id_header_pengeluaran + 1;
				$data['tgl_pengeluaran'] = date('Y-m-d');
			}
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

		$condition = array('id_user' => $this->session->userdata('id'));
		$data['user'] = $this->all_model->getDataByCondition('user', $condition)->row();
		$this->load->view('pengeluaran/add_pengeluaran_header', $data);
	}

	public function processAdd(){
		$data = array(
			'id_header_pengeluaran' => $this->input->post('id_header_pengeluaran'),
			'tgl_pengeluaran' => date('Y-m-d', strtotime($this->input->post('tgl_pengeluaran'))),
			'status'  => 0,
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
		$data['pengeluaran'] = $this->all_model->getDataByCondition('pengeluaran', array('status_delete' => 0))->result();
		$condition = array('id_user' => $this->session->userdata('id'));
		$data['user'] = $this->all_model->getDataByCondition('user', $condition)->row();
		$this->load->view('pengeluaran/add_pengeluaran', $data);
	}

	public function processAddPengeluaran(){
		$this->form_validation->set_rules('item', 'Nama item', 'required');
		$this->form_validation->set_rules('harga', 'Harga', 'required');

		if($this->form_validation->run() == false){
			return redirect(base_url() . 'pengeluaran/detail/' . $this->input->post('id_header_pengeluaran'));
		}else{ 
			$harga = str_replace(".", "", $this->input->post('harga'));
			$data = array(
				'item' => $this->input->post('item'),
				'price' => $harga,
				'keterangan' => $this->input->post('keterangan'),
				'status' => 0,
				'created_date' => date('Y-m-d'),
				'created_by' => $this->session->userdata('id'),
				'id_header_pengeluaran' => $this->input->post('id_header_pengeluaran')
			);
			$res = $this->all_model->insertData("pengeluaran", $data);
			if($res == true){
				$condition = array('id_header_pengeluaran' => $this->input->post('id_header_pengeluaran'));
				$res = $this->all_model->getDataByCondition('header_pengeluaran', $condition)->row();
				$total = $res->total + $harga;
				$dataHeaderPengeluaran = array(
					'total' => $total
				);
				// var_dump($dataHeaderPenjualan);exit();
				$headerPengeluaran = $this->all_model->updateData('header_pengeluaran', $condition, $dataHeaderPengeluaran);
				if($headerPengeluaran == true){
					$this->session->set_flashdata('success', 'Data item berhasil disimpan');
					redirect(base_url() . 'pengeluaran/detail/' . $this->input->post('id_header_pengeluaran'));
				}
				$this->session->set_flashdata('error', 'Data item tidak berhasil disimpan');
				redirect(base_url() . 'pengeluaran/detail/' . $this->input->post('id_header_pengeluaran'));
			}
			$this->session->set_flashdata('error', 'Data item tidak berhasil disimpan');
				redirect(base_url() . 'pengeluaran/detail/' . $this->input->post('id_header_pengeluaran'));
		}
	}

	public function edit(){
		$condition = array('id_pengeluaran' => $this->input->get('id'));
    	$data['pengeluaran'] = $this->all_model->getDataByCondition('pengeluaran', $condition)->row();
    	echo json_encode($data);
	}


	public function processEditPengeluaran(){
		$this->form_validation->set_rules('item', 'Nama item', 'required');
		$this->form_validation->set_rules('harga', 'Harga', 'required');

		$harga = str_replace(".", "", $this->input->post('harga'));

		$con = array('id_pengeluaran' => $this->input->post('id_pengeluaran'));
		$result = $this->all_model->getDataByCondition('pengeluaran', $con)->row();

		if($this->form_validation->run() == false){
			return redirect(base_url() . 'pengeluaran/detail/' . $this->input->post('id_header_pengeluaran'));
		}else{ 
			$condition = array('id_header_pengeluaran' => $this->input->post('id_header_pengeluaran'));
			$res = $this->all_model->getDataByCondition('header_pengeluaran', $condition)->row();

			$total = $res->total - $result->price + $harga;
			$dataHeaderPengeluaran = array(
				'total' => $total,
				'updated_date' => date('Y-m-d'),
				'updated_by' => $this->session->userdata('id')
			);

			$headerPengeluaran = $this->all_model->updateData('header_pengeluaran', $condition, $dataHeaderPengeluaran);
			if($headerPengeluaran == true){
				$data = array(
					'item' => $this->input->post('item'),
					'price' => $harga,
					'keterangan' => $this->input->post('keterangan'),
					'status' => 0,
					'updated_date' => date('Y-m-d'),
					'updated_by' => $this->session->userdata('id'),
					'id_header_pengeluaran' => $this->input->post('id_header_pengeluaran')
				);

				$res_pengeluaran = $this->all_model->updateData("pengeluaran", $condition, $data);
				if($res_pengeluaran == true){
					$this->session->set_flashdata('success', 'Data item berhasil disimpan');
					redirect(base_url() . 'pengeluaran/detail/' . $this->input->post('id_header_pengeluaran'));
				}
				$this->session->set_flashdata('error', 'Data item tidak berhasil disimpan');
				redirect(base_url() . 'pengeluaran/detail/' . $this->input->post('id_header_pengeluaran'));
			}
			$this->session->set_flashdata('error', 'Data item tidak berhasil disimpan');
			redirect(base_url() . 'pengeluaran/detail/' . $this->input->post('id_header_pengeluaran'));
		}
	}

	public function deleteItem(){
		$con = array('id_pengeluaran' => $this->input->post('id'));
		$pengeluaran = $this->all_model->getDataByCondition('pengeluaran', $con)->row();

		$condition = array('id_header_pengeluaran' => $pengeluaran->id_header_pengeluaran);
		$res = $this->all_model->getDataByCondition('header_pengeluaran', $condition)->row();

		$total = $res->total - $pengeluaran->price;
		$dataHeaderPengeluaran = array(
			'total' => $total
		);

		$headerPengeluaran = $this->all_model->updateData('header_pengeluaran', $condition, $dataHeaderPengeluaran);
		if($headerPengeluaran == true){
			$data = array(
				'status_delete' => 1,
				'deleted_by' => $this->session->userdata('id'),
				'deleted_date' => date('Y-m-d'),
				'keterangan_delete' => $this->input->post('keterangan_delete')
			);

			$res_pengeluaran = $this->all_model->updateData("pengeluaran", $con, $data);
			if($res_pengeluaran == true){
				$this->session->set_flashdata('success', 'Data item berhasil dihapus');
				redirect(base_url() . 'pengeluaran/detail/' . $pengeluaran->id_header_pengeluaran);
			}
			$this->session->set_flashdata('error', 'Data item tidak berhasil dihapus');
			redirect(base_url() . 'pengeluaran/detail/' . $pengeluaran->id_header_pengeluaran);
		}
		$this->session->set_flashdata('error', 'Data item tidak berhasil dihapus');
		redirect(base_url() . 'pengeluaran/detail/' . $pengeluaran->id_header_pengeluaran);
	}

	public function checkout($id){
		$condition = array('id_header_pengeluaran' => $id);
		$pengeluaran = array(
			'status' => 1
		);
		$header_pengeluaran = array(
			'status' => 1
		);

		$res_pengeluaran = $this->all_model->updateData('pengeluaran', $condition, $pengeluaran);
		if($res_pengeluaran == true){
			$res_header = $this->all_model->updateData('header_pengeluaran', $condition, $header_pengeluaran);
			if($res_header == true){
				$this->session->set_flashdata('success', 'Berhasil checkout');
				redirect(base_url() . 'pengeluaran/detail/' . $id);
			} 
			$this->session->set_flashdata('error', 'Gagal checkout');
			redirect(base_url() . 'pengeluaran/detail/' . $id);
		}
		$this->session->set_flashdata('error', 'Gagal checkout');
		redirect(base_url() . 'pengeluaran/detail/' . $id);
	}

	public function view($id){
		$condition = array('id_header_pengeluaran' => $id);
		$data['header_pengeluaran'] = $this->all_model->getDataByCondition('header_pengeluaran', $condition)->row();
		$data['pengeluaran'] = $this->all_model->getDataByCondition('pengeluaran', array('status_delete' => 0))->result();
		$condition = array('id_user' => $this->session->userdata('id'));
		$data['user'] = $this->all_model->getDataByCondition('user', $condition)->row();
		$this->load->view('pengeluaran/view_pengeluaran', $data);
	}

	public function delete(){
		$condition = array('id_header_pengeluaran' => $this->input->post('id'));
		$data = array(
			'status_delete' => 1,
			'keterangan_delete' => $this->input->post('keterangan'),
			'deleted_by'  => $this->session->userdata('id'),
			'deleted_date' => date('Y-m-d')
		);
		$res_header = $this->all_model->updateData('header_pengeluaran', $condition, $data);
		if($res_header == true){
			$this->session->set_flashdata('success', 'Data pengeluaran berhasil dihapus');
			redirect(base_url() . 'pengeluaran/index');
		} 
		$this->session->set_flashdata('error', 'Data pengeluaran gagal dihapus');
		redirect(base_url() . 'pengeluaran/index');
	}
}
