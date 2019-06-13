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

//MUESTRA EL VALOR DE B
function detalle(){
	document.getElementById('div_b').style.display="inline";
	document.getElementById('div_b_valor').style.display="inline";
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
 <title><?=$nombre_aplicacion?> -- VENTAS TOTALES --</title>
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
			  		<td><div align="center" class="ctablasup">VENTAS TOTALES DESDE <?=$fec_ini?> HASTA <?=$fec_fin?></div></td>
			    </tr>
				</table>					</TD>
		  </TR>
			
			
			<TR>
			  <TD align="center">
			  <table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="#333333" id="select_tablas" >
			    <tr>
			      <td align="center">TIPO</td>
			      <td align="center">TOTAL</td>
		        </tr>
		        <?php
		        //REALIZA LA CONSULTA DE VENTAS
		        $total_a = 0;
		        $total_b = 0;
		        $db = new database();
		        $sql = "SELECT * ,DATE(DATE(FECHA)) as fec FROM m_factura
		        INNER JOIN cliente ON cliente.cod_cli = m_factura.cod_cli
		        WHERE estado is null $where
		        GROUP BY cod_fac
				HAVING (fec >= '$fec_ini') AND (fec <= '$fec_fin')
				ORDER BY tipo_fac,fec";
		        $db->query($sql);
		        while($db->next_row()){
		        	if($db->tipo_fac == 'A'){
		        		$total_a = $total_a + $db->tot_fac;
		        	} else {
		        		$total_b = $total_b + $db->tot_fac;
		        	}
		        }
		        ?>
			    <tr>
			      	<td align="center"><?php echo 'A'?></td>
			      	<td align="center"><?php echo '$'.number_format($total_a,'.','.','.')?></td>
		        </tr>
			    <tr>
			      	<td align="center"><div style="display:none" id="div_b"><?php echo 'B'?></div></td>
					<td align="center"><div style="display:none" id="div_b_valor"><?php echo '$'.number_format($total_b,'.','.','.')?></div></td>
		        </tr>			    		 
				<tr>			  
                  <td colspan="6" align="CENTER"><input name="button" type="button"  class="botones" id="detalle" onClick="detalle()" value="DETALLE"></td>
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
      <td align="center" colspan='5'><a href="../exportar/word/totales.php?fec_ini=<?=$fec_ini?>&fec_fin=<?=$fec_fin?>"><img src='../imagenes/word.png'></a><a href="../exportar/excel/totales.php?fec_ini=<?=$fec_ini?>&fec_fin=<?=$fec_fin?>"><img src='../imagenes/excel.png'></a><a href="../exportar/pdf/totales.php?fec_ini=<?=$fec_ini?>&fec_fin=<?=$fec_fin?>"><img src='../imagenes/pdf.png'></a></td>
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
	