<?php 

class Login_model extends CI_model{


  public function getByUsername($username){
	
  $this->db->where('username',$username);
  $admin = 	$this->db->get('admins')->row_array();
  return $admin;
  }

}



?>
