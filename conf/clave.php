<?
session_start();
#TABLAS DEL SISTEMA
$t_proyecto="proyecto";
$t_usuario="usuario";
//$t_cargo="cargo";
$t_movil="movil";
$t_proyecto="proyecto";
//------------- Servidor donde esta siendo ejecutado ----------------
$servidor = "http://".$HTTP_HOST."/servidor/admin/";
//------------- Ruta f�sica del servidor para los paths----------------
$ruta_fisica = "c:/appserv/www/sis_dis/admin/";
$nombre_imagenes="imagenes";
$cant_reg_pag=20;
$nombre_aplicacion=":::: SISTEMA POS :::";
//$sis="onContextMenu='return false' ";
$celda_blanca=" bgcolor='#FFFFFF' onMouseOver= \"bgColor='#CCCCCC' \" onMouseOut=\"bgColor='#FFFFFF'\" ";
$celda_gris=" bgcolor='#EEEEEE' onMouseOver= \"bgColor='#CCCCCC' \" onMouseOut=\"bgColor='#EEEEEE'\" ";

$where="";
	
//	session_unset();
//	session_register("global");
		
?>
