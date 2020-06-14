<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('all_model');
	}

	public function index()
	{
		$data['customer'] = $this->all_model->getAllData('customer')->result();
		$this->load->view('customer/index', $data);
	}

	public function add()
	{
		$this->load->view('customer/add');
	}

	public function processAdd(){
		$this->form_validation->set_rules('first_name', 'Nama', 'required');
		$this->form_validation->set_rules('last_name', 'Alamat', 'required');

		$data = array(
			'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'address_1' => $this->input->post('address_1'),
            'address_2' => $this->input->post('address_2'),
            'phone_1' => $this->input->post('phone_1'),
            'phone_2' => $this->input->post('phone_2'),
            'status' => $this->input->post('status'),
            'email' => $this->input->post('email'),
            'created_date' => date('Y-m-d'),
            'created_by' => $this->session->userdata('id')
		);

		if($this->form_validation->run() == false){
			$this->load->view('customer/add');
		}else{
            // $result = $this->all_model->insertData("customer", $data);
            // if($result  == true){
            //     $this->session->set_flashdata('success', 'Data customer berhasil disimpan');
            //     redirect(base_url() . 'customer/index');
            // }else{
            //     $this->session->set_flashdata('error', 'Data customer tidak berhasil disimpan');
            //     redirect(base_url() . 'customer/add');
            // }
            $cek = $this->all_model->getFirstAndLast($this->input->post('first_name'), $this->input->post('last_name'))->row();
            if(empty($cek)){
            	$result = $this->all_model->insertData("customer", $data);
	            if($result  == true){
	                $this->session->set_flashdata('success', 'Data customer berhasil disimpan');
	                redirect(base_url() . 'customer/index');
	            }else{
	                $this->session->set_flashdata('error', 'Data customer tidak berhasil disimpan');
	                redirect(base_url() . 'customer/add');
	            }
            }else{
            	$this->session->set_flashdata('error', 'First and last name sudah tersedia');
            	redirect(base_url() . 'customer/add');
            }
		}
	}

	public function view($id)
	{
		$condition = array('id_customer' => $id);
		$data['customer'] = $this->all_model->getDataByCondition('customer', $condition)->row();
		$this->load->view('location/view', $data);
	}


	public function edit($id)
	{
		$condition = array('id_customer' => $id);
		$data['customer'] = $this->all_model->getDataByCondition('customer', $condition)->row();
		$this->load->view('customer/edit', $data);
	}

	public function processEdit(){
		$this->form_validation->set_rules('first_name', 'Nama', 'required');
		$this->form_validation->set_rules('last_name', 'Alamat', 'required');

		if($this->form_validation->run() == false){
			$this->load->view('customer/edit/' . $this->input->post('id'));
		}else{
			// $location = $this->all_model->getListDataByNama('location', 'nama_location', $this->input->post('nama'))->row();
			// if(($location->nama_location == $this->input->post('nama') && $location->id_location == $this->input->post('id')) || empty($location)){
			// 	$condition = array("id_location" => $this->input->post('id'));
			// 	$data = array(
			// 		'nama_location' => $this->input->post('nama'),
			// 		'alamat_location' => $this->input->post('alamat'),
			// 		'status' => $this->input->post('status')
			// 	);

			// 	$result = $this->all_model->updateData("location", $condition, $data);
			// 	if($result  == true){
			// 		$this->session->set_flashdata('success', 'Data location berhasil diubah');
			// 		redirect(base_url() . 'location/index');
			// 	}else{
			// 		$this->session->set_flashdata('error', 'Data location tidak berhasil diubah');
			// 		redirect(base_url() . 'location/edit/' . $this->input->post('id'));
			// 	}
			// }else{
			// 	$this->session->set_flashdata('error', 'Nama sudah tersedia');
			// 	redirect(base_url() . 'location/edit/' . $this->input->post('id'));
            // }
            $cek = $this->all_model->getFirstAndLast($this->input->post('first_name'), $this->input->post('last_name'))->row();

            $condition = array('id_customer' => $this->input->post('id'));
			$customer = $this->all_model->getDataByCondition('customer', $condition)->row();

			if($customer->first_name == $this->input->post('first_name') && $customer->last_name == $this->input->post('last_name') && $customer->id_customer == $this->input->post('id') || empty($cek)){
	            $condition = array("id_customer" => $this->input->post('id'));
	            $data = array(
	                'first_name' => $this->input->post('first_name'),
	                'last_name' => $this->input->post('last_name'),
	                'address_1' => $this->input->post('address_1'),
	                'address_2' => $this->input->post('address_2'),
	                'phone_1' => $this->input->post('phone_1'),
	                'phone_2' => $this->input->post('phone_2'),
	                'status' => $this->input->post('status'),
	                'email' => $this->input->post('email'),
	                'updated_date' => date('Y-m-d'),
	                'updated_by' => $this->session->userdata('id')
	            );
	            $result = $this->all_model->updateData("customer", $condition, $data);
	            if($result  == true){
	                $this->session->set_flashdata('success', 'Data customer berhasil diubah');
	                redirect(base_url() . 'customer/index');
	            }else{
	                $this->session->set_flashdata('error', 'Data customer tidak berhasil diubah');
	                redirect(base_url() . 'customer/edit/' . $this->input->post('id'));
	            }
	        }else{
	        	$this->session->set_flashdata('error', 'First and last name sudah tersedia');
            	redirect(base_url() . 'customer/edit/' . $this->input->post('id'));
	        }
		}
	}

	public function delete($id){
		$condition = array("id_customer" => $id);
		$res  = $this->all_model->deleteData("customer", $condition);
		if($res == false){
			$this->session->set_flashdata('error', 'Data customer berhasil dihapus');
			redirect(base_url() . "customer/index");
		}

		$this->session->set_flashdata('success', 'Data customer berhasil dihapus');
		redirect(base_url() . "customer/index");
	}
}
