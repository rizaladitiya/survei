<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	function __construct(){
		parent::__construct();		
		$this->load->model(array('pertanyaan_model','jawaban_model','data_model','about_model'));
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
		$this->load->view('dashboard',$data);
	}
	public function harian()
	{
		$dari=$this->input->post('datetime');
		$hingga=$this->input->post('datetime2');
		if(!empty($dari)&&!empty($hingga))
		{
				$data['datetime']=$this->input->post('datetime');
				$data['datetime2']=$this->input->post('datetime2');
				$data['survey'] = $this->data_model->get_by_tanggal($this->input->post('datetime'),$this->input->post('datetime2'))->result();
			}else{
				$data['datetime']='';
				$data['datetime2']='';
			}
		$data['nama'] = $this->session->userdata('logged_in')['nama'];
		$data['user'] = $this->session->userdata('logged_in')['user'];
		$data['email'] = $this->session->userdata('logged_in')['email'];
		$this->load->view('harian',$data);
	}
	public function bulanan()
	{
		$dari=$this->input->post('datetime');
		if(!empty($dari))
		{
				$data['datetime']=$this->input->post('datetime');
				//$data['survey'] = $this->data_model->get_by_tanggal($this->input->post('datetime'),$this->input->post('datetime2'))->result();
			}else{
				$data['datetime']=date('Y-m');
			}
		$data['nama'] = $this->session->userdata('logged_in')['nama'];
		$data['user'] = $this->session->userdata('logged_in')['user'];
		$data['email'] = $this->session->userdata('logged_in')['email'];
		$this->load->view('bulanan',$data);
	}
	
	public function kesimpulan()
	{
		$dari=$this->input->post('datetime');
		if(!empty($dari))
		{
				$data['datetime']=$this->input->post('datetime');
				$data['survey'] = $this->pertanyaan_model->get_by_bobot()->result();
			}else{
				$data['datetime']=date('Y-m');
			}
		$data['nama'] = $this->session->userdata('logged_in')['nama'];
		$data['user'] = $this->session->userdata('logged_in')['user'];
		$data['email'] = $this->session->userdata('logged_in')['email'];
		$this->load->view('kesimpulan',$data);
	}
}
