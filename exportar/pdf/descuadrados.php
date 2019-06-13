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
			  		<td class="textotabla01" colspan="3"><div align="center">MOVIMIENTOS CONTABLES</div></td>
			    </tr>			
						<tr >
							<td width="5%"  class="botones1">TIPO</td>
            				<td width="5%"  class="botones1">No DOC</td>
            				<td width="5%"  class="botones1">FECHA</td>
            			</tr>';

    $db = new Database();
	$sql = "SELECT fec_emi,desc_tmov,conse_mov,SUM(debito_dmov) AS debitos,SUM(credito_dmov) AS creditos FROM d_movimientos
	INNER JOIN m_movimientos ON m_movimientos.cod_mov = d_movimientos.cod_mov
	INNER JOIN tipo_movimientos ON tipo_movimientos.cod_tmov = m_movimientos.tipo_mov
	GROUP BY m_movimientos.cod_mov" ;
	$db->query($sql);
	while($db->next_row()){
		if($db->creditos != $db->debitos){	

	$codigoHTML.='<tr id="fila_0"  >
                  <td  class="textotabla01">'.$db->desc_tmov.'</td>
                  <td  class="textotabla01">'.$db->conse_mov.'</td>
                  <td  class="textotabla01">'.$db->fec_emi.'</td>';

        }
	} 		

		$codigoHTML.='</tr>			 
				  <tr >
				    <td colspan="3" >&nbsp;</td>
			    </tr>
</TABLE>
</body>
</html>';

$codigoHTML=utf8_decode($codigoHTML);
$dompdf=new DOMPDF();
$dompdf->load_html($codigoHTML);
ini_set("memory_limit","128M");
$dompdf->render();
$dompdf->stream("Descuadrados.pdf");
?>