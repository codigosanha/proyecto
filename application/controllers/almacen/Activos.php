<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activos extends CI_Controller {

	
	public function __construct(){
		parent::__construct();
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
		$this->load->view("admin/activos/list",$data);
		$this->load->view("layouts/footer");

	}

	public function add(){

		$data =array( 
			"empleados" => $this->Empleados_model->getEmpleados(),
		);

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/activos/add", $data);
		$this->load->view("layouts/footer");
	}

	public function store(){

		$nombre = $this->input->post("nombre");
		$precio = $this->input->post("precio");
		$empleado = $this->input->post("empleado");

		$this->form_validation->set_rules("nombre","Nombre","required|is_unique[activos.nombre]");
		//Validaciones de los campos, campo nombre

		if ($this->form_validation->run()==TRUE) {

			$data  = array(
				'nombre' => $nombre, 
				'precio' => $precio,
				'empleado_id' => $empleado,  				
				'estado' => "1"
			);

			if ($this->Activos_model->save($data)) { //Retorna BOOLEAN
				redirect(base_url()."almacen/activos");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."almacen/activos/add");
			}
		}
		else{

			$this->add(); // Llamada al metodo add para mostrar form
		}

		
	}

	public function edit($id){//Recibe el parametro id de la categoria
		$data  = array(
			'activo' => $this->Activos_model->getActivo($id), 
			"empleados" => $this->Empleados_model->getEmpleados(),
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/activos/edit",$data);
		$this->load->view("layouts/footer");
	}

	public function update(){
		$idActivo = $this->input->post("idActivo");
		$nombre = $this->input->post("nombre");
		$precio = $this->input->post("precio");
		$empleado = $this->input->post("empleado");
	

		
		$data = array(
			'nombre' => $nombre, 
			'precio' => $precio,
			'empleado_id' => $empleado, 
		);

		if ($this->Activos_model->update($idActivo,$data)) {
			redirect(base_url()."almacen/activos");
		}
		else{
			$this->session->set_flashdata("error","No se pudo actualizar la informacion");
			redirect(base_url()."almacen/activos/edit/".$idActivo);
		}
		

		
	}

	public function view($id){
		$data  = array(
			'activo' => $this->Activos_model->getActivo($id), 
		);
		$this->load->view("admin/activos/view",$data);
	}

	public function delete($id){
		$data  = array(
			'estado' => "0", 
		);
		$this->Activos_model->update($id,$data);
		redirect(base_url()."almacen/activos");
		//echo "almacen/categorias";
	}

	public function restore($id){
		$data  = array(
			'estado' => "1", 
		);
		$this->Activos_model->update($id,$data);
		redirect(base_url()."almacen/activos");
		//echo "almacen/categorias";
	}
}
