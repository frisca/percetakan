<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('all_model');
	}

	public function index()
	{
		$this->load->view('login');
	}

	public function processLogin(){
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		$data = array(
			"username" => $this->input->post('username'),
			'password' => md5($this->input->post('password'))
		);

		if($this->form_validation->run() == false){
			$this->load->view('login');
		}else{
			$cek = $this->all_model->getDataByCondition("user", $data)->num_rows();
			if($cek  <= 0){
				$this->session->set_flashdata('error', 'Username dan password invalid');
				redirect(base_url());
			}

			$res = $this->all_model->getDataByCondition("user", $data)->row();
			$data_session = array(
				'username'  => $res->username,
				'nama'		=> $res->nama,
				'id'		=> $res->id_user,
				'logged_in' => 1,
				'role'		=> (int)$res->role,
				'location'  => $res->id_location
			);

			$this->session->set_userdata($data_session);
			redirect(base_url() . 'home/index');
		}
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url());
	}
}
