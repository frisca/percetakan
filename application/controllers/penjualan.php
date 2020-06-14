<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penjualan extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('all_model');
	}

	public function index()
	{
		$data['header_penjualan'] = $this->all_model->getDataByCondition('header_penjualan', array('status_delete' => 0))->result();
		$this->load->view('penjualan/index', $data);
	}

	public function add(){
		$order = "id_header_penjualan desc";
		$header_penjualan = $this->all_model->getDataByLimit(1, $order, 'header_penjualan')->row();

		if(empty($header_penjualan)){
			$data['id_header_penjualan'] = 1;
			$data['tgl_penjualan'] = date('d-m-Y');
		}else{
			$data['id_header_penjualan'] = $header_penjualan->id_header_penjualan + 1;
			$data['tgl_penjualan'] = date('d-m-Y');
		}

		$data['item'] = $this->all_model->getAllData('item')->result();
		$data['satuan'] = $this->all_model->getAllData('satuan')->result();
		$data['customer'] = $this->all_model->getDataByCondition('customer', array('status' => 1))->result();

		$condition = array('id_user' => $this->session->userdata('id'));
		$data['user'] = $this->all_model->getDataByCondition('user', $condition)->row();
		$this->load->view('penjualan/add_penjualan_header', $data);
	}

	public function processAdd(){
		$data = array(
			'id_header_penjualan' => $this->input->post('id_header_penjualan'),
			'tgl_penjualan' => date('Y-m-d', strtotime(strtr($this->input->post('tgl_penjualan'), '-', '-'))),
			'status'  => 0,
			'createdBy' => $this->session->userdata('id'),
			'createdDate' => date('Y-m-d H:i:s', strtotime(strtr($this->input->post('createdDate'), '-', '-'))),
			'id_customer' => $this->input->post('id_customer')
		);

		$result = $this->all_model->insertData('header_penjualan', $data);
		if($result == true){
			$order = "id_header_penjualan desc";
		    $header_penjualan = $this->all_model->getDataByLimit(1, $order, 'header_penjualan')->row();
		    return redirect(base_url().'penjualan/detail/' . $header_penjualan->id_header_penjualan);
		}
		return redirect(base_url() . 'penjualan/add');
	}

	public function detail($id){
		$condition = array('id_header_penjualan' => $id);
		$data['header_penjualan'] = $this->all_model->getDataByCondition('header_penjualan', $condition)->row();
		// var_dump($data);exit();
		$data['penjualan'] = $this->all_model->getPenjualanByHeaderPenjualan($id)->result();
		$data['counts'] = $this->all_model->getPenjualanByStatusHeaderPenjualan($id)->num_rows();
		$data['item'] = $this->all_model->getAllData('item')->result();
		$data['satuan'] = $this->all_model->getAllData('satuan')->result();

		$condition = array('id_user' => $this->session->userdata('id'));
		$data['user'] = $this->all_model->getDataByCondition('user', $condition)->row();
		$data['customer'] = $this->all_model->getDataByCondition('customer', array('status' => 1))->result();
		$this->load->view('penjualan/add_penjualan', $data);
	}

	public function processAddPenjualan(){
		$this->form_validation->set_rules('id_item', 'Nama item', 'required');
		$this->form_validation->set_rules('id_satuan', 'Satuan', 'required');
		$this->form_validation->set_rules('harga_satuan', 'Harga Satuan', 'required');
		$this->form_validation->set_rules('jmlh', 'Jumlah', 'required');
		$this->form_validation->set_rules('total_harga', 'Total Harga', 'required');


		if($this->form_validation->run() == false){
			return redirect(base_url() . 'penjualan/detail/' . $this->input->post('id_header_penjualan'));
		}else{ 

			$str = explode(',', $this->input->post('harga_satuan'));
			$harga = str_replace(".", "", $str[0]);

			if(!$_FILES['line_item']['name']){

				if((int)$this->input->post('metode_pembayaran') == 0){
					$status_pembayaran = 0;
				}else if((int)$this->input->post('metode_pembayaran') == 1){
					$status_pembayaran = 1;
				}else{
					$status_pembayaran = 2;
				}

				$datas = array(
					'id_item' => $this->input->post('id_item'),
					'id_satuan' => $this->input->post('id_satuan'),
					'qty' => $this->input->post('jmlh'),
					'harga_satuan' => $harga,
					'total_harga' => $this->input->post('total_harga'),
					'status' => 0,
					'created_date' => date('Y-m-d'),
					'created_by' => $this->session->userdata('id'),
					'id_header_penjualan' => $this->input->post('id_header_penjualan'),
					'id_user' => $this->session->userdata('id'),
					'keterangan' => $this->input->post('keterangan')
				);

				$result = $this->all_model->insertData("penjualan", $datas);
				if($result  == true){
					$condition = array('id_header_penjualan' => $this->input->post('id_header_penjualan'));
					$res = $this->all_model->getDataByCondition('header_penjualan', $condition)->row();

					$total = $res->total + $this->input->post('total_harga');
					$grandTotal = $total - $this->input->post('discount');

					$dataHeaderPenjualan = array(
						'total' => $total,
						'grandtotal' => $grandTotal,
						'discount' => $this->input->post('discount'),
						'metode_pembayaran' => $this->input->post('metode_pembayaran'),
						'status_pembayaran' => $status_pembayaran,
						'updatedBy' => $this->session->userdata('id'),
						'updatedDate' => date('Y-m-d H:i:s', strtotime(strtr($this->input->post('updatedDate'), '-', '-'))),
						'tgl_penjualan' => date('Y-m-d', strtotime(strtr($this->input->post('tgl_penjualan'), '-', '-'))),
						'id_customer' => $this->input->post('customers')
					);
					// var_dump($dataHeaderPenjualan);exit();
					$headerPenjualan = $this->all_model->updateData('header_penjualan', $condition, $dataHeaderPenjualan);
					if($headerPenjualan == true){
						$this->session->set_flashdata('success', 'Data item berhasil disimpan');
						redirect(base_url() . 'penjualan/detail/' . $this->input->post('id_header_penjualan'));
					}
					$this->session->set_flashdata('error', 'Data item tidak berhasil disimpan');
					redirect(base_url() . 'penjualan/detail/' . $this->input->post('id_header_penjualan'));
				}else{
					$this->session->set_flashdata('error', 'Data item tidak berhasil disimpan');
					redirect(base_url() . 'penjualan/detail/' . $this->input->post('id_header_penjualan'));
				}
			}else{
				$new_name                   = time().$_FILES["line_item"]['name'];
		        $config['file_name']        = $new_name;
				$config['upload_path']      = './gambar/';
				$config['allowed_types']    = 'gif|jpg|png';

				$this->load->library('upload', $config);
		 
				if ( ! $this->upload->do_upload('line_item')){
					$this->session->set_flashdata('error', 'Data item tidak berhasil disimpan');
					redirect(base_url() . 'penjualan/detail/' . $this->input->post('id_header_penjualan'));
				}

				$datas = array(
					'id_item' => $this->input->post('id_item'),
					'id_satuan' => $this->input->post('id_satuan'),
					'qty' => $this->input->post('jmlh'),
					'harga_satuan' => $harga,
					'total_harga' => $this->input->post('total_harga'),
					'status' => 0,
					'created_date' => date('Y-m-d'),
					'created_by' => $this->session->userdata('id'),
					'id_header_penjualan' => $this->input->post('id_header_penjualan'),
					'id_user' => $this->session->userdata('id'),
					'line_item' => $new_name,
					'keterangan' => $this->input->post('keterangan')
				);

				$result = $this->all_model->insertData("penjualan", $datas);
				if($result  == true){
					$condition = array('id_header_penjualan' => $this->input->post('id_header_penjualan'));
					$res = $this->all_model->getDataByCondition('header_penjualan', $condition)->row();

					$total = $res->total + $this->input->post('total_harga');
					$grandTotal = $total - $res->discount;

					if((int)$this->input->post('metode_pembayaran') == 0){
						$status_pembayaran = 0;
					}else if((int)$this->input->post('metode_pembayaran') == 1){
						$status_pembayaran = 1;
					}else{
						$status_pembayaran = 2;
					}

					$dataHeaderPenjualan = array(
						'total' => $total,
						'grandtotal' => $grandTotal,
						'discount' => $this->input->post('discount'),
						'grandtotal' => $this->input->post('grandtotal'),
						'metode_pembayaran' => $this->input->post('metode_pembayaran'),
						'status_pembayaran' => $status_pembayaran,
						'updatedBy' => $this->session->userdata('id'),
						'updatedDate' => date('Y-m-d H:i:s', strtotime(strtr($this->input->post('updatedDate'), '-', '-'))),
						'tgl_penjualan' => date('Y-m-d', strtotime(strtr($this->input->post('tgl_penjualan'), '-', '-'))),
						'id_customer' => $this->input->post('customers')
					);

					$headerPenjualan = $this->all_model->updateData('header_penjualan', $condition, $dataHeaderPenjualan);
					if($headerPenjualan == true){
						$this->session->set_flashdata('success', 'Data item berhasil disimpan');
						redirect(base_url() . 'penjualan/detail/' . $this->input->post('id_header_penjualan'));
					}
					$this->session->set_flashdata('error', 'Data item tidak berhasil disimpan');
					redirect(base_url() . 'penjualan/detail/' . $this->input->post('id_header_penjualan'));
				}else{
					$this->session->set_flashdata('error', 'Data item tidak berhasil disimpan');
					redirect(base_url() . 'penjualan/detail/' . $this->input->post('id_header_penjualan'));
				}
			}
		}	
	}


	// public function checkout($id, $id_header_penjualan){
	// 	$condition = array('id_penjualan' => $id);
	// 	$data = array('status' => 1);
	// 	$res = $this->all_model->updateData('penjualan', $condition, $data);
	// 	if($res == false){
	// 		return redirect(base_url().'penjualan/detail/' . $id_header_penjualan);
	// 	}
	// 	return redirect(base_url().'penjualan/detail/' . $id_header_penjualan);
	// }

	public function checkout($id){
		$condition = array('id_header_penjualan' => $id);
		$data = array('status' => 1);
		$res = $this->all_model->updateData('penjualan', $condition, $data);
		if($res == false){
			$this->session->set_flashdata('error', 'Data penjualan tidak tersimpan');
			return redirect(base_url().'penjualan/detail/' . $id);
		}
		$tahun = date('y');
		$bulan = date('m');

		if((int)$this->input->post('metode_pembayaran') == 0){
			$status_pembayaran = 0;
		}else if((int)$this->input->post('metode_pembayaran') == 1){
			$status_pembayaran = 1;
		}else{
			$status_pembayaran = 2;
		}

		$con = array('id_user' => $this->session->userdata('id'));
		$user = $this->all_model->getDataByCondition('user', $con)->row();

		// $cons = array('id_location' => $user->id_location);
		// $location = $this->all_model->getDataByCondition('location', $cons)->row();

		$datas = array(
			'metode_pembayaran' => $this->input->post('metode_pembayaran'),
			'discount' => $this->input->post('discount'),
			'grandtotal' => $this->input->post('grandtotal'),
			'status_pembayaran' => $status_pembayaran,
			'status' => 1,
			'updatedBy' => $this->session->userdata('id'),
			'updatedDate' => date('Y-m-d H:i:s', strtotime(strtr($this->input->post('updatedDate'), '-', '-'))),
			'tgl_penjualan' => date('Y-m-d', strtotime(strtr($this->input->post('tgl_penjualan'), '-', '-'))),
			'nomor_penjualan' => sprintf('%02d', $user->id_location) . '/INV/' . $tahun . '/' . $bulan . '/' . sprintf('%04d', $id),
			'id_customer' => $this->input->post('customers')
		);
		$result = $this->all_model->updateData('header_penjualan', $condition, $datas);
		if($result == false){
			$this->session->set_flashdata('error', 'Data penjualan tidak disimpan');
			return redirect(base_url().'penjualan/detail/' . $id);
		}
		return redirect(base_url().'penjualan/index');
	}

	public function edit(){
		$condition = array('id_penjualan' => $this->input->get('id'));
    	$penjualan = $this->all_model->getDataByCondition('penjualan', $condition)->row();
    	$penjualan->harga_satuan = number_format($penjualan->harga_satuan, 0,'','.');
    	$penjualan->total_harga = number_format($penjualan->total_harga, 0,'','.');
    	$data['penjualan'] = $penjualan;
    	$data['item'] = $this->all_model->getAllData('item')->result();
    	$data['satuan'] = $this->all_model->getAllData('satuan')->result();
    	$data['design'] = $this->all_model->getIsDesign($this->input->get('id'))->row();
    	echo json_encode($data); 
	}

	public function processEditPenjualan(){
		$con = array('id_penjualan' => $this->input->post('id_penjualan'));
		$penjualan = $this->all_model->getDataByCondition('penjualan', $con)->row();

		$this->form_validation->set_rules('id_item', 'Nama item', 'required');
		$this->form_validation->set_rules('id_satuan', 'Satuan', 'required');
		$this->form_validation->set_rules('harga_satuan', 'Harga Satuan', 'required');
		$this->form_validation->set_rules('qty', 'Jumlah', 'required');
		$this->form_validation->set_rules('total_harga', 'Total Harga', 'required');

		if($this->form_validation->run() == false){
			return redirect(base_url() . 'penjualan/detail/' . $this->input->post('id_header_penjualan'));
		}else{
			$condition = array('id_header_penjualan' => $this->input->post('id_header_penjualan'));
			$res = $this->all_model->getDataByCondition('header_penjualan', $condition)->row();

			$total = $res->total - $penjualan->total_harga + $this->input->post('total_harga');
			$grandTotal = $total - $this->input->post('discount');

			if((int)$this->input->post('metode_pembayaran') == 0){
				$status_pembayaran = 0;
			}else if((int)$this->input->post('metode_pembayaran') == 1){
				$status_pembayaran = 1;
			}else{
				$status_pembayaran = 2;
			}

			if($grandTotal >= $res->dp1 && $grandTotal > 0){
				if((int)$res->sisa_pembayaran == 0){
					$dataHeaderPenjualan = array(
						'total' => $total,
						'grandtotal' => $grandTotal,
						'discount' => $this->input->post('discount'),
						'metode_pembayaran' => $this->input->post('metode_pembayaran'),
						'status_pembayaran' => $status_pembayaran,
						'updatedBy' => $this->session->userdata('id'),
						'updatedDate' => date('Y-m-d H:i:s', strtotime(strtr($this->input->post('updatedDate'), '-', '-'))),
						'tgl_penjualan' => date('Y-m-d', strtotime(strtr($this->input->post('tgl_penjualan'), '-', '-'))),
						'id_customer' => $this->input->post('customers')
					);
				}else{
					$dataHeaderPenjualan = array(
						'total' => $total,
						'grandtotal' => $grandTotal,
						'discount' => $this->input->post('discount'),
						'metode_pembayaran' => $this->input->post('metode_pembayaran'),
						'status_pembayaran' => $status_pembayaran,
						'updatedBy' => $this->session->userdata('id'),
						'updatedDate' => date('Y-m-d H:i:s', strtotime(strtr($this->input->post('updatedDate'), '-', '-'))),
						'tgl_penjualan' => date('Y-m-d', strtotime(strtr($this->input->post('tgl_penjualan'), '-', '-'))),
						'sisa_pembayaran' => $grandTotal - $res->dp1,
						'id_customer' => $this->input->post('customers')
					);
				}
			}

			$con_item = array('id_item' => $this->input->post('id_item'));
			$items = $this->all_model->getDataByCondition('item', $con_item)->row();

			if($items->is_design == 1){
				if(!$_FILES['line_item']['name']){
					$datas = array(
						'id_item' => $this->input->post('id_item'),
						'id_satuan' => $this->input->post('id_satuan'),
						'qty' => $this->input->post('qty'),
						'harga_satuan' => $this->input->post('harga_satuan'),
						'total_harga' => $this->input->post('total_harga'),
						'updated_date' => date('Y-m-d'),
						'updated_by' => $this->session->userdata('id'),
						'keterangan' => $this->input->post('keterangan')
					);

					$result = $this->all_model->updateData("penjualan", $con, $datas);
					if($result  == true){
						$headerPenjualan = $this->all_model->updateData('header_penjualan', $condition, $dataHeaderPenjualan);
						if($headerPenjualan == true){
							$this->session->set_flashdata('success', 'Data item berhasil disimpan');
							redirect(base_url() . 'penjualan/detail/' . $this->input->post('id_header_penjualan'));
						}
						$this->session->set_flashdata('error', 'Data penjualan tidak berhasil diubah');
						redirect(base_url() . 'penjualan/detail/' . $this->input->post('id_header_penjualan'));
					}else{
						$this->session->set_flashdata('error', 'Data penjualan tidak berhasil diubah');
						redirect(base_url() . 'penjualan/detail/' . $this->input->post('id_header_penjualan'));
					}
				}else{
					unlink(FCPATH."gambar/".$penjualan->line_item);

					$new_name                   = time().$_FILES["line_item"]['name'];
			        $config['file_name']        = $new_name;
					$config['upload_path']      = './gambar/';
					$config['allowed_types']    = 'gif|jpg|png';

					$this->load->library('upload', $config);
			 
					if ( ! $this->upload->do_upload('line_item')){
						$this->session->set_flashdata('error', 'Data item tidak berhasil disimpan');
						redirect(base_url() . 'penjualan/detail/' . $this->input->post('id_header_penjualan'));
					}
					$datas = array(
						'id_item' => $this->input->post('id_item'),
						'id_satuan' => $this->input->post('id_satuan'),
						'qty' => $this->input->post('qty'),
						'harga_satuan' => $this->input->post('harga_satuan'),
						'total_harga' => $this->input->post('total_harga'),
						'updated_date' => date('Y-m-d'),
						'updated_by' => $this->session->userdata('id'),
						'line_item' => $new_name,
						'keterangan' => $this->input->post('keterangan')
					);
					$result = $this->all_model->updateData("penjualan", $con, $datas);
					if($result  == true){
						$headerPenjualan = $this->all_model->updateData('header_penjualan', $condition, $dataHeaderPenjualan);
						if($headerPenjualan == true){
							$this->session->set_flashdata('success', 'Data item berhasil disimpan');
							redirect(base_url() . 'penjualan/detail/' . $this->input->post('id_header_penjualan'));
						}
						$this->session->set_flashdata('error', 'Data penjualan tidak berhasil diubah');
						redirect(base_url() . 'penjualan/detail/' . $this->input->post('id_header_penjualan'));
					}else{
						$this->session->set_flashdata('error', 'Data penjualan tidak berhasil diubah');
						redirect(base_url() . 'penjualan/detail/' . $this->input->post('id_header_penjualan'));
					}
				}
			}else{
				unlink(FCPATH."gambar/".$penjualan->line_item);

				$datas = array(
					'id_item' => $this->input->post('id_item'),
					'id_satuan' => $this->input->post('id_satuan'),
					'qty' => $this->input->post('qty'),
					'harga_satuan' => $this->input->post('harga_satuan'),
					'total_harga' => $this->input->post('total_harga'),
					'updated_date' => date('Y-m-d'),
					'updated_by' => $this->session->userdata('id'),
					'keterangan' => $this->input->post('keterangan'),
					'line_item' => ''
				);

				$result = $this->all_model->updateData("penjualan", $con, $datas);
				if($result  == true){
					$headerPenjualan = $this->all_model->updateData('header_penjualan', $condition, $dataHeaderPenjualan);
					if($headerPenjualan == true){
						$this->session->set_flashdata('success', 'Data item berhasil disimpan');
						redirect(base_url() . 'penjualan/detail/' . $this->input->post('id_header_penjualan'));
					}
					$this->session->set_flashdata('error', 'Data penjualan tidak berhasil diubah');
					redirect(base_url() . 'penjualan/detail/' . $this->input->post('id_header_penjualan'));
				}else{
					$this->session->set_flashdata('error', 'Data penjualan tidak berhasil diubah');
					redirect(base_url() . 'penjualan/detail/' . $this->input->post('id_header_penjualan'));
				}
			}
		}	
	}

	// public function delete($id, $header_penjualan){
	// 	$condition = array("id_penjualan" => $id);
	// 	$penjualan = $this->all_model->getDataByCondition('penjualan', $condition)->row();

	// 	$con = array('id_header_penjualan' => $header_penjualan);
	// 	$res = $this->all_model->getDataByCondition('header_penjualan', $con)->row();

	// 	$total = $res->total - $penjualan->total_harga;
	// 	$grandTotal = $total - $res->discount;

	// 	if($grandTotal >= $res->dp1 && $grandTotal > 0){
	// 		if((int)$res->sisa_pembayaran == 0)
	// 		{
	// 			$dataHeaderPenjualan = array(
	// 				'total' => $total,
	// 				'grandtotal' => $grandTotal
	// 			);
	// 		}else{
	// 			$dataHeaderPenjualan = array(
	// 				'total' => $total,
	// 				'grandtotal' => $grandTotal, 
	// 				'sisa_pembayaran' => $grandTotal - $res->dp1
	// 			);
	// 		}
	// 	}

	// 	$headerPenjualan = $this->all_model->updateData('header_penjualan', $con, $dataHeaderPenjualan);
	// 	if($headerPenjualan == true){
	// 		$res  = $this->all_model->deleteData("penjualan", $condition);
	// 		if($res == false){
	// 			$this->session->set_flashdata('error', 'Data penjualan berhasil dihapus');
	// 			redirect(base_url() . "penjualan/detail/" . $header_penjualan);
	// 		}
	// 		$this->session->set_flashdata('success', 'Data penjualan berhasil dihapus');
	// 		redirect(base_url() . "penjualan/detail/" . $header_penjualan);
	// 	}
	// 	$this->session->set_flashdata('error', 'Data penjualan berhasil dihapus');
	// 	redirect(base_url() . "penjualan/detail/" . $header_penjualan);
	// }

	public function view($id){
		$condition = array('id_header_penjualan' => $id);
		$data['header_penjualan'] = $this->all_model->getDataByCondition('header_penjualan', $condition)->row();
		// var_dump($data);exit();
		$data['penjualan'] = $this->all_model->getPenjualanByHeaderPenjualan($id)->result();
		$data['counts'] = $this->all_model->getPenjualanByStatusHeaderPenjualan($id)->num_rows();
		$data['item'] = $this->all_model->getAllData('item')->result();
		$data['satuan'] = $this->all_model->getAllData('satuan')->result();

		$condition = array('id_user' => $this->session->userdata('id'));
		$data['user'] = $this->all_model->getDataByCondition('user', $condition)->row();
		$data['customer'] = $this->all_model->getDataByCondition('customer', array('status' => 1))->result();
		$this->load->view('penjualan/view_penjualan', $data);
	}

	// public function deletes($id){
	// 	$condition = array("id_header_penjualan" => $id);
	// 	$res  = $this->all_model->deleteData("penjualan", $condition);
	// 	if($res == true){
	// 		// $this->session->set_flashdata('error', 'Data penjualan tidak berhasil dihapus');
	// 		// redirect(base_url() . "penjualan/index");
	// 		$result  = $this->all_model->deleteData("header_penjualan", $condition);
	// 		if($result == true){
	// 			$this->session->set_flashdata('success', 'Data penjualan berhasil dihapus');
	// 		    redirect(base_url() . "penjualan/index");
	// 		}
	// 	}

	// 	$this->session->set_flashdata('error', 'Data penjualan tidak berhasil dihapus');
	// 	redirect(base_url() . "penjualan/index/" . $header_penjualan);
	// }

	public function getItem(){
		// $condition = array('id_item' => $this->input->get('id'));
  //   	$data = $this->all_model->getDataByCondition('item', $condition)->row();
		$data = $this->all_model->getItemById($this->input->get('id'))->row();
		$data->harga = number_format($data->harga, 0,'','.');
    	echo json_encode($data); 
	}

	public function editHeaderPenjualan(){
		$condition = array('id_header_penjualan' => $this->input->get('id'));
    	$data['header_penjualan'] = $this->all_model->getDataByCondition('header_penjualan', $condition)->row();
    	echo json_encode($data); 
	}

	public function processDP1(){
		$condition = array('id_header_penjualan' => $this->input->post('id_header_penjualan'));
    	$h_penjualan = $this->all_model->getDataByCondition('header_penjualan', $condition)->row();
    	
    	$dp1 = str_replace(".", "", $this->input->post('dp1'));

    	$data  = array(
    		'dp1' => $dp1,
    		'sisa_pembayaran' => ($h_penjualan->grandtotal - $dp1)
    	);

    	$res = $this->all_model->updateData('header_penjualan', $condition, $data);
		if($res == true){
			$this->session->set_flashdata('success', 'Data untuk pembayaran dp berhasil disimpan');
			redirect(base_url() . "penjualan/index");
		}
		$this->session->set_flashdata('error', 'Data untuk pembayaran dp tidak berhasil disimpan');
		redirect(base_url() . "penjualan/index");
	}

	public function processDP2(){
		$condition = array('id_header_penjualan' => $this->input->post('id_header_penjualan'));
    	$h_penjualan = $this->all_model->getDataByCondition('header_penjualan', $condition)->row();
    	
    	$data  = array(
    		'dp2' => $h_penjualan->sisa_pembayaran,
    		'sisa_pembayaran' => 0,
    		'status_pembayaran' => 1
    	);

    	$res = $this->all_model->updateData('header_penjualan', $condition, $data);
		if($res == true){
			$this->session->set_flashdata('success', 'Data untuk pembayaran dp berhasil disimpan');
			redirect(base_url() . "penjualan/index");
		}
		$this->session->set_flashdata('error', 'Data untuk pembayaran dp tidak berhasil disimpan');
		redirect(base_url() . "penjualan/index");
	}

	public function deleteItem(){
		$con = array('id_penjualan' => $this->input->post('id'));
		$penjualan = $this->all_model->getDataByCondition('penjualan', $con)->row();

		$condition = array('id_header_penjualan' => $penjualan->id_header_penjualan);
		$res = $this->all_model->getDataByCondition('header_penjualan', $condition)->row();

		$total = $res->grandtotal - $penjualan->total_harga;
		$grandTotal = $total - $res->diskon;
		$dataHeaderPenjualan = array(
			'total' => $total,
			'grandtotal' => $grandTotal
		);

		$headerPenjualan = $this->all_model->updateData('header_penjualan', $condition, $dataHeaderPenjualan);
		if($headerPenjualan == true){
			$data = array(
				'status_delete' => 1,
				'deleted_by' => $this->session->userdata('id'),
				'deleted_date' => date('Y-m-d'),
				'keterangan_delete' => $this->input->post('keterangan_delete')
			);

			$res_penjualan = $this->all_model->updateData("penjualan", $con, $data);
			if($res_penjualan == true){
				$this->session->set_flashdata('success', 'Data item berhasil dihapus');
				redirect(base_url() . 'penjualan/detail/' . $penjualan->id_header_penjualan);
			}
			$this->session->set_flashdata('error', 'Data item tidak berhasil dihapus');
			redirect(base_url() . 'penjualan/detail/' . $penjualan->id_header_penjualan);
		}
		$this->session->set_flashdata('error', 'Data item tidak berhasil dihapus');
		redirect(base_url() . 'penjualan/detail/' . $penjualan->id_header_penjualan);
	}

	public function delete(){
		$condition = array('id_header_penjualan' => $this->input->post('id'));
		$data = array(
			'status_delete' => 1,
			'keterangan_delete' => $this->input->post('keterangan'),
			'deleted_by'  => $this->session->userdata('id'),
			'deleted_date' => date('Y-m-d')
		);
		$res_header = $this->all_model->updateData('header_penjualan', $condition, $data);
		if($res_header == true){
			$this->session->set_flashdata('success', 'Data penjualan berhasil dihapus');
			redirect(base_url() . 'penjualan/index');
		} 
		$this->session->set_flashdata('error', 'Data penjualan gagal dihapus');
		redirect(base_url() . 'penjualan/index');
	}

	// public function edit_penjualan($id)
	// {
	// 	$condition = array('role' => 3, 'id_user' => $id);
	// 	$data['user'] = $this->all_model->getDataByCondition('user', $condition)->row();
	// 	$this->load->view('operator/edit', $data);
	// }
}
