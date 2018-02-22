<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * author: Nikollai Hernandez
 */

class Usuarios extends CI_Model{

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function validarUsuario($email, $password){

		$this->db->from('usuarios u');
		$this->db->join('roles r', 'r.id_rol = u.rol');
		$this->db->join('ciudades c', 'c.id_ciudad = u.ciudad');
		$this->db->join('Isleros i', 'i.usuario = u.id_usuario', 'left');
		$this->db->join('estaciones e', 'e.id_estacion = i.estacion', 'left');
		$this->db->join('tipos_incentivos ti', 'ti.id_tipo = i.incentivo', 'left');
		$this->db->where('u.email', $email);
		$this->db->where('u.clave', md5($password));
		$this->db->where('u.estado', 1);

		$result = $this->db->get();

		if ($result->num_rows() > 0) {
			return $result->row_array();
		}
		else{
			return false;
		}
	}
}