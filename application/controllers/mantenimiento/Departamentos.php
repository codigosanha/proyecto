<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Departamentos extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model("Departamentos_model");
		//$this->load->model("Sucursal_model");
	}

	public function index()
	{
		$data  = array(
			'departamentos' => $this->Departamentos_model->getDepartamentos(), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/departamentos/list",$data);
		$this->load->view("layouts/footer");

	}
	public function add(){

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/departamentos/add");
		$this->load->view("layouts/footer");
	}
	public function store(){

		$nombre = $this->input->post("nombre");
		

		$this->form_validation->set_rules("nombre","Nombre del Departamento","required");
		

		if ($this->form_validation->run()) {
			$data  = array(
				'nombre' => $nombre,
				'estado' => "1"
			);

			if ($this->Departamentos_model->save($data)) {
				redirect(base_url()."mantenimiento/departamentos");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."mantenimiento/departamentos/add");
			}
		}
		else{
			$this->add();
		}

		
	}
	public function edit($id){
		$data  = array(
			'departamento' => $this->Departamentos_model->getDepartamento($id)
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/departamentos/edit",$data);
		$this->load->view("layouts/footer");
	}


	public function update(){
		$iddepartamento = $this->input->post("idcliente");
		$nombre = $this->input->post("nombre");
		

		$departamentoActual = $this->Departamentos_model->getDepartamento($iddepartamento);

		if ($nombre == $departamentoActual->nombre) {
			$is_unique = "";
		}else{
			$is_unique= '|is_unique[departamentos.nombre]';
		}

		$this->form_validation->set_rules("nombre","Nombre del Departamento","required");
		

		if ($this->form_validation->run()) {
			$data = array(
				'nombre' => $nombre, 
			);

			if ($this->Clientes_model->update($iddepartamento,$data)) {
				redirect(base_url()."mantenimiento/departamentos");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."mantenimiento/departamentos/edit/".$iddepartamento);
			}
		}else{
			$this->edit($iddepartamento);
		}

		

	}

	public function view($id){
		$data  = array(
			'departamento' => $this->Departamentos_model->getDepartamento($id), 
		);
		$this->load->view("admin/departamentos/view",$data);
	}

	public function delete($id){
		$data  = array(
			'estado' => "0", 
		);
		$this->Departamentos_model->update($id,$data);
		redirect(base_url()."mantenimiento/departamentos");
		//echo "almacen/categorias";
	}

	public function restore($id){
		$data  = array(
			'estado' => "1", 
		);
		$this->Departamentos_model->update($id,$data);
		redirect(base_url()."mantenimiento/departamentos");
		//echo "almacen/categorias";
	}
}