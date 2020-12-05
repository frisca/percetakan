<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class History_Item extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('all_model');
		if($this->session->userdata('logged_in') != 1){
			return redirect(base_url() . 'login');
		}
	}

	public function index()
	{
		$data['history'] = $this->all_model->getHistoryItem()->result();
		$this->load->view('history-item/index', $data);
    }
    
    public function view($id)
	{
		$data['history'] = $this->all_model->getHistoryItemById($id)->row();
		$this->load->view('history-item/view', $data);
	}
}
