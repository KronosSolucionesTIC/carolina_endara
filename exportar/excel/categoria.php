<?php include("../../lib/database.php");?>
<?php include("../../js/funciones.php");?>
<? 
//CODIGO PARA GUARDAR COMO EXCEL
header ( "Content-type: application/x-msexcel" );
header ( "Content-Disposition: attachment; filename=Ventas_Categoria.xls" );
header ( "Content-Description: Generador XLS" );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$nombre_aplicacion?></title>
</head>
<body>
<TABLE width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" >
			  	<tr>
			  		<td><div align="center" class="ctablasup">VENTAS X CATEGORIA DESDE <?=$fec_ini?> HASTA <?=$fec_fin?></div></td>
			    </tr>
			    <tr>
			      <td align="center">CATEGORIA</td>
			      <td align="center">CANTIDAD</td>
			      <td align="center">PORCENTAJE</td>
		        </tr>
		        <?php
		        //SUMA EL TOTAL
		        $total = 0;
		        $dbt = new database();
		        $sqlt = "SELECT *,COUNT(cant_pro) as cantidad,DATE(DATE(FECHA)) as fec FROM m_factura
		        INNER JOIN d_factura ON d_factura.cod_mfac = m_factura.cod_fac
		        INNER JOIN marca ON marca.cod_mar = d_factura.cod_cat
		        WHERE estado is null
		        GROUP BY cod_cat
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
		        WHERE estado is null
		        GROUP BY cod_cat
				HAVING (fec >= '$fec_ini') AND (fec <= '$fec_fin')
				ORDER BY cantidad DESC";
		        $db->query($sql);
		        while($db->next_row()){
		        	//SACA PORCENTAJE
		        	$porcentaje = round($db->cantidad * 100 / $total) ;
		        ?>
			    <tr>
			      <td align="center"><?php echo $db->nom_mar?></td>
			      <td align="center"><?php echo $db->cantidad?></td>
			      <td align="center"><?php echo $porcentaje.'%'?></td>
		        </tr>
		        <?php } ?>			 
				<tr>			  
                  <td align="center">Total:</td>
                  <td align="center"><?php echo number_format($total,'.','.','.')?></td>
                  <td align="center"><?php echo '100%'?></td>
				</tr>
</TABLE>
</body>
</html>