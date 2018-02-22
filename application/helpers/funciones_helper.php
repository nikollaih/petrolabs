<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('isLogin')) {
 function isLogin(){
   $CI = & get_instance();  //get instance, access the CI superobject
   $CI->load->library("session");

   if (empty(trim($CI->session->userdata("id"))) && empty(trim($CI->session->userdata("nombre"))) && empty(trim($CI->session->userdata("email")))) {
     redirect("panel");
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
[9:41 PM, 2/21/2018] Niko Hernandez: /**
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