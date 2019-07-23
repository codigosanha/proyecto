<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventario_model extends CI_Model {
	public function save($data){
		return $this->db->insert("inventario",$data);
	}
	public function saveDetalleInventario($data){
		return $this->db->insert("inventario_producto", $data);
	}

	public function getInventario($sucursal){
		$this->db->select("p.nombre, i.*");
		$this->db->from("inventario i");
		$this->db->join("productos p", "i.producto_id = p.id");
		$this->db->where("i.sucursal_id",$sucursal);
		$resultados = $this->db->get();
		return $resultados->result();
	}	
	
	public function getProductoSucursal($producto,$sucursal){
		$this->db->select("p.nombre,p.cod_barras,c.nombre as categoria,p.id");
		$this->db->from("inventario i");
		$this->db->join("productos p", "i.producto_id = p.id");
		$this->db->join("categorias c", "p.categoria_id = c.id");
		$this->db->where("i.sucursal_id",$sucursal);
		$this->db->where("i.producto_id",$producto);
		$resultados = $this->db->get();
		if ($resultados->num_rows() > 0) {
			return $resultados->row();
		}
		return 0;
	}	

	public function getProductos($idinventario,$month,$year){
		$this->db->select("p.nombre, m.nombre as marca,ip.*");
		$this->db->from("inventario_producto ip");
		$this->db->join("productos p", "ip.producto_id = p.id");
		$this->db->join("marca m", "p.marca_id = m.id");
		$this->db->where("ip.inventario_id", $idinventario);
		$query = $this->db->get();
	    $return = array();

	    foreach ($query->result() as $producto)
	    {
	        $return[$producto->id] = $producto;
	        $return[$producto->id]->venta = $this->sumaVentas($producto->producto_id,$month,$year);
	        $return[$producto->id]->compra = $this->sumaCompras($producto->producto_id,$month,$year); // Get the categories sub categories
	    }

	    return $return;
	}
	public function sumaVentas($producto_id,$month,$year)
	{
	    $this->db->select("SUM(dv.cantidad) as total");
	    $this->db->from("detalle_venta dv");
	    $this->db->join("ventas v", "dv.venta_id = v.id");
	    $this->db->where("v.fecha >=",$year."-".str_pad($month, 2,'0',STR_PAD_LEFT)."-01");
	    $this->db->where("v.fecha <=",$year."-".str_pad($month, 2,'0',STR_PAD_LEFT)."-31");
	    $this->db->where("v.estado !=","0");
	    $this->db->where("dv.producto_id", $producto_id);
	    $this->db->group_by("dv.producto_id");
	    $resultado = $this->db->get();
	    if ($resultado->num_rows() > 0) {
	    	return $resultado->row()->total;
	    }
	    return 0;
	}

	public function sumaCompras($producto_id,$month,$year)
	{
	    $this->db->select("SUM(dc.cantidad) as total");
	    $this->db->from("detalle_compra dc");
	    $this->db->join("compras c", "dc.compra_id = c.id");
	    $this->db->where("c.fecha >=",$year."-".str_pad($month, 2,'0',STR_PAD_LEFT)."-01");
	    $this->db->where("c.fecha <=",$year."-".str_pad($month, 2,'0',STR_PAD_LEFT)."-31");
	    $this->db->where("dc.producto_id", $producto_id);
	    $this->db->group_by("dc.producto_id");
	    $resultado = $this->db->get();
	    if ($resultado->num_rows() > 0) {
	    	return $resultado->row()->total;
	    }

	    return 0;

	}

	public function years(){
		$this->db->select("year");
		$this->db->group_by("year");
		$this->db->order_by("year","desc");
		$resultados = $this->db->get("inventarios");
		return $resultados->result();
	}

	public function searchProductos($valor,$sucursal,$ventas = false){
		$this->db->select("p.id,CONCAT(p.cod_barras,' - ',p.nombre) as label,p.nombre,p.cod_barras,p.precio_compra,p.precio_venta,i.stock");
		$this->db->from("inventario i");
		$this->db->join("productos p", "i.producto_id = p.id");
		$this->db->where("i.sucursal_id",$sucursal);
		$this->db->like("CONCAT(p.cod_barras,'',p.nombre)",$valor);
		if ($ventas) {
			$this->db->where("i.stock >=","1");
		}
		$resultados = $this->db->get();
		return $resultados->result_array();
	}

	public function update($id,$data){
		$this->db->where("id",$id);
		return $this->db->update("inventario",$data);
	}

}
