<?php include("lib/database.php");?>
<?php include("js/funciones.php");?>
<?php 

//RECIBE LAS VARIABLES
$insertar = $_REQUEST['insertar'];
$eliminar = $_REQUEST['eliminar'];
$editar = $_REQUEST['editar'];
$eli_codigo = $_REQUEST['eli_codigo'];
$confirmacion = $_REQUEST['confirmacion'];
$busquedas = $_REQUEST['busquedas'];
$eliminacion = $_REQUEST['eliminacion'];
$act_pag = $_REQUEST['act_pag'];
$cant_pag = $_REQUEST['cant_pag'];

//CONSULTA EL MES ACTIVO
$dbm = new database();
$sqlm = "SELECT * FROM datos_contables
WHERE cod_dato = 1";
$dbm->query($sqlm);
$dbm->next_row();

if (!isset($_SESSION['global_2'])) {
  echo "<script language='javascript'>alert('La sesion finalizó, por favor reinicie el sistema')</script>";
}
if($eliminacion==1) {//confirmacion de insercion  
	$campos="estado_mov ='2'";
	$error=editar("m_movimientos",$campos,'cod_mov',$eli_codigo); 
	if ($error >=1)
	echo "<script language='javascript'> alert('Se Elimino el registro Correctamente..') </script>" ;
}

if($confirmacion==1) //confirmacion de insercion 
	echo "<script language='javascript'> alert('Se Inserto el registro Correctamente..') </script>" ;

if($confirmacion==2) //confirmacion de insercion 
	echo "<script language='javascript'> alert('Se Edito el registro Correctamente..') </script>" ;

if($det==0)
	$where.=" where cod_mov > 0 ";

if(!empty($busquedas)) { #codigo para buscar 
	$busquedas=reemplazar_1($busquedas);
	$where.=" and $busquedas   ";
}
#codigo para buscar 

$sql="select * from m_movimientos
INNER JOIN tipo_movimientos ON tipo_movimientos.cod_tmov = m_movimientos.tipo_mov
$where AND estado_mov = 1 AND (fec_emi >= '$dbm->fec_ini' AND fec_emi <= '$dbm->fec_fin' ) ORDER BY fec_emi   DESC";

$cantidad_paginas=paginar($sql);
$cant_pag=ceil($cantidad_paginas/$cant_reg_pag);

if(!empty($act_pag)) 
	$inicio=($act_pag -1)*$cant_reg_pag  ;
else { 
	$inicio =0;
	$act_pag=1;
	}
$paginar=" limit  $inicio, $cant_reg_pag";
$sql.=$paginar;
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
<script type="text/javascript" src="informes/inf.js"></script>
 <link href="css/styles.css" rel="stylesheet" type="text/css">
</head>
<body  <?php echo $sis?> onLoad="cambio_1(<?php echo $cant_pag?>,<?php echo $act_pag?>);">

<table width="761" align="center">
<tr>
<td width="777" valign="top" >
<form id="forma_total" name="forma_total" method="post" action="man_movimiento.php">
                  <table width="624" border="0" cellspacing="0" cellpadding="0" align="center" >
                    <tr>
                      <td bgcolor="#E9E9E9"><table width="624" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="8" height="33"> </td>
                          <td width="17"> 
						  <?php if ($insertar==1) {?>
					  	  <img src="imagenes/agregar.png" width="16" height="16"  alt="Nuevo Registro" style="cursor:pointer" onClick="location.href='man_movimiento.php?codigo=0&editar=<?php echo $editar?>&insertar=<?php echo $insertar?>&eliminar=<?php echo $eliminar?>'"/>
					  	  <?php } ?></td>
                          <td width="133"><span class="ctablaform">
                            <?php if ($insertar==1) {?>
								Agregar
							<?php } ?>
                          </span></td>
                          <td width="50" class="ctablaform">Buscar: </td>
                          <td width="103" class="ctablaform"><input name="text" type="text" class="textfield" size="12" id="texto" /></td>
                          <td width="20"><label> <span class="ctablaform">en</span></label></td>
                          <td width="160" class="ctablaform"><select name="campos" class="textfieldlista" id="campos" >
                            <option value="0">Seleccion</option>
                            <option value="nom_tmov">Tipo</option>
                            <option value="num_mov">No documento</option>
                            <option value="fec_emi">Fecha emision</option>
                            <option value="fec_venci">Fecha factura</option>
                            <option value="-1">Lista Completa</option>
                          </select></td>
                          <td width="41" valign="middle"><img src="imagenes/lupa.png" alt="Buscar" width="16" height="16" style="cursor:pointer"  onClick="buscar()"/></td>
                          <td width="54" valign="middle" class="ctablaform">&nbsp;</td>
                          <td width="38" valign="middle">&nbsp;</td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="755" border="0"  cellpadding="0">
                        <tr>
                          <td width="70"  class="ctablasup">CONSECUTIVO</td>
						  <td width="76"  class="ctablasup">No DOCUMENTO</td>
						  <td width="141"  class="ctablasup">FECHA EMISION</td>
						  <td width="128"  class="ctablasup">FECHA VENCIMIENTO</td>
                          <td  class="ctablasup"  width="112">OPCIONES</td>
                        </tr>
						<?php 
						
						echo "<tr style='display:none'><td ><form name='forma_0' action='man_movimiento.php'>";
						echo "  </form> </td></tr>  ";						  
						$estilo="ctablablanc";
						$estilo="ctablagris";
						
						//echo $sql;
						$db->query($sql);  #consulta paginada
						while($db->next_row()) {
							if ($aux==0) { $estilo="ctablablanc"; $aux=1; $cambio_celda=$celda_blanca; }else { $estilo="ctablagris";  $cambio_celda=$celda_gris; $aux=0;}
							echo "<tr class='$estilo' $cambio_celda> <form name='forma_$db->cod_mov' action='man_movimiento.php'>  ";
							echo "<td >$db->conse_mov</td>";
							echo "<td >$db->num_mov</td>";
							echo "<td >$db->fec_emi</td>";
							echo "<td >$db->fec_venci</td>";
							echo "<td aling='center' >"; 
							echo 	"<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
                            echo 	" <tr>  <td align='center'> <input type='hidden' name='codigo' value='$db->cod_mov'>";
							if ($editar==1)
							 	echo "<img src='imagenes/icoeditar.png' alt='Editar Registro' width='16' height='16' style='cursor:pointer'  onclick='document.forma_$db->cod_mov.submit()'/></td>";
							else 
								echo "<img src='imagenes/e_icoeditar.png' width='16' height='16'  /></td>";
                            echo 	"<td align='center'>";
							if ($eliminar==1)
								echo"<img src='imagenes/icoeliminar.png' width='16' alt='Eliminar Registro' height='16' style='cursor:pointer' onclick=confirmar($db->cod_mov) /></td> ";
							else
								echo"<img src='imagenes/e_icoeliminar.png' width='16' height='16'  /></td> ";
							
							//impresion	
							echo "<td align='center'><img src='imagenes/mirar.png' width='16' height='16'  style=\"cursor:pointer\" onClick=\"imprimir_inf('inf_movimientos.php',$db->cod_mov,'grande')\" /></td>";	
														
						    echo "  </tr> </table>  </td>  ";
							echo "<input type='hidden' name='editar' value=".$editar."> <input type='hidden' name='insertar' value=".$insertar."> <input type='hidden' name='eliminar' value=".$eliminar.">";
							echo "  </form></tr>  ";
						
						} ?>

                      </table ></td>
                    </tr>
                    
                    <tr>
                      <td><img src="imagenes/lineasup3.gif" width="100%" height="4" /></td>
                    </tr>
                    <tr>
                      <td height="30" align="center" valign="bottom"><table>
                        <tr>
                          <td> <span class="ctablaform" > <?php  if ($cant_pag>0) echo "Pagina ".$act_pag." de ".$cant_pag ; else echo "No hay Resultados"  ?> </span>
                            <img src="imagenes/primero.png" alt="Inicio" width="16" height="16" id="primero" style="cursor:pointer; display:inline"  onClick="cambio(1)"/> <img src="imagenes/regresar.png" alt="Anterior" width="16" height="16" id="regresar" style="cursor:pointer; display:inline" onClick="cambio(2)"/> <img src="imagenes/siguiente.png" alt="Siguiente" width="16" height="16"  id="siguiente" style="cursor:pointer; display:inline" onClick="cambio(3)"/> <img src="imagenes/ultimo.png" alt="Ultimo" width="16" height="16" id="ultimo" style="cursor:pointer; display:inline" onClick="cambio(4)"/> </td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>
      </form>
</td>
</tr>
</table>						
<form name="forma" method="post" action="con_movimiento.php">
  <input type="hidden" name="editar" id="editar" value="<?php echo $editar?>">
  <input type="hidden" name="insertar" id="insertar" value="<?php echo $insertar?>">
  <input type="hidden" name="eliminar" id="eliminar" value="<?php echo $eliminar?>">
  <input type="hidden" name="cant_pag"  id="cant_pag" value="<?php echo $cant_pag?>">
  <input type="hidden" name="act_pag"  id="act_pag" value="<?php if(!empty($act_pag)) echo $act_pag; else echo $pagina;?>">
  <input type="hidden" name="busquedas" id="busquedas" value="<?php echo $busquedas?>">
   <input type="hidden" name="eliminacion" id="eliminacion" >
    <input type="hidden" name="eli_codigo" id="eli_codigo" >
</form>
</body>
</html>