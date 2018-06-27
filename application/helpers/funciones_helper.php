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


if(!function_exists('valorEnLetras'))
{
  function valorEnLetras($x)
  {
      if ($x<0) { $signo = "menos ";}
      else      { $signo = "";}
      $x = abs ($x);
      $C1 = $x;

      $G6 = floor($x/(1000000));  // 7 y mas

      $E7 = floor($x/(100000));
      $G7 = $E7-$G6*10;   // 6

      $E8 = floor($x/1000);
      $G8 = $E8-$E7*100;   // 5 y 4

      $E9 = floor($x/100);
      $G9 = $E9-$E8*10;  //  3

      $E10 = floor($x);
      $G10 = $E10-$E9*100;  // 2 y 1


      $G11 = round(($x-$E10)*100,0);  // Decimales
  //////////////////////

      $H6 = unidades($G6);

      if($G7==1 AND $G8==0) { $H7 = "Cien "; }
      else {    $H7 = decenas($G7); }

      $H8 = unidades($G8);

      if($G9==1 AND $G10==0) { $H9 = "Cien "; }
      else {    $H9 = decenas($G9); }

      $H10 = unidades($G10);

      if($G11 < 10) { $H11 = "0".$G11; }
      else { $H11 = $G11; }

  /////////////////////////////
      if($G6==0) { $I6=" "; }
      elseif($G6==1) { $I6="Millon "; }
      else { $I6="Millones "; }

      if ($G8==0 AND $G7==0) { $I8=" "; }
      else { $I8="Mil "; }


      $C3 = $signo.$H6.$I6.$H7.$H8.$I8.$H9.$H10;

      return $C3; //Retornar el resultado

  }
}


function decenas($d)
{
    if ($d==0)  {$rd = "";}
    elseif ($d==1)  {$rd = "Ciento ";}
    elseif ($d==2)  {$rd = "Doscientos ";}
    elseif ($d==3)  {$rd = "Trescientos ";}
    elseif ($d==4)  {$rd = "Cuatrocientos ";}
    elseif ($d==5)  {$rd = "Quinientos ";}
    elseif ($d==6)  {$rd = "Seiscientos ";}
    elseif ($d==7)  {$rd = "Setecientos ";}
    elseif ($d==8)  {$rd = "Ochocientos ";}
    else            {$rd = "Novecientos ";}
    return $rd; //Retornar el resultado
}

function unidades($u)
{
    if ($u==0)  {$ru = " ";}
    elseif ($u==1)  {$ru = "Un ";}
    elseif ($u==2)  {$ru = "Dos ";}
    elseif ($u==3)  {$ru = "Tres ";}
    elseif ($u==4)  {$ru = "Cuatro ";}
    elseif ($u==5)  {$ru = "Cinco ";}
    elseif ($u==6)  {$ru = "Seis ";}
    elseif ($u==7)  {$ru = "Siete ";}
    elseif ($u==8)  {$ru = "Ocho ";}
    elseif ($u==9)  {$ru = "Nueve ";}
    elseif ($u==10) {$ru = "Diez ";}

    elseif ($u==11) {$ru = "Once ";}
    elseif ($u==12) {$ru = "Doce ";}
    elseif ($u==13) {$ru = "Trece ";}
    elseif ($u==14) {$ru = "Catorce ";}
    elseif ($u==15) {$ru = "Quince ";}
    elseif ($u==16) {$ru = "Dieciseis ";}
    elseif ($u==17) {$ru = "Decisiete ";}
    elseif ($u==18) {$ru = "Dieciocho ";}
    elseif ($u==19) {$ru = "Diecinueve ";}
    elseif ($u==20) {$ru = "Veinte ";}

    elseif ($u==21) {$ru = "Veintiun ";}
    elseif ($u==22) {$ru = "Veintidos ";}
    elseif ($u==23) {$ru = "Veintitres ";}
    elseif ($u==24) {$ru = "Veinticuatro ";}
    elseif ($u==25) {$ru = "Veinticinco ";}
    elseif ($u==26) {$ru = "Veintiseis ";}
    elseif ($u==27) {$ru = "Veintisiente ";}
    elseif ($u==28) {$ru = "Veintiocho ";}
    elseif ($u==29) {$ru = "Veintinueve ";}
    elseif ($u==30) {$ru = "Treinta ";}

    elseif ($u==31) {$ru = "Treinta y un ";}
    elseif ($u==32) {$ru = "Treinta y dos ";}
    elseif ($u==33) {$ru = "Treinta y tres ";}
    elseif ($u==34) {$ru = "Treinta y cuatro ";}
    elseif ($u==35) {$ru = "Treinta y cinco ";}
    elseif ($u==36) {$ru = "Treinta y seis ";}
    elseif ($u==37) {$ru = "Treinta y siete ";}
    elseif ($u==38) {$ru = "Treinta y ocho ";}
    elseif ($u==39) {$ru = "Treinta y nueve ";}
    elseif ($u==40) {$ru = "Cuarenta ";}

    elseif ($u==41) {$ru = "Cuarenta y un ";}
    elseif ($u==42) {$ru = "Cuarenta y dos ";}
    elseif ($u==43) {$ru = "Cuarenta y tres ";}
    elseif ($u==44) {$ru = "Cuarenta y cuatro ";}
    elseif ($u==45) {$ru = "Cuarenta y cinco ";}
    elseif ($u==46) {$ru = "Cuarenta y seis ";}
    elseif ($u==47) {$ru = "Cuarenta y siete ";}
    elseif ($u==48) {$ru = "Cuarenta y ocho ";}
    elseif ($u==49) {$ru = "Cuarenta y nueve ";}
    elseif ($u==50) {$ru = "Cincuenta ";}

    elseif ($u==51) {$ru = "Cincuenta y un ";}
    elseif ($u==52) {$ru = "Cincuenta y dos ";}
    elseif ($u==53) {$ru = "Cincuenta y tres ";}
    elseif ($u==54) {$ru = "Cincuenta y cuatro ";}
    elseif ($u==55) {$ru = "Cincuenta y cinco ";}
    elseif ($u==56) {$ru = "Cincuenta y seis ";}
    elseif ($u==57) {$ru = "Cincuenta y siete ";}
    elseif ($u==58) {$ru = "Cincuenta y ocho ";}
    elseif ($u==59) {$ru = "Cincuenta y nueve ";}
    elseif ($u==60) {$ru = "Sesenta ";}

    elseif ($u==61) {$ru = "Sesenta y un ";}
    elseif ($u==62) {$ru = "Sesenta y dos ";}
    elseif ($u==63) {$ru = "Sesenta y tres ";}
    elseif ($u==64) {$ru = "Sesenta y cuatro ";}
    elseif ($u==65) {$ru = "Sesenta y cinco ";}
    elseif ($u==66) {$ru = "Sesenta y seis ";}
    elseif ($u==67) {$ru = "Sesenta y siete ";}
    elseif ($u==68) {$ru = "Sesenta y ocho ";}
    elseif ($u==69) {$ru = "Sesenta y nueve ";}
    elseif ($u==70) {$ru = "Setenta ";}

    elseif ($u==71) {$ru = "Setenta y un ";}
    elseif ($u==72) {$ru = "Setenta y dos ";}
    elseif ($u==73) {$ru = "Setenta y tres ";}
    elseif ($u==74) {$ru = "Setenta y cuatro ";}
    elseif ($u==75) {$ru = "Setenta y cinco ";}
    elseif ($u==76) {$ru = "Setenta y seis ";}
    elseif ($u==77) {$ru = "Setenta y siete ";}
    elseif ($u==78) {$ru = "Setenta y ocho ";}
    elseif ($u==79) {$ru = "Setenta y nueve ";}
    elseif ($u==80) {$ru = "Ochenta ";}

    elseif ($u==81) {$ru = "Ochenta y un ";}
    elseif ($u==82) {$ru = "Ochenta y dos ";}
    elseif ($u==83) {$ru = "Ochenta y tres ";}
    elseif ($u==84) {$ru = "Ochenta y cuatro ";}
    elseif ($u==85) {$ru = "Ochenta y cinco ";}
    elseif ($u==86) {$ru = "Ochenta y seis ";}
    elseif ($u==87) {$ru = "Ochenta y siete ";}
    elseif ($u==88) {$ru = "Ochenta y ocho ";}
    elseif ($u==89) {$ru = "Ochenta y nueve ";}
    elseif ($u==90) {$ru = "Noventa ";}

    elseif ($u==91) {$ru = "Noventa y un ";}
    elseif ($u==92) {$ru = "Noventa y dos ";}
    elseif ($u==93) {$ru = "Noventa y tres ";}
    elseif ($u==94) {$ru = "Noventa y cuatro ";}
    elseif ($u==95) {$ru = "Noventa y cinco ";}
    elseif ($u==96) {$ru = "Noventa y seis ";}
    elseif ($u==97) {$ru = "Noventa y siete ";}
    elseif ($u==98) {$ru = "Noventa y ocho ";}
    else            {$ru = "Noventa y nueve ";}
    return $ru; //Retornar el resultado
}