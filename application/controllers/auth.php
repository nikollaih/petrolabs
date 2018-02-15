<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('ajustes');
		$this->load->library('session');
	}

	function editar(){
		if ($this->session->userdata('id_usuario')) {
			if ($this->input->post('info')) {
				$info = $this->input->post('info');

				$this->ajustes->modifyConfig($info);

			}

			$data['config'] = $this->ajustes->getConfig();
			$this->load->view('panel/config_site', $data);
		}
		else{
			redirect('panel');
		}
	}
}