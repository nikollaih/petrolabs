<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * author: Nikollai Hernandez
 */

class Estaciones extends CI_Model{

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function agregarEstacion($estacion){
		$this->db->insert('estaciones', $estacion);
		return $this->obtenerEstacioneId($this->db->insert_id());
	}

	function obtenerEstaciones(){
		$this->db->from('estaciones e');
		$this->db->join('ciudades c', 'e.ciudad = c.id_ciudad');
		$this->db->join('departamentos d', 'd.id_departamento = c.departamento');
		$this->db->join('estaciones_asesor ea', 'e.id_estacion = ea.estacion', 'left');
		$this->db->where('e.estado', 1);
		$objEstaciones = $this->db->get();

		if ($objEstaciones->num_rows() > 0) {
			return $objEstaciones->result_array();
		}else{
			return 0;
		}
	}

	function obtenerEstacionesCiudad($id_ciudad){
		$this->db->from('estaciones e');
		$this->db->join('ciudades c', 'e.ciudad = c.id_ciudad');
		$this->db->join('departamentos d', 'd.id_departamento = c.departamento');
		$this->db->join('estaciones_asesor ea', 'e.id_estacion = ea.estacion', 'left');
		$this->db->join('usuarios u', 'ea.usuario = u.id_usuario', 'left');
		$this->db->where('e.ciudad', $id_ciudad);
		$this->db->where('e.estado', 1);
		$objEstaciones = $this->db->get();

		if ($objEstaciones->num_rows() > 0) {
			return $objEstaciones->result_array();
		}else{
			return 0;
		}
	}

	function obtenerEstacionesDepartamento($id_departamento){
		$this->db->from('estaciones e');
		$this->db->join('ciudades c', 'e.ciudad = c.id_ciudad');
		$this->db->join('departamentos d', 'd.id_departamento = c.departamento');
		$this->db->join('estaciones_asesor ea', 'e.id_estacion = ea.estacion', 'left');
		$this->db->join('usuarios u', 'ea.usuario = u.id_usuario', 'left');
		$this->db->where('d.id_departamento', $id_departamento);
		$this->db->where('e.estado', 1);
		$objEstaciones = $this->db->get();

		if ($objEstaciones->num_rows() > 0) {
			return $objEstaciones->result_array();
		}else{
			return 0;
		}
	}

	function obtenerEstacioneId($id_estacion){
		$this->db->from('estaciones e');
		$this->db->join('ciudades c', 'e.ciudad = c.id_ciudad');
		$this->db->join('departamentos d', 'd.id_departamento = c.departamento');
		$this->db->join('estaciones_asesor ea', 'e.id_estacion = ea.estacion', 'left');
		$this->db->where('id_estacion', $id_estacion);
		$this->db->where('e.estado', 1);
		$objEstacion = $this->db->get();

		if ($objEstacion->num_rows() > 0) {
			return $objEstacion->row_array();
		}else{
			return 0;
		}
	}

	function modificarEstacion($id_estacion, $estacion){
		$this->db->where('id_estacion', $id_estacion);
		return $this->db->update('estaciones', $estacion);
	}

	function asignarEstacionAsesor($estacion_asesor){
		return $this->db->insert('estaciones_asesor', $estaciones_asesor);
	}

	function eliminarEstacion($id_estacion){
		$this->db->where('id_estacion', $id_estacion);
		return $this->db->delete('estaciones');
	}

	function eliminarEstacionAsesor($id_estacion, $id_asesor){
		$this->db->where('id_estacion', $id_estacion);
		$this->db->where('id_asesor', $id_asesor);
		return $this->db->delete('estaciones');
	}

	/**
	 * [estacionesUsuario description]
	 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
	 * @param  [type] $id_usuario [description]
	 * @return [type]             [description]
	 */
	function estacionesUsuario($id_usuario){
		$this->db->from('estaciones e');
		$this->db->join('ciudades c', 'e.ciudad = c.id_ciudad');
		$this->db->join('departamentos d', 'd.id_departamento = c.departamento');
		$this->db->join('estaciones_asesor ea', 'e.id_estacion = ea.estacion');
		$this->db->where('ea.usuario', $id_usuario);
		$this->db->where('e.estado', 1);
		$objEstaciones = $this->db->get();

		if ($objEstaciones->num_rows() > 0) {
			return $objEstaciones->result_array();
		}else{
			return 0;
		}
	}

	/**
	 * [asociarEstacionAsesor description]
	 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
	 * @param  [type] $datos [description]
	 * @return [type]        [description]
	 */
	function asociarEstacionAsesor($datos){
		$this->db->insert('estaciones_asesor', $datos);
		return $this->db->insert_id();
	}

	/**
	 * [desasociarEstacionAsesor description]
	 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
	 * @param  [type] $estacion [description]
	 * @param  [type] $asesor   [description]
	 * @return [type]           [description]
	 */
	function desasociarEstacionAsesor($estacion, $asesor){
		$this->db->where('usuario', $asesor);
		$this->db->where('estacion', $estacion);
		return $this->db->delete('estaciones_asesor');
	}

	/**
	 * [validarEstacionAsesor description]
	 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
	 * @param  [type] $estacion [description]
	 * @param  [type] $asesor   [description]
	 * @return [type]           [description]
	 */
	function validarEstacionAsesor($estacion, $asesor){
		$this->db->from('estaciones_asesor');
		$this->db->where('estacion', $estacion);
		$this->db->where('usuario', $asesor);

		$objEstacion = $this->db->get();

		if ($objEstacion->num_rows() > 0) {
			return true;
		}
		else{
			return false;
		}
	}
}