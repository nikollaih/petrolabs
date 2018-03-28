<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comisiones extends CI_Model{

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	/**
	 * [obtenerComisionesGeneral description]
	 * @author German Donoso <germanedt@gmail.com>
	 * @return [type] [description]
	 */
	function obtenerComisionesGeneral($estadoComision){
		$incentivos = $this->obtenerTiposIncentivos();
		$fechaInicial = date('Y').'-01-01';
		$ventas = array();
		if ($incentivos != 0) {
			foreach ($incentivos as $incentivo) {
				$this->db->select('d.id_departamento id, d.nombre_departamento nombre, SUM(IFNULL(V.comision_total,0)) comision');
				$this->db->from('ventas v');
				$this->db->join('Isleros i', 'i.id_islero = v.islero','RIGHT');
				$this->db->join('estaciones e', 'e.id_estacion = i.estacion','RIGHT');
				$this->db->join('ciudades c', 'c.id_ciudad = e.ciudad','RIGHT');
				$this->db->join('departamentos d', 'd.id_departamento = c.departamento','RIGHT');
				$this->db->where('i.tipo_incentivo', $incentivo['id_tipo']);
				if ($estadoComision) {
					$this->db->where('v.fecha_pago', 0);
				}
				$this->db->where('v.fecha >=', $fechaInicial);
				$this->db->where('v.fecha <=', date('Y-m-d'));
				$this->db->group_by('d.id_departamento');
				$this->db->order_by('nombre', 'asc');

				$comisiones = $this->db->get();
				$resultado = $comisiones->result_array();
				$datos = array();
				if ($comisiones->num_rows() > 0) {
					foreach ($resultado as $comision) {
						$datos['id'] = $comision['id'];
						$datos['nombre'] = $comision['nombre'];
						$datos['incentivo'] = $incentivo['descripcion'];
						$datos['id_incentivo'] = $incentivo['id_tipo'];
						$datos['comision'] = $comision['comision'];
						array_push($ventas, $datos);
					}
				}
			}
			if (empty($ventas)) {
				return 0;
			}else{
				return $ventas;
			}

		}else{
			return 0;
		}
	}
	/**
	 * [obtenerComisionesFiltro description]
	 * @author German Donoso <germanedt@gmail.com>
	 * @return [type] [description]
	--SELECT c.id_ciudad id, c.nombre_ciudad nombre, SUM(IFNULL(v.comision_total,0)) comision 
	--FROM ventas v 
	--RIGHT JOIN Isleros i ON i.id_islero = v.islero 
	--RIGHT JOIN estaciones e ON e.id_estacion = i.estacion
	--RIGHT JOIN ciudades c ON c.id_ciudad = e.ciudad
	--WHERE v.fecha_pago = 0
	--AND c.departamento = 1
	--GROUP BY c.id_ciudad
	 */
	function obtenerComisionesFiltro($fechaInicial, $fechaFinal, $departamento = 0, $ciudad = 0, $estacion = 0, $estado){
		$incentivos = $this->obtenerTiposIncentivos();
		$ventas = array();
		if ($incentivos != 0) {
			foreach ($incentivos as $incentivo) {
				$this->db->from('ventas v');
				$this->db->join('Isleros i', 'i.id_islero = v.islero', 'RIGHT');
				$group = '';
				if ($estacion != 0) {
					$this->db->select('i.id_islero id, CONCAT(u.nombre," ",u.apellidos) nombre, SUM(IFNULL(v.comision_total,0)) comision');
					$this->db->join('usuarios u', 'u.id_usuario = i.usuario');
					$this->db->where('i.estacion', $estacion);
					$group = 'i.id_islero'; 
				}
				if ($ciudad != 0) {
					$this->db->select('e.id_estacion id, e.nombre_estaciones nombre, SUM(IFNULL(v.comision_total,0)) comision');
					$this->db->join('estaciones e', 'e.id_estacion = i.estacion', 'RIGHT');
					$this->db->where('e.ciudad', $ciudad);
					$group = 'e.id_estacion'; 
				}
				if ($departamento) {
					$this->db->select('c.id_ciudad id, c.nombre_ciudad nombre, SUM(IFNULL(v.comision_total,0)) comision');
					$this->db->join('estaciones e', 'e.id_estacion = i.estacion', 'RIGHT');
					$this->db->join('ciudades c', 'c.id_ciudad = e.ciudad', 'RIGHT');
					$this->db->where('c.departamento', $departamento);
					$group = 'c.id_ciudad'; 
				}
				$this->db->where('i.tipo_incentivo', $incentivo['id_tipo']);
				if ($estado) {
					$this->db->where('v.fecha_pago', 0);
				}
				$this->db->where('v.fecha >=', $fechaInicial);
				$this->db->where('v.fecha <=', $fechaFinal);
				$this->db->group_by($group);

				$comisiones = $this->db->get();
				$resultado = $comisiones->result_array();
				$datos = array();
				if ($comisiones->num_rows() > 0) {
					foreach ($resultado as $comision) {
						$datos['id'] = $comision['id'];
						$datos['nombre'] = $comision['nombre'];
						$datos['incentivo'] = $incentivo['descripcion'];
						$datos['id_incentivo'] = $incentivo['id_tipo'];
						$datos['comision'] = $comision['comision'];
						array_push($ventas, $datos);
					}
				}
			}
			if (empty($ventas)) {
				return 0;
			}else{
				return $ventas;
			}

		}else{
			return 0;
		}
	}
	function obtenerTiposIncentivos(){
		$this->db->from('tipos_incentivo');

		$result = $this->db->get();

		if ($result->num_rows() > 0) {
			return $result->result_array();
		}
		else{
			return 0;
		}
	}
}