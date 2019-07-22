<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compras extends CI_Controller {

	public function __construct(){
		parent::__construct();
		
		$this->load->model("Compras_model");
	}

	public function index(){
		$fechainicio = $this->input->post("fechainicio");
		$fechafin = $this->input->post("fechafin");
		if ($this->input->post("buscar")) {
			$compras = $this->Compras_model->getComprasbyDate($fechainicio,$fechafin);
		}
		else{
			$compras = $this->Compras_model->getCompras();
		}
		$data = array(
			"compras" => $compras,
			"fechainicio" => $fechainicio,
			"fechafin" => $fechafin
		);

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/reportes/compras",$data);
		$this->load->view("layouts/footer");
	}
}