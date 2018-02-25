<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ubicaciones extends CI_Model{

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	/**
	 * [obtenerCiudades description]
	 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
	 * @return [type] [description]
	 */
	function obtenerCiudades(){
		$this->db->from('ciudades c');
		$this->db->join('departamentos d', 'c.departamento = d.id_departamento');
		$this->db->order_by('nombre_ciudad', 'asc');

		$objCiudades = $this->db->get();

		if ($objCiudades->num_rows() > 0) {
			return $objCiudades->result_array();
		}
		else{
			return 0;
		}
	}

	/**
	 * [obtenerCiudades description]
	 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
	 * @return [type] [description]
	 */
	function obtenerDepartamentos(){
		$this->db->from('departamentos c');
		$this->db->order_by('nombre_departamento', 'asc');

		$objDepartamento = $this->db->get();

		if ($objDepartamento->num_rows() > 0) {
			return $objDepartamento->result_array();
		}
		else{
			return 0;
		}
	}

	/**
	 * [obtenerCiudades description]
	 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
	 * @return [type] [description]
	 */
	function obtenerCiudadesDepartamento($id_departamento){
		$this->db->from('ciudades c');
		$this->db->join('departamentos d', 'c.departamento = d.id_departamento');
		$this->db->where('c.departamento', $id_departamento);
		$this->db->order_by('nombre_ciudad', 'asc');

		$objCiudades = $this->db->get();

		if ($objCiudades->num_rows() > 0) {
			return $objCiudades->result_array();
		}
		else{
			return 0;
		}
	}
}