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
		permisos(array(1, 2));
		$datos['departamentos'] = $this->ubicaciones->obtenerDepartamentos();
		$datos['asesores'] = $this->usuarios->obtenerUsuariosRol(2);
		$datos['comisiones'] = [];
		$comisiones = $this->comisiones->obtenerComisionesGeneral(1);
		if ($datos['asesores'] != 0) {
			foreach ($datos['asesores'] as $asesor) {
				$efectivo = 0;
				$exito = 0;
				$catalogo = 0;
				if ($comisiones != 0) {
					foreach ($comisiones as $comision) {
						foreach (unserialize($asesor['dptos']) as $id) {
							if ($comision['id'] == $id) {
								switch ($comision['id_incentivo']) {
									case '1':
										$efectivo += $comision['comision'];
										break;
									case '2':
										$exito += $comision['comision'];
										break;
									case '3':
										$catalogo += $comision['comision'];
										break;
									
									default:

										break;
								}
							}
						}
					}
				}
				if ($efectivo > 0) {
					$data['id'] = $asesor['id_usuario'];
					$data['nombre'] = $asesor['nombre'].' '.$asesor['apellidos'];
					$data['incentivo'] = 'Efectivo';
					$data['id_incentivo'] = 1;
					$data['comision'] = $efectivo;
					array_push($datos['comisiones'], $data);
				}

				if ($exito > 0) {
					$data['id'] = $asesor['id_usuario'];
					$data['nombre'] = $asesor['nombre'].' '.$asesor['apellidos'];
					$data['incentivo'] = 'Exito';
					$data['id_incentivo'] = 2;
					$data['comision'] = $exito;
					array_push($datos['comisiones'], $data);
				}

				if ($catalogo > 0) {
					$data['id'] = $asesor['id_usuario'];
					$data['nombre'] = $asesor['nombre'].' '.$asesor['apellidos'];
					$data['incentivo'] = 'Catalogo de los deseos';
					$data['id_incentivo'] = 3;
					$data['comision'] = $catalogo;
					array_push($datos['comisiones'], $data);
				}
			}
		}
		$this->load->view('liquidar_comisiones',$datos);
	}

	function liquidadas(){
		isLogin();
		permisos(array(1, 2));
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
			$datos['comisiones'] = $this->comisiones->obtenerComisionesFiltro($fechaInicial,$fechaFinal,0,0,$codigo,$estado,0);
		}
		if ($tipo == 'Ciudad') {
			$datos['comisiones'] = $this->comisiones->obtenerComisionesFiltro($fechaInicial,$fechaFinal,0,$codigo,0,$estado,0);
		}
		if ($tipo == 'Departamento') {
			$datos['comisiones'] = $this->comisiones->obtenerComisionesFiltro($fechaInicial,$fechaFinal,$codigo,0,0,$estado,0);
		}
		if ($tipo == 'Asesor') {
			$datos['comisiones'] = $this->comisiones->obtenerComisionesFiltro($fechaInicial,$fechaFinal,0,0,0,$estado,$codigo);
		}
		responder($datos['comisiones'], true, 'Estacion asosiada al asesor');
	}
}