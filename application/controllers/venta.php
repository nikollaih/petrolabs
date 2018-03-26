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
		$this->load->view('lista_ProductosVendidos',$datos);
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

	function liquidar($incentivo=0, $islero=0, $estacion=0, $ciudad=0, $departamento=0){
		//isLogin();
		$ventas = $this->ventas->obtenerVentasLiquidar($incentivo, $islero, $estacion, $ciudad, $departamento);
		$ventasLiquidadas = array();
		if ($ventas != 0) {
			foreach ($ventas as $venta) {
				$datos['fecha_pago'] = date('Y-m-d');
				if($this->ventas->modificarVenta($datos, $venta['id_venta'])){
					array_push($ventasLiquidadas, $venta);
				}
			}
		}
		//responder($ventasLiquidadas, true, 'Ventas liquidadas correctamente');
		
	}
}