<?php require_once("../../lib/dompdf/dompdf_config.inc.php");?>
<?php include("../../lib/database.php");?>
<?php include("../../js/funciones.php");?>
<?php 

//RECIBE LAS VARIABLES
$fec_ini = $_REQUEST['fec_ini'];
$fec_fin = $_REQUEST['fec_fin'];

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
	<tr>
		<td colspan="3"><div align="center"><span class="Estilo4">BALANCE DETALLADO DE '.$fec_ini.' HASTA '.$fec_fin.'</span></div></td>
	</tr>
    <tr>
    	<td class="botones1"><div align="center">CUENTA</div></td>
        <td class="botones1"><div align="center">NOMBRE DE LA CUENTA</div></td>
        <td class="botones1"><div align="center">SALDO</div></td>
    </tr>';

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

	$codigoHTML.='<tr id="fila_0"  >
          <td  class="textotabla01">'.$db->cod_contable.'</td>
          <td  class="textotabla01">'.$db->desc_cuenta.'</td>';

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

		$codigoHTML.='<td colspan="1" class="textotabla01"><div align="right">
            '.number_format($nuevo_saldo,0,".",".").'
          </div></td>
        </tr>';
    			
    			}

    $codigoHTML.='<tr>
    	<td colspan="3" >&nbsp;</td>
    </tr>
        <tr>
          <td colspan="2" ><div align="right"><strong>Total activo:</strong></div></td>
          <td ><div align="right"> <strong>
            '.number_format($total_nuevo_saldo,0,".",".").'
          </strong></div></td>
        </tr>
        <tr>
          <td colspan="3" >&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" >&nbsp;</td>
        </tr>
        <tr>
          <td width="9%"  class="botones1"><div align="center">CUENTA</div></td>
          <td width="34%"  class="botones1"><div align="center">NOMBRE DE LA CUENTA</div></td>
          <td width="16%"  class="botones1"><div align="center">SALDO</div></td>
        </tr>';

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

	$codigoHTML.='<tr id="fila_0"  >
          <td  class="textotabla01">'.$db->cod_contable.'</td>
          <td  class="textotabla01">'.$db->desc_cuenta.'</td>';

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

				$nuevo_saldo = $saldo + $credito - $debito ;				  				 
				  if ($db->nivel == 1){
					$total_nuevo_saldo = $total_nuevo_saldo + $nuevo_saldo;
				  }

    $codigoHTML.='<td colspan="1" class="textotabla01"><div align="right">
            '.number_format($nuevo_saldo,0,".",".").'
          </div></td>
        </tr>';
    }

    $codigoHTML.='<tr >
          <td colspan="3" >&nbsp;</td>
        </tr>
        <tr >
          <td colspan="2" ><div align="right"><strong>Total pasivo + patrimonio:</strong></div></td>
          <td ><div align="right"> <strong>
            '.number_format($total_nuevo_saldo,0,".",".").'
          </strong></div></td>
        </tr>			 				
</table>
</body>
</html>';

$codigoHTML=utf8_decode($codigoHTML);
$dompdf=new DOMPDF();
$dompdf->load_html($codigoHTML);
ini_set("memory_limit","128M");
$dompdf->render();
$dompdf->stream("Balance_detallado_".$fec_ini."_".$fec_fin.".pdf");
?>