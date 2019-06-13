<?
include "../lib/sesion.php";
include("../lib/database.php");

//RECIBE LAS VARIABLES
$fec_ini = $_REQUEST['fec_ini'];
$fec_fin = $_REQUEST['fec_fin'];
$auxiliar = $_REQUEST['auxiliar'];
?>
<script language="javascript">
function imprimir(){
	document.getElementById('imp').style.display="none";
	document.getElementById('cer').style.display="none";
	window.print();
}

function abrir(aux) {			
	ancho=900;
	alto=600;

var marginleft = (screen.width - ancho) / 2;
var margintop = (screen.height - alto) / 2;
propiedades = 'menubar=0,resizable=1,height='+alto+',width='+ancho+',top='+margintop+',left='+marginleft+',toolbar=0,scrollbars=yes';
	window.open("../informes/inf_movimientos.php?codigo="+aux,propiedades); 
}
</script>
 <link href="styles.css" rel="stylesheet" type="text/css" />
 <link href="../styles.css" rel="stylesheet" type="text/css" />
 <link href="../css/styles.css" rel="stylesheet" type="text/css" />
 <link href="../css/stylesforms.css" rel="stylesheet" type="text/css" />
 <title><?php echo $nombre_aplicacion?> -- AUXILIAR --</title>
 <style type="text/css">
<!--
.Estilo4 {font-size: 18px}
-->
 </style>
 <TABLE width="100%" border="0" cellspacing="0" cellpadding="0"   >
 <?php echo $credito?>
	
	<TR>
		<TD align="center">
		<TABLE width="98%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" >
		
			<INPUT type="hidden" name="mapa" value="<?php echo $mapa?>">
			<INPUT type="hidden" name="id" value="<?php echo $id?>">

			<TR>
			  <TD width="100%" class='txtablas'>
			  <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#333333">
			  	<tr>
			  		<td width="47%" height="26"><div align="center"><span class="Estilo4">INFORME DE AUXILIARES DE
	  		      <?php echo $fec_ini?> HASTA <?php echo $fec_fin?></span></div></td>
			    </tr>
				</table>					</TD>
		  </TR>
			
			
			<TR>
			  <TD align="center">
			  <table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="#333333" id="select_tablas" >
                
				  <tr >
			<td class="botones1"><div align="center">CUENTA</div></td>
            <td  class="botones1"><div align="center">FECHA EMISION</div></td>
            <td  class="botones1"><div align="center">CONSECUTIVO</div></td>
            <td  class="botones1"><div align="center">NIT</div></td>
            <td  class="botones1"><div align="center">DIGITO</div></td>
            <td  class="botones1"><div align="center">TERCERO</div></td>
            <td  class="botones1"><div align="center">DEBITO</div></td>
            <td   class="botones1"><div align="center">CREDITO</div></td>
            <td class="botones1"><div align="center">DETALLE</div></td>
			</tr>
				<?
				$db = new Database ();
				$sql = "SELECT * FROM d_movimientos
				INNER JOIN cuenta ON cuenta.cod_cuenta = d_movimientos.cuenta_dmov
				INNER JOIN m_movimientos ON m_movimientos.cod_mov = d_movimientos.cod_mov
				INNER JOIN cliente ON cliente.cod_cli = d_movimientos.cod_ter
				WHERE nivel = 5 AND cod_cuenta = $auxiliar AND fec_venci >='$fec_ini' AND fec_venci<='$fec_fin' and estado_mov = 1
				ORDER BY fec_emi";
				$db->query($sql);
				$estilo="formsleo";
				$total_debito = 0;
				$total_credito = 0;
				while($db->next_row()){					
				?>
                 <tr >
                   <td ><div ><?php echo $db->cod_contable?></div></td>
                   <td ><div ><?php echo $db->fec_emi?></div></td>
                   <td ><div ><?php echo $db->conse_mov?></div></td>
                   <td ><div ><?php echo $db->iden_cli?></div></td>
                   <td ><div ><?php echo $db->digito_cli?></div></td>
                   <td ><div ><?php echo $db->nom1_cli?></div></td>
                   <td ><div align="right"><?php echo number_format($db->debito_dmov,0,".",".")?></div>
                   <div ></div></td>
                   <td ><div align="right"><?php echo number_format($db->credito_dmov,0,".",".")?></div></td>
                   <td><div align='center'><img src='../imagenes/mirar.png' width='16' height='16'  style="cursor:pointer"  onclick='abrir(<?=$db->cod_mov?>)' /></div></td>
                 </tr>	        
               	<?php  
				$total_debito = $total_debito + $db->debito_dmov;
				$total_credito = $total_credito + $db->credito_dmov;
				} 				
				?>			 
				  <tr >
				    <td colspan="6" ><div align="right"><span >TOTAL</span></div></td>
				    <td ><div align="right">
				      <?php echo number_format($total_debito,0,".",".")?>
			        </div></td>
				    <td ><div align="right"><?php echo number_format($total_credito,0,".",".")?></div></td>
				    <td>&nbsp;</td>
			    </tr>
				  <tr >
				    <td colspan="9" >&nbsp;</td>
			    </tr>
		      </table></TD>
		  </TR>
			<TR>
			  <TD align="center">             </TD>
		  </TR>
</TABLE>
<TABLE width="70%" border="0" cellspacing="0" cellpadding="0">
     <tr>
      <td align="center" colspan='5'><a href="../exportar/word/auxiliares.php?fec_ini=<?=$fec_ini?>&fec_fin=<?=$fec_fin?>&auxiliar=<?=$auxiliar?>"><img src='../imagenes/word.png'></a><a href="../exportar/excel/auxiliares.php?fec_ini=<?=$fec_ini?>&fec_fin=<?=$fec_fin?>&auxiliar=<?=$auxiliar?>"><img src='../imagenes/excel.png'></a><a href="../exportar/pdf/auxiliares.php?fec_ini=<?=$fec_ini?>&fec_fin=<?=$fec_fin?>&auxiliar=<?=$auxiliar?>"><img src='../imagenes/pdf.png'></a></td>
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