<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('funciones');
		$this->load->model('usuarios');
		$this->load->model('myemail');
	}

	function index(){ 
		if ($this->usuarios->validarTokenId($this->session->userdata("token"), $this->session->userdata("id_usuario"))){
			redirect(base_url().'producto');
		}
		else{
			$this->load->view('login');
		}
	}

	function login(){
		$email = $this->input->post('correo');
		$password = $this->input->post('clave');

		$usuario = $this->usuarios->validarUsuario($email, $password);
		
		if ($usuario) {
			$data['token'] = generarToken();
			$datosUsuario = $this->usuarios->modificarUsuario($usuario['id_usuario'], $data, null);
			if ($datosUsuario) {
				$datosUsuario['clave'] = $password;
				$this->session->set_userdata($datosUsuario);
				responder($datosUsuario, true, 'Ingreso exitoso');
			}else{
				responder(0, false, 'Ingreso fallo');
			}
		}
		else{
			responder(0, false, 'Ingreso fallo');
		}
	}

	/**
	 * ---------------------------------------------------
	 * Metodos para la app movil
	 * ---------------------------------------------------
	 */

	/**
	 * [loginApp description]
	 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
	 * @return [type] [description]
	 */
	function loginApp(){
		$email = $this->input->post('correo');
		$password = $this->input->post('clave');

		$usuario = $this->usuarios->validarUsuario($email, $password);
		
		if ($usuario) {
			$data['token'] = generarToken();
			$datosUsuario = $this->usuarios->modificarUsuario($usuario['id_usuario'], $data, null);
			if ($datosUsuario) {
				responder($datosUsuario, true, 'Datos usuario');
			}
			else{
				responder(0, false, 'Acceso denegado');
			}
		}
		else{
			responder(0, false, 'Acceso denegado');
		}
	}

	/**
	 * [logoutApp description]
	 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
	 * @return [type] [description]
	 */
	function logoutApp(){
		//Valida que la peticion se haga desde un dispositivo que se encuentre logueado en el sistema
		isLoginApp($this->input->post('token'), $this->input->post('id_usuario'));

		$data['token'] = '';
		$datosUsuario = $this->usuarios->modificarUsuario($this->input->post('id_usuario'), $data, null);

		responder(0, true, 'Cerrar sesion');
	}

	/**
	 * [recuperarContrasenia description]
	 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
	 * @return [type] [description]
	 */
	function recuperarContrasenia(){
		if (($this->input->post('token_app') && $this->input->post('token_app') == 'P3TR0L4B5-T') && $this->input->post('correo')) {
			$usuario = $this->usuarios->obtenerUsuarioEmail($this->input->post('correo'));
			if ($usuario != 0) {
				$contrasenia = generarContrasenia();
				$datos['clave'] = md5($contrasenia);
				if ($this->myemail->recuperarContrasenia($this->input->post('correo'), $contrasenia)){
					$this->usuarios->modificarUsuario($usuario['id_usuario'], $datos, null);
					responder($contrasenia, true, 'Mensaje enviado');
				}
				else{
					responder($contrasenia, false, 'Ha ocurrido un error al intentar enviar el correo');
				}
			}
			else{
				responder(0, false, 'No se ha encontrado un usuario con el email especificado');
			}
		}
		else{
			responder(0, false, 'Acceso denegado');
		}
	}

	function forgotPassword(){
		if ($this->usuarios->validarTokenId($this->session->userdata("token"), $this->session->userdata("id_usuario"))){
			redirect(base_url().'producto');
		}
		else{
			$this->load->view('recuperar_contrasenia');
		}
	}
}