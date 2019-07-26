<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ajuste extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model("Ajustes_model");
		$this->load->model("Productos_model");
		$this->load->model("Inventario_model");
	}

	public function index()
	{
		$data  = array(
			'ajustes' => $this->Ajustes_model->getAjustes(),
			'ajusteActual' => $this->Ajustes_model->ajusteActual(),
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/ajustes/list",$data);
		$this->load->view("layouts/footer");
	}

	public function add(){
		$data = array(
			'productos' => $this->Ajustes_model->getProductos(),
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/ajustes/add",$data);
		$this->load->view("layouts/footer");

	}

	public function store(){
		$usuario_id = $this->session->userdata("id");
		$fecha = date("Y-m-d H:i:s");
		$productos = $this->input->post("productos");
		$stocks_bd = $this->input->post("stocks_bd");
		$stocks_fisico = $this->input->post("stocks_fisico");
		$stocks_diferencia = $this->input->post("stocks_diferencia");

		$data  = array(
			'fecha' => $fecha, 
			'usuario_id' => $usuario_id,
			'sucursal_id' => $this->session->userdata("sucursal_id")
		);

		$ajuste_id = $this->Ajustes_model->save($data);
		if ($ajuste_id != false) {
			$this->saveAjusteProductos($ajuste_id,$productos,$stocks_bd,$stocks_fisico,$stocks_diferencia);
			$this->session->set_flashdata("success",$ajuste_id);
			redirect(base_url()."inventario/ajuste");
		}

		else{

			$this->session->set_flashdata("error","No se pudo guardar la informacion");

			redirect(base_url()."inventario/ajuste/add");

		}

		

	}



	protected function saveAjusteProductos($ajuste_id,$productos,$stocks_bd,$stocks_fisico,$stocks_diferencia){

		for ($i=0; $i < count($productos); $i++) { 
			$data = array(
				'ajuste_id' => $ajuste_id,
				'producto_id' => $productos[$i],
				'stock_bd' => $stocks_bd[$i],
				'stock_fisico' => $stocks_fisico[$i],
				'diferencia_stock' => $stocks_diferencia[$i]

			);
			$dataInventario = array(
				'stock' => $stocks_fisico[$i]
			);
			$this->Inventario_model->updateStock($productos[$i],$this->session->userdata('sucursal_id'), $dataInventario);
			$this->Ajustes_model->saveAjusteProductos($data);
		}
	} 



	public function edit($id){

		$data  = array(
			'ajuste' => $this->Ajustes_model->getAjuste($id),
			'ajustes' => $this->Ajustes_model->getAjusteProductos($id), 

		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/ajustes/edit",$data);
		$this->load->view("layouts/footer");

	}



	public function update(){
		$idAjuste = $this->input->post("idAjuste");
		$productos = $this->input->post("productos");
		$stocks_fisico = $this->input->post("stocks_fisico");
		$stocks_diferencia = $this->input->post("stocks_diferencia");

		for ($i=0; $i < count($productos); $i++) { 
			$data = array(
				'stock_fisico' => $stocks_fisico[$i],
				'diferencia_stock' => $stocks_diferencia[$i],
			);
			$dataInventario = array(
				'stock' => $stocks_fisico[$i]
			);
			$this->Inventario_model->updateStock($productos[$i],$this->session->userdata('sucursal_id'), $dataInventario);
			$this->Ajustes_model->updateAjuste($idAjuste,$productos[$i],$data);

		}

		$this->session->set_flashdata("success",$idAjuste);
		redirect(base_url()."inventario/ajuste");
	}


	public function view($ajuste_id){
		$data = array(
			'ajuste' => $this->Ajustes_model->getAjuste($ajuste_id),
			'productos' => $this->Ajustes_model->getAjusteProductos($ajuste_id),
		);

		$this->load->view("admin/ajustes/view", $data);
	}

}
