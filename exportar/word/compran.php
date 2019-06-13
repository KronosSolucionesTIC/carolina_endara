<?php include("../../lib/database.php");?>
<?php include("../../js/funciones.php");?>
<? 
//RECIBE LAS VARIABLES
header ( "Content-type: application/vnd.ms-word" );
header ( "Content-Disposition: attachment; filename=Clientes_mas_compran.doc" );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
		        </tr>
		        <?php
		        //REALIZA LA CONSULTA DE VENTAS
		        $db = new database();
		        $sql = "SELECT *,CONCAT(nom1_cli,' ',nom2_cli,' ',apel1_cli,' ',apel2_cli) as nombre,DATE(DATE(FECHA)) as fec FROM m_factura
		        INNER JOIN cliente ON cliente.cod_cli = m_factura.cod_cli
		        WHERE estado is null
		        GROUP BY cod_fac
				ORDER BY tot_fac DESC";
		        $db->query($sql);
		        while($db->next_row()){
		        ?>
			    <tr>
			      <td align="center"><?php echo $db->nombre?></td>
			      <td align="center"><?php echo $db->iden_cli?></td>
			      <td align="center"><?php echo $db->tipo_fac?></td>
			      <td align="center"><?php echo $db->num_fac?></td>
			      <td align="center"><?php echo $db->fec.$db->cod_fac?></td>
			      <td align="center"><?php echo '$'.number_format($db->tot_fac,'.','.','.')?></td>
		        </tr>
		        <?php } ?>			 
				<tr>			  
                  <td colspan="6" >&nbsp;</td>
				</tr>
</TABLE>
</body>
</html>