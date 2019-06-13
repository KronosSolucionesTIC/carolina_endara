<?php include("lib/database.php");?>
<?php include("js/funciones.php");?>
<?php

//RECIBE LAS VARIABLES
$codigo = $_REQUEST['codigo'];
$guardar = $_REQUEST['guardar'];
$insertar = $_REQUEST['insertar'];
$eliminar = $_REQUEST['eliminar'];

if ($codigo!=0) {
    $sql ="SELECT * from producto
	WHERE cod_pro = $codigo";
	$dbdatos= new  Database();
	$dbdatos->query($sql);
	$dbdatos->next_row();
}

if($guardar==1 and $codigo==0) { // RUTINA PARA  INSERTAR REGISTROS NUEVOS
	
	$compos="(cod_fry_pro,nom_pro,cod_tpro_pro, cod_mar_pro,valor_pro,promo_pro,temp_pro,costo_pro)";
	$valores="('".$_REQUEST['cod_fry_pro']."','".$_REQUEST['nombres']."','".$_REQUEST['tipo_producto']."','".$_REQUEST['marca']."','".$_REQUEST['precio']."','".$_REQUEST['precio']."','".$_REQUEST['precio']."','".$_REQUEST['costo']."')" ;
	$error = insertar("producto",$compos,$valores); 
	
	if ($error==1) {
		header("Location: con_referencia.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	}
	else
		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 
}

if($guardar==1 and $codigo!=0) { // RUTINA PARA EDITAR REGISTROS NUEVOS
	$compos="cod_fry_pro='".$_REQUEST['cod_fry_pro']."',nom_pro='".$_REQUEST['nombres']."',cod_tpro_pro='".$_REQUEST['tipo_producto']."',cod_mar_pro='".$_REQUEST['marca']."',valor_pro='".$_REQUEST['precio']."',costo_pro='".$_REQUEST['costo']."'";
	$error=editar("producto",$compos,'cod_pro',$codigo); 
	
	if ($error==1) {
		header("Location: con_referencia.php?confirmacion=2&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	}
	else
		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
//CARGA EL TIPO DEL PRODUCTO
function cargar_tipo_producto(categoria,tipo_producto){
var combo=document.getElementById(tipo_producto);
combo.options.length=0;
var cant=0;
combo.options[cant] = new Option('Seleccione','0'); 
cant++;
<?
		$sqltp ="SELECT * FROM tipo_producto ORDER BY `tipo_producto`.`nom_tpro` ASC";		
		$dbtp= new  Database();
		$dbtp->query($sqltp);
		while($dbtp->next_row()){ 
		echo "if(document.getElementById(categoria).value==$dbtp->cod_marca) {";
		echo "combo.options[cant] = new Option('$dbtp->nom_tpro','$dbtp->cod_tpro');";
		echo "cant++; } ";
		}
?> 
}

function datos_completos(){
if (document.getElementById('nombres').value == "" || document.getElementById('tipo_producto').value == 0 || document.getElementById('marca').value == 0 || document.getElementById('bandera').value == 0)
	return false;
else
	return true;
}

function buscar_codigo(){

var cajita_codigo=document.getElementById('cod_fry_pro').value;
var vec_codigo = new Array;
<?
$dbdatos111= new  Database();
$sql ="select cod_fry_pro from producto WHERE estado_producto = 1";
$dbdatos111->query($sql);
$i = 0;
while($dbdatos111->next_row()){
	echo "vec_codigo[$i]= '$dbdatos111->cod_fry_pro';\n";	
	$i++;
 
}

?>
var encontre=0;
for (j=0; j<<?php echo $i?>;j++){
	if(cajita_codigo==vec_codigo[j])
		encontre=1;
}

if(encontre==1){	
	if (document.getElementById('cod_fry_pro').value!="") {
		alert('La referencia ya esta registrada')
		document.getElementById('cod_fry_pro').value="";
		return false;
	}
}

}

//VALIDA LOS DIGITOS DEL CODIGO
function valida_codigo(){
  var texto = document.getElementById('cod_fry_pro').value;
  var numeroCaracteres = texto.length;

  if(parseInt(numeroCaracteres) != 8){
    alert('Verifique los digitos del codigo');
    document.getElementById('bandera').value = 0;
    document.getElementById('cod_fry_pro').focus();
    return false;
  } else{
    document.getElementById('bandera').value = 1;
  }
}
</script>

</head>
<body <?php echo $sis?>>
<form  name="forma" id="forma" action="man_referencia.php"  method="post">
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
        <td width="20" ><img src="imagenes/icoguardar.png" alt="Nueno Registro" width="16" height="16" border="0"  onclick="cambio_guardar()" style="cursor:pointer"/></td>
        <td width="61" class="ctablaform">Guardar</td>
        <td width="21" class="ctablaform"><a href="con_referencia.php?confirmacion=0&editar=<?php echo $editar?>&insertar=<?php echo $insertar?>&eliminar=<?php echo $eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
        <td width="22" class="ctablaform">&nbsp;</td>
        <td width="70" class="ctablaform">&nbsp;</td>
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
    <td class="textotabla1 Estilo1">PRODUCTO:</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td bgcolor="#D1D8DE" valign="top">
	<table width="629" border="0" cellspacing="0" cellpadding="0">
		<tr>
        <td width="128" class="textotabla1">Categoria</td>
        <td width="187"><?php combo_evento("marca","marca","cod_mar","nom_mar",$dbdatos->cod_mar_pro,"onchange=\"cargar_tipo_producto('marca','tipo_producto') \"", "nom_mar"); ?></td>
        <td width="9" class="textorojo">*</td>
        <td class="textotabla1">Nombre Interno:</td>
        <td><input name="nombres" id="nombres" type="text" class="textfield2"  value="<?php echo $dbdatos->nom_pro?>" /></td>
        <td><span class="textorojo">*</span></td>
        <td width="39" class="textorojo">&nbsp;</td>
      </tr>
	  
	  
	  
	  
      <tr>
        <td width="128" class="textotabla1">Tipo Producto </td>
        <td width="187">
		<?php combo_evento("tipo_producto","tipo_producto","cod_tpro","nom_tpro",$dbdatos->cod_tpro_pro,"", "nom_tpro"); ?>		</td>
        <td width="9" class="textorojo">*</td>
        <td class="textotabla1">Codigo:</td>
        <td><input name="cod_fry_pro" id="cod_fry_pro" type="text" class="textfield2"  value="<?php echo $dbdatos->cod_fry_pro?>" onchange="buscar_codigo()"  onblur="valida_codigo()"/></td>
        <td><span class="textorojo">*</span></td>
        <td width="39" class="textorojo">&nbsp;</td>
      </tr>  
      <tr>
        <td width="128" class="textotabla1">Precio</td>
        <td width="187"><input name="precio" id="precio" type="text" class="textfield2"  value="<?php echo $dbdatos->valor_pro?>" /></td>
        <td width="9" class="textorojo">*</td>
        <td class="textotabla1">Costo:</td>
        <td><input name="costo" id="costo" type="text" class="textfield2"  value="<?php echo $dbdatos->costo_pro?>" />
        <td><span class="textorojo">*</span></td>
        <td width="39" class="textorojo">&nbsp;</td>
      </tr>        
        <tr>
	    <td class="textotabla1">&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td class="textotabla1">&nbsp;</td>
	    <td>&nbsp;</td>
	    <td >&nbsp;</td>
	    <td >&nbsp;</td>
	    </tr>
	  </table></td>
  </tr>
  
  <tr>
    <td><div align="center"><img src="imagenes/spacer.gif" alt="." width="624" height="4" /></div></td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td height="30"  > <input type="hidden" name="guardar" id="guardar" />
    <input type="hidden" name="bandera" id="bandera" />
	  <input type="hidden" name="contador" id="contador" value="<?php echo $jj - 1?>"/></td>
  </tr>
</table>
</form> 
</body>
</html>