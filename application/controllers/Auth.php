<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	
	function __construct(){
		parent::__construct();		
		$this->load->model(array('user_model','about_model'));
		$this->load->helper(array('url','form'));
 
	}

	public function index()
	{
		$this->load->view('login');
	}
        
	public function login()
	{
    //Field validation succeeded.  Validate against database
   $user = $this->input->post('user');
   $password = $this->input->post('password');
 
   //query the database
   $result = $this->user_model->login($user, $password);
 
   if($result)
   {
     $sess_array = array();
     foreach($result as $row)
     {
       $sess_array = array(
         'id' => $row->id,
         'user' => $row->user,
         'nama' => $row->nama,
		 'email' => $row->email
       );
       $this->session->set_userdata('logged_in', $sess_array);
     }
     redirect('admin');
   }
   else
   {
	 $data['message']="Periksa Kembali User";
     $this->load->view('login',$data);
   }
	}
        
        public function logout()
	{
                $this->session->unset_userdata('logged_in');
   				session_destroy();
   				redirect('auth', 'refresh');
	}
}
