<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ubicacion extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('funciones');
		$this->load->model('ubicaciones');
		$this->load->model('usuarios');
	}

	/**
	 * [ciudadesPorDepartamento description]
	 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
	 * @param  [type] $id_departamento [description]
	 * @return [type]                  [description]
	 */
	function ciudadesPorDepartamento($id_departamento){
		isLogin();

		$objCiudades = $this->ubicaciones->obtenerCiudadesDepartamento($id_departamento);
		responder($objCiudades, true, 'Lista ciudades');
	}

	/**
	 * [departamentosAsesor description]
	 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
	 * @param  [type] $asesor [description]
	 * @return [type]         [description]
	 */
	function departamentosAsesor($asesor){
		isLogin();

		$asesor = $this->usuarios->obtenerUsuario($asesor);
		$objDepartamentos = $this->ubicaciones->obtenerDepartamentosPorId(unserialize($asesor['dptos']));
		responder($objDepartamentos, true, 'Lista departamentos');
	}
}