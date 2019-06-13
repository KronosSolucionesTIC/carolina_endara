<?php
include "../lib/sesion.php";
include("../lib/database.php");

//RECIBE LAS VARIABLES
$fecha_ini = $_REQUEST['fec_ini'];
$fecha_fin = $_REQUEST['fec_fin'];
?>
<script language="javascript">
function imprimir(){
	document.getElementById('imp').style.display="none";
	document.getElementById('cer').style.display="none";
	window.print();
}

function abrir(){
	var producto = document.getElementById('producto').value;
			
	imprimir_inf("../inf_det_movimiento_referencia.php",'0&producto='+producto,'mediano','target = _blank');
}
</script>
 <link href="styles.css" rel="stylesheet" type="text/css" />
 <link href="../styles.css" rel="stylesheet" type="text/css" />
 <script type="text/javascript" src="../informes/inf.js"></script>
 <style type="text/css">
<!--
.Estilo1 {font-size: 9px}
.Estilo2 {font-size: 9 }
-->
 </style>
 <link href="../css/styles.css" rel="stylesheet" type="text/css" />
 <link href="../css/stylesforms.css" rel="stylesheet" type="text/css" />
 <title><?php echo $nombre_aplicacion?> -- VENTAS X COSTO --</title>
<TABLE width="100%" border="0" cellspacing="0" cellpadding="0"   >
	
	<TR>
		<TD align="center">
		<TABLE width="98%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" >
		
			<INPUT type="hidden" name="mapa" value="<?php echo $mapa?>">
			<INPUT type="hidden" name="id" value="<?php echo $id?>">
			<INPUT type="hidden" name="producto" id='producto' value="<?php echo $producto?>">


			<TR>
			  <TD width="100%" class='txtablas'>
			  <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#333333">
			  	<tr>
			  		<td><div align="center">VENTAS X COSTO</div></td>
			    </tr>
				</table>					</TD>
		  </TR>
			
			
			<TR>
			  <TD align="center">
			  <table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="#333333" id="select_tablas" >
			    <tr >
			      <td  class="botones1"><div align="center">FECHA INICIO</div></td>
			      <td   class="botones1"><div align="center">FECHA FIN</div></td>
			      <td  class="botones1"><div align="center">TOTAL</div></td>
		        </tr>
                
			    <?
				$estilo="formsleo";

				//VENTAS
				$dbv = new database();
				$sqlv = "SELECT *,DATE(DATE(FECHA)) as fec FROM d_factura 
				INNER JOIN m_factura ON m_factura.cod_fac = d_factura.cod_mfac
				INNER JOIN producto ON producto.cod_pro = d_factura.cod_pro
				GROUP BY cod_dfac
				HAVING (fec >= '$fecha_ini') AND (fec <= '$fecha_fin') AND estado is null
 				ORDER BY tipo_fac";
				$dbv->query($sqlv);
				$gran_total = 0;
				while($dbv->next_row()){
					$tot = $dbv->cant_pro * $dbv->costo_pro ;
					$gran_total = $gran_total + $tot;
				}
				?> 
				<tr id="fila_0">			
                	<td class="textotabla01"><div align="center"><?php echo $fec_ini ?></div></td>
					<td class="textotabla01"><div align="center"><?php echo $fec_fin ?></div></td>
					<td class="textotabla01"><div align="center"><?php echo number_format($gran_total,'.','.','.')?></div></td>
			    </tr>				 
				<tr>			  
                	<td colspan="9" >&nbsp;</td>
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
      <td align="center" colspan='5'><a href="../exportar/word/productos.php?codigo=<?php echo $codigo_bodega?>"><img src='../imagenes/word.png'></a><a href="../exportar/excel/productos.php?codigo=<?php echo $codigo_bodega?>"><img src='../imagenes/excel.png'></a><a href="../exportar/pdf/productos.php?codigo=<?php echo $codigo_bodega?>"><img src='../imagenes/pdf.png'></a></td>
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