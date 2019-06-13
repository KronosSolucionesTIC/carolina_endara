<?php include("lib/database.php");?>
<?php include("js/funciones.php");?>
<?
if ($codigo!=0) { // BUSCAR DATOS

	$sql ="SELECT  *  FROM m_entrada 
	WHERE cod_ment=$codigo";		
	$dbdatos= new  Database();
	$dbdatos->query($sql);
	$dbdatos->next_row();
}

if($guardar==1 and $codigo==0) 	{ // RUTINA PARA  INSERTAR REGISTROS NUEVOS
		
		$compos="(MES,CUENTA,BENEF,VALOR,DEBCRE,COMP,COD_FAC,OP,CONCEP,VENDEDOR,NCHE,BANCO,FCHE,DIAS)";
		
		for ($ii=1 ;  $ii <= $val_inicial ; $ii++) 
		{
			if($_REQUEST['debito_'.$ii] > 0){
				$valor = $_REQUEST['debito_'.$ii];
				$deb_cre = 0;
			}
			else{
				$valor = $_REQUEST['credito_'.$ii];
				$deb_cre = 1;
			}
			$valores="('".$_REQUEST['fecha']."','".$_REQUEST['cuenta_'.$ii]."','".$_REQUEST['benef_'.$ii]."','".$valor."','".$deb_cre."','2','','".$_REQUEST['num_doc']."','','','','','','')" ;
			$error=insertar("mo",$compos,$valores); 
		}

	if ($error==1) {
		header("Location: con_ingresos.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
}

else
	echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 	
	
}

if($guardar==1 and $codigo!=0) { // RUTINA PARA  editar REGISTROS 

	if ($error==1) {
		header("Location: con_ingresos.php?confirmacion=2&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
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
function datos_completos()
{  
	if (document.getElementById('fecha').value == "" || document.getElementById('acumdeb').value == 0 || document.getElementById('acumcred').value == 0){
		return false;
	}
	else if( document.getElementById("acumdeb").value != document.getElementById("acumcred").value ){
		alert('El valor del debito debe ser igual al credito');
	}
	else
	{
		return true;
	}
}

//AGREGAR
function adicionar(){
	Agregar_html_facturacion();
	document.getElementById('CUENTA').value=0;
	document.getElementById('BENEFIC').value=0;
	document.getElementById('debito').value = 0;
	document.getElementById('credito').value = 0;
}
//

//LIMPIAR CAMPOS
function limpiar(){
	document.getElementById('CUENTA').options.length=0;
	document.getElementById('BENEFIC').options.length=0;
	document.getElementById('debito').value = 0;
	document.getElementById('credito').value = 0;
}
//
</script>
<script type="text/javascript" src="js/js.js"></script>
</head>
<body <?=$sis?>>
<div id="total">
<form  name="forma" id="forma" action="man_ingresos.php"  method="post">
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
   <td bgcolor="#FFF" >
   <table width="100%" height="30" border="0" cellspacing="0" cellpadding="0" align="center" > 
      <tr>
        <td width="5" height="30">&nbsp;</td>
        <td width="20" ><img src="imagenes/icoguardar.png" alt="Nuevo Registro" width="16" height="16" border="0" onClick="cambio_guardar()" style="cursor:pointer"/></td>
        <td width="61" class="ctablaform">Guardar</td>
        <td width="21" class="ctablaform"><a href="con_ingresos.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
        <td width="22" class="ctablaform">&nbsp;</td>
        <td width="70" class="ctablaform">&nbsp;</td>
        <td width="21" class="ctablaform"></td>
        <td width="60" class="ctablaform">&nbsp;</td>
        <td width="24" valign="middle" class="ctablaform">&nbsp;</td>
        <td width="193" valign="middle">
          <input type="hidden" name="editar"   id="editar"   value="<?=$editar?>">
		  <input type="hidden" name="insertar" id="insertar" value="<?=$insertar?>">
		  <input type="hidden" name="eliminar" id="eliminar" value="<?=$eliminar?>">
          <input type="hidden" name="codigo" id="codigo" value="<?=$codigo?>" /> </td>
        
        <td width="67" valign="middle">&nbsp;</td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td height="4" valign="bottom"><img src="imagenes/lineasup3.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td class="textotabla01">CONTABILIZACION FACTURAS:</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td bgcolor="#FFF" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td width="76" class="textotabla1">Fecha:</td>
         <td width="208">
           <input name="fecha" type="text" class="fecha" id="fecha" readonly="1" value="<?=$dbdatos->fec_ment ?>" />
           <img src="imagenes/date.png" alt="Calendario" name="calendario" width="16" height="16" border="0" id="calendario" style="cursor:pointer"/></td>
         <td width="15" class="textorojo">*</td>
         <td width="118" class="textotabla1" valign="top">No documento:</td>
         <td width="305"><input name="num_doc" type="text" class="caja_resalte1" id="num_doc" onkeypress="return validaInt_evento(this)" value="<?=$dbdatos->fac_ment?>"/></td>
         <td width="28">&nbsp;</td>
       </tr>
	   <tr>
        <td colspan="6" class="textotabla1" >
		<table  width="100%" border="1">
        <? if ($codigo == 0) {?>         
          <tr >
            <td class="ctablasup"><div align="center">CUENTA</div></td>
            <td class="ctablasup"><div align="center">BENEFIC</div></td>
            <td class="ctablasup"><div align="center">DEBITO</div></td>
			<td class="ctablasup"><div align="center">CREDITO</div></td>
			<td width="8%" class="ctablasup" align="center">Agregar:</td>
          </tr>
          <tr>
            <td><? combo_evento_where("CUENTA","maecta","CUENTA","CONCAT(CUENTA,' ',NOMBRE)","",""," where ESTADO = 1")?></td>
            <td><? combo_evento_where("BENEFIC","maeben","BENEF","CONCAT(BENEF,' ',NOM)","",""," where ESTADO = 1 AND CLAS = 'D'")?></td>
            <td><input name="debito" type="text" class="caja_resalte1" id="debito" onkeypress="return validaInt_evento(this,'valor')"/></td>
			<td><input name="credito" type="text" class="caja_resalte1" id="credito" onkeypress="return validaInt_evento(this,'cantidad')"/></td>
		    <td align="center"><input id="mas" type='button'  class='botones' value='  +  '  onclick="adicionar()"></td>
          </tr>
		  <? } ?>    
		  <tr >
		  <td  colspan="9">
			<table width="100%">
			  <tr id="fila_0">
            <td class="ctablasup"><div align="center">CUENTA</div></td>
            <td class="ctablasup"><div align="center">BENEFIC</div></td>
            <td class="ctablasup"><div align="center">DEBITO</div></td>
			<td class="ctablasup"><div align="center">CREDITO</div></td>
                <? if ($codigo == 0) {?>
				<td width="12%" class="ctablasup" align="center">Borrar:</td>
                <? } ?>
				</tr>
				<?
				if ($codigo!=0) { // BUSCAR DATOS
					$sql =" SELECT *,CONCAT(REFER,' ',ARTICULO,' ',MEDIDA) AS producto FROM d_entrada
					INNER JOIN maeref ON maeref.cod_refer = d_entrada.cod_ref_dent 
					WHERE cod_ment_dent=$codigo order by cod_dent ";//=		
					$dbdatos_1= new  Database();
					$dbdatos_1->query($sql);
					$jj=1;

					while($dbdatos_1->next_row()){ 
						echo "<tr id='fila_$jj'>";
												
						//referencia
						echo "<td  ><INPUT type='hidden'  name='referencia_$jj' value='$dbdatos_1->cod_ref_dent'><span  class='textfield01'>$dbdatos_1->producto</span> </td>";
						
						//valor unitario
						echo "<td align='right'><INPUT type='hidden'  name='valor_$jj' value='$dbdatos_1->val_uni'><span  class='textfield01'>".number_format($dbdatos_1->val_uni ,0,",",".")."  </span> </td>";
																		
						//cantidad
						echo "<td align='right'><INPUT type='hidden'  name='cantidad_$jj' value='$dbdatos_1->cant_dent'><span  class='textfield01'>".number_format($dbdatos_1->cant_dent ,0,",",".")."  </span> </td>";	
						
						//valor total
						echo "<td align='right'><INPUT type='hidden'  name='val_tot_$jj' value='$dbdatos_1->val_tot'><span  class='textfield01'>".number_format($dbdatos_1->val_tot ,0,",",".")."  </span> </td>";	
						
						//boton q quita la fila
					    if ($codigo == 0) {
						echo "<td><div align='center'>	
<INPUT type='button' class='botones' value='  -  ' onclick='removerFila_entrada(\"fila_$jj\",\"val_inicial\",\"fila_\",\"$dbdatos_1->cos_dent\");'>
						</div></td>";
						}
						echo "</tr>";
						$jj++;
					}
				}
				?>
				</table>			</td>
			</tr>			
		 <tr >
		  <td  colspan="9">
			  <table width="100%">
				<tr>
					<td  class="ctablasup"><div align="right">Resumen Entrada </div></td>
				</tr>
				<tr>
					<td><div align="right" >ACUMDEB:<input name="acumdeb" id="acumdeb" type="text" class="textfield01" readonly="1" value="<? if($codigo !=0) echo $dbdatos->total_ment; else echo "0"; ?>"/></div></td>
				</tr>
				<tr>
					<td><div align="right" >ACUMCRED:<input name="acumcred" id="acumcred" type="text" class="textfield01" readonly="1" value="<? if($codigo !=0) echo $dbdatos->total_ment; else echo "0"; ?>"/></div></td>
				</tr>
			  </table>
			</td>
			</tr>
		</table>	
		  </table>
	    </td>
		 </tr>
	  <tr> 
		  <td colspan="8" >		  </td>
		  </tr>
    </table>
<tr>
  <tr>
    <td>
	<input type="hidden" name="val_inicial" id="val_inicial" value="<? if($codigo!=0) echo $jj-1; else echo "0"; ?>" />
	<input type="hidden" name="guardar" id="guardar" />
		 <?  if ($codigo!="") $valueInicial = $aa; else $valueInicial = "1";?>
	   <input type="hidden" id="valDoc_inicial" value="<?=$valueInicial?>"> 
	   <input type="hidden" name="cant_items" id="cant_items" value=" <?  if ($codigo!="") echo $aa; else echo "0"; ?>">
	</td>
  </tr>
</table>
</form> 
</div>
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
<div  id="relacion" align="center" style="display:none" >
<!-- <div  id="relacion" align="center" >-->
<table width="413" border="0" cellspacing="0" cellpadding="0" bgcolor="#D1D8DE" align="center">
   <tr id="pongale_0" >
    <td width="81" class="textotabla1"><strong>Referncia:</strong></td>
    <td width="332" class="textotabla1"><strong id="serial_nombre_"> </strong>
      <input type="hidden" name="textfield3"  id="ref_serial_"/>
	  <input type="hidden" name="textfield3"  id="campo_guardar"/>
	  </td>
   </tr>
   <tr>
     <td class="textotabla1" colspan="2"><div align="center">
       <input type="button" name="Submit" value="Guardar"  onclick="guardar_serial()"/>  
	    <input type="button" name="Submit" value="Cancelar"  onclick="limpiar()" id="cancelar" />  
       <input type="hidden" name="textfield32"  id="catidad_seriales" value="0"/>
     </div></td>
   </tr>
</table>
</div>
</body>
</html>