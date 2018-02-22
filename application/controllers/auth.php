<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('funciones');
	}

	function index(){
		$this->load->view('login');
	}

	function login(){
		$this->load->model('usuarios');

		$email = $this->input->post('correo');
		$password = $this->input->post('clave');

		$usuario = $this->usuarios->validarUsuario($email, $password);
		
		if ($usuario) {
			$data['token'] = generarToken();
			$datosUsuario = $this->usuarios->modificarUsuario($usuario['id_usuario'], $data, null);
			if ($datosUsuario) {
				$this->session->set_userdata($datosUsuario);
				redirect('panel');
			}
		}
	}

	function loginApp(){
		$this->load->model('usuarios');

		$email = $this->input->post('correo');
		$password = $this->input->post('clave');

		$usuario = $this->usuarios->validarUsuario($email, $password);
		
		if ($usuario) {
			$data['token'] = generarToken();
			$datosUsuario = $this->usuarios->modificarUsuario($usuario['id_usuario'], $data, null);
			if ($datosUsuario) {
				responder($datosUsuario, true, 'Datos usuario');
			}
		}
	}
}