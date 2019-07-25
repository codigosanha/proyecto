<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedidos extends CI_Controller {
	//private $permisos;
	private $modulo = "Ventas";
	public function __construct(){
		parent::__construct();
		//$this->permisos = $this->backend_lib->control();
		$this->load->model("Pedidos_model");
		$this->load->model("Ventas_model");
		$this->load->model("Clientes_model");
		$this->load->model("Productos_model");
		$this->load->model("Compras_model");

		$this->load->model("Usuarios_model");
		$this->load->model("Inventario_model");
		$this->load->model("Sucursales_model");
	}

	public function index(){
		
		$data  = array(
			//'permisos' => $this->permisos,
			'pedidos' => $this->Pedidos_model->getPedidos(), 
		);


		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/pedidos/list",$data);
		$this->load->view("layouts/footer");
	}

	public function add(){

		$data = array(
			"clientes" => $this->Clientes_model->getClientes(),
			"usuario" => $this->Usuarios_model->getSucursal($this->session->userdata("id")),
			"sucursales" => $this->Sucursales_model->getSucursales()
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/pedidos/add",$data);
		$this->load->view("layouts/footer");
	}

	//metodo para mostrar productos en la accion de asociar
	public function getProductos(){
		$sucursal = $this->input->post("sucursal");
		$valor = $this->input->post("valor");
		$productos = $this->Inventario_model->searchProductos($valor,$sucursal,true);
		echo json_encode($productos);
	}

	public function getProductoByCode(){
		$codigo_barra = $this->input->post("codigo_barra");
		$producto = $this->Pedidos_model->getProductoByCode($codigo_barra);

		if ($producto != false) {
			echo json_encode($producto);
		}else{
			echo "0";
		}
	}

	public function store(){
		
		$fecha = $this->input->post("fecha_registro");
		$fecha_entrega = $this->input->post("fecha_entrega");
		$cliente = $this->input->post("cliente");
		$total = $this->input->post("total");
		$sucursal = $this->input->post("sucursal");

		$idproductos = $this->input->post("idproductos");
		$cantidades = $this->input->post("cantidades");
		$importes = $this->input->post("importes");
		$precios = $this->input->post("precios");

		$data = array(
			'fecha' => $fecha,
			'fecha_entrega' => $fecha_entrega,
			'total' => $total,
			'cliente_id' => $cliente,
			'estado' => "0",
			"sucursal_id" => $sucursal
		);
		$pedido = $this->Pedidos_model->save($data);
		if ($pedido) {
			$this->saveDetalle($pedido, $idproductos, $precios, $cantidades, $importes);
			$this->updateStock($sucursal, $idproductos, $cantidades);

			$this->session->set_flashdata("success", "Los datos fueron guardados exitosamente");
			//echo "1";
			redirect(base_url()."movimientos/pedidos");
		}
		else{
			$this->session->set_flashdata("error", "Los datos no fueron guardados");
				//echo "1";
			redirect(base_url()."movimientos/pedidos/add");
		}
	}
	protected function saveDetalle($pedido_id, $productos, $precios, $cantidades, $importes){
		for ($i=0; $i < count($productos) ; $i++) { 
			$dataDetalle = array(
				"producto_id" => $productos[$i],
				"pedido_id" => $pedido_id,
				"cantidad" => $cantidades[$i],
				"precio" =>  $precios[$i],
				"importe" => $importes[$i],
			);
			$this->Pedidos_model->saveDetalle($dataDetalle);
		}
	}

	protected function updateStock($sucursal_id, $productos, $cantidades){
		for ($i=0; $i < count($productos) ; $i++) { 
			$ps = $this->Inventario_model->getProductoSucursal($productos[$i],$sucursal_id);
			$data = array(
				"stock" => $ps->stock - $cantidades[$i] 
			);
			$this->Inventario_model->update($ps->id,$data);
		}
	}

	public function view(){
		$idPedido = $this->input->post("id");
		$data = array(
			"pedido" => $this->Pedidos_model->getPedido($idPedido),
			"detalles" =>$this->Pedidos_model->getDetalle($idPedido)
		);
		$this->load->view("admin/pedidos/view",$data);
	}

	public function finalizarPedido($idPedido){
		$pedido = $this->Pedidos_model->getPedido($idPedido);
		$detalles = $this->Pedidos_model->getDetalle($idPedido);
		$data = array(
			"estado" => 1
		);
		if ($this->Pedidos_model->update($idPedido,$data)) {
			$fecha = date("Y-m-d H:i:s");
			$cliente = $pedido->cliente_id;
			$total = $pedido->total;

			$data = array(
				'fecha' => $fecha,
				'total' => $total,
				'cliente_id' => $cliente,
				'usuario_id' => $this->session->userdata('id'),
				'estado' => "1"
			);
			$venta = $this->Ventas_model->save($data);
			if ($venta) {
				//$this->saveDetalle($venta, $idproductos, $precios, $cantidades, $importes);
				foreach ($detalles as $detalle) {
					$dataDetalle = array(
						"producto_id" => $detalle->producto_id,
						"venta_id" => $venta,
						"cantidad" => $detalle->cantidad,
						"precio" =>  $detalle->precio,
						"importe" => $detalle->importe,
					);
					$this->Ventas_model->saveDetalle($dataDetalle);
				}
				$this->session->set_flashdata("success", "Se ha finalizado el pedido con exito");
				//echo "1";
				redirect(base_url()."movimientos/pedidos");
			}
			else{
				$this->session->set_flashdata("error", "No se pudo actualizar el estado del pedido");
					//echo "1";
				redirect(base_url()."movimientos/pedidos");
			}
			
		}else{
			$this->session->set_flashdata("error", "No se pudo actualizar el estado del pedido");
					//echo "1";
			redirect(base_url()."movimientos/pedidos");
		}
	}



}