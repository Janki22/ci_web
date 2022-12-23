<?php
    class Page extends CI_Controller {

        public function about()
        {
            $this->load->view('front/about');
        }

        public function services()
        {
            $this->load->view('front/services');
        }

		public function contact(){
            $this->load->view('front/contact_us');

		}
    }

?>
