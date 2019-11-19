<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pertanyaan_model extends CI_Model {
	private $primary_key='id';
	private $table_name='pertanyaan';
function __construct()
	{
		parent::__construct();
	}

function count_all() {
	return $this->db->count_all($this->table_name);
}
function get_by_all(){
	$select=array(
				$this->primary_key,
				'ruang_lingkup',
				$this->table_name,
				'type'
			);
	$this->db->select($select);    
	$this->db->from($this->table_name);
	$this->db->order_by('urutan asc');
	return $this->db->get();
}
function get_by_bobot(){
	$select=array(
				$this->primary_key,
				'ruang_lingkup',
				$this->table_name,
				'type'
			);
	$where='id!=1 and id<11';
	$this->db->select($select);    
	$this->db->from($this->table_name);
	$this->db->where($where);  
	$this->db->order_by('id asc');
	return $this->db->get();
}
function get_by_last(){
	$select=array(
				$this->primary_key,
				'ruang_lingkup',
				$this->table_name,
				'type'
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
				'ruang_lingkup',
				$this->table_name,
				'type'
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
