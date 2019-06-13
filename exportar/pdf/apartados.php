<?php require_once("../../lib/dompdf/dompdf_config.inc.php");?>
<?php include("../../lib/database.php");?>
<?php include("../../js/funciones.php");?>
<?php 

$codigoHTML='
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/html1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="http://app.skala.hostei.com/Blue_version_2_0/css/styles.css" rel="stylesheet" type="text/css" />
<title><?=$nombre_aplicacion?></title>
</head>
<body>
<TABLE width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#333333">
			  	<tr>
			  		<td><div align="center">INFORME DE APARTADOS</div></td>
			    </tr>			
			    <tr >
			      <td  class="botones1"><div align="center">NUMERO</div></td>
			      <td   class="botones1"><div align="center">ESTADO</div></td>
			      <td  class="botones1"><div align="center">FECHA</div></td>
			      <td  class="botones1"><div align="center">DIAS</div></td>
			      <td   class="botones1"><div align="center">FACTURA</div></td>
		        </tr>';

				$total=0;
				$sql = " SELECT *,m_factura.cod_apa as codigo_apartado,DATEDIFF(DATE(DATE(m_factura.fecha)),DATE(DATE(m_apartado.fecha))) AS dias,DATE(DATE(m_apartado.fecha)) as fec FROM m_apartado
				LEFT JOIN otros_pagos ON otros_pagos.cod_apa = m_apartado.cod_apa
				LEFT JOIN m_factura ON m_factura.cod_apa = m_apartado.cod_apa";
					$db->query($sql);
					$estilo="formsleo";
					while($db->next_row()){	

				   	if($db->estado_apa == 1){ 
				   		$estado = 'PENDIENTE';
				   	} else { 
				   		$estado = 'REDIMIDO';
				   	}

	$codigoHTML.='<tr >
                   <td ><div >'.$db->num_apa.'</div></td>
                   <td ><div >'.$estado.'</div></td>
                   <td ><div >'.$db->fec.'</div></td>
                   <td ><div >'.$db->dias.'</div></td>
                   <td ><div >'.$db->num_fac.'</div></td>
                 </tr>';

				} 		

		$codigoHTML.='
</TABLE>
</body>
</html>';

$codigoHTML=utf8_decode($codigoHTML);
$dompdf=new DOMPDF();
$dompdf->load_html($codigoHTML);
ini_set("memory_limit","128M");
$dompdf->render();
$dompdf->stream("Apartados.pdf");
?>