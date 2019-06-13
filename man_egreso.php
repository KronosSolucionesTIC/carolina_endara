<? include("lib/database.php")?>
<? include("js/funciones.php")?>
<?
if ($codigo!="") {

$sql ="SELECT nom_usu,cc_usu,tel_usu,dir_usu,log_usu,pas_usu  FROM usuario WHERE cod_usu=$codigo";
$dbdatos= new  Database();
$dbdatos->query($sql);
$dbdatos->next_row();
}


if($guardar==1 and $codigo==0) { // RUTINA PARA  INSERTAR REGISTROS NUEVOS

	$compos="(nom_usu,cc_usu,tel_usu,dir_usu,log_usu,pas_usu,estado_usuario)";
	$valores="('".$nombres."',".$cc.",'".$tele."','".$dir."','".$login."','".$pass."','1')" ;
	$error=insertar($t_usuario,$compos,$valores); 

	if ($error==1) {
		header("Location: con_usuario.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	}
	else
		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 
}

if($guardar==1 and $codigo!=0) { // RUTINA PARA  editar REGISTROS NUEVOS
	$compos="nom_usu='".$nombres."',cc_usu=".$cc.",tel_usu='".$tele."',dir_usu='".$dir."',log_usu='".$login."',pas_usu='".$pass."',estado_usuario = '1'";
	$error=editar("usuario",$compos,'cod_usu',$codigo); 
	//echo $error; exit;
	if ($error==1) {
		header("Location: con_usuario.php?confirmacion=2&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
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
<link href="css/styles.css" rel="stylesheet" type="text/css" /> 
<? inicio() ?>

<script language="javascript">
function datos_completos(){  
if (document.getElementById('nombres').value == "" || document.getElementById('cc').value == "" )
	return false;
else
	return true;
}

function poner_letras(){
  var num = document.getElementById('valor').value ; 
  val = covertirNumLetras(num);
  document.getElementById('texto').value = val;
}

function cargar_facturas(){
  var combo=document.getElementById('facturas');
  combo.options.length=0;
  var cant=0;
  combo.options[cant] = new Option('Seleccione...','0'); 
  cant++;
  <?
    $i=0;
    $sqlc ="SELECT * FROM `proveea` ";   
    $dbc= new  Database();
    $dbc->query($sqlc);
    while($dbc->next_row()){ 
    echo "if(document.getElementById('cliente').value=='$dbc->benef'){ "; 
    echo "combo.options[cant] = new Option('$dbc->fact','$dbc->fact'); ";
    echo "cant++; } ";
    }
  ?>
}
</script>
<script type="text/javascript" src="js/funciones.js"></script>
</head>
<body <?=$sis?>>
<form  name="forma" id="forma" action="man_egreso.php"  method="post">
<table width="624" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
    <td bgcolor="#FFF"><table width="100%" height="46" border="0" cellpadding="0" cellspacing="0">
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
        <td width="21" class="ctablaform"><a href="con_usuario.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
        <td width="22" class="ctablaform">&nbsp;</td>
        <td width="70" class="ctablaform">&nbsp;</td>
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
    <td class="textotabla2">COMPROBANTE DE EGRESO:</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td class="tablacabezera" valign="top">
	<table width="629" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="78" class="textotabla1">No:</td>
        <td width="144"><input name="nombres" id="nombres" type="text" class="textfield2"  value="<?=$dbdatos->nom_usu?>" /></td>
        <td width="9"><span class="textorojo">*</span></td>
        <td width="64"><span class="textotabla1">Fecha:</span></td>
        <td width="150"><input name="fecha" type="text" class="caja_resalte1" id="fecha" readonly="1" value="<? echo date('Y-m-d') ?>" /><img src="imagenes/date.png" alt="Calendario" name="calendario" width="16" height="16" border="0" id="calendario" style="cursor:pointer"/></td>
        <td width="11" class="textorojo">*</td>
        <td width="173" class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Cliente:</td>
        <td><? combo_evento_where("cliente","maeben","benef","CONCAT(benef,'-',nom)",$dbdatos->cod_ben_ment," onchange='cargar_facturas();'"," where estado = 1 AND clas = 'd' ORDER BY benef");  ?></td>
        <td><span class="textorojo">*</span></td>
        <td><span class="textotabla1">Valor:</span></td>
        <td><a href="#">
          <input name="valor" type="text" class="textfield2" id="valor" onkeypress='poner_letras();' value="<?=$dbdatos->tel_usu?>"/>
        </a></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Cuenta banco:</td>
        <td><input name="login" type="text" class="textfield2" id="login" value="<?=$dbdatos->log_usu?>"/></td>
        <td>&nbsp;</td>
        <td></td>
        <td ></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Valor en letras:</td>
        <td colspan='6'><input name="texto" type="text" class="val_letras" id="texto" value="<?=$prueba?>"/></td>
      </tr>
      <tr>
        <td class="textotabla1">Facturas:</td>
        <td><? combo_evento_where("facturas","proveea","cod_prov","fact",$dbdatos->cod_ben_ment," onchange='cargar_plazo()'","");  ?></td>
        <td>&nbsp;</td>
        <td></td>
        <td ></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
        <tr>
          <th class="ctablasup"><div align='left'>Cheque:</div></th>
          <th><input type="text" name="tot" readonly='1' id="tot" value="<?=$total?>" style="text-align:right"/><input type="hidden" name="base" id="base" value="<?=$total?>" style="text-align:right"/></th>
        </tr>
        <tr>
          <th class="ctablasup"><div align='left'>Devolucion:</div></th>
          <?
           //CALCULA EL IVA
           $iva = $total * 0.16; 
          ?>
          <th><input type="text" readonly='1' name="iva" id="iva" value="<?=$iva?>" style="text-align:right"/></th>
        </tr>
        <tr>
          <th class="ctablasup"><div align='left'>Retefuente:</div></th>
          <th><input type="text" name="descuento" id="descuento" value="0" style="text-align:right" onkeypress="calcular_dto();return valida(event);"/></th>
        </tr>
        <tr>
          <th class="ctablasup"><div align='left'>Descuento:</div></th>
          <th><input type="text" name="flete" id="flete" value="0" style="text-align:right" onkeypress="sumar_flete();return valida(event);"/></th>
        </tr>
        <tr>
          <th class="ctablasup"><div align='left'>Efectivo:</div></th>
          <?
           //SUMA TOTAL
           $neto = $total + $iva; 
          ?>
          <th><input type="text" readonly='1' name="neto" id="neto" value="<?=$neto?>" style="text-align:right"/></th>
        </tr>
      <tr>
        <td class="textotabla1">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td><div align="center"><img src="imagenes/spacer.gif" alt="." width="624" height="4" /></div></td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif" alt="." width="100%" height="4" /></td>
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