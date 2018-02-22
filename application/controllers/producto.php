<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Producto extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('productos');
	}

	/*
	* author German Donoso
	* method index, Metodo que carga la vista de lista de productos del panel web
	*/
	function index(){
		isLogin();
		$data['productos'] = $this->productos->obtenerProductos();
		//$this->load->view('lista_productos', $data);
		print_r($data);
	}

	/*
	* author German Donoso
	* method listarProductos, Metodo que carga la lista de productos para la app
	* return lista de productos en formato JSON
	*/
	function listarProductos(){
		isLogin();
		$data['productos'] = $this->productos->obtenerProductos();

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
			$idProducto = $this->producto->agregarProduto($this->input->post('producto'));
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
		$producto = $this->producto->obtenerProdutoId($idProducto);
		if ($producto != 0) {
			responder($producto, true, 'Producto obtenido');
		}else{
			responder(0, false, 'Error obteniendo producto');
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
		if ($this->input->post('producto')) {
			$idProductoModif = $this->producto->modificarProduto($this->input->post('producto'));
			if ($idProductoModif) {
				responder($idProducto, true, 'Producto modificado');
			}else{
				responder(0, false, 'Error modificando el producto');
			}
		}
	}
}