<?php include("../../lib/database.php");?>
<?php include("../../js/funciones.php");?>
<? 
//CODIGO PARA GUARDAR COMO EXCEL
header ( "Content-type: application/x-msexcel" );
header ( "Content-Disposition: attachment; filename=Ventas_totales.xls" );
header ( "Content-Description: Generador XLS" );

//RECIBE LAS VARIABLES
$fec_ini = $_REQUEST['fec_ini'];
$fec_fin = $_REQUEST['fec_fin'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$nombre_aplicacion?></title>
</head>
<body>
<TABLE width="100%" border="0" cellspacing="0" cellpadding="0"   >
	
	<TR>
		<TD align="center">
		<TABLE width="98%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" >
		
			<INPUT type="hidden" name="mapa" value="<?=$mapa?>">
			<INPUT type="hidden" name="id" value="<?=$id?>">
			<INPUT type="hidden" name="fec_ini" id="fec_ini"  value="<?=$fec_ini?>">
			<INPUT type="hidden" name="fec_fin" id="fec_fin" value="<?=$fec_fin?>">
			<INPUT type="hidden" name="vendedor" id="vendedor"  value="<?=$vendedor?>">


			<TR>
			  <TD width="100%" class='txtablas'>
			  <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#333333">
			  	<tr>
			  		<td><div align="center" class="ctablasup">VENTAS TOTALES DESDE <?=$fec_ini?> HASTA <?=$fec_fin?></div></td>
			    </tr>
				</table>					</TD>
		  </TR>
			
			
			<TR>
			  <TD align="center">
			  <table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="#333333" id="select_tablas" >
			    <tr>
			      <td align="center">TIPO</td>
			      <td align="center">TOTAL</td>
		        </tr>
		        <?php
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
		        ?>
			    <tr>
			      	<td align="center"><?php echo 'A'?></td>
			      	<td align="center"><?php echo '$'.number_format($total_a,'.','.','.')?></td>
		        </tr>
			    <tr>
			      	<td align="center"><?php echo 'B'?></td>
					<td align="center"><?php echo '$'.number_format($total_b,'.','.','.')?></td>
		        </tr>			    		 
				<tr>			  
                  <td colspan="6" align="CENTER"><input name="button" type="button"  class="botones" id="detalle" onClick="detalle()" value="DETALLE"></td>
				</tr>

              </table></TD>
		  </TR>
			<TR>
			  <TD align="center">             </TD>
		  </TR>
			<TR>
			  <TD align="center"><p></TD>
		  </TR>
</TABLE>
</body>
</html>