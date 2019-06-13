<?php include("lib/database.php");?>
<?php include("js/funciones.php");?>
<?

//RECIBE LAS VARIABLES
$codigo = $_REQUEST['codigo'];
$guardar = $_REQUEST['guardar'];
$insertar = $_REQUEST['insertar'];
$eliminar = $_REQUEST['eliminar'];
$editar = $_REQUEST['editar'];

if ($codigo!="") {
$sql ="SELECT * FROM gastos  WHERE cod_gasto = $codigo";
$dbdatos= new  Database();
$dbdatos->query($sql);
$dbdatos->next_row();
}

if($guardar==1 and $codigo==0) { // RUTINA PARA  INSERTAT REGISTROS NUEVOS
	$compos="(tipo_gasto,fecha_gasto,valor_gasto,obs_gasto)";
	$valores="('".$_REQUEST['tipo_gasto']."','".$_REQUEST['fecha']."','".$_REQUEST['valor_gas']."','".$_REQUEST['desc']."')" ;
	$error=insertar("gastos",$compos,$valores); 
	if ($error==1) {
		header("Location: con_gasto.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	}
	else
		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 
}

if($guardar==1 and $codigo!=0) { // RUTINA PARA  editar REGISTROS NUEVOS
	$compos="fecha_gasto='".$_REQUEST['fecha']."',tipo_gasto='".$_REQUEST['tipo_gasto']."',valor_gasto='".$_REQUEST['valor_gas']."',obs_gasto='".$_REQUEST['desc']."'"; 
	$error=editar("gastos",$compos,'cod_gasto',$codigo); 
	if ($error==1) {
		header("Location: con_gasto.php?confirmacion=2&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
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
if (document.getElementById('fecha').value == "" && document.getElementById('valor_gas').value == "" && document.getElementById('nombre_gas').value == "" )
	return false;
else
	return true;
}
</script>

</head>
<body <?php echo $sis?>>
<form  name="forma" id="forma" action="man_gasto.php"  method="post">
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
        <td width="21" class="ctablaform"><a href="con_gasto.php?confirmacion=0&editar=<?php echo $editar?>&insertar=<?php echo $insertar?>&eliminar=<?php echo $eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
        <td width="22" class="ctablaform"><a href="con_gasto.php?confirmacion=0&editar=<?php echo $editar?>&insertar=<?php echo $insertar?>&eliminar=<?php echo $eliminar?>"><img src="imagenes/iconolupa.gif" alt="Buscar" width="16" height="16" border="0" /></a></td>
        <td width="70" class="ctablaform">Consultar</td>
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
    <td class="textotabla1 Estilo1">GASTOS ADMINISTRATIVOS:</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td bgcolor="#D1D8DE" valign="top">
	<table width="629" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="textotabla1">Fecha:</td>
        <td><input name="fecha" type="text" class="fecha" id="fecha" readonly="1" value="<?php echo $dbdatos->fecha_gasto?>"/>
          <a href="#"><img src="imagenes/date.png" alt="Calendario" name="calendario" width="16" height="16" border="0" id="calendario"/></a></td>
        <td><span class="textorojo">*</span></td>
        <td class="textotabla1">Tipo de Gasto :</td>
        <td><?php combo_evento_where("tipo_gasto","tipo_gastos","cod_gas","nom_gas", $dbdatos->tipo_gasto,""," where estado_tipo_gastos = 1 ORDER BY nom_gas");  ?>          <span class="textorojo">*</span></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textorojo">&nbsp;</td>
      </tr>
	  
	   <tr>
        <td width="57" class="textotabla1">Valor:</td>
        <td width="148"><input name="valor_gas" id="valor_gas" type="text" class="textfield2"  value="<?php echo $dbdatos->valor_gasto?>"  onkeypress="  return validaInt()" /></td>
        <td width="12"><span class="textorojo">*</span></td>
        <td width="108"><span class="textotabla1">Observacion: </span></td>
        <td width="226"><textarea name="desc" cols="35" rows="4" class="textfield02"  ><?php echo $dbdatos->obs_gas?></textarea></td>
        <td width="9" class="textorojo">&nbsp;</td>
        <td width="69" class="textorojo">&nbsp;</td>
      </tr>
	  
      <tr>
        <td width="57" class="textotabla1">&nbsp;</td>
        <td width="148">&nbsp;</td>
        <td width="12">&nbsp;</td>
        <td width="108" class="textotabla1">&nbsp;</td>
        <td width="226">&nbsp;</td>
        <td width="9" class="textorojo">&nbsp;</td>
        <td width="69" class="textorojo">&nbsp;</td>
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
				inputField  : "fecha",      
				ifFormat    : "%Y-%m-%d",    
				button      : "calendario" ,  
				align       :"T3",
				singleClick :true
				}
			);
</script>
</body>
</html>