<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * author: Nikollai Hernandez
 */

class Incentivos extends CI_Model{

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function agregarIncentivo($incentivo){
		$this->db->insert('tipos_incentivo', $incentivo);
		return $this->db->last_id();
	}

	function obtenerIncentivos(){
		$this->db->from('tipos_incentivo');
		$objIncentivos = $this->db->get();

		if ($objIncentivos->num_rows() > 0) {
			return $objIncentivos->result_array();
		}
		else{
			return 0;
		}
	}

	function modificarIncentivo($id_incentivo, $incentivos){
		$this->db->where('id_tipo', $id_incentivo);
		return $this->db->update('tipos_incentivos¡');
	}

	function eliminarIncentivo($id_incentivo){
		$this->db->where('id_tipo', $id_tipo);
		return $this->db->delete('tipos_incentivo');
	}
}