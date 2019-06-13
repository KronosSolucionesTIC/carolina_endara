<?php  include("lib/database.php");?>
<?php  include("js/funciones.php");?>
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
			
			
		if(document.getElementById('fec_fin').value == ""  ||  document.getElementById('fec_ini').value=="") {
		 	alert('Seleccione las Fechas de consulta')
		 }
		 else {
		 	var fec_ini = document.getElementById('fec_ini').value;
			var fec_fin = document.getElementById('fec_fin').value;
			
			imprimir_inf("inf_ventas_tipo.php",'0&fec_ini='+fec_ini+"&fec_fin="+fec_fin,'mediano');
			
		}
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
                      <td bgcolor="#E9E9E9"><table width="624" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="16" height="33"> </td>
                          <td width="19"> 
						  <?php  if ($insertar==1) {?>
					  	  <?php  } ?></td>
                          <td width="160"><span class="ctablaform">
                            <?php  if ($insertar==1) {?>
							<?php  } ?>
                          </span></td>
                          <td width="20" class="ctablaform">&nbsp;</td>
                          <td width="53" class="ctablaform"></td>
                          <td width="103"><label>
                          </label></td>
                          <td width="19" class="ctablaform"></td>
                          <td width="160" valign="middle"></td>
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
							 
							  <td ><input name='fec_ini' id='fec_ini' type='text' class='SELECT' readonly='-1' /> <img src='imagenes/date.png' alt='Calendario' name='imageField' width='18' height='18' id='imageField' style='cursor:pointer'/></td>
							<td ><input name='fec_fin' id='fec_fin' type='text' class='SELECT' readonly='-1' /> <img src='imagenes/date.png' alt='Calendario' name='imageField1' width='18' height='18' id='imageField1' style='cursor:pointer'/></td>
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
                          <td> <span class="ctablaform" >  </span></td>
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
<form name="forma" method="post" action="con_traza_general.php">
  <input type="hidden" name="editar" id="editar" value="<?=$editar?>">
  <input type="hidden" name="insertar" id="insertar" value="<?=$insertar?>">
  <input type="hidden" name="eliminar" id="eliminar" value="<?=$eliminar?>">
  <input type="hidden" name="cant_pag"  id="cant_pag" value="<?=$cant_pag?>">
  <input type="hidden" name="act_pag"  id="act_pag" value="<?php  if(!empty($act_pag)) echo $act_pag; else echo $pagina;?>">
  <input type="hidden" name="busquedas" id="busquedas" value="<?=$busquedas?>">
   <input type="hidden" name="eliminacion" id="eliminacion" >
    <input type="hidden" name="eli_codigo" id="eli_codigo" >
</form>
</body>
</html>