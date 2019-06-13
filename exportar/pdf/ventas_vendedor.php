<?php require_once("../../lib/dompdf/dompdf_config.inc.php");?>
<?php include("../../lib/database.php");?>
<?php include("../../js/funciones.php");?>
<?php 

//RECIBE LAS VARIABLES
$vendedor = $_REQUEST['vendedor'];
$fec_ini = $_REQUEST['fec_ini'];
$fec_fin = $_REQUEST['fec_fin'];

//CONSULTA EL VENDEDOR
$db = new Database();
$sql = "SELECT * FROM vendedor
WHERE vendedor.`cod_ven` = $vendedor";
$db->query($sql);
if($db->next_row()){
	$vend = $db->nom_ven;
}	

//VENTAS CON DESCUENTO
$bono_tipo = 0;
$db1 = new Database();
$sql1 = "SELECT *,DATE(DATE(FECHA)) as fec FROM `m_factura`
INNER JOIN vendedor ON vendedor.cod_ven = m_factura.cod_ven 
INNER JOIN d_factura ON d_factura.cod_mfac = m_factura.cod_fac
WHERE vendedor.`cod_ven` = $vendedor AND m_factura.estado is null
GROUP BY cod_dfac
HAVING (fec >= '$fec_ini') AND (fec <= '$fec_fin')";
$db1->query($sql1);
while($db1->next_row()){ 
	//CONSULTA EL TIPO DE BONO
	$bono_tipo = 0;
	$dbtp = new database();
	$sqltp = "SELECT * FROM bono
	INNER JOIN tipo_bono ON tipo_bono.cod_tbono = bono.tipo_bono
	WHERE cod_tbono = $db1->bono_fac";
	$dbtp->query($sqltp);
	if($dbtp->next_row()){
		if(($dbtp->tipo_bono == 1)or($dbtp->tipo_bono == 3)or($dbtp->tipo_bono == 5)){
			$bono_tipo = 1;
		}
	}

	if(($db1->desc_pro > 0)or($bono_tipo > 0)){
		$con_dcto = $con_dcto + $db1->total_pro;
	}
}

//VENTAS SIN DESCUENTO
$db2 = new Database();
$sql2 = "SELECT *,DATE(DATE(FECHA)) as fec FROM `m_factura`
INNER JOIN vendedor ON vendedor.cod_ven = m_factura.cod_ven 
INNER JOIN d_factura ON d_factura.cod_mfac = m_factura.cod_fac
WHERE vendedor.`cod_ven` = $vendedor AND m_factura.estado is null
GROUP BY cod_dfac
HAVING (fec >= '$fec_ini') AND (fec <= '$fec_fin')";
$db2->query($sql2);	
while($db2->next_row()){
	if(($db2->desc_pro == 0)and($db2->bono_fac == 0)){
		$sin_dcto = $sin_dcto + $db2->total_pro;
	}
}

//VENTAS TOTALES
$db3 = new Database();
$sql3 = "SELECT *,DATE(DATE(FECHA)) as fec FROM `m_factura`
INNER JOIN vendedor ON vendedor.cod_ven = m_factura.cod_ven 
INNER JOIN d_factura ON d_factura.cod_mfac = m_factura.cod_fac
WHERE vendedor.`cod_ven` = $vendedor AND m_factura.estado is null
GROUP BY cod_dfac
HAVING (fec >= '$fec_ini') AND (fec <= '$fec_fin')";
$db3->query($sql3);	
while($db3->next_row()){ 
	$total = $total + $db3->total_pro;
}

//CONSULTA LO DEL BONO CON DESCUENTO
$dbb1 = new Database();
$sqlb1 = "SELECT *,DATE(DATE(FECHA)) as fec FROM `m_factura`
INNER JOIN d_factura ON d_factura.cod_mfac = m_factura.cod_fac
INNER JOIN bono ON bono.cod_bono = m_factura.bono_fac
WHERE `cod_ven` = $vendedor AND m_factura.estado is null
GROUP BY cod_mfac
HAVING (fec >= '$fec_ini') AND (fec <= '$fec_fin')";
$dbb1->query($sqlb1);	
if($dbb1->next_row()){
	if(($dbb1->desc_pro > 0)or($dbb1->bono_fac > 0)){
		$bono_con = $dbb1->valor_bono;
	}
}

//CONSULTA LO DEL BONO SIN DESCUENTO
$dbb2 = new Database();
$sqlb2 = "SELECT *,DATE(DATE(FECHA)) as fec FROM `m_factura`
INNER JOIN d_factura ON d_factura.cod_mfac = m_factura.cod_fac
INNER JOIN bono ON bono.cod_bono = m_factura.bono_fac
WHERE `cod_ven` = $vendedor AND m_factura.estado is null
GROUP BY cod_mfac
HAVING (fec >= '$fec_ini') AND (fec <= '$fec_fin')";
$dbb2->query($sqlb2);	
if($dbb2->next_row()){
	if(($dbb2->desc_pro = 0)or($dbb2->bono_fac = 0)){
		$bono_sin = $dbb2->valor_bono;
	}
}

//CONSULTA LO DEL BONO TOTAL
$dbb3 = new Database();
$sqlb3 = "SELECT *,DATE(DATE(FECHA)) as fec FROM `m_factura`
INNER JOIN d_factura ON d_factura.cod_mfac = m_factura.cod_fac
INNER JOIN bono ON bono.cod_bono = m_factura.bono_fac
WHERE `cod_ven` = $vendedor AND m_factura.estado is null
GROUP BY cod_mfac
HAVING (fec >= '$fec_ini') AND (fec <= '$fec_fin')";
$dbb3->query($sqlb3);	
if($dbb3->next_row()){
	$bono_tot = $dbb3->valor_bono;
}

//RESTA LOS BONOS
$tot_con = $con_dcto - $bono_con;
$tot_sin = $sin_dcto - $bono_sin;
$tot_tot = $total - $bono_tot;

//SACA * DE IVA 
$tot_con_base = $tot_con / 1.19;
$tot_sin_base = $tot_sin / 1.19;
$tot_tot_base = $tot_tot / 1.19;

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
			  		<td colspan="3"><div align="center" class="ctablasup">VENTAS X VENDEDOR DESDE '.$fec_ini.' HASTA '.$fec_fin.'<br>VENDEDORA '.$vend.'</div></td>
			    </tr>		
			    <tr >
			      <td  class="botones1"></td>
			      <td align="center">CON IVA</td>
			      <td align="center">SIN IVA</td>
		        </tr>
			    <tr >
			      <td  class="botones1">VENTAS CON DESCUENTO</td>
			      <td align="right">'.number_format($tot_con,'.','.','.').'</td>
			      <td align="right">'.number_format($tot_con_base,'.','.','.').'</td>
		        </tr>
			    <tr >
			      <td  class="botones1">VENTAS SIN DESCUENTO</td>
			      <td align="right">'.number_format($tot_sin,'.','.','.').'</td>
			      <td align="right">'.number_format($tot_sin_base,'.','.','.').'</td>
		        </tr>
			    <tr >
			      <td  class="botones1">VENTAS TOTALES</td>
			      <td align="right">'.number_format($tot_tot,'.','.','.').'</td>
			      <td align="right">'.number_format($tot_tot_base,'.','.','.').'</td>
		        </tr>				 
</TABLE>';

$codigoHTML=utf8_decode($codigoHTML);
$dompdf=new DOMPDF();
$dompdf->load_html($codigoHTML);
ini_set("memory_limit","128M");
$dompdf->render();
$dompdf->stream("Inf_ventas_vendedor.pdf");
?>