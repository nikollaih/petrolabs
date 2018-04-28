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
		$this->db->join('tipos_incentivo ti', 'ti.id_tipo = i.tipo_incentivo', 'left');
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

	function obtenerUsuariosRol($id_rol){
		$this->db->from('usuarios u');
		$this->db->join('Isleros i', 'u.id_usuario = i.usuario', 'left');
		$this->db->join('ciudades c', 'u.ciudad = c.id_ciudad');
		$this->db->join('departamentos d', 'd.id_departamento = c.departamento');
		$this->db->join('estaciones e', 'e.id_estacion = i.estacion', 'left');
		$this->db->where('u.rol', $id_rol);

		$objUsuario = $this->db->get();

		if ($objUsuario->num_rows() > 0) {
			return $objUsuario->result_array();
		}
		else{
			return 0;
		}
	}

	function agregarUsuario($usuario, $islero){
		$this->db->insert('usuarios', $usuario);
		$id_usuario = $this->db->insert_id();

		if ($islero != null && $islero != false) {
			$islero['usuario'] = $id_usuario;
			$this->db->insert('Isleros', $islero);

		}

		return $id_usuario;
	}

	function validarTokenId($token, $id_usuario){
		$this->db->from('usuarios');
		$this->db->where('token', $token);
		$this->db->where('id_usuario', $id_usuario);

		$objUsuario = $this->db->get();

		if ($objUsuario->num_rows() > 0) {
			return true;
		}
		else{
			return false;
		}
	}

	function modificarUsuario($id_usuario, $usuario, $islero){
		if ($usuario != null && $usuario) {
			$this->db->where('id_usuario', $id_usuario);
			$this->db->update('usuarios', $usuario);
		}

		if ($islero != null && $islero) {
			$this->db->where('usuario', $id_usuario);
			$this->db->update('Isleros', $islero);
		}

		return $this->obtenerUsuario($id_usuario);
	}

	/**
	 * [obtenerUsuario description]
	 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
	 * @param  [type] $id_usuario [description]
	 * @return [type]             [description]
	 */
	function obtenerUsuario($id_usuario){
		$this->db->from('usuarios u');
		$this->db->join('Isleros i', 'u.id_usuario = i.usuario', 'left');
		$this->db->join('ciudades c', 'u.ciudad = c.id_ciudad');
		$this->db->join('departamentos d', 'd.id_departamento = c.departamento');
		$this->db->join('estaciones e', 'e.id_estacion = i.estacion', 'left');
		$this->db->join('tipos_incentivo ti', 'ti.id_tipo = i.tipo_incentivo', 'left');
		$this->db->join('roles r', 'r.id_rol = u.rol');
		$this->db->where('u.id_usuario', $id_usuario);

		$objUsuario = $this->db->get();

		if ($objUsuario->num_rows() > 0) {
			return $objUsuario->row_array();
		}
		else{
			return 0;
		}
	}

	/**
	 * [obtenerUsuarioEmail description]
	 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
	 * @param  [type] $email [description]
	 * @return [type]        [description]
	 */
	function obtenerUsuarioEmail($email){
		$this->db->from('usuarios u');
		$this->db->join('Isleros i', 'u.id_usuario = i.usuario', 'left');
		$this->db->join('ciudades c', 'u.ciudad = c.id_ciudad');
		$this->db->join('departamentos d', 'd.id_departamento = c.departamento');
		$this->db->join('estaciones e', 'e.id_estacion = i.estacion', 'left');
		$this->db->join('tipos_incentivo ti', 'ti.id_tipo = i.tipo_incentivo', 'left');
		$this->db->join('roles r', 'r.id_rol = u.rol');
		$this->db->where('u.email', $email);

		$objUsuario = $this->db->get();

		if ($objUsuario->num_rows() > 0) {
			return $objUsuario->row_array();
		}
		else{
			return 0;
		}
	}

	/**
	 * [obtenerIslerosPorEstacion description]
	 * @author German Donoso <germanedt@gmail.com>
	 * @param  [type] $id_Estacion [description]
	 * @return [type]        [description]
	 */
	function obtenerIslerosPorEstacion($id_estacion){
		$this->db->from('usuarios u');
		$this->db->join('Isleros i', 'u.id_usuario = i.usuario');
		$this->db->where('i.estacion', $id_estacion);

		$usuarios = $this->db->get();

		if ($usuarios->num_rows() > 0) {
			return $usuarios->result_array();
		}
		else{
			return 0;
		}
	}

	/**
	 * [obtenerUsuarioDepartamento description]
	 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
	 * @param  [type]  $depto [description]
	 * @param  integer $rol   [description]
	 * @return [type]         [description]
	 */
	function obtenerUsuarioDepartamento($depto, $rol=1){
		$this->db->from('usuarios u');
		$this->db->join('Isleros i', 'u.id_usuario = i.usuario', 'left');
		$this->db->join('ciudades c', 'u.ciudad = c.id_ciudad');
		$this->db->join('departamentos d', 'd.id_departamento = c.departamento');
		$this->db->join('estaciones e', 'e.id_estacion = i.estacion', 'left');
		$this->db->join('tipos_incentivo ti', 'ti.id_tipo = i.tipo_incentivo', 'left');
		$this->db->join('roles r', 'r.id_rol = u.rol');
		$this->db->where('d.id_departamento', $depto);
		$this->db->where('r.id_rol', $rol);

		$objUsuario = $this->db->get();

		if ($objUsuario->num_rows() > 0) {
			return $objUsuario->result_array();
		}
		else{
			return 0;
		}
	}


	/**
	 * [obtenerAsesorPorDepartamento description]
	 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
	 * @param  [type]  $depto [description]
	 * @param  integer $rol   [description]
	 * @return [type]         [description]
	 */
	function obtenerAsesorPorDepartamento($depto, $rol=1){
		$this->db->from('usuarios u');
		$this->db->join('Isleros i', 'u.id_usuario = i.usuario', 'left');
		$this->db->join('ciudades c', 'u.ciudad = c.id_ciudad');
		$this->db->join('departamentos d', 'd.id_departamento = c.departamento');
		$this->db->join('estaciones e', 'e.id_estacion = i.estacion', 'left');
		$this->db->join('tipos_incentivo ti', 'ti.id_tipo = i.tipo_incentivo', 'left');
		$this->db->join('roles r', 'r.id_rol = u.rol');
		$this->db->like('u.dptos', 's:'.strlen($depto).':"'.$depto.'";');
		$this->db->where('r.id_rol', $rol);

		$objUsuario = $this->db->get();

		if ($objUsuario->num_rows() > 0) {
			return $objUsuario->result_array();
		}
		else{
			return 0;
		}
	}

}