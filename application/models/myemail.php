<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Myemail extends CI_Model{

    function __construct()
    {        
        parent::__construct();
        $config = Array(
		    'protocol'  => 'smtp',
		    'smtp_host' => 'ssl://smtp.gmail.com',
		    'smtp_port' =>  465,
		    'smtp_user' => 'nikollaihernandezgamus@gmail.com',
		    'smtp_pass' => 'NIKo1096039150',
		    'mailtype'  => 'html', 
		    'charset'   => 'iso-8859-1',
		    'charset'   => 'utf-8',
			'newline'   => "\r\n"
		);
		$this->load->library('email', $config);
    }

    function recuperarContrasenia($email, $pass){
    	$this->email->from('nikollaihernandezgamus@gmail.com', 'Petrolabs');
        $this->email->to($email); 

        $this->email->subject('Recuperar contraseña');
        $this->email->message('Se ha generado una nueva contraseña: '.$pass);  

        return $this->email->send();
    }
}