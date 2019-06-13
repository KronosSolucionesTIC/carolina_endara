<?php include("lib/database.php");?>
<?php include("js/funciones.php");?>
<?php

//RECIBE LAS VARIABLES
$codigo = $_REQUEST['codigo'];
$guardar = $_REQUEST['guardar'];
$insertar = $_REQUEST['insertar'];
$eliminar = $_REQUEST['eliminar'];
$editar = $_REQUEST['editar'];
$vendedor = $_SESSION['global_2'];
$bodega_entrada = $_REQUEST['bodega_entrada'];
$bodega_salida = $_REQUEST['bodega_salida'];

if ($codigo >0) { // BUSCAR DATOS
	 $sql =" SELECT * , (SELECT nom_bod FROM bodega WHERE cod_bod=cod_bod_sal_tras) AS bodega_salida, (SELECT nom_bod FROM bodega WHERE cod_bod=cod_bod_ent_tras) AS bodega_entrada FROM m_traslado WHERE cod_tras=$codigo";		
	$dbdatos= new  Database();
	$dbdatos->query($sql);
	$dbdatos->next_row();
	
	if(empty($bodega_salida) )
	$bodega_salida=$dbdatos->cod_bod_sal_tras;
}



if($guardar==1 and $codigo==0) 	{ // RUTINA PARA  INSERTAT REGISTROS NUEVOS
	$compos="(fec_tras,cod_bod_sal_tras,cod_bod_ent_tras,obs_tras,estado_m_traslado,cod_usu_tras)";
	$valores="('".$_REQUEST['fecha']."','".$_REQUEST['bodega_salida']."','".$_REQUEST['bodega_entrada']."','".$_REQUEST['observaciones']."','1','".$_REQUEST['vendedor']."')" ;
	$ins_id=insertar_maestro("m_traslado",$compos,$valores); 	
		
	if ($ins_id > 0) 
	{
		$compos="(cod_mtras_dtra,cod_tpro_dtra,cod_mar_dtra,cod_ref_dtra,cant_dtra)";
		
		for ($ii=1 ;  $ii <= $_REQUEST['val_inicial'] + 1 ; $ii++) 
		{
			if($_REQUEST["codigo_tipo_prodcuto_".$ii]!=NULL) 
			{
				$valores="('".$ins_id."','".$_REQUEST["codigo_tipo_prodcuto_".$ii]."','".$_REQUEST["codigo_marca_".$ii]."','".$_REQUEST["codigo_referencia_".$ii]."','".$_REQUEST["cantidad_ref_".$ii]."')" ;	
				$error=insertar("d_traslado",$compos,$valores); 

				kardex("resta",$_REQUEST["codigo_referencia_".$ii],$bodega_salida,$_REQUEST["cantidad_ref_".$ii],$_REQUEST["costo_ref_".$ii]);
				if($linea != 2){
					kardex("suma",$_REQUEST["codigo_referencia_".$ii],$bodega_entrada,$_REQUEST["cantidad_ref_".$ii],$_REQUEST["costo_ref_".$ii]);
				}
				$todocompra = $todocompra + $_REQUEST["cantidad_ref_".$ii];
			}	
		
		}
		
		if($linea == 2){
			//INGRESO DE LA ENTRADA
			$campos="(fec_ment,fac_ment,obs_ment,cod_bod,total_ment,cod_prove_ment,usu_ment,estado_m_entrada)";
			$valores="('".date('Y-m-d')."','','CONVERSION TRASLADO No "."$ins_id','".$bodega_entrada."','".$todocompra."','','".$vendedor."','1')" ; 
			$ins_id=insertar_maestro("m_entrada",$campos,$valores); 
		
			$dbg = new Database();
			$sqlg = "SELECT * FROM grupo";
			$dbg->query($sqlg);
			while ($dbg->next_row()){
				$cantidad = 0;
				for ($ii=1 ;  $ii <= $_REQUEST['val_inicial'] + 1 ; $ii++) 
				{
					$campos="(cod_ment_dent,cod_tpro_dent,cod_mar_dent,cod_pes_dent,cod_ref_dent,cant_dent,cos_dent)";
				
					if($_REQUEST["cod_linea_".$ii]== $dbg->cod_grupo) 
					{
							$cantidad = $cantidad + $_REQUEST["cantidad_ref_".$ii];
					}
				
				}	
					
					if($cantidad > 0){
						echo "<script language='javascript'> alert('ENTRO') </script>" ; 
						$dbp = new Database();
						$sqlp = "SELECT * FROM producto
						WHERE cod_pro = $dbg->cod_pro";
						$dbp->query($sqlp);
						$dbp->next_row();
						
						$tipo = $dbp->cod_tpro_pro;
						$marca = $dbp->cod_mar_pro;
						$cod_pro = $dbg->cod_pro;
						if($dbg->cod_grupo == 1){
							$cantidad = $cantidad * 12;
						}
						if($dbg->cod_grupo == 2){
							$cantidad = $cantidad / 2;
						}
						$valores="('".$ins_id."','".$tipo."','".$marca."','1','".$cod_pro."','".$cantidad."','".$cantidad."')" ;
						$error=insertar("d_entrada",$campos,$valores); 
						
						kardex("suma",$cod_pro,$bodega_entrada,$cantidad,0,1);
						
						$total_cant = $total_cant + $cantidad;
					}
				$compos="total_ment='".$total_cant."'";
				$error=editar("m_entrada",$compos,'cod_ment',$ins_id);
					
			}
		
		}
		header("Location: con_traslado.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	}

else
	echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 		
}


if($guardar==1 and $codigo!=0) { // RUTINA PARA  editar REGISTROS 
	
	$compos="fec_tras='".$_REQUEST['fecha']."',  obs_tras='".$_REQUEST['observaciones']."' ";
	
	$error=editar("m_traslado",$compos,'cod_tras',$codigo); 
	
	$sql="select * from  d_traslado  where cod_mtras_dtra=$codigo ";
	$dbser= new  Database();	
	$dbser->query($sql);
	while($dbser->next_row())
	{			
		kardex("resta",$dbser->cod_ref_dtra,$bodega_entrada,$dbser->cant_dtra,"",$dbser->cod_pes_dtra);
		kardex("suma",$dbser->cod_ref_dtra,$bodega_salida,$dbser->cant_dtra,"",$dbser->cod_pes_dtra);
	}

	$sql="DELETE from  d_traslado  where cod_mtras_dtra=$codigo ";
	$dbser->query($sql);

	$compos="(cod_mtras_dtra,cod_tpro_dtra,cod_mar_dtra,cod_ref_dtra,cant_dtra)";		
	for ($ii=1 ;  $ii <= $_REQUEST['val_inicial'] + 1 ; $ii++) 
	{
		if($_REQUEST["codigo_tipo_prodcuto_".$ii]!=NULL) 
		{
			$valores="('".$codigo."','".$_REQUEST["codigo_tipo_prodcuto_".$ii]."','".$_REQUEST["codigo_marca_".$ii]."','".$_REQUEST["codigo_referencia_".$ii]."','".$_REQUEST["cantidad_ref_".$ii]."')" ;
			$error=insertar("d_traslado",$compos,$valores); 
			
			kardex("resta",$_REQUEST["codigo_referencia_".$ii],$bodega_salida,$_REQUEST["cantidad_ref_".$ii],$_REQUEST["costo_ref_".$ii]);
			kardex("suma",$_REQUEST["codigo_referencia_".$ii],$bodega_entrada,$_REQUEST["cantidad_ref_".$ii],$_REQUEST["costo_ref_".$ii]);
		}	
	}
		
	if ($error==1) {
		header("Location: con_traslado.php?confirmacion=2&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
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
//CARGA EL TIPO DEL PRODUCTO
function cargar_tipo_producto(categoria,tipo_producto,bodega){
var combo=document.getElementById(tipo_producto);
combo.options.length=0;
var cant=0;
combo.options[cant] = new Option('Seleccione','0'); 
cant++;
<?
		$sqltp ="SELECT * FROM tipo_producto";		
		$dbtp= new  Database();
		$dbtp->query($sqltp);
		while($dbtp->next_row()){ 
		echo "if(document.getElementById(categoria).value==$dbtp->cod_marca) {";
		echo "combo.options[cant] = new Option('$dbtp->nom_tpro','$dbtp->cod_tpro');";
		echo "cant++; } ";
		}
?> 
}

//CARGA LA REFERENCIA DEL PRODUCTO
function cargar_referencia(tipo_producto,referencia,bodega){
var combo=document.getElementById(referencia);
combo.options.length=0;
var cant=0;
combo.options[cant] = new Option('Seleccione','0'); 
cant++;
<?
		$sqlr ="SELECT * FROM kardex
		INNER JOIN producto ON (kardex.cod_ref_kar = producto.cod_pro)
		INNER JOIN tipo_producto ON (producto.cod_tpro_pro = tipo_producto.cod_tpro)
		WHERE cant_ref_kar > 0 AND cod_bod_kar = $bodega_salida 
		GROUP by  cod_pro";		
		$dbr= new  Database();
		$dbr->query($sqlr);
		while($dbr->next_row()){ 
		echo "if(document.getElementById(tipo_producto).value==$dbr->cod_tpro_pro) {";
		echo "combo.options[cant] = new Option('$dbr->nom_pro','$dbr->cod_ref_kar');";
		echo "cant++; } ";
		}
?> 
}

//CARGA EL ITEM, EL CODIGO DEL PRODUCTO Y LA TALLA
function cargar_codigo_talla(referencia,codigo,codigo_producto,cod_linea,bodega,valor_lista){
var item_articulo = "";
var codigo_articulo = "";
var codigo_linea = "";
<?
		$sqlcod ="SELECT * FROM kardex
		INNER JOIN producto ON (kardex.cod_ref_kar = producto.cod_pro)";		
		$dbcod= new  Database();
		$dbcod->query($sqlcod);
		while($dbcod->next_row()){ 
		echo "if(document.getElementById(referencia).value==$dbcod->cod_ref_kar && document.getElementById(bodega).value==$dbcod->cod_bod_kar && $dbcod->cant_ref_kar > 0) {";	
		echo "codigo_articulo = '$dbcod->cod_pro'; ";
		echo "codigo_linea = '$dbcod->cod_gru_pro'; ";
		echo "item_articulo = '$dbcod->cod_fry_pro'; }";
		}
?>
document.getElementById(codigo_producto).value= codigo_articulo;
document.getElementById(codigo).value= item_articulo;
document.getElementById(cod_linea).value= codigo_linea;
}

function datos_completos()
{  

	if (document.getElementById('fecha').value == "" )
		return false;
	else
		return true;		

}

function  adicion() 
{
	
	if(document.getElementById('marca').value < 1 || document.getElementById('tipo_producto').value < 1 || document.getElementById('combo_referncia').value < 1  || document.getElementById('cantidad').value=="" ) 
	{
		alert("Datos Incompletos")
		return false;
	}
	
	if(document.getElementById("cantidad").value>0 && document.getElementById("codigo_fry").value > ""  && document.getElementById('combo_referncia').value > 0) 
	{

		Agregar_html_traslado();					
		limpiar_combos();
		document.getElementById('marca').value=0;
		document.getElementById("codigo_fry").focus();
		return false;
		
	}
	else {
		alert("Ingrese una Referencia Valida junto con los demas Valores")
		document.getElementById("codigo_fry").focus();
	}
	
}




function enfocar(obj_ini,obj_fin){
if(window.event.keyCode==13)
{
  window.event.keyCode=0;
  document.getElementById(obj_fin).focus();
  return false;
}
}


function limpiar_combos()
{
	document.getElementById('tipo_producto').options.length=0;
	document.getElementById('combo_referncia').options.length=0;
	document.getElementById('codigo_fry').value="";
	document.getElementById('cantidad').value="";

return false;
}

//CARGA TODA LA INFORMACION CON EL ITEM
function cargar_articulo(categoria,tipo_producto,referencia,codigo,codigo_producto,bodega,valor_lista){
	
//CARGA LA CATEGORIA
var combo=document.getElementById(categoria);
<?
		$sqltd ="SELECT cod_fry_pro,cod_mar FROM `producto`
		INNER JOIN marca ON (marca.cod_mar = producto.cod_mar_pro)";		
		$dbtd= new  Database();
		$dbtd->query($sqltd);
		while($dbtd->next_row()){ 
		echo "if(document.getElementById(codigo).value =='$dbtd->cod_fry_pro'){";
		echo "valor = '$dbtd->cod_mar';}";	
		}
?>
var cant = combo.options.length; 
for (i=0; i<=cant; i++){
if(combo[i].value == valor){
combo[i].selected = true;
	
	//CARGA EL TIPO DEL PRODUCTO
	cargar_tipo_producto(categoria,tipo_producto,bodega)	
	var combo=document.getElementById(tipo_producto);
	<?
		$sqltp ="SELECT cod_fry_pro,cod_tpro FROM `producto`
		INNER JOIN tipo_producto ON (tipo_producto.cod_tpro = producto.cod_tpro_pro)";		
		$dbtp= new  Database();
		$dbtp->query($sqltp);
		while($dbtp->next_row()){ 	
		echo "if(document.getElementById(codigo).value=='$dbtp->cod_fry_pro') {";
		echo "valor = '$dbtp->cod_tpro';}";
		}
	?>
	var cant = combo.options.length;
	for (i=0; i<=cant; i++){
	if(combo[i].value == valor){
	combo[i].selected = true;
		
		//CARGA LA REFERENCIA
		cargar_referencia(tipo_producto,referencia,bodega)
		var combo=document.getElementById(referencia);
		<?
			$sqlr ="SELECT cod_fry_pro,cod_pro FROM `producto`";		
			$dbr= new  Database();
			$dbr->query($sqlr);
			while($dbr->next_row()){ 	
			echo "if(document.getElementById(codigo).value=='$dbr->cod_fry_pro') {";
			echo "valor = '$dbr->cod_pro';}";
			}
		?>
		var cant = combo.options.length;
		for (i=0; i<=cant; i++){
		if(combo[i].value == valor){
		combo[i].selected = true;
		cargar_codigo_talla(referencia,codigo,codigo_producto,bodega,valor_lista)
		return true;
		}
		}
	}
	}
}
}
}
</script>

<script type="text/javascript" src="js/js.js"></script>
</head>
<body <?php echo $sis?>>
<div id="total">
<form  name="forma" id="forma" action="man_traslado.php"  method="post">
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
   <td bgcolor="#D1D8DE" >
   <table width="100%" height="30" border="0" cellspacing="0" cellpadding="0" align="center" > 
      <tr>
        <td width="5" height="30">&nbsp;</td>
        <td width="20" ><img src="imagenes/icoguardar.png" alt="Nuevo Registro" width="16" height="16" border="0" onClick="cambio_guardar()" style="cursor:pointer"/></td>
        <td width="61" class="ctablaform">Guardar</td>
        <td width="21" class="ctablaform"><a href="con_cargue.php?confirmacion=0&editar=<?php echo $editar?>&insertar=<?php echo $insertar?>&eliminar=<?php echo $eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
        <td width="21" class="ctablaform"></td>
        <td width="60" class="ctablaform">&nbsp;</td>
        <td width="24" valign="middle" class="ctablaform">&nbsp;</td>
        <td width="193" valign="middle">
          <input type="hidden" name="editar"   id="editar"   value="<?php echo $editar?>">
		  <input type="hidden" name="insertar" id="insertar" value="<?php echo $insertar?>">
		  <input type="hidden" name="eliminar" id="eliminar" value="<?php echo $eliminar?>">
          <input type="hidden" name="codigo" id="codigo" value="<?php echo $codigo?>" />
          <input type="hidden" name="bodega_salida" id="bodega_salida" value="<?php echo $bodega_salida?>" /></td>
        
        <td width="67" valign="middle">&nbsp;</td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td height="4" valign="bottom"><img src="imagenes/lineasup3.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td class="textotabla01">TRASLADO INVENTARIO :</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td bgcolor="#D1D8DE" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
        <td width="50" class="textotabla1">Fecha:</td>
        <td width="164">
          <input name="fecha" type="text" class="fecha" id="fecha" readonly="1" value="<?php echo $dbdatos->fec_tras ?>" />
          <img src="imagenes/date.png" alt="Calendario" name="calendario" width="16" height="16" border="0" id="calendario" style="cursor:pointer"/></td>
        <td width="8" class="textorojo">*</td>
        <td width="93" rowspan="3" class="textotabla1" valign="top">Observaicones:</td>
        <td rowspan="3">
		  <textarea name="observaciones" cols="45" rows="4" class="textfield02"  ><?php echo $dbdatos->obs_tras?></textarea></td>
        </tr>
      
       <tr>
         <td class="textotabla1">Bodega Salida </td>
         <td><span class="textotabla1">
           <?php 
		   $dbdatos333= new  Database();
		   
		 if ($codigo > 0 ) {
			echo "$dbdatos->bodega_salida <input name='bodega_salida' type='hidden' id='bodega_salida' value='$dbdatos->cod_bod_sal_tras' />";
			
			}
		 else {
			$sql ="select * from bodega where cod_bod=$bodega_salida "; 
			$dbdatos333->query($sql);
			while($dbdatos333->next_row()){
				echo "$dbdatos333->nom_bod <input name='bodega_salida' type='hidden' id='bodega_salida' value='$bodega_salida' />";
				}
			}
			 ?>
         </span></td>
         <td><span class="textorojo">*</span></td>
         </tr>
       
	         <tr>
         <td class="textotabla1">Bodega Entrada </td>
         <td class="textotabla1">
		 
		 <?php 
		 if ($codigo > 0 ) 
		 	echo "$dbdatos->bodega_entrada<input name='bodega_entrada' type='hidden' id='bodega_entrada' value='$dbdatos->cod_bod_ent_tras'/>";
		 else   {
		 	$sql ="select * from bodega where cod_bod=$bodega_entrada "; 
			$dbdatos333->query($sql);
			while($dbdatos333->next_row()){
				$linea = $dbdatos333->cod_linea;
				echo "$dbdatos333->nom_bod  $linea <input name='linea' type='hidden' value='$linea' /><input name='bodega_entrada' type='hidden' id='bodega_salida' value='$bodega_entrada' />";
				}
			}
			?>
			</td>
         
		 
		 <td><span class="textorojo">*</span></td>
         </tr>
       
	   
	   <tr>
        <td colspan="5" class="textotabla1" >
		<table  width="99%" border="1">
         
          <tr>
            <td  class="ctablasup">Categoria</td>
            <td  class="ctablasup">Tipo Producto </td>
			<td  class="ctablasup">Referencia</td>
            <td  class="ctablasup">Codigo</td>
            <td   class="ctablasup">Cantidad</td>
			<td width="4%" class="ctablasup" align="center">Agregar:</td>
          </tr>
          <tr >
            <td ><?php 
  			$sql="SELECT cod_mar_pro,nom_mar  FROM kardex 
			INNER JOIN producto ON (kardex.cod_ref_kar = producto.cod_pro)  
 			INNER JOIN marca ON (producto.cod_mar_pro = marca.cod_mar)
			WHERE  cod_bod_kar = $bodega_salida AND cant_ref_kar > 0
			GROUP BY  kardex.cod_bod_kar, cod_mar_pro ";
			combo_sql_evento("marca","","cod_mar_pro","nom_mar","",$sql," onchange=\"cargar_tipo_producto('marca','tipo_producto','bodega_salida') \"");  ?></td>
			<td ><select size="1" id="tipo_producto" name="tipo_producto" class='SELECT' onchange="cargar_referencia('tipo_producto','combo_referncia','bodega_salida') " >
			  </select></td>
			<td align="center"><select size="1" id="combo_referncia" name="combo_referncia"  class='SELECT'  onchange="cargar_codigo_talla('combo_referncia','codigo_fry','codigo_producto','cod_linea','bodega_salida','valor_lista')">
			  </select>			  <input name="text" type="hidden" id="codigo_producto" />
			  <input name="cod_linea" type="hidden" id="cod_linea" /></td>
			 <td align="center"><input name="codigo_fry" id="codigo_fry" type="text" class="caja_resalte1" onkeypress=" return valida_evento(this)"  onchange="cargar_articulo('marca','tipo_producto','combo_referncia','codigo_fry','codigo_producto','bodega','valor_lista')" ></td>
			 <td align="center"><input name="cantidad" type="text" class="caja_resalte" id="cantidad" onkeypress="return validaInt_evento(this,'mas')"/></td>
			 <td align="center"> 
			 <input id="mas" type='button'  class='botones' value='  +  '  onclick="adicion()">			 </td>
          </tr>
		      
		  <tr >
		  <td  colspan="8">
		  
		  
		  
			  <table width="100%">
				<tr id="fila_0">

				<td  class="ctablasup">Tipo Producto </td>
				<td  class="ctablasup">Categoria</td>
				<td  class="ctablasup">Referencia:</td>
				<td  class="ctablasup">Codigo</td>
				<td   class="ctablasup">Cantidad:              </td>
				
				<td width="4%" class="ctablasup" align="center">Borrar:</td>
				</tr>
				<?
				if ($codigo!="") { // BUSCAR DATOS
					$sql =" SELECT * FROM d_traslado LEFT JOIN tipo_producto ON tipo_producto.cod_tpro=d_traslado.cod_tpro_dtra LEFT JOIN marca ON marca.cod_mar=d_traslado.cod_mar_dtra LEFT JOIN producto ON producto.cod_pro=d_traslado.cod_ref_dtra WHERE cod_mtras_dtra=$codigo  ORDER BY cod_dtra ";//=		
					$dbdatos_1= new  Database();
					$dbdatos_1->query($sql);
					$jj=1;
					//echo "<table width='100%'>";
					while($dbdatos_1->next_row()){ 
						echo "<tr id='fila_$jj'>";
						//tipo de producto
						echo "<td><INPUT type='hidden'  name='codigo_tipo_prodcuto_$jj' value='$dbdatos_1->cod_tpro_dtra'><span  class='textfield01'> $dbdatos_1->nom_tpro </span> </td>";
						
						//cmarca
						echo "<td  ><INPUT type='hidden'  name='codigo_marca_$jj' value='$dbdatos_1->cod_mar_dtra'><span class='textfield01'> $dbdatos_1->nom_mar </span> </td>";	
												
						//referencia
						echo "<td  ><INPUT type='hidden'  name='codigo_referencia_$jj' value='$dbdatos_1->cod_ref_dtra'><span  class='textfield01'> $dbdatos_1->nom_pro </span> </td>";
						
						//% codigo barra
						echo "<td ><INPUT type='hidden'  name='codigo_fry_$jj' value='$dbdatos_1->cod_fry_pro'><span  class='textfield01'> $dbdatos_1->cod_fry_pro </span> </td>";
						
						//cantidad
						echo "<td align='right'><INPUT type='hidden'  name='cantidad_ref_$jj' value='$dbdatos_1->cant_dtra'><span  class='textfield01'>".number_format($dbdatos_1->cant_dtra ,0,",",".")."  </span> </td>";	
						
						//boton q quita la fila
						echo "<td><div align='center'>	
<INPUT type='button' class='botones' value='  -  ' onclick='removerFila_entrada(\"fila_$jj\",\"val_inicial\",\"fila_\",\"0\");'>
						</div></td>";
						echo "</tr>";
						$jj++;
					}
				}
				?>
				</table>			</td>
			</tr>
			
		 <tr >
		  <td  colspan="8">
		  <div style="display:none">
			  <table width="100%">
				<tr >
				<td  class="ctablasup"><div align="right">Resumen de Compra</div></td>
				</tr>
				<tr >
				<td ><div align="right" >Total  Compra:
				    <input name="todocompra" id="todocompra" type="text" class="textfield01" readonly="1" value="<?php if($codigo !=0) echo $dbdatos->total_ment; else echo "0"; ?>"/>
                    <textarea name="tipo_referencias"  id="tipo_referencias"   cols="45" rows="4" style="display:inline" ></textarea>
				</div>				  </td>
				</tr>
				</table>			
		</div>
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
    <td width="81" class="textotabla1"><strong>Referencia:</strong></td>
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