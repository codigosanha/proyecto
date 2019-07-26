<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends CI_Model {

	public function getUsuarios(){
		$this->db->select("u.*,e.nombre,e.apellido");
		$this->db->from("usuarios u");
		$this->db->join("empleados e","u.empleado_id = e.id");
		$this->db->where("e.sucursal_id",$this->session->userdata("sucursal_id"));
		$resultado = $this->db->get();
		return $resultado->result();//Devolver conjunto de varios registros
	}

//Retornar un usuario especifico
	public function getUsuario($id){
		$this->db->select("u.*,e.nombre,e.apellido");
		$this->db->from("usuarios u");
		$this->db->join("empleados e","u.empleado_id = e.id");
		$this->db->where("u.id",$id);
		$resultado = $this->db->get();//Antes de cualquier retorno de datos
		return $resultado->row();//metodo row q Devuelve un solo registro
	}

	public function save($data){
		return $this->db->insert("usuarios",$data);//Se esta registrando en la tabla
		//Retorna un valor booleano si es TRUE es que se ha insertado y si es 0 es que no se ha insertado la informacion
	}
	public function update($id,$data){//Recibe los parametros id del registro y la data son los valores para los campos
		$this->db->where("id",$id);//Para actualizar un solo registro
		return $this->db->update("usuarios",$data);//Nombre de la tabla y la informacion de dicha tabla, update BOOLEAN TRUE or FALSE
	}

	public function login($username, $password){
		$this->db->where("username", $username);
		$this->db->where("password", $password);
		$this->db->where("estado", 1);
		$resultados = $this->db->get("usuarios");//resultados la informacion de la consulta
		if ($resultados->num_rows() > 0) {//Numero de registros que haya coincidido con la consulta
			return $resultados->row();//row devuelve un solo registro
		}
		else{
			return false;//Si no hay registros en la consulta
		}
	}

	public function getSucursal($id){
		$this->db->select("e.sucursal_id");
		$this->db->from("usuarios u");
		$this->db->join("empleados e", "e.id = u.empleado_id");
		$this->db->where("u.id",$id);
		$resultados = $this->db->get();
		return $resultados->row();
	}	

	public function verificarExistencia($id){

		$this->db->where("empleado_id",$id);
		$resultados = $this->db->get("usuarios");
		if ($resultados->num_rows() > 0) {
			return true;
		}
		return false;
	}
}
