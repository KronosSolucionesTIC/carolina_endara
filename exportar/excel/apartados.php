<?php include("../../lib/database.php");?>
<?php include("../../js/funciones.php");?>
<? 
//CODIGO PARA GUARDAR COMO EXCEL
header ( "Content-type: application/x-msexcel" );
header ( "Content-Disposition: attachment; filename=Apartados.xls" );
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
			  		<td><div align="center">INFORME DE APARTADOS</div></td>
			    </tr>			
			    <tr >
			      <td  class="botones1"><div align="center">NUMERO</div></td>
			      <td   class="botones1"><div align="center">ESTADO</div></td>
			      <td  class="botones1"><div align="center">FECHA</div></td>
			      <td  class="botones1"><div align="center">DIAS</div></td>
			      <td   class="botones1"><div align="center">FACTURA</div></td>
		        </tr>
                
			    <?
				$total=0;
				$sql = " SELECT *,m_factura.cod_apa as codigo_apartado,DATEDIFF(DATE(DATE(m_factura.fecha)),DATE(DATE(m_apartado.fecha))) AS dias,DATE(DATE(m_apartado.fecha)) as fec FROM m_apartado
				LEFT JOIN otros_pagos ON otros_pagos.cod_apa = m_apartado.cod_apa
				LEFT JOIN m_factura ON m_factura.cod_apa = m_apartado.cod_apa";
					$db->query($sql);
					$estilo="formsleo";
					while($db->next_row()){	
				?>
                <tr id="fila_0"  >
				   <td class="textotabla01"><?php echo $db->num_apa?></td>
				   <?php 
				   	if($db->estado_apa == 1){ 
				   		$estado = 'PENDIENTE';
				   	} else { 
				   		$estado = 'REDIMIDO';
				   	}
				   ?>
				   <td class="textotabla01"><?php echo $estado?></td>
				   <td class="textotabla01"><?php echo $db->fec?></td>
				   <td class="textotabla01"><?php echo $db->dias?></td>
				   <td class="textotabla01"><?php echo $db->num_fac ?> </td>
			    </tr>
				  
				<?
	
				  } 
				 
				 ?>
				 
				  <tr >
			  
                  <td colspan="6" >&nbsp;</td>
				  </tr>
</TABLE>
</body>
</html>