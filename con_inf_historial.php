<?php include("lib/database.php");?>
<?php include("js/funciones.php");?>
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
			var cliente = document.getElementById('cliente').value;
			
			imprimir_inf("inf_historial_cliente.php",'0&fec_ini='+fec_ini+"&fec_fin="+fec_fin+"&cliente="+cliente,'mediano');
			
		}
	}

//VALIDA QUE ES ENTER
function valida_enter(e){
  var e = (typeof event != 'undefined') ? window.event : e; // IE : Moz 
    if (e.keyCode == 13) {
      carga_cliente2();
    }
}

//CARGA CLIENTE CON NIT
function carga_cliente2(){
var bandera = 0;

  <?
    $sql ="SELECT * FROM `cliente` ";    
    $db= new  Database();
    $db->query($sql);
    while($db->next_row()){ 
    echo "if(document.getElementById('nit').value=='$db->iden_cli'){ "; 
    echo "document.getElementById('cliente').value = '$db->cod_cli'; "; 
    echo "bandera = 1;";
    echo "} ";
    }  
  ?>

    if(bandera == 0){
      document.getElementById('cliente').value = 0;
      alert('No existe el cliente');
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
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" >
                    <tr>
                      <td bgcolor="#E9E9E9"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="16" height="33"> </td>
                          <td width="19"> 
						  <? if ($insertar==1) {?>
					  	 <!-- <img src="imagenes/page.png" width="16" height="16"  alt="Nuevo Registro" style="cursor:pointer" onClick="location.href='man_traza_general.php?codigo=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>'"/>-->
					  	  <? } ?></td>
                          <td width="160"><span class="ctablaform">
                            <? if ($insertar==1) {?>
								<!--Agregar-->
							<? } ?>
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
                      <td><table width="100%" border="0"  cellpadding="0">
                      	<tr>
						  <td  class="ctablasup" >FECHA INICIAL</td>
						  <td  class="ctablasup" >FECHA FINAL</td>
                          <td  class="ctablasup"  width="112">INFORME</td>
                        </tr>
                        <tr>
							<td ><input name='fec_ini' id='fec_ini' type='text' class='SELECT' readonly='-1' /> <img src='imagenes/date.png' alt='Calendario' name='imageField' width='18' height='18' id='imageField' style='cursor:pointer'/></td>
							<td ><input name='fec_fin' id='fec_fin' type='text' class='SELECT' readonly='-1' /> <img src='imagenes/date.png' alt='Calendario' name='imageField1' width='18' height='18' id='imageField1' style='cursor:pointer'/></td>
                            <td aling='center' >
							<table width='100%' border='0' cellspacing='0' cellpadding='0'>
                            <tr>  <td align='center'> <input type='hidden' name='codigo'></td>
                         
							<td align='center'><img src='imagenes/mirar.png' width='16' height='16'  style="cursor:pointer"  onclick="abrir()" /></td>
							
                            </tr>
                        </tr>
                        </table></td>
              <tr>
						 	  <td>CLIENTE</td>
						    <td><?php combo_evento_where("cliente","cliente","cod_cli","CONCAT(nom1_cli,' ',nom2_cli,' ',apel1_cli,' ',apel2_cli)","",""," WHERE estado_cli = 1 ORDER BY nombre")?></td>
                <td></td>
              </tr>
              <tr>
                <td>NIT</td>
                <td><input name="nit" id="nit" type="text" onkeypress="valida_enter(event)" /></td>
                <td></td>
              </tr>
							<?
							echo "<input type='hidden' name='editar' value=".$editar."> <input type='hidden' name='insertar' value=".$insertar."> <input type='hidden' name='eliminar' value=".$eliminar.">";
							echo "  </tr>  ";
						 ?>
                      </table ></td>
                    </tr>
                    
                    <tr>
                      <td><img src="imagenes/lineasup3.gif" width="100%" height="4" /></td>
                    </tr>
<tr>
  <td width="100%" class="ayuda" colspan='4'>...PRESIONE ENTER PARA CARGAR CLIENTE CON EL NIT...<BR>
  SI DESEA VER TODOS LOS CLIENTES DEJE LA OPCION 'SELECCIONE' QUE ES POR DEFECTO</td>
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
  <input type="hidden" name="act_pag"  id="act_pag" value="<? if(!empty($act_pag)) echo $act_pag; else echo $pagina;?>">
  <input type="hidden" name="busquedas" id="busquedas" value="<?=$busquedas?>">
   <input type="hidden" name="eliminacion" id="eliminacion" >
    <input type="hidden" name="eli_codigo" id="eli_codigo" >
</form>
</body>
</html>