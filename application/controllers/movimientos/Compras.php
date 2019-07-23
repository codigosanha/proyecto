<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compras extends CI_Controller {
	//private $permisos;
	public function __construct(){
		parent::__construct();
		//$this->permisos = $this->backend_lib->control();
		$this->load->model("Productos_model");
		$this->load->model("Compras_model");
		$this->load->model("Proveedores_model");
		$this->load->model("Inventario_model");
		$this->load->model("Usuarios_model");
	}

	public function index(){
		$data  = array(
			//'permisos' => $this->permisos,
			'compras' => $this->Compras_model->getCompras(), 
		);

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/compras/list",$data);
		$this->load->view("layouts/footer");
	}

	public function add(){

		$data = array(
			"proveedores" => $this->Proveedores_model->getProveedores(),
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/compras/add",$data);
		$this->load->view("layouts/footer");
	}


	//metodo para mostrar productos en la accion de asociar
	public function getProductos(){
		$usuario = $this->Usuarios_model->getSucursal($this->session->userdata("id"));
		$valor = $this->input->post("valor");
		$productos = $this->Inventario_model->searchProductos($valor,$usuario->sucursal_id);
		echo json_encode($productos);
	}

	public function getProductoByCode(){
		$codigo_barra = $this->input->post("codigo_barra");
		$producto = $this->Compras_model->getProductoByCode($codigo_barra);

		if ($producto != false) {
			echo json_encode($producto);
		}else{
			echo "0";
		}
	}

	public function store(){
		
		$fecha = $this->input->post("fecha");
		$proveedor = $this->input->post("proveedor");
		$total = $this->input->post("total");

		$idproductos = $this->input->post("idproductos");
		$cantidades = $this->input->post("cantidades");
		$importes = $this->input->post("importes");
		$precios = $this->input->post("precios");

		$data = array(
			'fecha' => $fecha,
			'total' => $total,
			'proveedor_id' => $proveedor,
			'usuario_id' => $this->session->userdata('id'),

		);
		$compra = $this->Compras_model->save($data);
		if ($compra) {
			$usuario = $this->Usuarios_model->getSucursal($this->session->userdata("id"));
			$this->saveDetalle($compra, $idproductos, $precios, $cantidades, $importes);
			$this->updateStock($usuario->sucursal_id, $idproductos, $cantidades);

			$this->session->set_flashdata("success", "Los datos fueron guardados exitosamente");
			//echo "1";
			redirect(base_url()."movimientos/compras");
		}
		else{
			$this->session->set_flashdata("error", "Los datos no fueron guardados");
				//echo "1";
			redirect(base_url()."movimientos/compras/add");
		}
	}
	protected function saveDetalle($compra_id, $productos, $precios, $cantidades, $importes){
		for ($i=0; $i < count($productos) ; $i++) { 
			$dataDetalle = array(
				"producto_id" => $productos[$i],
				"compra_id" => $compra_id,
				"cantidad" => $cantidades[$i],
				"precio" =>  $precios[$i],
				"importe" => $importes[$i],
			);
			$this->Compras_model->saveDetalle($dataDetalle);
		}
	}

	protected function updateStock($sucursal_id, $productos, $cantidades){
		for ($i=0; $i < count($productos) ; $i++) { 
			$ps = $this->Inventario_model->getProductoSucursal($productos[$i],$sucursal_id);
			$data = array(
				"stock" => $ps->stock + $cantidades[$i] 
			);
			$this->Inventario_model->update($ps->id,$data);
		}
	}


	public function view(){
		$idCompra = $this->input->post("id");
		$data = array(
			"compra" => $this->Compras_model->getCompra($idCompra),
			"detalles" =>$this->Compras_model->getDetalle($idCompra)
		);
		$this->load->view("admin/compras/view",$data);
	}
      
    public function getProveedores(){
    	$valor = $this->input->post("valor");
		$proveedores = $this->Compras_model->getProveedores($valor);
		echo json_encode($proveedores);
    }

}