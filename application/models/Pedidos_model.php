<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedidos_model extends CI_Model {

	public function getPedidos(){
		//$this->db->where("fecha", date("Y-m-d"));
		//$this->db->where("estado","1");
		$this->db->select("p.*,c.nombres,s.nombre as sucursal");
		$this->db->from("pedidos p");
		$this->db->join("clientes c","p.cliente_id = c.id");
		$this->db->join("sucursal s","p.sucursal_id = s.id");
		if ($this->session->userdata("rol") == 2) {
			$this->db->where("s.id",$this->session->userdata("sucursal_id"));
		}
		$resultados = $this->db->get();
		if ($resultados->num_rows() > 0) {
			return $resultados->result();
		}else
		{
			return false;
		}
	}
	public function getPedidosPendientes($sucursal){
		$this->db->select("p.*,c.nombres as cliente");
		$this->db->from("pedidos p");
		$this->db->join("clientes c","p.cliente_id = c.id");
		$this->db->where("p.sucursal_id",$sucursal);
		$this->db->where("p.estado","0");
		$resultados = $this->db->get();
		if ($resultados->num_rows() > 0) {
			return $resultados->result();
		}else
		{
			return false;
		}
	}

	public function getPedido($id){
		$this->db->select("p.*,c.nombres,c.telefono,c.direccion");
		$this->db->from("pedidos p");
		$this->db->join("clientes c","p.cliente_id = c.id");
		$this->db->where("p.id",$id);
		$resultado = $this->db->get();
		return $resultado->row();
	}

	public function getDetalle($id){
		$this->db->select("dt.*,p.cod_barras,p.nombre,p.precio_venta");
		$this->db->from("detalle_pedido dt");
		$this->db->join("productos p","dt.producto_id = p.id");
		$this->db->where("dt.pedido_id",$id);
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function getComprobantes(){
		$resultados = $this->db->get("tipo_comprobante");
		return $resultados->result();
	}
	public function getTipoPagos(){
		$resultados = $this->db->get("tipo_pago");
		return $resultados->result();
	}

	public function getComprobante($idcomprobante){
		$this->db->where("id",$idcomprobante);
		$resultado = $this->db->get("tipo_comprobante");
		return $resultado->row();
	}

	public function getProductos($valor){
		$this->db->select("p.id,CONCAT(p.codigo_barras,' - ',p.nombre) as label,p.nombre,p.codigo_barras,p.precio_compra,m.nombre as marca,p.stock");
		$this->db->from("productos p");
		$this->db->join("marca m", "p.marca_id = m.id");
		$this->db->like("CONCAT(p.codigo_barras,'',p.nombre)",$valor);
		$this->db->where("p.stock > ",0);
		$resultados = $this->db->get();
		return $resultados->result_array();
	}

	public function getProductoByCode($codigo_barra){
		$this->db->select("p.id,p.nombre,p.codigo_barras,p.precio,m.nombre as marca,p.stock");
		$this->db->from("productos p");
		$this->db->join("marca m", "p.marca_id = m.id");
		$this->db->where("p.codigo_barras", $codigo_barra);
		$this->db->where("p.stock > ",0);
		$resultados = $this->db->get();
		if ($resultados->num_rows() > 0) {
			return $resultados->row();
		}else{
			return false;
		}
		
	}

	public function getproductosA($valor){
		$this->db->select("id,codigo_barras,nombre as label,precio,stock");
		$this->db->from("productos");
		$this->db->like("nombre",$valor);
		$resultados = $this->db->get();
		return $resultados->result_array();
	}

	public function save($data){
		if ($this->db->insert("pedidos",$data)) {
			return $this->db->insert_id();
		}
		return false;
	}

	public function lastID(){
		return $this->db->insert_id();
	}

	public function updateComprobante($idcomprobante,$data){
		$this->db->where("id",$idcomprobante);
		$this->db->update("tipo_comprobante",$data);
	}

	public function saveDetalle($data){
        return $this->db->insert("detalle_pedido", $data);
			
	}

	public function years(){
		$this->db->select("YEAR(fecha) as year");
		$this->db->from("ventas");
		$this->db->group_by("year");
		$this->db->order_by("year","desc");
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function montos(){
		$this->db->select("fecha, SUM(total) as monto");
		$this->db->from("ventas");
		$this->db->where("estado","1");
		$this->db->group_by("fecha");
		$this->db->order_by("fecha");
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function montosMeses($year){
		$this->db->select("MONTH(fecha) as mes, SUM(total) as monto");
		$this->db->from("ventas");
		$this->db->where("fecha >=",$year."-01-01");
		$this->db->where("fecha <=",$year."-12-31");
		$this->db->group_by("mes");
		$this->db->order_by("mes");
		$resultados = $this->db->get();
		return $resultados->result();
	}


	public function savecliente($data){
		if ($this->db->insert("clientes",$data)) {
			return $this->db->insert_id();
		}
		else{
			return false;
		}
	}

	public function stockminimo(){
		$this->db->where("estado","1");
		$query = $this->db->get("productos");
		$return = array();

	    foreach ($query->result() as $producto)
	    {
	    	if ($producto->stock <= $producto->stock_minimo) {
	    		$return[$producto->id] = $producto;
	    	}
	        
	    }

	    return $return;

	}

	public function deleteDetail($id){
		$this->db->where("venta_id",$id);
		return $this->db->delete("detalle_venta");
	}

	public function update($id,$data){
		$this->db->where("id",$id);
		return $this->db->update("pedidos",$data);
	}


	public function getProductosmasVendidos(){
		$this->db->select("p.id, p.codigo_barras, p.nombre, p.stock, p.precio,SUM(dv.cantidad) as totalVendidos, c.nombre as categoria");
		$this->db->from("detalle_venta dv");
		$this->db->join("productos p", "dv.producto_id = p.id");
		$this->db->join("ventas v", "dv.venta_id = v.id");
		$this->db->join("categorias c","p.categoria_id = c.id");
		$this->db->order_by("totalVendidos", "desc"); 
		$this->db->limit(10);
		$this->db->group_by("dv.producto_id");
		$resultados = $this->db->get();
		return $resultados->result();
	}
}