<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Operator extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('all_model');
	}

	public function index()
	{
		$condition = array('role' => 3);
		$data['user'] = $this->all_model->getDataByCondition('user', $condition)->result();
		$this->load->view('operator/index', $data);
	}

	public function add()
	{
		$location = array('status' => 1);
		$data['location'] = $this->all_model->getDataByCondition('location', $location)->result();
		$this->load->view('operator/add', $data);
	}

	public function processAdd(){
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('id_location', 'Location', 'required');

		$data = array(
			'nama' => $this->input->post('nama'),
			'username' => $this->input->post('username'),
			'password' => md5($this->input->post('password')),
			'role' => 3
		);

		if($this->form_validation->run() == false){
			$this->load->view('operator/add');
		}else{
			$result = $this->all_model->insertData("user", $data);
			if($result  == true){
				$this->session->set_flashdata('success', 'Data operator berhasil disimpan');
				redirect(base_url() . 'operator/index');
			}else{
				$this->session->set_flashdata('error', 'Data operator tidak berhasil disimpan');
				redirect(base_url() . 'operator/add');
			}
		}
	}

	public function view($id)
	{
		$condition = array('role' => 3, 'id_user' => $id);
		$data['user'] = $this->all_model->getDataByCondition('user', $condition)->row();

		$location = array('status' => 1);
		$data['location'] = $this->all_model->getDataByCondition('location', $location)->result();
		$this->load->view('operator/view', $data);
	}


	public function edit($id)
	{
		$condition = array('role' => 3, 'id_user' => $id);
		$data['user'] = $this->all_model->getDataByCondition('user', $condition)->row();

		$condition = array('status' => 1);
		$data['location'] = $this->all_model->getDataByCondition('location', $condition)->result();
		$this->load->view('operator/edit', $data);
	}

	public function processEdit(){
		$condition = array('role' => 3, 'id_user' => $this->input->post('id'));
		$user = $this->all_model->getDataByCondition('user', $condition)->row();

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('id_location', 'Location', 'required');

		if($this->form_validation->run() == false){
			$this->load->view('operator/edit');
		}else{
			$data = array(
				'nama' => $this->input->post('nama'),
				'username' => $this->input->post('username'),
				'password' => empty($this->input->post('password')) ? $user->password : md5($this->input->post('password'))
			);

			$result = $this->all_model->updateData("user", $condition, $data);
			if($result  == true){
				$this->session->set_flashdata('success', 'Data operator berhasil diubah');
				redirect(base_url() . 'operator/index');
			}else{
				$this->session->set_flashdata('error', 'Data operator tidak berhasil diubah');
				redirect(base_url() . 'operator/edit');
			}
		}
		redirect(base_url() . 'operator/edit');
	}

	public function delete($id){
		$condition = array("id_user" => $id);
		$res  = $this->all_model->deleteData("user", $condition);
		if($res == false){
			$this->session->set_flashdata('error', 'Data operator berhasil dihapus');
			redirect(base_url() . "operator/index");
		}

		$this->session->set_flashdata('success', 'Data operator berhasil dihapus');
		redirect(base_url() . "operator/index");
	}
}
