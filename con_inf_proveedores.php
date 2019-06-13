<? include("lib/database.php")?>
<? include("js/funciones.php")?>

<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript" src="calendario/javascript/calendar.js"></script>
<script type="text/javascript" src="calendario/javascript/calendar-es.js"></script>
<script type="text/javascript" src="calendario/javascript/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="calendario/styles/calendar-win2k-cold-1.css" title="win2k-cold-1" />  <script src="utilidades.js" type="text/javascript"> </script>
<title><?=$nombre_aplicacion?></title>
<script type="text/javascript">
var tWorkPath="menus/data.files/";
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

	function abrir() {	
	var valor = document.getElementById('valor').value;
	var filtro = document.getElementById('filtro').value;
		
	imprimir_inf("inf_terceros.php",'0&valor='+valor+"&filtro="+filtro,'mediano');
	}

</script>
<script type="text/javascript" src="js/funciones.js"></script>
<script type="text/javascript" src="informes/inf.js"></script>
 <link href="css/styles.css" rel="stylesheet" type="text/css">
 
</head>
<body  <?=$sis?> >

<table align="center">
<tr>
<td valign="top" >
<form id="forma_total" name="forma_total" method="post" action="formatos/ver_traza.php">
                  <table width="624" border="0" cellspacing="0" cellpadding="0" align="center" >
                    <tr>
                      <td class="tablacabezera"><table width="624" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="217" height="33">  
                            <? if ($insertar==1) {?>
                            <!-- <img src="imagenes/agregar.png" width="16" height="16"  alt="Nuevo Registro" style="cursor:pointer" onClick="location.href='man_traza_general.php?codigo=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>'"/>-->
                          <? } ?>                          <span class="ctablaform">
                            <? if ($insertar==1) {?>
								<!--Agregar-->
							<? } ?>
                          </span></td>
                          <td width="212" class="ctablaform"><label>
                            <div align="center">INF PROVEEDORES</div>
                          </label>                            
                          <div align="center"><!-- en--></div></td>
                          <td width="195" valign="middle"><!--<select name="campos" class="textfieldlista" id="campos" >
                            <option value="0">Seleccion</option>
                            <option value="nom_bod">Bodega</option>
                           	<option value="-1">Lista Completa</option>
                          </select>--><!--<img src="imagenes/lupa.png" width="16" height="16" style="cursor:pointer"  onClick="buscar()"/>--></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="624" border="0"  cellpadding="0">
                        <tr>
                          
						
						  <td  class="ctablasup" >VALOR A BUSCAR</td>
						  <td  class="ctablasup" >FILTRO</td>
                          <td  class="ctablasup"  width="112">INFORME</td>
                        </tr>
						<? 
						
						echo "<tr style='display:none'><td ><form name='forma_0' action='man_traza_general.php'>";
						echo "  </form> </td></tr>  ";						  
						$estilo="ctablablanc";
						$estilo="ctablagris";
						
						//echo $sql;
						
							if ($aux==0) { $estilo="ctablablanc"; $aux=1; $cambio_celda=$celda_blanca; }else { $estilo="ctablagris";  $cambio_celda=$celda_gris; $aux=0;}
							echo "<tr class='$estilo' $cambio_celda> ";
                          	
							?>
							 
							  <td ><input name='valor' id='valor' type='text' class='SELECT' /></td>
							<td ><span class="ctablaform">
							  <select name="filtro" class="textfieldlista" id="filtro" >
							    <option value="0">Seleccion</option>
                                <option value="BENEF">Codigo</option>
                                <option value="CIU">Ciudad</option>
							    <option value="NOM">Nombre</option>
                                <option value="CIA">Razon social</option>
							    <option value="NIT">Nit/CC</option>
							    <option value="CLAS">Clase</option>
							    <option value="VEND">Vendedor</option>
							    <option value="-1">Lista Completa</option>
						    </select>
							</span></td>
                            <td aling='center' >
							<table width='100%' border='0' cellspacing='0' cellpadding='0'>
                            <tr>  <td align='center'> <input type='hidden' name='codigo'></td>
                         
							<td align='center'><img src='imagenes/mirar.png' width='16' height='16'  style="cursor:pointer"  onclick="abrir()" /></td>
							
                            </tr> </table>  </td>
							<?
							echo "<input type='hidden' name='editar' value=".$editar."> <input type='hidden' name='insertar' value=".$insertar."> <input type='hidden' name='eliminar' value=".$eliminar.">";
							echo "  </tr>  ";
						 ?>
                      </table ></td>
                    </tr>
                    
                    <tr>
                      <td><img src="imagenes/lineasup3.gif" width="624" height="4" /></td>
                    </tr>
                    <tr>
                      <td height="30" align="center" valign="bottom"><table>
                        <tr>
                          <td> <span class="ctablaform" >  </span>
                           <!-- <img src="imagenes/primero.png" alt="Inicio" width="16" height="16" id="primero" style="cursor:pointer; display:inline"  onClick="cambio(1)"/> <img src="imagenes/regresar.png" alt="Anterior" width="16" height="16" id="regresar" style="cursor:pointer; display:inline" onClick="cambio(2)"/>--> <!--<img src="imagenes/siguiente.png" alt="Siguiente" width="16" height="16"  id="siguiente" style="cursor:pointer; display:inline" onClick="cambio(3)"/>--> <!--<img src="imagenes/ultimo.png" alt="Ultimo" width="16" height="16" id="ultimo" style="cursor:pointer; display:inline" onClick="cambio(4)"/>--> </td>
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



