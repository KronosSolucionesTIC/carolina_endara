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
<TABLE width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" >
			  	<tr>
			  		<td colspan="3"><div align="center" class="ctablasup">VENTAS X TIPO DESDE '.$fec_ini.' HASTA '.$fec_fin.'</div></td>
			    </tr>
			    <tr>
			      <td align="center">TIPO</td>
			      <td align="center">CANTIDAD</td>
			      <td align="center">PORCENTAJE</td>
		        </tr>';

		        $total = 0;
		        $dbt = new database();
		        $sqlt = "SELECT *,COUNT(cant_pro) as cantidad,DATE(DATE(FECHA)) as fec FROM m_factura
		        INNER JOIN d_factura ON d_factura.cod_mfac = m_factura.cod_fac
		        INNER JOIN marca ON marca.cod_mar = d_factura.cod_cat
		        INNER JOIN tipo_producto ON tipo_producto.cod_tpro = d_factura.cod_tpro
		        WHERE estado is null
		        GROUP BY tipo_producto.cod_tpro
				HAVING (fec >= '$fec_ini') AND (fec <= '$fec_fin')
				ORDER BY tipo_fac,fec";
		        $dbt->query($sqlt);
		        while($dbt->next_row()){
		        	$total = $total + $dbt->cantidad;
		        }

		        //REALIZA LA CONSULTA DE VENTAS
		        $db = new database();
		        $sql = "SELECT *,COUNT(cant_pro) as cantidad,DATE(DATE(FECHA)) as fec FROM m_factura
		        INNER JOIN d_factura ON d_factura.cod_mfac = m_factura.cod_fac
		        INNER JOIN marca ON marca.cod_mar = d_factura.cod_cat
		        INNER JOIN tipo_producto ON tipo_producto.cod_tpro = d_factura.cod_tpro
		        WHERE estado is null
		        GROUP BY tipo_producto.cod_tpro
				HAVING (fec >= '$fec_ini') AND (fec <= '$fec_fin')
				ORDER BY tipo_fac,fec";
		        $db->query($sql);
		        while($db->next_row()){
		        	//SACA PORCENTAJE
		        	$porcentaje = round($db->cantidad * 100 / $total) ;

	$codigoHTML.='<tr >
                   <td ><div >'.$db->nom_mar.' '.$db->nom_tpro.'</div></td>
                   <td ><div >'.$db->cantidad.'</div></td>
                   <td ><div >'.$porcentaje.'%'.'</div></td>
                 </tr>';

				} 		

		$codigoHTML.='<tr>			  
                  <td align="center">Total:</td>
                  <td align="center">'.number_format($total,'.','.','.').'</td>
                  <td align="center">100%</td>
				</tr>
</TABLE>
</body>
</html>';

$codigoHTML=utf8_decode($codigoHTML);
$dompdf=new DOMPDF();
$dompdf->load_html($codigoHTML);
ini_set("memory_limit","128M");
$dompdf->render();
$dompdf->stream("Ventas_tipo_".$fec_ini."_".$fec_fin.".pdf");
?>