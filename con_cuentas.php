<?php include("lib/database.php");?>
<?php include("js/funciones.php");?>
<?php 

if($eliminacion==1) {//confirmacion de eliminacion 
	$campos="ESTADO ='2'";
	$error=editar("MAECTA",$campos,'CUENTA',$eli_codigo); 
	if ($error >=1)
	echo "<script language='javascript'> alert('Se Elimino el registro Correctamente..') </script>" ;
	
}

if($confirmacion==1) //confirmacion de insercion 
	echo "<script language='javascript'> alert('Se Inserto el registro Correctamente..') </script>" ;

if($confirmacion==2) //confirmacion de edicion
	echo "<script language='javascript'> alert('Se Edito el registro Correctamente..') </script>" ;

#codigo para buscar  	
if(!empty($busquedas)) { 
$campo = substr($busquedas,0,6);
	if($campo == "NOM"){
		$busquedas=reemplazar_1($busquedas);
		$where="having $busquedas AND ESTADO = 1";	
	}
	else{
		$busquedas=reemplazar_1($busquedas);
		$where="where $busquedas AND ESTADO = 1";	
	}
}
else{
	$where = "WHERE ESTADO = 1";
}

$sql="SELECT * FROM MAECTA 
 $where";
#codigo para buscar 

$cantidad_paginas=paginar("SELECT * FROM MAECTA 
 $where");
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
<title><?=$nombre_aplicacion?></title>
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
<body  <?=$sis?> onLoad="cambio_1(<?=$cant_pag?>,<?=$act_pag?>);">

<table align="center">
<tr>
<td valign="top" >
<form id="forma_total" name="forma_total" method="post" action="man_cuentas.php">
                  <table width="624" border="0" cellspacing="0" cellpadding="0" align="center" >
                    <tr>
                      <td class="tablacabezera"><table width="624" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="8" height="33"> </td>
                          <td width="17"> 
						  <?php if ($insertar==1) {?>
					  	  <img src="imagenes/agregar.png" width="16" height="16"  alt="Nuevo Registro" style="cursor:pointer" onClick="location.href='man_cuentas.php?codigo=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>'"/>
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
                            <option value="CUENTA">CUENTA</option>
							<option value="NOMBRE">NOMBRE</option>
                            <option value="INDICATIVO">INDICATIVO</option>
							<option value="CONTROL">CONTROL</option>
                            <option value="-1">Lista Completa</option>
                          </select></td>
                          <td width="41" valign="middle"><img src="imagenes/lupa.png" alt="Buscar" width="16" height="16" style="cursor:pointer"  onClick="buscar()"/></td>
                        
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="688" border="0"  cellpadding="0">
                        <tr>
						 <td width="129"  class="ctablasup">CUENTA</td>
						 <td width="230"  class="ctablasup">NOMBRE</td>
						  <td width="121"  class="ctablasup">INDICATIVO</td>
						  <td width="85"  class="ctablasup">CONTROL</td>
                          <td  class="ctablasup"  width="111">OPCIONES</td>
                        </tr>
						<?php 
						
						echo "<tr style='display:none'><td ><form name='forma_0' action='man_cuentas.php'>";
						echo "  </form> </td></tr>  ";						  
						$estilo="ctablablanc";
						$estilo="ctablagris";
						
						//echo $sql;
						$sql="SELECT * FROM MAECTA $where $paginar";
						$db->query($sql);  #consulta paginada
						while($db->next_row()) {
							if ($aux==0) { $estilo="ctablablanc"; $aux=1; $cambio_celda=$celda_blanca; }else { $estilo="ctablagris";  $cambio_celda=$celda_gris; $aux=0;}
							echo "<tr class='$estilo' $cambio_celda> <form name='forma_$db->CUENTA' action='man_cuentas.php'>  ";
							echo "<td >$db->CUENTA</td>";
							echo "<td >$db->NOMBRE</td>";
							echo "<td ><div align='center'>$db->INDICATIVO</div></td>";
							echo "<td ><div align='center'>$db->CONTROL</div></td>";
                            echo "<td aling='center' >"; 
							
							echo 	"<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
                            echo 	" <tr>  <td align='center'> <input type='hidden' name='codigo' value='$db->CUENTA'>";
							if ($editar==1)
							 	echo "<img src='imagenes/icoeditar.png' alt='Editar Registro' width='16' height='16' style='cursor:pointer'  onclick='document.forma_$db->CUENTA.submit()'/></td>";
							else 
								echo "<img src='imagenes/e_icoeditar.png' width='16' height='16'  /></td>";								
                            echo 	"<td align='center'>";
							if ($eliminar==1)
								echo"<img src='imagenes/icoeliminar.png' width='16' alt='Eliminar Registro' height='16' style='cursor:pointer' onclick=confirmar($db->CUENTA) /></td> ";
							else
								echo"<img src='imagenes/e_icoeliminar.png' width='16' height='16'  /></td> ";
                            echo "  </tr> </table>  </td>  ";
							echo "<input type='hidden' name='editar' value=".$editar."> <input type='hidden' name='insertar' value=".$insertar."> <input type='hidden' name='eliminar' value=".$eliminar.">";
							echo "  </form></tr>  ";
						
						} ?>

                      </table ></td>
                    </tr>
                    
                    <tr>
                      <td><img src="imagenes/lineasup3.gif" width="690" height="4" /></td>
                    </tr>
                    <tr>
                      <td height="30" align="center" valign="bottom"><table>
                        <tr>
                          <td><?php  if ($cant_pag>0) echo "Pagina ".$act_pag." de ".$cant_pag ; else echo "No hay Resultados"  ?>
                            <img src="imagenes/primero.png" alt="Inicio" width="16" height="16" id="primero" style="cursor:pointer; display:inline"  onClick="cambio(1)"/> <img src="imagenes/regresar.png" alt="Anterior" width="16" height="16" id="regresar" style="cursor:pointer; display:inline" onClick="cambio(2)"/> <img src="imagenes/siguiente.png" alt="Siguiente" width="16" height="16"  id="siguiente" style="cursor:pointer; display:inline" onClick="cambio(3)"/> <img src="imagenes/ultimo.png" alt="Ultimo" width="16" height="16" id="ultimo" style="cursor:pointer; display:inline" onClick="cambio(4)"/> </td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>
      </form>
</td>
</tr>
</table>						
<form name="forma" method="post" action="con_cuentas.php">
  <input type="hidden" name="editar" id="editar" value="<?=$editar?>">
  <input type="hidden" name="insertar" id="insertar" value="<?=$insertar?>">
  <input type="hidden" name="eliminar" id="eliminar" value="<?=$eliminar?>">
  <input type="hidden" name="cant_pag"  id="cant_pag" value="<?=$cant_pag?>">
  <input type="hidden" name="act_pag"  id="act_pag" value="<?php if(!empty($act_pag)) echo $act_pag; else echo $pagina;?>">
  <input type="hidden" name="busquedas" id="busquedas" value="<?=$busquedas?>">
   <input type="hidden" name="eliminacion" id="eliminacion" >
    <input type="hidden" name="eli_codigo" id="eli_codigo" >
</form>
</body>
</html>


