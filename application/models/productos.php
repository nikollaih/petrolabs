<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * author: Nikollai Hernandez
 */

class Productos extends CI_Model{

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function agregarProducto($producto){
		$this->db->insert('productos', $producto);
		return $this->db->insert_id();
	}

	function obtenerProductos(){
		$this->db->from('productos');
		$objProductos = $this->db->get();
		if ($objProductos->num_rows() > 0) {
			return $objProductos->result_array();
		}
		else{
			return 0;
		}
	}

	function obtenerProductoId($id_producto){
		$this->db->from('productos');
		$this->db->where('id_producto', $id_producto);
		$objProducto = $this->db->get();
		if ($objProducto->num_rows() > 0) {
			return $objProducto->row_array();
		}
		else{
			return 0;
		}
	}

	function modificarProducto($id_producto, $producto){
		$this->db->where('id_producto', $id_producto);
		return $this->db->update('productos', $producto);
	}
}