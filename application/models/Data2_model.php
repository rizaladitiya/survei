<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data2_model extends CI_Model {
	private $primary_key='id';
	private $table_parrent='data';
	private $table_child='data_jawaban';
function __construct()
	{
		parent::__construct();
	}


function get_by_kesimpulan_freq($kesimpulan,$date,$date2,$idpertanyaan){
	$sql = "select count(b.bobot) as total
			from data a 
			inner join data_jawaban b on a.id=b.id_data
			where date(a.datetime)>='$date' and 
					date(a.datetime)<='$date2' and 
					b.id_pertanyaan=$idpertanyaan and 
					(b.bobot between (select nilai_min from `range` where value='$kesimpulan') and (select nilai_max from `range` where value='$kesimpulan'))";
	$query=$this->db->query($sql);
	return $query;
}
function get_by_bobot_freq($kesimpulan,$date,$date2,$idpertanyaan){
	$sql = "select count(b.bobot) as total
			from data a 
			inner join data_jawaban b on a.id=b.id_data
			where date(a.datetime)>='$date' and 
					date(a.datetime)<='$date2' and 
					b.id_pertanyaan=$idpertanyaan and 
					b.bobot=$bobot)";
	$query=$this->db->query($sql);
	return $query;
}
function get_by_kesimpulan_count($date,$date2,$idpertanyaan){
	$sql = "select count(b.bobot) as total
			from data a 
			inner join data_jawaban b on a.id=b.id_data
			where date(a.datetime)>='$date' and 
					date(a.datetime)<='$date2' and
					b.id_pertanyaan=$idpertanyaan";
	$query=$this->db->query($sql);
	return $query;
}
function get_by_detail($date,$date2){
	$select=array(
				'data.id',
				'date(data.datetime) as datetime',
				'data_jawaban.id_pertanyaan',
				'data_jawaban.jawaban',
				'data_jawaban.bobot'
			);
	$where=array(
				'date(data.datetime)>='=>$date,
				'date(data.datetime)<='=>$date2
		);
	$this->db->select($select);    
	$this->db->from($this->table_parrent);
	$this->db->where($where);
	$this->db->join($this->table_child, 'data.id = data_jawaban.id_data', 'inner');
	$this->db->order_by('datetime asc');
	return $this->db->get();
}
function get_by_kesimpulan($id,$date,$date2){
	$select=array(
				'data_jawaban.id_pertanyaan',
				'avg(data_jawaban.bobot) as rata'
			);
	$where=array(
				'date(data.datetime)>='=>$date,
				'date(data.datetime)<='=>$date2,
				'data_jawaban.id_pertanyaan'=>$id
		);
	$this->db->select($select);    
	$this->db->from($this->table_parrent);
	$this->db->where($where);
	$this->db->join($this->table_child, 'data.id = data_jawaban.id_data', 'inner');
	$this->db->group_by('data_jawaban.id_pertanyaan');
	$this->db->order_by('data_jawaban.id_pertanyaan asc');
	return $this->db->get();
}
function get_by_detail_id($id,$pertanyaan){
	$select=array(
				'data.id',
				'date(data.datetime) as datetime',
				'data_jawaban.id_pertanyaan',
				'data_jawaban.jawaban',
				'data_jawaban.bobot'
			);
	$where=array(
				'data.id'=>$id,
				'data_jawaban.id_pertanyaan'=>$pertanyaan
		);
	$this->db->select($select);    
	$this->db->from($this->table_parrent);
	$this->db->where($where);
	$this->db->join($this->table_child, 'data.id = data_jawaban.id_data', 'inner');
	$this->db->order_by('datetime asc');
	return $this->db->get();
}
function get_by_average($id){
	$select=array(
				'avg(data_jawaban.bobot) as avg'
			);
	$where=array(
				'data.id'=>$id,
				'data_jawaban.bobot>'=>0
		);
	$this->db->select($select);    
	$this->db->from($this->table_parrent);
	$this->db->where($where);
	$this->db->join($this->table_child, 'data.id = data_jawaban.id_data', 'inner');
	$this->db->order_by('datetime asc');
	return $this->db->get();
}
function get_by_home_smile($date){
	$sql="select count(*) as rata from (select avg(data_jawaban.bobot) as rata from data inner join data_jawaban on data.id=data_jawaban.id_data
			where data_jawaban.bobot>0 and date(data.datetime)='$date' group by data.id) a where a.rata>='2.51'";
	$query=$this->db->query($sql);
	return $query;
}
function get_by_home_frown($date){
	$sql="select count(*) as rata from (select avg(data_jawaban.bobot) as rata from data inner join data_jawaban on data.id=data_jawaban.id_data
			where data_jawaban.bobot>0 and date(data.datetime)='$date' group by data.id) a where a.rata<'2.51'";
	$query=$this->db->query($sql);
	return $query;
}
function get_kesimpulan($nilai){
	$select=array(
				'value',
				'value2'
			);
			$where=array(
				'min<='=>$nilai,
				'max>='=>$nilai
		);
	$this->db->select($select);    
	$this->db->from('range');
	$this->db->where($where);
	return $this->db->get();
}
function get_kesimpulan_rata($nilai){
	$select=array(
				'value',
				'value2'
			);
			$where=array(
				'nilai_min<='=>$nilai,
				'nilai_max>='=>$nilai
		);
	$this->db->select($select);    
	$this->db->from('range');
	$this->db->where($where);
	return $this->db->get();
}
function get_by_tanggal($date,$date2){
	$select=array(
				'data.id',
				'date(data.datetime) as datetime',
			);
	$where=array(
				'date(data.datetime)>='=>$date,
				'date(data.datetime)<='=>$date2
		);
	$this->db->select($select);    
	$this->db->from($this->table_parrent);
	$this->db->where($where);
	$this->db->order_by('datetime asc');
	$this->db->group_by('id');
	return $this->db->get();
}
function get_by_responden($date,$date2,$idpertanyaan){
	$select=array(
				'data_jawaban.jawaban',
				'count(*) as jumlah',
			);
	$where=array(
				'date(data.datetime)>='=>$date,
				'date(data.datetime)<='=>$date2,
				'data_jawaban.id_pertanyaan'=>$idpertanyaan
		);
	$this->db->select($select);    
	$this->db->from($this->table_parrent);
	$this->db->join($this->table_child, 'data.id = data_jawaban.id_data', 'inner');
	$this->db->where($where);
	$this->db->order_by('datetime asc');
	$this->db->group_by('jawaban');
	return $this->db->get();
}
function get_by_responden_detail($date,$date2,$idpertanyaan,$jawaban){
	$select=array(
				'data_jawaban.jawaban',
				'count(*) as jumlah',
			);
	$where=array(
				'date(data.datetime)>='=>$date,
				'date(data.datetime)<='=>$date2,
				'data_jawaban.id_pertanyaan'=>$idpertanyaan,
				'data_jawaban.jawaban'=>$jawaban
		);
	$this->db->select($select);    
	$this->db->from($this->table_parrent);
	$this->db->join($this->table_child, 'data.id = data_jawaban.id_data', 'inner');
	$this->db->where($where);
	$this->db->order_by('datetime asc');
	$this->db->group_by('jawaban');
	return $this->db->get();
}
function get_by_last(){
	$select=array(
				$this->primary_key,
				'datetime'
			);
	$this->db->select($select);    
	$this->db->from($this->table_parrent);
	$this->db->limit(1, 0);
	$this->db->order_by('id desc');
	return $this->db->get();
}
function get_by_id($id){
	$select=array(
				$this->primary_key,
				'datetime'
			);
	$this->db->select($select);    
	$this->db->from($this->table_parrent);
	$this->db->where($this->primary_key,$id);
	return $this->db->get();
}

function add($data){
	$this->db->insert($this->table_parrent,$data);
	return $this->db->insert_id();
}
function insert($data){
	$this->db->insert($this->table_child,$data);
	return $this->db->insert_id();
}
function update($id,$data) {
	$this->db->where($this->primary_key,$id);
	$this->db->update($this->table_parrent,$data);
}

function delete($id) {
	$this->db->where($this->primary_key,$id);
	$this->db->delete($this->table_parrent);
}
}
