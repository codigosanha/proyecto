<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ventas extends CI_Controller {
	//private $permisos;
	private $modulo = "Ventas";
	public function __construct(){
		parent::__construct();
		//$this->permisos = $this->backend_lib->control();
		$this->load->model("Ventas_model");
		$this->load->model("Clientes_model");
		$this->load->model("Productos_model");
		$this->load->model("Compras_model");

		$this->load->model("Usuarios_model");
		$this->load->model("Inventario_model");
	}

	public function index(){
		$usuario = $this->Usuarios_model->getSucursal($this->session->userdata("id"));
		$data  = array(
			//'permisos' => $this->permisos,
			'ventas' => $this->Ventas_model->getVentas($usuario->sucursal_id), 
		);


		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/ventas/list",$data);
		$this->load->view("layouts/footer");
	}

	public function add(){

		$data = array(
			"clientes" => $this->Clientes_model->getClientes(),
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/ventas/add",$data);
		$this->load->view("layouts/footer");
	}

	//metodo para mostrar productos en la accion de asociar
	public function getProductos(){
		$usuario = $this->Usuarios_model->getSucursal($this->session->userdata("id"));
		$valor = $this->input->post("valor");
		$productos = $this->Inventario_model->searchProductos($valor,$usuario->sucursal_id,true);
		echo json_encode($productos);
	}

	public function getProductoByCode(){
		$codigo_barra = $this->input->post("codigo_barra");
		$producto = $this->Ventas_model->getProductoByCode($codigo_barra);

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

	protected function numberDocumentGenerated($id){
		$comprobante = $this->Comprobante_model->getComprobante($id);
		return str_pad($comprobante->cantidad + 1, 8, '0', STR_PAD_LEFT);
	}

	protected function updatePedidoProductos($pedidoproductos,$cantidades){
		for ($i=0; $i < count($pedidoproductos); $i++) { 
			$infoP = $this->Ordenes_model->getPedidoProducto($pedidoproductos[$i]);

			$pagados = $infoP->pagados + $cantidades[$i];
			$estado = 0;
			if ($infoP->cantidad == $pagados) {
				$estado = 1;
			}

			$data  = array(
				"estado" => $estado,
				"pagados" => $pagados
			);

			$this->Ordenes_model->updatePedidoProductos($pedidoproductos[$i],$data);
		}
	}

	protected function updateComprobante($idcomprobante){
		$comprobanteActual = $this->Ventas_model->getComprobante($idcomprobante);
		$data  = array(
			'cantidad' => $comprobanteActual->cantidad + 1, 
		);
		$this->Ventas_model->updateComprobante($idcomprobante,$data);
	}

	protected function save_detalle($productos,$idventa,$precios,$cantidades,$importes){
		for ($i=0; $i < count($productos); $i++) { 
			$data  = array(
				'producto_id' => $productos[$i], 
				'venta_id' => $idventa,
				'precio' => $precios[$i],
				'cantidad' => $cantidades[$i],
				'importe'=> $importes[$i],
			);

			$this->Ventas_model->save_detalle($data);
			$this->updateStockProducto($productos[$i],$cantidades[$i]);
			$this->GenerarNotificacion($productos[$i]);
			//Descontar stock de los productos asociados
			$cantidadProdAsociados = $this->Productos_model->getProductosA($productos[$i]);
			if (!empty($cantidadProdAsociados)) {
				foreach ($cantidadProdAsociados as $cpa) {
					$this->updateStockProducto($cpa->producto_asociado,($cantidades[$i] * $cpa->cantidad));
					$this->GenerarNotificacion($cpa->producto_asociado);
				}
			}
		}
		$this->reset_stock_negative();
	}

	protected function reset_stock_negative(){
		$data = array(
			"stock" => 0
		);
		$products = $this->Productos_model->setear_stock_negative($data);
	}

	protected function GenerarNotificacion($idproducto){
		$productoActual = $this->Productos_model->getProducto($idproducto);
		if ($productoActual->stock <= $productoActual->stock_minimo) {
			$data = array(
				'estado' => 0,
				'producto_id' => $idproducto
			);
			$this->Ventas_model->saveNotificacion($data);
		}
	}

	protected function updateStockProducto($idproducto,$cantidad){
		$infoproducto = $this->Productos_model->getProducto($idproducto);

		$data = array(
			'stock' => $infoproducto->stock - $cantidad, 
		);
		$this->Productos_model->update($idproducto, $data);
	}

	protected function updateProductosAsociados($idproducto){
		$productosA = $this->Productos_model->getProductosA($idproducto);
		if (!empty($productosA)) {
			foreach ($productosA as $productoA) {
				$productoActual = $this->Productos_model->getProducto($productoA->producto_asociado);
					$this->updateProducto($productoA->producto_asociado,$productoA->cantidad);
				
				
			}
		}
	}

	protected function updateProducto($idproducto,$cantidad){
		$productoActual = $this->Productos_model->getProducto($idproducto);
		$data = array(
			'stock' => $productoActual->stock - $cantidad, 
		);
		$this->Productos_model->update($idproducto,$data);
	}

	public function view(){
		$idventa = $this->input->post("id");
		$data = array(
			"venta" => $this->Ventas_model->getVenta($idventa),
			"detalles" =>$this->Ventas_model->getDetalle($idventa)
		);
		$this->load->view("admin/ventas/view",$data);
	}

	public function view_orden(){
		$idventa = $this->input->post("id");
		$data = array(
			"venta" => $this->Ventas_model->getVenta($idventa),
			"detalles" =>$this->Ventas_model->getDetalle($idventa)
		);
		$this->load->view("admin/ventas/view3",$data);
	}

	public function edit($id)
	{
		$data  = array(
			'venta' => $this->Ventas_model->getVenta($id), 
			"detalles" =>$this->Ventas_model->getDetalle($id),
			"tipocomprobantes" => $this->Ventas_model->getComprobantes(),
			"tipopagos" => $this->Ventas_model->getTipoPagos(),
			"clientes" => $this->Clientes_model->getClientes(),
			"estado" => "2",
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/ventas/edit",$data);
		$this->load->view("layouts/footer");
	}

	public function savecliente(){
		$nombre = $this->input->post("nombre");
		//$tipodocumento = $this->input->post("tipodocumento");
		//$tipocliente = $this->input->post("tipocliente");
		$direccion = $this->input->post("direccion");
		$telefono = $this->input->post("telefono");
		//$num_documento = $this->input->post("numero");

		$data  = array(
			'nombre' => $nombre, 
		//	'tipo_documento_id' => $tipodocumento,
		//	'tipo_cliente_id' => $tipocliente,
			'direccion' => $direccion,
			'telefono' => $telefono,
		//	'num_documento' => $num_documento,
			'estado' => "1"
		);
		$cliente = $this->Ventas_model->savecliente($data);
		if (!$cliente) {
			echo "0";
		}
		else{
			$data  = array(
				'id' => $cliente, 
				'nombres' => $nombre,
			);
			echo json_encode($data);
		}
		
	}

	public function update(){
		$idventa = $this->input->post("idVenta");
		$fecha = $this->input->post("fecha");
		$subtotal = $this->input->post("subtotal");
		$iva = $this->input->post("iva");
		$descuento = $this->input->post("descuento");
		$total = $this->input->post("total");
		$comprobante_id = $this->input->post("comprobante_id");
		$tipo_pago = $this->input->post("tipo_pago");
		$idcliente = $this->input->post("idcliente");
		$idusuario = $this->session->userdata("id");

		$idproductos = $this->input->post("idproductos");
		$precios = $this->input->post("precios");
		$cantidades = $this->input->post("cantidades");
		$importes = $this->input->post("importes");

		$data = array(
			'fecha' => $fecha,
			'subtotal' => $subtotal,
			'iva' => $iva,
			//'iva' => $iva,
			'descuento' => $descuento,
			'total' => $total,
			'tipo_comprobante_id' => $comprobante_id,
			'cliente_id' => $idcliente,
			'usuario_id' => $idusuario,
			'estado' => $tipo_pago
		);

		$this->retornarStockVenta($idventa);

        $this->Ventas_model->deleteDetail($idventa);
        
        if ($this->Ventas_model->update($idventa, $data)) {
            //$this->session->set_flashdata("msg_success","La informacion de la categoria  ".$name." se actualizo correctamente");
            for ($i = 0; $i < count($idproductos);$i++) {
                $this->save_detalle($idproductos,$idventa,$precios,$cantidades,$importes);
            }
            $this->backend_lib->savelog($this->modulo,"Actualizacion de la venta con identificador ".$idventa);
            $this->session->set_flashdata("msg_success","La informacion de la venta se actualizo correctamente");
            redirect(base_url() . "movimientos/ventas");
        } else {
            //$this->session->set_flashdata("msg_error","La informacion de la categoria ".$name." no pudo actualizarse");
            //redirect(base_url() . "movimientos/ventas/edit/" . $idarea);
           
        }
	}

	protected function retornarStockVenta($idventa){
		$detalles = $this->Ventas_model->getDetalle($idventa);

        foreach ($detalles as $detalle) {
            $infoproducto = $this->Productos_model->getProducto($detalle->producto_id);
            //reponer stock de los productos asociados
            $productosAsociados = $this->Productos_model->getProductosA($detalle->producto_id);

        	foreach ($productosAsociados as $productoA) {
        		$infoproductoA = $this->Productos_model->getProducto($productoA->producto_asociado);

        		$dataProductoA = array(
                    'stock' => $infoproductoA->stock + ($productoA->cantidad * $detalle->cantidad), 
                );

                $this->Productos_model->update($productoA->producto_asociado,$dataProductoA);

        	}
        	//Actualizando el stock del producto
            $dataProducto = array(
                'stock' => $infoproducto->stock + $detalle->cantidad, 
            );

            $this->Productos_model->update($detalle->producto_id,$dataProducto);
        }
	}


    public function delete($idventa)
    {
        $this->retornarStockVenta($idventa);
        //$this->Ventas_model->deleteDetail($idventa);
        $data  = array(
            'estado' => "0", 
        );
        $this->backend_lib->savelog($this->modulo,"Eliminacion de la venta con identificador ".$idventa);
        $this->Ventas_model->update($idventa,$data);
        echo "movimientos/ventas";

    }


    public function comprobarPassword(){
    	$password = $this->input->post("password");

    	if (!$this->Ventas_model->comprobarPassword($password)) {
    		echo "0";
    	}else{
    		echo "1";
    	}
    }

    public function descontarStock(){
    	$idproducto = $this->input->post("idproducto");
    	$stock = $this->input->post("stock");
    	$asociado = $this->input->post("asociado");

    	$this->products[$idproducto]['stock'] = $this->products[$idproducto]['stock'] - $stock;
    	echo json_encode($this->products);



    }

    public function verStock(){
    	echo json_encode($this->products);
    }

}