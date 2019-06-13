<?php include("../../lib/database.php");?>
<?php include("../../js/funciones.php");?>
<? 
//CODIGO PARA GUARDAR COMO EXCEL
header ( "Content-type: application/x-msexcel" );
header ( "Content-Disposition: attachment; filename=Cumplea&ntilde;os.xls" );
header ( "Content-Description: Generador XLS" );
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
			  		<td><div align="center" class="ctablasup">INFORME DE CUMPLEAÑOS</div></td>
			    </tr>
				</table>					</TD>
		  </TR>
			
			
			<TR>
			  <TD align="center">
			  <table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="#333333" id="select_tablas" >
			    <tr>
			      <td align="center">CLIENTE</td>
			      <td align="center">FECHA</td>
		        </tr>
		        <?php
		        //REALIZA LA CONSULTA DE VENTAS
		        $db = new database();
		        $sql = "SELECT *,CONCAT(nom1_cli,' ',nom2_cli,' ',apel1_cli,' ',apel2_cli) as nombre,MONTH(fcun_cli) as mes,DAY(fcun_cli) as dia FROM cliente
		        WHERE estado_cli = 1 AND fcun_cli != '00-00-0000'
		        ORDER BY mes,dia";
		        $db->query($sql);
		        while($db->next_row()){
		        	$mes = $db->mes;

		//FUNCION PARA LOS MESES
    	if($mes=="01"){$mes = "Enero";}
		if($mes=="02"){$mes = "Febrero";}
		if($mes=="03"){$mes = "Marzo";}
		if($mes=="04"){$mes = "Abril";}
		if($mes=="05"){$mes = "Mayo";}
		if($mes=="06"){$mes = "Junio";}
		if($mes=="07"){$mes = "Julio";}
		if($mes=="08"){$mes = "Agosto";}
		if($mes=="09"){$mes = "Septiembre";}
		if($mes=="10"){$mes = "Octubre";}
		if($mes=="11"){$mes = "Noviembre";}
		if($mes=="12"){$mes = "Diciembre";}
	     
	     ?>
			    <tr>
			      <td align="center"><?php echo $db->nombre?></td>
			      <td align="center"><?php echo $db->dia.' de '.$mes?></td>
		        </tr>
		        <?php } ?>			 
				<tr>			  
                  <td colspan="3" >&nbsp;</td>
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