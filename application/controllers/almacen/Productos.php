<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends CI_Controller {
//	private $permisos;
//	private $modulo = "Productos";

	public function __construct(){
		parent::__construct();

		$this->load->model("Productos_model");
		$this->load->model("Categorias_model");
		$this->load->model("Ventas_model");
		$this->load->model("Presentacion_model");
		$this->load->model("Marcas_model");
	}

	public function index()
	{
		$data  = array(
			'productos' => $this->Productos_model->getProductos()
			//'productoslast' => $this->Productos_model->getLastProductos()
		);

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/productos/list",$data);
		$this->load->view("layouts/footer");

	}
	public function add(){
		
		$data =array( 
			"categorias" => $this->Categorias_model->getCategorias(),
			"productos" => $this->Productos_model->getProductos(),
			"presentaciones" => $this->Presentacion_model->getPresentaciones(),
			"marcas" => $this->Marcas_model->getMarcas(),
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/productos/add",$data);
		$this->load->view("layouts/footer");
	}

	public function store(){

		$cod_barras = $this->input->post("cod_barras");
		$nombre = $this->input->post("nombre");
		$precio_compra = $this->input->post("precio_compra");
		$precio_venta = $this->input->post("precio_venta");
		$descripcion = $this->input->post("descripcion");
		$categoria = $this->input->post("categoria");
		$marca = $this->input->post("marca");
		$presentacion = $this->input->post("presentacion");
		
		$this->form_validation->set_rules("cod_barras","Codigo de Barras","required|is_unique[productos.cod_barras]");
		$this->form_validation->set_rules("nombre","Nombre","required");


		if ($this->form_validation->run()==TRUE) {
			
            $data  = array(
				'cod_barras' => $cod_barras,
				'nombre' => $nombre,
				'descripcion' => $descripcion,
				'precio_venta' => $precio_venta,
				'precio_compra' => $precio_compra,
				'categoria_id' => $categoria,
				"marca_id" => $marca,
				"presentacion_id" => $presentacion,
				'estado' => "1",
			);
			// $producto_id = $this->Productos_model->save($data);
			// if ($producto_id != false) {
			// 	$this->generateBarCode($codigo_barras);

			// 	if (!empty($idproductosA)) {
			// 		//Guardar productos Asociados
			// 		for($i = 0; $i < count($idproductosA); $i++){
			// 			$dataA = array(
			// 				"producto_id" => $producto_id,
			// 				"producto_asociado" => $idproductosA[$i],
			// 				"cantidad" => $cantidadA[$i]
			// 			);

			// 			$this->Productos_model->saveAsociados($dataA);
			// 		}
			// 	}
			// 	$this->backend_lib->savelog($this->modulo,"Inserción de un nuevo producto con codigo de barras ".$codigo_barras);
			// 	redirect(base_url()."mantenimiento/productos");
			// }
            if ($this->Productos_model->save($data)){
            	redirect(base_url()."almacen/productos");
            }
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."almacen/productos/add");
			}
		}
		else{
			$this->add();
		}

		
	}

	public function edit($id){
		$data =array( 
			"producto" => $this->Productos_model->getProducto($id),
			"categorias" => $this->Categorias_model->getCategorias(),
			"presentaciones" => $this->Presentacion_model->getPresentaciones(),
			"marcas" => $this->Marcas_model->getMarcas(),
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/productos/edit",$data);
		$this->load->view("layouts/footer");
	}

	public function update(){
		$idproducto = $this->input->post("idProducto");
		$cod_barras = $this->input->post("cod_barras");
		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");
		$precio_venta = $this->input->post("precio_venta");
		$precio_compra = $this->input->post("precio_compra");
		$presentacion = $this->input->post("presentacion");
		$marca = $this->input->post("marca");
		$categoria = $this->input->post("categoria");
		

		$productoActual = $this->Productos_model->getProducto($idproducto);

		if ($cod_barras == $productoActual->cod_barras) {
			$is_unique = '';
		}
		else{
			$is_unique = '|is_unique[productos.cod_barras]';
		}

		$this->form_validation->set_rules("cod_barras","Codigo de Barras","required".$is_unique);
		$this->form_validation->set_rules("nombre","Nombre","required");
		

		if ($this->form_validation->run()) {

			$data  = array(
				'cod_barras' => $cod_barras,
				'nombre' => $nombre,
				'descripcion' => $descripcion,
				'precio_venta' => $precio_venta,
				'precio_compra' => $precio_compra,
				'categoria_id' => $categoria,
				"marca_id" => $marca,
				"presentacion_id" => $presentacion,
				
			);
			if ($this->Productos_model->update($idproducto,$data)) {

				//$this->generateBarCode($cod_barras);
				
				
				redirect(base_url()."almacen/productos");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."almacen/productos/edit/".$idproducto);
			}
		}else{
			$this->edit($idproducto);
		}

		
	}
	public function delete($id){
		$data  = array(
			'estado' => "0", 
		);
		$this->Productos_model->update($id,$data);
		redirect(base_url()."almacen/productos");
		//echo "almacen/categorias";
	}

	public function restore($id){
		$data  = array(
			'estado' => "1", 
		);
		$this->Productos_model->update($id,$data);
		redirect(base_url()."almacen/productos");
		//echo "almacen/categorias";
	}

	public function view($id){
		$data  = array(
			'producto' => $this->Productos_model->getProducto($id), 
		);
		$this->load->view("admin/productos/view",$data);
	}

	protected function generateBarCode($codigo_barras){
		$this->load->library('zend');
	   	$this->zend->load('Zend/Barcode');
	   	$file = Zend_Barcode::draw('code128', 'image', array('text' => $codigo_barras), array());
	   	//$code = time().$code;
	   	$store_image = imagepng($file,"./assets/barcode/{$codigo_barras}.png");
	}

}