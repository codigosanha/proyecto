<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compras extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if (!$this->session->userdata("login")) {
			redirect(base_url());
		}
		$this->load->model("Compras_model");
	}

	public function index(){
		$fechainicio = date("Y-m-d");
		$fechafin = date("Y-m-d");
		if ($this->input->post("buscar")) {
			$fechainicio = $this->input->post("fechainicio");
			$fechafin = $this->input->post("fechafin");
			
		}
		$compras = $this->Compras_model->getComprasbyDate($fechainicio,$fechafin);
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