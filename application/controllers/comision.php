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
		$datos['comisiones'] = $this->comisiones->obtenerComisionesGeneral(1);
		$this->load->view('liquidar_comisiones',$datos);
	}

	function liquidadas(){
		isLogin();
		$datos['departamentos'] = $this->ubicaciones->obtenerDepartamentos();
		$datos['comisiones'] = $this->comisiones->obtenerComisionesGeneral(0);
		$this->load->view('comisiones_liquidadas',$datos);
	}

	function filtro($tipo, $codigo, $estado=1){
		isLogin();
		$datos['departamentos'] = $this->ubicaciones->obtenerDepartamentos();
		$fechaInicial = $this->input->post('inicio');
		$fechaFinal = $this->input->post('fin');
		if ($tipo == 'Estacion') {
			$datos['comisiones'] = $this->comisiones->obtenerComisionesFiltro($fechaInicial,$fechaFinal,0,0,$codigo,$estado);
		}
		if ($tipo == 'Ciudad') {
			$datos['comisiones'] = $this->comisiones->obtenerComisionesFiltro($fechaInicial,$fechaFinal,0,$codigo,0,$estado);
		}
		if ($tipo == 'Departamento') {
			$datos['comisiones'] = $this->comisiones->obtenerComisionesFiltro($fechaInicial,$fechaFinal,$codigo,0,0,$estado);
		}
		responder($datos['comisiones'], true, 'Estacion asosiada al asesor');
	}
}