<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Venta extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('funciones');
		$this->load->model('ventas');
		$this->load->model('productos');
		$this->load->model('ubicaciones');
		$this->load->model('usuarios');
		$this->load->model('facturas');
	}

	function index(){
		isLogin();
		$datos['ventas'] = $this->ventas->obtenerVentasFiltro(0, 0, 0, 0);
		$datos['departamentos'] = $this->ubicaciones->obtenerDepartamentos();
		$this->load->view('lista_productosVendidos',$datos);
	}

	function filtro($tipo, $dato){
		isLogin();
		$departamento = 0;
		$ciudad = 0;
		$estacion = 0;
		$islero = 0;
		if ($tipo == 'Departamento') {
			$departamento = $dato;
		}elseif ($tipo == 'Ciudad') {
			$ciudad = $dato;
		}elseif ($tipo == 'Estacion') {
			$estacion = $dato;
		}elseif ($tipo == 'Islero') {
			$islero = $dato;
		}
		$ventas = $this->ventas->obtenerVentasFiltro($departamento, $ciudad, $estacion, $islero);
		responder($ventas, true, 'Ventas filtradas');
	}

	function agregar(){
		//Valida que la peticion se haga desde un dispositivo que se encuentre logueado en el sistema
		isLoginApp($this->input->post('token'), $this->input->post('id_usuario'));

		$venta['islero'] = $this->input->post('islero');
		$venta['producto'] = $this->input->post('producto');
		$venta['fecha'] = $this->input->post('fecha');
		$venta['cantidad'] = $this->input->post('cantidad');
		$objProducto = $this->productos->obtenerProductoId($venta['producto']);
		$venta['precio'] = $objProducto['precio'];
		$venta['comision_total'] = $venta['cantidad'] * $objProducto['comision'];

		$objVenta = $this->ventas->agregarVenta($venta);

		if ($objVenta) {
			responder($objVenta, true, 'Venta creada exitosamente');
		}
		else{
			responder(0, false, 'Error al intentar registrar la venta');
		}
	}

	function liquidar($incentivo=0, $tipo, $codigo){
		//isLogin();
		$ventas = 0;
		if ($tipo=='Departamento') {
			$ventas = $this->ventas->obtenerVentasLiquidar($incentivo, 0, 0, 0, $codigo, 0);
			$asesores = $this->usuarios->obtenerAsesorLiquidacion($codigo);
		}else if ($tipo=='Ciudad') {
			$ventas = $this->ventas->obtenerVentasLiquidar($incentivo, 0, 0, $codigo, 0, 0);
			$asesores = $this->usuarios->obtenerAsesorLiquidacion(0, $codigo);
		}else if ($tipo=='Estacion') {
			$ventas = $this->ventas->obtenerVentasLiquidar($incentivo, 0, $codigo, 0, 0, 0);
			$asesores = $this->usuarios->obtenerAsesorLiquidacion(0, 0, $codigo);
		}else if ($tipo=='Islero') {
			$ventas = $this->ventas->obtenerVentasLiquidar($incentivo, $codigo, 0, 0, 0, 0);
			$asesores = $this->usuarios->obtenerAsesorLiquidacion(0,0,0,$codigo);
		}else if ($tipo=='Asesor') {
			$ventas = $this->ventas->obtenerVentasLiquidar($incentivo, 0, 0, 0, 0, $codigo);
			$asesores[0] = array('id_usuario' => $codigo);
		}
		$ventasLiquidadas = array();
		if ($ventas != 0) {
			foreach ($ventas as $venta) {
				$datos['fecha_pago'] = date('Y-m-d');
				if($this->ventas->modificarVenta($datos, $venta['id_venta'])){
					array_push($ventasLiquidadas, $venta);
				}
			}

			$this->agregarFactura($asesores, $ventasLiquidadas, $incentivo);
		}
		if (count($ventasLiquidadas)!=0) {
			responder($ventasLiquidadas, true, 'Ventas liquidadas correctamente');	
		}else{
			responder(0, false, 'Error liquidando');
		}
		
		
	}


	function agregarFactura($asesores, $ventas, $incentivo){
		$ventas_ids = [];
		if (count($ventas) > 0 && count($asesores) > 0) {
			foreach ($ventas as $v) {
				array_push($ventas_ids, $v['id_venta']);
			}

			$ventas = $this->ventas->obtenerVentasIds($ventas_ids, true)[0]['valor'] * 0.02;

			$data['incentivo'] = $incentivo;
			$data['tipo'] = 'Pago';
			$data['fecha'] = date('Y-m-d');
			$data['fecha_visual'] = date('F d, Y', strtotime(date('Y-m-d')));
			$data['valor'] = $ventas;
			$data['concepto'] = 'Pago Comisiones';
			foreach ($asesores as $a) {
				$data['id_usuario'] = $a['id_usuario'];
				$this->facturas->agregar($data);
			}

		}
	}
}