<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ventas_model extends CI_Model {

	public function getVentas($sucursal){
		//$this->db->where("fecha", date("Y-m-d"));
		//$this->db->where("estado","1");
		$this->db->select("v.*,c.nombres, u.username");
		$this->db->from("ventas v");
		$this->db->join("clientes c","v.cliente_id = c.id");
		$this->db->join("usuarios u","v.usuario_id = u.id");
		$this->db->join("empleados e","u.empleado_id = e.id");
		$this->db->where("v.sucursal_id",$sucursal);
		$resultados = $this->db->get();
		if ($resultados->num_rows() > 0) {
			return $resultados->result();
		}else
		{
			return false;
		}
	}
	public function getVentasbyDate($fechainicio,$fechafin){
		$this->db->select("v.*,c.nombres, u.username");
		$this->db->from("ventas v");
		$this->db->join("clientes c","v.cliente_id = c.id");
		$this->db->join("usuarios u","v.usuario_id = u.id");
		$this->db->where("v.sucursal_id",$this->session->userdata("sucursal_id"));
		$this->db->where("DATE(v.fecha) >=",$fechainicio);
		$this->db->where("DATE(v.fecha) <=",$fechafin);
		$resultados = $this->db->get();
		if ($resultados->num_rows() > 0) {
			return $resultados->result();
		}else
		{
			return false;
		}
	}

	public function getVenta($id){
		$this->db->select("v.*,c.nombres,c.telefono,c.direccion");
		$this->db->from("ventas v");
		$this->db->join("clientes c","v.cliente_id = c.id");
		$this->db->where("v.id",$id);
		$resultado = $this->db->get();
		return $resultado->row();
	}

	public function getDetalle($id){
		$this->db->select("dt.*,p.cod_barras,p.nombre");
		$this->db->from("detalle_venta dt");
		$this->db->join("productos p","dt.producto_id = p.id");
		$this->db->where("dt.venta_id",$id);
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
		if ($this->db->insert("ventas",$data)) {
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
        return $this->db->insert("detalle_venta", $data);
			
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
		$this->db->select("DATE(fecha) as fecha, SUM(total) as monto");
		$this->db->from("ventas");
		$this->db->where("sucursal_id",$this->session->userdata("sucursal_id"));
		$this->db->group_by("DATE(fecha)");
		$this->db->order_by("DATE(fecha)");
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function montosMeses($year){
		$this->db->select("MONTH(fecha) as mes, SUM(total) as monto");
		$this->db->from("ventas");
		$this->db->where("DATE(fecha) >=",$year."-01-01");
		$this->db->where("DATE(fecha) <=",$year."-12-31");
		$this->db->where("sucursal_id",$this->session->userdata("sucursal_id"));
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
		return $this->db->update("ventas",$data);
	}

	public function comprobarPassword($password){
		$this->db->where("clave_permiso", $password);
		$resultados  = $this->db->get("configuraciones");
		if ($resultados->num_rows() > 0) {
			return $resultados->row();
		}
		else{
			return false;
		}
	}

	public function saveNotificacion($data){
		$this->db->insert("notificaciones",$data);
	}

	public function updateNotificacion($id,$data){
		$this->db->where("id",$id);
		return $this->db->update("notificaciones",$data);
	}

	public function getProducts(){
		$this->db->select("p.*,c.nombre as categoria");
		$this->db->from("productos p");
		$this->db->join("categorias c","p.categoria_id = c.id");
		$this->db->where("p.estado","1");
		$resultados = $this->db->get();

		$productos = array();
		foreach ($resultados->result_array() as $resultado) {
			$productos[$resultado['id']] = $resultado;
		}

		return $productos;
	}

	public function productosVendidos($fechainicio, $fechafin){
		$this->db->select("p.id, p.nombre, p.stock, p.precio,SUM(dv.cantidad) as totalVendidos");
		$this->db->from("detalle_venta dv");
		$this->db->join("productos p", "dv.producto_id = p.id");
		$this->db->join("ventas v", "dv.venta_id = v.id");
		$this->db->where("v.fecha >=", $fechainicio);
		$this->db->where("v.fecha <=", $fechafin);
		$this->db->group_by("dv.producto_id");
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function getLastProductos(){
		$this->db->select("p.*, c.nombre as categoria");
		$this->db->from("productos p");
		$this->db->join("categorias c","p.categoria_id = c.id");
		$this->db->order_by('id',"desc");
		$this->db->limit(5);
		$resultados = $this->db->get();
		return $resultados->result();
	}
	
	public function getProductosStockMinimo(){
		$this->db->select("p.*,c.nombre as categoria");
		$this->db->from("productos p");
		$this->db->join("categorias c","p.categoria_id = c.id");
		$this->db->where("p.estado","1");
		$this->db->where("stock <", 10);
		$resultados = $this->db->get();
		return $resultados->result();
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