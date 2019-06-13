<?php include("lib/database.php");?>
<?php include("js/funciones.php");?>
<?php 

//RECIBE LAS VARIABLES
$codigo = $_REQUEST['codigo'];
$guardar = $_REQUEST['guardar'];
$insertar = $_REQUEST['insertar'];
$eliminar = $_REQUEST['eliminar'];
$editar = $_REQUEST['editar'];

if($codigo==0) 
   $codigo=-10; 
if ($codigo!="") {
	    $sql ="SELECT * FROM cliente WHERE cod_cli= $codigo";
		$dbdatos= new  Database();
		$dbdatos->query($sql);
		$dbdatos->next_row();
}

if($guardar==1 and $codigo==-10) { // RUTINA PARA  INSERTAR REGISTROS NUEVOS
	$campos="(nom1_cli,nom2_cli,apel1_cli,apel2_cli,tipo_id_cli,iden_cli,digito_cli,dir_cli,tel_cli,cel1_cli,dpto_cli,ciu_cli,email_cli,
    cupo_cli,plazo_cli,obser_cli,desc_cli,fcun_cli)";
	
	 $valores="('".$_REQUEST['nombre1']."','".$_REQUEST['nombre2']."','".$_REQUEST['apellido1']."', '".$_REQUEST['apellido2']."',
    '".$_REQUEST['tipo_id']."', '".$_REQUEST['nit']."','".$_REQUEST['dv']."','".$_REQUEST['direccion']."','".$_REQUEST['telefono']."',
    '".$_REQUEST['celular']."', '".$_REQUEST['departamento']."','".$_REQUEST['ciudad']."','".$_REQUEST['correo']."',
    '".$_REQUEST['credito']."','".$_REQUEST['dias']."','".$_REQUEST['obser']."','".$_REQUEST['descuento']."','".$_REQUEST['fecha_cum']."')" ;  
	
	$error=1;
	$id_cli=insertar_maestro("cliente",$campos,$valores); 
	
	if ($error==1) {
		header("Location: con_cliente.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	}
	else
		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 
}

if($guardar==1 and $codigo!=0) { // RUTINA PARA EDITAR REGISTROS 
	$campos="nom1_cli='".$_REQUEST['nombre1']."',nom2_cli='".$_REQUEST['nombre2']."', apel1_cli='".$_REQUEST['apellido1']."', 
  apel2_cli='".$_REQUEST['apellido2']."', tipo_id_cli='".$_REQUEST['tipo_id']."', iden_cli='".$_REQUEST['nit']."',
  digito_cli='".$_REQUEST['dv']."', dir_cli='".$_REQUEST['direccion']."', tel_cli='".$_REQUEST['telefono']."', 
  cel1_cli='".$_REQUEST['celular']."', dpto_cli='".$_REQUEST['departamento']."',ciu_cli='".$_REQUEST['ciudad']."', 
  email_cli='".$_REQUEST['correo']."', cupo_cli='".$_REQUEST['credito']."', plazo_cli='".$_REQUEST['dias']."',
  obser_cli='".$_REQUEST['obser']."',desc_cli='".$_REQUEST['descuento']."',fcun_cli='".$_REQUEST['fecha_cum']."'";
	
	$error=editar("cliente",$campos,'cod_cli',$codigo); 
	if ($error==1) {
		
		header("Location: con_cliente.php?confirmacion=2&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	}
	else
		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="js/funciones.js"></script>
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
// VALIDA EL No DE IDENTIFICACION
function buscar_nit(){
var cajita_codigo=document.getElementById('nit').value;
var vec_codigo = new Array;
<?
$dbdatos111= new  Database();
$sql ="select iden_cli from cliente WHERE estado_cli = 1";
$dbdatos111->query($sql);
$i = 0;
while($dbdatos111->next_row()){
  echo "vec_codigo[$i]= '$dbdatos111->iden_cli';\n"; 
  $i++;
 
}

?>
var encontre=0;
for (j=0; j<<?php echo $i?>;j++){
  if(cajita_codigo==vec_codigo[j])
    encontre=1;
}

if(encontre==1){  
  if (document.getElementById('nit').value!="") {
    alert('El No de identificacion ya esta registrado')
    document.getElementById('nit').value="";
    return false;
  }
}
}

function datos_completos(){  
if (document.getElementById('nombre1').value == "" || document.getElementById('nit').value == ""  )
	return false;
else
	return true;
}

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

//CALCULA EL DIGITO DE VERIFICACION DE UN NIT O CEDULA
function CalcularDv(nit,dv)
{ 
 var vpri, x, y, z, i, nit1, dv1;
 nit1=document.getElementById(nit).value;
    if (isNaN(nit1))
    {
    document.getElementById(dv).value="X";
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
    document.getElementById(dv).value=dv1;
    }
}
</script>
</head>
<body <?php echo $sis?>>
<form  name="forma" id="forma" action="man_cliente.php"  method="post">
<table width="624" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
    <td bgcolor="#D1D8DE"><table width="100%" height="46" border="0" cellpadding="0" cellspacing="0">
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
        <td width="21" class="ctablaform"><a href="con_cliente.php?confirmacion=0&editar=<?php echo $editar?>&insertar=<?php echo $insertar?>&eliminar=<?php echo $eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
        
        <td width="21" class="ctablaform"></td>
        <td width="60" class="ctablaform">&nbsp;</td>
        <td width="24" valign="middle" class="ctablaform">&nbsp;</td>
        <td width="193" valign="middle"><label>
          <input type="hidden" name="editar"   id="editar"   value="<?php echo $editar?>">
		  <input type="hidden" name="insertar" id="insertar" value="<?php echo $insertar?>">
		  <input type="hidden" name="eliminar" id="eliminar" value="<?php echo $eliminar?>">
          <input type="hidden" name="codigo" id="codigo" value="<?php echo $codigo?>" />
        </label></td>
        <td width="67" valign="middle">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="4" valign="bottom"><img src="imagenes/lineasup3.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td class="textotabla1 Estilo1">CLIENTES 1:</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td bgcolor="#D1D8DE" valign="top">
	<table width="629" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="105" class="textotabla1">Primer nombre o razon social:</td>
        <td width="159"><input name="nombre1" id="nombre1" type="text" class="textfield2"  value="<?php echo $dbdatos->nom1_cli?>" />
          <span class="textorojo">*</span>
        <td>&nbsp;</td>
        <td width="105" class="textotabla1">Segundo nombre:</td>
        <td width="159"><input name="nombre2" id="nombre2" type="text" class="textfield2"  value="<?php echo $dbdatos->nom2_cli?>" /></td>
        <td width="20" align="left" class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Primer apellido:</td>
        <td><input name="apellido1" id="apellido1" type="text" class="textfield2"  value="<?php echo $dbdatos->apel1_cli?>" /></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textotabla1">Segundo apellido:</td>
        <td><input name="apellido2" id="apellido2" type="text" class="textfield2"  value="<?php echo $dbdatos->apel2_cli?>" /></td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td width="84" class="textotabla1">Tipo ID</td>
        <td colspan='4'><?php echo combo_evento_where("tipo_id","tipo_identificacion","cod_tiden","nom_tiden",$dbdatos->tipo_id_cli,""," where estado_tiden = 1");?>
          <span class="textorojo">*</span></td>
      </tr>    
      <tr>
        <td width="84" class="textotabla1">Nit/CC:</td>
        <td width="220"><input name="nit" id="nit" type="text" class="textfield2" onblur="CalcularDv('nit','dv')" onchange="buscar_nit()" value="<?php echo $dbdatos->iden_cli?>"  />
          <input name="dv" id="dv" type="text" maxlength="1" class="textfield0010" readonly='readonly' value="<?php echo $dbdatos->digito_cli?>"  />
          <span class="textorojo">*</span></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textotabla1">Direccion:</td>
        <td><input name="direccion" id="direccion" type="text" class="textfield2"  value="<?php echo $dbdatos->dir_cli?>" /></td>
        <td class="textorojo">&nbsp;</td>
      </tr>    
      <tr>
        <td class="textotabla1">Telefono:</td>
        <td><input name="telefono" id="telefono" type="text" class="textfield2"  value="<?php echo $dbdatos->tel_cli?>" /></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textotabla1">Celular:</td>
        <td><input name="celular" id="celular" type="text" class="textfield2"  value="<?php echo $dbdatos->cel1_cli?>" /></td>
        <td class="textorojo">&nbsp;</td>
        </tr>
      <tr>
        <td class="textotabla1">Departamento:</td>
        <td><?php combo_evento("departamento","departamento","cod_departamento","desc_departamento",$dbdatos->dpto_cli,"onchange='cargar_ciudad(\"departamento\",\"ciudad\")'","desc_departamento"); ?></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textotabla1">Ciudad:</td>
        <td><?php 
		if ($codigo == -10) {
			combo_evento_where("ciudad","ciudad","cod_ciudad","desc_ciudad","","","");
		}
		else {
		combo_evento_where("ciudad","ciudad","cod_ciudad","desc_ciudad",$dbdatos->ciu_cli,""," where departamento = $dbdatos->dpto_cli ");
		}?></td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">E-mail:</td>
        <td><input name="correo" id="correo" type="text" class="textfield2"  value="<?php echo $dbdatos->email_cli?>" /></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textotabla1">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="textorojo">&nbsp;</td>
        </tr>
	  <tr>
	    <td class="textotabla1">Valor credito:</td>
	    <td><input name="credito" id="credito" type="text" class="textfield2" onkeypress="return validaInt()"  value="<?php echo $dbdatos->cupo_cli?>" /></td>
	    <td class="textorojo">&nbsp;</td>
	    <td class="textotabla1">Dias factura: </td>
	    <td><input name="dias" id="dias" onkeypress="return validaInt('%d', this,event)"  type="text" class="textfield2"  value="<?php echo $dbdatos->plazo_cli?>" /></td>
	    <td class="textorojo">&nbsp;</td>
	  </tr>		
    <tr>
      <td class="textotabla1">Observaciones:</td>
      <td><input name="obser" id="obser" type="text" class="textfield2" value="<?php echo $dbdatos->obser_cli?>" /></td>
      <td>&nbsp;</td>
      <td class="textotabla1">Descuento</td>
      <td><input name="descuento" id="descuento" type="text" class="textfield2" value="<?php echo $dbdatos->desc_cli?>" /></td>
      <td>&nbsp;</td>
    </tr> 
    <tr>
      <td class="textotabla1">Cumpleaños:</td>
      <td><input name="fecha_cum" type="text" class="fecha" id="fecha_cum" readonly="1" value="<?php echo $dbdatos->fcun_cli?>"/><img src="imagenes/date.png" alt="Calendario4" name="calendario4" width="18" height="18" id="calendario4" style="cursor:pointer"/></td> 
    </tr>
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
          inputField  : "fecha_cum",      
          ifFormat    : "%Y-%m-%d",    
          button      : "calendario4" ,  
          align       :"T3",
          singleClick :true
        }
      );
</script>     
</body>
</html>