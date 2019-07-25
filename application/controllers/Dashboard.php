<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if (!$this->session->userdata("login")) {
			redirect(base_url());
		}
		$this->load->model("Sucursales_model");

	}
	public function index()
	{
		/*
		$data = array(
			"cantVentas" => $this->Backend_model->rowCount("ventas"),
			"cantUsuarios" => $this->Backend_model->rowCount("usuarios"),
			"cantClientes" => $this->Backend_model->rowCount("clientes"),
			"cantProductos" => $this->Backend_model->rowCount("productos"),
			'productoslast' => $this->Ventas_model->getLastProductos(),
			'productosmvendidos' => $this->Ventas_model->getProductosmasVendidos(),
				'pstockminimo' => $this->Ventas_model->getProductosStockMinimo(),
		);
*/
		if (!$this->session->userdata("sucursal_id")) {
			$this->viewSeleccion();
		}else{
			$this->load->view("layouts/header");
			$this->load->view("layouts/aside");
			$this->load->view("admin/dashboard");
			$this->load->view("layouts/footer");
		}
		

		//echo 'view/dashboard';
	}

	public function viewSeleccion(){
		$this->session->unset_userdata('sucursal_id');
		$this->session->unset_userdata('sucursal_name');
		$data =array(
			"sucursales" => $this->Sucursales_model->getSucursales()
		);
		$this->load->view("admin/sucursales/seleccion",$data);
	}

	public function setSucursal($idSucursal){
		$infoSucursal = $this->Sucursales_model->getSucursal($idSucursal);
		$data['sucursal_id'] = $idSucursal;
		$data['sucursal_name'] = $infoSucursal->nombre;
		$this->session->set_userdata($data);
		redirect(base_url()."dashboard");
	}



	/*public function getData(){
		$year = $this->input->post("year");
		$resultados = $this->Ventas_model->montosMeses($year);
		echo json_encode($resultados);
	}
*/
}
