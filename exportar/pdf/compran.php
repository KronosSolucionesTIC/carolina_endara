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
<TABLE width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999">
			  	<tr>
			  		<td colspan="6"><div align="center" class="ctablasup">CLIENTES QUE MAS COMPRAN</div></td>
			    </tr>
			    <tr>
			      <td align="center">CLIENTE</td>
			      <td align="center">CEDULA</td>
			      <td align="center">TIPO</td>
			      <td align="center">FACTURA</td>
			      <td align="center">FECHA</td>
			      <td align="center">VALOR</td>
		        </tr>';

		        //REALIZA LA CONSULTA DE VENTAS
		        $db = new database();
		        $sql = "SELECT iden_cli,tipo_fac,num_fac,tot_fac,CONCAT(nom1_cli,' ',nom2_cli,' ',apel1_cli,' ',apel2_cli) as nombre,DATE(DATE(FECHA)) as fec FROM m_factura
		        INNER JOIN cliente ON cliente.cod_cli = m_factura.cod_cli
		        WHERE estado is null
		        GROUP BY cod_fac
				ORDER BY tot_fac DESC";
		        $db->query($sql);
		        while($db->next_row()){

	$codigoHTML.='<tr >
                   <td ><div >'.$db->nombre.'</div></td>
                   <td ><div >'.$db->iden_cli.'</div></td>
                   <td ><div >'.$db->tipo_fac.'</div></td>
                   <td ><div >'.$db->num_fac.'</div></td>
                   <td ><div >'.$db->fec.'</div></td>
                   <td align="center">'.'$'.number_format($db->tot_fac,'.','.','.').'</td>
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
$dompdf->stream("Clientes_mas_compran.pdf");
?>