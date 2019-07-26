<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if (!$this->session->userdata("login")) {
			redirect(base_url());
		}
		$this->load->model("Clientes_model");
	}

	public function index()
	{
		$data  = array(
			'clientes' => $this->Clientes_model->getClientes(), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/clientes/list",$data);
		$this->load->view("layouts/footer");

	}
	public function add(){
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/clientes/add");
		$this->load->view("layouts/footer");
	}
	public function store(){

		$nombres = $this->input->post("nombres");
		$direccion = $this->input->post("direccion");
		$telefono = $this->input->post("telefono");
	

		$this->form_validation->set_rules("nombres","Nombre del Cliente","required");
		

		if ($this->form_validation->run()) {
			$data  = array(
				'nombres' => $nombres, 
				'direccion' => $direccion,
				'telefono' => $telefono,
				'estado' => "1"
			);

			if ($this->Clientes_model->save($data)) {
				redirect(base_url()."mantenimiento/clientes");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."mantenimiento/clientes/add");
			}
		}
		else{
			$this->add();
		}

		
	}
	public function edit($id){
		$data  = array(
			'cliente' => $this->Clientes_model->getCliente($id)
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/clientes/edit",$data);
		$this->load->view("layouts/footer");
	}


	public function update(){
		$idcliente = $this->input->post("idcliente");
		$nombres = $this->input->post("nombres");
		$direccion = $this->input->post("direccion");
		$telefono = $this->input->post("telefono");

		$clienteActual = $this->Clientes_model->getCliente($idcliente);

		if ($nombres == $clienteActual->nombres) {
			$is_unique = "";
		}else{
			$is_unique= '|is_unique[clientes.nombres]';
		}

		$this->form_validation->set_rules("nombres","Nombre del Cliente","required");

		if ($this->form_validation->run()) {
			$data = array(
				'nombres' => $nombres, 
				'direccion' => $direccion,
				'telefono' => $telefono,
			);

			if ($this->Clientes_model->update($idcliente,$data)) {
				redirect(base_url()."mantenimiento/clientes");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."mantenimiento/clientes/edit/".$idcliente);
			}
		}else{
			$this->edit($idcliente);
		}

		

	}

	public function view($id){
		$data  = array(
			'cliente' => $this->Clientes_model->getCliente($id), 
		);
		$this->load->view("admin/clientes/view",$data);
	}

	public function delete($id){
		$data  = array(
			'estado' => "0", 
		);
		$this->Clientes_model->update($id,$data);
		redirect(base_url()."mantenimiento/clientes");
		//echo "mantenimiento/clientes";
	}

	public function restore($id){
		$data  = array(
			'estado' => "1", 
		);
		$this->Clientes_model->update($id,$data);
		redirect(base_url()."mantenimiento/clientes");
		//echo "mantenimiento/clientes";
	}
}