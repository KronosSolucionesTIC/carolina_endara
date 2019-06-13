<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
 * {
	padding:0px;
 	margin:0px;
 }
 
 #header{
	 margin:auto;
	 width:100%;
 }
 
 ul,ol{
	 list-style:none;
 }
 
 .nav li a{
	 background:#1F6FC6;
	 color:#FFF;
	 text-decoration:none;
	 padding:10px 15px;
	 display:block;
 }
 
  .nav li a:hover{
	 background:#434343;
 }
 
 .nav > li {
	 float:left;
 }
 
 .nav li ul{
	 display:none;
	 position:absolute;
	 min-width:140px;
 }
 
   .nav li:hover > ul {
	 display:block;
 }
</style>
</head>
<body>
<div id="header">
<ul class="nav">
<? 
$usu = $_SESSION['global_2'];
$db= new  Database();
$sql="SELECT  cod_mod, nom_mod,cod_int_per,nom_int,rut_int, cod_usu_per,con_per,edi_per, ins_per,eli_per ,concat(CONCAT(CONCAT(CONCAT(CONCAT(CONCAT(CONCAT(CONCAT(CONCAT(rut_int,'?consulta='),cod_usu_per),'&editar='),edi_per),'&insertar='),ins_per),'&eliminar='),eli_per),'&pagina=1')
	AS rutas,cod_per FROM  permisos INNER JOIN interfaz   ON permisos.cod_int_per=interfaz.cod_int INNER JOIN modulos ON interfaz.cod_mod_int=modulos.cod_mod
	WHERE permisos.cod_usu_per=$usu  AND con_per > 0 ORDER BY modulos.cod_mod ,cod_per asc"; 
$db->query($sql);
$modulo=0;
 while($db->next_row()) 
{
				if($modulo != $db->cod_mod) 
				{//IMPRIMIR PADRE
?>
<li><a href=""><?=$db->nom_mod?></a>
<ul>
<? 
$usu = $_SESSION['global_2'];
$db1= new  Database();
$sql1="SELECT  cod_mod, nom_mod, cod_int_per,nom_int,rut_int, cod_usu_per,con_per,edi_per, ins_per,eli_per ,concat(CONCAT(CONCAT(CONCAT(CONCAT(CONCAT(CONCAT(CONCAT(CONCAT(rut_int,'?consulta='),cod_usu_per),'&editar='),edi_per),'&insertar='),ins_per),'&eliminar='),eli_per),'&pagina=1')
	AS rutas,cod_per FROM  permisos INNER JOIN interfaz   ON permisos.cod_int_per=interfaz.cod_int INNER JOIN modulos ON interfaz.cod_mod_int=modulos.cod_mod
	WHERE permisos.cod_usu_per=$usu  AND con_per>0 AND cod_mod = $db->cod_mod  ORDER BY modulos.cod_mod ,cod_per asc"; 
$db1->query($sql1); 
$modulo=0;
 while($db1->next_row()) 
{
?>
<li><a href="<?=$db1->rutas?>" target="interna"><?=$db1->nom_int?></a></li>
<? 
}
?>
</ul>
</li>
<? 
				$modulo=$db->cod_mod;
				}
}
?>
</ul>
</div>
</body>
</html>
