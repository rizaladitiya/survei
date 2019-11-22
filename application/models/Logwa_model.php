<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logwa_model extends CI_Model {
	private $primary_key='id';
	private $table_name='logwa';
function __construct()
	{
		parent::__construct();
	}

function count_all() {
	return $this->db->count_all($this->table_name);
}
function get_paged_list($limit=10,$offset=0,$order_column='',$order_type='asc'){
	$select=array(
				
				'logwa.id',
				'logwa.nomer',
				'logwa.pesan',
				'logwa.datetime',
				'pegawai.nama',
				'pegawai.jabatan',
				'pegawai.gelar'
			);
	$this->db->select($select);    
	$this->db->from($this->table_name);
	$this->db->limit($limit,$offset);
	$this->db->join('pegawai', 'pegawai.hp = logwa.nomer', 'inner');
	if (empty($order_column)|| empty($order_type))
	$this->db->order_by($this->primary_key,'desc');
	else
	$this->db->order_by($order_column,$order_type);
	return $this->db->get();
}
function get_by_all(){
	$select=array(
				$this->primary_key,
				'nomer',
				'pesan',
				'datetime'
			);
	$this->db->select($select);    
	$this->db->from($this->table_name);
	$this->db->order_by('nama asc');
	return $this->db->get();
}

function get_by_last(){
	$select=array(
				$this->primary_key,
				'nomer',
				'pesan',
				'datetime'
			);
	$this->db->select($select);    
	$this->db->from($this->table_name);
	$this->db->limit(1, 0);
	$this->db->order_by('id desc');
	return $this->db->get();
}
function get_by_id($id){
	$select=array(
				$this->primary_key,
				'nomer',
				'pesan',
				'datetime'
			);
	$this->db->select($select);    
	$this->db->from($this->table_name);
	$this->db->where($this->primary_key,$id);
	return $this->db->get();
}

function add($data){
	$this->db->insert($this->table_name,$data);
	return $this->db->insert_id();
}
function update($id,$data) {
	$this->db->where($this->primary_key,$id);
	$this->db->update($this->table_name,$data);
}

function delete($id) {
	$this->db->where($this->primary_key,$id);
	$this->db->delete($this->table_name);
}
}
