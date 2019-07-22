<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias extends CI_Controller {

	
	public function __construct(){
		parent::__construct();
		$this->load->model("Categorias_model");
		//if (!$this->session->userdata('username')){ 
		//	redirect('Auth');
	}

	public function index()
	{
		$data  = array(
			'categorias' => $this->Categorias_model->getCategorias(), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/categorias/list",$data);
		$this->load->view("layouts/footer");

	}

	public function add(){

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/categorias/add");
		$this->load->view("layouts/footer");
	}

	public function store(){

		$nombre = $this->input->post("nombre");

		$this->form_validation->set_rules("nombre","Nombre","required|is_unique[categorias.nombre]");
		//Validaciones de los campos, campo nombre

		if ($this->form_validation->run()==TRUE) {

			$data  = array(
				'nombre' => $nombre, 
				'estado' => "1"
			);

			if ($this->Categorias_model->save($data)) { //Retorna BOOLEAN
				redirect(base_url()."almacen/categorias");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."almacen/categorias/add");
			}
		}
		else{

			$this->add(); // Llamada al metodo add para mostrar form
		}

		
	}

	public function edit($id){//Recibe el parametro id de la categoria
		$data  = array(
			'categoria' => $this->Categorias_model->getCategoria($id), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/categorias/edit",$data);
		$this->load->view("layouts/footer");
	}

	public function update(){
		$idCategoria = $this->input->post("idCategoria");
		$nombre = $this->input->post("nombre");
	
		$categoriaactual = $this->Categorias_model->getCategoria($idCategoria);//Recibir la informacion de la Categoria Antes que se Actualize

		if ($nombre == $categoriaactual->nombre) {//Obtener la informacion de cierto campo
			$is_unique = "";//saber si se va a realizar la validacion
		}else{
			$is_unique = "|is_unique[categorias.nombre]";//Si se haga la validacion

		}


		$this->form_validation->set_rules("nombre","Nombre","required".$is_unique);
		if ($this->form_validation->run()==TRUE) {
			$data = array(
				'nombre' => $nombre, 
			);

			if ($this->Categorias_model->update($idCategoria,$data)) {
				redirect(base_url()."almacen/categorias");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."almacen/categorias/edit/".$idCategoria);
			}
		}else{
			$this->edit($idCategoria);
		}

		
	}

	public function view($id){
		$data  = array(
			'categoria' => $this->Categorias_model->getCategoria($id), 
		);
		$this->load->view("admin/categorias/view",$data);
	}

	public function delete($id){
		$data  = array(
			'estado' => "0", 
		);
		$this->Categorias_model->update($id,$data);
		redirect(base_url()."almacen/categorias");
		//echo "almacen/categorias";
	}

	public function restore($id){
		$data  = array(
			'estado' => "1", 
		);
		$this->Categorias_model->update($id,$data);
		redirect(base_url()."almacen/categorias");
		//echo "almacen/categorias";
	}
}
