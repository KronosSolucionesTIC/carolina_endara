<?php require_once("../../lib/dompdf/dompdf_config.inc.php");?>
<?php include("../../lib/database.php");?>
<?php include("../../js/funciones.php");?>
<?php 

//RECIBE LAS VARIABLES
$fec_ini = $_REQUEST['fec_ini'];
$fec_fin = $_REQUEST['fec_fin'];
$cliente = $_REQUEST['cliente'];
$cuenta = $_REQUEST['cuenta'];

if($cliente > 0){
	$where_cliente = " AND cod_cli = $cliente";
} else {
	$where_cliente = "";
}

if($cuenta > 0){
	$where_cuenta = " AND cod_cuenta = $cuenta";
} else {
	$where_cuenta = "";
}

$codigoHTML='
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/html1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="http://app.skala.hostei.com/Blue_version_2_0/css/styles.css" rel="stylesheet" type="text/css" />
<title><?=$nombre_aplicacion?></title>
</head>
<body>
 <TABLE  width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#333333">
			  	<tr>
			  		<td colspan="6"><div align="center"><span class="Estilo4">BALANCE DE PRUEBA DE '.$fec_ini.' HASTA '.$fec_fin.'</span></div></td>
			    </tr>		
			<tr >
            <td  class="botones1"><div align="center">CUENTA</div></td>
            <td  class="botones1"><div align="center">NOMBRE DE LA CUENTA</div></td>
            <td   class="botones1"><div align="center">SALDO INICIAL</div></td>
            <td  class="botones1"><div align="center">DEBITOS</div></td>
            <td  class="botones1"><div align="center">CREDITOS</div></td>
			<td  class="botones1"><div align="center">NUEVO SALDO</div></td>
            </tr>';

				$db = new Database ();
				$sql = "SELECT * FROM cuenta
				INNER JOIN d_movimientos ON d_movimientos.cuenta_dmov = cuenta.cod_cuenta
				INNER JOIN m_movimientos ON m_movimientos.cod_mov = d_movimientos.cod_mov
				WHERE (fec_emi >='$fec_ini') AND (fec_emi <='$fec_fin') AND estado_mov = 1 $where_cliente $where_cuenta
				GROUP BY cod_cuenta
				ORDER BY  `cuenta`.`cod_contable` ASC";
				$db->query($sql);
				$estilo="formsleo";
				$total_saldo = 0;
				$total_debito = 0;
				$total_credito = 0;
				$total_nuevo_saldo = 0;
				while($db->next_row()){	

	$codigoHTML.='<tr id="fila_0"  >';

    if($db->nivel == 5){ 

    $codigoHTML.='<td  class="textotabla01">'.$db->cod_contable.'</td>';

     } else {
 	
 	$codigoHTML.='<td  class="textotabla01">'.$db->cod_contable.'</td>';
 				
 	 }          
	
	$codigoHTML.='<td  class="textotabla01">'.$db->desc_cuenta.'</td>';

                $dbsi = new Database ();
				$sqlsi = "SELECT SUM(debito_dmov) AS suma_debito,SUM(credito_dmov) AS suma_credito FROM `d_movimientos`
				INNER JOIN m_movimientos ON m_movimientos.cod_mov = d_movimientos.cod_mov
				where cuenta_dmov = $db->cod_cuenta AND (fec_emi <='$fec_ini') AND estado_mov = 1";
				$dbsi->query($sqlsi);
				$dbsi->next_row();	

				$saldo = $dbsi->suma_debito - $dbsi->suma_credito;
				
				if ($db->nivel == 5){
					$total_saldo = $total_saldo + $saldo;
				}

	$codigoHTML.='<td class="textotabla01"><div align="right">'.$saldo.'</div></td>';

	            $dbb = new Database ();
				$sqlb = "SELECT sum(debito_dmov) as debito FROM `d_movimientos`
				INNER JOIN m_movimientos ON m_movimientos.cod_mov = d_movimientos.cod_mov
				where cuenta_dmov = $db->cod_cuenta AND ((fec_emi >='$fec_ini')AND(fec_emi <='$fec_fin')) AND estado_mov = 1";
				$dbb->query($sqlb);
				$dbb->next_row();						
				if($dbb->debito == ""){
					$debito = 0;	
				}
				else {
					$debito = $dbb->debito;
				};
				if ($db->nivel == 5){
					$total_debito = $total_debito + $debito;
				}

	$codigoHTML.='<td class="textotabla01">
			      <div align="right">'.number_format($debito,0,".",".").'</div>
                  </td>';

				$dbc = new Database ();
				$sqlc = "SELECT sum(credito_dmov) as credito FROM `d_movimientos`
				INNER JOIN m_movimientos ON m_movimientos.cod_mov = d_movimientos.cod_mov
				where cuenta_dmov = $db->cod_cuenta AND ((fec_emi >='$fec_ini')AND(fec_emi <='$fec_fin')) AND estado_mov = 1";
				$dbc->query($sqlc);
				$dbc->next_row();		
				if($dbc->credito == ""){
					$credito = 0;	
				}
				else {
					$credito = $dbc->credito;
				};
				if ($db->nivel == 5){
					$total_credito = $total_credito + $credito;
				}	

	$codigoHTML.='<td class="textotabla01">
			     <div align="right">'.number_format($credito,0,".",".").'</div>
                 </td>';

				 $nuevo_saldo = $saldo + $debito - $credito;
				 
				 if ($db->nivel == 5){
					$total_nuevo_saldo = $total_nuevo_saldo + $nuevo_saldo;
				 }

	$codigoHTML.='<td colspan="1" class="textotabla01"><div align="right">
				   '.number_format($nuevo_saldo,0,".",".").'</div></td>
                </tr>';

            }



	$codigoHTML.='<tr>
                	<td colspan="2" align="right">Totales:</td>	
                	<td>'.number_format($total_saldo,0,".",".").'</td>
                	<td>'.number_format($total_debito,0,".",".").'</td>
                	<td>'.number_format($total_credito,0,".",".").'</td>
                	<td>'.number_format($total_nuevo_saldo,0,".",".").'</td>
                </tr>
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
$dompdf->stream("Balance_prueba_".$fec_ini."_".$fec_fin.".pdf");
?>