<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * author: Nikollai Hernandez
 */

class Ventas extends CI_Model{

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function agregarVenta($venta){
		$this->db->insert('ventas', $venta);
		return $this->obtenerVentaId($this->db->insert_id());
	}

	function obtenerVentas(){
		$this->db->from('ventas v');
		$this->db->join('isleros i', 'v.islero = i.id_islero');
		$this->db->join('productos p', 'v.producto = p.id_producto');
		$objVentas = $this->db->get();

		if ($objVentas->num_rows() > 0) {
			return $objVentas->result_array();
		}
		else{
			return 0;
		}
	}

	function obtenerVentaId($id_venta){
		$this->db->from('ventas v');
		$this->db->join('isleros i', 'v.islero = i.id_islero');
		$this->db->join('productos p', 'v.producto = p.id_producto');
		$this->db->where('id_venta', $id_venta);
		$objVentas = $this->db->get();

		if ($objVentas->num_rows() > 0) {
			return $objVentas->result_array();
		}
		else{
			return 0;
		}
	}

	function obtenerVentasIslero($id_islero){
		$this->db->from('ventas v');
		$this->db->join('isleros i', 'v.islero = i.id_islero');
		$this->db->join('productos p', 'v.producto = p.id_producto');
		$this->db->where('v.islero', $id_islero);
		$objVentas = $this->db->get();

		if ($objVentas->num_rows() > 0) {
			return $objVentas->result_array();
		}
		else{
			return 0;
		}
	}

	function obtenerVentasFecha($fecha_inicial, $fecha_final){
		$this->db->from('ventas v');
		$this->db->join('isleros i', 'v.islero = i.id_islero');
		$this->db->join('productos p', 'v.producto = p.id_producto');
		$this->db->where('fecha >=', $fecha_inicial);
		$this->db->where('fecha <=', $fecha_final);
		$objVentas = $this->db->get();

		if ($objVentas->num_rows() > 0) {
			return $objVentas->result_array();
		}
		else{
			return 0;
		}
	}

	function obtenerVentasIsleroFecha($fecha_inicial, $fecha_final, $id_islero){
		$this->db->from('ventas v');
		$this->db->join('isleros i', 'v.islero = i.id_islero');
		$this->db->join('productos p', 'v.producto = p.id_producto');
		$this->db->where('v.islero', $id_islero);
		$this->db->where('fecha >=', $fecha_inicial);
		$this->db->where('fecha <=', $fecha_final);
		$objVentas = $this->db->get();

		if ($objVentas->num_rows() > 0) {
			return $objVentas->result_array();
		}
		else{
			return 0;
		}
	}

	function obtenerVentasFechaPago($fecha_inicial, $fecha_final){
		$this->db->from('ventas v');
		$this->db->join('isleros i', 'v.islero = i.id_islero');
		$this->db->join('productos p', 'v.producto = p.id_producto');
		$this->db->where('fecha_pago >=', $fecha_inicial);
		$this->db->where('fecha_pago <=', $fecha_final);
		$objVentas = $this->db->get();

		if ($objVentas->num_rows() > 0) {
			return $objVentas->result_array();
		}
		else{
			return 0;
		}
	}

	function obtenerVentasIsleroFechaPago($fecha_inicial, $fecha_final, $id_islero){
		$this->db->from('ventas v');
		$this->db->join('isleros i', 'v.islero = i.id_islero');
		$this->db->join('productos p', 'v.producto = p.id_producto');
		$this->db->where('v.islero', $id_islero);
		$this->db->where('fecha_pago >=', $fecha_inicial);
		$this->db->where('fecha_pago <=', $fecha_final);
		$objVentas = $this->db->get();

		if ($objVentas->num_rows() > 0) {
			return $objVentas->result_array();
		}
		else{
			return 0;
		}
	}

	function obtenerVentasPonderadoIsleroFechaPago($fecha_inicial, $fecha_final, $id_islero){
		$this->db->select('v.id_venta, p.id_producto, p.foto, p.nombre_producto, SUM(v.cantidad) as cantidad, SUM(v.comision_total) as comision_total');
		$this->db->from('ventas v');
		$this->db->join('isleros i', 'v.islero = i.id_islero');
		$this->db->join('productos p', 'v.producto = p.id_producto');
		$this->db->where('v.islero', $id_islero);
		$this->db->where('fecha_pago >=', $fecha_inicial);
		$this->db->where('fecha_pago <=', $fecha_final);
		$this->db->group_by('v.producto');
		$objVentas = $this->db->get();

		if ($objVentas->num_rows() > 0) {
			return $objVentas->result_array();
		}
		else{
			return 0;
		}
	}

	function obtenerVentasProducto($id_producto){
		$this->db->from('ventas v');
		$this->db->join('isleros i', 'v.islero = i.id_islero');
		$this->db->join('productos p', 'v.producto = p.id_producto');
		$this->db->where('v.producto', $id_producto);
		$objVentas = $this->db->get();

		if ($objVentas->num_rows() > 0) {
			return $objVentas->result_array();
		}
		else{
			return 0;
		}
	}

	function obtenerVentasProductoFecha($fecha_inicial, $fecha_final, $id_producto){
		$this->db->from('ventas v');
		$this->db->join('isleros i', 'v.islero = i.id_islero');
		$this->db->join('productos p', 'v.producto = p.id_producto');
		$this->db->where('fecha >=', $fecha_inicial);
		$this->db->where('fecha <=', $fecha_final);
		$this->db->where('v.producto', $id_producto);
		$objVentas = $this->db->get();

		if ($objVentas->num_rows() > 0) {
			return $objVentas->result_array();
		}
		else{
			return 0;
		}
	}

	function obtenerVentasProductoFechaPago($fecha_inicial, $fecha_final, $id_producto){
		$this->db->from('ventas v');
		$this->db->join('isleros i', 'v.islero = i.id_islero');
		$this->db->join('productos p', 'v.producto = p.id_producto');
		$this->db->where('fecha_pago >=', $fecha_inicial);
		$this->db->where('fecha_pago <=', $fecha_final);
		$this->db->where('v.producto', $id_producto);
		$objVentas = $this->db->get();

		if ($objVentas->num_rows() > 0) {
			return $objVentas->result_array();
		}
		else{
			return 0;
		}
	}

	function eliminarVenta($id_venta){
		$this->db->where('id_venta', $id_venta);
		return $this->db->delete('ventas');
	}
}