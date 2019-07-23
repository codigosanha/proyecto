<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos_model extends CI_Model {

	public function getProductos(){
		$this->db->select("p.*,c.nombre as categoria, pr.nombre as presentacion, m.nombre as marca");
		$this->db->from("productos p");
		$this->db->join("categorias c","p.categoria_id = c.id");
		$this->db->join("marcas m","p.marca_id = m.id");
		$this->db->join("presentaciones pr","p.presentacion_id = pr.id");

		$resultados = $this->db->get();
		return $resultados->result();
	}
	
	public function getProducto($id){
		$this->db->select("p.*,c.nombre as categoria,m.nombre as marca,pre.nombre as presentacion");
		$this->db->from("productos p");
		$this->db->join("categorias c","p.categoria_id = c.id");
		$this->db->join("marcas m","p.marca_id = m.id");
		$this->db->join("presentaciones pre","p.presentacion_id = pre.id");
		$this->db->where("p.id",$id);
		$resultado = $this->db->get();
		return $resultado->row();
	}

	public function save($data){
		if ($this->db->insert("productos",$data)) {
			return $this->db->insert_id();
		}else{
			return false;
		}
	}

	public function update($id,$data){
		$this->db->where("id",$id);
		return $this->db->update("productos",$data);
	}
}