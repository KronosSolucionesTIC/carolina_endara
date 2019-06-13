<?php include("lib/database.php");?>
<?php include("js/funciones.php");?>
<? header ( "Content-type: application/x-msexcel" );
	header ( "Content-Disposition: attachment; filename=puc.xls" );
	header ( "Content-Description: Generador XLS" );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$nombre_aplicacion?></title>

</head>
<body>
<table width="837" border="0"  cellpadding="0">
                        <tr>                          
						  <td  class="ctablasup">CODIGO</td>
						  <td  class="ctablasup">NOMBRE</td>
                        </tr>
						<? 				
						$sql="SELECT * from `cuenta` order by cod_contable";
						//echo $sql;
						$db->query($sql); 
						while($db->next_row()) {
							echo "<tr >  ";
                          	echo "<td>$db->cod_contable</td>";
							echo "<td>$db->desc_cuenta</td>";
							echo "</tr>";
						} ?>
</table >
</body>
</html>