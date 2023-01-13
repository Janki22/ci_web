<?php $this->load->view('front/header')?>
 
<div class="container-fluid"  style="background-image: url('<?= base_url('public/images/ball-bright-close-up-clouds-207489.jpg')?>'); ">
 
<div class="row">

  <div class="col-md-12">
  <h1 class="text-center text-white pt-5">Contact Us</h1>
   </div>
   <div class="container mt-5">
	<div class="row mb-5">
		<div class="col-md-7">
			<div class="card h-100">
            <div class="card-header bg-secondary text-white">
				Have Question Or comments?
			</div>
			<div class="card-body">
				<?php  if(!empty($this->session->flashdata('msg'))){
				?>	<div class="alert alert-success">
					<?php echo $this->session->flashdata('msg'); ?>
				</div>
				<?php
				}
				?>
				<form action="<?php echo base_url('blog/contactUs') ?>" method="post" id="contact-form" name="contact-form">
			        <div class="form-group">
                    <label>Name</label>
                    <input type="text" value="<?php echo set_value('name') ?>"  id="name" placeholder="Name" name="name" class="form-control <?php echo (form_error('name') != "") ?  'is-invalid' : ''; ?>">
					<?php  echo form_error('name')?>
                     </div>
                 <div class="form-group">
                 <label>Email</label>
                 <input type="text" value="<?php echo set_value('email') ?>" id="email" placeholder="Email" name="email" class="form-control <?php echo (form_error('email') != "")? 'is-invalid' : '';  ?>" >
				 <?php  echo form_error('email')?>
               </div>
			   <div class="form-group">
                 <label>Message</label>
                 <textarea name="message" value="<?php echo set_value('message') ?>"  class="form-control" id="message" rows="5"></textarea>
               </div>
            <button type="submit" id="submit" class="btn btn-primary">Submit</button>
            </form>
			</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card h-100">
			<div class="card-header bg-secondary text-white">
			Reach Us 
			</div>
			<div class="card-body">
				<p> <strong>Customer Service:</strong></p>
				<p class="mb-0">Phone: +91 2321 458 XX</p>
				<p class="mb-0">Email: support@test.com</p>
				<p class="pt-2"> &nbsp; </p>
				<p> <strong>Headquarter:</strong></p>
				<p class="mb-0">Company Inc,</p>
				<p class="mb-0">Las vegas street 201</p>
				<p class="mb-0">Phone: +91 2321 458 XX</p>
				<p class="mb-0">example@test.com</p>
				<p> <strong>India:</strong></p>
				<p class="mb-0">Company Inc LTD</p>
				<p class="mb-0">125 Park Street Avenue</p>
				<p class="mb-0">UP, India</p>
				<p class="mb-0">Phone: +91 XXX 203 XX</p>
				<p class="mb-0">ine@mysite.com</p>
			</div>
			</div>
		</div>
	</div>
   </div>
</div>
  
 </div>

<?php $this->load->view('front/footer')?>
