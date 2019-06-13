<?php
include "../lib/sesion.php";
include "../lib/database.php";

//RECIBE LAS VARIABLES
$producto = $_REQUEST['producto'];

$db     = new Database();
$db_ver = new Database();
$sql    = "SELECT  *  FROM producto
INNER JOIN marca ON marca.cod_mar = producto.cod_mar_pro
INNER JOIN tipo_producto ON tipo_producto.cod_tpro = producto.cod_tpro_pro
WHERE cod_pro = $producto";
$db_ver->query($sql);
if ($db_ver->next_row()) {
    $cod_prod = $db_ver->cod_fry_pro . ' ' . $db_ver->nom_pro;
}

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
 <title><?php echo $nombre_aplicacion ?> -- INFORME DE MOVIMIENTOS X REFERENCIA --</title>
<TABLE width="100%" border="0" cellspacing="0" cellpadding="0"   >

	<TR>
		<TD align="center">
		<TABLE width="98%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" >

			<INPUT type="hidden" name="mapa" value="<?php echo $mapa ?>">
			<INPUT type="hidden" name="id" value="<?php echo $id ?>">
			<INPUT type="hidden" name="producto" id='producto' value="<?php echo $producto ?>">


			<TR>
			  <TD width="100%" class='txtablas'>
			  <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#333333">
			  	<tr>
			  		<td><div align="center">PRODUCTO :<?php echo $cod_prod ?></div></td>
			    </tr>
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
			      <td   class="botones1"><div align="center">INGRESOS</div></td>
			      <td   class="botones1"><div align="center">VENTAS</div></td>
			      <td   class="botones1"><div align="center">TRASLADOS</div></td>
			      <td   class="botones1"><div align="center">EXISTENCIA</div></td>
			      <td   class="botones1"><div align="center">DETALLE</div></td>
		        </tr>

			    <?
$estilo = "formsleo";

//INGRESOS
$dbi  = new database();
$sqli = "SELECT SUM(cant_dent) AS total_ingresos FROM d_entrada
				INNER JOIN m_entrada ON m_entrada.cod_ment = d_entrada.cod_ment_dent
				WHERE cod_ref_dent = $producto AND cod_bod = 1 AND estado_m_entrada = 1";
$dbi->query($sqli);
while ($dbi->next_row()) {
    $ingresos = $dbi->total_ingresos;
}

//TRASLADOS INGRESOS
$traslados = 0;
$dbt       = new database();
$sqlt      = "SELECT SUM(cant_dtra) AS total_traslados FROM d_traslado
				INNER JOIN m_traslado ON m_traslado.cod_tras = d_traslado.cod_mtras_dtra
				WHERE cod_ref_dtra = $producto AND cod_bod_ent_tras = 1";
$dbt->query($sqlt);
while ($dbt->next_row()) {
    $ingresos = $ingresos + $dbt->total_traslados;
}

//VENTAS
$dbv  = new database();
$sqlv = "SELECT SUM(cant_pro) AS total_ventas FROM d_factura
				INNER JOIN m_factura ON m_factura.cod_fac = d_factura.cod_mfac
				WHERE estado is null AND cod_pro = $producto";
$dbv->query($sqlv);
while ($dbv->next_row()) {
    $ventas = $dbv->total_ventas;
}

//TRASLADOS SALIDAS
$traslados = 0;
$dbt       = new database();
$sqlt      = "SELECT SUM(cant_dtra) AS total_traslados FROM d_traslado
				INNER JOIN m_traslado ON m_traslado.cod_tras = d_traslado.cod_mtras_dtra
				WHERE cod_ref_dtra = $producto AND cod_bod_sal_tras = 1";
$dbt->query($sqlt);
while ($dbt->next_row()) {
    $traslados = $dbt->total_traslados;
}

//EXISTENCIAS
$dbe  = new database();
$sqle = "SELECT SUM(cant_ref_kar) AS total_existencias FROM kardex
				WHERE cod_ref_kar = $producto AND cod_bod_kar = 1
				GROUP BY cod_ref_kar";
$dbe->query($sqle);
while ($dbe->next_row()) {
    $existencias = $dbe->total_existencias;
}
?>
                <tr id="fila_0">
                	<td class="textotabla01"><div align="center"><?php echo $db_ver->cod_fry_pro ?></div></td>
					<td class="textotabla01"><div align="center"><?php echo $db_ver->nom_mar ?></div></td>
					<td class="textotabla01"><div align="center"><?php echo $db_ver->nom_tpro ?></div></td>
                	<td class="textotabla01"><div align="center"><?php echo $db_ver->nom_pro ?></div></td>
					<td class="textotabla01"><div align="right"><?php echo $ingresos ?></div></td>
					<td class="textotabla01"><div align="right"><?php echo $ventas ?></div></td>
					<td class="textotabla01"><div align="right"><?php echo $traslados ?></div></td>
					<td class="textotabla01"><div align="right"><?php echo $existencias ?></div></td>
					<td class="textotabla01"><div align="center"><img src='../imagenes/mirar.png' width='16' height='16'  style="cursor:pointer"  onclick="abrir()" /></div></td>
			    </tr>
				<tr>
                	<td colspan="10" >&nbsp;</td>
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
      <td align="center" colspan='5'><a href="../exportar/word/productos.php?codigo=<?php echo $codigo_bodega ?>"><img src='../imagenes/word.png'></a><a href="../exportar/excel/productos.php?codigo=<?php echo $codigo_bodega ?>"><img src='../imagenes/excel.png'></a><a href="../exportar/pdf/productos.php?codigo=<?php echo $codigo_bodega ?>"><img src='../imagenes/pdf.png'></a></td>
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