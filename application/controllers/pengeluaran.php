<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengeluaran extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('all_model');
		if($this->session->userdata('logged_in') != 1){
			return redirect(base_url() . 'login');
		}
	}

	public function index()
	{
		// $condition = array('status_delete' => 0);
		// $data['header_pengeluaran'] = $this->all_model->getDataByCondition('header_pengeluaran', $condition)->result();
		// if($this->session->userdata('role') != 3){
			// $data['header_pengeluaran'] = $this->all_model->getHeaderPengeluaran()->result();
		// }else{
		// 	$data['header_pengeluaran'] = $this->all_model->getHeaderPengeluaranByOperator($this->session->userdata('location'))->result();
		// }
		if($this->session->userdata('role') == 3){
			$user = $this->all_model->getDataByCondition('user', array('id_user' => $this->session->userdata('id')))->row();
			$data['header_pengeluaran'] = $this->all_model->getHeaderPengeluaranByOperator($user->id_location)->result();
		}else{
			$data['header_pengeluaran'] = $this->all_model->getHeaderPengeluaran()->result();
		}
		$this->load->view('pengeluaran/index', $data);
	}

	public function add(){
		$month = date('m');
		$date = date('d');

		$order = "id_header_pengeluaran desc";
		$user = $this->all_model->getDataByCondition('user', array('id_user' => $this->session->userdata('id')))->row();
		$header_pengeluaran = $this->all_model->getHeaderPengeluaransByOperator($user->id_location, $month, $date)->row();
		// $header_pengeluaran = $this->all_model->getDataByLimitPengeluaran(array('status_delete'=>0), 1, $order, 'header_pengeluaran')->row();

		if(empty($header_pengeluaran)){
			// $pengeluaran = $this->all_model->getDataByLimitPengeluaran(array('status_delete'=>1), 1, $order, 'header_pengeluaran')->row();
			$pengeluaran = $this->all_model->getPengeluaranByDesc()->row();
			if(empty($pengeluaran)){
				$data['id_header_pengeluaran'] = 1;
				$data['tgl_pengeluaran'] = date('Y-m-d');
			}else{
				$data['id_header_pengeluaran'] = $pengeluaran->id_header_pengeluaran + 1;
				$data['tgl_pengeluaran'] = date('Y-m-d');
			}
		}else{
			// $data['id_header_penjualan'] = $header_penjualan->id_header_penjualan + 1;
			// $data['tgl_penjualan'] = date('Y-m-d');
			if($header_pengeluaran->tgl_pengeluaran == date('Y-m-d')){
				$this->session->set_flashdata('error', 'Data pengeluaran untuk hari ini sudah tersedia');
				redirect(base_url() . 'pengeluaran/index');
			}else{
				$data['id_header_pengeluaran'] = $header_pengeluaran->id_header_pengeluaran + 1;
				$data['tgl_pengeluaran'] = date('Y-m-d');
			}
		}

		$condition = array('id_user' => $this->session->userdata('id'));
		$data['user'] = $this->all_model->getDataByCondition('user', $condition)->row();
		$this->load->view('pengeluaran/add_pengeluaran_header', $data);
	}

	public function processAdd(){
		$data = array(
			'id_header_pengeluaran' => $this->input->post('id_header_pengeluaran'),
			'tgl_pengeluaran' => date('Y-m-d', strtotime($this->input->post('tgl_pengeluaran'))),
			'status'  => 0,
			'created_by' => $this->session->userdata('id'),
			'created_date' => date('Y-m-d H:i:s', strtotime(strtr($this->input->post('createdDate'), '-', '-'))),
			'updated_date' => '0000-00-00 00:00:00',
			'updated_by' => 0,
			'keterangan_delete' => '',
			'total' => 0,
			'status_delete' => 0,
			'deleted_date' => '0000-00-00 00:00:00',
			'deleted_by' => 0,
			'nomor_pengeluaran' => ''
		);
		$result = $this->all_model->insertData('header_pengeluaran', $data);
		if($result == true){
			$order = "id_header_pengeluaran desc";
		    $header_pengeluaran = $this->all_model->getDataByLimit(1, $order, 'header_pengeluaran')->row();
		    return redirect(base_url().'pengeluaran/detail/' . $header_pengeluaran->id_header_pengeluaran);
		}
		return redirect(base_url() . 'pengeluaran/add');
	}

	public function detail($id){
		$condition = array('id_header_pengeluaran' => $id);
		$data['header_pengeluaran'] = $this->all_model->getDataByCondition('header_pengeluaran', $condition)->row();
		$data['pengeluaran'] = $this->all_model->getDataByCondition('pengeluaran', array('status_delete' => 0, 'id_header_pengeluaran' => $id))->result();
		$condition = array('id_user' => $this->session->userdata('id'));
		$data['user'] = $this->all_model->getDataByCondition('user', $condition)->row();
		$this->load->view('pengeluaran/add_pengeluaran', $data);
	}

	public function processAddPengeluaran(){
		$this->form_validation->set_rules('item', 'Nama item', 'required');
		$this->form_validation->set_rules('harga', 'Harga', 'required');

		if($this->form_validation->run() == false){
			return redirect(base_url() . 'pengeluaran/detail/' . $this->input->post('id_header_pengeluaran'));
		}else{ 
			$harga = str_replace(".", "", $this->input->post('harga'));
			$data = array(
				'item' => $this->input->post('item'),
				'price' => $harga,
				'keterangan' => $this->input->post('keterangan'),
				'status' => 0,
				'created_date' => date('Y-m-d'),
				'created_by' => $this->session->userdata('id'),
				'id_header_pengeluaran' => $this->input->post('id_header_pengeluaran')
			);
			$res = $this->all_model->insertData("pengeluaran", $data);
			if($res == true){
				$condition = array('id_header_pengeluaran' => $this->input->post('id_header_pengeluaran'));
				$res = $this->all_model->getDataByCondition('header_pengeluaran', $condition)->row();
				$total = $res->total + $harga;
				$dataHeaderPengeluaran = array(
					'total' => $total
				);
				// var_dump($dataHeaderPenjualan);exit();
				$headerPengeluaran = $this->all_model->updateData('header_pengeluaran', $condition, $dataHeaderPengeluaran);
				if($headerPengeluaran == true){
					$this->session->set_flashdata('success', 'Data item berhasil disimpan');
					redirect(base_url() . 'pengeluaran/detail/' . $this->input->post('id_header_pengeluaran'));
				}
				$this->session->set_flashdata('error', 'Data item tidak berhasil disimpan');
				redirect(base_url() . 'pengeluaran/detail/' . $this->input->post('id_header_pengeluaran'));
			}
			$this->session->set_flashdata('error', 'Data item tidak berhasil disimpan');
				redirect(base_url() . 'pengeluaran/detail/' . $this->input->post('id_header_pengeluaran'));
		}
	}

	public function edit(){
		$condition = array('id_pengeluaran' => $this->input->get('id'));
    	$data['pengeluaran'] = $this->all_model->getDataByCondition('pengeluaran', $condition)->row();
    	echo json_encode($data);
	}


	public function processEditPengeluaran(){
		$this->form_validation->set_rules('item', 'Nama item', 'required');
		$this->form_validation->set_rules('harga', 'Harga', 'required');

		$harga = str_replace(".", "", $this->input->post('harga'));

		$con = array('id_pengeluaran' => $this->input->post('id_pengeluaran'));
		$result = $this->all_model->getDataByCondition('pengeluaran', $con)->row();

		if($this->form_validation->run() == false){
			return redirect(base_url() . 'pengeluaran/detail/' . $this->input->post('id_header_pengeluaran'));
		}else{ 
			$condition = array('id_header_pengeluaran' => $this->input->post('id_header_pengeluaran'));
			$res = $this->all_model->getDataByCondition('header_pengeluaran', $condition)->row();

			$total = $res->total - $result->price + $harga;
			$dataHeaderPengeluaran = array(
				'total' => $total,
				'updated_date' => date('Y-m-d'),
				'updated_by' => $this->session->userdata('id')
			);

			$headerPengeluaran = $this->all_model->updateData('header_pengeluaran', $condition, $dataHeaderPengeluaran);
			if($headerPengeluaran == true){
				$data = array(
					'item' => $this->input->post('item'),
					'price' => $harga,
					'keterangan' => $this->input->post('keterangan'),
					'status' => 0,
					'updated_date' => date('Y-m-d'),
					'updated_by' => $this->session->userdata('id'),
					'id_header_pengeluaran' => $this->input->post('id_header_pengeluaran')
				);

				$res_pengeluaran = $this->all_model->updateData("pengeluaran", $con, $data);
				if($res_pengeluaran == true){
					$this->session->set_flashdata('success', 'Data item berhasil disimpan');
					redirect(base_url() . 'pengeluaran/detail/' . $this->input->post('id_header_pengeluaran'));
				}
				$this->session->set_flashdata('error', 'Data item tidak berhasil disimpan');
				redirect(base_url() . 'pengeluaran/detail/' . $this->input->post('id_header_pengeluaran'));
			}
			$this->session->set_flashdata('error', 'Data item tidak berhasil disimpan');
			redirect(base_url() . 'pengeluaran/detail/' . $this->input->post('id_header_pengeluaran'));
		}
	}

	public function deleteItem(){
		$con = array('id_pengeluaran' => $this->input->post('id'));
		$pengeluaran = $this->all_model->getDataByCondition('pengeluaran', $con)->row();

		$condition = array('id_header_pengeluaran' => $pengeluaran->id_header_pengeluaran);
		$res = $this->all_model->getDataByCondition('header_pengeluaran', $condition)->row();

		$total = $res->total - $pengeluaran->price;
		$dataHeaderPengeluaran = array(
			'total' => $total
		);

		$headerPengeluaran = $this->all_model->updateData('header_pengeluaran', $condition, $dataHeaderPengeluaran);
		if($headerPengeluaran == true){
			$data = array(
				'status_delete' => 1,
				'deleted_by' => $this->session->userdata('id'),
				'deleted_date' => date('Y-m-d'),
				'keterangan_delete' => $this->input->post('keterangan_delete')
			);

			$res_pengeluaran = $this->all_model->updateData("pengeluaran", $con, $data);
			if($res_pengeluaran == true){
				$this->session->set_flashdata('success', 'Data item berhasil dihapus');
				redirect(base_url() . 'pengeluaran/detail/' . $pengeluaran->id_header_pengeluaran);
			}
			$this->session->set_flashdata('error', 'Data item tidak berhasil dihapus');
			redirect(base_url() . 'pengeluaran/detail/' . $pengeluaran->id_header_pengeluaran);
		}
		$this->session->set_flashdata('error', 'Data item tidak berhasil dihapus');
		redirect(base_url() . 'pengeluaran/detail/' . $pengeluaran->id_header_pengeluaran);
	}

	public function checkout($id){
		$condition = array('id_header_pengeluaran' => $id);

		$tahun = date('y');
		$bulan = date('m');

		$con = array('id_user' => $this->session->userdata('id'));
		$user = $this->all_model->getDataByCondition('user', $con)->row();
		// var_dump($user->id_location);exit();
		$nmr = sprintf('%02d', $user->id_location);
		$p = $this->all_model->getHeaderPengeluaranByLimit($nmr)->row();
		// var_dump($nmr);exit();
		if(empty($p)){
			$nmrs = $nmr. '/OUT/' . $tahun . '/' . $bulan . '/' . sprintf('%04d', 1);
		}else{
			$counter_in = explode("/", $p->nomor_pengeluaran);
			if($counter_in[3] == $bulan && $counter_in[2] == $tahun){
				$tamp = sprintf('%04d', $counter_in[4] + 1);
				$nmrs = $nmr. '/OUT/' . $tahun . '/' . $bulan . '/' . $tamp;
			}else{
				$nmrs = $nmr. '/OUT/' . $tahun . '/' . $bulan . '/' . sprintf('%04d', 1);
			}
			// }else if($counter_in[3] != $bulan && $counter_in[2] == $tahun){
			// 	$nmrs = $nmr. '/INV/' . $tahun . '/' . $bulan . '/' . sprintf('%04d', 1);
			// }else if($counter_in[3] == $bulan && $counter_in[2] != $tahun){
			// 	$nmrs = $nmr. '/INV/' . $tahun . '/' . $bulan . '/' . sprintf('%04d', 1);
			// }
		}

		$pengeluaran = array(
			'status' => 1
		);

		$header_pengeluaran = array(
			'nomor_pengeluaran' => $nmrs,
			'status' => 1
		);

		$res_pengeluaran = $this->all_model->updateData('pengeluaran', $condition, $pengeluaran);
		if($res_pengeluaran == true){
			$res_header = $this->all_model->updateData('header_pengeluaran', $condition, $header_pengeluaran);
			if($res_header == true){
				$this->session->set_flashdata('success', 'Data pengeluaran berhasil checkout');
				redirect(base_url() . 'pengeluaran/detail/' . $id);
			} 
			$this->session->set_flashdata('error', 'Data pengeluaran gagal checkout');
			redirect(base_url() . 'pengeluaran/detail/' . $id);
		}
		$this->session->set_flashdata('error', 'Data pengeluaran gagal checkout');
		redirect(base_url() . 'pengeluaran/detail/' . $id);
	}

	public function view($id){
		$condition = array('id_header_pengeluaran' => $id);
		$data['header_pengeluaran'] = $this->all_model->getDataByCondition('header_pengeluaran', $condition)->row();
		$data['pengeluaran'] = $this->all_model->getDataByCondition('pengeluaran', array('status_delete' => 0, 'id_header_pengeluaran' => $id))->result();
		$condition = array('id_user' => $this->session->userdata('id'));
		$data['user'] = $this->all_model->getDataByCondition('user', $condition)->row();
		$this->load->view('pengeluaran/view_pengeluaran', $data);
	}

	public function delete(){
		$condition = array('id_header_pengeluaran' => $this->input->post('id'));
		$data = array(
			'status_delete' => 1,
			'keterangan_delete' => $this->input->post('keterangan'),
			'deleted_by'  => $this->session->userdata('id'),
			'deleted_date' => date('Y-m-d')
		);
		$res_header = $this->all_model->updateData('header_pengeluaran', $condition, $data);
		if($res_header == true){
			$this->session->set_flashdata('success', 'Data pengeluaran berhasil dihapus');
			redirect(base_url() . 'pengeluaran/index');
		} 
		$this->session->set_flashdata('error', 'Data pengeluaran gagal dihapus');
		redirect(base_url() . 'pengeluaran/index');
	}

	public function open($id){
		$condition = array('id_header_pengeluaran' => $id);
		$data['header_pengeluaran'] = $this->all_model->getDataByCondition('header_pengeluaran', $condition)->row();
		$data['pengeluaran'] = $this->all_model->getDataByCondition('pengeluaran', array('status_delete' => 0, 'id_header_pengeluaran' => $id))->result();
		$condition = array('id_user' => $this->session->userdata('id'));
		$data['user'] = $this->all_model->getDataByCondition('user', $condition)->row();
		$this->load->view('pengeluaran/open_pengeluaran', $data);
	}

	public function processOpenPengeluaran(){
		$this->form_validation->set_rules('item', 'Nama item', 'required');
		$this->form_validation->set_rules('harga', 'Harga', 'required');

		if($this->form_validation->run() == false){
			return redirect(base_url() . 'pengeluaran/detail/' . $this->input->post('id_header_pengeluaran'));
		}else{ 
			$condition = array('id_header_pengeluaran' => $this->input->post('id_header_pengeluaran'));
			$headers_pengeluaran = $this->all_model->getDataByCondition('header_pengeluaran', $condition)->row();

			if($headers_pengeluaran->nomor_pengeluaran != $this->input->post('nmr_pengeluaran')){
				$counter_in = explode("/", $this->input->post('nmr_pengeluaran'));
				$nmr = $counter_in[0] . '/' . $counter_in[1] . '/' . $counter_in[2] . '/' . $counter_in[3]. '/';
				$nmr_pengeluaran = $this->all_model->getHeaderPengeluaranByLimitDesc($nmr)->row();
				$counter_db = explode("/", $nmr_pengeluaran->nomor_pengeluaran);
				$tamp_db = (int)$counter_db[4] + 1;
				
				// var_dump($tamp_db);exit();
				if($counter_in[4] != sprintf('%04d', $tamp_db)){
					$error = "Nomor invoice seharusnya : " .  $counter_in[0] . '/' . $counter_in[1] . '/' . $counter_in[2] . '/' . $counter_in[3]. '/' . sprintf('%04d', $tamp_db);
					$this->session->set_flashdata('error', $error);
					return redirect(base_url().'pengeluaran/open/' . $this->input->post('id_header_pengeluaran'));
				}
				$nmrs = $counter_in[0] . '/' . $counter_in[1] . '/' . $counter_in[2] . '/' . $counter_in[3]. '/' . sprintf('%04d', $tamp_db);
			}else{
				$nmrs = $headers_pengeluaran->nomor_pengeluaran;
			}

			$harga = str_replace(".", "", $this->input->post('harga'));
			$data = array(
				'item' => $this->input->post('item'),
				'price' => $harga,
				'keterangan' => $this->input->post('keterangan'),
				'status' => 1,
				'created_date' => date('Y-m-d'),
				'created_by' => $this->session->userdata('id'),
				'id_header_pengeluaran' => $this->input->post('id_header_pengeluaran')
			);
			$res = $this->all_model->insertData("pengeluaran", $data);
			if($res == true){
				$condition = array('id_header_pengeluaran' => $this->input->post('id_header_pengeluaran'));
				$res = $this->all_model->getDataByCondition('header_pengeluaran', $condition)->row();
				$total = $res->total + $harga;
				$dataHeaderPengeluaran = array(
					'total' => $total,
					'nomor_pengeluaran' => $nmrs
				);
				// var_dump($dataHeaderPenjualan);exit();
				$headerPengeluaran = $this->all_model->updateData('header_pengeluaran', $condition, $dataHeaderPengeluaran);
				if($headerPengeluaran == true){
					$this->session->set_flashdata('success', 'Data item berhasil disimpan');
					redirect(base_url() . 'pengeluaran/open/' . $this->input->post('id_header_pengeluaran'));
				}
				$this->session->set_flashdata('error', 'Data item tidak berhasil disimpan');
				redirect(base_url() . 'pengeluaran/open/' . $this->input->post('id_header_pengeluaran'));
			}
			$this->session->set_flashdata('error', 'Data item tidak berhasil disimpan');
				redirect(base_url() . 'pengeluaran/open/' . $this->input->post('id_header_pengeluaran'));
		}
	}

	public function processOpenEditPengeluaran(){
		$this->form_validation->set_rules('item', 'Nama item', 'required');
		$this->form_validation->set_rules('harga', 'Harga', 'required');

		$harga = str_replace(".", "", $this->input->post('harga'));

		$con = array('id_pengeluaran' => $this->input->post('id_pengeluaran'));
		$result = $this->all_model->getDataByCondition('pengeluaran', $con)->row();

		if($this->form_validation->run() == false){
			return redirect(base_url() . 'pengeluaran/detail/' . $this->input->post('id_header_pengeluaran'));
		}else{ 
			$condition = array('id_header_pengeluaran' => $this->input->post('id_header_pengeluaran'));
			$res = $this->all_model->getDataByCondition('header_pengeluaran', $condition)->row();

			$total = $res->total - $result->price + $harga;
			$dataHeaderPengeluaran = array(
				'total' => $total,
				'updated_date' => date('Y-m-d'),
				'updated_by' => $this->session->userdata('id')
			);

			$headerPengeluaran = $this->all_model->updateData('header_pengeluaran', $condition, $dataHeaderPengeluaran);
			if($headerPengeluaran == true){
				$data = array(
					'item' => $this->input->post('item'),
					'price' => $harga,
					'keterangan' => $this->input->post('keterangan'),
					'status' => 1,
					'updated_date' => date('Y-m-d'),
					'updated_by' => $this->session->userdata('id'),
					'id_header_pengeluaran' => $this->input->post('id_header_pengeluaran')
				);

				$res_pengeluaran = $this->all_model->updateData("pengeluaran", $con, $data);
				if($res_pengeluaran == true){
					$this->session->set_flashdata('success', 'Data item berhasil disimpan');
					redirect(base_url() . 'pengeluaran/open/' . $this->input->post('id_header_pengeluaran'));
				}
				$this->session->set_flashdata('error', 'Data item tidak berhasil disimpan');
				redirect(base_url() . 'pengeluaran/open/' . $this->input->post('id_header_pengeluaran'));
			}
			$this->session->set_flashdata('error', 'Data item tidak berhasil disimpan');
			redirect(base_url() . 'pengeluaran/open/' . $this->input->post('id_header_pengeluaran'));
		}
	}

	public function open_checkout($id){
		$condition = array('id_header_pengeluaran' => $id);
		$headers_pengeluaran = $this->all_model->getDataByCondition('header_pengeluaran', $condition)->row();
		// var_dump($this->input->post('id_head'));exit();
		if($headers_pengeluaran->nomor_pengeluaran != $this->input->post('id_head')){
			$counter_in = explode("/", $this->input->post('id_head'));
			$nmr = $counter_in[0] . '/' . $counter_in[1] . '/' . $counter_in[2] . '/' . $counter_in[3]. '/';
			$nmr_pengeluaran = $this->all_model->getHeaderPengeluaranByLimitDesc($nmr)->row();
			$counter_db = explode("/", $nmr_pengeluaran->nomor_pengeluaran);
			$tamp_db = (int)$counter_db[4] + 1;
			
			// var_dump($tamp_db);exit();
			if($counter_in[4] != sprintf('%04d', $tamp_db)){
				$error = "Nomor invoice seharusnya : " .  $counter_in[0] . '/' . $counter_in[1] . '/' . $counter_in[2] . '/' . $counter_in[3]. '/' . sprintf('%04d', $tamp_db);
				$this->session->set_flashdata('error', $error);
				return redirect(base_url().'pengeluaran/open/' . $id);
			}
			$nmrs = $counter_in[0] . '/' . $counter_in[1] . '/' . $counter_in[2] . '/' . $counter_in[3]. '/' . sprintf('%04d', $tamp_db);
		}else{
			$nmrs = $headers_pengeluaran->nomor_pengeluaran;
		}

		
		$pengeluaran = array(
			'status' => 1
		);
		$header_pengeluaran = array(
			'status' => 1,
			'nomor_pengeluaran' => $nmrs
		);

		$res_pengeluaran = $this->all_model->updateData('pengeluaran', $condition, $pengeluaran);
		if($res_pengeluaran == true){
			$res_header = $this->all_model->updateData('header_pengeluaran', $condition, $header_pengeluaran);
			if($res_header == true){
				$this->session->set_flashdata('success', 'Data pengeluaran berhasil diedit');
				// redirect(base_url() . 'pengeluaran/open/' . $id);
				redirect(base_url() . 'pengeluaran/index');
			} 
			$this->session->set_flashdata('error', 'Data pengeluaran gagal checkout');
			redirect(base_url() . 'pengeluaran/open/' . $id);
		}
		$this->session->set_flashdata('error', 'Data pengeluaran gagal checkout');
		redirect(base_url() . 'pengeluaran/open/' . $id);
	}
}
