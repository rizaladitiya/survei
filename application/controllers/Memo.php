<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH."/third_party/Twiliomaster/Twilio/autoload.php";
use Twilio\Rest\Client;

class Memo extends CI_Controller {
	
	private $limit=30;
	function __construct(){
		parent::__construct();		
		//error_reporting(0);
        //ini_set('display_errors', 0); 
		$this->load->model(array('about_model','user_model','pegawai_model','logwa_model'));
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
		
		$message=1;
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
			foreach($arrnomer as $value){
				$arrlog=array('nomer'=>$value,
								'pesan'=>$pesan,
								'datetime'=>date('Y-m-d H:i:s')
								);
				$this->logwa_model->add($arrlog);
				}
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
	
	function log($offset=0,$order_column='id',$order_type='asc'){
		$data=$this->data;
		$this->load->library(array('pagination','table'));
		if (empty($offset)) $offset=0;
		if (empty($order_column)) $order_column='id';
		if (empty($order_type)) $order_type='asc';
		//TODO: check for valid column
		$alls=$this->logwa_model->get_paged_list($this->limit,
		$offset,$order_column,$order_type)->result();
		$config['base_url']= site_url('memo/log/');
		$config['total_rows']=$this->logwa_model->count_all();
		$config['per_page']=$this->limit;
		$config['first_link'] = false; 
    	$config['last_link']  = false;
		$config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
		$config['full_tag_close'] = '</ul>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li><a href="#"><b>';
		$config['cur_tag_close'] = '</b></a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['last_link'] = '<i class="fa fa-angle-double-right"></i>';
		$config['first_link'] = '<i class="fa fa-angle-double-left"></i>';
    	$config ['prev_link'] = '<i class="fa fa-caret-left"></i>';
    	$config ['next_link'] = '<i class="fa fa-caret-right"></i>';
		//$config['uri_segment']=3;
		$this->pagination->initialize($config);
		$data['pagination']=$this->pagination->create_links();
		// generate table data
		
		$this->table->set_empty("&nbsp;");
		$tmpl = array ('table_open'=>'<table id="tabellaporan" class="table table-hover">');
		$this->table->set_template($tmpl); 
		$new_order=($order_type=='asc'?'desc':'asc');
		$this->table->set_heading(
		'No',
		'Nama',
		'Jabatan',
		'Pesan',
		anchor('memo/log/'.$offset.'/datetime/'.$new_order,'Terkirim')
	);
	$i=0+$offset;
	$max_char=45;
	foreach ($alls as $all){
		$this->table->add_row(
			$i,
			$all->nama,
			$all->jabatan,
			$all->pesan,
			date('d-M-y H:i',strtotime($all->datetime))
		);
		$i++;
	}
	$data['table']=$this->table->generate();
	
		$this->load->view('memo/view.php',$data);
		
	}
	
	
}

