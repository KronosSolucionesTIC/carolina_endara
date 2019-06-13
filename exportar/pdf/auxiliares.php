<?php require_once("../../lib/dompdf/dompdf_config.inc.php");?>
<?php include("../../lib/database.php");?>
<?php include("../../js/funciones.php");?>
<?php 

//RECIBE LAS VARIABLES
$fec_ini = $_REQUEST['fec_ini'];
$fec_fin = $_REQUEST['fec_fin'];
$auxiliar = $_REQUEST['auxiliar'];

$codigoHTML='
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/html1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="http://app.skala.hostei.com/Blue_version_2_0/css/styles.css" rel="stylesheet" type="text/css" />
<title><?=$nombre_aplicacion?></title>
</head>
<body>
<table width="100%" border="1" bordercolor="#333333" id="select_tablas" >
	<TR>
		<TD align="center">
		<TABLE width="98%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" >
			<TR>
			  <TD width="100%" class="txtablas">
			  <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#333333">
			  	<tr>
			  		<td width="47%" height="26"><div align="center"><span class="Estilo4">INFORME DE AUXILIARES DE
	  		      '.$fec_ini.' HASTA '.$fec_fin.'</span></div></td>
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
			</tr>';

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

	$codigoHTML.='<tr >
                   <td ><div >'.$db->cod_contable.'</div></td>
                   <td ><div >'.$db->fec_emi.'</div></td>
                   <td ><div >'.$db->conse_mov.'</div></td>
                   <td ><div >'.$db->iden_cli.'</div></td>
                   <td ><div >'.$db->digito_cli.'</div></td>
                   <td ><div >'.$db->nom1_cli.'</div></td>
                   <td ><div align="right">'.number_format($db->debito_dmov,0,".",".").'</div>
                   <div ></div></td>
                   <td ><div align="right">'.number_format($db->credito_dmov,0,".",".").'</div></td>
                 </tr>';

				$total_debito = $total_debito + $db->debito_dmov;
				$total_credito = $total_credito + $db->credito_dmov;
				} 		

		$codigoHTML.='<tr>
				    <td colspan="5" ><div align="right"><span >TOTAL</span></div></td>
				    <td ><div align="right">
				      '.number_format($total_debito,0,".",".").'
			        </div></td>
				    <td ><div align="right">'.number_format($total_credito,0,".",".").'</div></td>
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
</html>';

$codigoHTML=utf8_decode($codigoHTML);
$dompdf=new DOMPDF();
$dompdf->load_html($codigoHTML);
ini_set("memory_limit","128M");
$dompdf->render();
$dompdf->stream("Inf_auxiliares_".$fec_ini."_".$fec_fin.".pdf");
?>