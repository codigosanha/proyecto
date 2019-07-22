<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	//private $modulo = "Usuarios";
	public function __construct(){
		parent::__construct();
		$this->load->model("Usuarios_model");//Referencia a la clase Auth $this-->
	}
	public function index()
	{
		if ($this->session->userdata("login")) {//Si existe la variable de sesion/cookie
			redirect(base_url()."dashboard");//redirecciona al dashboard
		}
		else{
			$this->load->view("admin/login");
		}
		

	}

	public function login(){
		$username = $this->input->post("username");//Recibiendo
		$password = $this->input->post("password");//Recibiendo
		$res = $this->Usuarios_model->login($username, sha1($password));

		if (!$res) {
			/*$this->session->set_flashdata("error","El usuario y/o contraseña son incorrectos");*/
			//redirect(base_url());
			echo "0";//error en la comprobacion de los datos del usuario
		}
		else{
			$data  = array(
				//variables de sesion
				'id' => $res->id, 
				'username' => $res->username,
				'rol' => $res->rol,
				'login' => TRUE
			);
			$this->session->set_userdata($data);
			//$this->backend_lib->savelog($this->modulo,"Inicio de sesión");
			//redirect(base_url()."dashboard");
			echo "1";//exito en la comprobacion de los datos del usuario
		}
	}

	public function logout(){
		//$this->backend_lib->savelog($this->modulo,"Cierre de sesión");
		$this->session->sess_destroy();
		redirect(base_url());
	}
}
