<?php include("lib/database.php");?>
<?php include("js/funciones.php");?>
<?php 

//CONSULTA LA LISTA ACTIVA
$dbl = new database();
$sqll = "SELECT cod_lista FROM lista WHERE act_lista = 1";
$dbl->query($sqll);
if($dbl->next_row()){
	$lista_act = $dbl->cod_lista;
}

if($guardar==1) { // RUTINA PARA  INSERTAT REGISTROS NUEVOS
	$compos="act_lista='0'";
	$error=editar("lista",$compos,'estado_lista','1'); 

	$compos="act_lista='1'";
	$error=editar("lista",$compos,'cod_lista',$lista); 

	for($i = 1; $i <= $ultimo - 1; $i++){
		$compos="valor_pro='".$_REQUEST['precio1_'.$i]."',promo_pro='".$_REQUEST['precio2_'.$i]."',temp_pro='".$_REQUEST['precio3_'.$i]."'";
		$error=editar("producto",$compos,'cod_pro',$_REQUEST['producto_'.$i]);
	}

	if ($error==1) {
		header("Location: ver_lista.php?confirmacion=2&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	}
	else
		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 
}

?>
<link href="../css/styles.css" rel="stylesheet" type="text/css">
<script language="javascript">
function datos_completos(){  
	if (document.getElementById('lista').value == 0)    
		return false;
	else
		return true;		
}

function validaInt(){
	if (event.keyCode>47 & event.keyCode<58) {
		return true;
		}
	else{
		return false;
		}
}

//VALIDA QUE SE SELECCIONE SOLO UNA LISTA
function valida(){
	if(document.getElementById('standard').checked == true && document.getElementById('temporada').checked == true){
		alert('Seleccione solo  una lista');
		document.getElementById('standard').checked = false;
		document.getElementById('temporada').checked = false;
		document.getElementById('lista').value = 0;
	}else if(document.getElementById('standard').checked == true && document.getElementById('promo').checked == true){
		alert('Seleccione solo  una lista');
		document.getElementById('standard').checked = false;
		document.getElementById('promo').checked = false;
		document.getElementById('lista').value = 0;
	}else if(document.getElementById('temporada').checked == true && document.getElementById('promo').checked == true){
		alert('Seleccione solo  una lista');
		document.getElementById('temporada').checked = false;
		document.getElementById('promo').checked = false;
		document.getElementById('lista').value = 0;
	}else if(document.getElementById('standard').checked == true){
			document.getElementById('lista').value = 1;
	}else if (document.getElementById('temporada').checked == true){
			document.getElementById('lista').value = 2;
	}else if(document.getElementById('promo').checked == true){
			document.getElementById('lista').value = 3;
	}else{
			document.getElementById('lista').value = 0;
	}
}

//PORCENTUA
function porcentua(contador){
	if(document.getElementById('prod_por' + contador).checked == true){	
		var pr1 = parseInt(document.getElementById('precio1_' + contador).value) ;
		var porcentaje = parseInt(document.getElementById('porcentaje').value) ;
		//SACA PORCENTAJE
		por = porcentaje * pr1 / 100;
		val = pr1 - por;
		document.getElementById('precio3_' + contador).value = val;
	}else if (document.getElementById('prod_por' + contador).checked == false){
		pr3 = document.getElementById('precio1_' + contador).value ;
		document.getElementById('precio3_' + contador).value = pr3;
	}
}
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<script type="text/javascript" src="js/funciones.js"></script>
</head>
<body <?php echo $sis?>>
<FORM method="POST" action="ver_lista.php" id='forma' name='forma'>
<TABLE width="100%" border="1"  cellspacing="1" bgcolor="#F2F2F2" class="textotabla1">
<tr>
	<td colspan="11" align="center" class="ayuda">PARA BUSCAR UN PRODUCTO EN ESPECIFICO PRESION CTRL + F, Y DIGITE EL CODIGO</td>
</tr>
	<TR>	
		<TD  class="textotabla1"><div align="center">CODIGO</div></TD>
		<TD  class="textotabla1"><div align="center">CATEGORIA</div></TD>
		<TD  class="textotabla1"><div align="center">TIPO PRODUCTO</div></TD>
		<TD  class="textotabla1"><div align="center">REFERENCIA</div></TD>
		<TD  class="textotabla1"><div align="center">EXISTENCIAS</div></TD>
      	<TD  class="textotabla1"><div align="center">VALOR 1</div></TD>
      	<TD  class="textotabla1"><div align="center">
      		<?php if($lista_act == 1){ ?>
      			<input type="checkbox" name="standard" id='standard' onclick='valida()' value="1" checked >HABILITAR</div>
      		<?php } else {?>
      			<input type="checkbox" name="standard" id='standard' onclick='valida()' value="1">HABILITAR</div>
      		<?php } ?>
      	</TD>
        <TD  class="textotabla1"><div align="center">VALOR 2</div></TD>
        <TD  class="textotabla1"><div align="center">
			<?php if($lista_act == 2){ ?>
        		<input type="checkbox" name="temporada" id='temporada' onclick='valida()' value="1" checked>HABILITAR</div>
        	<?php } else {?>
        		<input type="checkbox" name="temporada" id='temporada' onclick='valida()' value="1">HABILITAR</div>
        	<?php } ?>	
        </TD>
        <TD  class="textotabla1"><div align="center">VALOR 3</div></TD>
        <TD  class="textotabla1"><div align="center">
        	<?php if($lista_act == 3){ ?>
        		<input type="checkbox" name="promo" id='promo' onclick='valida()' value="1" checked >HABILITAR</div>
        	<?php } else {?>
        		<input type="checkbox" name="promo" id='promo' onclick='valida()' value="1">HABILITAR</div>
        	<?php } ?>	
        </TD>
        <TD  class="textotabla1"><div align="center">PORCENTAJE<input type='text' id='porcentaje' name='porcentaje' maxlength='2' size='2'>%</div></TD>
	</TR>
<?
		$db = new Database();
		$db1 = new Database();
		$sql = "SELECT * FROM kardex	
					INNER JOIN producto ON kardex.cod_ref_kar=producto.cod_pro
					LEFT JOIN 	tipo_producto ON producto.cod_tpro_pro = tipo_producto.cod_tpro 
					LEFT JOIN  marca ON producto.cod_mar_pro = marca.cod_mar
					WHERE kardex.cod_bod_kar=1 and kardex.cant_ref_kar>0
					GROUP BY cod_ref_kar
					 order by nom_tpro,cod_fry_pro  "; 
		$db->query($sql);
		$j=1;
		while($db->next_row()){
			echo "<TR>";
			echo "<TD width=\"11%\" class=\"textotabla1\">$db->cod_fry_pro</TD>";
			echo "<TD width=\"18%\" class=\"textotabla1\">$db->nom_mar</TD>";
			echo "<TD width=\"18%\" class=\"textotabla1\">$db->nom_tpro</TD>";
			echo "<TD class='txtablas' width='15%'>$db->nom_pro</TD>";	
			echo "<TD class='txtablas' width='15%' align='center'>$db->cant_ref_kar</TD>";					
			echo "<TD class='txtablas' align='center' width='15%' colspan='2'>";
			echo "<INPUT type='hidden' name='producto_$j'  maxlength='10' value='$db->cod_pro'>";
			echo "<INPUT type='hidden' name='pr2_".$j."' id='pr2_".$j."' maxlength='10' value='$db->promo_pro'>";
			echo "<INPUT type='text' onkeypress='return validaInt()'  id='precio1_".$j."' name='precio1_".$j."' maxlength='10' value='$db->valor_pro'></TD>";
			echo "<TD class='txtablas' align='center' width='15%' colspan='2'>";
			echo "<INPUT type='text' onkeypress='return validaInt()' id='precio2_".$j."' name='precio2_".$j."' maxlength='10' value='$db->promo_pro'></TD>";
			echo "<TD class='txtablas' align='center' width='15%' colspan='2'>";
			if($db->temp_pro == 0){
				$tempo = $db->valor_pro;
			}else{
				$tempo = $db->temp_pro;
			}
			echo "<INPUT type='text' onkeypress='return validaInt()' id='precio3_".$j."' name='precio3_".$j."' maxlength='10' value='$tempo'></TD>";			echo "<TD class='txtablas' align='center' width='15%'>";
			echo "<input type='checkbox' name='prod_por".$j."' id='prod_por".$j."' value='1' onclick='porcentua($j)'></TD>";				
			echo "</TR>";
			$j++;
		
		}
?>
<TR><TD align="center" colspan="9">	
			<INPUT type="hidden" id="lista" name="lista" value="<?php echo $lista_act?>">
            <INPUT type="hidden" name="ultimo" value="<?php echo $j?>">
			<INPUT type="button" class='botones1' value="Guardar" onclick="cambio_guardar()"  class="botones"></TD>
    <td height="30"  > <input type="hidden" name="guardar" id="guardar" />
    	<input type="hidden" name="codigo" id="codigo" value="<?php echo $codigo?>" /> 
	</td>
</TR>
</TABLE>
</FORM>
</body>
</html>