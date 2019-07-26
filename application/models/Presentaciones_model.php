<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Presentaciones_model extends CI_Model {

	public function getPresentaciones(){
		$this->db->where("estado","1");
		$resultados = $this->db->get("presentaciones");
		return $resultados->result();
	}

	public function getPresentacion($id){
		$this->db->where("id",$id);
		$resultado = $this->db->get("presentaciones");
		return $resultado->row();
	}

	public function save($data){
		return $this->db->insert("presentaciones",$data);
	}
	
	public function update($id,$data){
		$this->db->where("id",$id);
		return $this->db->update("presentaciones",$data);
	}
}
