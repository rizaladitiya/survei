<?php
class User_model extends CI_Model {
 	private $table_name= 'user';
	private $primary_key= 'id';
 	function __construct(){
  		parent::__construct();
 	}
 	function login($user, $password)
 {
   $this -> db -> select('id,user,nama,email,password');
   $this -> db -> from($this->table_name);
   $this -> db -> where('user', $user);
   $this -> db -> where('password', md5($password));
   $this -> db -> limit(1);
 
   $query = $this -> db -> get();
 
   if($query -> num_rows() == 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
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
 
 	function update($id, $data){
  		$this->db->where($this->primary_key, $id);
  		$this->db->update($this->table_name, $data);
 	}
 
 	function delete($id){
  		$this->db->where($this->primary_key, $id);
  		$this->db->delete($this->table_name);
 	}
}