<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if (!$this->session->userdata("login")) {
			redirect(base_url());
		}
		$this->load->model("Inventario_model");
		$this->load->model("Categorias_model");
		$this->load->model("Ventas_model");
		$this->load->model("Presentaciones_model");
		$this->load->model("Marcas_model");
	}

	public function index()
	{
		$data  = array(
			'productos' => $this->Inventario_model->getInventario($this->session->userdata("sucursal_id")), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/reportes/productos",$data);
		$this->load->view("layouts/footer");

	}
}