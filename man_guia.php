<? include("lib/database.php")?>
<? include("js/funciones.php")?>
<? 
if($enviar==1)
{
$db1= new  Database();
$sql="DELETE FROM permisos WHERE cod_usu_per=".$codigo;
$db1->query($sql);  
$db1->close();
//$sql="";
$db1= new  Database();
$db2= new  Database();
$sql="SELECT  cod_int  from interfaz ";
$db1->query($sql);  
while($db1->next_row()) {
	for ($a=1; $a<5; $a++) {
		if ( $_POST["check_".$db1->cod_int."_$a"]=="checkbox") 
			$valor[$a]=1;
		else 
			$valor[$a]=0;
	}
	
	$sql="INSERT INTO permisos (cod_usu_per, cod_int_per, con_per, ins_per,edi_per, eli_per)  VALUES($codigo,$db1->cod_int,$valor[1],$valor[2],$valor[3], $valor[4])";
	$db2->query($sql);  
	//$db2->close();
}
$db1->close();

$e=1;
if($e==1) {
	header("Location: con_permisos.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	
}
}

?>

<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$nombre_aplicacion?></title>
<script type="text/javascript">
var tWorkPath="menus/data.files/";
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value + "'");
  if (restore) selObj.selectedIndex=0;
}

function  guardar() {
	document.getElementById('enviar').value=1
	document.forma_total.submit()
}
</script>
<script type="text/javascript" src="js/funciones.js"></script>
 <link href="css/styles.css" rel="stylesheet" type="text/css">
</head>
<body  <?=$sis?> >

<table align="center">
<tr>
<td height="94" valign="top" >
<form id="forma_total" name="forma_total" method="post" action="man_permisos.php">                 
                  <table width="624" border="0" cellspacing="0" cellpadding="0" align="center" >
                    
                    <tr>
                      <td><table width="624" border="0"  cellpadding="0">
                        <tr> 
						  <td width="336"  class="ctablasup">GUIA</td>
						  <td width="282"  class="ctablasup">DESCARGAR</td>
					    </tr>	
						<? 
						
							echo "<tr class='$estilo' $cambio_celda >";
                          	echo "<td >Guia tecnica</td>";
							echo "<td ><div align='center'><a href='formatos/guia.docx'><img src='imagenes/word.png'></a></div></td> \n";
							echo " </tr> ";
							?>
						
                      </table ></td>
                    </tr>
                    <tr>
                      <td  align="center"><img src="imagenes/lineasup3.gif" width="624" height="4" /></td>
                    </tr>
                    <tr>
                      <td height="6" align="center" valign="bottom"><table>
                        <tr>
                          <td>  </td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>
				 
      </form>
</td>
</tr>
</table>						
</body>
</html>