<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facturas extends CI_Model{

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

/**
 * [agregar description]
 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
 * @param  [type] $data [description]
 * @return [type]       [description]
 */
	function agregar($data){
		$this->db->insert('facturas', $data);
		return $this->db->insert_id();
	}

/**
 * [obtenerFacturaId description]
 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
	function obtenerFacturaId($id){
		$this->db->from('facturas f');
		$this->db->join('usuarios u', 'f.id_usuario = u.id_usuario');
		$this->db->where('f.id_factura', $id);
		$this->db->order_by('f.fecha', 'desc');

		$factura = $this->db->get();

		if ($factura->num_rows() > 0) {
			return $factura->row_array();
		}
		else{
			return 0;
		}
	}

/**
 * [obtenerFacturas description]
 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
 * @param  integer $id_asesor     [description]
 * @param  integer $fecha_inicial [description]
 * @param  integer $fecha_final   [description]
 * @return [type]                 [description]
 */
	function obtenerFacturas($id_asesor = 0, $fecha_inicial = 0, $fecha_final = 0){
		$this->db->from('facturas f');
		$this->db->join('usuarios u', 'f.id_usuario = u.id_usuario');

		if ($id_asesor != 0) {
			$this->db->where('f.id_usuario', $id_asesor);
		}
		if ($fecha_inicial != 0) {
			$this->db->where('f.fecha >=', $fecha_inicial);
		}
		if ($fecha_final != 0) {
			$this->db->where('f.fecha <=', $fecha_final);
		}

		$this->db->order_by('f.fecha', 'desc');
		$factura = $this->db->get();

		if ($factura->num_rows() > 0) {
			return $factura->result_array();
		}
		else{
			return 0;
		}
	}
}