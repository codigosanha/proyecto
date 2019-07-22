<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Departamentos_model extends CI_Model {

	public function getDepartamentos(){
		//$this->db->where("estado","1");
		$resultados = $this->db->get("departamentos");
		return $resultados->result();
	}

	public function getDepartamento($id){
		$this->db->where("id",$id);
		$resultado = $this->db->get("departamentos");
		return $resultado->row();
	}

	public function save($data){
		return $this->db->insert("departamentos",$data);
	}
	
	public function update($id,$data){
		$this->db->where("id",$id);
		return $this->db->update("departamentos",$data);
	}
}
