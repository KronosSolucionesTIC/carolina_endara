<? include("lib/database.php")?>
<? include("js/funciones.php")?>
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
						  <td  class="ctablasup">MODULO  	</td>
						  <td  class="ctablasup">INTERFAZ </td>
						  <td  class="ctablasup">VIDEO</td> 
					    </tr>

						<? 
						
						echo "<tr style='display:none'><td >";
						echo "   </td></tr>  ";						  
						$estilo="ctablablanc";
						$estilo="ctablagris"; $ult_id = 0;
						$sql="SELECT * FROM interfaz INNER JOIN modulos ON  modulos.cod_mod=interfaz.cod_mod_int ORDER BY cod_mod , cod_per";
						$db->query($sql);  #consulta paginada
						
						while($db->next_row()) {;
							if ($aux==0) { $estilo="ctablablanc"; $aux=1; $cambio_celda=$celda_blanca; }else { $estilo="ctablagris";  $cambio_celda=$celda_gris; $aux=0;}
							echo "<tr class='$estilo' $cambio_celda >";
                          	echo "<td >$db->nom_mod</td>";
							echo "<td >$db->nom_int</td> \n";
							$ruta = $db->ruta_video;
							echo "<td  align='center'><a href=$ruta target='_blank'><img src='imagenes/youtube.png' alt='Video'></a></td>"."\n";
						} ?>
                      </table >
                        <table width="624" border="0"  cellpadding="0">
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