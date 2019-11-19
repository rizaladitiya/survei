<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {
	
	function __construct(){
		parent::__construct();		
		//error_reporting(0);
        //ini_set('display_errors', 0); 
		$this->load->model(array('about_model','user_model','pegawai_model'));
		$this->load->helper(array('url','form'));
		$this->load->library('user_agent');
		
		$sess = getsession();
		$this->id = $sess->id;
		$this->nama = $sess->nama;
		
		$this->data['id'] = $sess->id;
		$this->data['user'] = $sess->user;
		$this->data['nama'] = $sess->nama;
		
		if(!$this->session->userdata('logged_in'))
   			
   		{
     		//If no session, redirect to login page
     		redirect('auth', 'refresh');
   		}
 
	}
	
	public function index()
	{
		
	}
	public function pegawaiupdate()
	{
		
		$data=$this->data;
		$id=$this->uri->segment(3);
		if(!empty($id)){
		
		$pegawais = $this->pegawai_model->get_by_id($id)->result();
		foreach($pegawais as $value){
				$hasil=(object) array(
										'id'=>$value->id,
										'nama'=>$value->nama,
										'nrp'=>$value->nrp,
										'pangkat'=>$value->pangkat,
										'jabatan'=>$value->jabatan,
										'kesatuan'=>$value->kesatuan,
										'gelar'=>$value->gelar,
										'hp'=>$value->hp
									);
			}
		$data['pegawai'] = $hasil;
		}
		
		//print_r($data);
		$this->load->view('master/pegawaiupdate',$data);
	}
	public function pegawai()
	{
		
		$data=$this->data;
		$data['pegawais'] = $this->pegawai_model->get_by_all()->result();
		
		$this->load->view('master/pegawai',$data);
	}
	public function pegawaisave()
	{
		$pegawai=array(
						'nama'=>$this->input->post('nama'),
						'nrp'=>$this->input->post('nrp'),
						'pangkat'=>$this->input->post('pangkat'),
						'jabatan'=>$this->input->post('jabatan'),
						'kesatuan'=>$this->input->post('kesatuan'),
						'gelar'=>$this->input->post('gelar'),
						'hp'=>$this->input->post('hp')
						);
		if($this->input->post('id')==0){
			$this->pegawai_model->add($pegawai);
		}else{
			$this->pegawai_model->update($this->input->post('id'),$pegawai);
		}
		redirect(base_url('master/pegawai'), 'refresh');
	}
	public function pegawaidelete()
	{
		$id=$this->uri->segment(3);
		if(!empty($id)){
			$this->pegawai_model->delete($id);
		}
		redirect($this->agent->referrer(), 'refresh');
	}
	public function pegawaidata()
	{
		
		$json_data = $this->pegawai_model->get_by_all()->result();
		echo json_encode($json_data);
	}
	
}

