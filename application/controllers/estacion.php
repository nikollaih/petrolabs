<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estacion extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('funciones');
		$this->load->model('estaciones');
	}

	
	/**
	 * Metodos para la app movil
	 */
	
	function estacionesPorCiudad($id_ciudad){
		//Valida que la peticion se haga desde un dispositivo que se encuentre logueado en el sistema
		isLogin();

		$objEstaciones = $this->estaciones->obtenerEstacionesCiudad($id_ciudad);

		responder($objEstaciones, true, 'Lista estaciones');
	}
}