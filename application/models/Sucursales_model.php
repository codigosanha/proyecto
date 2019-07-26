<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sucursales_model extends CI_Model {

	public function getSucursales(){
		$this->db->select("s.*, d.nombre as departamento");
		$this->db->from("sucursal s");
		$this->db->join("departamentos d", "s.departamento_id = d.id");
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function getSucursal($id){
		$this->db->select("s.*, d.nombre as departamento");
		$this->db->from("sucursal s");
		$this->db->join("departamentos d", "s.departamento_id = d.id");
		$this->db->where("s.id",$id);
		$resultado = $this->db->get();
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
