<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sucursales extends CI_Controller {

	
	public function __construct(){
		parent::__construct();
		if (!$this->session->userdata("login")) {
			redirect(base_url());
		}
		$this->load->model("Sucursales_model");
		//if (!$this->session->userdata('username')){ 
		//	redirect('Auth');
	}

	public function index()
	{
		$data  = array(
			'sucursales' => $this->Sucursales_model->getSucursales(), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/sucursales/list",$data);
		$this->load->view("layouts/footer");

	}

	public function add(){

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/sucursales/add");
		$this->load->view("layouts/footer");
	}

	public function store(){

		$nombre = $this->input->post("nombre");
		$telefono = $this->input->post("telefono");
		$departamento_id = $this->input->post("departamento_id");

		$data  = array(
			'nombre' => $nombre, 
			'telefono' => $telefono, 
			'departamento_id' => $departamento_id, 
		);

		if ($this->Sucursales_model->save($data)) { //Retorna BOOLEAN
			redirect(base_url()."administrador/sucursales");
		}
		else{
			$this->session->set_flashdata("error","No se pudo guardar la informacion");
			redirect(base_url()."administrador/sucursales/add");
		}
	}

	public function edit($id){//Recibe el parametro id de la categoria
		$data  = array(
			'sucursal' => $this->Sucursales_model->getSucursal($id), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/sucursales/edit",$data);
		$this->load->view("layouts/footer");
	}

	public function update(){
		$idSucursal = $this->input->post("idSucursal");
		$nombre = $this->input->post("nombre");
		$telefono = $this->input->post("telefono");
		$departamento_id = $this->input->post("departamento_id");
		
		$data = array(
			'nombre' => $nombre, 
			'telefono' => $telefono, 
			'departamento_id' => $departamento_id, 
		);

		if ($this->Sucursales_model->update($idSucursal,$data)) {
			redirect(base_url()."administrador/sucursales");
		}
		else{
			$this->session->set_flashdata("error","No se pudo actualizar la informacion");
			redirect(base_url()."administrador/sucursales/edit/".$idSucursal);
		}
	}

	public function view($id){
		$data  = array(
			'sucursal' => $this->Sucursales_model->getSucursal($id), 
		);
		$this->load->view("admin/sucursales/view",$data);
	}

}
