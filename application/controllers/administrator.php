<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administrator extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('all_model');
		if($this->session->userdata('logged_in') != 1){
			return redirect(base_url() . 'login');
		}
	}

	public function index()
	{
		$condition = array('role' => 1, 'is_deleted' => 0);
		$data['user'] = $this->all_model->getDataByCondition('user', $condition)->result();
		$this->load->view('administrator/index', $data);
	}

	public function add()
	{
		$condition = array('status' => 1, 'is_deleted' => 0);
		$data['location'] = $this->all_model->getDataByCondition('location', $condition)->result();
		$this->load->view('administrator/add', $data);
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
			'role' => 1,
			'id_location' => $this->input->post('id_location'),
			'is_deleted' => 0
		);

		if($this->form_validation->run() == false){
			$input = array(
				'nama' => $this->input->post('nama'),
				'username' => $this->input->post('username'),
				'id_location' => $this->input->post('id_location')
			);

			$this->session->set_flashdata('inputs', $input);
			$this->session->set_flashdata('error', 'Data administrator tidak berhasil disimpan');
			$this->load->view('administrator/add');
		}else{
			$con = array('username' => $this->input->post('username'), 'role' => 1);
			$check = $this->all_model->getDataByCondition('user', $con)->num_rows();
			if($check > 0){
				$this->session->set_flashdata('error', 'Username sudah tersedia');
				redirect(base_url() . 'administrator/add');
			}else{
				$result = $this->all_model->insertData("user", $data);
				if($result  == true){
					$this->session->set_flashdata('success', 'Data administrator berhasil disimpan');
					redirect(base_url() . 'administrator/index');
				}else{
					$input = array(
						'nama' => $this->input->post('nama'),
						'username' => $this->input->post('username'),
						'id_location' => $this->input->post('id_location')
					);
		
					$this->session->set_flashdata('inputs', $input);
					$this->session->set_flashdata('error', 'Data administrator tidak berhasil disimpan');
					redirect(base_url() . 'administrator/add');
				}
			}
		}
	}

	public function view($id)
	{
		$condition = array('role' => 1, 'id_user' => $id);
		$data['user'] = $this->all_model->getDataByCondition('user', $condition)->row();

		$location = array('status' => 1);
		$data['location'] = $this->all_model->getDataByCondition('location', $location)->result();

		$this->load->view('administrator/view', $data);
	}


	public function edit($id)
	{
		$condition = array('role' => 1, "id_user" => $id);
		$data['user'] = $this->all_model->getDataByCondition('user', $condition)->row();

		$location = array('status' => 1, 'is_deleted' => 0);
		$data['location'] = $this->all_model->getDataByCondition('location', $location)->result();
		
		$this->load->view('administrator/edit', $data);
	}

	public function processEdit(){
		$condition = array('role' => 1, 'id_user' => $this->input->post('id'));
		$user = $this->all_model->getDataByCondition('user', $condition)->row();

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('id_location', 'Location', 'required');

		if($this->form_validation->run() == false){
			$input = array(
				'nama' => $this->input->post('nama'),
				'username' => $this->input->post('username'),
				'id_location' => $this->input->post('id_location')
			);

			$this->session->set_flashdata('inputs', $input);
			$this->session->set_flashdata('error', 'Data administrator tidak berhasil diubah');
			$this->load->view('administrator/edit/' . $this->input->post('id'));
		}else{
			$con = array('username' => $this->input->post('username'), 'role' => 1);
			$users = $this->all_model->getDataByCondition('user', $con)->row();
			
			if(($users->username == $this->input->post('username') && $users->id_user == $this->input->post('id') && (int)$users->role == 1) || empty($users)){
				$data = array(
					'nama' => $this->input->post('nama'),
					'username' => $this->input->post('username'),
					'password' => empty($this->input->post('password')) ? $user->password : md5($this->input->post('password')),
					'id_location' => $this->input->post('id_location')
				);

				$result = $this->all_model->updateData("user", $condition, $data);
				if($result  == true){
					$this->session->set_flashdata('success', 'Data administrator berhasil diubah');
					redirect(base_url() . 'administrator/index');
				}else{
					$input = array(
						'nama' => $this->input->post('nama'),
						'username' => $this->input->post('username'),
						'id_location' => $this->input->post('id_location')
					);
		
					$this->session->set_flashdata('inputs', $input);
					$this->session->set_flashdata('error', 'Data administrator tidak berhasil diubah');
					redirect(base_url() . 'administrator/edit/' . $this->input->post('id'));
				}
			}else{
				$input = array(
					'nama' => $this->input->post('nama'),
					'username' => $this->input->post('username'),
					'id_location' => $this->input->post('id_location')
				);
	
				$this->session->set_flashdata('inputs', $input);
				$this->session->set_flashdata('error', 'Username sudah tersedia');
				redirect(base_url() . 'administrator/edit/' . $this->input->post('id'));
			}
		}
	}

	public function delete($id){
		$condition = array('id_user' => $id);
		$data = array('is_deleted' => 1);
		$res  = $this->all_model->updateData('user', $condition, $data);
		if($res == false){
			$this->session->set_flashdata('error', 'Data administrator berhasil dihapus');
			redirect(base_url() . "administrator/index");
		}

		$this->session->set_flashdata('success', 'Data administrator berhasil dihapus');
		redirect(base_url() . "administrator/index");
	}
}
