<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}

	function index(){
		$this->load->view('login');
	}

	function login(){
		$this->load->view('login');
	}
}