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
		if(confirm("¿Esta seguro de Anular esta apartado?")) 
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
	$sql = "  update   m_apartado  set  estado='anulado',razon_anulacion='$razon',obs_anulacion='$observacion'   WHERE  cod_apa=$codigo ";
	$db6->query($sql);	
	
	$db7 = new Database();
	$sql2 = "  update   m_apartado_esp  set  estado='anulado'   WHERE  cod_apa_m=$codigo ";
	$db7->query($sql2);	
	
	
	// parte de ajuste del kardex
	$sql = " select * ,(select cod_bod from m_apartado where cod_apa=$codigo) as bodega from d_apartado  where cod_mapa=$codigo ";
	$db6->query($sql);	
	while($db6->next_row()) {
		
		$bodega = $db6->bodega;
		kardex("suma",$db6->cod_pro ,$db6->bodega,$db6->cant_pro,$_REQUEST["costo_ref_".$ii],$db6->cod_peso);
	}
	
	$db8 = new Database();
	$sql = " select sum(tot_apa-tot_dev_mapa) as total from m_apartado  where cod_apa=$codigo ";
	$db8->query($sql);	
	$db8->next_row();
	$total = $db8->total;
	
	//INGRESO DE LA DEVOLUCION
	$campos="(fec_dev, cod_bod_dev, num_apa_dev ,val_del,cod_ven_dev, obs_dev)";
	$valores="('".date("Y-m-d")."','".$_REQUEST['bodega']."','".$_REQUEST['codigo']."','".$_REQUEST['total']."','".$_SESSION['global_2']."','".$_REQUEST['observacion']."')" ; 
	$id=insertar_maestro("m_devolucion",$campos,$valores);
	
	$compos="(cod_mdev, cod_mapa_dev , cod_dapa_dev, cod_prod_ddev, cod_pes_ddev, cant_apa_dev, val_apa ,cant_ddev,total_ddev) ";
	$db9 = new Database();
	$sql = "SELECT * FROM d_apartado 
	INNER JOIN m_apartado ON m_apartado.cod_apa = d_apartado.cod_mapa 
	WHERE cod_mapa = $codigo";
	$db9->query($sql);
	while($db9->next_row()){
		$cod_dapa = $db9->cod_dapa;	
		$cod_pro = $db9->cod_pro;	
		$cod_peso = $db9->cod_peso;
		$cant_pro = $db9->cant_pro;
		$val_uni = $db9->val_uni;
		$total_pro = $db9->total_pro;
		$num_apa = $db9->num_apa;
		$valores="('".$id."','".$codigo."','".$cod_dapa."','".$cod_pro."','".$cod_peso."' ,'".$cant_pro."','".$val_uni."','".$cant_pro."','".$total_pro."')";
		$error=insertar("d_devolucion",$compos,$valores); 	
	}
	
	//INGRESO DE LA ENTRADA
	$db9 = new Database();
	$sql = "SELECT * FROM d_apartado 
	INNER JOIN m_apartado ON m_apartado.cod_apa = d_apartado.cod_mapa 
	WHERE cod_mapa = $codigo";
	$db9->query($sql);
	$campos="(fec_ment,apa_ment,obs_ment,cod_bod,total_ment,cod_prove_ment,usu_ment,estado_m_entrada)";
	$valores="('".date('Y-m-d')."','','DEVOLUCION APARTADO No "."$num_apa','".$bodega."','".$total."','','".$_SESSION['global_2']."','1')" ; 
	$ins_id=insertar_maestro("m_entrada",$campos,$valores); 
	
	$campos="(cod_ment_dent,cod_tpro_dent,cod_mar_dent,cod_pes_dent,cod_ref_dent,cant_dent,cos_dent)";
	$db10 = new Database();
	$sql = "SELECT * FROM d_apartado 
	INNER JOIN m_apartado ON m_apartado.cod_apa = d_apartado.cod_mapa 
	WHERE cod_mapa = $codigo";
	$db10->query($sql);
	while($db10->next_row()){
		$cod_tpro = $db10->cod_tpro;	
		$cod_cat = $db10->cod_cat;	
		$cod_peso = $db10->cod_peso;
		$cod_pro = $db10->cod_pro;
		$cant_pro = $db10->cant_pro;
		$val_uni = $db10->val_uni;
		$total_pro = $db10->total_pro;
		$num_apa = $db10->num_apa;
		$valores="('".$ins_id."','".$cod_tpro."','".$cod_cat."','".$cod_peso."','".$cod_pro."' ,'".$cant_pro."','".$val_uni."')";
		$error=insertar("d_entrada",$campos,$valores); 	
	}	
	
	//ELIMINACION DEL OTRO PAGO
		eliminar("otros_pagos", $codigo,"cod_apa");
	
	echo " <script language='javascript'>window.location = 'con_anul_apa.php?confirmacion=0&editar=$editar&insertar=$insertar&eliminar=$eliminar'; </script> "; 

}
?>
<script type="text/javascript" src="js/js.js"></script>
<script type="text/javascript" src="js/funciones.js"></script>
<script type="text/javascript" src="informes/inf.js"></script>
</head>
<body <?php echo $sis?>>
<div id="total">
<form  name="forma" id="forma" action="man_anul_apa.php"  method="post">
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
        <td width="21" class="ctablaform"><a href="con_anul_apa.php?confirmacion=0&editar=<?php echo $editar?>&insertar=<?php echo $insertar?>&eliminar=<?php echo $eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
        <td width="22" class="ctablaform"><a href="con_cargue.php?confirmacion=0&editar=<?php echo $editar?>&insertar=<?php echo $insertar?>&eliminar=<?php echo $eliminar?>"></a></td>
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
    <td class="textotabla01">ANULACION DE APARTADO:</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td bgcolor="#D1D8DE" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
        <td width="147" class="textotabla1">No apartado:</td>
        <td width="119" class="textotabla1"><a href="#">
		
		<img src="imagenes/mirar.png" alt="Cancelar" width="16" height="16" border="0"   onclick="imprimir_inf('ver_apartado_v.php',<?php echo $codigo?>,'grande')"/>
		
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
           <?php echo $dbdatos_edi->tot_apa?>
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