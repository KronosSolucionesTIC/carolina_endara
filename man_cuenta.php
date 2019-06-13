<?php include("lib/database.php");?>
<?php include("js/funciones.php");?>
<?php 

//RECIBE LAS VARIABLES
$codigo = $_REQUEST['codigo'];
$guardar = $_REQUEST['guardar'];
$insertar = $_REQUEST['insertar'];
$eliminar = $_REQUEST['eliminar'];
$editar = $_REQUEST['editar'];

if ($codigo!=0) {
$sqlm ="SELECT * FROM cuenta WHERE cod_cuenta=$codigo";
$dbm = new  Database();
$dbm->query($sqlm);
$dbm->next_row();
}

if($guardar==1 and $codigo==0) { // RUTINA PARA INSERTAR REGISTROS NUEVOS
	$campos="(desc_cuenta,cod_contable,nivel,estado_cuenta)";
	$valores="('".$_REQUEST['nombres']."','".$_REQUEST['cod_contable']."','".$_REQUEST['nivel']."',1)" ;
	$error=insertar("cuenta",$campos,$valores); 
	if ($error==1) {
		header("Location: con_cuenta.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	}
	else
		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 
}

if($guardar==1 and $codigo!=0) { // RUTINA PARA EDITAR REGISTROS NUEVOS
	$campos="desc_cuenta='".$_REQUEST['nombres']."',cod_contable='".$_REQUEST['cod_contable']."',nivel='".$_REQUEST['nivel']."'";
	$error=editar("cuenta",$campos,'cod_cuenta',$codigo); 
	if ($error==1) {
		header("Location: con_cuenta.php?confirmacion=2&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
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
if (document.getElementById('nombres').value == "" || document.getElementById('cod_contable').value == "" || document.getElementById('nivel').value == "")
	return false;
else
	return true;
}
</script>
</head>
<body <?php echo $sis?>>
<form  name="forma" id="forma" action="man_cuenta.php"  method="post">
<table width="624" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
    <td bgcolor="#E9E9E9"><table width="100%" height="46" border="0" cellpadding="0" cellspacing="0">
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
        <td width="21" class="ctablaform"><a href="con_cuenta.php?confirmacion=0&amp;editar=<?php echo $editar?>&amp;insertar=<?php echo $insertar?>&amp;eliminar=<?php echo $eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
        <td width="22" class="ctablaform"></td>
        <td width="70" class="ctablaform"></td>
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
    <td class="textotabla1 Estilo1">CUENTAS CONTABLES:</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td bgcolor="#E9E9E9" valign="top">
	<table width="629" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="113" class="textotabla1">Nombre:</td>
        <td width="152"><input name="nombres" id="nombres" type="text" class="textfield2" value="<?php echo $dbm->desc_cuenta?>" onkeyup = "this.value=this.value.toUpperCase()" /></td>
        <td width="209"><span class="textorojo">*</span></td>
        <td width="83">&nbsp;</td>
        <td width="13">&nbsp;</td>
        <td width="46">&nbsp;</td>
      </tr>
	  <tr>
	    <td class="textotabla1">Codigo contable:</td>
	    <td><input name="cod_contable" id="cod_contable" type="text" class="textfield2" value="<?php echo $dbm->cod_contable?>" maxlength="8" onkeypress="return validaInt_evento(this)"/></td>
	    <td><span class="textorojo">*</span></td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	  <tr> 
	  	<td class="textotabla1">Nivel:</td>
		<td><input name="nivel" id="nivel" type="text" class="textfield2" value="<?php echo $dbm->nivel?>" maxlength="8" onkeypress="return validaInt_evento(this)"/></td>
		<td><span class="textorojo">*</span></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
    </table></td>
  </tr>
  <tr>
    <td height="30"  > <input type="hidden" name="guardar" id="guardar" />
	</td>
  </tr>
</table>
</form> 
</body>
</html>