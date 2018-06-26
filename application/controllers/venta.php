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
		}else if ($tipo=='Ciudad') {
			$ventas = $this->ventas->obtenerVentasLiquidar($incentivo, 0, 0, $codigo, 0, 0);
		}else if ($tipo=='Estacion') {
			$ventas = $this->ventas->obtenerVentasLiquidar($incentivo, 0, $codigo, 0, 0, 0);
		}else if ($tipo=='Islero') {
			$ventas = $this->ventas->obtenerVentasLiquidar($incentivo, $codigo, 0, 0, 0, 0);
		}else if ($tipo=='Asesor') {
			$ventas = $this->ventas->obtenerVentasLiquidar($incentivo, 0, 0, 0, 0, $codigo);
		}
		$ventasLiquidadas = array();
		if ($ventas != 0) {
			foreach ($ventas as $venta) {
				$datos['fecha_pago'] = date('Y-m-d');
				if($this->ventas->modificarVenta($datos, $venta['id_venta'])){
					array_push($ventasLiquidadas, $venta);
				}
			}
		}
		if (count($ventasLiquidadas)!=0) {
			responder($ventasLiquidadas, true, 'Ventas liquidadas correctamente');	
		}else{
			responder(0, false, 'Error liquidando');
		}
		
		
	}
}