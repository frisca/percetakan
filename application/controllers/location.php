<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Location extends CI_Controller {
	public $data = array();
	 
	public function __construct() {
	 
		//parent::Controller();
		parent::__construct();
		 
		$this->load->helper('ckeditor_helper');
		 
		 
		//Ckeditor's configuration
		$this->data['ckeditor'] = array(
		 
		 	//ID of the textarea that will be replaced
		 	'id' => 'content',
			'path' => 'js/ckeditor',
		 
			 //Optionnal values
			 'config' => array(
			 'toolbar' => "Full", //Using the Full toolbar
			 'width' => "550px", //Setting a custom width
			 'height' => '100px', //Setting a custom height		 
		),
		 
		 //Replacing styles from the "Styles tool"
		 'styles' => array(
		 
		 //Creating a new style named "style 1"
		 'style 1' => array (
		 'name' => 'Blue Title',
		 'element' => 'h2',
		 'styles' => array(
		 'color' => 'Blue',
		 'font-weight' => 'bold'
		 )
		 ),
		 
		 //Creating a new style named "style 2"
		 'style 2' => array (
		 'name' => 'Red Title',
		 'element' => 'h2',
		 'styles' => array(
		 'color' => 'Red',
		 'font-weight' => 'bold',
		 'text-decoration' => 'underline'
		 )
		 ) 
		 )
		 );
		 
		 $this->data['ckeditor_2'] = array(
		 
		 //ID of the textarea that will be replaced
		 'id' => 'content_2',
		 'path' => 'js/ckeditor',
		 
		 //Optionnal values
		 'config' => array(
		 'width' => "100%", //Setting a custom width
		 'height' => '100px', //Setting a custom height
		 'toolbar' => array( //Setting a custom toolbar
		 array('Bold', 'Italic'),
		 array('Underline', 'Strike', 'FontSize'),
		 array('Smiley'),
		 '/'
		 )
		 ),
		 
		 //Replacing styles from the "Styles tool"
		 'styles' => array(
		 
		 //Creating a new style named "style 1"
		 'style 3' => array (
		 'name' => 'Green Title',
		 'element' => 'h3',
		 'styles' => array(
		 'color' => 'Green',
		 'font-weight' => 'bold'
		 )
		 )
		 
		 )
		 ); 
		$this->load->model('all_model');
		if($this->session->userdata('logged_in') != 1){
			return redirect(base_url() . 'login');
		}
	}

	// public function __construct(){
	// 	parent::__construct();
	// 	$this->load->model('all_model');
	// 	if($this->session->userdata('logged_in') != 1){
	// 		return redirect(base_url() . 'login');
	// 	}
	// }

	public function index()
	{
		// $data['location'] = $this->all_model->getAllData('location')->result();
		$condition = array('is_deleted' => 0);
		$data['location'] = $this->all_model->getDataByCondition('location', $condition)->result();
		$this->load->view('location/index', $data);
	}

	public function add()
	{
		$this->load->library('CKEditor');
 		$this->load->library('CKFinder');
 
 		//Add Ckfinder to Ckeditor
		$this->ckfinder->SetupCKEditor($this->ckeditor,'../../assets/ckfinder/');

		$kode_lokasi = $this->all_model->getKodeLocationByDesc()->row();
		if($kode_lokasi->code_location == "") {
			$kode = "01";
		}else{
			$kode = "0" . ((int) $kode_lokasi->code_location + 1);
		}

		$data['kode_lokasi'] = $kode;
		$this->load->view('location/add', $data);
	}

	public function processAdd(){
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('alamat', 'Alamat', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');
		$this->form_validation->set_rules('bank_account_name', 'Nama Rekening', 'required');
		$this->form_validation->set_rules('bank_account', 'Nama Bank', 'required');
		$this->form_validation->set_rules('bank_no', 'Nomor Rekening', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('tlp', 'Telepon', 'required');
		$this->form_validation->set_rules('ig', 'Instagram', 'required');

		$data = array(
			'name_location' => $this->input->post('nama'),
			'address_location' => $this->input->post('alamat'),
			'status' => $this->input->post('status'),
			'bank_account_name' => $this->input->post('bank_account_name'),
			'bank_account' => $this->input->post('bank_account'),
			'bank_no' => $this->input->post('bank_no'),
			'code_location' => $this->input->post('kode_lokasi'),
			'email' => $this->input->post('email'),
			'tlp' => $this->input->post('tlp'),
			'ig' => $this->input->post('ig'),
			'is_deleted' => 0
		);

		if($this->form_validation->run() == false){
			$input = array(
				'name_location' => $this->input->post('nama'),
				'address_location' => $this->input->post('alamat'),
				'status' => $this->input->post('status'),
				'bank_account_name' => $this->input->post('bank_account_name'),
				'bank_account' => $this->input->post('bank_account'),
				'bank_no' => $this->input->post('bank_no'),
				'code_location' => $this->input->post('kode_lokasi'),
				'email' => $this->input->post('email'),
				'tlp' => $this->input->post('tlp'),
				'ig' => $this->input->post('ig')
			);

			$this->session->set_flashdata('inputs', $input);
			$this->session->set_flashdata('error', 'Data lokasi tidak berhasil disimpan');
			redirect(base_url() . 'location/add');
		}else{
			$kode_lokasi = $this->all_model->getKodeLocationByDesc()->row();
			if($kode_lokasi->code_location == "") {
				$kode = "01";
			}else{
				$kode = "0" . ((int) $kode_lokasi->code_location + 1);
			}

			if($kode != $this->input->post('kode_lokasi')) {
				$input = array(
					'name_location' => $this->input->post('nama'),
					'address_location' => $this->input->post('alamat'),
					'status' => $this->input->post('status'),
					'bank_account_name' => $this->input->post('bank_account_name'),
					'bank_account' => $this->input->post('bank_account'),
					'bank_no' => $this->input->post('bank_no'),
					'code_location' => $this->input->post('kode_lokasi'),
					'email' => $this->input->post('email'),
					'tlp' => $this->input->post('tlp'),
					'ig' => $this->input->post('ig')
				);

				$this->session->set_flashdata('inputs', $input);
				$this->session->set_flashdata('error', 'Kode lokasi salah.');
				redirect(base_url() . 'location/add');
			}else{
				$check = $this->all_model->getListDataByNama('location', 'name_location', $this->input->post('nama'))->num_rows();
				if($check <= 0){
					$result = $this->all_model->insertData("location", $data);
					if($result  == true){
						$this->session->set_flashdata('success', 'Data location berhasil disimpan');
						redirect(base_url() . 'location/index');
					}else{
						$input = array(
							'name_location' => $this->input->post('nama'),
							'address_location' => $this->input->post('alamat'),
							'status' => $this->input->post('status'),
							'bank_account_name' => $this->input->post('bank_account_name'),
							'bank_account' => $this->input->post('bank_account'),
							'bank_no' => $this->input->post('bank_no'),
							'code_location' => $this->input->post('kode_lokasi'),
							'email' => $this->input->post('email'),
							'tlp' => $this->input->post('tlp'),
							'ig' => $this->input->post('ig')
						);
		
						$this->session->set_flashdata('inputs', $input);
						$this->session->set_flashdata('error', 'Data lokasi tidak berhasil disimpan');
						redirect(base_url() . 'location/add');
					}
				}else{
					$input = array(
						'name_location' => $this->input->post('nama'),
						'address_location' => $this->input->post('alamat'),
						'status' => $this->input->post('status'),
						'bank_account_name' => $this->input->post('bank_account_name'),
						'bank_account' => $this->input->post('bank_account'),
						'bank_no' => $this->input->post('bank_no'),
						'code_location' => $this->input->post('kode_lokasi'),
						'email' => $this->input->post('email'),
						'tlp' => $this->input->post('tlp'),
						'ig' => $this->input->post('ig')
					);

					$this->session->set_flashdata('inputs', $input);
					$this->session->set_flashdata('error', 'Nama sudah tersedia');
					redirect(base_url() . 'location/add');
				}
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
		$this->load->library('CKEditor');
 		$this->load->library('CKFinder');
 
 		//Add Ckfinder to Ckeditor
		$this->ckfinder->SetupCKEditor($this->ckeditor,'../../assets/ckfinder/');

		$condition = array('id_location' => $id);
		$data['location'] = $this->all_model->getDataByCondition('location', $condition)->row();
		$this->load->view('location/edit', $data);
	}

	public function processEdit(){
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('alamat', 'Alamat', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');
		$this->form_validation->set_rules('bank_account_name', 'Nama Rekening', 'required');
		$this->form_validation->set_rules('bank_account', 'Nama Bank', 'required');
		$this->form_validation->set_rules('bank_no', 'Nomor Rekening', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('tlp', 'Telepon', 'required');
		$this->form_validation->set_rules('ig', 'Instagram', 'required');

		if($this->form_validation->run() == false){
			$input = array(
				'name_location' => $this->input->post('nama'),
				'address_location' => $this->input->post('alamat'),
				'status' => $this->input->post('status'),
				'bank_account_name' => $this->input->post('bank_account_name'),
				'bank_account' => $this->input->post('bank_account'),
				'bank_no' => $this->input->post('bank_no'),
				'code_location' => $this->input->post('kode_lokasi'),
				'email' => $this->input->post('email'),
				'tlp' => $this->input->post('tlp'),
				'ig' => $this->input->post('ig')
			);

			$this->session->set_flashdata('inputs', $input);
			$this->session->set_flashdata('error', 'Data location tidak berhasil diubah');
			redirect(base_url() . 'location/edit/' . $this->input->post('id'));
		}else{
			$location = $this->all_model->getListDataByNama('location', 'name_location', $this->input->post('nama'))->row();
			if(($location->name_location == $this->input->post('nama') && $location->id_location == $this->input->post('id')) || empty($location)){
				$kode_lokasi = $this->all_model->getKodeLocationByDesc()->row();
				if($kode_lokasi->code_location == "") {
					$kode = "01";
				}else{
					$kode = "0" . ((int) $kode_lokasi->code_location + 1);
				}

				$condition = array("id_location" => $this->input->post('id'));
				$data = array(
					'name_location' => $this->input->post('nama'),
					'address_location' => $this->input->post('alamat'),
					'status' => $this->input->post('status'),
					'bank_account_name' => $this->input->post('bank_account_name'),
					'bank_account' => $this->input->post('bank_account'),
					'bank_no' => $this->input->post('bank_no'),
					'code_location' => $this->input->post('kode_lokasi'),
					'email' => $this->input->post('email'),
					'tlp' => $this->input->post('tlp'),
					'ig' => $this->input->post('ig')
				);

				$result = $this->all_model->updateData("location", $condition, $data);
				if($result  == true){
					$this->session->set_flashdata('success', 'Data location berhasil diubah');
					redirect(base_url() . 'location/index');
				}else{
					$input = array(
						'name_location' => $this->input->post('nama'),
						'address_location' => $this->input->post('alamat'),
						'status' => $this->input->post('status'),
						'bank_account_name' => $this->input->post('bank_account_name'),
						'bank_account' => $this->input->post('bank_account'),
						'bank_no' => $this->input->post('bank_no'),
						'code_location' => $this->input->post('kode_lokasi'),
						'email' => $this->input->post('email'),
						'tlp' => $this->input->post('tlp'),
						'ig' => $this->input->post('ig')
					);
	
					$this->session->set_flashdata('inputs', $input);
					$this->session->set_flashdata('error', 'Data location tidak berhasil diubah');
					redirect(base_url() . 'location/edit/' . $this->input->post('id'));
				}
			}else{
				$input = array(
					'name_location' => $this->input->post('nama'),
					'address_location' => $this->input->post('alamat'),
					'status' => $this->input->post('status'),
					'bank_account_name' => $this->input->post('bank_account_name'),
					'bank_account' => $this->input->post('bank_account'),
					'bank_no' => $this->input->post('bank_no'),
					'code_location' => $this->input->post('kode_lokasi'),
					'email' => $this->input->post('email'),
					'tlp' => $this->input->post('tlp'),
					'ig' => $this->input->post('ig')
				);

				$this->session->set_flashdata('inputs', $input);
				$this->session->set_flashdata('error', 'Nama sudah tersedia');
				redirect(base_url() . 'location/edit/' . $this->input->post('id'));
			}
		}
	}

	public function delete($id){
		$condition = array("id_location" => $id);
		$data = array('is_deleted' => 1);
		$res  = $this->all_model->updateData("location", $condition, $data);
		if($res == false){
			$this->session->set_flashdata('error', 'Data lokasi berhasil dihapus');
			redirect(base_url() . "location/index");
		}

		$this->session->set_flashdata('success', 'Data lokasi berhasil dihapus');
		redirect(base_url() . "location/index");
	}
}
