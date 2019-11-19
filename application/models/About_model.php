<?php
class About_model extends CI_Model {
 	private $table_name= 'about';
	private $primary_key= 'id';
 	function __construct(){
  		parent::__construct();
 	}
 	function get_all(){
  		$this->db->order_by('nama','asc');
  		return $this->db->get($table_name);
 	}
 
 	function count_all(){
  		return $this->db->count_all($this->table_name);
 	}
 
 	function get_by_id($id){
  		$this->db->where($this->primary_key, $id);
  		return $this->db->get($this->table_name);
 	}
	
	function get_by_nama($nama){
  		$this->db->where(array('nama'=>$nama));
  		return $this->db->get($this->table_name);
 	}
 
 	function save($data){
  		$this->db->insert($this->table_name, $data);
  		return $this->db->insert_id();
 	}
 
 	function update($nama, $data){
  		$this->db->where('nama', $nama);
  		$this->db->update($this->table_name, $data);
 	}
 
 	function delete($id){
  		$this->db->where($this->primary_key, $id);
  		$this->db->delete($this->table_name);
 	}
}