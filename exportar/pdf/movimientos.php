<?php require_once("../../lib/dompdf/dompdf_config.inc.php");?>
<?php include("../../lib/database.php");?>
<?php include("../../js/funciones.php");?>
<?php 

//RECIBE LAS VARIABLES
$codigo = $_REQUEST['codigo'];	

$codigoHTML='
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/html1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body>
 <TABLE width="100%" border="0" cellspacing="0" cellpadding="0"   >	
	<TR>
		<TD align="center">
		<TABLE width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" >
			<TR>
			  <TD colspan="2" class="txtablas">
			  <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#333333">
			  	<tr>
			  		<td width="47%" height="22" class="textotabla01"><div align="center">MOVIMIENTOS CONTABLES</div></td>
			    </tr>
				</table>					</TD>
		  </TR>
			
			
			<TR>
			  <TD colspan="2" align="center">
			  <table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="#333333" id="select_tablas" >';

	$dbv = new Database();
	$sqlv = "SELECT * FROM m_movimientos
	WHERE cod_mov = $codigo";
	$dbv->query($sqlv);
	$dbv->next_row();	

	$codigoHTML.='
				<tr >
				    <td class="textotabla01">Consecutivo:</td>
				    <td class="textotabla01">'.$dbv->conse_mov.'</td>
				    <td class="textotabla01">&nbsp;</td>
				    <td class="textotabla01">No factura:</td>
				    <td class="textotabla01">'.$dbv->num_mov.'</td>
			    </tr>
				  <tr >
				    <td class="textotabla01">Fecha de emision:</td>
				    <td class="textotabla01">'.$dbv->fec_emi.'</td>
				    <td class="textotabla01">&nbsp;</td>
				    <td class="textotabla01">Fecha de vencimiento:</td>
				    <td class="textotabla01">'.$dbv->fec_venci.'</td>
			    </tr>
				  <tr >
				    <td class="textotabla01">&nbsp;</td>
				    <td class="textotabla01">&nbsp;</td>
				    <td class="textotabla01">&nbsp;</td>
				    <td class="textotabla01">&nbsp;</td>
				    <td class="textotabla01">&nbsp;</td>
			    </tr>
			<tr>
				<td width="5%"  class="botones1">TERCERO</td>
            	<td width="5%"  class="botones1">CUENTA</td>
            	<td width="5%"  class="botones1">CONCEPTO</td>
				<td width="5%"  class="botones1">DEBITO</td>
				<td width="5%"   class="botones1">CREDITO</td>
            </tr>';

 	$db = new Database();
	$sql = "SELECT *,CONCAT(cod_contable,'-',desc_cuenta) as cuenta FROM d_movimientos
	INNER JOIN cliente ON cliente.cod_cli = d_movimientos.cod_ter
	INNER JOIN cuenta ON cuenta.cod_cuenta = d_movimientos.cuenta_dmov
	WHERE cod_mov = $codigo AND nivel = 5" ;
	$db->query($sql);
	while($db->next_row()){

		$codigoHTML.='<tr id="fila_0"  >
                  <td  class="textotabla01">'.$db->nom1_cli.'</td>
                  <td  class="textotabla01">'.$db->cuenta.'</td>
				  <td  class="textotabla01"><div align="center">'.$db->concepto_dmov.'</div></td>
                  <td  class="textotabla01"><div align="center">'.$db->debito_dmov.'</div></td>
                  <td  class="textotabla01"><div align="center">'.$db->credito_dmov.'</div></td>';
    			
				 $total_debitos = $total_debitos + $db->debito_dmov;
				 $total_creditos = $total_creditos + $db->credito_dmov;
				} 

    $codigoHTML.='</tr>			 
				  <tr >
				    <td colspan="5" >&nbsp;</td>
			    </tr>
				  <tr >
				    <td colspan="4" ><strong><div align="right">Total debitos:</div></strong></td>
				    <td ><strong><div align="right">'.number_format($total_debitos,0,".",".").'</div></strong></td>
		        </tr>
				  <tr >
			  
                  <td height="23" colspan="4" ><strong><div align="right">Total creditos:</div></strong></td>
                  <td ><strong><div align="right">'.number_format($total_creditos,0,".",".").'</div></strong></td>
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
			    <div align="left" class="subtitulosproductos">Observaciones:</div>
			  </div></TD>
		      <TD width="87%" valign="top" ><span class="textotabla01">
		        '.$dbv->obs_mov.' 
		      </span></TD>
			</TR>
</TABLE>';

$codigoHTML=utf8_decode($codigoHTML);
$dompdf=new DOMPDF();
$dompdf->load_html($codigoHTML);
ini_set("memory_limit","128M");
$dompdf->render();
$dompdf->stream("Inf_movimientos_".$fec_ini."_".$fec_fin.".pdf");
?>