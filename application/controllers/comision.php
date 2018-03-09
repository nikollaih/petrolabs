<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comision extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('funciones');
		$this->load->model('ubicaciones');
		$this->load->model('comisiones');
	}

	function index(){
		isLogin();
		$datos['departamentos'] = $this->ubicaciones->obtenerDepartamentos();
		$datos['comisiones'] = $this->comisiones->obtenerComisionesGeneral();
		$this->load->view('liquidar_comisiones',$datos);
	}

	function filtro($tipo, $codigo){
		isLogin();
		$datos['departamentos'] = $this->ubicaciones->obtenerDepartamentos();
		if ($tipo == 'Estacion') {
			$datos['comisiones'] = $this->comisiones->obtenerComisionesFiltro(date('Y-m-d'),date('Y-m-d'),0,0,$codigo);
		}
		if ($tipo == 'Ciudad') {
			$datos['comisiones'] = $this->comisiones->obtenerComisionesFiltro(date('Y-m-d'),date('Y-m-d'),0,$codigo,0);
		}
		if ($tipo == 'Departamento') {
			$datos['comisiones'] = $this->comisiones->obtenerComisionesFiltro(date('Y-m-d'),date('Y-m-d'),$codigo,0,0);
		}
		$this->load->view('liquidar_comisiones',$datos);
	}
}