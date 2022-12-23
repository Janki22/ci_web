<?php

class Category extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$admin = $this->session->userdata('admin');
		if(empty($admin)){
			$this->session->set_flashdata('msg','your session has been expired');
			redirect(base_url().'admin/login/index');
		}
	}
 
   public function index(){

	$this->load->model('Category_model');
	$queryString = $this->input->get('q');
	$params['queryString']  =$queryString;
	$categories = $this->Category_model->getCategories($params);
	$data['categories'] = $categories;
	$data['queryString'] = $queryString;
	$data['mainModule'] = 'category';
    $data['subModule'] =  'viewCategory'; 

      $this->load->view('admin/category/list',$data);
   }

   public function create(){

	$this->load->helpers('common_helper');
	$data['mainModule'] = 'category';
    $data['subModule'] =  'createCategory';
	//uploading file
	$config['upload_path']          = './public/uploads/category/';
 	$config['allowed_types'] = 'gif|jpg|png|jpeg|PNG|JPG|JPEG';
	$config['encrypt_name']        =  TRUE;
	 
 
 
	   $this->load->library('upload', $config);

		$this->load->model('Category_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<p class="invalid-feedback">','</p>');
		$this->form_validation->set_rules('name', 'Name' ,'trim|required');
		
		if($this->form_validation->run() == TRUE){

            //    print_r($_FILES);exit;
			if(!empty($_FILES['image']['name'])){
              //now a user has selected a file
			 if ($this->upload->do_upload('image')){
                //   file uploaded succesfully
				$data = $this->upload->data();
				// echo"<pre>";
				// print_r($data);
				// echo"</pre>";
                // exit;
				//resize part
			 
				resizeImage($config['upload_path'].$data['file_name'],$config['upload_path'].'thumb/'.$data['file_name'],1120,800);
				resizeImage($config['upload_path'].$data['file_name'],$config['upload_path'].'thumb/'.$data['file_name'],300,250);
		
				$formArray['image'] = $data['file_name'];
				$formArray['name'] = $this->input->post('name');
				 $formArray['status'] = $this->input->post('status');
			    $formArray['created_at'] = date('y-m-d H:s');
			   $this->Category_model->create($formArray);
			   $this->session->set_flashdata('success','Category added successful');
			   redirect(base_url().'admin/category/index');

			 }else{
                 //we got a same error
				 $error = $this->upload->display_errors("<p class='invalid-feedback'>",'</p>');
				 $data['errorImageUpload'] = $error;
			     $this->load->view('admin/category/create',$data);

			 }

			}else{
              
				//we will create category without image 
			$formArray['name'] = $this->input->post('name');
			$formArray['status'] = $this->input->post('status');
			$formArray['created_at'] = date('y-m-d H:s');
			$this->Category_model->create($formArray);

			$this->session->set_flashdata('success','Category added successful');
			redirect(base_url().'admin/category/index');

			}
			 
		} else{
			//WILL SHOW ERROR
			$this->load->view('admin/category/create',$data);
		}        
   }
   public function edit($id){
	//    echo $id;
	$this->load->model('Category_model');
	$data['mainModule'] = 'category';
    $data['subModule'] =  '';
    $category =  $this->Category_model->getCategory($id);
	// echo '<pre>';
	// print_r( $category);
    if (empty($category)){
		$this->session->set_flashdata('error','Category Not Found');
		redirect(base_url().'admin/category/index');
	}

	$this->load->helpers('common_helper');
	//uploading file
	$config['upload_path']          = './public/uploads/category/';
     $config['allowed_types'] = 'gif|jpg|png|jpeg|PNG|JPG|JPEG';
	$config['encrypt_name']        =  TRUE;
	 

	   $this->load->library('upload', $config);
 
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<p class="invalid-feedback">','</p>');
		$this->form_validation->set_rules('name', 'Name' ,'trim|required');
		
		if($this->form_validation->run() == TRUE){
			if(!empty($_FILES['image']['name'])){
				//now a user has selected a file
			   if ($this->upload->do_upload('image')){
				  //   file uploaded succesfully
				  $data = $this->upload->data();
				  //resize part
				  resizeImage($config['upload_path'].$data['file_name'],$config['upload_path'].'thumb/'.$data['file_name'],300,270);
				  $formArray['image'] = $data['file_name'];
				  $formArray['name'] = $this->input->post('name');
				   $formArray['status'] = $this->input->post('status');
				  $formArray['updated_at'] = date('y-m-d H:s');
				 $this->Category_model->update($id,$formArray);
				 
				 if(file_exists('./public/uploads/category/'.$category['image'])){
					unlink('./public/uploads/category/'.$category['image']) ;
				 } 
				 if(file_exists('./public/uploads/category/thumb'.$category['image'])){
					unlink('./public/uploads/category/thumb/'.$category['image']) ;
				 }

				 $this->session->set_flashdata('success','Category updated successful');
				 redirect(base_url().'admin/category/index');
  			   }else{
				   //we got a same error
				   $error = $this->upload->display_errors("<p class='invalid-feedback'>",'</p>');
				   $data['errorImageUpload'] = $error;
				   $data['category']  =$category;
                   $this->load->view('admin/category/edit',$data);
  			   }
  			  }else{
				  //we will create category without image 
			  $formArray['name'] = $this->input->post('name');
			  $formArray['status'] = $this->input->post('status');
			  $formArray['updated_at'] = date('y-m-d H:s');
			  $this->Category_model->update($id,$formArray);
  
			  $this->session->set_flashdata('success','Category updated successful');
			  redirect(base_url().'admin/category/index');
  
			  }
       

		}else{
		  $data['category']  =$category;
          $this->load->view('admin/category/edit',$data);
		}



  }
    
  public function delete($id){
	//   echo $id;
	$this->load->model('Category_model');
    $category =  $this->Category_model->getCategory($id);
	// echo '<pre>';
	// print_r( $category);
    if (empty($category)){
		$this->session->set_flashdata('error','Category Not Found');
		redirect(base_url().'admin/category/index');
	}
	if(file_exists('./public/uploads/category/'.$category['image'])){
		unlink('./public/uploads/category/'.$category['image']) ;
	 } 
	 if(file_exists('./public/uploads/category/thumb'.$category['image'])){
		unlink('./public/uploads/category/thumb/'.$category['image']) ;
	 }
	$this->Category_model->deleteCategory($id);
    $this->session->set_flashdata('success','category Deleted Successfully');
	redirect(base_url().'admin/category/index');
  }
 
}


?>
