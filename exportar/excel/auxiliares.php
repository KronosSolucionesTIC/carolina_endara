<?php include("../../lib/database.php");?>
<?php include("../../js/funciones.php");?>
<? 
//CODIGO PARA GUARDAR COMO EXCEL
header ( "Content-type: application/x-msexcel" );
header ( "Content-Disposition: attachment; filename=Inf_auxiliares.xls" );
header ( "Content-Description: Generador XLS" );

//RECIBE LAS VARIABLES
$fec_ini = $_REQUEST['fec_ini'];
$fec_fin = $_REQUEST['fec_fin'];
$auxiliar = $_REQUEST['auxiliar'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$nombre_aplicacion?></title>
</head>
<body>
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
                 </tr>	        
               	<?php  
				$total_debito = $total_debito + $db->debito_dmov;
				$total_credito = $total_credito + $db->credito_dmov;
				} 				
				?>			 
				  <tr >
				    <td colspan="5" ><div align="right"><span >TOTAL</span></div></td>
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
</body>
</html>