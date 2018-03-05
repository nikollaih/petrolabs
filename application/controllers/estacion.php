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
	 * [index description]
	 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
	 * @return [type] [description]
	 */
	function index(){
		//Valida que la peticion se haga desde un dispositivo que se encuentre logueado en el sistema
		isLogin();

		$data['departamentos'] = $this->ubicaciones->obtenerDepartamentos();
		$this->load->view('lista_estaciones', $data);
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

	function estacionesPorDepartamento($id_departamento){
		//Valida que la peticion se haga desde un dispositivo que se encuentre logueado en el sistema
		isLogin();

		$objEstaciones = $this->estaciones->obtenerEstacionesDepartamento($id_departamento);

		responder($objEstaciones, true, 'Lista estaciones');
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

	/**
	 * [obtener description]
	 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
	 * @param  [type] $idEstacion [description]
	 * @return [type]             [description]
	 */
	function obtener($idEstacion){
		//Valida que la peticion se haga desde un dispositivo que se encuentre logueado en el sistema
		isLogin();

		$data['estacion'] = $this->estaciones->obtenerEstacioneId($idEstacion);
		$data['departamentos'] = $this->ubicaciones->obtenerDepartamentos();

		$this->load->view('ver_estacion', $data);
	}

	/**
	 * [modificar description]
	 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
	 * @param  [type] $idEstacion [description]
	 * @return [type]             [description]
	 */
	function modificar($idEstacion){
		//Valida que la peticion se haga desde un dispositivo que se encuentre logueado en el sistema
		isLogin();
		$temp_estacion = $this->input->post();
		$estacion =  $this->estaciones->obtenerEstacioneId($idEstacion);

		if ($estacion != 0) {
			if ($this->estaciones->modificarEstacion($estacion['id_estacion'], $temp_estacion['info'])) {
				if (!empty(trim($temp_estacion['asesor']))) {
					if ($this->estaciones->desasociarEstacionAsesor($estacion['id_estacion'], $temp_estacion['asesor'])){
						$data['usuario'] = $temp_estacion['asesor'];
						$data['estacion'] = $estacion['id_estacion'];
						$this->estaciones->asociarEstacionAsesor($data);
					}
				}

				$info = ['success', 'Exito', 'Estacion modificada exitosamente'];
				$this->session->set_flashdata('info', $info);
			}
		}
		else{
			$temp_estacion['info']['id_estacion'] = 'null';
			$estacion = $this->estaciones->agregarEstacion($temp_estacion['info']);
			if ($estacion != 0) {
				if (!empty(trim($temp_estacion['asesor']))) {
					$data['usuario'] = $temp_estacion['asesor'];
					$data['estacion'] = $estacion['id_estacion'];
					$this->estaciones->asociarEstacionAsesor($data);
				}

				$info = ['success', 'Exito', 'Estacion agregada exitosamente'];
				$this->session->set_flashdata('info', $info);
			}
			else{
				$info = ['warning', 'Error', 'Ha ocurrido un error, intente d enuevo más tarde'];
				$this->session->set_flashdata('info', $info);
			}
		}

		redirect(base_url().'estacion/obtener/'.$estacion['id_estacion'].'/'.stringToUrl($estacion['nombre_estaciones']));		
	}

	/**
	 * [eliminarEstacion description]
	 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
	 * @return [type] [description]
	 */
	function eliminarEstacion(){
		//Valida que la peticion se haga desde un dispositivo que se encuentre logueado en el sistema
		isLogin();

		if ($this->estaciones->obtenerEstacioneId($this->input->post('estacion')) != 0){
			if ($this->estaciones->modificarEstacion($this->input->post('estacion'), $this->input->post('info'))) {
				responder(0, true, 'Estado cambiado correctamente');
			}
			else{
				responder(0, false, 'Ha ocurrido un error al intentar cambiar el estado de la estacion');
			}
		}
		else{
			responder(0, false, 'No se ha encontrado la estación');
		}
	}
}