<?php include("lib/database.php");?>
<?php include("js/funciones.php");?>
<?
$dbm = new database();
$sqlm = "SELECT * FROM datos_contables
WHERE cod_dato = 1";
$dbm->query($sqlm);
$dbm->next_row();
?>
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

function datos_completos(){  
if (document.getElementById('fec_ini').value == "" || document.getElementById('fec_fin').value == 0 )
  return false;
else
  return true;
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
<form id="forma" name="forma" method="post" action="man_cierre_mes.php">
                  <table width="624" border="0" cellspacing="0" cellpadding="0" align="center" >
                    <tr>
                      <td bgcolor="#E9E9E9"><table width="624" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="16" height="33"> </td>
                          <td width="19"> 
              <?php if ($insertar==1) {?>
               <!-- <img src="imagenes/page.png" width="16" height="16"  alt="Nuevo Registro" style="cursor:pointer" onClick="location.href='man_traza_general.php?codigo=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>'"/>-->
                <?php } ?></td>
                          <td width="160"><span class="ctablaform">
                            <?php if ($insertar==1) {?>
                <!--Agregar-->
              <?php } ?>
                          </span></td>
                          <td width="20" class="ctablaform">&nbsp;</td>
                          <td width="53" class="ctablaform"><!--Buscar: --></td>
                          <td width="103"><label>
                            <!--<input name="text" type="text" class="textfield" size="12" id="texto" />-->
                          </label></td>
                          <td width="19" class="ctablaform"><!-- en--></td>
                          <td width="160" valign="middle"><!--<select name="campos" class="textfieldlista" id="campos" >
                            <option value="0">Seleccion</option>
                            <option value="nom_bod">Bodega</option>
                            <option value="-1">Lista Completa</option>
                          </select>--></td>
                          <td width="74" valign="middle"><!--<img src="imagenes/ver.png" width="16" height="16" style="cursor:pointer"  onClick="buscar()"/>--></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="624" border="0"  cellpadding="0">
                        <tr>
                          
            
              <td  class="ctablasup" >FECHA INICIAL</td>
              <td  class="ctablasup" >FECHA FINAL</td>
                          <td  class="ctablasup"  width="112">INFORME</td>
                        </tr>
            <?php 
            
            echo "<tr style='display:none'><td ><form name='forma_0' action='man_traza_general.php'>";
            echo "  </form> </td></tr>  ";              
            $estilo="ctablablanc";
            $estilo="ctablagris";
            
            //echo $sql;
            
              if ($aux==0) { $estilo="ctablablanc"; $aux=1; $cambio_celda=$celda_blanca; }else { $estilo="ctablagris";  $cambio_celda=$celda_gris; $aux=0;}
              echo "<tr class='$estilo' $cambio_celda> ";
                            
              ?>
               
                <td ><input name='fec_ini' id='fec_ini' type='text' class='SELECT' readonly='-1' value='<?php echo $dbm->fec_ini ?>'/> <img src='imagenes/date.png' alt='Calendario' name='imageField' width='18' height='18' id='imageField' style='cursor:pointer'/></td>
              <td ><input name='fec_fin' id='fec_fin' type='text' class='SELECT' readonly='-1' value='<?php echo $dbm->fec_fin ?>'/> <img src='imagenes/date.png' alt='Calendario' name='imageField1' width='18' height='18' id='imageField1' style='cursor:pointer'/></td>
                            <td aling='center' >
              <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                            <tr>  <td align='center'> <input type='hidden' name='codigo'></td>
                         
              <td align='center'><a href='#' onclick="cambio_guardar()" />GUARDA</td>
              
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
<script type="text/javascript">
      
      Calendar.setup(
        {
          inputField  : "fec_ini",      
          ifFormat    : "%Y-%m-%d",    
          button      : "imageField" ,  
          //align       :"T3",
          singleClick :true
        }
      );
      
      Calendar.setup(
        {
        inputField  : "fec_fin",      // ID of the input field
        ifFormat    : "%Y-%m-%d",    // the date format
        button      : "imageField1" ,   // ID of the button
        //align       :"T2",
        singleClick :true
        }
      );
      
</script>         
  <input type="hidden" name="editar" id="editar" value="<?=$editar?>">
  <input type="hidden" name="insertar" id="insertar" value="<?=$insertar?>">
  <input type="hidden" name="eliminar" id="eliminar" value="<?=$eliminar?>">
  <input type="hidden" name="cant_pag"  id="cant_pag" value="<?=$cant_pag?>">
  <input type="hidden" name="guardar" id="guardar" />
  <input type="hidden" name="act_pag"  id="act_pag" value="<?php if(!empty($act_pag)) echo $act_pag; else echo $pagina;?>">
  <input type="hidden" name="busquedas" id="busquedas" value="<?=$busquedas?>">
   <input type="hidden" name="eliminacion" id="eliminacion" >
    <input type="hidden" name="eli_codigo" id="eli_codigo" >
</form>
</body>
</html>