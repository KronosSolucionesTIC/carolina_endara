<?php include("../../lib/database.php");?>
<?php include("../../js/funciones.php");?>
<? 
//CODIGO PARA GUARDAR COMO EXCEL
header ( "Content-type: application/x-msexcel" );
header ( "Content-Disposition: attachment; filename=Descuadrados.xls" );
header ( "Content-Description: Generador XLS" );

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
            			</tr>
    <?php  
    $db = new Database();
	$sql = "SELECT fec_emi,desc_tmov,conse_mov,SUM(debito_dmov) AS debitos,SUM(credito_dmov) AS creditos FROM d_movimientos
	INNER JOIN m_movimientos ON m_movimientos.cod_mov = d_movimientos.cod_mov
	INNER JOIN tipo_movimientos ON tipo_movimientos.cod_tmov = m_movimientos.tipo_mov
	GROUP BY m_movimientos.cod_mov" ;
	$db->query($sql);
	while($db->next_row()){
		if($db->creditos != $db->debitos){
	?>
                <tr id="fila_0"  >
                  <td  class="textotabla01"><?php echo $db->desc_tmov?></td>
                  <td  class="textotabla01"><?php echo $db->conse_mov?></td>
                  <td  class="textotabla01"><?php echo $db->fec_emi?></td>
    <?php 
        }
	} 
	?>
			    </tr>			 
				  <tr >
				    <td colspan="3" >&nbsp;</td>
			    </tr>
</TABLE>
</body>
</html>