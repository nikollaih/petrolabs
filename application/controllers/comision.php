<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comision extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('funciones');
		$this->load->model('ventas');
		$this->load->model('productos');
		$this->load->model('ubicaciones');
	}

	function index(){
		isLogin();
		$datos['departamentos'] = $this->ubicaciones->obtenerDepartamentos();
		$this->load->view('liquidar_comisiones',$datos);
	}
}