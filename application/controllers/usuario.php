<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('funciones');
		$this->load->model('usuarios');
	}

	/*
	* author German Donoso
	* method index, Metodo que carga la vista de lista de usuarios asesor del panel web
	*/
	function index(){
		isLogin();
		$data['usuarios'] = $this->usuarios->obtenerUsuariosRol(2);
		$data['rol'] = 2;
		//$this->load->view('lista_usuarios', $data);
		print_r($data);
	}

	/*
	* author German Donoso
	* method index, Metodo que carga la vista de lista de usuarios islero del panel web
	*/
	function isleros(){
		isLogin();
		$data['usuarios'] = $this->usuarios->obtenerUsuariosRol(3);
		$data['rol'] = 3;
		//$this->load->view('lista_usuarios', $data);
		print_r($data);
	}

	/*
	* author German Donoso
	* method agregar, Metodo que controla la insersión de usuario
	* param producto, arreglo de datos correspondientes a un usuario
	* return estado de la transacción, insertado o no el usuario
	*/
	function agregar(){
		isLogin();
		$idUsuario = 0;
		if ($this->input->post('usuario')) {
			if ($this->input->post('islero')) {
				$idUsuario = $this->usuarios->agregarUsuario($this->input->post('usuario'), $this->input->post('islero'));
			}else{
				$idUsuario = $this->usuarios->agregarUsuario($this->input->post('usuario'),null);
			}

			if ($idUsuario != 0) {
				responder($idUsuario, true, 'Usuario agregado');
			}else{
				responder(0, false, 'Error agregando el usuario');
			}
		}
	}
}