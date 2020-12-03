<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penjualan extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('all_model');
		$this->load->library('pdf');
		if($this->session->userdata('logged_in') != 1){
			return redirect(base_url() . 'login');
		}
	}

	public function index()
	{
		// $data['header_penjualan'] = $this->all_model->getDataByCondition('header_penjualan', array('status_delete' => 0))->result();
		if($this->session->userdata('role') != 3){
			$data['header_penjualan'] = $this->all_model->getHeaderPenjualan()->result();
		}else{
			$data['header_penjualan'] = $this->all_model->getHeaderPenjualanByOperator($this->session->userdata('location'))->result();
		}
		$this->load->view('penjualan/index', $data);
	}

	public function add(){
		$order = "id_header_penjualan desc";
		$header_penjualan = $this->all_model->getDataByLimit(1, $order, 'header_penjualan')->row();
		// var_dump($header_penjualan);exit();
		if(empty($header_penjualan)){
			$data['id_header_penjualan'] = 1;
			$data['tgl_penjualan'] = date('d-m-Y');
		}else{
			$data['id_header_penjualan'] = (int)$header_penjualan->id_header_penjualan + 1;
			$data['tgl_penjualan'] = date('d-m-Y');
		}
		// var_dump($data['id_header_penjualan']);exit();
		$data['item'] = $this->all_model->getAllData('item')->result();
		$data['satuan'] = $this->all_model->getAllData('satuan')->result();
		$data['customer'] = $this->all_model->getDataByCondition('customer', array('status' => 1))->result();

		$condition = array('id_user' => $this->session->userdata('id'));
		$data['user'] = $this->all_model->getDataByCondition('user', $condition)->row();
		$this->load->view('penjualan/add_penjualan_header', $data);
	}

	public function processAdd(){
		$condition = array('id_header_penjualan' => $this->input->post('id_header_penjualan'));
		$p = $this->all_model->getDataByCondition('header_penjualan', $condition)->row();

		if(!empty($p)){
			$tamp = $p->id_header_penjualan + 1;
		}else{
			$tamp = $this->input->post('id_header_penjualan');
		}

		$data = array(
			'id_header_penjualan' => $tamp,
			'tgl_penjualan' => date('Y-m-d', strtotime(strtr($this->input->post('tgl_penjualan'), '-', '-'))),
			'status'  => 0,
			'createdBy' => $this->session->userdata('id'),
			'createdDate' => date('Y-m-d H:i:s', strtotime(strtr($this->input->post('createdDate'), '-', '-'))),
			'id_customer' => $this->input->post('id_customer'),
			'updatedDate' => '0000-00-00 00:00:00',
			'updatedBy' => 0,
			'keterangan_delete' => '',
			'total' => 0,
			'status_delete' => 0,
			'deleted_date' => '0000-00-00 00:00:00',
			'deleted_by' => 0,
			'nomor_penjualan' => '',
			'discount' => 0,
			'counter_dp1' => 0,
			'counter_dp2' => 0,
			'counter_lunas' => 0,
			'dp1' => 0,
			'dp2' => 0,
			'grandtotal' => 0,
			'metode_pembayaran' => 0,
			'sisa_pembayaran' => 0
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

			// $str = explode(',', $this->input->post('harga_satuan'));
			// $harga = str_replace(",", "", $str[0]);

			$harga = str_replace(',', '', $this->input->post('harga_satuan'));

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
					'keterangan' => $this->input->post('keterangan'),
					'updated_date' => '0000-00-00 00:00:00',
					'updated_by' => 0,
					'status_delete' => 0,
					'keterangan_delete' => '',
					'deleted_by' => 0,
					'deleted_date' => '0000-00-00 00:00:00'
				);
				// var_dump($datas);exit();
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
				// $dname = explode(".", $_FILES["line_item"]['name']);
				// $ext = end($dname);
				$imageExtention = pathinfo($_FILES["line_item"]['name'], PATHINFO_EXTENSION);
				$new_name                   = time() . "." . $imageExtention;
				// var_dump($new_name);exit();
		        $config['file_name']        = $new_name;
				$config['upload_path']      = './gambar/';
				$config['allowed_types']    = 'gif|jpg|png';

				$this->load->library('upload', $config);
		 
				if ($this->upload->do_upload('line_item')){

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
					// var_dump('masuk', $datas);exit();
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
				}else{
					$this->session->set_flashdata('error', 'Data item tidak berhasil disimpan');
					redirect(base_url() . 'penjualan/detail/' . $this->input->post('id_header_penjualan'));
				}
			}
		}	
	}

	public function checkout($id){
		// $condition = array('id_header_penjualan' => $id);
		// $data = array('status' => 1);
		// $res = $this->all_model->updateData('penjualan', $condition, $data);
		// if($res == false){
		// 	$this->session->set_flashdata('error', 'Data penjualan tidak tersimpan');
		// 	return redirect(base_url().'penjualan/detail/' . $id);
		// }
		$condition = array('id_header_penjualan' => $id);
		$tahun = date('y');
		$bulan = date('m');
		// var_dump($bulan);exit();
		if((int)$this->input->post('metode_pembayaran') == 0){
			$status_pembayaran = 0;
		}else if((int)$this->input->post('metode_pembayaran') == 1){
			$status_pembayaran = 1;
		}else{
			$status_pembayaran = 2;
		}

		$con = array('id_user' => $this->session->userdata('id'));
		// $user = $this->all_model->getDataByCondition('user', $con)->row();
		// var_dump($user->id_location);exit();
		$user = $this->all_model->getLocationByUser($this->session->userdata('id'))->row();
		$nmr = $user->code_location;
		$p = $this->all_model->getHeaderPenjualanByLimit($nmr)->row();
		// var_dump($user);exit();
		if(empty($p)){
			$nmrs = $nmr. '/INV/' . $tahun . '/' . $bulan . '/' . sprintf('%04d', 1);
		}else{
			$counter_in = explode("/", $p->nomor_penjualan);
			if($counter_in[3] == $bulan && $counter_in[2] == $tahun){
				$tamp = sprintf('%04d', $counter_in[4] + 1);
				$nmrs = $nmr. '/INV/' . $tahun . '/' . $bulan . '/' . $tamp;
			}else{
				$nmrs = $nmr. '/INV/' . $tahun . '/' . $bulan . '/' . sprintf('%04d', 1);
			}
			// }else if($counter_in[3] != $bulan && $counter_in[2] == $tahun){
			// 	$nmrs = $nmr. '/INV/' . $tahun . '/' . $bulan . '/' . sprintf('%04d', 1);
			// }else if($counter_in[3] == $bulan && $counter_in[2] != $tahun){
			// 	$nmrs = $nmr. '/INV/' . $tahun . '/' . $bulan . '/' . sprintf('%04d', 1);
			// }
		}

		$datas = array(
			'metode_pembayaran' => $this->input->post('metode_pembayaran'),
			'discount' => $this->input->post('discount'),
			'grandtotal' => $this->input->post('grandtotal'),
			'status_pembayaran' => $status_pembayaran,
			'status' => 1,
			'updatedBy' => $this->session->userdata('id'),
			'updatedDate' => date('Y-m-d H:i:s', strtotime(strtr($this->input->post('updatedDate'), '-', '-'))),
			'tgl_penjualan' => date('Y-m-d', strtotime(strtr($this->input->post('tgl_penjualan'), '-', '-'))),
			'nomor_penjualan' => $nmrs,
			'id_customer' => $this->input->post('customers')
		);

		$result = $this->all_model->updateData('header_penjualan', $condition, $datas);
		if($result == false){
			$this->session->set_flashdata('error', 'Data penjualan tidak disimpan');
			return redirect(base_url().'penjualan/detail/' . $id);
		}
		
		$data = array('status' => 1);
		$res1 = $this->all_model->updateData('penjualan', $condition, $data);
		if($res1 == false){
			$this->session->set_flashdata('error', 'Data penjualan tidak tersimpan');
			return redirect(base_url().'penjualan/detail/' . $id);
		}
		return redirect(base_url().'penjualan/index');
	}

	public function edit(){
		$condition = array('id_penjualan' => $this->input->get('id'));
    	$penjualan = $this->all_model->getDataByCondition('penjualan', $condition)->row();
    	$penjualan->harga_satuan = number_format($penjualan->harga_satuan, 0,'',',');
    	$penjualan->total_harga = number_format($penjualan->total_harga, 0,'',',');
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
				// var_dump($_FILES['line_item']['name']);exit();
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
					$imageExtention = pathinfo($_FILES["line_item"]['name'], PATHINFO_EXTENSION);
					$new_name                   = time() . "." . $imageExtention;
					// var_dump($new_name);exit();
			        $config['file_name']        = $new_name;
					$config['upload_path']      = './gambar/';
					$config['allowed_types']    = 'gif|jpg|png';

					$this->load->library('upload', $config);

					// var_dump($penjualan->line_item);exit();
					if(!empty($penjualan->line_item) || $penjualan->line_item != ""){
						unlink(FCPATH."gambar/".$penjualan->line_item);
					}
			 
					if ($this->upload->do_upload('line_item')){
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
						// $this->session->set_flashdata('error', 'Data item tidak berhasil disimpan');
						// redirect(base_url() . 'penjualan/detail/' . $this->input->post('id_header_penjualan'));
					}else{
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect(base_url() . 'penjualan/detail/' . $this->input->post('id_header_penjualan'));
					}
					
				}
			}else{
				// unlink(FCPATH."gambar/".$penjualan->line_item);
				if(!empty($penjualan->line_item) || $penjualan->line_item != ""){
					unlink(FCPATH."gambar/".$penjualan->line_item);
				}

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

	public function getItem(){
		$data = $this->all_model->getItemById($this->input->get('id'))->row();
		$data->harga = number_format($data->harga, 0,'',',');
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
    	
    	$dp1 = str_replace(",", "", $this->input->post('dp1'));

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

	public function prints_dp1($id){
		$count = 0;

		$con = array('id_header_penjualan' => $id);
		$penjualan = $this->all_model->getDataByCondition('header_penjualan', $con)->row();

		$penjualans = $this->all_model->getCountHeaderPenjualan($penjualan->nomor_penjualan)->num_rows();
		
		if($penjualans > 1){
			$this->session->set_flashdata('error', 'Data gagal di print');
			redirect(base_url() . 'penjualan/index/');
		}else{
			if(empty($penjualan)){
				$count = 1;
				$dataHeaderPenjualan = array("counter_dp1" => (int)$count);
				$res = $this->all_model->updateData('header_penjualan', $con, $dataHeaderPenjualan);
			}else{
				$count = (int)$penjualan->counter_dp1 + 1;
				$dataHeaderPenjualan = array("counter_dp1" => (int)$count);
				$res = $this->all_model->updateData('header_penjualan', $con, $dataHeaderPenjualan);
			}
			
			if($res == true){
				$this->load->library('pdf');

				$descrip = "Kamu pun dapat menghitung kata atau huruf sesuai dengan kata atau huruf sesuai dengan kata atau huruf sesuai dengan kata";
				// $descrip = "Kamu pun dapat menghitung kata atau huruf sesuai dengan kata atau kalimat tertentu saja di mana kalimat tersebut harus kamu blok atau kamu seleksi terlebih dahulu. Jika tidak ada yang dibloksasaasasas";
				$nama = "Bapak Hendra Kusuma Saassdsdadasqwqqsdsdssdas";
				
				// $this->load->view('laporan_pdf');
				// set header and footer fonts
				$pdf = new PDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

				// set header and footer fonts
				$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

				// set default monospaced font
				$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

				// set margins
				if((strlen($descrip) <= 120 && strlen($nama) <= 36) || (strlen($descrip) <= 120 && strlen($nama) > 36)){
					$pdf->SetMargins(PDF_MARGIN_LEFT, 65, PDF_MARGIN_RIGHT);
				}

				if(strlen($descrip) > 120 && strlen($nama) <= 36){
					$pdf->SetMargins(PDF_MARGIN_LEFT, 73, PDF_MARGIN_RIGHT);
				}

				if(strlen($descrip) > 120 && strlen($nama) > 36){
					$pdf->SetMargins(PDF_MARGIN_LEFT, 76, PDF_MARGIN_RIGHT);
				}

				$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$pdf->SetFooterMargin(10);

				// set auto page breaks
				$pdf->SetAutoPageBreak(TRUE, 45);

				// set font
				$pdf->SetFont('helvetica', 'B', 20);

				// add a page
				$pdf->AddPage();

				$pdf->SetFont('helvetica', '', 8);
				// -----------------------------------------------------------------------------
				$tbl = '
					<table border="0" nobr="true" align="center" cellspacing="0" cellpadding="5" style="font-size:9px;
					padding:10px 10px 10px 10px;">
						<thead>
							<tr nobr="true">
								<td width="30" align="center" border="1">No.</td>
								<td width="250" align="center" border="1">Nama Barang</td>
								<td width="90" align="center" colspan="2" border="1">Qty</td>
								<td width="70" align="center" border="1">Harga Stn</td>
								<td width="70" align="center" border="1">Jumlah</td>
							</tr>
						</thead>
						<tr nobr="true">
							<td width="30" border="1">1</td>
							<td width="250" align="left" border="1">
								Nota 3 Rangkap, 2 Warna, Cacah, Nomorator <br>
								PT. ABCD | NCR Putih-Merah-Kuning Cetak Warna Merah-Biru | Nomor : 00001
							</td>
							<td width="45" border="1">1.00</td>
							<td width="45" border="1">Rim</td>
							<td width="70" align="right" border="1">250.000</td>
							<td width="70" align="right" border="1">250.000</td>
						</tr>
						<tr nobr="true">
							<td border="1">2</td>
							<td align="left" border="1">
								Spanduk Flx Biasa <br>
								PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
							</td>
							<td border="1">3.00</td>
							<td border="1">M2</td>
							<td align="right" border="1">35.000</td>
							<td align="right" border="1">105.000</td>
						</tr>
						<tr nobr="true">
							<td border="1">3</td>
							<td align="left" border="1">
								Spanduk Flx Biasa <br>
								PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
							</td>
							<td border="1">3.00</td>
							<td border="1">M2</td>
							<td align="right" border="1">35.000</td>
							<td align="right" border="1">105.000</td>
						</tr>
						<tr nobr="true">
							<td border="1">2</td>
							<td align="left" border="1">
								Spanduk Flx Biasa <br>
								PT. ABCD | Uk. 3 x 1 m | MA A4 B2 PT. ABCD | Uk. 3 x 1 m | MA A4 B2PT. ABCD | Uk. 3 x 1 m | MA A4 B2PT. ABCD | Uk. 3 x 1 m | MA A4 B2PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
							</td>
							<td border="1">3.00</td>
							<td border="1">M2</td>
							<td align="right" border="1">35.000</td>
							<td align="right" border="1">105.000</td>
						</tr>
						<tr nobr="true">
							<td border="1">3</td>
							<td align="left" border="1">
								Spanduk Flx Biasa <br>
								PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
							</td>
							<td border="1">3.00</td>
							<td border="1">M2</td>
							<td align="right" border="1">35.000</td>
							<td align="right" border="1">105.000</td>
						</tr>
						<tr nobr="true">
							<td border="1">2</td>
							<td align="left" border="1">
								Spanduk Flx Biasa <br>
								PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
							</td>
							<td border="1">3.00</td>
							<td border="1">M2</td>
							<td align="right" border="1">35.000</td>
							<td align="right" border="1">105.000</td>
						</tr>
						<tr nobr="true">
							<td border="1">3</td>
							<td align="left" border="1">
								Spanduk Flx Biasa <br>
								PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
							</td>
							<td border="1">3.00</td>
							<td border="1">M2</td>
							<td align="right" border="1">35.000</td>
							<td align="right" border="1">105.000</td>
						</tr>
						<tr nobr="true">
							<td border="1">2</td>
							<td align="left" border="1">
								Spanduk Flx Biasa <br>
								PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
							</td>
							<td border="1">3.00</td>
							<td border="1">M2</td>
							<td align="right" border="1">35.000</td>
							<td align="right" border="1">105.000</td>
						</tr>
						<tr nobr="true">
							<td border="1">3</td>
							<td align="left" border="1">
								Spanduk Flx Biasa <br>
								PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
							</td>
							<td border="1">3.00</td>
							<td border="1">M2</td>
							<td align="right" border="1">35.000</td>
							<td align="right" border="1">105.000</td>
						</tr>
						<tr nobr="true">
							<td border="1">3</td>
							<td align="left" border="1">
								Spanduk Flx Biasa <br>
								PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
							</td>
							<td border="1">3.00</td>
							<td border="1">M2</td>
							<td align="right" border="1">35.000</td>
							<td align="right" border="1">105.000</td>
						</tr>
						<tr nobr="true">
							<td border="1">3</td>
							<td align="left" border="1">
								Spanduk Flx Biasa <br>
								PT. ABCD | Uk. 3 x 1 m | MA A4 B2 PT. ABCD | Uk. 3 x 1 m | MA A4 B2PT. ABCD | Uk. 3 x 1 m | MA A4 B2PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
							</td>
							<td border="1">3.00</td>
							<td border="1">M2</td>
							<td align="right" border="1">35.000</td>
							<td align="right" border="1">105.000</td>
						</tr>
						<tr nobr="true">
							<td border="1">3</td>
							<td align="left" border="1">
								Spanduk Flx Biasa <br>
								PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
							</td>
							<td border="1">3.00</td>
							<td border="1">M2</td>
							<td align="right" border="1">35.000</td>
							<td align="right" border="1">105.000</td>
						</tr>
						<tr nobr="true">
							<td border="1">3</td>
							<td align="left" border="1">
								Spanduk Flx Biasa <br>
								PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
							</td>
							<td border="1">3.00</td>
							<td border="1">M2</td>
							<td align="right" border="1">35.000</td>
							<td align="right" border="1">105.000</td>
						</tr>
					</table>';
				
				$pdf->writeHTML($tbl, true, false, false, false, '');
				
				//Close and output PDF document
				$pdf->Output('example_048.pdf', 'I');
			}else{
				$this->session->set_flashdata('error', 'Data gagal di print');
				redirect(base_url() . 'penjualan/index/');
			}
		}
	}

	public function prints_dp2($id){
		$count = 0;
		$con = array('id_header_penjualan' => $id);
		$penjualan = $this->all_model->getDataByCondition('header_penjualan', $con)->row();
		if(empty($penjualan)){
			$count = 1;
			$dataHeaderPenjualan = array("counter_dp2" => (int)$count);
			$res = $this->all_model->updateData('header_penjualan', $con, $dataHeaderPenjualan);
		}else{
			$count = (int)$penjualan->counter_dp2 + 1;
			$dataHeaderPenjualan = array("counter_dp2" => (int)$count);
			$res = $this->all_model->updateData('header_penjualan', $con, $dataHeaderPenjualan);
		}

		if($res == true){
			$this->load->library('pdf');

			$descrip = "Kamu pun dapat menghitung kata atau huruf sesuai dengan kata atau huruf sesuai dengan kata atau huruf sesuai dengan kata";
			// $descrip = "Kamu pun dapat menghitung kata atau huruf sesuai dengan kata atau kalimat tertentu saja di mana kalimat tersebut harus kamu blok atau kamu seleksi terlebih dahulu. Jika tidak ada yang dibloksasaasasas";
			$nama = "Bapak Hendra Kusuma Saassdsdadasqwqqsdsdssdas";
			
			// $this->load->view('laporan_pdf');
			// set header and footer fonts
			$pdf = new PDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			if((strlen($descrip) <= 120 && strlen($nama) <= 36) || (strlen($descrip) <= 120 && strlen($nama) > 36)){
				$pdf->SetMargins(PDF_MARGIN_LEFT, 65, PDF_MARGIN_RIGHT);
			}

			if(strlen($descrip) > 120 && strlen($nama) <= 36){
				$pdf->SetMargins(PDF_MARGIN_LEFT, 73, PDF_MARGIN_RIGHT);
			}

			if(strlen($descrip) > 120 && strlen($nama) > 36){
				$pdf->SetMargins(PDF_MARGIN_LEFT, 76, PDF_MARGIN_RIGHT);
			}

			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(10);

			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, 45);

			// set font
			$pdf->SetFont('helvetica', 'B', 20);

			// add a page
			$pdf->AddPage();

			$pdf->SetFont('helvetica', '', 8);
			// -----------------------------------------------------------------------------
			$tbl = '
				<table border="0" nobr="true" align="center" cellspacing="0" cellpadding="5" style="font-size:9px;
				padding:10px 10px 10px 10px;">
					<thead>
						<tr nobr="true">
							<td width="30" align="center" border="1">No.</td>
							<td width="250" align="center" border="1">Nama Barang</td>
							<td width="90" align="center" colspan="2" border="1">Qty</td>
							<td width="70" align="center" border="1">Harga Stn</td>
							<td width="70" align="center" border="1">Jumlah</td>
						</tr>
					</thead>
					<tr nobr="true">
						<td width="30" border="1">1</td>
						<td width="250" align="left" border="1">
							Nota 3 Rangkap, 2 Warna, Cacah, Nomorator <br>
							PT. ABCD | NCR Putih-Merah-Kuning Cetak Warna Merah-Biru | Nomor : 00001
						</td>
						<td width="45" border="1">1.00</td>
						<td width="45" border="1">Rim</td>
						<td width="70" align="right" border="1">250.000</td>
						<td width="70" align="right" border="1">250.000</td>
					</tr>
					<tr nobr="true">
						<td border="1">2</td>
						<td align="left" border="1">
							Spanduk Flx Biasa <br>
							PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
						</td>
						<td border="1">3.00</td>
						<td border="1">M2</td>
						<td align="right" border="1">35.000</td>
						<td align="right" border="1">105.000</td>
					</tr>
					<tr nobr="true">
						<td border="1">3</td>
						<td align="left" border="1">
							Spanduk Flx Biasa <br>
							PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
						</td>
						<td border="1">3.00</td>
						<td border="1">M2</td>
						<td align="right" border="1">35.000</td>
						<td align="right" border="1">105.000</td>
					</tr>
					<tr nobr="true">
						<td border="1">2</td>
						<td align="left" border="1">
							Spanduk Flx Biasa <br>
							PT. ABCD | Uk. 3 x 1 m | MA A4 B2 PT. ABCD | Uk. 3 x 1 m | MA A4 B2PT. ABCD | Uk. 3 x 1 m | MA A4 B2PT. ABCD | Uk. 3 x 1 m | MA A4 B2PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
						</td>
						<td border="1">3.00</td>
						<td border="1">M2</td>
						<td align="right" border="1">35.000</td>
						<td align="right" border="1">105.000</td>
					</tr>
					<tr nobr="true">
						<td border="1">3</td>
						<td align="left" border="1">
							Spanduk Flx Biasa <br>
							PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
						</td>
						<td border="1">3.00</td>
						<td border="1">M2</td>
						<td align="right" border="1">35.000</td>
						<td align="right" border="1">105.000</td>
					</tr>
					<tr nobr="true">
						<td border="1">2</td>
						<td align="left" border="1">
							Spanduk Flx Biasa <br>
							PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
						</td>
						<td border="1">3.00</td>
						<td border="1">M2</td>
						<td align="right" border="1">35.000</td>
						<td align="right" border="1">105.000</td>
					</tr>
					<tr nobr="true">
						<td border="1">3</td>
						<td align="left" border="1">
							Spanduk Flx Biasa <br>
							PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
						</td>
						<td border="1">3.00</td>
						<td border="1">M2</td>
						<td align="right" border="1">35.000</td>
						<td align="right" border="1">105.000</td>
					</tr>
					<tr nobr="true">
						<td border="1">2</td>
						<td align="left" border="1">
							Spanduk Flx Biasa <br>
							PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
						</td>
						<td border="1">3.00</td>
						<td border="1">M2</td>
						<td align="right" border="1">35.000</td>
						<td align="right" border="1">105.000</td>
					</tr>
					<tr nobr="true">
						<td border="1">3</td>
						<td align="left" border="1">
							Spanduk Flx Biasa <br>
							PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
						</td>
						<td border="1">3.00</td>
						<td border="1">M2</td>
						<td align="right" border="1">35.000</td>
						<td align="right" border="1">105.000</td>
					</tr>
					<tr nobr="true">
						<td border="1">3</td>
						<td align="left" border="1">
							Spanduk Flx Biasa <br>
							PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
						</td>
						<td border="1">3.00</td>
						<td border="1">M2</td>
						<td align="right" border="1">35.000</td>
						<td align="right" border="1">105.000</td>
					</tr>
					<tr nobr="true">
						<td border="1">3</td>
						<td align="left" border="1">
							Spanduk Flx Biasa <br>
							PT. ABCD | Uk. 3 x 1 m | MA A4 B2 PT. ABCD | Uk. 3 x 1 m | MA A4 B2PT. ABCD | Uk. 3 x 1 m | MA A4 B2PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
						</td>
						<td border="1">3.00</td>
						<td border="1">M2</td>
						<td align="right" border="1">35.000</td>
						<td align="right" border="1">105.000</td>
					</tr>
					<tr nobr="true">
						<td border="1">3</td>
						<td align="left" border="1">
							Spanduk Flx Biasa <br>
							PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
						</td>
						<td border="1">3.00</td>
						<td border="1">M2</td>
						<td align="right" border="1">35.000</td>
						<td align="right" border="1">105.000</td>
					</tr>
					<tr nobr="true">
						<td border="1">3</td>
						<td align="left" border="1">
							Spanduk Flx Biasa <br>
							PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
						</td>
						<td border="1">3.00</td>
						<td border="1">M2</td>
						<td align="right" border="1">35.000</td>
						<td align="right" border="1">105.000</td>
					</tr>
				</table>';
			
			$pdf->writeHTML($tbl, true, false, false, false, '');
			
			//Close and output PDF document
			$pdf->Output('example_048.pdf', 'I');
		}else{
			$this->session->set_flashdata('error', 'Data gagal di print');
			redirect(base_url() . 'penjualan/index/');
		}
	}

	public function prints_lunas($id){
		$count = 0;
		$con = array('id_header_penjualan' => $id);
		$penjualan = $this->all_model->getDataByCondition('header_penjualan', $con)->row();
		if(empty($penjualan)){
			$count = 1;
			$dataHeaderPenjualan = array("counter_lunas" => (int)$count);
			$res = $this->all_model->updateData('header_penjualan', $con, $dataHeaderPenjualan);
		}else{
			$count = (int)$penjualan->counter_dp2 + 1;
			$dataHeaderPenjualan = array("counter_lunas" => (int)$count);
			$res = $this->all_model->updateData('header_penjualan', $con, $dataHeaderPenjualan);
		}

		if($res == true){
			$this->load->library('pdf');

			$descrip = "Kamu pun dapat menghitung kata atau huruf sesuai dengan kata atau huruf sesuai dengan kata atau huruf sesuai dengan kata";
			// $descrip = "Kamu pun dapat menghitung kata atau huruf sesuai dengan kata atau kalimat tertentu saja di mana kalimat tersebut harus kamu blok atau kamu seleksi terlebih dahulu. Jika tidak ada yang dibloksasaasasas";
			$nama = "Bapak Hendra Kusuma Saassdsdadasqwqqsdsdssdas";
			
			// $this->load->view('laporan_pdf');
			// set header and footer fonts
			$pdf = new PDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			if((strlen($descrip) <= 120 && strlen($nama) <= 36) || (strlen($descrip) <= 120 && strlen($nama) > 36)){
				$pdf->SetMargins(PDF_MARGIN_LEFT, 65, PDF_MARGIN_RIGHT);
			}

			if(strlen($descrip) > 120 && strlen($nama) <= 36){
				$pdf->SetMargins(PDF_MARGIN_LEFT, 73, PDF_MARGIN_RIGHT);
			}

			if(strlen($descrip) > 120 && strlen($nama) > 36){
				$pdf->SetMargins(PDF_MARGIN_LEFT, 76, PDF_MARGIN_RIGHT);
			}

			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(10);

			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, 45);

			// set font
			$pdf->SetFont('helvetica', 'B', 20);

			// add a page
			$pdf->AddPage();

			$pdf->SetFont('helvetica', '', 8);
			// -----------------------------------------------------------------------------
			$tbl = '
				<table border="0" nobr="true" align="center" cellspacing="0" cellpadding="5" style="font-size:9px;
				padding:10px 10px 10px 10px;">
					<thead>
						<tr nobr="true">
							<td width="30" align="center" border="1">No.</td>
							<td width="250" align="center" border="1">Nama Barang</td>
							<td width="90" align="center" colspan="2" border="1">Qty</td>
							<td width="70" align="center" border="1">Harga Stn</td>
							<td width="70" align="center" border="1">Jumlah</td>
						</tr>
					</thead>
					<tr nobr="true">
						<td width="30" border="1">1</td>
						<td width="250" align="left" border="1">
							Nota 3 Rangkap, 2 Warna, Cacah, Nomorator <br>
							PT. ABCD | NCR Putih-Merah-Kuning Cetak Warna Merah-Biru | Nomor : 00001
						</td>
						<td width="45" border="1">1.00</td>
						<td width="45" border="1">Rim</td>
						<td width="70" align="right" border="1">250.000</td>
						<td width="70" align="right" border="1">250.000</td>
					</tr>
					<tr nobr="true">
						<td border="1">2</td>
						<td align="left" border="1">
							Spanduk Flx Biasa <br>
							PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
						</td>
						<td border="1">3.00</td>
						<td border="1">M2</td>
						<td align="right" border="1">35.000</td>
						<td align="right" border="1">105.000</td>
					</tr>
					<tr nobr="true">
						<td border="1">3</td>
						<td align="left" border="1">
							Spanduk Flx Biasa <br>
							PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
						</td>
						<td border="1">3.00</td>
						<td border="1">M2</td>
						<td align="right" border="1">35.000</td>
						<td align="right" border="1">105.000</td>
					</tr>
					<tr nobr="true">
						<td border="1">2</td>
						<td align="left" border="1">
							Spanduk Flx Biasa <br>
							PT. ABCD | Uk. 3 x 1 m | MA A4 B2 PT. ABCD | Uk. 3 x 1 m | MA A4 B2PT. ABCD | Uk. 3 x 1 m | MA A4 B2PT. ABCD | Uk. 3 x 1 m | MA A4 B2PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
						</td>
						<td border="1">3.00</td>
						<td border="1">M2</td>
						<td align="right" border="1">35.000</td>
						<td align="right" border="1">105.000</td>
					</tr>
					<tr nobr="true">
						<td border="1">3</td>
						<td align="left" border="1">
							Spanduk Flx Biasa <br>
							PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
						</td>
						<td border="1">3.00</td>
						<td border="1">M2</td>
						<td align="right" border="1">35.000</td>
						<td align="right" border="1">105.000</td>
					</tr>
					<tr nobr="true">
						<td border="1">2</td>
						<td align="left" border="1">
							Spanduk Flx Biasa <br>
							PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
						</td>
						<td border="1">3.00</td>
						<td border="1">M2</td>
						<td align="right" border="1">35.000</td>
						<td align="right" border="1">105.000</td>
					</tr>
					<tr nobr="true">
						<td border="1">3</td>
						<td align="left" border="1">
							Spanduk Flx Biasa <br>
							PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
						</td>
						<td border="1">3.00</td>
						<td border="1">M2</td>
						<td align="right" border="1">35.000</td>
						<td align="right" border="1">105.000</td>
					</tr>
					<tr nobr="true">
						<td border="1">2</td>
						<td align="left" border="1">
							Spanduk Flx Biasa <br>
							PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
						</td>
						<td border="1">3.00</td>
						<td border="1">M2</td>
						<td align="right" border="1">35.000</td>
						<td align="right" border="1">105.000</td>
					</tr>
					<tr nobr="true">
						<td border="1">3</td>
						<td align="left" border="1">
							Spanduk Flx Biasa <br>
							PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
						</td>
						<td border="1">3.00</td>
						<td border="1">M2</td>
						<td align="right" border="1">35.000</td>
						<td align="right" border="1">105.000</td>
					</tr>
					<tr nobr="true">
						<td border="1">3</td>
						<td align="left" border="1">
							Spanduk Flx Biasa <br>
							PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
						</td>
						<td border="1">3.00</td>
						<td border="1">M2</td>
						<td align="right" border="1">35.000</td>
						<td align="right" border="1">105.000</td>
					</tr>
					<tr nobr="true">
						<td border="1">3</td>
						<td align="left" border="1">
							Spanduk Flx Biasa <br>
							PT. ABCD | Uk. 3 x 1 m | MA A4 B2 PT. ABCD | Uk. 3 x 1 m | MA A4 B2PT. ABCD | Uk. 3 x 1 m | MA A4 B2PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
						</td>
						<td border="1">3.00</td>
						<td border="1">M2</td>
						<td align="right" border="1">35.000</td>
						<td align="right" border="1">105.000</td>
					</tr>
					<tr nobr="true">
						<td border="1">3</td>
						<td align="left" border="1">
							Spanduk Flx Biasa <br>
							PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
						</td>
						<td border="1">3.00</td>
						<td border="1">M2</td>
						<td align="right" border="1">35.000</td>
						<td align="right" border="1">105.000</td>
					</tr>
					<tr nobr="true">
						<td border="1">3</td>
						<td align="left" border="1">
							Spanduk Flx Biasa <br>
							PT. ABCD | Uk. 3 x 1 m | MA A4 B2 <br>
						</td>
						<td border="1">3.00</td>
						<td border="1">M2</td>
						<td align="right" border="1">35.000</td>
						<td align="right" border="1">105.000</td>
					</tr>
				</table>';
			
			$pdf->writeHTML($tbl, true, false, false, false, '');
			
			//Close and output PDF document
			$pdf->Output('example_048.pdf', 'I');
		}else{
			$this->session->set_flashdata('error', 'Data gagal di print');
			redirect(base_url() . 'penjualan/index/');
		}
	}

	public function open($id){
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
		$this->load->view('penjualan/open_penjualan', $data);
	}

	public function processOpenAddPenjualan(){
		$this->form_validation->set_rules('id_item', 'Nama item', 'required');
		$this->form_validation->set_rules('id_satuan', 'Satuan', 'required');
		$this->form_validation->set_rules('harga_satuan', 'Harga Satuan', 'required');
		$this->form_validation->set_rules('jmlh', 'Jumlah', 'required');
		$this->form_validation->set_rules('total_harga', 'Total Harga', 'required');


		if($this->form_validation->run() == false){
			return redirect(base_url() . 'penjualan/open/' . $this->input->post('id_header_penjualan'));
		}else{ 
			// $str = explode(',', $this->input->post('harga_satuan'));
			// $harga = str_replace(",", "", $str[0]);

			$harga = str_replace(',', '', $this->input->post('harga_satuan'));

			$condition = array('id_header_penjualan' => $this->input->post('id_header_penjualan'));
			$headers_penjualan = $this->all_model->getDataByCondition('header_penjualan', $condition)->row();

			if($headers_penjualan->nomor_penjualan != $this->input->post('nmr_penjualan')){
				$counter_in = explode("/", $this->input->post('nmr_penjualan'));
				$nmr = $counter_in[0] . '/' . $counter_in[1] . '/' . $counter_in[2] . '/' . $counter_in[3]. '/';
				$nmr_penjualan = $this->all_model->getHeaderPenjualanByLimitDesc($nmr)->row();
				$counter_db = explode("/", $nmr_penjualan->nomor_penjualan);
				$tamp_db = (int)$counter_db[4] + 1;
				
				// var_dump($tamp_db);exit();
				if($counter_in[4] != sprintf('%04d', $tamp_db)){
					$error = "Nomor invoice seharusnya : " .  $counter_in[0] . '/' . $counter_in[1] . '/' . $counter_in[2] . '/' . $counter_in[3]. '/' . sprintf('%04d', $tamp_db);
					$this->session->set_flashdata('error', $error);
					return redirect(base_url().'penjualan/open/' . $this->input->post('id_header_penjualan'));
				}
				$nmrs = $counter_in[0] . '/' . $counter_in[1] . '/' . $counter_in[2] . '/' . $counter_in[3]. '/' . sprintf('%04d', $tamp_db);
			}else{
				$nmrs = $headers_penjualan->nomor_penjualan;
			}

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
					'keterangan' => $this->input->post('keterangan'),
					'updated_date' => '0000-00-00 00:00:00',
					'updated_by' => 0,
					'status_delete' => 0,
					'keterangan_delete' => '',
					'deleted_by' => 0,
					'deleted_date' => '0000-00-00 00:00:00'
				);
				// var_dump($datas);exit();
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
						'id_customer' => $this->input->post('customers'),
						'nomor_penjualan' => $nmrs
					);
					// var_dump($dataHeaderPenjualan);exit();
					$headerPenjualan = $this->all_model->updateData('header_penjualan', $condition, $dataHeaderPenjualan);
					if($headerPenjualan == true){
						$this->session->set_flashdata('success', 'Data item berhasil disimpan');
						redirect(base_url() . 'penjualan/open/' . $this->input->post('id_header_penjualan'));
					}
					$this->session->set_flashdata('error', 'Data item tidak berhasil disimpan');
					redirect(base_url() . 'penjualan/open/' . $this->input->post('id_header_penjualan'));
				}else{
					$this->session->set_flashdata('error', 'Data item tidak berhasil disimpan');
					redirect(base_url() . 'penjualan/open/' . $this->input->post('id_header_penjualan'));
				}
			}else{
				
				$new_name                   = time().$_FILES["line_item"]['name'];
		        $config['file_name']        = $new_name;
				$config['upload_path']      = './gambar/';
				$config['allowed_types']    = 'gif|jpg|png';

				$this->load->library('upload', $config);
		 
				if ($this->upload->do_upload('line_item')){

					$datas = array(
						'id_item' => $this->input->post('id_item'),
						'id_satuan' => $this->input->post('id_satuan'),
						'qty' => $this->input->post('jmlh'),
						'harga_satuan' => $harga,
						'total_harga' => $this->input->post('total_harga'),
						'status' => 1,
						'created_date' => date('Y-m-d'),
						'created_by' => $this->session->userdata('id'),
						'id_header_penjualan' => $this->input->post('id_header_penjualan'),
						'id_user' => $this->session->userdata('id'),
						'line_item' => $new_name,
						'keterangan' => $this->input->post('keterangan')
					);
					// var_dump('masuk', $datas);exit();
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
							'id_customer' => $this->input->post('customers'),
							'nomor_penjualan' => $nmrs
						);

						$headerPenjualan = $this->all_model->updateData('header_penjualan', $condition, $dataHeaderPenjualan);
						if($headerPenjualan == true){
							$this->session->set_flashdata('success', 'Data item berhasil disimpan');
							redirect(base_url() . 'penjualan/open/' . $this->input->post('id_header_penjualan'));
						}
						$this->session->set_flashdata('error', 'Data item tidak berhasil disimpan');
						redirect(base_url() . 'penjualan/open/' . $this->input->post('id_header_penjualan'));
					}else{
						$this->session->set_flashdata('error', 'Data item tidak berhasil disimpan');
						redirect(base_url() . 'penjualan/open/' . $this->input->post('id_header_penjualan'));
					}
				}else{
					$this->session->set_flashdata('error', 'Data item tidak berhasil disimpan');
					redirect(base_url() . 'penjualan/open/' . $this->input->post('id_header_penjualan'));
				}
			}
		}	
	}

	public function open_checkout($id){
		$tamp_db = 0;
		$tamp_in = 0;

		$condition = array('id_header_penjualan' => $id);
		$headers_penjualan = $this->all_model->getDataByCondition('header_penjualan', $condition)->row();
		// var_dump($this->input->post('id_head'));exit();
		if($headers_penjualan->nomor_penjualan != $this->input->post('id_head')){
			$counter_in = explode("/", $this->input->post('id_head'));
			$nmr = $counter_in[0] . '/' . $counter_in[1] . '/' . $counter_in[2] . '/' . $counter_in[3]. '/';
			$nmr_penjualan = $this->all_model->getHeaderPenjualanByLimitDesc($nmr)->row();
			$counter_db = explode("/", $nmr_penjualan->nomor_penjualan);
			$tamp_db = (int)$counter_db[4] + 1;
			
			// var_dump($tamp_db);exit();
			if($counter_in[4] != sprintf('%04d', $tamp_db)){
				$error = "Nomor invoice seharusnya : " .  $counter_in[0] . '/' . $counter_in[1] . '/' . $counter_in[2] . '/' . $counter_in[3]. '/' . sprintf('%04d', $tamp_db);
				$this->session->set_flashdata('error', $error);
				return redirect(base_url().'penjualan/open/' . $id);
			}
			$nmrs = $counter_in[0] . '/' . $counter_in[1] . '/' . $counter_in[2] . '/' . $counter_in[3]. '/' . sprintf('%04d', $tamp_db);
		}else{
			$nmrs = $headers_penjualan->nomor_penjualan;
		}
		
		$condition = array('id_header_penjualan' => $id);
		$data = array('status' => 1);
		$res = $this->all_model->updateData('penjualan', $condition, $data);
		if($res == false){
			$this->session->set_flashdata('error', 'Data penjualan tidak tersimpan');
			return redirect(base_url().'penjualan/open/' . $id);
		}

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
			'nomor_penjualan' => $nmrs,
			'id_customer' => $this->input->post('customers')
		);
		$result = $this->all_model->updateData('header_penjualan', $condition, $datas);
		if($result == false){
			$this->session->set_flashdata('error', 'Data penjualan tidak disimpan');
			return redirect(base_url().'penjualan/open/' . $id);
		}
		return redirect(base_url().'penjualan/index');
	}

	public function processOpenEditPenjualan(){
		// var_dump($this->input->post('id_penjualan'));exit();
		$con = array('id_penjualan' => $this->input->post('id_penjualan'));
		$penjualan = $this->all_model->getDataByCondition('penjualan', $con)->row();

		$this->form_validation->set_rules('id_item', 'Nama item', 'required');
		$this->form_validation->set_rules('id_satuan', 'Satuan', 'required');
		$this->form_validation->set_rules('harga_satuan', 'Harga Satuan', 'required');
		$this->form_validation->set_rules('qty', 'Jumlah', 'required');
		$this->form_validation->set_rules('total_harga', 'Total Harga', 'required');

		if($this->form_validation->run() == false){
			return redirect(base_url() . 'penjualan/open/' . $this->input->post('id_header_penjualan'));
		}else{
			$conditions = array('id_header_penjualan' => $this->input->post('id_header_penjualan'));
			$headers_penjualan = $this->all_model->getDataByCondition('header_penjualan', $conditions)->row();

			if($headers_penjualan->nomor_penjualan != $this->input->post('nmrs_penjualan')){
				$counter_in = explode("/", $this->input->post('nmrs_penjualan'));
				$nmr = $counter_in[0] . '/' . $counter_in[1] . '/' . $counter_in[2] . '/' . $counter_in[3]. '/';
				$nmr_penjualan = $this->all_model->getHeaderPenjualanByLimitDesc($nmr)->row();
				$counter_db = explode("/", $nmr_penjualan->nomor_penjualan);
				$tamp_db = (int)$counter_db[4] + 1;
				
				// var_dump($tamp_db);exit();
				if($counter_in[4] != sprintf('%04d', $tamp_db)){
					$error = "Nomor invoice seharusnya : " .  $counter_in[0] . '/' . $counter_in[1] . '/' . $counter_in[2] . '/' . $counter_in[3]. '/' . sprintf('%04d', $tamp_db);
					$this->session->set_flashdata('error', $error);
					return redirect(base_url().'penjualan/open/' . $this->input->post('id_header_penjualan'));
				}
				$nmrs = $counter_in[0] . '/' . $counter_in[1] . '/' . $counter_in[2] . '/' . $counter_in[3]. '/' . sprintf('%04d', $tamp_db);
			}else{
				$nmrs = $headers_penjualan->nomor_penjualan;
			}

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
						'id_customer' => $this->input->post('customers'),
						'nomor_penjualan' => $nmrs
					);
				}
			}

			$con_item = array('id_item' => $this->input->post('id_item'));
			$items = $this->all_model->getDataByCondition('item', $con_item)->row();

			if($items->is_design == 1){
				// var_dump($_FILES['line_item']['name']);exit();
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
							redirect(base_url() . 'penjualan/open/' . $this->input->post('id_header_penjualan'));
						}
						$this->session->set_flashdata('error', 'Data penjualan tidak berhasil diubah');
						redirect(base_url() . 'penjualan/open/' . $this->input->post('id_header_penjualan'));
					}else{
						$this->session->set_flashdata('error', 'Data penjualan tidak berhasil diubah');
						redirect(base_url() . 'penjualan/open/' . $this->input->post('id_header_penjualan'));
					}
				}else{
					$new_name                   = time().$_FILES["line_item"]['name'];
			        $config['file_name']        = $new_name;
					// $config['upload_path']      = './gambar/';
					// $config['allowed_types']    = 'gif|jpg|png';
					$config['upload_path'] = './gambar/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['max_size'] = 2000;
					$config['max_width'] = 1500;
					$config['max_height'] = 1500;

					$this->load->library('upload', $config);

					// var_dump($penjualan->line_item);exit();
					if(!empty($penjualan->line_item) || $penjualan->line_item != ""){
						unlink(FCPATH."gambar/".$penjualan->line_item);
					}
			 
					if ($this->upload->do_upload('line_item')){
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
								redirect(base_url() . 'penjualan/open/' . $this->input->post('id_header_penjualan'));
							}
							$this->session->set_flashdata('error', 'Data penjualan tidak berhasil diubah');
							redirect(base_url() . 'penjualan/open/' . $this->input->post('id_header_penjualan'));
						}else{
							$this->session->set_flashdata('error', 'Data penjualan tidak berhasil diubah');
							redirect(base_url() . 'penjualan/open/' . $this->input->post('id_header_penjualan'));
						}
						// $this->session->set_flashdata('error', 'Data item tidak berhasil disimpan');
						// redirect(base_url() . 'penjualan/detail/' . $this->input->post('id_header_penjualan'));
					}else{
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect(base_url() . 'penjualan/open/' . $this->input->post('id_header_penjualan'));
					}
					
				}
			}else{
				// unlink(FCPATH."gambar/".$penjualan->line_item);
				if(!empty($penjualan->line_item) || $penjualan->line_item != ""){
					unlink(FCPATH."gambar/".$penjualan->line_item);
				}

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
						redirect(base_url() . 'penjualan/open/' . $this->input->post('id_header_penjualan'));
					}
					$this->session->set_flashdata('error', 'Data penjualan tidak berhasil diubah');
					redirect(base_url() . 'penjualan/open/' . $this->input->post('id_header_penjualan'));
				}else{
					$this->session->set_flashdata('error', 'Data penjualan tidak berhasil diubah');
					redirect(base_url() . 'penjualan/open/' . $this->input->post('id_header_penjualan'));
				}
			}
		}	
	}

	public function validasiPrintPenjualan(){
		$nmr = $this->input->post('nmr');
		// var_dump($nmr);exit();
		$counter = $this->all_model->getCountHeaderPenjualans($nmr)->num_rows();
		// var_dump($nmr);exit();
		echo json_encode($counter);
	}
}
