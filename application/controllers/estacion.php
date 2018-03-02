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
		$this->load->model('ubicaciones');
	}

	/**
	 * [asignarEstacionAsesor description]
	 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
	 * @return [type] [description]
	 */
	function asignarEstacionAsesor(){
		//Valida que la peticion se haga desde un dispositivo que se encuentre logueado en el sistema
		isLogin();

		$data['estacion'] = $this->input->post('estacion');
		$data['usuario'] = $this->input->post('asesor');

		if (!$this->estaciones->validarEstacionAsesor($data['estacion'], $data['usuario'])) {
			if ($this->estaciones->asociarEstacionAsesor($data)) {
				responder(0, true, 'Estacion asosiada al asesor');
			}
			else{
				responder(0, false, 'Ha ocurrido un error al intentar asociar la estacion al asesor');
			}
		}
		else{
			responder(0, false, 'La estacion ya se encuentra asociada al asesor');
		}
	}

	/**
	 * [desasignarEstacionAsesor description]
	 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
	 * @return [type] [description]
	 */
	function desasignarEstacionAsesor(){
		//Valida que la peticion se haga desde un dispositivo que se encuentre logueado en el sistema
		isLogin();

		$estacion = $this->input->post('estacion');
		$asesor = $this->input->post('asesor');

		if ($this->estaciones->desasociarEstacionAsesor($estacion, $asesor)) {
			responder(0, true, 'Estacion eliminada del asesor');
		}
		else{
			responder(0, false, 'Ha ocurrido un error al intentar eliminar la estacion del asesor');
		}
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


	function obtener($idEstacion){
		//Valida que la peticion se haga desde un dispositivo que se encuentre logueado en el sistema
		isLogin();

		$data['estacion'] = $this->estaciones->obtenerEstacioneId($idEstacion);
		//$data['departamentos'] = $this->ubicaciones->obtenerDepartamentos();



		$this->load->view('ver_estacion', $data);
	}
}