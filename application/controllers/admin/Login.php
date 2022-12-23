<?php 

class Login extends CI_Controller {

	 
	public function index()
	{
	//    echo	password_hash('admin',PASSWORD_DEFAULT);
	$admin = $this->session->userdata('admin');
	if(!empty($admin)) {
			redirect(base_url().'admin/home/index');
	}
		$this->load->library('form_validation');
		$this->load->view('admin/login');
	}

	public function authenticate(){
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('Login_model');
	
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if ($this->form_validation->run() == true) {
            //success  
			$username = $this->input->post('username');
			$admin = $this->Login_model->getByUsername($username);
			// print_r($admin);
			 if(!empty($admin)){
			   $password = $this->input->post('password');
				if(password_verify($password,$admin['password']) == true){
					$adminArray['admin_id'] = $admin['id'];
					$adminArray['username'] = $admin['username'];
					$this->session->set_userdata('admin' ,$adminArray);
					redirect(base_url().'admin/home/index');

				}else{
					$this->session->set_flashdata('msg','Either username or password incorrect');
					redirect(base_url().'admin/login/index');	
				}
              
			 }else{
				$this->session->set_flashdata('msg','Either username or password incorrect');
				redirect(base_url().'admin/login/index');
			 }
		}else{
         // form error
         $this->load->view('admin/login');
		}


	}

	function logout() {
        $this->session->unset_userdata('admin');
        redirect(base_url().'admin/login/index');
    }
	 
}
