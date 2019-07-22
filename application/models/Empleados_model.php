<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empleados_model extends CI_Model {

	public function getEmpleados(){
		$this->db->select("e.*,sc.nombre as sucursal");
		$this->db->from("empleados e");
		$this->db->join("sucursal sc", "e.sucursal_id = sc.id");
		$resultados = $this->db->get();
		return $resultados->result();
	}
	
	// public function getSoloClientes(){
	// 	$this->db->select("c.*");
	// 	$this->db->from("clientes c");
	// 	$this->db->where("c.estado","1");
	// 	$resultados = $this->db->get();
	// 	return $resultados->result();
	// }

	public function getEmpleado($id){
		$this->db->select("e.*,sc.nombre as sucursal");
		$this->db->from("empleados e");
		$this->db->join("sucursal sc", "e.sucursal_id = sc.id");
		$this->db->where("e.id",$id);
		$resultado = $this->db->get();
		return $resultado->row();

	}
	public function save($data){
		return $this->db->insert("empleados",$data);
	}
	public function update($id,$data){
		$this->db->where("id",$id);
		return $this->db->update("empleados",$data);
	}

	public function getTipoSurcursal(){
		$resultados = $this->db->get("sucursal");
		return $resultados->result();
	}

}