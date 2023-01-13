<?php
    class Blog extends CI_Controller {

        public function index()
        {   
            $this->load->model('Article_model');
            $this->load->helper('text');

            $articles = $this->Article_model->getArticlesFront();
            $data = [];
            $data['articles'] = $articles;
            $this->load->view('front/blog', $data);
        }

        public function categories() 
        {
            $this->load->model('Category_model');

            $categories = $this->Category_model->getCategoriesFront();
            $data = [];
            $data['categories'] = $categories;
            // print_r($categories);
            $this->load->view('front/categories', $data);

        }

		public function contactUs() 
        {
			$this->load->library('form_validation');

			$this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_error_delimiters('<p class="invalid-feedback">','</p>');

			if ($this->form_validation->run() == true)
			{
				$config = Array(
					'protocol' => 'smtp',
					'smtp_host' => 'ssl://smtp.googlemail.com',
					'smtp_port' => 465,
					'smtp_user' => 'jankisurya09@gmail.com',
					'smtp_pass' => 'jenisurya1',
					'mailtype' => 'html',
					'charset' => 'iso-8859-1'
					);
					$this->load->library('email', $config);
					$this->email->set_newline("\r\n");

                    $this->email->to('test@gmail.com');
                    $this->email->from('example@example.com');
                    $this->email->subject('you  have received anenquiry');

                    $name = $this->input->post('name');
                    $email = $this->input->post('email');
                    $msg = $this->input->post('message');

                    $message = "Name: ".$name;
                    $message .=  "<br>";
                    $message .= "Email: ".$email;
                    $message .=  "<br>";
                    $message .= "Message: ".$msg;
                    $message .=  "<br>";
                    $message .=  "<br>";
                    $message .= "Thanks";
                    $this->email->message($message);
					$this->email->send();

                    $this->session->set_flashdata('msg','Thanks for message');

                    redirect('blog/contactUs');

			}
			else
			{
				$this->load->view('front/contact_us');
			}

            

        }

       
    }

?>
