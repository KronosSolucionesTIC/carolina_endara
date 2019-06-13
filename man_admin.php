<?php include("lib/database.php");?>
<?php include("js/funciones.php");?>
<?php

//RECIBE LAS VARIABLES
$codigo = $_REQUEST['codigo'];
$guardar = $_REQUEST['guardar'];
$insertar = $_REQUEST['insertar'];
$eliminar = $_REQUEST['eliminar'];
$editar = $_REQUEST['editar'];

if ($codigo!=0) {
$sql ="SELECT * FROM m_cuenta  WHERE cod_cuenta=$codigo";
$dbdatos= new  Database();
$dbdatos->query($sql);
$dbdatos->next_row();

if($codigo == 1){
  $texto = 'POR COBRAR';
} else {
  $texto = 'POR PAGAR';
}
}

if($guardar==1 and $codigo!=0) { // RUTINA PARA EDITAR REGISTROS NUEVOS

  $db1= new  Database();
  $sql="DELETE FROM d_cuenta WHERE cod_mcuenta=".$codigo;
  $db1->query($sql);  
  $db1->close();

    $campos="(cod_mcuenta,cod_cuenta)";
    
    for ($i=0 ;  $i <= $contador ; $i++){
      if($_REQUEST["casilla_".$i]) {
        $valores="('".$codigo."','".$_REQUEST["cod_contable_".$i]."')" ;
        $error=insertar("d_cuenta",$campos,$valores); 
      } 
    }

	if ($error==1) {
		header("Location: con_admin.php?confirmacion=2&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
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
function datos_completos(){
	return true;
}
</script>

</head>
<body <?php echo $sis?>>
<form  name="forma" id="forma" action="man_admin.php"  method="post">
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
        <td width="21" class="ctablaform"><a href="con_admin.php?confirmacion=0&amp;editar=<?php echo $editar?>&amp;insertar=<?php echo $insertar?>&amp;eliminar=<?php echo $eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
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
    <td class="textotabla1 Estilo1">CUENTAS X <?php echo $texto?>:</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td bgcolor="#D1D8DE" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
        <td class="textotabla1" align="center">Seleccion</td>
        <td class="textotabla1" align="center">Codigo</td>
        <td class="textotabla1" align="center">Nombre</td>
  </tr>
  <?php
  //CONSULTA TODAS LAS CUENTAS CONTABLES
  $contador = 0;
  $dbc = new database();
  $sqlc = "SELECT * FROM cuenta
  WHERE estado_cuenta = 1
  ORDER BY cod_contable";
  $dbc->query($sqlc);
  while ($dbc->next_row()) {
  ?>
      <tr>
      <?php
      //CONSULTA CUALES ESTAN ACTIVAS O NO
      $dbd = new database();
      $sqld = "SELECT * FROM d_cuenta
      WHERE cod_mcuenta = $codigo AND cod_cuenta = $dbc->cod_cuenta";
      $dbd->query($sqld);
      if($dbd->next_row()){
        $bandera = 1;
      } else {
        $bandera = 0;
      }
      
      echo "<td class='textotabla1'>";

      if($bandera == 1){

      echo "<input type='checkbox' checked=true id='casilla_$contador' name='casilla_$contador'>";

      } else { 

      echo "<input type='checkbox' id='casilla_$contador' name='casilla_$contador'>";

      } 

      echo "</td>";

      echo "<td class='textotabla1'><input type='hidden' name='cod_contable_$contador' id='cod_contable_$contador' value='$dbc->cod_cuenta'>$dbc->cod_contable</td>";

      echo "<td class='textotabla1'>$dbc->desc_cuenta</td>";

      ?>
      </tr>
  <?php 
  //CUENTA LA CANTIDAD DE CUENTAS
    $contador++;
    } 
  ?>
    </table></td>
  </tr>
  <tr>
    <td><input type="hidden" name="contador" value="<?php echo $contador?>"></td>
    <td><div align="center"><img src="imagenes/spacer.gif" alt="." width="624" height="4" /></div></td>
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
</body>
</html>