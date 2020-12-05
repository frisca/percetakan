<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('all_model');
		if($this->session->userdata('logged_in') != 1){
			return redirect(base_url() . 'login');
		}
	}

	public function index()
	{
		$data['item'] = $this->all_model->getListItem()->result();
		$this->load->view('item/index', $data);
	}

	public function add()
	{
		$condition = array('is_deleted' => 0, 'status' => 1);
		$data['satuan'] = $this->all_model->getDataByCondition('satuan', $condition)->result();
		$this->load->view('item/add', $data);
	}

	public function processAdd(){
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('id_satuan', 'Satuan', 'required');
		$this->form_validation->set_rules('hargas', 'Harga', 'required');

		$harga = str_replace(",", "", $this->input->post('hargas'));

		$data = array(
			'nama' => $this->input->post('nama'),
			'id_satuan' => $this->input->post('id_satuan'),
			'harga' => $harga,
			'is_design' => $this->input->post('is_design'),
			'is_deleted' => 0,
			'status' => $this->input->post('status')
		);

		if($this->form_validation->run() == false){
			$input = array(
				'nama' => $this->input->post('nama'),
				'id_satuan' => $this->input->post('id_satuan'),
				'harga' => $harga,
				'is_design' => $this->input->post('is_design'),
				'status' => $this->input->post('status')
			);

			$this->session->set_flashdata('inputs', $input);
			$this->session->set_flashdata('error', 'Data item tidak berhasil disimpan');
			redirect(base_url() . 'item/add');
		}else{
			$check = $this->all_model->getListDataByNama('item', 'nama', $this->input->post('nama'))->num_rows();
			if($check <= 0){
				$result = $this->all_model->insertData("item", $data);
				if($result  == true){
					$this->session->set_flashdata('success', 'Data item berhasil disimpan');
					redirect(base_url() . 'item/index');
				}else{
					$input = array(
						'nama' => $this->input->post('nama'),
						'id_satuan' => $this->input->post('id_satuan'),
						'harga' => $this->input->post('harga'),
						'is_design' => $this->input->post('is_design'),
						'status' => $this->input->post('status')
					);
		
					$this->session->set_flashdata('inputs', $input);
					$this->session->set_flashdata('error', 'Data item tidak berhasil disimpan');
					redirect(base_url() . 'item/add');
				}
			}else{
				$input = array(
					'nama' => $this->input->post('nama'),
					'id_satuan' => $this->input->post('id_satuan'),
					'harga' => $harga,
					'is_design' => $this->input->post('is_design'),
					'status' => $this->input->post('status')
				);
	
				$this->session->set_flashdata('inputs', $input);
				$this->session->set_flashdata('error', 'Nama sudah tersedia');
				redirect(base_url() . 'item/add');
			}
		}
	}

	public function edit($id)
	{
		// $data['satuan'] = $this->all_model->getAllData('satuan')->result();

		$condition = array('is_deleted' => 0, 'status' => 1);
		$data['satuan'] = $this->all_model->getDataByCondition('satuan', $condition)->result();
		$data['item'] = $this->all_model->getItemById($id)->row();
		$this->load->view('item/edit', $data);
	}

	public function processEdit(){
		$condition = array('id_item' => $this->input->post('id'));

		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('id_satuan', 'Satuan', 'required');
		$this->form_validation->set_rules('hargas', 'Harga', 'required');

		// $str = explode(',', $this->input->post('hargas'));
		// $harga = str_replace(".", "", $str[0]);

		$harga = str_replace(",", "", $this->input->post('hargas'));

		$old_item = $this->all_model->getDataByCondition('item', $condition)->row();
		$old_harga = $old_item->harga;

		$history = array(
			'harga' => $old_harga,
			'id_item' => $this->input->post('id'),
			'updated_by' => $this->session->userdata('id'),
			'updated_date' => date('Y-m-d')
		);

		$data = array(
			'nama' => $this->input->post('nama'),
			'id_satuan' => $this->input->post('id_satuan'),
			'harga' => $harga,
			'is_design' => $this->input->post('is_design'),
			'status' => $this->input->post('status')
		);

		if($this->form_validation->run() == false){
			$input = array(
				'nama' => $this->input->post('nama'),
				'id_satuan' => $this->input->post('id_satuan'),
				'harga' => $harga,
				'is_design' => $this->input->post('is_design'),
				'status' => $this->input->post('status')
			);

			$this->session->set_flashdata('inputs', $input);
			$this->load->view('item/edit/' . $this->input->post('id'));
		}else{
			$name = $this->all_model->getListDataByNama('item', 'nama', $this->input->post('nama'))->row();
			if(($name->nama == $this->input->post('nama') && $name->id_item == $this->input->post('id')) || empty($name)){
				$result = $this->all_model->updateData("item", $condition, $data);
				if($result  == true){
					// $insert_history = $this->all_model->insertData('history_price', $history);
					if($harga != $old_harga){
						$insert_history = $this->all_model->insertData('history_price', $history);
					}

					$this->session->set_flashdata('success', 'Data item berhasil diubah');
					redirect(base_url() . 'item/index');
				}else{
					$input = array(
						'nama' => $this->input->post('nama'),
						'id_satuan' => $this->input->post('id_satuan'),
						'harga' => $harga,
						'is_design' => $this->input->post('is_design'),
						'status' => $this->input->post('status')
					);
		
					$this->session->set_flashdata('inputs', $input);
					$this->session->set_flashdata('error', 'Data item tidak berhasil diubah');
					redirect(base_url() . 'item/edit/' . $this->input->post('id'));
				}
			}else{
				$input = array(
					'nama' => $this->input->post('nama'),
					'id_satuan' => $this->input->post('id_satuan'),
					'harga' => $this->input->post('harga'),
					'is_design' => $this->input->post('is_design'),
					'status' => $this->input->post('status')
				);
	
				$this->session->set_flashdata('inputs', $input);
				$this->session->set_flashdata('error', 'Nama sudah tersedia.');
				redirect(base_url() . 'item/edit/' . $this->input->post('id'));
			}
		}
	}


	public function delete(){
		$id = $this->input->post('id');
		$condition = array('id_item' => $id);
		$data = array('is_deleted' => 1);
		$res  = $this->all_model->updateData('item', $condition, $data);
		if($res == false){
			$this->session->set_flashdata('error', 'Data item berhasil dihapus');
			redirect(base_url() . "item/index");
		}

		$this->session->set_flashdata('success', 'Data item berhasil dihapus');
		redirect(base_url() . "item/index");
	}

	public function view($id)
	{
		$condition = array('id_item' => $id);
		$data['item'] = $this->all_model->getDataByCondition('item', $condition)->row();

		$condition = array('is_deleted' => 0, 'status' => 1);
		$data['satuan'] = $this->all_model->getDataByCondition('satuan', $condition)->result();
		$this->load->view('item/view', $data);
	}
}
