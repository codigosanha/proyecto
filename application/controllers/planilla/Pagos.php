<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pagos extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model("Pagos_model");
		$this->load->model("Empleados_model");
		//if (!$this->session->userdata('username')){ 
		//	redirect('Auth');
	}

	public function index()
	{
		$data  = array(
			'pagos' => $this->Pagos_model->getPagos(), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/pagos/list",$data);
		$this->load->view("layouts/footer");

	}

	public function add(){
		$data = array(
			"empleados" => $this->Empleados_model->getEmpleados()
		);

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/pagos/add",$data);
		$this->load->view("layouts/footer");
	}

	public function store(){

		$empleado_id = $this->input->post("empleado_id");
		$mes = $this->input->post("mes");


		$data  = array(
			'fecha' => date("Y-m-d"), 
			'empleado_id' => $empleado_id,
			'mes' => $mes,
		);

		if ($this->Pagos_model->save($data)) { //Retorna BOOLEAN
			redirect(base_url()."planilla/pagos");
		}
		else{
			$this->session->set_flashdata("error","No se pudo guardar la informacion");
			redirect(base_url()."planilla/pagos/add");
		}
	}

	public function view($id){
		$data  = array(
			'pago' => $this->Pagos_model->getPago($id), 
		);
		$this->load->view("admin/pagos/view",$data);
	}

}
