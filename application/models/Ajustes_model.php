<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ajustes_model extends CI_Model {

	public function getAjustes(){
		$this->db->select("a.*,u.username");
		$this->db->from("ajustes a");
		$this->db->join("usuarios u","a.usuario_id = u.id");
		$this->db->where("a.sucursal_id",$this->session->userdata("sucursal_id"));
		$resultado = $this->db->get();
		return $resultado->result();
	}

	public function getProductos(){
		$this->db->select("p.nombre,i.stock,i.id,i.producto_id");
		$this->db->from("inventario i");
		$this->db->join("productos p","i.producto_id = p.id");
		$this->db->where("i.sucursal_id",$this->session->userdata("sucursal_id"));
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function ajusteActual(){
		$this->db->where("sucursal_id",$this->session->userdata("sucursal_id"));
		$this->db->where("DATE(fecha)",date("Y-m-d"));
		$resultado = $this->db->get("ajustes");
		if ($resultado->num_rows() > 0) {
			return true;
		}else{
			return false;
		}
	}

	public function getAjuste($id){
		$this->db->select("a.*,u.username");
		$this->db->from("ajustes a");
		$this->db->join("usuarios u","a.usuario_id = u.id");
		$this->db->where("a.id", $id);
		$resultado = $this->db->get();
		return $resultado->row();
	}



	public function save($data){

		if ($this->db->insert("ajustes",$data)) {

			return $this->db->insert_id();

		}

		return false;

	}

	public function getAjusteProductos($idajuste){
		$this->db->select("ap.*, p.nombre");
		$this->db->from("ajustes_productos ap");
		$this->db->join("productos p","ap.producto_id = p.id");
		$this->db->where("ap.ajuste_id",$idajuste);
		return $this->db->get()->result();
	}



	public function saveAjusteProductos($data){
		return $this->db->insert("ajustes_productos",$data);
	}



	public function updateAjuste($idajuste,$idproducto,$data){

		$this->db->where("ajuste_id",$idajuste);

		$this->db->where("producto_id",$idproducto);

		return $this->db->update("ajustes_productos",$data);

	}



	

}