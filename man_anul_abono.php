<?php include("lib/database.php");?>
<?php include("js/funciones.php");?>
<?php
//RECIBE LAS VARIABLES
$codigo = $_REQUEST['codigo'];
$guardar = $_REQUEST['guardar'];
$insertar = $_REQUEST['insertar'];
$eliminar = $_REQUEST['eliminar'];
$editar = $_REQUEST['editar'];
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
function datos_completos_sigue()
{  
	if(document.getElementById('razon').value==0 || document.getElementById('observacion').value==''){
	  alert("Complete los campos obligatorios");
	  return false;
	}
	else {
		if(confirm("¿Esta seguro de Anular esta abono?")) 
			{
				document.forma.submit();		
			}
	}
}

</script>
<?

if($_REQUEST['anular']==1 and $codigo>0) 	{ // RUTINA PARA  INSERTAT REGISTROS NUEVOS
	$razon = $_REQUEST['razon'];
	$observacion = $_REQUEST['observacion'];

	$db6 = new Database();
	$sql = "  update   m_abono  set  estado='anulado',razon_anulacion='$razon',obs_anulacion='$observacion'   WHERE  cod_abo=$codigo ";
	$db6->query($sql);		
	
	//ELIMINACION DEL OTRO PAGO
		eliminar("otros_pagos", $codigo,"cod_abo");
	
	echo " <script language='javascript'>window.location = 'con_anul_abono.php?confirmacion=0&editar=$editar&insertar=$insertar&eliminar=$eliminar'; </script> "; 

}
?>
<script type="text/javascript" src="js/js.js"></script>
<script type="text/javascript" src="js/funciones.js"></script>
<script type="text/javascript" src="informes/inf.js"></script>
</head>
<body <?php echo $sis?>>
<div id="total">
<form  name="forma" id="forma" action="man_anul_abono.php"  method="post">
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
   <td bgcolor="#D1D8DE" >
   <table width="100%" height="30" border="0" cellspacing="0" cellpadding="0" align="center" > 
      <tr>
        <td width="5" height="30">&nbsp;</td>
        <td width="20" >
        <?php if($no_anular!=1) { ?>
        <img src="imagenes/icoguardar.png" alt="Nueno Registro" width="16" height="16" border="0" onClick="datos_completos_sigue()" style="cursor:pointer"/>
        <?php } ?>
        </td>
        <td width="61" class="ctablaform">Anular</td>
        <td width="21" class="ctablaform"><a href="con_anul_abono.php?confirmacion=0&editar=<?php echo $editar?>&insertar=<?php echo $insertar?>&eliminar=<?php echo $eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
        <td width="22" class="ctablaform"><a href="con_anul_abono.php?confirmacion=0&editar=<?php echo $editar?>&insertar=<?php echo $insertar?>&eliminar=<?php echo $eliminar?>"></a></td>
        <td width="70" class="ctablaform">&nbsp;</td>
        <td width="21" class="ctablaform"></td>
        <td width="60" class="ctablaform">&nbsp;</td>
        <td width="24" valign="middle" class="ctablaform">&nbsp;</td>
        <td width="193" valign="middle">
          <input type="hidden" name="editar"   id="editar"   value="<?php echo $editar?>">
		  <input type="hidden" name="insertar" id="insertar" value="<?php echo $insertar?>">
		  <input type="hidden" name="eliminar" id="eliminar" value="<?php echo $eliminar?>">
          <input type="hidden" name="codigo" id="codigo" value="<?php echo $codigo?>" /> 
		   <input type="hidden" name="anular" id="anular" value="1">
		  </td>
        
        <td width="67" valign="middle">&nbsp;</td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td height="4" valign="bottom"><img src="imagenes/lineasup3.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td class="textotabla01">ANULACION DE ABONO:</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td bgcolor="#D1D8DE" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
        <td width="147" class="textotabla1">No abono:</td>
        <td width="119" class="textotabla1"><a href="#">
		
		<img src="imagenes/mirar.png" alt="Cancelar" width="16" height="16" border="0"   onclick="imprimir_inf('ver_abono.php',<?php echo $codigo?>,'grande')"/>
		
		</a>
         &nbsp;</td>
        <td width="17" class="textorojo">*</td>
        <td width="55" class="textotabla1" valign="top">Cliente</td>
        <td width="211"><span class="textotabla1">
          <?php echo $dbdatos_edi->nom_bod?>
        </span></td>
        <td width="201">&nbsp;</td>
       </tr>
       <tr>
         <td class="textotabla1">Razon:</td>
         <td><span class="textotabla1">
           <?php combo_evento("razon","razon_anulacion","cod_razon","desc_razon",""," ", "desc_razon"); ?>
         </span></td>
         <td><span class="textorojo">*</span></td>
         <td width="55" class="textotabla1" valign="top">Valor</td>
         <td><span class="textotabla1">
           <?php echo $dbdatos_edi->tot_abono?>
         </span></td>
         <td>&nbsp;</td>
       </tr>
	   <tr>
         <td class="textotabla1" >Observacion:     	   
	     <td class="textotabla1" ><textarea name="observacion" id="observacion" cols="45" rows="3" class="textfield02"></textarea>         
	     <td class="textotabla1" ><span class="textorojo">*</span>                  
	     <td class="textotabla1" >         
	     <td class="textotabla1" >         
	     <td class="textotabla1" >         
	   </table>		  
	    </td>
	  </tr>
	  <tr> 
		<td colspan="8" >		  
		</td>
	  </tr>
    </table>
<tr>
  <tr>
    <td>
	<input type="hidden" name="val_inicial" id="val_inicial" value="<?php if($codigo!=0) echo $jj-1; else echo "0"; ?>" />
	<input type="hidden" name="guardar" id="guardar" />
		 <?php  if ($codigo!="") $valueInicial = $aa; else $valueInicial = "1";?>
	   <input type="hidden" id="valDoc_inicial" value="<?php echo $valueInicial?>"> 
	   <input type="hidden" name="cant_items" id="cant_items" value=" <?php  if ($codigo!="") echo $aa; else echo "0"; ?>">
	</td>
  </tr>
</table>
</form> 
</div>
</body>
</html>