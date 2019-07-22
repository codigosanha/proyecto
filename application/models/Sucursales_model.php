<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sucursales_model extends CI_Model {

	public function getSucursales(){
		//$this->db->where("estado","1");
		$resultados = $this->db->get("sucursal");
		return $resultados->result();
	}

	public function getSucursal($id){
		$this->db->where("id",$id);
		$resultado = $this->db->get("sucursal");
		return $resultado->row();
	}

	public function save($data){
		return $this->db->insert("sucursal",$data);
	}
	
	public function update($id,$data){
		$this->db->where("id",$id);
		return $this->db->update("sucursal",$data);
	}
}
