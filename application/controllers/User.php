<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	
	function __construct(){
		parent::__construct();		
		$this->load->model(array('about_model','user_model'));
		$this->load->helper(array('url','form'));
		
		if(!$this->session->userdata('logged_in'))
   			
   		{
     		//If no session, redirect to login page
     		redirect('auth', 'refresh');
   		}
 
	}
	
	public function index()
	{
		$data['nama'] = $this->session->userdata('logged_in')['nama'];
		$data['user'] = $this->session->userdata('logged_in')['user'];
		$data['email'] = $this->session->userdata('logged_in')['email'];
		$data['id'] = $this->session->userdata('logged_in')['id'];
		$this->load->view('user',$data);
	}
	public function save()
	{
		
		$id=$this->input->post('id');
		$password=$this->input->post('password');
		if(empty($password)){
		$data=array(
					'nama'=>$this->input->post('nama'),
					'user'=>$this->input->post('user'),
					'email'=>$this->input->post('email')
					);
		}else{
			$data=array(
					'nama'=>$this->input->post('nama'),
					'user'=>$this->input->post('user'),
					'email'=>$this->input->post('email'),
					'password'=>md5($this->input->post('password'))
					);
		}
		$this->user_model->update($id,$data);
		$sess_array = array(
         'id' => $this->input->post('id'),
         'user' => $this->input->post('user'),
         'nama' => $this->input->post('nama'),
		 'email' => $this->input->post('email')
       );
       $this->session->set_userdata('logged_in', $sess_array);
		redirect('user', 'refresh');	
        
	}
	
}
