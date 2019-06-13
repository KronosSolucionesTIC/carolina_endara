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
<TABLE width="98%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" >
			  	<tr>
			  		<td colspan="2"><div align="center" class="ctablasup">VENTAS TOTALES DESDE '.$fec_ini.' HASTA '.$fec_fin.'</div></td>
			    </tr>
			    <tr>
			      <td align="center">TIPO</td>
			      <td align="center">TOTAL</td>
		        </tr>';

		        //REALIZA LA CONSULTA DE VENTAS
		        $total_a = 0;
		        $total_b = 0;
		        $db = new database();
		        $sql = "SELECT * ,DATE(DATE(FECHA)) as fec FROM m_factura
		        INNER JOIN cliente ON cliente.cod_cli = m_factura.cod_cli
		        WHERE estado is null $where
		        GROUP BY cod_fac
				HAVING (fec >= '$fec_ini') AND (fec <= '$fec_fin')
				ORDER BY tipo_fac,fec";
		        $db->query($sql);
		        while($db->next_row()){
		        	if($db->tipo_fac == 'A'){
		        		$total_a = $total_a + $db->tot_fac;
		        	} else {
		        		$total_b = $total_b + $db->tot_fac;
		        	}
		        }	

	$codigoHTML.='<tr >
                   <td ><div >'.'A'.'</div></td>
                   <td ><div >'.'$'.number_format($total_a,'.','.','.').'</div></td>
                 </tr>
				<tr>
                   <td ><div >'.'B'.'</div></td>
                   <td ><div >'.'$'.number_format($total_b,'.','.','.').'</div></td>
                 </tr>';	

		$codigoHTML.='
</TABLE>
</body>
</html>';

$codigoHTML=utf8_decode($codigoHTML);
$dompdf=new DOMPDF();
$dompdf->load_html($codigoHTML);
ini_set("memory_limit","128M");
$dompdf->render();
$dompdf->stream("Ventas_totales_".$fec_ini."_".$fec_fin.".pdf");
?>