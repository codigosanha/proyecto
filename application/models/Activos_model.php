<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activos_model extends CI_Model {

	public function getActivos(){
		$this->db->select("a.*,e.nombre as empleado");
		$this->db->from("activos a");
		$this->db->join("empleados e","a.empleado_id = e.id");
		$this->db->where("e.sucursal",$this->session->userdata("sucursal_id"));
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function getActivo($id){
		$this->db->where("id",$id);
		$resultado = $this->db->get("activos");
		return $resultado->row();
	}

	public function save($data){
		return $this->db->insert("activos",$data);
	}
	
	public function update($id,$data){
		$this->db->where("id",$id);
		return $this->db->update("activos",$data);
	}
}
