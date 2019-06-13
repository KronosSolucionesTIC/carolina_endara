<?php include("../../lib/database.php");?>
<?php include("../../js/funciones.php");?>
<? 
//CODIGO PARA GUARDAR COMO WORD
header ( "Content-type: application/vnd.ms-word" );
header ( "Content-Disposition: attachment; filename=Descuadrados.doc" );

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
		<TABLE width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" >
		
			<INPUT type="hidden" name="mapa" value="<?PHP echo $mapa?>">
			<INPUT type="hidden" name="id" value="<?PHP echo $id?>">

			<TR>
			  <TD colspan="2" class='txtablas'>
			  <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#333333">
			  	<tr>
			  		<td width="47%" height="22" class="textotabla01"><div align="center">MOVIMIENTOS CONTABLES</div></td>
			    </tr>
				</table>					</TD>
		  </TR>
			
			
			<TR>
				<TD colspan="2" align="center">
					<table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="#333333" id="select_tablas" >
						<tr >
							<td width="5%"  class="botones1">TIPO</td>
            				<td width="5%"  class="botones1">No DOC</td>
            				<td width="5%"  class="botones1">FECHA</td>
            			</tr>
    <?PHP  
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
                  <td  class="textotabla01"><?PHP echo $db->desc_tmov?></td>
                  <td  class="textotabla01"><?PHP echo $db->conse_mov?></td>
                  <td  class="textotabla01"><?PHP echo $db->fec_emi?></td>
    <?PHP 
        }
	} 
	?>
			    </tr>			 
				  <tr >
				    <td colspan="5" >&nbsp;</td>
			    </tr>
              </table></TD>
		  </TR>
</TABLE>
</body>
</html>