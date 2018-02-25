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
	}

	function index(){
		isLogin();
		$this->load->view('lista_ProductosVendidos');
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
}