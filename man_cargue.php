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

//CONSULTA CONSECUTIVO DE ENTRADAS
if($codigo == 0){
	$db = new database();
	$sql = "SELECT cod_ment FROM m_entrada ORDER BY cod_ment DESC limit 1";
	$db->query($sql);
	$db->next_row();
	$conse = $db->cod_ment;
}

if ($codigo!=0) { // BUSCAR DATOS

	$sql ="SELECT  *  FROM m_entrada 
	inner join bodega on bodega.cod_bod=m_entrada.cod_bod 
	WHERE cod_ment=$codigo";		
	$dbdatos= new  Database();
	$dbdatos->query($sql);
	$dbdatos->next_row();
}

if($guardar==1 and $codigo==0) 	{ // RUTINA PARA  INSERTAR REGISTROS NUEVOS

	$compos="(fec_ment,fac_ment,obs_ment,cod_bod,total_ment,cod_prove_ment,usu_ment,estado_m_entrada)";
	$valores="('".$_REQUEST['fecha']."','".$_REQUEST['num_fac']."','".$_REQUEST['observaciones']."','".$_REQUEST['bodega']."','".$_REQUEST['todocompra']."','".$_REQUEST['proveedor']."','".$vendedor."','1')" ; 
	$ins_id=insertar_maestro("m_entrada",$compos,$valores); 	
		
	if ($ins_id > 0) 
	{
		$compos="(cod_ment_dent,cod_tpro_dent,cod_mar_dent,cod_ref_dent,cant_dent,cos_dent)";
		
		for ($ii=1 ;  $ii <= $val_inicial + 1 ; $ii++) 
		{
			if($_REQUEST["codigo_tipo_prodcuto_".$ii]!=NULL) 
			{
				$valores="('".$ins_id."','".$_REQUEST["codigo_tipo_prodcuto_".$ii]."','".$_REQUEST["codigo_marca_".$ii]."','".$_REQUEST["codigo_referencia_".$ii]."','".$_REQUEST["cantidad_ref_".$ii]."','".$_REQUEST["costo_ref_".$ii]."')" ;
				$error=insertar("d_entrada",$compos,$valores); 
				kardex("suma",$_REQUEST["codigo_referencia_".$ii],$bodega,$_REQUEST["cantidad_ref_".$ii],$_REQUEST["costo_ref_".$ii]);
			}	
		}
		header("Location: con_cargue.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	}

else
	echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 	
	
}


if($guardar==1 and $codigo!=0) { // RUTINA PARA  editar REGISTROS 
	
	$campos="fac_ment='".$_REQUEST['num_fac']."'";
	$error=editar("m_entrada",$campos,'cod_ment',$codigo); 


	if ($error==1) {
		header("Location: con_cargue.php?confirmacion=2&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
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
function cargar_tipo_producto(categoria,tipo_producto){
var combo=document.getElementById(tipo_producto);
combo.options.length=0;
var cant=0;
combo.options[cant] = new Option('Seleccione','0'); 
cant++;
<?
		$sqltp ="SELECT cod_marca,nom_tpro,cod_tpro FROM tipo_producto
		INNER JOIN marca ON marca.cod_mar = tipo_producto.cod_marca
		ORDER BY nom_tpro";		
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
function cargar_referencia(tipo_producto,referencia){
var combo=document.getElementById(referencia);
combo.options.length=0;
var cant=0;
combo.options[cant] = new Option('Seleccione','0'); 
cant++;
<?
		$sqlr ="SELECT cod_pro,nom_pro,cod_tpro_pro FROM producto
		INNER JOIN tipo_producto ON tipo_producto.cod_tpro = producto.cod_tpro_pro
		ORDER BY nom_pro";		
		$dbr= new  Database();
		$dbr->query($sqlr);
		while($dbr->next_row()){ 
		echo "if(document.getElementById(tipo_producto).value==$dbr->cod_tpro_pro) {";
		echo "combo.options[cant] = new Option('$dbr->nom_pro','$dbr->cod_pro');";
		echo "cant++; } ";
		}
?> 
}

//CARGA EL ITEM, EL CODIGO DEL PRODUCTO
function cargar_codigo_talla(referencia,codigo,codigo_producto){
//CARGA EL ITEM Y EL CODIGO DEL PRODUCTO
var item_articulo = "";
var codigo_articulo = "";
<?
		$sqlcod ="SELECT cod_pro,cod_fry_pro FROM producto";		
		$dbcod= new  Database();
		$dbcod->query($sqlcod);
		while($dbcod->next_row()){ 
		echo "if(document.getElementById(referencia).value==$dbcod->cod_pro) {";	
		echo "codigo_articulo = '$dbcod->cod_pro'; ";
		echo "item_articulo = '$dbcod->cod_fry_pro'; }";
		}
?>
document.getElementById(codigo_producto).value= codigo_articulo;
document.getElementById(codigo).value= item_articulo;
}

function datos_completos()
{  
	if (document.getElementById('fecha').value == "" || document.getElementById('bodega').value == "" )
		return false;
	else
		return true;		

}

function  adicion() 
{
	if(document.getElementById("cantidad").value>0 && document.getElementById("codigo_fry").value > ""  && document.getElementById('combo_referncia').value > 0 ) 
	{
	
		Agregar_html_entrada();		
		document.getElementById('tipo_producto').options.length=0;
		document.getElementById('combo_referncia').options.length=0;
		document.getElementById("codigo_fry").value='';
		document.getElementById("cantidad").value='';
		document.getElementById("codigo_fry").focus();
		return false;
	}
	else 
	{
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
<form  name="forma" id="forma" action="man_cargue.php"  method="post">
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
   <td bgcolor="#D1D8DE" >
   <table width="100%" height="30" border="0" cellspacing="0" cellpadding="0" align="center" > 
      <tr>
        <td width="5" height="30">&nbsp;</td>
        <td width="20" ><img src="imagenes/icoguardar.png" alt="Nueno Registro" width="16" height="16" border="0" onClick="cambio_guardar()" style="cursor:pointer"/></td>
        <td width="61" class="ctablaform">Guardar</td>
        <td width="21" class="ctablaform"><a href="con_cargue.php?confirmacion=0&editar=<?php echo $editar?>&insertar=<?php echo $insertar?>&eliminar=<?php echo $eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
        <td width="22" class="ctablaform"></td>
        <td width="70" class="ctablaform"></td>
        <td width="21" class="ctablaform"></td>
        <td width="60" class="ctablaform">&nbsp;</td>
        <td width="24" valign="middle" class="ctablaform">&nbsp;</td>
        <td width="193" valign="middle">
          <input type="hidden" name="editar"   id="editar"   value="<?php echo $editar?>">
		  <input type="hidden" name="insertar" id="insertar" value="<?php echo $insertar?>">
		  <input type="hidden" name="eliminar" id="eliminar" value="<?php echo $eliminar?>">
          <input type="hidden" name="codigo" id="codigo" value="<?php echo $codigo?>" /> </td>
        
        <td width="67" valign="middle">&nbsp;</td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td height="4" valign="bottom"><img src="imagenes/lineasup3.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td class="textotabla01">CARGUE INVENTARIO No <?php echo $conse+1 ?>:</td>
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
        <?php if ($codigo == 0) {?>
          <input name="fecha" type="text" class="fecha" id="fecha" readonly="1" value="<?php echo $dbdatos->fec_ment ?>" />
        <?php } else {?>
           <input name="fecha" type="text" class="fecha" id="fecha" readonly="1" value="<?php echo $dbdatos->fec_ment ?>" disabled="disabled"/>
        <?php } ?>
          <img src="imagenes/date.png" alt="Calendario" name="calendario" width="16" height="16" border="0" id="calendario" style="cursor:pointer"/></td>
        <td width="8" class="textorojo">*</td>
        <td width="93" rowspan="2" class="textotabla1" valign="top">Observaciones:</td>
        <td rowspan="2">
		  <textarea name="observaciones" cols="45" rows="4" class="textfield02"  onchange='buscar_rutas()' ><?php echo $dbdatos->obs_ment?></textarea></td>
        </tr>
      
       <tr>
         <td class="textotabla1">Bodega</td>
         <td><span class="textotabla1">
           <?php 
		   
		 if ($codigo > 0 ) echo "$dbdatos->nom_bod <input name='bodega' type='hidden' id='bodega' value='$dbdatos->cod_bod' />";
		 
		 
		 else
		 	{
			
				$sql="select distinct punto_venta.cod_bod as valor , nom_bod as nombre from punto_venta  inner join  bodega  on punto_venta.cod_bod=bodega.cod_bod where cod_ven=$vendedor";
				 combo_sql("bodega","bodega","valor","nombre",$dbdatos->cod_bod,$sql); 
						
				//combo_evento_1("bodega","bodega","cod_bod","nom_bod",$dbdatos->cod_bod,"  ", "nom_bod",""); 
			} 
			  ?>
		 
		 
		 
         </span></td>
         <td>&nbsp;</td>
         </tr>
       
	         <tr>
         <td class="textotabla1">Factura No:</td>
         <td class="textotabla1"><input name="num_fac" type="text" class="caja_resalte1" id="num_fac" onkeypress="return validaInt_evento(this)" value="<?php echo $dbdatos->fac_ment?>"/></td>
         <td>&nbsp;</td>
         <td width="93" class="textotabla1" valign="top">Proveedor</td>
         <td>
		 <?php combo_evento("proveedor","proveedor","cod_pro","nom_pro",$dbdatos->cod_prove_ment," ", "nom_pro"); ?>
         </td>
            </tr>
	   <tr>
        <td colspan="5" class="textotabla1" >
		<table  width="99%" border="1">
        <?php if ($codigo == 0) {?>         
          <tr >
            <td  class="ctablasup">Categoria</td>
			<td  class="ctablasup">Tipo Producto </td>
            <td colspan="2"  class="ctablasup">Referencia</td>
			<td  class="ctablasup">&nbsp;Codigo</td>
            <td  class="ctablasup">Cantidad</td>
			<td width="4%" class="ctablasup" align="center">Agregar:</td>
          </tr>
          <tr >
            <td ><?php combo_evento("marca","marca","cod_mar","nom_mar",""," onchange=\"cargar_tipo_producto('marca','tipo_producto') \"","nom_mar");  ?></td>
			<td ><select size="1" id="tipo_producto" name="tipo_producto" class='SELECT' onchange="cargar_referencia('tipo_producto','combo_referncia') " >
			  </select></td>
            <td colspan="2" align="center"><select size="1" id="combo_referncia" name="combo_referncia"  class='SELECT'  onchange="cargar_codigo_talla('combo_referncia','codigo_fry','codigo_producto')">
            </select>              <input name="hidden" type="hidden" id="codigo_producto" value="0" /></td>
            <td align="center"><input name="codigo_fry" id="codigo_fry" type="text" class="caja_resalte1" onkeypress=" return valida_evento(this)"  onchange="cargar_articulo('marca','tipo_producto','combo_referncia','codigo_fry','codigo_producto','bodega','valor_lista')" /></td>
			 <td align="center">
			 <input name="cantidad" type="text" class="caja_resalte" id="cantidad" onkeypress="return validaInt_evento(this,'costo')"/>			 </td>
			 <td align="center"> 
			 <input id="mas" type='button'  class='botones' value='  +  '  onclick="adicion()">			 </td>
          </tr>
		  <?php } ?>    
		  <tr >
		  <td  colspan="9">
			  <table width="100%">
				<tr id="fila_0">
				<td  class="ctablasup">Categoria</td>
				<td  class="ctablasup">Tipo Producto </td>
				<td   class="ctablasup">Referencia</td>
				<td  class="ctablasup">Codigo</td>
				<td   class="ctablasup">Cantidad:              </td>
                <?php if ($codigo == 0) {?>
				<td width="4%" class="ctablasup" align="center">Borrar:</td>
                <?php } ?>
				</tr>
				<?
				if ($codigo!="") { // BUSCAR DATOS
					$sql =" SELECT * FROM d_entrada 
					INNER JOIN tipo_producto ON tipo_producto.cod_tpro=d_entrada.cod_tpro_dent
					INNER JOIN marca ON marca.cod_mar=d_entrada.cod_mar_dent
					INNER JOIN producto ON producto.cod_pro=d_entrada.cod_ref_dent 
					WHERE cod_ment_dent=$codigo order by cod_dent ";//=		
					$dbdatos_1= new  Database();
					$dbdatos_1->query($sql);
					$jj=1;
					//echo "<table width='100%'>";
					while($dbdatos_1->next_row()){ 
						echo "<tr id='fila_$jj'>";
						
						//cmarca
						echo "<td  ><INPUT type='hidden'  name='codigo_marca_$jj' value='$dbdatos_1->cod_mar_dent'><span class='textfield01'> $dbdatos_1->nom_mar </span> </td>";	
						
						//tipo de producto
						echo "<td><INPUT type='hidden'  name='codigo_tipo_prodcuto_$jj' value='$dbdatos_1->cod_tpro_dent'><span  class='textfield01'> $dbdatos_1->nom_tpro </span> </td>";
						
						//referencia
						echo "<td  ><INPUT type='hidden'  name='codigo_referencia_$jj' value='$dbdatos_1->cod_ref_dent'><span  class='textfield01'> $dbdatos_1->nom_pro </span> </td>";
						
						//% codigo barra
						echo "<td ><INPUT type='hidden'  name='codigo_fry_$jj' value='$dbdatos_1->cod_fry_pro'><span  class='textfield01'> $dbdatos_1->cod_fry_pro </span> </td>";
												
						//cantidad
						echo "<td align='right'><INPUT type='hidden'  name='cantidad_ref_$jj' value='$dbdatos_1->cant_dent'><span  class='textfield01'>".number_format($dbdatos_1->cant_dent ,0,",",".")."  </span> </td>";	
												
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
				<tr >
				<td  class="ctablasup"><div align="right">Resumen Entrada </div></td>
				</tr>
				<tr >
				<td ><div align="right" >Total  Compra:
				    <input name="todocompra" id="todocompra" type="text" class="textfield01" readonly="1" value="<?php if($codigo !=0) echo $dbdatos->total_ment; else echo "0"; ?>"/>
				</div>				  </td>
				</tr>
				</table>			</td>
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