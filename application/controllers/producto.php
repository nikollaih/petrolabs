<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Producto extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('funciones');
		$this->load->model('productos');
		$this->load->model('ventas');
	}

	/*
	* author German Donoso
	* method index, Metodo que carga la vista de lista de productos del panel web
	*/
	function index(){
		isLogin();
		$data['productos'] = $this->productos->obtenerProductos();

		$this->load->view('lista_producto', $data);
	}

	/*
	* author German Donoso
	* method listarProductos, Metodo que carga la lista de productos para la app
	* return lista de productos en formato JSON
	*/
	function listarProductos(){
		isLogin();
		$data = $this->productos->obtenerProductos();

		responder($data, true, 'Lista de productos');
	}

	/*
	* author German Donoso
	* method agregar, Metodo que controla la insersión de productos
	* param producto, arreglo de datos correspondientes a un producto
	* return estado de la transacción, insertado o no el producto
	*/
	function agregar(){
		isLogin();
		if ($this->input->post('producto')) {
			$idProducto = $this->productos->agregarProducto($this->input->post('producto'));
			if ($idProducto != 0) {
				responder($idProducto, true, 'Producto agregado');
			}else{
				responder(0, false, 'Error agregando el producto');
			}
		}
	}

	/*
	* author German Donoso
	* method obtener, Metodo que obtiene un producto por id
	* param idProducto, id del producto que se desea obtener
	* return el producto si lo encuentra de lo contrario 0
	*/
	function obtener($idProducto){
		isLogin();
		permisos(array(1));
		if ($idProducto != 'nuevo') {
			$data['producto'] = $this->productos->obtenerProductoId($idProducto);
			if ($data['producto'] != 0) {
				$this->load->view('ver_producto', $data);
			}else{
				responder(0, false, 'Error obteniendo producto');
			}
		}else{
			$this->load->view('ver_producto');
		}
		
	}

	/*
	* author German Donoso
	* method modificar, Metodo que controla la modificación de productos
	* param producto, arreglo de datos correspondientes a un producto
			idProducto, id del producto que se esta modificando
	* return estado de la transacción, modificado o no el producto
	*/
	function modificar($idProducto){
		isLogin();
		if ($idProducto != -1) {
			if ($this->input->post('producto')) {
				$datos = $this->input->post('producto');
				if (isset($_FILES['imageProducto']) && !empty($_FILES['imageProducto']['tmp_name'])) {
					
					$dir_subida = 'uploads/productos/';
					$type_file = str_replace('image/', '', $_FILES['imageProducto']['type']);
					$file_name = 'producto_'.$idProducto.'_'.time();
					$full_path = $dir_subida.$file_name.'.'.$type_file;

					if (move_uploaded_file($_FILES['imageProducto']['tmp_name'], $full_path)) {
						$producto = $this->productos->obtenerProductoId($idProducto);
						if (file_exists($dir_subida.$producto['foto']) && !empty(trim($producto['foto']))) {
							unlink($dir_subida.$producto['foto']);
						}
						$datos['foto'] = $file_name.'.'.$type_file;
					}
				}
				$idProductoModif = $this->productos->modificarProducto($idProducto, $datos);
				if ($idProductoModif) {
					redirect(base_url().'producto');
				}else{
					responder(0, false, 'Error modificando el producto');
				}
			}
		}else{
			if ($this->input->post('producto')) {
				$info = $this->input->post('producto');
				$info['id_producto'] = 'null';
				$idProducto= $this->productos->agregarProducto($info);

				if (isset($_FILES['imageProducto']) && !empty($_FILES['imageProducto']['tmp_name'])) {
					
					$dir_subida = 'uploads/productos/';
					$type_file = str_replace('image/', '', $_FILES['imageProducto']['type']);
					$file_name = 'producto_'.$idProducto.'_'.time();
					$full_path = $dir_subida.$file_name.'.'.$type_file;

					if (move_uploaded_file($_FILES['imageProducto']['tmp_name'], $full_path)) {
						$datos['foto'] = $file_name.'.'.$type_file;
					}
				}
				$idProductoModif = $this->productos->modificarProducto($idProducto, $datos);
				if ($idProductoModif) {
					redirect(base_url().'producto');
				}else{
					responder(0, false, 'Error modificando el producto');
				}
			}
		}
		
	}

	function modificarEstado($idProducto){ 
		isLogin();

		if ($this->input->post('estado') !== '') {
			$datos['estado'] = $this->input->post('estado');
			$idProductoModif = $this->productos->modificarProducto($idProducto, $datos);
			if ($idProductoModif) {
				responder(0, true, 'Producto modificado');
			}else{
				responder(0, false, 'Error modificando el producto');
			}
		}
		else{
			responder(0, false, 'Error modificando el producto');
		}
	}
	/**
	 * ---------------------------------------------------
	 * Metodos para la app movil
	 * ---------------------------------------------------
	 */
	
	/*
	* @author: Nikollai Hernandez G. <nikollaihernandez@gmail.com>
	* method listarProductos, Metodo que carga la lista de productos para la app
	* return lista de productos en formato JSON
	*/
	function listarProductosApp(){
		//Valida que la peticion se haga desde un dispositivo que se encuentre logueado en el sistema
		isLoginApp($this->input->post('token'), $this->input->post('id_usuario'));

		$objProductos = $this->productos->obtenerProductos();

		responder($objProductos, true, 'Lista de productos');
	}

	function comisionesIsleroMes(){
		//Valida que la peticion se haga desde un dispositivo que se encuentre logueado en el sistema
		isLoginApp($this->input->post('token'), $this->input->post('id_usuario'));

		$id_islero = $this->input->post('islero');
		$mes = $this->input->post('mes');
		$anio = $this->input->post('anio');

		$fecha_inicio = $anio . '-' . $mes . '-01 00:00:00';
		$fecha_final = $anio . '-' . $mes . '-31 23:59:59';

		$objProductos = $this->ventas->obtenerVentasPonderadoIsleroFechaPago($fecha_inicio, $fecha_final, $id_islero);

		responder($objProductos, true, 'Productos comisiones');
	}

	function productosSinLiquidar(){
		//Valida que la peticion se haga desde un dispositivo que se encuentre logueado en el sistema
		isLoginApp($this->input->post('token'), $this->input->post('id_usuario'));

		$id_islero = $this->input->post('islero');

		$fecha = '0000-00-00 00:00:00';

		$objProductos = $this->ventas->obtenerVentasPonderadoIsleroFechaPago($fecha, $fecha, $id_islero);

		responder($objProductos, true, 'Productos comisiones');
	}

	function productosVendidosPorFecha(){
		//Valida que la peticion se haga desde un dispositivo que se encuentre logueado en el sistema
		isLoginApp($this->input->post('token'), $this->input->post('id_usuario'));
		$fecha = $this->input->post('fecha');
		$id_islero = $this->input->post('islero');

		$objProductos = $this->ventas->obtenerVentasIsleroFecha($fecha, $fecha, $id_islero);

		responder($objProductos, true, 'Productos comisiones');
	}
}