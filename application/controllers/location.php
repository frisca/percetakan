<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Location extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('all_model');
	}

	public function index()
	{
		$data['location'] = $this->all_model->getAllData('location')->result();
		$this->load->view('location/index', $data);
	}

	public function add()
	{
		$this->load->view('location/add');
	}

	public function processAdd(){
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('alamat', 'Alamat', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');

		$data = array(
			'nama_location' => $this->input->post('nama'),
			'alamat_location' => $this->input->post('alamat'),
			'status' => $this->input->post('status')
		);

		if($this->form_validation->run() == false){
			$this->load->view('location/add');
		}else{
			$result = $this->all_model->insertData("location", $data);
			if($result  == true){
				$this->session->set_flashdata('success', 'Data location berhasil disimpan');
				redirect(base_url() . 'location/index');
			}else{
				$this->session->set_flashdata('error', 'Data location tidak berhasil disimpan');
				redirect(base_url() . 'location/add');
			}
		}
	}

	public function view($id)
	{
		$condition = array('id_location' => $id);
		$data['location'] = $this->all_model->getDataByCondition('location', $condition)->row();
		$this->load->view('location/view', $data);
	}


	public function edit($id)
	{
		$condition = array('id_location' => $id);
		$data['location'] = $this->all_model->getDataByCondition('location', $condition)->row();
		$this->load->view('location/edit', $data);
	}

	public function processEdit(){
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('alamat', 'Alamat', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');

		if($this->form_validation->run() == false){
			$this->load->view('location/edit');
		}else{
			$condition = array("id_location" => $this->input->post('id'));
			$data = array(
				'nama_location' => $this->input->post('nama'),
				'alamat_location' => $this->input->post('alamat'),
				'status' => $this->input->post('status')
			);

			$result = $this->all_model->updateData("location", $condition, $data);
			if($result  == true){
				$this->session->set_flashdata('success', 'Data location berhasil diubah');
				redirect(base_url() . 'location/index');
			}else{
				$this->session->set_flashdata('error', 'Data location tidak berhasil diubah');
				redirect(base_url() . 'location/edit');
			}
		}
		redirect(base_url() . 'location/edit');
	}

	public function delete($id){
		$condition = array("id_location" => $id);
		$res  = $this->all_model->deleteData("location", $condition);
		if($res == false){
			$this->session->set_flashdata('error', 'Data location berhasil dihapus');
			redirect(base_url() . "location/index");
		}

		$this->session->set_flashdata('success', 'Data location berhasil dihapus');
		redirect(base_url() . "location/index");
	}
}
