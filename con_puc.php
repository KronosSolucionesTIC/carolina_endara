<?php include("lib/database.php");?>
<?php include("js/funciones.php");?>
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

	return true;
}
</script>
</head>
<body <?php echo $sis?>>
<form  name="forma" id="forma" action="inventario/a.php"  method="post" enctype="multipart/form-data">
<table width="624" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
    <td bgcolor="#E9E9E9"><table width="100%" height="46" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="5" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="20" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="61" bgcolor="#FFFFFF" >&nbsp;</td>
        <td width="21" bgcolor="#FFFFFF" >&nbsp;</td>
        <td width="65" bgcolor="#FFFFFF" >&nbsp;</td>
        <td width="22" bgcolor="#FFFFFF" >&nbsp;</td>
        <td width="70" bgcolor="#FFFFFF" >&nbsp;</td>
        <td width="21" bgcolor="#FFFFFF" >&nbsp;</td>
        <td width="60" bgcolor="#FFFFFF" >&nbsp;</td>
        <td width="24" valign="middle" bgcolor="#FFFFFF" >&nbsp;</td>
        <td width="193" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
        <td width="67" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      </table></td>
  </tr>
  <tr>
    <td height="4" valign="bottom"><img src="imagenes/lineasup3.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td class="textotabla1 Estilo1">PUC:</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td bgcolor="#E9E9E9" valign="top">
	<table width="629" border="0" cellspacing="0" cellpadding="0">
	        <tr>
	          <td width="105" class="textotabla1">&nbsp;</td>
	          <td width="144" class="textfield2">PUC</td>
	          <td width="8">&nbsp;</td>
	          <td width="51" class="textotabla1">&nbsp;</td>
	          <td width="232"><a href="exportar_puc.php" target="_blank">Descargar </a></td>
	          <td width="6" class="textorojo">&nbsp;</td>
	          <td width="83" class="textorojo">&nbsp;</td>
          </tr>
    </table></td>
  </tr>  
  <tr>
    <td><img src="imagenes/lineasup3.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td height="30"  > <input type="hidden" name="guardar" id="guardar" />	</td>
  </tr>
</table>
</form> 
</body>
</html>