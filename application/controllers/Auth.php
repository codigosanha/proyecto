<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	//private $modulo = "Usuarios";
	public function __construct(){
		parent::__construct();
		$this->load->model("Usuarios_model");//Referencia a la clase Auth $this-->
		$this->load->model("Sucursales_model");
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
			$data['id'] = $res->id;
			$data['username'] = $res->username;
			$data['rol'] = $res->rol;
			$data['login'] = TRUE;
			if ($res->rol != 1) {
				$infoUsuario = $this->Usuarios_model->getSucursal($res->id);
				$infoSucursal = $this->Sucursales_model->getSucursal($infoUsuario->sucursal_id);
				$data['sucursal_id'] = $infoUsuario->sucursal_id;
				$data['sucursal_name'] = $infoSucursal->nombre;
			}

			//colocar las rutas
			
			$this->session->set_userdata($data);
			//$this->backend_lib->savelog($this->modulo,"Inicio de sesión");
			//redirect(base_url()."dashboard");
			//echo "1";//exito en la comprobacion de los datos del usuario
			switch ($res->rol) {
				case '1':
					echo "dashboard";
					break;
				case '2':
					echo "movimientos/pedidos";
					break;
				case '3':
					echo "movimientos/compras";
					break;
				
				default:
					echo "movimientos/ventas";
					break;
			}
		}
	}

	public function logout(){
		//$this->backend_lib->savelog($this->modulo,"Cierre de sesión");
		$this->session->sess_destroy();
		redirect(base_url());
	}
}
