<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		if (!$this->session->userdata("login")) {
			redirect(base_url());
		}
		$this->load->model("Usuarios_model");
		$this->load->model("Ventas_model");
		$this->load->model("Empleados_model");
	}

	public function index(){
		$data  = array(
			'usuarios' => $this->Usuarios_model->getUsuarios(), 
		);

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/usuarios/list",$data);
		$this->load->view("layouts/footer");
	}

	public function add(){
		$empleados = $this->Empleados_model->getEmpleados();
		$dataEmpleados = array();
		foreach ($empleados as $e) {
			if(!$this->Usuarios_model->verificarExistencia($e->id)){
				$dataEmpleados[] = $e;
			}
		}
		
		$data  = array(
			'empleados' => $dataEmpleados, 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/usuarios/add",$data);
		$this->load->view("layouts/footer");
	}

	public function store(){

		$empleado_id = $this->input->post("empleado_id");
		$username = $this->input->post("username");
		$password = $this->input->post("password");
		$rol = $this->input->post("rol");

		$data  = array(
			'empleado_id' => $empleado_id, 
			'username' => $username,
			'password' => sha1($password),
			'rol' => $rol,
			'estado' => "1"
		);

		if ($this->Usuarios_model->save($data)) {
			redirect(base_url()."administrador/usuarios");
		}
		else{
			$this->session->set_flashdata("error","No se pudo guardar la informacion");
			redirect(base_url()."administrador/usuarios/add");
		}

		
	}

	public function view(){
		$idusuario = $this->input->post("idusuario");
		$data = array(
			"usuario" => $this->Usuarios_model->getUsuario($idusuario)
		);
		$this->load->view("admin/usuarios/view",$data);
	}

	public function edit($id){
		$data  = array(
		
			'usuario' => $this->Usuarios_model->getUsuario($id)
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/usuarios/edit",$data);
		$this->load->view("layouts/footer");
	}

	public function update(){
		$idusuario = $this->input->post("idUsuario");
		$rol = $this->input->post("rol");
		$username = $this->input->post("username");

		$rol = $this->input->post("rol");

		$data  = array(
			'username' => $username,
			'rol' => $rol,
		);

		if ($this->Usuarios_model->update($idusuario,$data)) {
			redirect(base_url()."administrador/usuarios");
		}
		else{
			$this->session->set_flashdata("error","No se pudo guardar la informacion");
			redirect(base_url()."administrador/usuarios/edit/".$idusuario);
		}

		
	}

	public function delete($id){
		$data  = array(
			'estado' => "0", 
		);
		$this->Usuarios_model->update($id,$data);
		redirect(base_url()."administrador/usuarios");
		//echo "administrador/usuarios";
	}

	public function restore($id){
		$data  = array(
			'estado' => "1", 
		);
		$this->Usuarios_model->update($id,$data);
		redirect(base_url()."administrador/usuarios");
		//echo "administrador/usuarios";
	}
	public function changepassword(){
		$id = $this->input->post("idusuario");
		$newpassword = $this->input->post("newpassword");
		$repeatpassword = $this->input->post("repeatpassword");
		$data = array(
			"password" => sha1($newpassword)
		);

		if ($this->Usuarios_model->update($id,$data)) {
			echo "administrador/usuarios";
		}

	}

}