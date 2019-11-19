<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH."/third_party/Twiliomaster/Twilio/autoload.php";
use Twilio\Rest\Client;

class Memo extends CI_Controller {
	
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
	
	public function send()
	{
		
		
		$data=$this->data;
		$data['pegawais'] = $this->pegawai_model->get_by_all()->result();
		$pesan = $this->input->post('pesan');
		$arrnomer=$this->input->post('kepada');
		
		
		
		$sid    = "ACf37f803b49ecbd61d95c14466d8c6d52";
		$token  = "6ef11e5e9ad095fb1762d2d9c4d700a0";
		$twilio = new Client($sid, $token);
		foreach($arrnomer as $value){
		$nomer = "whatsapp:+".$value;
		$message = $twilio->messages
						  ->create($nomer, // to
								   array(
									   "from" => "whatsapp:+14155238886",
									   "body" => $pesan
								   )
						  );
		}
		//print($message->sid);
		if($message){
		$data['message']="Berhasil Terkirim";
		}else{
		$data['message']="";
		}
     		$this->load->view('memo/send',$data);
		//redirect($this->agent->referrer(), 'refresh');
	

	}
	public function index()
	{
		$data=$this->data;
		$data['pegawais'] = $this->pegawai_model->get_by_all()->result();
		
		//print_r($data);
		$this->load->view('memo/send',$data);
	}
	
	
}

