<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activos extends CI_Controller {

	
	public function __construct(){
		parent::__construct();
		if (!$this->session->userdata("login")) {
			redirect(base_url());
		}
		$this->load->model("Activos_model");
		$this->load->model("Empleados_model");
		//if (!$this->session->userdata('username')){ 
		//	redirect('Auth');
	}

	public function index()
	{
		$data  = array(
			'activos' => $this->Activos_model->getActivos(),
			//'empleados' =>  $this->Empleados_model->getEmpleados(),
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/reportes/activos",$data);
		$this->load->view("layouts/footer");

	}
}
