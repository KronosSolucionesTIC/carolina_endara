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
 <title><?php echo $nombre_aplicacion?> -- INFORME DE MOVIMIENTOS X REFERENCIA --</title>
<TABLE width="100%" border="0" cellspacing="0" cellpadding="0"   >
	
	<TR>
		<TD align="center">
		<TABLE width="98%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" >
		
			<INPUT type="hidden" name="fec_ini" id='fec_ini' value="<?php echo $fec_ini?>">
			<INPUT type="hidden" name="fec_fin" id='fec_fin' value="<?php echo $fec_fin?>">
			<INPUT type="hidden" name="producto" id='producto' value="<?php echo $producto?>">


			<TR>
			  <TD width="100%" class='txtablas'>
			  <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#333333">
				</table>					</TD>
		  </TR>
			
			
			<TR>
			  <TD align="center">
			  <table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="#333333" id="select_tablas" >
			    <tr >
			      <td  class="botones1"><div align="center">CODIGO</div></td>
			      <td   class="botones1"><div align="center">CATEGORIA</div></td>
			      <td  class="botones1"><div align="center">TIPO PRODUCTO</div></td>
			      <td  class="botones1"><div align="center">REFERENCIA</div></td>
		        </tr>
                
			    <?
				$estilo="formsleo";

				$db = new Database();
				$sql = "SELECT  *  FROM producto  
				INNER JOIN marca ON marca.cod_mar = producto.cod_mar_pro
				INNER JOIN tipo_producto ON tipo_producto.cod_tpro = producto.cod_tpro_pro
				WHERE estado_producto = 1";
				$db->query($sql);	
				while($db->next_row()){ 
					$producto = $db->cod_pro;

				//VENTAS
				$ventas = 0;
				$dbv = new database();
				$sqlv = "SELECT SUM(cant_pro) AS total_ventas,DATE(DATE(FECHA)) as fec FROM d_factura 
				INNER JOIN m_factura ON m_factura.cod_fac = d_factura.cod_mfac
				WHERE estado is null AND cod_pro = $producto
				GROUP BY cod_fac
				HAVING (fec >= '$fec_ini') AND (fec <= '$fec_fin')";
				$dbv->query($sqlv);
				while($dbv->next_row()){
					$ventas = $dbv->total_ventas;
				} 
					if($ventas <= 0){											
				?>
                <tr id="fila_0">			
                	<td class="textotabla01"><div align="center"><?php echo $db->cod_fry_pro ?></div></td>
					<td class="textotabla01"><div align="center"><?php echo $db->nom_mar ?></div></td>
					<td class="textotabla01"><div align="center"><?php echo $db->nom_tpro ?></div></td>
                	<td class="textotabla01"><div align="center"><?php echo $db->nom_pro ?></div></td>
			    </tr>
			    <?php 
			    	} 
			    } 
			    ?>				 
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