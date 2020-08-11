<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Satuan extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('all_model');
	}

	public function index()
	{
		$data['satuan'] = $this->all_model->getAllData('satuan')->result();
		$this->load->view('satuan/index', $data);
	}

	public function add()
	{
		$this->load->view('satuan/add');
	}

	public function processAdd(){
		$this->form_validation->set_rules('satuan', 'Satuan', 'required');

		$data = array(
			'satuan' => $this->input->post('satuan')
		);

		if($this->form_validation->run() == false){
			$input = array(
				'satuan' => $this->input->post('satuan')
			);

			$this->session->set_flashdata('inputs', $input);
			$this->load->view('satuan/add');
		}else{
			$check = $this->all_model->getListDataByNama('satuan', 'satuan', $this->input->post('satuan'))->num_rows();
			if($check <= 0){
				$result = $this->all_model->insertData("satuan", $data);
				if($result  == true){
					$this->session->set_flashdata('success', 'Data satuan berhasil disimpan');
					redirect(base_url() . 'satuan/index');
				}else{
					$input = array(
						'satuan' => $this->input->post('satuan')
					);
		
					$this->session->set_flashdata('inputs', $input);
					$this->session->set_flashdata('error', 'Data satuan tidak berhasil disimpan');
					redirect(base_url() . 'satuan/add');
				}
			}else{
				$input = array(
					'satuan' => $this->input->post('satuan')
				);
	
				$this->session->set_flashdata('inputs', $input);
				$this->session->set_flashdata('error', 'Satuan sudah tersedia');
				redirect(base_url() . 'satuan/add');
			}
		}
	}

	public function edit($id)
	{
		$condition = array('id_satuan' => $id);
		$data['satuan'] = $this->all_model->getDataByCondition('satuan', $condition)->row();
		$this->load->view('satuan/edit', $data);
	}

	public function processEdit(){
		$condition = array('id_satuan' => $this->input->post('id'));
		$user = $this->all_model->getDataByCondition('satuan', $condition)->row();

		$this->form_validation->set_rules('satuan', 'Satuan', 'required');

		if($this->form_validation->run() == false){
			$this->load->view('satuan/edit');
		}else{
			$satuan = $this->all_model->getListDataByNama('satuan', 'satuan', $this->input->post('satuan'))->row();
			if(($satuan->satuan == $this->input->post('satuan') && $name->id_item == $this->input->post('id')) || empty($satuan)){
				$data = array(
					'satuan' => $this->input->post('satuan')
				);

				$result = $this->all_model->updateData("satuan", $condition, $data);
				if($result  == true){
					$this->session->set_flashdata('success', 'Data satuan berhasil diubah');
					redirect(base_url() . 'satuan/index');
				}else{
					$input = array(
						'satuan' => $this->input->post('satuan')
					);
		
					$this->session->set_flashdata('inputs', $input);
					$this->session->set_flashdata('error', 'Data satuan tidak berhasil diubah');
					redirect(base_url() . 'satuan/edit/' . $this->input->post('id'));
				}
			}else{
				$input = array(
					'satuan' => $this->input->post('satuan')
				);
	
				$this->session->set_flashdata('inputs', $input);
				$this->session->set_flashdata('error', 'Satuan sudah tersedia');
				redirect(base_url() . 'satuan/edit/' . $this->input->post('id'));
			}
		}
	}

	public function view($id)
	{
		$condition = array('id_satuan' => $id);
		$data['satuan'] = $this->all_model->getDataByCondition('satuan', $condition)->row();
		$this->load->view('satuan/view', $data);
	}

	public function delete($id){
		$condition = array('id_satuan' => $id);
		$res  = $this->all_model->deleteData("satuan", $condition);
		if($res == false){
			$this->session->set_flashdata('error', 'Data satuan berhasil dihapus');
			redirect(base_url() . "satuan/index");
		}

		$this->session->set_flashdata('success', 'Data satuan berhasil dihapus');
		redirect(base_url() . "satuan/index");
	}

}
