<?php
include "../lib/sesion.php";
include("../lib/database.php");

//RECIBE LAS VARIABLES
$cliente = $_REQUEST['cliente'];
$fec_ini = $_REQUEST['fec_ini'];
$fec_fin = $_REQUEST['fec_fin'];

//VERIFICA SI ES UN CLIENTE O TODOS
if($cliente == 0){
	$where = '';
} else {
	$where = ' AND cliente.cod_cli ='.$cliente;
}
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
 <title><?=$nombre_aplicacion?> -- VENTAS X CLIENTE --</title>
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
			  		<td><div align="center" class="ctablasup">VENTAS X CLIENTE DESDE <?=$fec_ini?> HASTA <?=$fec_fin?></div></td>
			    </tr>
				</table>					</TD>
		  </TR>
			
			
			<TR>
			  <TD align="center">
			  <table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="#333333" id="select_tablas" >
			    <tr>
			      <td align="center">CLIENTE</td>
			      <td align="center">TIPO</td>
			      <td align="center">FACTURA</td>
			      <td align="center">FECHA</td>
			      <td align="center">VALOR</td>
			      <td align="center">DETALLE</td>
		        </tr>
		        <?php
		        //REALIZA LA CONSULTA DE VENTAS
		        $db = new database();
		        $sql = "SELECT *,CONCAT(nom1_cli,' ',nom2_cli,' ',apel1_cli,' ',apel2_cli) as nombre,DATE(DATE(FECHA)) as fec FROM m_factura
		        INNER JOIN cliente ON cliente.cod_cli = m_factura.cod_cli
		        WHERE estado is null $where
		        GROUP BY cod_fac
				HAVING (fec >= '$fec_ini') AND (fec <= '$fec_fin')
				ORDER BY tipo_fac,fec";
		        $db->query($sql);
		        while($db->next_row()){
		        ?>
			    <tr>
			      <td align="center"><?php echo $db->nombre?></td>
			      <td align="center"><?php echo $db->tipo_fac?></td>
			      <td align="center"><?php echo $db->num_fac?></td>
			      <td align="center"><?php echo $db->fec.$db->cod_fac?></td>
			      <td align="center"><?php echo '$'.number_format($db->tot_fac,'.','.','.')?></td>
			      <td align="center"><img src='../imagenes/mirar.png' width='16' height='16'  style="cursor:pointer"  onclick="abrir('<?php echo $db->cod_fac?>')" /></td>
		        </tr>
		        <?php } ?>			 
				<tr>			  
                  <td colspan="6" >&nbsp;</td>
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
	