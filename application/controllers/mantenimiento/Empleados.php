<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empleados extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model("Empleados_model");
		$this->load->model("Sucursales_model");
	}

	public function index()
	{
		$data  = array(
			'empleados' => $this->Empleados_model->getEmpleados(), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/empleados/list",$data);
		$this->load->view("layouts/footer");

	}
	public function add(){
		$data = array(
			"sucursales" => $this->Sucursales_model->getSucursales()
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/empleados/add",$data);
		$this->load->view("layouts/footer");
	}
	public function store(){

		$nombre = $this->input->post("nombre");
		$apellido = $this->input->post("apellido");
		$sueldo = $this->input->post("sueldo");
		$puesto_trabajo = $this->input->post("puesto_trabajo");
		$sucursal = $this->input->post("sucursal");
		
		$data =array(
			"nombre" => $nombre,
			"apellido" => $apellido,
			"sueldo" => $sueldo,
			"puesto_trabajo" => $puesto_trabajo,
			"sucursal_id" => $sucursal,
			"estado" => "1",
		);

		if ($this->Empleados_model->save($data)) {
			redirect(base_url()."mantenimiento/empleados");
		}
		else{
			$this->session->set_flashdata("error","No se pudo guardar la informacion");
			redirect(base_url()."mantenimiento/empleados/add");
		}
		
		
	}
	public function edit($id){
		$data  = array(
			'empleado' => $this->Empleados_model->getEmpleado($id),
			"sucursales" => $this->Sucursales_model->getSucursales()
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/empleados/edit",$data);
		$this->load->view("layouts/footer");
	}


	public function update(){
		$idEmpleado = $this->input->post("idEmpleado");
		$nombre = $this->input->post("nombre");
		$apellido = $this->input->post("apellido");
		$sueldo = $this->input->post("sueldo");
		$puesto_trabajo = $this->input->post("puesto_trabajo");
		$sucursal = $this->input->post("sucursal");

		$data = array(
			"nombre" => $nombre,
			"apellido" => $apellido,
			"sueldo" => $sueldo,
			"puesto_trabajo" => $puesto_trabajo,
			"sucursal_id" => $sucursal,
		);

		if ($this->Empleados_model->update($idEmpleado,$data)) {
			redirect(base_url()."mantenimiento/empleados");
		}
		else{
			$this->session->set_flashdata("error","No se pudo actualizar la informacion");
			redirect(base_url()."mantenimiento/empleados/edit/".$idEmpleado);
		}
		

	}

	public function view($id){
		$data  = array(
			'empleado' => $this->Empleados_model->getEmpleado($id), 
		);
		$this->load->view("admin/empleados/view",$data);
	}

	public function delete($id){
		$data  = array(
			'estado' => "0", 
		);
		$this->Empleados_model->update($id,$data);
		redirect(base_url()."mantenimiento/empleados");
		//echo "mantenimiento/empleados";
	}

	public function restore($id){
		$data  = array(
			'estado' => "1", 
		);
		$this->Empleados_model->update($id,$data);
		redirect(base_url()."mantenimiento/empleados");
		//echo "almacen/empleados";
	}
}