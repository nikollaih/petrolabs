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
   
   if (!$CI->usuarios->validarTokenId($CI->session->userdata("token"), $CI->session->userdata("id_usuario"))) {
    //responder(0, false, 'Acceso denegado');
    redirect(base_url().'auth');
   }
   else{
    return true;
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
   return trim($CI->session->userdata("rol"));
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
   return $CI->usuarios->obtenerUsuario($id);
 }
}

// Define si el usuario conectado tiene permisos para realizar una accion
if (!function_exists('permisos')) {
 function permisos($roles){
   $estado = false;

   if (count($roles) > 0) {
      for ($i=0; $i <= (count($roles) - 1); $i++) { 
        if ($roles[$i] == tipoUsuarioConectado()) {
          $estado = true;
        }
      }
   }

   if (!$estado) {
     redirect(base_url().'producto');
   }
 }
}


if(!function_exists('stringToUrl')){
    function stringToUrl($string) {
        $no_permitidas= array (",", ".","@", "$", "%", ".", ")", "(", "+", "Ñ", "ñ", " ", "á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
        $permitidas= array ('.', '-', '', '', '', '_', '', '', '-', 'n', "n", "-", "a","e","i","o","u","a","e","i","o","u","n","n","a","e","i","o","u","a","e","i","o","u","c","c","a","e","i","o","u","a","e","i","o","u","u","o","o","i","a","e","u","i","a","e");
        $texto = str_replace($no_permitidas, $permitidas ,$string);

        return strtolower($texto);
    }
}

function generarContrasenia($lenght = 6){
  $string = '0123789456';
  $contrasenia = '';
  for ($i=0; $i < $lenght; $i++) { 
    $contrasenia .= substr($string, rand(0,strlen($string)),1);
  }
  return $contrasenia;
}

function replaceSerialize($cadena){
  $no_permitidas = ['%20', '%40'];
  $permitidas = [' ', '@'];

  return str_replace($no_permitidas, $permitidas, $cadena);
}

function serializeToArray($cadena, $separador = '&'){
  $array_temp = explode($separador, $cadena);
  $array = [];
  if (count($array_temp) > 0) {
    for ($i=0; $i < count($array_temp); $i++) { 
       $temp = explode('=', $array_temp[$i]);
       $array[$temp[0]] = replaceSerialize($temp[1]);
    }
  }

  return $array;
}

function responder($objeto,$estado,$mensaje){
  $resultado["objeto"]=$objeto;
  $resultado["estado"]=$estado;
  $resultado["mensaje"]=$mensaje;
  echo json_encode($resultado);
  die();
}

function comisionAsesor($idAsesor){
  $CI = & get_instance();  //get instance, access the CI superobject
  $CI->load->model("ventas");

  $ventas = $CI->ventas->comisionAsesor($idAsesor);

  return $ventas['comision'];
}