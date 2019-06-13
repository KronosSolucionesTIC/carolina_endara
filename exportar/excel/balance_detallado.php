<?php include("../../lib/database.php");?>
<?php include("../../js/funciones.php");?>
<? 
//RECIBE LAS VARIABLES
header ( "Content-type: application/x-msexcel" );
header ( "Content-Disposition: attachment; filename=productos.xls" );
header ( "Content-Description: Generador XLS" );

//RECIBE LAS VARIABLES
$fec_ini = $_REQUEST['fec_ini'];
$fec_fin = $_REQUEST['fec_fin'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$nombre_aplicacion?></title>
</head>
<body>
 <TABLE width="100%" border="0" cellspacing="0" cellpadding="0"   >
 <?=$credito?>
	
	<TR>
		<TD align="center">
		<TABLE width="98%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" >
		
			<INPUT type="hidden" name="mapa" value="<?=$mapa?>">
			<INPUT type="hidden" name="id" value="<?=$id?>">

			<TR>
			  <TD width="100%" class='txtablas'>
			  <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#333333">
			  	<tr>
			  		<td width="47%" height="26"><div align="center"><span class="Estilo4">BALANCE DETALLADO DE <?=$fec_ini?> HASTA <?=$fec_fin?></span></div></td>
			    </tr>
				</table>					</TD>
		  </TR>
			
			
			<TR>
			  <TD align="center">&nbsp;</TD>
		  </TR>
			<TR>
			  <TD align="center">             </TD>
		  </TR>
</TABLE>
		<table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="#333333" id="select_tablas" >
		<tr ></tr>
        <tr >
          <td width="9%"  class="botones1"><div align="center">CUENTA</div></td>
          <td width="34%"  class="botones1"><div align="center">NOMBRE DE LA CUENTA</div></td>
          <td width="16%"  class="botones1"><div align="center">SALDO</div></td>
        </tr>
        <?
				$db = new Database ();
				$sql = "SELECT cod_contable,desc_cuenta,nivel,debito_dmov,credito_dmov,SUM(debito_dmov) AS suma_debito,SUM(credito_dmov) AS suma_credito FROM cuenta
				INNER JOIN d_movimientos ON d_movimientos.cuenta_dmov = cuenta.cod_cuenta
				INNER JOIN m_movimientos ON m_movimientos.cod_mov = d_movimientos.cod_mov
				WHERE ((cod_contable LIKE '1%')or(cod_contable LIKE '5%')or(cod_contable LIKE '6%') ) AND ((fec_emi >='$fec_ini') AND (fec_emi <='$fec_fin'))AND estado_mov = 1
				GROUP BY cod_cuenta
				ORDER BY  `cuenta`.`cod_contable` ASC";
				$db->query($sql);
				$estilo="formsleo";
				$total_saldo = 0;
				$total_debito = 0;
				$total_credito = 0;
				$total_nuevo_saldo = 0;
				while($db->next_row()){						
				?>
        <tr id="fila_0"  >
          <td  class="textotabla01"><?=$db->cod_contable?></td>
          <td  class="textotabla01"><?=$db->desc_cuenta?></td>
          <?
				if($db->saldo == ""){
					$saldo = 0;	
				}
				else {
					$saldo = $db->saldo;
				};	
				
				if ($db->nivel == 1){
					$total_saldo = $total_saldo + $saldo;
				}
										
				if($db->suma_debito == ""){
					$debito = 0;	
				}
				else {
					$debito = $db->suma_debito;
				};
				if ($db->nivel == 1){
					$total_debito = $total_debito + $debito;
				}
						
				if($db->suma_credito == ""){
					$credito = 0;	
				}
				else {
					$credito = $db->suma_credito;
				};
				if ($db->nivel == 1){
					$total_credito = $total_credito + $credito;
				}				
				
				 $nuevo_saldo = $saldo + $debito - $credito;
				 
				 if ($db->nivel == 1){
					$total_nuevo_saldo = $total_nuevo_saldo + $nuevo_saldo;
				 }
				 ?>
          <td colspan="1" class="textotabla01"><div align="right">
            <?=number_format($nuevo_saldo,0,".",".")?>
          </div></td>
        </tr>
        <? } ?>
        <tr >
          <td colspan="6" >&nbsp;</td>
        </tr>
        <tr >
          <td colspan="2" ><div align="right"><strong>Total activo:</strong></div></td>
          <td ><div align="right"> <strong>
            <?=number_format($total_nuevo_saldo,0,".",".")?>
          </strong></div></td>
        </tr>
        <tr >
          <td colspan="6" >&nbsp;</td>
        </tr>
        <tr >
          <td colspan="6" >&nbsp;</td>
        </tr>
        <tr >
          <td width="9%"  class="botones1"><div align="center">CUENTA</div></td>
          <td width="34%"  class="botones1"><div align="center">NOMBRE DE LA CUENTA</div></td>
          <td width="16%"  class="botones1"><div align="center">SALDO</div></td>
        </tr>
        <?
				$db = new Database ();
				$sql = "SELECT nivel,cod_contable,desc_cuenta,debito_dmov,credito_dmov,SUM(credito_dmov) AS suma_credito,SUM(debito_dmov) AS suma_debito FROM cuenta
				INNER JOIN d_movimientos ON d_movimientos.cuenta_dmov = cuenta.cod_cuenta
				INNER JOIN m_movimientos ON m_movimientos.cod_mov = d_movimientos.cod_mov
				WHERE ((cod_contable LIKE '2%')or(cod_contable LIKE '3%') or(cod_contable LIKE '4%')) AND ((fec_emi >='$fec_ini') AND (fec_emi <='$fec_fin')) AND estado_mov = 1
				GROUP BY cod_cuenta
				ORDER BY  `cuenta`.`cod_contable` ASC";
				$db->query($sql);
				$estilo="formsleo";
				$total_saldo = 0;
				$total_debito = 0;
				$total_credito = 0;
				$total_nuevo_saldo = 0;
				while($db->next_row()){						
				?>
        <tr id="fila_0"  >
          <td  class="textotabla01"><?=$db->cod_contable?></td>
          <td  class="textotabla01"><?=$db->desc_cuenta?></td>
          <?
				if($db->saldo == ""){
					$saldo = 0;	
				}
				else {
					$saldo = $db->saldo;
				};
				if ($db->nivel == 1){
					$total_saldo = $total_saldo + $saldo;
				}					

				if($db->suma_debito == ""){
					$debito = 0;	
				}
				else {
					$debito = $db->suma_debito;
				};		
				if ($db->nivel == 1){
					$total_debito = $total_debito + $debito;
				}				
	
				if($db->suma_credito == ""){
					$credito = 0;	
				}
				else {
					$credito = $db->suma_credito;
				};		
				if ($db->nivel == 1){
					$total_credito = $total_credito + $credito;
				}						
				?>
          <? 
				  $nuevo_saldo = $saldo + $credito - $debito ;				  				 
				  if ($db->nivel == 1){
					$total_nuevo_saldo = $total_nuevo_saldo + $nuevo_saldo;
				  }
				  ?>
          <td colspan="1" class="textotabla01"><div align="right">
            <?=number_format($nuevo_saldo,0,".",".")?>
          </div></td>
        </tr>
        <?
				  } 
				 ?>
        <tr >
          <td colspan="6" >&nbsp;</td>
        </tr>
        <tr >
          <td colspan="2" ><div align="right"><strong>Total pasivo + patrimonio:</strong></div></td>
          <td ><div align="right"> <strong>
            <?=number_format($total_nuevo_saldo,0,".",".")?>
          </strong></div></td>
        </tr>
        <tr >
          <td colspan="6" ><table  width="100%"  >
            <tr></tr>
          </table></td>
        </tr>
        </table>
</body>
</html>