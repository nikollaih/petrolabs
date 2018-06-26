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

	function obtenerVentasFiltro($departamento, $ciudad, $estacion, $islero){
		$this->db->select('p.id_producto, p.foto, p.nombre_producto, SUM(v.cantidad) cantidad, SUM(v.cantidad*v.precio) total, SUM(v.comision_total) comision_total');
		$this->db->from('ventas v');
		$this->db->join('productos p', 'p.id_producto = v.producto');
		$this->db->join('Isleros i', 'i.id_islero = v.islero','LEFT');
		$this->db->join('estaciones e', 'e.id_estacion = i.estacion', 'LEFT');
		$this->db->join('ciudades c','c.id_ciudad = e.ciudad','LEFT');
		$this->db->join('departamentos d', 'd.id_departamento = c.departamento', 'LEFT');
		$where = array();
		if ($departamento != 0) {
			$where[0] = 'd.id_departamento';
			$where[1] = $departamento;
		}
		if ($ciudad != 0) {
			$where[0] = 'c.id_ciudad';
			$where[1] = $ciudad;
		}
		if ($estacion != 0) {
			$where[0] = 'e.id_estacion';
			$where[1] = $estacion;
		}
		if ($islero != 0) {
			$where[0] = 'i.id_islero';
			$where[1] = $islero;
		}
		if (!empty($where)) {
			$this->db->where($where[0], $where[1]);
		}
		$this->db->group_by('p.id_producto');

		$ventas = $this->db->get();

		if ($ventas->num_rows() > 0) {
			return $ventas->result_array();
		}
		else{
			return 0;
		}
	}

	function comisionAsesor($idAsesor){
		$dptos = unserialize($this->obtenerUsuario($idAsesor)['dptos']);
		$this->db->select('SUM(v.comision_total) as comision');
		$this->db->from('ventas v');
		$this->db->join('Isleros i', 'v.islero = i.id_islero');
		$this->db->join('usuarios u', 'u.id_usuario = i.id_islero');
		$this->db->join('ciudades c','c.id_ciudad = u.ciudad');
		$this->db->join('departamentos d', 'd.id_departamento = c.departamento');
		$this->db->where_in('d.id_departamento', $dptos);
		$this->db->where('v.fecha_pago', '0000-00-00 00:00:00');
		$objVentas = $this->db->get();

		if ($objVentas->num_rows() > 0) {
			return $objVentas->row_array();
		}
		else{
			return 0;
		}
	}

	function obtenerVentas(){
		$this->db->from('ventas v');
		$this->db->join('Isleros i', 'v.islero = i.id_islero');
		$this->db->join('productos p', 'v.producto = p.id_producto');
		$objVentas = $this->db->get();

		if ($objVentas->num_rows() > 0) {
			return $objVentas->result_array();
		}
		else{
			return 0;
		}
	}

	function obtenerVentasLiquidar($incentivo=0, $islero=0, $estacion=0, $ciudad=0, $departamento=0, $id_asesor = 0){
		if ($id_asesor) {
			$this->db->select('dptos');
			$this->db->from('usuarios');
			$this->db->where('id_usuario', $id_asesor);
			$resultado = $this->db->get();
			$dptosIds = unserialize($resultado->row_array()['dptos']);
		}
		$this->db->select('v.id_venta');
		$this->db->from('ventas v');
		$this->db->join('Isleros i', 'i.id_islero = v.islero');
		$whereCampo = '';
		$whereValor = '';

		if ($islero != 0) {
			$whereCampo = 'i.id_islero';
			$whereValor = $islero;
		}
		if ($estacion != 0) {
			$whereCampo = 'i.estacion';
			$whereValor = $estacion;
		}
		if ($ciudad != 0) {
			$this->db->join('estaciones e', 'e.id_estacion = i.estacion');
			$whereCampo = 'e.ciudad';
			$whereValor = $ciudad;
		}
		if ($departamento != 0) {
			$this->db->join('estaciones e', 'e.id_estacion = i.estacion');
			$this->db->join('ciudades c', 'c.id_ciudad = e.ciudad');
			$whereCampo = 'c.departamento';
			$whereValor = $departamento;
		}
		if ($id_asesor != 0) {
			$this->db->join('estaciones e', 'e.id_estacion = i.estacion');
			$this->db->join('ciudades c', 'c.id_ciudad = e.ciudad');
			$this->db->join('departamentos d', 'c.departamento = d.id_departamento');
		}
		$this->db->where('v.fecha_pago', 0);
		if ($incentivo != 0) {
			$this->db->where('i.tipo_incentivo', $incentivo);
		}
		if ($whereCampo != '' && $whereValor != '') {
			$this->db->where($whereCampo, $whereValor);	
		}
		else{
			if ($id_asesor) {
				$this->db->where_in('d.id_departamento', $dptosIds);
			}
		}

		$ventas = $this->db->get();
		
		if ($ventas->num_rows() > 0) {
			return $ventas->result_array();
		}
		else{
			return 0;
		}
	}

	function modificarVenta($venta, $id_venta){
		$this->db->where('id_venta', $id_venta);
		return $this->db->update('ventas', $venta);
	}

	function obtenerVentaId($id_venta){
		$this->db->from('ventas v');
		$this->db->join('Isleros i', 'v.islero = i.id_islero');
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
		$this->db->join('Isleros i', 'v.islero = i.id_islero');
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
		$this->db->join('Isleros i', 'v.islero = i.id_islero');
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
		$this->db->select('v.id_venta, p.id_producto, p.foto, p.nombre_producto, SUM(v.cantidad) as cantidad, SUM(v.comision_total) as comision_total');
		$this->db->from('ventas v');
		$this->db->join('Isleros i', 'v.islero = i.id_islero');
		$this->db->join('productos p', 'v.producto = p.id_producto');
		$this->db->where('v.islero', $id_islero);
		$this->db->where('fecha >=', $fecha_inicial);
		$this->db->where('fecha <=', $fecha_final);
		$this->db->group_by('v.producto');
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
		$this->db->join('Isleros i', 'v.islero = i.id_islero');
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

	function obtenerUsuario($id_usuario){
		$this->db->from('usuarios u');
		$this->db->join('Isleros i', 'u.id_usuario = i.usuario', 'left');
		$this->db->join('ciudades c', 'u.ciudad = c.id_ciudad');
		$this->db->join('departamentos d', 'd.id_departamento = c.departamento');
		$this->db->join('estaciones e', 'e.id_estacion = i.estacion', 'left');
		$this->db->join('tipos_incentivo ti', 'ti.id_tipo = i.tipo_incentivo', 'left');
		$this->db->join('roles r', 'r.id_rol = u.rol');
		$this->db->where('u.id_usuario', $id_usuario);

		$objUsuario = $this->db->get();

		if ($objUsuario->num_rows() > 0) {
			return $objUsuario->row_array();
		}
		else{
			return 0;
		}
	}

	function obtenerVentasIsleroFechaPago($fecha_inicial, $fecha_final, $id_islero){
		$this->db->from('ventas v');
		$this->db->join('Isleros i', 'v.islero = i.id_islero');
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
		$this->db->join('Isleros i', 'v.islero = i.id_islero');
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
		$this->db->join('Isleros i', 'v.islero = i.id_islero');
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
		$this->db->join('Isleros i', 'v.islero = i.id_islero');
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
		$this->db->join('Isleros i', 'v.islero = i.id_islero');
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