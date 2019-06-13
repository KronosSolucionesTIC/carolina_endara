<?php include("lib/database.php");?>
<?php include("js/funciones.php");?>
<?

//RECIBE LAS VARIABLES
$codigo = $_REQUEST['codigo'];
$guardar = $_REQUEST['guardar'];
$insertar = $_REQUEST['insertar'];
$eliminar = $_REQUEST['eliminar'];
$editar = $_REQUEST['editar'];

if ($codigo!=0) {
	  $sql ="SELECT * FROM tercero WHERE cod_ter= $codigo";
		$dbdatos= new  Database();
		$dbdatos->query($sql);
		$dbdatos->next_row();
}

if($guardar==1 and $codigo==0) { // RUTINA PARA  INSERTAR REGISTROS NUEVOS


	$campos="(nom1_ter,nom2_ter,apel1_ter,apel2_ter,tiden_ter,id_ter,dir_ter,email_ter,ciu_ter,dep_ter,tel_ter,cel1_ter,cel2_ter,plazo_ter,fec_ter,ven_ter,tipo_cont,clas_dian,ica_ter,tar_ica)";
	$valores="('".$_REQUEST['nombre1']."','".$_REQUEST['nombre2']."','".$_REQUEST['apellido1']."','".$_REQUEST['apellido2']."','".$_REQUEST['tipo_id']."','".$_REQUEST['iden']."','".$_REQUEST['direccion']."','".$_REQUEST['correo']."','".$_REQUEST['ciudad']."','".$_REQUEST['departamento']."','".$_REQUEST['telefono']."','".$_REQUEST['celular1']."','".$_REQUEST['celular2']."','".$_REQUEST['plazo']."','".$_REQUEST['fecha']."','".$_REQUEST['vendedor']."','".$_REQUEST['tipo_contribuyente']."','".$_REQUEST['clasificacion_dian']."','".$_REQUEST['ica']."','".$_REQUEST['tar_ica']."')" ;  
	
	$error=insertar("tercero",$campos,$valores); 
	
	if ($error==1) {
		header("Location: con_tercero.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	}
	else
		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 
}

if($guardar==1 and $codigo!=0) { // RUTINA PARA EDITAR REGISTROS 
  
  if($dbdatos->foto_ter != ""){
  }
  else{
    //GUARDA LA FOTO
    $ruta = "fotos";
    $archivo = $_FILES['imagen']['tmp_name'];
    $nombre_archivo = $_FILES['imagen']['name'];

    move_uploaded_file($archivo, $ruta."/".$nombre_archivo);
    $ruta = $ruta."/".$nombre_archivo;
    //
    if($ruta == "fotos/"){
      $ruta = "";
    }

    $campos = "foto_ter = '".$ruta."'";
    $error=editar("tercero",$campos,'cod_ter',$codigo);
  }

	$campos="linea_ter='".$_REQUEST['linea']."',nom1_ter='".$_REQUEST['nombre1']."',nom2_ter='".$_REQUEST['nombre2']."', apel1_ter='".$_REQUEST['apellido1']."', apel2_ter='".$_REQUEST['apellido2']."',tiden_ter='".$_REQUEST['tipo_id']."',id_ter='".$_REQUEST['iden']."', dir_ter='".$_REQUEST['direccion']."',tel_ter='".$_REQUEST['telefono']."',cel1_ter='".$_REQUEST['celular1']."', cel2_ter='".$_REQUEST['celular2']."', dep_ter='".$_REQUEST['departamento']."', ciu_ter='".$_REQUEST['ciudad']."', loc_ter='".$_REQUEST['localidad']."', rh_ter='".$_REQUEST['rh_ter']."', email_ter= '".$_REQUEST['correo']."', cat_ter= '".$_REQUEST['categoria']."', eps_ter= '".$_REQUEST['eps']."', fnac_ter = '".$_REQUEST['fecha']."' , fins_ter = '".$_REQUEST['fecha_ins']."' ,copia_eps='".$_REQUEST['copia_eps']."',copia_doc='".$_REQUEST['doc']."'";
	
	$error=editar("tercero",$campos,'cod_ter',$codigo); 
	if ($error==1) {
		
		header("Location: con_tercero.php?confirmacion=2&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	}
	else
		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link href="css/stylesforms.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Estilo1 {font-size: 12px}
</style> 

<?php inicio() ?>

<script language="javascript">
//VALIDA LOS DATOS
function datos_completos(){  
if (document.getElementById('nombre1').value == "" || document.getElementById('nombre2').value == "" )
  return false;
else
  return true;
}

//CARGA EL DIGITO DE VERIFICACION
function prueba(){
  var vpri, x, y, z, i, nit1, dv1;
 nit1=document.getElementById('iden').value;
    if (isNaN(nit1))
    {
    document.getElementById('iden').value="X";
  alert('El valor digitado no es un numero valido');        
    } else {
  vpri = new Array(16); 
    x=0 ; y=0 ; z=nit1.length ;
    vpri[1]=3;
    vpri[2]=7;
    vpri[3]=13; 
    vpri[4]=17;
    vpri[5]=19;
    vpri[6]=23;
    vpri[7]=29;
    vpri[8]=37;
    vpri[9]=41;
    vpri[10]=43;
    vpri[11]=47;  
    vpri[12]=53;  
    vpri[13]=59; 
    vpri[14]=67; 
    vpri[15]=71;
  for(i=0 ; i<z ; i++)
    { 
     y=(nit1.substr(i,1));
        //document.write(y+"x"+ vpri[z-i] +":");
   x+=(y*vpri[z-i]);
        //document.write(x+"<br>");     
    } 
  y=x%11
    //document.write(y+"<br>");
  if (y > 1)
    {
   dv1=11-y;
    } else {
   dv1=y;
    }
   document.getElementById('dv').value=dv1;
    }
}

//CARGA LA CUIDAD
function cargar_ciudad(departamento,ciudad) {
var combo=document.getElementById(ciudad);
combo.options.length=0;
var cant=0;
combo.options[cant] = new Option('Seleccione...','0'); 
cant++;
<?
    $i=0;
    $sqlc ="SELECT * FROM `ciudad` ";   
    $dbc= new  Database();
    $dbc->query($sqlc);
    while($dbc->next_row()){ 
    echo "if(document.getElementById(departamento).value==$dbc->departamento){ "; 
    echo "combo.options[cant] = new Option('$dbc->desc_ciudad','$dbc->cod_ciudad'); ";  
    echo "cant++; } ";
    }
?>
}

//HABILITA LA TARIFA DEL ICA
function habilita_ica(){
  if(document.getElementById('ica').checked == false){
    document.getElementById('tar_ica').disabled = true; 
  }
  else{
    document.getElementById('tar_ica').disabled = false; 
  }
}

//HABILITA LA TARIFA DEL cREE
function habilita_cree(){
  if(document.getElementById('cree').checked == false){
    document.getElementById('tar_cree').disabled = true; 
  }
  else{
    document.getElementById('tar_cree').disabled = false; 
  }
}
</script>

</head>
<body <?=$sis?>>
<form  name="forma" id="forma" action="man_tercero.php"  method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
    <td><table width="100%" height="46" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td valign="middle" bgcolor="#FFFFFF" >&nbsp;</td>
        <td valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
        <td valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
         <td width="5" height="19">&nbsp;</td>
        <td width="20" ><img src="imagenes/icoguardar.png" alt="Nuevo Registro" width="16" height="16" border="0"  onclick="cambio_guardar()" style="cursor:pointer"/></td>
        <td width="61" class="ctablaform">Guardar</td>
        <td width="21" class="ctablaform"><a href="con_tercero.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
        
        <td width="21" class="ctablaform"></td>
        <td width="60" class="ctablaform">&nbsp;</td>
        <td width="24" valign="middle" class="ctablaform">&nbsp;</td>
        <td width="193" valign="middle"><label>
          <input type="hidden" name="editar"   id="editar"   value="<?=$editar?>">
		  <input type="hidden" name="insertar" id="insertar" value="<?=$insertar?>">
		  <input type="hidden" name="eliminar" id="eliminar" value="<?=$eliminar?>">
          <input type="hidden" name="codigo" id="codigo" value="<?=$codigo?>" />
        </label></td>
        <td width="67" valign="middle">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="4" valign="bottom"><img src="imagenes/lineasup3.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td class="textotabla1 Estilo1">TERCEROS:</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="textotabla1">Primer nombre:</td>
        <td><input name="nombre1" id="nombre1" type="text" class="textfield2"  value="<?=$dbdatos->nom1_ter?>" /></td>
        <td align="left" class="textorojo">*</td>
        <td class="textotabla1">Segundo nombre:</td>
        <td><input name="nombre2" id="nombre2" type="text" class="textfield2" value="<?=$dbdatos->nom2_ter?>"  />
        <span class="textorojo"></span></td>
      </tr>
      <tr>
        <td class="textotabla1">Primer apellido:</td>
        <td><input name="apellido1" id="apellido1" type="text" class="textfield2"  value="<?=$dbdatos->apel1_ter?>" /></td>
        <td class="textorojo">*</td>
        <td class="textotabla1">Segundo apellido:</td>
        <td><input name="apellido2" id="apellido2" type="text" class="textfield2"  value="<?=$dbdatos->apel2_ter?>" /></td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Tipo ID:</td>
        <td><?php combo_evento_where("tipo_id","tipo_identificacion","cod_tiden","nom_tiden",$dbdatos->tiden_ter,""," where estado_tiden = 1 order by nom_tiden"); ?></td>
        <td class="textorojo">*</td>
        <td class="textotabla1">No identificacion:</td>
        <td><input name="iden" id="iden" type="text" class="textfield2"  onblur="prueba()" value="<?=$dbdatos->id_ter?>" /><input class="textfield2" readonly="readonly" type='text' id='dv' name='dv'></td>
        <td class="textorojo">*</td>
      </tr>
      <tr>
        <td class="textotabla1">Departamento:</td>
        <td><?php combo_evento("departamento","departamento","cod_departamento","desc_departamento",$dbdatos->dep_ter,"onchange='cargar_ciudad(\"departamento\",\"ciudad\")'","desc_departamento"); ?></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textotabla1">Ciudad:</td>
        <td><?php combo_evento_where("ciudad","ciudad","cod_ciudad","desc_ciudad",$dbdatos->ciu_ter,"","");?></td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Plazo dias:</td>
        <td><input name="plazo" id="plazo" type="text" class="textfield2"  value="<?=$dbdatos->dir_ter?>" /></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textotabla1">Fecha aniversario:</td>
        <td><input name="fecha" type="text" class="fecha" id="fecha" value="<?=$dbdatos->fins_ter ?>" /><img src="imagenes/date.png" alt="Calendario" name="calendario" width="16" height="16" border="0" id="calendario" style="cursor:pointer"/></td>
        <td></td>
      </tr>
      <tr>
        <td class="textotabla1">Direccion:</td>
        <td><input name="direccion" id="direccion" type="text" class="textfield2"  value="<?=$dbdatos->dir_ter?>" /></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textotabla1">Telefono:</td>
        <td><input name="telefono" id="telefono" type="text" class="textfield2"  value="<?=$dbdatos->tel_ter?>" /></td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Celular 1:</td>
        <td><input name="celular1" id="celular1" type="text" class="textfield2"  value="<?=$dbdatos->cel1_ter?>" /></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textotabla1">Celular 2:</td>
        <td><input name="celular2" id="celular2" type="text" class="textfield2"  value="<?=$dbdatos->cel2_ter?>" /></td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">E-mail:</td>
        <td><input name="correo" id="correo" type="text" class="textfield2"  value="<?=$dbdatos->email_ter?>" /></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textotabla1">Vendedor:</td>
        <td><?php combo_evento_where("vendedor","vendedor","cod_ven","nom_ven",$dbdatos->ven_ter,""," where estado_vendedor = 1 ORDER BY nom_ven"); ?></td>
        <td class="textorojo">&nbsp;</td>
      </tr>		
      <tr>
        <td class="textotabla1">Tipo de contribuyente:</td>
        <td><?php combo_evento_where("tipo_contribuyente","tipo_contribuyente","cod_tcont","nom_tcont",$dbdatos->ven_ter,""," where estado_tcont = 1 ORDER BY nom_tcont"); ?></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textotabla1">Clasificacion DIAN:</td>
        <td><?php combo_evento_where("clasificacion_dian","clasificacion_dian","cod_cdian","nom_cdian",$dbdatos->ven_ter,""," where estado_cdian = 1 ORDER BY nom_cdian"); ?></td>
        <td class="textorojo">&nbsp;</td>
      </tr> 
      <tr>
        <td class="textotabla1">Aplica ICA:</td>
        <td><input type='checkbox' id='ica' name='ica' onClick='habilita_ica()'><?php echo $db->nom_pro ?></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textotabla1">Tarifa ICA:</td>
        <td><input name="tar_ica" id="tar_ica" type="text" class="textfield2"  onkeypress="return validaInt_evento(this)" disabled='true' value="<?=$dbdatos->email_ter?>" /></td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Aplica RETECREE:</td>
        <td><input type='checkbox' id='cree' name='cree' onClick='habilita_cree()'><?php echo $db->nom_pro ?></td>
        <td class="textotabla1">&nbsp;</td>
        <td class="textotabla1">Tarifa CREE:</td>
        <td><input name="tar_cree" id="tar_cree" type="text" class="textfield2" onkeypress="return validaInt_evento(this)" disabled='true' value="<?=$dbdatos->email_ter?>" /></td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Lista de precios:</td>
        <td><?php combo_evento_where("lista","listaprecio","cos_list","nom_list",$dbdatos->ven_ter,""," where estado_list = 1 ORDER BY nom_list"); ?></td>
        <td class="textotabla1">&nbsp;</td>
        <td class="textotabla1">Cupo credito:</td>
        <td><input name="cupo" id="cupo" type="text" class="textfield2" onkeypress="return validaInt_evento(this)"  value="<?=$dbdatos->email_ter?>" /></td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Propiedades:</td>
        <td>&nbsp;</td>
        <td class="textorojo">&nbsp;</td>
        <td class="textorojo">&nbsp;</td>
        <td class="textorojo">&nbsp;</td>
        <td class="textorojo">&nbsp;</td>
      </tr>      
        <?php
        //CONSULTA LAS PROPIEDADES DE LOS TERCEROS
        $db = new database();
        $sql = "SELECT * FROM propiedad
        WHERE estado_pro = 1";
        $db->query($sql);
        while($db->next_row()){
        ?>
      <tr>
        <td class="textotabla1"></td>
        <td><input type='checkbox' id='copia_eps' name='copia_eps'><?php echo $db->nom_pro ?></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textorojo">&nbsp;</td>
        <td class="textorojo">&nbsp;</td>
        <td class="textorojo">&nbsp;</td>
      </tr>
        <?php 
        } 
        ?>
	  	  <tr>
        <td colspan="6" valign="bottom"></td>
        </tr>
    </table></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td height="30"  > <input type="hidden" name="guardar" id="guardar" />
	</td>
  </tr>
</table>
</form>
<script type="text/javascript">
    Calendar.setup(
      {
      inputField  : "fecha",      
      ifFormat    : "%Y-%m-%d",    
      button      : "calendario" ,  
      align       :"T3",
      singleClick :true
      }
    );
</script> 
</body>
</html>