<?php 

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$admin = $this->session->userdata('admin');
		if(empty($admin)){
			$this->session->set_flashdata('msg','your session has been expired');
			redirect(base_url().'admin/login/index');
		}
	}
	 
	public function index()
	{ 
	 $admin = $this->session->userdata('admin');
		// print_r($admin);
		$this->load->view('admin/dashboard');
	}



}
