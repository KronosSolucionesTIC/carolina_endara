<?php  include("lib/database.php");?>
<?php  include("js/funciones.php");?>
<?php  

//RECIBE LAS VARIABLES
$insertar = $_REQUEST['insertar'];
$eliminar = $_REQUEST['eliminar'];
$editar = $_REQUEST['editar'];
$eli_codigo = $_REQUEST['eli_codigo'];
$confirmacion = $_REQUEST['confirmacion'];
$busquedas = $_REQUEST['busquedas'];
$eliminacion = $_REQUEST['eliminacion'];

if($_REQUEST['eliminacion']==1) {//confirmacion de insercion  
	$campos="estado_usuario='2'";
	$error=editar("usuario",$campos,'cod_usu',$eli_codigo); 
	if ($error >=1)
	echo "<script language='javascript'> alert('Se Elimino el registro Correctamente..') </script>" ;
}

if($confirmacion==1) //confirmacion de insercion 
	echo "<script language='javascript'> alert('Se Inserto el registro Correctamente..') </script>" ;

if($confirmacion==2) //confirmacion de insercion 
	echo "<script language='javascript'> alert('Se Edito el registro Correctamente..') </script>" ;

	
if(!empty($busquedas)) { #codigo para buscar 
	$busquedas=reemplazar_1($busquedas);
	$where=" where estado_usuario = 1 and $busquedas";
}#codigo para buscar 
else{
	$where=" where estado_usuario = 1";
}

$sql="SELECT cod_usu,nom_usu , cc_usu FROM usuario $where";

$cantidad_paginas=paginar($sql);
$cant_pag=ceil($cantidad_paginas/$cant_reg_pag);

if(!empty($act_pag)) 
	$inicio=($act_pag -1)*$cant_reg_pag  ;
else { 
	$inicio =0;
	$act_pag=1;
	}
$paginar=" limit  $inicio, $cant_reg_pag";
$busquedas=reemplazar($busquedas);

?>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $nombre_aplicacion?></title>
<script type="text/javascript">
var tWorkPath="menus/data.files/";
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>
<script type="text/javascript" src="js/funciones.js"></script>
 <link href="css/styles.css" rel="stylesheet" type="text/css">
</head>
<body  <?php echo $sis?> onLoad="cambio_1(<?php echo $cant_pag?>,<?php echo $act_pag?>);">

<table align="left" width='100%'>
<tr>
<td valign="top" >
<form id="forma_total" name="forma_total" method="post" action="man_usuario.php">
                  <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center" >
                    <tr>
                      <td><table width="90%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td> </td>
                          <td> 
						  <?php  if ($insertar==1) {?>
					  	  <img src="imagenes/agregar.png"  alt="Nuevo Registro" style="cursor:pointer" onClick="location.href='man_usuario.php?codigo=0&editar=<?php echo $editar?>&insertar=<?php echo $insertar?>&eliminar=<?php echo $eliminar?>'"/>
					  	  <?php  } ?></td>
                          <td><span class="ctablaform">
                            <?php  if ($insertar==1) {?>
								Agregar
							<?php  } ?>
                          </span></td>
                          <td class="ctablaform">&nbsp;</td>
                          <td class="ctablaform">Buscar: </td>
                          <td><label>
                            <input name="text" type="text" class="textfield" size="12" id="texto" />
                          </label></td>
                          <td class="ctablaform"> en</td>
                          <td valign="middle"><select name="campos" class="textfieldlista" id="campos" >
                            <option value="0">Seleccion</option>
                            <option value="nom_usu">Nombres</option>
                            <option value="cc_usu">Identificacion</option>
							<option value="-1">Lista Completa</option>
                          </select></td>
                          <td valign="middle">
						  <img src="imagenes/lupa.png" style="cursor:pointer"  onClick="buscar()"/></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="90%" border="0"  cellpadding="0">
                        <tr>
                          <td  class="ctablasup">NOMBRES</td>
                          <td  class="ctablasup">IDENTIFICACION</td>
                          <td  class="ctablasup" >OPCIONES</td>
                        </tr>
						<?php  
						
						echo "<tr style='display:none'><td ><form name='forma_0' action='man_usuario.php'>";
						echo "  </form> </td></tr>  ";						  
						$estilo="ctablablanc";
						$estilo="ctablagris";
						$db->query($sql);  #consulta paginada
						while($db->next_row()) {
							if ($aux==0) { $estilo="ctablablanc"; $aux=1; $cambio_celda=$celda_blanca; }else { $estilo="ctablagris";  $cambio_celda=$celda_gris; $aux=0;}
							echo "<tr class='$estilo' $cambio_celda> <form name='forma_$db->cod_usu' action='man_usuario.php'>  ";
                          	echo "<td >$db->nom_usu </td>";
						  	echo "<td  >$db->cc_usu</td> ";
                            echo "<td aling='center' >"; 
							echo 	"<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
                            echo 	" <tr>  <td align='center'> <input type='hidden' name='codigo' value='$db->cod_usu'>";
							if ($editar==1)
							 	echo "<img src='imagenes/icoeditar.png' alt='Editar Registro' style='cursor:pointer'  onclick='document.forma_$db->cod_usu.submit()'/></td>";
							else 
								echo "<img src='imagenes/e_icoeditar.png'   /></td>";
                            echo 	"<td align='center'>";
							if ($eliminar==1)
								echo"<img src='imagenes/icoeliminar.png'  alt='Eliminar Registro' height='16' style='cursor:pointer' onclick=confirmar($db->cod_usu) /></td> ";
							else
								echo"<img src='imagenes/e_icoeliminar.png' /></td> ";
                            echo "  </tr> </table>  </td>  ";
							echo "<input type='hidden' name='editar' value=".$editar."> <input type='hidden' name='insertar' value=".$insertar."> <input type='hidden' name='eliminar' value=".$eliminar.">";
							echo "  </form></tr>  ";
						
						} ?>
                    
                        
                      </table ></td>
                    </tr>
                    
                    <tr>
                      <td><img src="imagenes/lineasup3.gif" width="90%" height="4" /></td>
                    </tr>
                    <tr>
                      <td height="30" align="center" valign="bottom"><table>
                        <tr>
                          <td> <span class="ctablaform" > <?php   if ($cant_pag>0) echo "Pagina ".$act_pag." de ".$cant_pag ; else echo "No hay Resultados"  ?> </span>
                            <img src="imagenes/primero.png" alt="Inicio" id="primero" style="cursor:pointer; display:inline"  onClick="cambio(1)"/> <img src="imagenes/regresar.png" alt="Anterior" id="regresar" style="cursor:pointer; display:inline" onClick="cambio(2)"/> <img src="imagenes/siguiente.png" alt="Siguiente"  id="siguiente" style="cursor:pointer; display:inline" onClick="cambio(3)"/> <img src="imagenes/ultimo.png" alt="Ultimo" id="ultimo" style="cursor:pointer; display:inline" onClick="cambio(4)"/> </td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>
      </form>
</td>
</tr>
</table>						
<form name="forma" method="post" action="con_usuario.php">
  <input type="hidden" name="editar" id="editar" value="<?php echo $editar?>">
  <input type="hidden" name="insertar" id="insertar" value="<?php echo $insertar?>">
  <input type="hidden" name="eliminar" id="eliminar" value="<?php echo $eliminar?>">
  <input type="hidden" name="cant_pag"  id="cant_pag" value="<?php echo $cant_pag?>">
  <input type="hidden" name="act_pag"  id="act_pag" value="<?php  if(!empty($act_pag)) echo $act_pag; else echo $pagina;?>">
  <input type="hidden" name="busquedas" id="busquedas" value="<?php echo $busquedas?>">
   <input type="hidden" name="eliminacion" id="eliminacion" >
    <input type="hidden" name="eli_codigo" id="eli_codigo" >
</form>
</body>
</html>