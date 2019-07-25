<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pagos_model extends CI_Model {

	public function getPagos(){
		$this->db->select("p.*,e.nombre,e.apellido,e.sueldo,e.puesto_trabajo");
		$this->db->from("pagos p");
		$this->db->join("empleados e", "p.empleado_id = e.id");
		$this->db->where("e.sucursal_id",$this->session->userdata("sucursal_id"));
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function getPago($id){
		$this->db->select("p.*,e.nombre,e.apellido,e.sueldo,e.puesto_trabajo,s.nombre as sucursal");
		$this->db->from("pagos p");
		$this->db->join("empleados e", "p.empleado_id = e.id");
		$this->db->join("sucursal s", "e.sucursal_id = s.id");
		$this->db->where("p.id",$id);
		$resultado = $this->db->get();
		return $resultado->row();
	}

	public function save($data){
		return $this->db->insert("pagos",$data);
	}

}
