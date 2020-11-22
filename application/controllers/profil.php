<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profil extends CI_Controller {
    public function __construct(){
		parent::__construct();
		$this->load->model('all_model');
		if($this->session->userdata('logged_in') != 1){
			return redirect(base_url() . 'login');
		}
    }
    
	public function index()
	{
        $condition = array('id_user' => $this->session->userdata('id'));
		$data['user'] = $this->all_model->getDataByCondition('user', $condition)->row();

		$location = array('status' => 1);
		$data['location'] = $this->all_model->getDataByCondition('location', $location)->result();
		$this->load->view('profil/index', $data);
	}

	public function edit()
	{
		$condition = array("id_user" => $this->session->userdata('id'));
		$data['user'] = $this->all_model->getDataByCondition('user', $condition)->row();

		$location = array('status' => 1);
		$data['location'] = $this->all_model->getDataByCondition('location', $location)->result();
		
		$this->load->view('profil/edit', $data);
	}

	public function processEdit(){
		$condition = array('id_user' => $this->input->post('id'));
		$user = $this->all_model->getDataByCondition('user', $condition)->row();

		// $this->form_validation->set_rules('username', 'Username', 'required');
		// $this->form_validation->set_rules('nama', 'Nama', 'required');
		// $this->form_validation->set_rules('id_location', 'Location', 'required');

		if($this->form_validation->run() == false){
			// $input = array(
			// 	'nama' => $this->input->post('nama'),
			// 	'username' => $this->input->post('username'),
			// 	'id_location' => $this->input->post('id_location')
			// );

			// $this->session->set_flashdata('inputs', $input);
			// $this->load->view('profil/edit');
		}else{
			$con = array('username' => $this->input->post('username'));
			$users = $this->all_model->getDataByCondition('user', $con)->row();
			
			if(($users->username == $this->input->post('username') && $users->id_user == $this->input->post('id')) || empty($users)){
				$data = array(
					// 'nama' => $this->input->post('nama'),
					// 'username' => $this->input->post('username'),
					'password' => empty($this->input->post('password')) ? $user->password : md5($this->input->post('password'))
					// 'id_location' => $this->input->post('id_location')
				);

				$result = $this->all_model->updateData("user", $condition, $data);
				if($result  == true){
					$this->session->set_flashdata('success', 'Data profil berhasil diubah. Silahkan logout.');
					redirect(base_url() . 'profil/edit');
				}else{
					// $input = array(
					// 	'nama' => $this->input->post('nama'),
					// 	'username' => $this->input->post('username'),
					// 	'id_location' => $this->input->post('id_location')
					// );
		
					// $this->session->set_flashdata('inputs', $input);
					$this->session->set_flashdata('error', 'Data profil tidak berhasil diubah');
					redirect(base_url() . 'profil/edit/' . $this->input->post('id'));
				}
			}else{
				// $input = array(
				// 	'nama' => $this->input->post('nama'),
				// 	'username' => $this->input->post('username'),
				// 	'id_location' => $this->input->post('id_location')
				// );
	
				// $this->session->set_flashdata('inputs', $input);
				$this->session->set_flashdata('error', 'Username sudah tersedia');
				redirect(base_url() . 'profil/edit/' . $this->input->post('id'));
			}
		}
	}
}
