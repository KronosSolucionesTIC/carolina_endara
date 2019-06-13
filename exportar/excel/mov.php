<?php include("../../lib/database.php");?>
<?php include("../../js/funciones.php");?>
<? 
//CODIGO PARA GUARDAR COMO EXCEL
header ( "Content-type: application/x-msexcel" );
header ( "Content-Disposition: attachment; filename=Inf_mov.xls" );
header ( "Content-Description: Generador XLS" );

//RECIBE LAS VARIABLES
$fec_ini = $_REQUEST['fec_ini'];
$fec_fin = $_REQUEST['fec_fin'];
$pro = $_REQUEST['pro'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$nombre_aplicacion?></title>
</head>
<body>
<TABLE width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="#333333" id="select_tablas" >	
	<tr>
		<td colspan="6" align="center">INFORME DE MOVIMIENTOS CONTABLES DE <?=$fec_ini?> HASTA <?=$fec_fin?></td>
	</tr>			
	<TR>
		<TD colspan="2" align="center">
		<?php 
			$dbv = new Database();
			$sqlv = "SELECT * FROM proveedor
			WHERE cod_pro = $pro";
			$dbv->query($sqlv);
			$dbv->next_row();
		?>
	<tr>
		<td class="textotabla01">Tercero:</td>
		<td colspan="5" class="textotabla01"><?=$dbv->nom_pro?></td>
	</tr>
	<tr>
		<td colspan="6" class="textotabla01">&nbsp;</td>
	</tr>
	<tr>
		<td width="5%"  class="botones1">NUMERO</td>
		<td width="5%"  class="botones1">CODIGO</td>
        <td width="5%"  class="botones1">CUENTA</td>
        <td width="5%"  class="botones1">CONCEPTO</td>
		<td width="5%"  class="botones1">DEBITO</td>
		<td width="5%"   class="botones1">CREDITO</td>
        </tr>
    <?php
    	$db = new Database();
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
        <?php
			$total_debitos = $total_debitos + $db->debito_dmov;
			$total_creditos = $total_creditos + $db->credito_dmov;
		} 
		?>
	</tr>			 
	<tr>
		<td colspan="6" >&nbsp;</td>
	</tr>
	<tr>
		<td colspan="5" ><strong><div align="right">Total debitos:</div></strong></td>
		<td ><strong><div align="right"><?=number_format($total_debitos,0,".",".")?></div></strong></td>
	</tr>
	<tr>
		<td height="23" colspan="5" ><strong><div align="right">Total creditos:</div></strong></td>
        <td><strong><div align="right"><?=number_format($total_creditos,0,".",".")?></div></strong></td>
	</tr>
		</TD>
	</TR>
		
		<tr>
			<td colspan="2" align="center"></td>
		</tr>
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
</body>
</html>