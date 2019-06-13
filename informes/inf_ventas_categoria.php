<?php
include "../lib/sesion.php";
include("../lib/database.php");

//RECIBE LAS VARIABLES
$fec_ini = $_REQUEST['fec_ini'];
$fec_fin = $_REQUEST['fec_fin'];
?>
<script language="javascript">
function imprimir(){
	document.getElementById('imp').style.display="none";
	document.getElementById('cer').style.display="none";
	window.print();
}

//ABRE EL DETALLE DEL INFORME
function abrir(opc){
	var fec_ini = document.getElementById('fec_ini').value;
	var fec_fin = document.getElementById('fec_fin').value;
	var vendedor = document.getElementById('vendedor').value;
	var opc = opc;
			
	imprimir_inf("../ver_factura_v.php",'0&fec_ini='+fec_ini+"&fec_fin="+fec_fin+"&vendedor="+vendedor+"&codigo="+opc,'mediano',"target = '_blank'");
}
</script>
<script type="text/javascript" src="../js/funciones.js"></script>
<script type="text/javascript" src="../informes/inf.js"></script>
 <link href="styles.css" rel="stylesheet" type="text/css" />
 <link href="../styles.css" rel="stylesheet" type="text/css" />
 <style type="text/css">
<!--
.Estilo1 {font-size: 9px}
.Estilo2 {font-size: 9 }
-->
 </style>
 <link href="../css/styles.css" rel="stylesheet" type="text/css" />
 <link href="../css/stylesforms.css" rel="stylesheet" type="text/css" />
 <title><?=$nombre_aplicacion?> -- VENTAS X CATEGORIA --</title>
<TABLE width="100%" border="0" cellspacing="0" cellpadding="0"   >
	
	<TR>
		<TD align="center">
		<TABLE width="98%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" >
		
			<INPUT type="hidden" name="mapa" value="<?=$mapa?>">
			<INPUT type="hidden" name="id" value="<?=$id?>">
			<INPUT type="hidden" name="fec_ini" id="fec_ini"  value="<?=$fec_ini?>">
			<INPUT type="hidden" name="fec_fin" id="fec_fin" value="<?=$fec_fin?>">
			<INPUT type="hidden" name="vendedor" id="vendedor"  value="<?=$vendedor?>">


			<TR>
			  <TD width="100%" class='txtablas'>
			  <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#333333">
			  	<tr>
			  		<td><div align="center" class="ctablasup">VENTAS X CATEGORIA DESDE <?=$fec_ini?> HASTA <?=$fec_fin?></div></td>
			    </tr>
				</table>					</TD>
		  </TR>
			
			
			<TR>
			  <TD align="center">
			  <table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="#333333" id="select_tablas" >
			    <tr>
			      <td align="center">CATEGORIA</td>
			      <td align="center">CANTIDAD</td>
			      <td align="center">PORCENTAJE</td>
		        </tr>
		        <?php
		        //SUMA EL TOTAL
		        $total = 0;
		        $dbt = new database();
		        $sqlt = "SELECT *,COUNT(cant_pro) as cantidad,DATE(DATE(FECHA)) as fec FROM m_factura
		        INNER JOIN d_factura ON d_factura.cod_mfac = m_factura.cod_fac
		        INNER JOIN marca ON marca.cod_mar = d_factura.cod_cat
		        WHERE estado is null
		        GROUP BY cod_cat
				HAVING (fec >= '$fec_ini') AND (fec <= '$fec_fin')
				ORDER BY tipo_fac,fec";
		        $dbt->query($sqlt);
		        while($dbt->next_row()){
		        	$total = $total + $dbt->cantidad;
		        }

		        //REALIZA LA CONSULTA DE VENTAS
		        $db = new database();
		        $sql = "SELECT *,COUNT(cant_pro) as cantidad,DATE(DATE(FECHA)) as fec FROM m_factura
		        INNER JOIN d_factura ON d_factura.cod_mfac = m_factura.cod_fac
		        INNER JOIN marca ON marca.cod_mar = d_factura.cod_cat
		        WHERE estado is null
		        GROUP BY cod_cat
				HAVING (fec >= '$fec_ini') AND (fec <= '$fec_fin')
				ORDER BY cantidad DESC";
		        $db->query($sql);
		        while($db->next_row()){
		        	//SACA PORCENTAJE
		        	$porcentaje = round($db->cantidad * 100 / $total) ;
		        ?>
			    <tr>
			      <td align="center"><?php echo $db->nom_mar?></td>
			      <td align="center"><?php echo $db->cantidad?></td>
			      <td align="center"><?php echo $porcentaje.'%'?></td>
		        </tr>
		        <?php } ?>			 
				<tr>			  
                  <td align="center">Total:</td>
                  <td align="center"><?php echo number_format($total,'.','.','.')?></td>
                  <td align="center"><?php echo '100%'?></td>
				</tr>

              </table></TD>
		  </TR>
			<TR>
			  <TD align="center">             </TD>
		  </TR>
			<TR>
			  <TD align="center"><p></TD>
		  </TR>
</TABLE>

 
<TABLE width="70%" border="0" cellspacing="0" cellpadding="0">
     <tr>
      <td align="center" colspan='5'><a href="../exportar/word/categoria.php?fec_ini=<?=$fec_ini?>&fec_fin=<?=$fec_fin?>"><img src='../imagenes/word.png'></a><a href="../exportar/excel/categoria.php?fec_ini=<?=$fec_ini?>&fec_fin=<?=$fec_fin?>"><img src='../imagenes/excel.png'></a><a href="../exportar/pdf/categoria.php?fec_ini=<?=$fec_ini?>&fec_fin=<?=$fec_fin?>"><img src='../imagenes/pdf.png'></a></td>
    </tr>	
	<TR><TD colspan="3" align="center"><input name="button" type="button"  class="botones" id="imp" onClick="imprimir()" value="Imprimir">
        <input name="button" type="button"  class="botones"  id="cer" onClick="window.close()" value="Cerrar"></TD>
	</TR>

	<TR>
		<TD width="1%" background="images/bordefondo.jpg" style="background-repeat:repeat-y" rowspan="2"></TD>
		<TD bgcolor="#F4F4F4" class="pag_actual">&nbsp;</TD>
		<TD width="1%" background="images/bordefondo.jpg" style="background-repeat:repeat-y" rowspan="2"></TD>
	</TR>
	<TR>
	  <TD align="center">
	