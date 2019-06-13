<?php
include "../lib/sesion.php";
include("../lib/database.php");

//RECIBE LAS VARIABLES
$producto = $_REQUEST['producto'];

$db = new Database();
$db_ver = new Database();
$sql = "SELECT  *  FROM producto  
INNER JOIN marca ON marca.cod_mar = producto.cod_mar_pro
INNER JOIN tipo_producto ON tipo_producto.cod_tpro = producto.cod_tpro_pro
WHERE cod_pro = $producto";
$db_ver->query($sql);	
if($db_ver->next_row()){ 
	$cod_prod = $db_ver->cod_fry_pro.' '.$db_ver->nom_pro;
}

?>
<script language="javascript">
function imprimir(){
	document.getElementById('imp').style.display="none";
	document.getElementById('cer').style.display="none";
	window.print();
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
 <title><?=$nombre_aplicacion?> -- MOVIMIENTOS X REFERENCIA --</title>
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
			  		<td><div align="center" class="ctablasup">MOVIMIENTOS X REFERENCIA <?php echo $cod_prod ?></div></td>
			    </tr>
				</table>					</TD>
		  </TR>
			
			
			<TR>
			  <TD align="center">
			  <table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="#333333" id="select_tablas" >
			  <tr>
			      <td align="center" colspan="4" align="center">INGRESOS</td>
		      </tr>
			  <tr>
			      <td align="center">No DOC</td>
			      <td align="center">FECHA</td>
			      <td align="center">BENEFICIARIO</td>
			      <td align="center">CANTIDAD</td>
		      </tr>
			  <?php 
			  	//INGRESOS
				$dbi = new database();
				$sqli = "SELECT * FROM d_entrada
				INNER JOIN m_entrada ON m_entrada.cod_ment = d_entrada.cod_ment_dent
				WHERE cod_ref_dent = $producto AND cod_bod = 1";
				$dbi->query($sqli);
				while($dbi->next_row()){
			  ?>
			  <tr>
			      <td align="center"><?php echo $dbi->cod_ment ?></td>
			      <td align="center"><?php echo $dbi->fec_ment ?></td>
			      <td align="center">&nbsp;</td>
			      <td align="center"><?php echo $dbi->cant_dent ?></td>
		      </tr>
		      <?php } ?>
		      <tr>
		      	<td colspan="4">&nbsp;</td>
		      </tr>
		      <tr>
			      <td align="center" colspan="4" align="center">VENTAS</td>
		      </tr>
			  <tr>
			      <td align="center">No DOC</td>
			      <td align="center">FECHA</td>
			      <td align="center">BENEFICIARIO</td>
			      <td align="center">CANTIDAD</td>
		      </tr>
			  <?php 
			  	//VENTAS
				$dbv = new database();
				$sqlv = "SELECT *,CONCAT(nom1_cli,' ',nom2_cli,' ',apel1_cli,' ',apel2_cli) AS nombre FROM d_factura 
				INNER JOIN m_factura ON m_factura.cod_fac = d_factura.cod_mfac
				INNER JOIN cliente ON cliente.cod_cli = m_factura.cod_cli
				WHERE estado is null AND cod_pro = $producto";
				$dbv->query($sqlv);
				while($dbv->next_row()){
					$ventas = $dbv->total_ventas;
			  ?>
			  <tr>
			      <td align="center"><?php echo $dbv->num_fac ?></td>
			      <td align="center"><?php echo $dbv->fecha ?></td>
			      <td align="center"><?php echo $dbv->nombre ?></td>
			      <td align="center"><?php echo $dbv->cant_pro ?></td>
		      </tr>
		      <?php } ?>
		      <tr>
		      	<td colspan="4">&nbsp;</td>
		      </tr>
		      			  <tr>
			      <td align="center" colspan="4" align="center">TRASLADOS</td>
		      </tr>
			  <tr>
			      <td align="center">No DOC</td>
			      <td align="center">FECHA</td>
			      <td align="center">BENEFICIARIO</td>
			      <td align="center">CANTIDAD</td>
		      </tr>
			  <?php 
				//TRASLADOS
				$traslados = 0;
				$dbt = new database();
				$sqlt = "SELECT * FROM d_traslado
				INNER JOIN m_traslado ON m_traslado.cod_tras = d_traslado.cod_mtras_dtra
				WHERE cod_ref_dtra = $producto";
				$dbt->query($sqlt);
				while($dbt->next_row()){
			  ?>
			  <tr>
			      <td align="center"><?php echo $dbt->cod_tras ?></td>
			      <td align="center"><?php echo $dbt->fec_tras ?></td>
			      <td align="center">&nbsp;</td>
			      <td align="center"><?php echo $dbt->cant_dtra ?></td>
		      </tr>
		      <?php } ?>
		      <tr>
		      	<td colspan="4">&nbsp;</td>
		      </tr>
		      			  <tr>
			      <td align="center" colspan="4" align="center">EXISTENCIAS</td>
		      </tr>
		      <tr>
			      <td align="center">No DOC</td>
			      <td align="center">FECHA</td>
			      <td align="center">BENEFICIARIO</td>
			      <td align="center">CANTIDAD</td>
		      </tr>
			  <?php 
				//EXISTENCIAS
				$dbe = new database();
				$sqle = "SELECT cant_ref_kar AS total_existencias FROM kardex	
				WHERE cod_ref_kar = $producto AND cod_bod_kar = 1
				GROUP BY cod_ref_kar";
				$dbe->query($sqle);
				while($dbe->next_row()){
			  ?>
			  <tr>
			      <td align="center">&nbsp;</td>
			      <td align="center"><?php echo date('Y-m-d');?></td>
			      <td align="center">&nbsp;</td>
			      <td align="center"><?php echo $dbe->total_existencias?></td>
		      </tr>
		      <?php } ?>
		      <tr>
		      	<td colspan="4">&nbsp;</td>
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
      <td align="center" colspan='5'><a href="../exportar/word/productos.php?codigo=<?=$codigo_bodega?>"><img src='../imagenes/word.png'></a><a href="../exportar/excel/productos.php?codigo=<?=$codigo_bodega?>"><img src='../imagenes/excel.png'></a><a href="../exportar/pdf/productos.php?codigo=<?=$codigo_bodega?>"><img src='../imagenes/pdf.png'></a></td>
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
	