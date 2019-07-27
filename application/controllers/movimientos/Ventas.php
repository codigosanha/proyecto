<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ventas extends CI_Controller {
	//private $permisos;
	private $modulo = "Ventas";
	public function __construct(){
		parent::__construct();
		//$this->permisos = $this->backend_lib->control();
		if (!$this->session->userdata("login")) {
			redirect(base_url());
		}
		$this->load->model("Ventas_model");
		$this->load->model("Clientes_model");
		$this->load->model("Productos_model");
		$this->load->model("Compras_model");
		$this->load->model("Pedidos_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Inventario_model");
	}

	public function index(){
		
		$data  = array(
			//'permisos' => $this->permisos,
			'ventas' => $this->Ventas_model->getVentas($this->session->userdata("sucursal_id")), 
		);


		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/ventas/list",$data);
		$this->load->view("layouts/footer");
	}

	public function add(){
		$usuario = $this->Usuarios_model->getSucursal($this->session->userdata("id"));
		
		$data = array(
			"clientes" => $this->Clientes_model->getClientes(),
			"usuario" => $usuario,
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/ventas/add",$data);
		$this->load->view("layouts/footer");
	}

	//metodo para mostrar productos en la accion de asociar
	public function getProductos(){
		
		$valor = $this->input->post("valor");
		$productos = $this->Inventario_model->searchProductos($valor,$this->session->userdata("sucursal_id"),true);
		echo json_encode($productos);
	}

	public function getProductoByCode(){
		$codigo_barra = $this->input->post("codigo_barra");
		$producto = $this->Inventario_model->getProductoByCode($codigo_barra);

		if ($producto != false) {
			echo json_encode($producto);
		}else{
			echo "0";
		}
	}

	public function store(){
		
		$fecha = date("Y-m-d H:i:s");
		$cliente = $this->input->post("cliente");
		$total = $this->input->post("total");

		$idproductos = $this->input->post("idproductos");
		$cantidades = $this->input->post("cantidades");
		$importes = $this->input->post("importes");
		$precios = $this->input->post("precios");

		$data = array(
			'fecha' => $fecha,
			'total' => $total,
			'cliente_id' => $cliente,
			'usuario_id' => $this->session->userdata('id'),
			'estado' => "1",
			'sucursal_id' => $this->session->userdata('sucursal_id')

		);
		$venta = $this->Ventas_model->save($data);
		if ($venta) {
			$this->saveDetalle($venta, $idproductos, $precios, $cantidades, $importes);
			$this->updateStock($this->session->userdata("sucursal_id"), $idproductos, $cantidades);

			$this->session->set_flashdata("success", $venta);
			//echo "1";
			redirect(base_url()."movimientos/ventas");
		}
		else{
			$this->session->set_flashdata("error", "Los datos no fueron guardados");
				//echo "1";
			redirect(base_url()."movimientos/ventas/add");
		}
	}
	protected function saveDetalle($venta_id, $productos, $precios, $cantidades, $importes){
		for ($i=0; $i < count($productos) ; $i++) { 
			$dataDetalle = array(
				"producto_id" => $productos[$i],
				"venta_id" => $venta_id,
				"cantidad" => $cantidades[$i],
				"precio" =>  $precios[$i],
				"importe" => $importes[$i],
			);
			$this->Ventas_model->saveDetalle($dataDetalle);
		}
	}

	protected function updateStock($sucursal_id, $productos, $cantidades){
		for ($i=0; $i < count($productos) ; $i++) { 
			$ps = $this->Inventario_model->getProductoSucursal($productos[$i],$sucursal_id);
			$data = array(
				"stock" => $ps->stock - $cantidades[$i] 
			);
			$this->Inventario_model->update($ps->idinv,$data);
		}
	}


	public function view(){
		$idventa = $this->input->post("id");
		$data = array(
			"venta" => $this->Ventas_model->getVenta($idventa),
			"detalles" =>$this->Ventas_model->getDetalle($idventa)
		);
		$this->load->view("admin/ventas/view",$data);
	}



	public function saveCliente(){
		$nombres = $this->input->post("nombres");

		$direccion = $this->input->post("direccion");
		$telefono = $this->input->post("telefono");

		$data  = array(
			'nombres' => $nombres, 
			'direccion' => $direccion,
			'telefono' => $telefono,
			'estado' => "1"
		);
		$cliente = $this->Ventas_model->savecliente($data);
		if (!$cliente) {
			echo "0";
		}
		else{
			$data  = array(
				'cliente_registrado' => $cliente, 
				'clientes' => $this->Clientes_model->getClientes(),
			);
			echo json_encode($data);
		}
		
	}


}