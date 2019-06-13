<?php
include "../lib/sesion.php";
include("../lib/database.php");		

//RECIBE LAS VARIABLES
$fec_ini = $_REQUEST['fec_ini'];
$fec_fin = $_REQUEST['fec_fin'];
$pro = $_REQUEST['pro'];		
?>
<script language="javascript">
function imprimir(){
	document.getElementById('imp').style.display="none";
	document.getElementById('cer').style.display="none";
	window.print();
}


</script>
 <link href="styles.css" rel="stylesheet" type="text/css" />
 <link href="../styles.css" rel="stylesheet" type="text/css" />
 <link href="../css/styles.css" rel="stylesheet" type="text/css" />
 <link href="../css/stylesforms.css" rel="stylesheet" type="text/css" />
 <title><?=$nombre_aplicacion?> -- MOVIMIENTOS CONTABLES --</title>
 <style type="text/css">
<!--
.Estilo4 {font-size: 18px}
-->
 </style>
 <? $cod_pro = $pro?>
 <TABLE width="100%" border="0" cellspacing="0" cellpadding="0"   >
	
	<TR>
		<TD align="center">
		<TABLE width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" >
		
			<INPUT type="hidden" name="mapa" value="<?=$mapa?>">
			<INPUT type="hidden" name="id" value="<?=$id?>">

			<TR>
			  <TD colspan="2" class='txtablas'>
			  <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#333333">
			  	<tr>
			  		<td width="47%" height="22" class="textotabla01"><div align="center">INFORME DE MOVIMIENTOS CONTABLES DE <?=$fec_ini?> HASTA <?=$fec_fin?></div></td>
			    </tr>
				</table>					</TD>
		  </TR>
			
			
			<TR>
			  <TD colspan="2" align="center">
			  <table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="#333333" id="select_tablas" >
<?  $dbv = new Database();
	$sqlv = "SELECT * FROM proveedor
	WHERE cod_pro = $pro";
	$dbv->query($sqlv);
	$dbv->next_row();
?>
				  <tr >
				    <td class="textotabla01">Tercero:</td>
				    <td colspan="5" class="textotabla01"><?=$dbv->nom_pro?></td>
			    </tr>
				  <tr >
				    <td colspan="6" class="textotabla01">&nbsp;</td>
			    </tr>
				  <tr >
				    <td width="5%"  class="botones1">NUMERO</td>
				    <td width="5%"  class="botones1">CODIGO</td>
            <td width="5%"  class="botones1">CUENTA</td>
            <td width="5%"  class="botones1">CONCEPTO</td>
			<td width="5%"  class="botones1">DEBITO</td>
			 <td width="5%"   class="botones1">CREDITO</td>
            </tr>
            <?  $db = new Database();
	$sql = "SELECT *,CONCAT(cod_contable,' ',desc_cuenta) as cuenta FROM m_movimientos
	INNER JOIN d_movimientos ON d_movimientos.cod_mov = m_movimientos.cod_mov
	INNER JOIN proveedor ON proveedor.cod_pro = d_movimientos.cod_ter
	INNER JOIN cuenta ON cuenta.cod_cuenta = d_movimientos.cuenta_dmov
	WHERE cod_ter = $pro AND nivel = 5 ORDER BY m_movimientos.cod_mov,cod_contable AND estado_mov =  1" ;
	$db->query($sql);
	while($db->next_row()){
?>
                <tr id="fila_0"  >
                  <td  class="textotabla01"><?=$db->cod_mov?></td>
                  <td  class="textotabla01"><?=$db->cod_contable?></td>
                  <td  class="textotabla01"><?=$db->desc_cuenta?></td>
				  <td  class="textotabla01"><div align="center"><?=$db->concepto_dmov?></div></td>
                  <td  class="textotabla01"><div align="center"><?=$db->debito_dmov?></div></td>
                  <td  class="textotabla01"><div align="center"><?=$db->credito_dmov?></div></td>
                <? 
				 $total_debitos = $total_debitos + $db->debito_dmov;
				 $total_creditos = $total_creditos + $db->credito_dmov;
				} ?>
			    </tr>			 
				  <tr >
				    <td colspan="6" >&nbsp;</td>
			    </tr>
				  <tr >
				    <td colspan="5" ><strong><div align="right">Total debitos:</div></strong></td>
				    <td ><strong><div align="right"><?=number_format($total_debitos,0,".",".")?></div></strong></td>
		        </tr>
				  <tr >
			  
                  <td height="23" colspan="5" ><strong><div align="right">Total creditos:</div></strong></td>
                  <td ><strong><div align="right"><?=number_format($total_creditos,0,".",".")?></div></strong></td>
				  </tr>
              </table></TD>
		  </TR>
			<TR>
			  <TD colspan="2" align="center">             </TD>
		  </TR>
			<TR>
			  <TD colspan="2" align="center"><p></TD>
		  </TR>
			<TR>
			
			
			
			  <TD width="13%" height="40" align="center" valign="top"><div align="center" class="textoproductos1">
			    <div align="left" class="subtitulosproductos">Observaciones:			    </div>
			  </div></TD>
		      <TD width="87%" valign="top" ><span class="textotabla01">
		        <?=$dbv->obs_mov?> 
		      </span></TD>
			</TR>
</TABLE>

 
<TABLE width="70%" border="0" cellspacing="0" cellpadding="0">
    <tr>
     	<td align="center" colspan='5'><a href="../exportar/word/mov.php?fec_ini=<?=$fec_ini?>&fec_fin=<?=$fec_fin?>&pro=<?=$pro?>"><img src='../imagenes/word.png'></a><a href="../exportar/excel/mov.php?fec_ini=<?=$fec_ini?>&fec_fin=<?=$fec_fin?>&pro=<?=$pro?>"><img src='../imagenes/excel.png'></a><a href="../exportar/pdf/mov.php?fec_ini=<?=$fec_ini?>&fec_fin=<?=$fec_fin?>&pro=<?=$pro?>"><img src='../imagenes/pdf.png'></a></td>
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
	