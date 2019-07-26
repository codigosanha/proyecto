<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ventas extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("Ventas_model");
	}

	public function index(){
		$fechainicio = date("Y-m-d");
		$fechafin = date("Y-m-d");
		if ($this->input->post("buscar")) {
			$fechainicio = $this->input->post("fechainicio");
			$fechafin = $this->input->post("fechafin");
			
		}
		$ventas = $this->Ventas_model->getVentasbyDate($fechainicio,$fechafin);
		$data = array(
			"ventas" => $ventas,
			"fechainicio" => $fechainicio,
			"fechafin" => $fechafin
		);

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/reportes/ventas",$data);
		$this->load->view("layouts/footer");
	}
}