<? include("lib/database.php")?>
<? include("js/funciones.php")?>
<?
if ($codigo!=0) {

$sql ="SELECT * FROM MAECTA WHERE CUENTA=$codigo";
$dbdatos= new  Database();
$dbdatos->query($sql);
$dbdatos->next_row();
}


if($guardar==1 and $codigo==0) { // RUTINA PARA  INSERTAR REGISTROS NUEVOS

	$campos="(CUENTA,NOMBRE,INDICATIVO,CONTROL,ESTADO)";
	$valores="('".$CUENTA."','".$NOMBRE."','".$INDICATIVO."','".$CONTROL."','1')" ;
	$error=insertar("MAECTA",$campos,$valores); 

	if ($error==1) {
		header("Location: con_cuentas.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	}
	else
		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 
}

if($guardar==1 and $codigo!=0) { // RUTINA PARA  editar REGISTROS NUEVOS

	$campos="CUENTA='".$CUENTA."',NOMBRE='".$NOMBRE."',INDICATIVO='".$INDICATIVO."',CONTROL='".$CONTROL."'";
	$error=editar("MAECTA",$campos,'CUENTA',$codigo); 
	
	if ($error==1) {
		header("Location: con_cuentas.php?confirmacion=2&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
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
<link href="css/styles.css" rel="stylesheet" type="text/css" /> 

<? inicio() ?>

<script language="javascript">
function datos_completos(){  
if (document.getElementById('CUENTA').value == "" || document.getElementById('NOMBRE').value == "" || document.getElementById('INDICATIVO').value == "" || document.getElementById('CONTROL').value == "")
	return false;
else
	return true;
}
</script>

</head>
<body <?=$sis?>>
<form  name="forma" id="forma" action="man_cuentas.php"  method="post">
<table width="624" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
    <td class="tablacabezera"><table width="100%" height="46" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td valign="middle" >&nbsp;</td>
        <td valign="middle" >&nbsp;</td>
        <td valign="middle" >&nbsp;</td>
      </tr>
      <tr>
         <td width="5" height="19">&nbsp;</td>
        <td width="20" ><img src="imagenes/icoguardar.png" alt="Nueno Registro" width="16" height="16" border="0"  onclick="cambio_guardar()" style="cursor:pointer"/></td>
        <td width="61" class="ctablaform">Guardar</td>
        <td width="21" class="ctablaform"><a href="con_cuentas.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
        <td width="22" class="ctablaform">&nbsp;</td>
        <td width="70" class="ctablaform">&nbsp;</td>
        <td width="21" class="ctablaform"></td>
        <td width="60" class="ctablaform">&nbsp;</td>
        <td width="24" valign="middle" class="ctablaform">&nbsp;</td>
        <td width="193" valign="middle"><label>
          <input type="hidden" name="editar"   id="editar"   value="<?=$editar?>">
		  <input type="hidden" name="insertar" id="insertar" value="<?=$insertar?>">
		  <input type="hidden" name="eliminar" id="eliminar" value="<?=$eliminar?>">
          <input type="hidden" name="codigo" id="codigo" value="<?=$codigo?>" />
        </label></td>
        <td width="67" valign="middle">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="4" valign="bottom"><img src="imagenes/lineasup3.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td class="textotabla2">CUENTAS</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <tD valign="top">
	<table width="629" border="0" cellspacing="0" cellpadding="0" class="tablacabezera">
	  <tr>
	    <td width="78" class="textotabla1">&nbsp;</td>
	    <td width="144">&nbsp;</td>
	    <td width="9" align="left" class="textorojo">&nbsp;</td>
	    <td width="64" class="textotabla1">&nbsp;</td>
	    <td width="150">&nbsp;</td>
	    </tr>
	  <tr>
	    <td class="textotabla1">Cuenta:</td>
	    <td><input name="CUENTA" id="CUENTA" type="text" class="textfield2"  value="<?=$dbdatos->CUENTA?>" maxlength="8"  onkeypress="return validaInt_evento(this)" />
	      <span class="textorojo">*</span></td>
	    <td>&nbsp;</td>
	    <td><span class="textotabla1">Nombre:</span></td>
	    <td><input name="NOMBRE" id="NOMBRE" type="text" class="textfield2"  value="<?=$dbdatos->NOMBRE?>" />
	      <span class="textorojo">*</span></td>
	    </tr>
	  <tr>
	    <td class="textotabla1">Indicativo:</td>
	    <td><input name="INDICATIVO" id="INDICATIVO" type="text" class="textfield2"  value="<?=$dbdatos->INDICATIVO?>"  onkeypress="return validaInt_evento(this)" maxlength="1"/>
	      <span class="textorojo">*</span></td>
	    <td class="textorojo">&nbsp;</td>
	    <td class="textotabla1">Control:</td>
	    <td><input name="CONTROL" id="CONTROL" type="text" class="textfield2"  value="<?=$dbdatos->CONTROL?>"  onkeypress="return validaInt_evento(this)" maxlength="1"/>
	      <span class="textorojo">*</span></td>
	    </tr>
	  <tr>
	    <td class="textotabla1">&nbsp;</td>
	    <td>&nbsp;</td>
	    <td class="textorojo">&nbsp;</td>
	    <td class="textotabla1">&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
      </table></td>
  </tr>
  
  <tr>
    <td><div align="center"><img src="imagenes/spacer.gif" alt="." width="624" height="4" /></div></td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td height="30"  > <input type="hidden" name="guardar" id="guardar" />
	</td>
  </tr>
</table>
</form> 
</body>
</html>

