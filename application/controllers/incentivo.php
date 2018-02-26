<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Incentivo extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('funciones');
		$this->load->model('incentivos');
	}

	
	/**
	 * Metodos para la app movil
	 */
	
	function obtenerIncentivosApp(){
		//Valida que la peticion se haga desde un dispositivo que se encuentre logueado en el sistema
		isLoginApp($this->input->post('token'), $this->input->post('id_usuario'));

		$objIncentivos = $this->incentivos->obtenerIncentivos();

		responder($objIncentivos, true, 'Tipos incentivo');
	}

	function actualizarIncentivoIsleroApp(){
		//Valida que la peticion se haga desde un dispositivo que se encuentre logueado en el sistema
		isLoginApp($this->input->post('token'), $this->input->post('id_usuario'));

		$islero['tipo_incentivo'] = $this->input->post('incentivo');

		if ($this->usuarios->modificarUsuario($this->input->post('id_usuario'), null, $islero)) {
			responder(0, true, 'Tipo incentivo cambiado correctamente');
		}
		else{
			responder(0, false, 'No se ha podido cambiar el incentivo');
		}
	}
}