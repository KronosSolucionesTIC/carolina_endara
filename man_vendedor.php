<?php include("lib/database.php");?>
<?php include("js/funciones.php");?>
<?php 

//RECIBE LAS VARIABLES
$codigo = $_REQUEST['codigo'];
$guardar = $_REQUEST['guardar'];
$insertar = $_REQUEST['insertar'];
$eliminar = $_REQUEST['eliminar'];
$editar = $_REQUEST['editar'];

if ($codigo!="") {
	$sql ="SELECT cod_ven, cc_ven, nom_ven, dir_ven, tel_ven, cod_emp_ven, cod_bod_ven, fec_ing_ven, fec_ret_ven, inv_ven, cod_car_ven
FROM vendedor  WHERE cod_ven = $codigo";
$dbdatos= new  Database();
$dbdatos->query($sql);
$dbdatos->next_row();
}

if($guardar==1 and $codigo==0) { // RUTINA PARA  INSERTAR REGISTROS NUEVOS
	$compos="(nom_ven,cc_ven,tel_ven, dir_ven,  cod_emp_ven, cod_bod_ven, fec_ing_ven, fec_ret_ven,estado_vendedor)";
	
	$valores="('".$_REQUEST['nombres']."','".$_REQUEST['cc']."','".$_REQUEST['tel']."','".$_REQUEST['dir']."','".$_REQUEST['empresa']."','".$_REQUEST['bodega']."','".$_REQUEST['fecha_ing']."','".$_REQUEST['fecha_ret']."','1')" ;
	
	$error=insertar("vendedor",$compos,$valores); 
	if ($error==1) {
		header("Location: con_vendedor.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	}
	else
		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 
}

if($guardar==1 and $codigo!=0) { // RUTINA PARA  editar REGISTROS 
	$compos="cc_ven='".$_REQUEST['cc']."', nom_ven='".$_REQUEST['nombres']."', tel_ven='".$_REQUEST['tel']."',dir_ven='".$_REQUEST['dir']."', cod_emp_ven='".$_REQUEST['empresa']."', cod_bod_ven='".$_REQUEST['bodega']."',  fec_ing_ven='".$_REQUEST['fecha_ing']."', fec_ret_ven='".$_REQUEST['fecha_ret']."'";
	//exit;
	$error=editar("vendedor",$compos,'cod_ven',$codigo); 
	if ($error==1) {
		header("Location: con_vendedor.php?confirmacion=2&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	}
	else
		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Estilo1 {font-size: 12px}
</style> 

<?php inicio() ?>

<script language="javascript">
function datos_completos(){  
if (document.getElementById('nombres').value == "" ||  document.getElementById('cc').value == ""  )
	return false;
else
	return true;
}

</script>

</head>
<body <?php echo $sis?>>
<form  name="forma" id="forma" action="man_vendedor.php"  method="post">
<table width="624" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
    <td bgcolor="#D1D8DE"><table width="100%" height="46" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td valign="middle" bgcolor="#FFFFFF" >&nbsp;</td>
        <td valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
        <td valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
         <td width="5" height="19">&nbsp;</td>
        <td width="20" ><img src="imagenes/icoguardar.png" alt="Nueno Registro" width="16" height="16" border="0"  onclick="cambio_guardar()" style="cursor:pointer"/></td>
        <td width="61" class="ctablaform">Guardar</td>
        <td width="21" class="ctablaform"><a href="con_vendedor.php?confirmacion=0&editar=<?php echo $editar?>&insertar=<?php echo $insertar?>&eliminar=<?php echo $eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
        <td width="22" class="ctablaform">&nbsp;</td>
        <td width="70" class="ctablaform">&nbsp;</td>
        <td width="21" class="ctablaform"></td>
        <td width="60" class="ctablaform">&nbsp;</td>
        <td width="24" valign="middle" class="ctablaform">&nbsp;</td>
        <td width="193" valign="middle"><label>
          <input type="hidden" name="editar"   id="editar"   value="<?php echo $editar?>">
		  <input type="hidden" name="insertar" id="insertar" value="<?php echo $insertar?>">
		  <input type="hidden" name="eliminar" id="eliminar" value="<?php echo $eliminar?>">
          <input type="hidden" name="codigo" id="codigo" value="<?php echo $codigo?>" />
        </label></td>
        <td width="67" valign="middle">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="4" valign="bottom"><img src="imagenes/lineasup3.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td class="textotabla1 Estilo1">EMPLEADOS:</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td bgcolor="#D1D8DE" valign="top">
	<table width="629" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="61" class="textotabla1">Nombres:</td>
        <td width="158"><input name="nombres" id="nombres" type="text" class="textfield2"  value="<?php echo $dbdatos->nom_ven?>" />
          <span class="textorojo">*</span></td>
        <td width="18" align="left" class="textorojo">&nbsp;</td>
        <td width="105" class="textotabla1">Identificacion:</td>
        <td width="162"><input name="cc" id="cc" type="text" class="textfield2"  value="<?php echo $dbdatos->cc_ven?>" onkeypress="  return validaInt()" />
          <span class="textorojo">*</span></td>
        <td width="96" class="textorojo">&nbsp;</td>
        <td width="29" class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Direccion:</td>
        <td><input name="dir" id="dir" type="text" class="textfield2"  value="<?php echo $dbdatos->dir_ven?>" /></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textotabla1">Telefono:</td>
        <td><input name="tel" id="tel" type="text" class="textfield2"  value="<?php echo $dbdatos->tel_ven?>" /></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Empresa:</td>
        <td ><?php combo_evento_where("empresa","rsocial","cod_rso","nom_rso",$dbdatos->cod_emp_ven,""," where estado_rsocial = 1"); ?></td>
        <td>&nbsp;</td>
        <td class="textotabla1">Bodega:</td>
        <td><?php combo("bodega","bodega","cod_bod","nom_bod",$dbdatos->cod_bod_ven); ?></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Fecha ing.</td>
        <td><input name="fecha_ing" type="text" class="fecha" id="fecha_ing" readonly="1" value="<?php echo $dbdatos->fec_ing_ven?>"/>
          <a href="#"><img src="imagenes/date.png" alt="Calendario" name="calendario" width="16" height="16" border="0" id="calendario"/></a></td>
        <td><a href="#"></a></td>
        <td class="textotabla1">Fecha ret. </td>
        <td><input name="fecha_ret" type="text" class="fecha" id="fecha_ret" readonly="1" value="<?php echo $dbdatos->fec_ret_ven?>"/>
          <a href="#"><img src="imagenes/date.png" alt="Calendario" name="calendario1" width="16" height="16" border="0" id="calendario"/></a></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textorojo">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td><div align="center"><img src="imagenes/spacer.gif" alt="." width="624" height="4" /></div></td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td height="30"  > <input type="hidden" name="guardar" id="guardar" />
	</td>
  </tr>
</table>
</form> 
<script type="text/javascript">
			Calendar.setup(
				{
				inputField  : "fecha_ing",      
				ifFormat    : "%Y-%m-%d",    
				button      : "calendario" ,  
				align       :"T3",
				singleClick :true
				}
			);
</script>
<script type="text/javascript">
			Calendar.setup(
				{
				inputField  : "fecha_ret",      
				ifFormat    : "%Y-%m-%d",    
				button      : "calendario1" ,  
				align       :"T3",
				singleClick :true
				}
			);
</script>
</body>
</html>