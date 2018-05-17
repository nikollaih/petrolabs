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
		$this->load->model('ubicaciones');
		$this->load->model('estaciones');
		$this->load->model('incentivos');
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

	/**
	 * Carga la lista de usuarios dependiendo del rol recibido
	 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
	 * @param  [int] $rol Recibe el identificador del rol que se desea cargar
	 * @return [type]      [description]
	 */
	function lista($rol, $nombre_rol = 'administrador'){
		isLogin();
		if ($rol < 3) {
			permisos(array(1));
		}

		$data['usuarios'] = $this->usuarios->obtenerUsuariosRol($rol);
		$data['rol'] = $rol;
		$data['nombre_rol'] = $nombre_rol;

		$this->load->view('lista_usuarios', $data);
	}

	/**
	 * [obtener description]
	 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
	 * @param  [type] $id_usuario [description]
	 * @return [type]             [description]
	 */
	function obtener($id_usuario, $rol = 1){
		isLogin();
		if ($rol < 3) {
			permisos(array(1));
		}

		$data['usuario'] = $this->usuarios->obtenerUsuario($id_usuario);
		$data['departamentos'] = $this->ubicaciones->obtenerDepartamentos();
		$data['incentivos'] = $this->incentivos->obtenerIncentivos();
		$data['rol'] = $rol;

		$this->load->view('ver_usuario', $data);
	}

	function perfil($id_usuario){
		isLogin();

		if ($id_usuario != $this->session->userdata('id_usuario')) {
			redirect(base_url().'usuario/perfil/'.$this->session->userdata('id_usuario').'/'.stringToUrl($this->session->userdata('nombre').' '.$this->session->userdata('apellidos')));
		}

		$data['usuario'] = $this->usuarios->obtenerUsuario($id_usuario);
		$data['departamentos'] = $this->ubicaciones->obtenerDepartamentos();
		$data['incentivos'] = $this->incentivos->obtenerIncentivos();
		$data['rol'] = $data['usuario']['id_rol'];
		$data['titulo'] = 'Perfil '.$data['usuario']['nombre'].' '.$data['usuario']['apellidos'];
		$data['perfil'] = true;

		$this->load->view('ver_usuario', $data);
	}

	/**
	 * [modificar description]
	 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
	 * @param  [type] $id_usuario [description]
	 * @return [type]             [description]
	 */
	function modificar($id_usuario){
		isLogin();

		$info = $this->input->post('info');

		if (isset($_POST['dptos'])) {
			$info['dptos'] = serialize($_POST['dptos']);
		}

		if ($this->input->post('info')) {
			$islero = 0;

			if (isset($this->input->post('islero')['estacion'])) {
				$islero = $this->input->post('islero');	
			}
			if ($this->usuarios->obtenerUsuario($this->input->post('id_usuario')) != 0) {
				$datos = $info;
				if (!empty($this->input->post('pass')['nueva'])) {
					$datos['clave'] = md5($this->input->post('pass')['nueva']);
				}
				if ($this->usuarios->modificarUsuario($this->input->post('id_usuario'), $datos, $islero) != 0){
					$info = ['success', 'Exito', 'Usuario modificado exitosamente'];
					$this->session->set_flashdata('info', $info);
				}
				else{
					$info = ['warning', 'Aviso', 'Ha ocurrido un error al intentar modificar el usuario'];
					$this->session->set_flashdata('info', $info);
				}
			}
			else{
				$info_usuario = $info;
				$info_usuario['clave'] = md5($info_usuario['cedula']);
				$id_usuario = $this->usuarios->agregarUsuario($info_usuario, $islero);

				if ($id_usuario){
					$info = ['success', 'Exito', 'Usuario creado exitosamente'];
					$this->session->set_flashdata('info', $info);
				}
				else{
					$info = ['warning', 'Aviso', 'Ha ocurrido un error al intentar crear el usuario'];
					$this->session->set_flashdata('info', $info);
				}
			}

			$usuario = $this->usuarios->obtenerUsuario($id_usuario);

			if (isset($_FILES['rut']) && !empty($_FILES['rut']['tmp_name']) && $usuario['rol'] == 3) {
				$dir_subida = 'uploads/rut/';
				$type_file = explode('/', $_FILES['rut']['type'])[1];
				$file_name = 'rut_'. $id_usuario.'_'.time();
				$full_path = $dir_subida . $file_name . '.' . $type_file;

				if (move_uploaded_file($_FILES['rut']['tmp_name'], $full_path)) {
					if (file_exists($dir_subida.$usuario['rut']) && !empty(trim($usuario['rut']))) {
						unlink($dir_subida.$usuario['rut']);
					}

					$datos['rut'] = $file_name.'.'.$type_file;
					$this->usuarios->modificarUsuario($id_usuario, null, $datos);
				}
			}

		}

		redirect(base_url().'usuario/lista/'.$usuario['rol'].'/'.$usuario['nombre_rol']);
	}

	/**
	 * [asesorEstaciones description]
	 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
	 * @param  [type] $id_asesor [description]
	 * @return [type]            [description]
	 */
	function asesorEstaciones($id_asesor){
		isLogin();

		$data['usuario'] = $this->usuarios->obtenerUsuario($id_asesor);
		$data['estaciones_usuario'] = $this->estaciones->estacionesUsuario($id_asesor);
		$data['estaciones'] = $this->estaciones->obtenerEstacionesDepartamento($data['usuario']['departamento']);

		$this->load->view('asesor_estaciones', $data);
	}

	/**
	 * [modificarPerfilApp description]
	 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
	 * @return [type] [description]
	 */
	function modificarPerfilApp(){
		//Valida que la peticion se haga desde un dispositivo que se encuentre logueado en el sistema
		isLoginApp($this->input->post('token'), $this->input->post('id_usuario'));
		$info = serializeToArray($this->input->post('info'));

		if ($this->input->post('info')) {
			$usuario = $this->usuarios->obtenerUsuario($this->input->post('id_usuario'));
			if ($usuario != 0) {
				if (!empty(trim($info['clave']))) {
					$info['clave'] = md5($info['clave']);
				}
				else{
					$info['clave'] = $usuario['clave'];
				}

				$usuario = $this->usuarios->modificarUsuario($this->input->post('id_usuario'), $info, null);
				if ($usuario != 0){
					responder($usuario, true, 'Usuario modificado');
				}
				else{
					responder(0, false, 'Ha ocurrido un error');
				}
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
	 * [islerosPorEstacion description]
	 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
	 * @param  [type] $id_estacion [description]
	 * @return [type]              [description]
	 */
	function islerosPorEstacion($id_estacion){
		isLogin();
		$isleros = $this->usuarios->obtenerIslerosPorEstacion($id_estacion);
		responder($isleros, true, 'Lista isleros');
	}

	/**
	 * [usuariosPorDepartamento description]
	 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
	 * @return [type] [description]
	 */
	function usuariosPorDepartamento(){
		//Valida que la peticion se haga desde un dispositivo que se encuentre logueado en el sistema
		isLogin();

		$usuarios = $this->usuarios->obtenerAsesorPorDepartamento($this->input->post('id_departamento'), $this->input->post('id_rol'));
 
		responder($usuarios, true, 'Lista usuarios');
	}

	/**
	 * [eliminarUsuario description]
	 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
	 * @param  [type] $idUsuario [description]
	 * @return [type]            [description]
	 */
	function eliminarUsuario($idUsuario){+
		//Valida que la peticion se haga desde un dispositivo que se encuentre logueado en el sistema
		isLogin();

		$data['estado'] = 2;
		$this->usuarios->modificarUsuario($idUsuario, $data, null);
		responder(0, true, 'Usuario eliminado');
	}

	/**
	 * [logout description]
	 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
	 * @return [type] [description]
	 */
	function logout(){
		$info['token'] = '';
		$this->usuarios->modificarUsuario($this->session->userdata('id_usuario'), $info, null);
		$this->session->sess_destroy();
		redirect(base_url().'auth');
	}
}