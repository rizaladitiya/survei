<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin2 extends CI_Controller {
	
	function __construct(){
		parent::__construct();		
		$this->load->model(array('pertanyaan_model','jawaban_model','data2_model','about_model'));
		$this->load->helper(array('url','form'));
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		
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
		$this->load->view('dashboard',$data);
	}
	
	public function bulanan()
	{
		$dari=$this->input->post('datetime');
		$hingga=$this->input->post('datetime2');
		if(!empty($dari))
		{
				$data['datetime']=$this->input->post('datetime');
				//$data['survey'] = $this->data_model->get_by_tanggal($this->input->post('datetime'),$this->input->post('datetime2'))->result();
			}else{
				$data['datetime']=date('Y-m-d');
			}
		if(!empty($hingga))
		{
				$data['datetime2']=$this->input->post('datetime2');
				//$data['survey'] = $this->data_model->get_by_tanggal($this->input->post('datetime'),$this->input->post('datetime2'))->result();
			}else{
				$data['datetime2']=date('Y-m-d');
			}
		$data['nama'] = $this->session->userdata('logged_in')['nama'];
		$data['user'] = $this->session->userdata('logged_in')['user'];
		$data['email'] = $this->session->userdata('logged_in')['email'];
		$this->load->view('bulanan2',$data);
	}
	
	public function kesimpulan()
	{
		$dari=$this->input->post('datetime');
		$hingga=$this->input->post('datetime2');
		if(!empty($dari))
		{
				$data['datetime']=$this->input->post('datetime');
			}else{
				$data['datetime']=date('Y-m-d');
			}
		if(!empty($hingga))
		{
				$data['datetime2']=$this->input->post('datetime2');
			}else{
				$data['datetime2']=date('Y-m-d');
			}
		
		$data['survey'] = $this->pertanyaan_model->get_by_bobot()->result();
		$data['nama'] = $this->session->userdata('logged_in')['nama'];
		$data['user'] = $this->session->userdata('logged_in')['user'];
		$data['email'] = $this->session->userdata('logged_in')['email'];
		$this->load->view('kesimpulan2',$data);
	}
}
