<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedores extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if (!$this->session->userdata("login")) {
			redirect(base_url());
		}
		$this->load->model("Proveedores_model");
		//$this->load->model("Sucursal_model");
	}

	public function index()
	{
		$data  = array(
			'proveedores' => $this->Proveedores_model->getProveedores(), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/proveedores/list",$data);
		$this->load->view("layouts/footer");

	}
	public function add(){

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/proveedores/add");
		$this->load->view("layouts/footer");
	}
	public function store(){

		$nit = $this->input->post("nit");
		$razon_social = $this->input->post("razon_social");
		$direccion = $this->input->post("direccion");
		$telefono = $this->input->post("telefono");		

		$this->form_validation->set_rules("razon_social","Nombre de la Razon Social","required");
		

		if ($this->form_validation->run()) {
			$data  = array(
				'nit' => $nit,
				'razon_social' => $razon_social,
				'direccion' => $direccion,
				'telefono' => $telefono,
				'estado' => "1"
			);

			if ($this->Proveedores_model->save($data)) {
				redirect(base_url()."mantenimiento/proveedores");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."mantenimiento/proveedores/add");
			}
		}
		else{
			$this->add();
		}

		
	}
	public function edit($id){
		$data  = array(
			'proveedor' => $this->Proveedores_model->getProveedor($id)
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/proveedores/edit",$data);
		$this->load->view("layouts/footer");
	}


	public function update(){
		$idProveedor = $this->input->post("idProveedor");
		$nit = $this->input->post("nit");
		$razon_social = $this->input->post("razon_social");
		$direccion = $this->input->post("direccion");
		$telefono = $this->input->post("telefono");
		

		$proveedorActual = $this->Proveedores_model->getProveedor($idProveedor);

		if ($razon_social == $proveedorActual->razon_social) {
			$is_unique = "";
		}else{
			$is_unique= '|is_unique[proveedores.razon_social]';
		}

		$this->form_validation->set_rules("razon_social","Nombre de la Razon Social","required");
		

		if ($this->form_validation->run()) {
			$data = array(
				'razon_social' => $razon_social, 
			);

			if ($this->Proveedores_model->update($idProveedor,$data)) {
				redirect(base_url()."mantenimiento/proveedores");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."mantenimiento/proveedores/edit/".$idProveedor);
			}
		}else{
			$this->edit($idProveedor);
		}

		

	}

	public function view($id){
		$data  = array(
			'proveedor' => $this->Proveedores_model->getProveedor($id), 
		);
		$this->load->view("admin/proveedores/view",$data);
	}

	public function delete($id){
		$data  = array(
			'estado' => "0", 
		);
		$this->Proveedores_model->update($id,$data);
		redirect(base_url()."mantenimiento/proveedores");
		//echo "almacen/categorias";
	}

	public function restore($id){
		$data  = array(
			'estado' => "1", 
		);
		$this->Proveedores_model->update($id,$data);
		redirect(base_url()."mantenimiento/proveedores");
		//echo "almacen/categorias";
	}
}