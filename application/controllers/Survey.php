<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survey extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct(){
		parent::__construct();		
		$this->load->model(array('pertanyaan_model','jawaban_model','data_model','about_model'));
		date_default_timezone_set('Asia/Jakarta');
 
	}
	public function index()
	{
		$hasil = array();
		$hasil2 = array();
		$saran = array();
		$jwb = array();
		$pertanyaan = $this->pertanyaan_model->get_by_all()->result();
		foreach($pertanyaan as $pert){
			$hasil['text']=$pert->pertanyaan;
        	$hasil['id']=$pert->id;
        	$hasil['break_after']=true;
			$hasil['required']=true;
			if($pert->pertanyaan=='Saran'){
				$hasil['required']=false;
				}
        	$hasil['type']=$pert->type;
		$jawaban = $this->jawaban_model->get_by_pertanyaan($pert->id)->result();
		foreach($jawaban as $k){
				array_push($jwb,$k->jawaban);
			}
		$hasil['options']=$jwb;
		$jwb=array();
		array_push($hasil2,$hasil);
			}
		$data['pertanyaan']=json_encode($hasil2);
		$this->load->view('survey',$data);
	}
	public function pertanyaan()
	{
		$hasil = array();
		$hasil2 = array();
		$saran = array();
		$jwb = array();
		$pertanyaan = $this->pertanyaan_model->get_by_all()->result();
		foreach($pertanyaan as $pert){
			$hasil['text']=$pert->pertanyaan;
        	$hasil['id']=$pert->id;
        	$hasil['break_after']=true;
			$hasil['required']=true;
			if($pert->pertanyaan=='Saran'){
				$hasil['required']=false;
				}
        	$hasil['type']=$pert->type;
		$jawaban = $this->jawaban_model->get_by_pertanyaan($pert->id)->result();
		foreach($jawaban as $k){
				array_push($jwb,$k->jawaban);
				//$jwb = $jwb+array($k->jawaban);
				//print_r($jwb);
			}
		$hasil['options']=$jwb;
		$jwb=array();
		array_push($hasil2,$hasil);
			}
		header('Content-Type: application/json');
		echo json_encode($hasil2);
	}
	public function kategori()
	{
		$smile = $this->data_model->get_by_home_smile(date('Y-m-d'))->row();
		$frown = $this->data_model->get_by_home_frown(date('Y-m-d'))->row();
		if(empty($smile)){
			$smile=0;
		} else {
			$smile=$smile->rata;
		}
		if(empty($frown)){
			$frown=0;
		} else {
			$frown=$frown->rata;
		}
		$arr = array('smile'=>$smile,'frown'=>$frown);
		$hasil['kategori']=$arr;
		header('Content-Type: application/json');
		echo json_encode($arr);
	}
	public function add()
	{
		$answers = json_decode($this->input->post('answers'));
		$id = $this->data_model->add(array('datetime'=>now()));
		foreach($answers as $key => $value){
			$bobot=$this->jawaban_model->get_bobot($key,$value)->row();
			//echo $this->db->last_query();
			if(empty($bobot)){
				$bobot=0;
				}else{
				$bobot=$bobot->bobot;
				}
			$data = array(
							'id_data'=>$id,
							'id_pertanyaan'=>$key,
							'jawaban'=>$value,
							'bobot'=>$bobot
						);
			$this->data_model->insert($data);
		}
		
		if(!empty($id)){
			echo 1;
		} else {
			echo 0;	
		}
		
	}
}
