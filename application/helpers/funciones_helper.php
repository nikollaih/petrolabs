<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('generarToken')) {
 function generarToken($lenght=35){
    $string = 'qwertyuiopasdfgh_jklzxcv_bnmQWERTYUIOPA_SDFGHJKLZXC_VBNM01237894_56';
    $token = '';
    for ($i=0; $i < $lenght; $i++) { 
      $token .= substr($string, rand(0,strlen($string)),1);
    }
    return $token;
 }
}

if (!function_exists('isLogin')) {
 function isLogin(){
   $CI = & get_instance();  //get instance, access the CI superobject
   $CI->load->library("session");
   $CI->load->model("usuarios");

   if (!$CI->usuarios->validarTokenId($CI->session->userdata("token"), $CI->session->userdata("id"))) {
    responder(0, false, 'Acceso denegado');
   }
   
 }
}

if (!function_exists('isLoginApp')) {
 function isLoginApp($token, $id){
   $CI = & get_instance();  //get instance, access the CI superobject
   $CI->load->model("usuarios");

   if (!$CI->usuarios->validarTokenId($token, $id)) {
    responder(0, false, 'Acceso denegado');
   }
   
 }
}


if (!function_exists('idUsuarioConectado')) {
 function idUsuarioConectado(){
   $CI = & get_instance();  //get instance, access the CI superobject
   $CI->load->library("session");
   return trim($CI->session->userdata("id_usuario"));

 }
}

if (!function_exists('tipoUsuarioConectado')) {
 function tipoUsuarioConectado(){
   $CI = & get_instance();  //get instance, access the CI superobject
   $CI->load->library("session");
   return trim($CI->session->userdata("tipo"));
 }
}
/**
 * Esta funcion obtiene el usuario logueado en ese
 * momento
 */
if (!function_exists('getUsuarioConectado')) {
 function getUsuarioConectado(){
  //echo("hola m");
   $CI = & get_instance();  //get instance, access the CI superobject
   $CI->load->library("session");
   $id= trim($CI->session->userdata("id_usuario"));
   //echo ($id);
   $CI->load->model("usuarios");
   return $CI->usuarios->buscarUsuarioPorId($id);
 }
}

function responder($objeto,$estado,$mensaje){
    $resultado["objeto"]=$objeto;
    $resultado["estado"]=$estado;
    $resultado["mensaje"]=$mensaje;
    echo json_encode($resultado);
    die();
  }