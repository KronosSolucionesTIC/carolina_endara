<?php include("lib/database.php");?>
<?php include("js/funciones.php");?>
<?php

//RECIBE LAS VARIABLES
$codigo = $_REQUEST['codigo'];
$guardar = $_REQUEST['guardar'];
$insertar = $_REQUEST['insertar'];
$eliminar = $_REQUEST['eliminar'];
$editar = $_REQUEST['editar'];
$empresa = $_REQUEST['empresa'];
$fecha_venta = $_REQUEST['fecha_venta'];
$bodega = $_REQUEST['bodega'];
$cliente = $_REQUEST['cliente'];
$usuario = $_SESSION['global_2'];
$vendedor = $_REQUEST['vendedor'];
$bodega_fac = $_REQUEST['bodega_fac'];
$guarda = $_REQUEST['guarda'];
$tipo_bono = $_REQUEST['tipo_bono'];

if($guarda==1) { // RUTINA PARA  INSERTAR REGISTROS NUEVOS
  if($cliente == 0){
      $campos="(nom1_cli,nom2_cli,apel1_cli,apel2_cli,tipo_id_cli,iden_cli,digito_cli,dir_cli,tel_cli,cel1_cli,dpto_cli,ciu_cli,
        email_cli,cupo_cli,plazo_cli,obser_cli,fcun_cli)";
  
      $valores="('".$_REQUEST['nombre1']."','".$_REQUEST['nombre2']."','".$_REQUEST['apellido1']."','".$_REQUEST['apellido2']."',
      '".$_REQUEST['tipo_id']."', '".$_REQUEST['nit']."','".$_REQUEST['dv']."','".$_REQUEST['direccion']."',
      '".$_REQUEST['telefono']."','".$_REQUEST['celular']."', '".$_REQUEST['departamento']."','".$_REQUEST['ciudad']."',
      '".$_REQUEST['correo']."','".$_REQUEST['credito']."','".$_REQUEST['dias']."','".$_REQUEST['obser']."','".$_REQUEST['fecha_cum']."')" ;  

      $cliente=insertar_maestro("cliente",$campos,$valores); 
  } else{
  
    $campos="nom1_cli='".$_REQUEST['nombre1']."',nom2_cli='".$_REQUEST['nombre2']."', apel1_cli='".$_REQUEST['apellido1']."', 
      apel2_cli='".$_REQUEST['apellido2']."', tipo_id_cli='".$_REQUEST['tipo_id']."', iden_cli='".$_REQUEST['nit']."',
      digito_cli='".$_REQUEST['dv']."', dir_cli='".$_REQUEST['direccion']."', tel_cli='".$_REQUEST['telefono']."', 
      cel1_cli='".$_REQUEST['celular']."', dpto_cli='".$_REQUEST['departamento']."',ciu_cli='".$_REQUEST['ciudad']."', 
      email_cli='".$_REQUEST['correo']."', cupo_cli='".$_REQUEST['credito']."', plazo_cli='".$_REQUEST['dias']."',
      obser_cli='".$_REQUEST['obser']."',fcun_cli='".$_REQUEST['fecha_cum']."'";
  
    $error=editar("cliente",$campos,'cod_cli',$cliente); 
  }
}

//CONSULTA NOMBRE VENDEDOR
$dbv = new database();
$sqlv = "SELECT * FROM vendedor WHERE cod_ven = $vendedor";
$dbv->query($sqlv);
$dbv->next_row();
$vend = $dbv->nom_ven;

function microtime_float(){ 
list($usec, $sec) = explode(" ", microtime()); 
return ((float)$usec + (float)$sec); 
} 

$time_start = microtime_float(); 

if($guardar==1 and $codigo==0)  { // RUTINA PARA  INSERTAR REGISTROS NUEVOS     
 
  $db6 = new Database();
  $sql = "select conse_tbono + 1  as  num_bono from tipo_bono WHERE cod_tbono = $tipo_bono ";
  $db6->query($sql);

  if($db6->next_row())
  $num_bono = $db6->num_bono;

  //ACTUALIZA LA ULTIMA FACTURA
  $db_a = new Database();
  $sql_a = "UPDATE tipo_bono SET conse_tbono = $num_bono  WHERE  cod_tbono=$tipo_bono";
  $db_a->query($sql_a);
    

  //HORA ACTIUAL
  $horas = date('H');
  $minutos = date('i');
  $segundos = date('s');

  $fecha_comp = $_REQUEST['fecha_fac'].' '.$horas.':'.$minutos.':'.$segundos;

  $compos="(tipo_bono,valor_bono,num_bono,cli_bono,fac_bono,ven_bono,fec_bono,obs_bono)";
  $valores="('".$_REQUEST['tipo_bono']."','".$_REQUEST['todocompra']."','".$num_bono."','".$cliente."','','".$_REQUEST['vendedor']."','".$fecha_comp."','".$_REQUEST['observaciones']."')" ;
  
  $ins_id=insertar_maestro("bono",$compos,$valores); 
  
  $cliente_facs=$cliente_fac;   

    
    //INSERCION DE LOS OTROS PAGOS
    for ($i=1; $i<=9; $i++){
      if(($i != 1)and($i != 2)){
        $valor_otro = $_REQUEST["pago_".$i];

        if($valor_otro > 0){
          $compos="(cod_usu_otro,fec_otro,cod_cli_otro,obs_otro,val_otro,cod_tpag_otro,cod_tarjeta,num_auto,cod_fac,cod_bono)";
          $valores="('".$usuario."','".$fecha_comp."','".$cliente."','".$obs."','".$valor_otro."','".$i."','".$i."','".$_REQUEST['autorizacion_'.$i]."','','".$ins_id."')" ;

          $error=insertar("otros_pagos",$compos,$valores); 
        }
      }
    }
  
  if ($ins_id > 0) {
    header("Location: informes/ver_bono_imp.php?codigo=$ins_id");  
    
  } else{
    echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>"; 
  } 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Facturaciòn</title>
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
<?
$dbdatos_cliente= new  Database();
$sql=" select cod_lista from lista  where act_lista = 1"; 
$dbdatos_cliente->query($sql);
if($dbdatos_cliente->next_row()){
  $codigo_lista_cliente=$dbdatos_cliente->cod_lista;
}
$dbdatos_cliente->close();
?>

<script language="javascript">
function activa_casilla_efec(){
  if (document.getElementById("efectivo").checked == true){
    document.getElementById("pago_2").disabled = false;
    document.getElementById("pago_2").value = parseInt(document.getElementById('saldo').value) ;
  }
  else {
    document.getElementById("pago_2").value = 0;
    document.getElementById("pago_2").disabled = true;
  }
}


function activa_casilla_data(cont){
  if (document.getElementById("datafono_" + cont).checked == true){
    document.getElementById("pago_" + cont).disabled = false;
    document.getElementById("pago_" + cont).value = parseInt(document.getElementById('saldo').value) ;
  }
  else {
    document.getElementById("pago_" + cont).value = 0;
    document.getElementById("pago_" + cont).disabled = true;
  }
}

function prueba(){
  var subtotal = document.getElementById('subtotal').value;
  var descuento = document.getElementById('desc_tot').value;
  var total = parseInt(subtotal) - parseInt(descuento);
  document.getElementById('todocompra').value = total;
}


function datos_completos(){   
  if(document.getElementById("efectivo").checked==false && document.getElementById("data").checked==false) {
    alert('Seleccione un tipo de pago')
    return false;
  }
      
  if (document.getElementById('todocompra').value == ""){ 
    return false;
  }
  else 
  
  total_suma = 0;
  for(i=1; i<=9; i++){
    valor = parseInt(document.getElementById('pago_'+i).value);
    if (valor == ""){
      valor = 0;
    }
    total_suma = total_suma + valor;
  }
  
  if(total_suma != parseInt(document.getElementById('todocompra').value)){
    alert('El pago debe ser igual al total de la compra');
    return false;
  }
  
    return true;
}

//ACTIVA BONO
function activa_bono(){
  if(document.getElementById('bono_chec').checked == true){
    document.getElementById('bono_div').style.display = "inline";
    document.getElementById('bono_div2').style.display = "inline";
  } else {
    document.getElementById('bono_div').style.display = "none";
    document.getElementById('bono_div2').style.display = "none";
    devuelve_total();
  }
  
}

//TRAE EL VALOR DEL BONO
function carga_bono(){
  <?php
  $dbb = new database();
  $sqlb = "SELECT * FROM bono
  WHERE estado_bono = 1";
  $dbb->query($sqlb);
  while($dbb->next_row()){
    echo "if(document.getElementById('bono').value == $dbb->cod_bono){";
    echo "document.getElementById('bono_valor').value = $dbb->valor_bono;";
    echo "document.getElementById('bono_tot').value = $dbb->valor_bono;";
    echo "} else {";
    echo "document.getElementById('bono_valor').value = 0";
    echo "}";
  }
  ?>
  resta_bono(document.getElementById('bono_valor').value);
}



//RESTA EL VALOR DEL BONO AL TOTAL DE LA FACTURA
function resta_bono(valor){
  if(document.getElementById('todocompra').value > 0){
    document.getElementById('todocompra').value = parseInt(document.getElementById('subtotal').value) - parseInt(document.getElementById('desc_tot').value) - parseInt(valor);
    document.getElementById('subtotal').value = parseInt(document.getElementById('subtotal').value) - parseInt(document.getElementById('desc_tot').value) - parseInt(valor);
  }
}

//CALCULA SALDO
function calcula_saldo(){
  var tot = document.getElementById('todocompra').value;
  var tot_pag = 0;

  //suma los pagos
  for(i = 2; i <= 9; i++){
    tot_pag = tot_pag + parseInt(document.getElementById('pago_' + i).value);
  }

  document.getElementById('saldo').value = parseInt(tot) - parseInt(tot_pag);
}

//ACTIVA TARJETA
function activa_tarjeta(){
  if(document.getElementById('data').checked == true){
    for(i = 3; i <= 9; i++){
      document.getElementById('tarjeta_nom_'+i).style.display = 'inline';
      document.getElementById('tarjeta_chec_'+i).style.display = 'inline';
      document.getElementById('tarjeta_pago_'+i).style.display = 'inline';
      document.getElementById('tarjeta_no_'+i).style.display = 'inline';
      document.getElementById('tarjeta_auto_'+i).style.display = 'inline';
    } 
  } else {
    for(i = 3; i <= 9; i++){
      document.getElementById('tarjeta_nom_'+i).style.display = 'none';
      document.getElementById('tarjeta_chec_'+i).style.display = 'none';
      document.getElementById('tarjeta_pago_'+i).style.display = 'none';
      document.getElementById('tarjeta_no_'+i).style.display = 'none';
      document.getElementById('tarjeta_auto_'+i).style.display = 'none';
    } 
  }
}

//ACTIVA RECOMPRA
function activa_casilla_recompra(){
  if(document.getElementById('recompra_chec').checked == true){
    document.getElementById('recompra_por').focus();
  } else {
    document.getElementById('recompra_por').value = 0;
  }
}

//CALCULA RECOMPRA
function calcula_recompra(e){
  var e = (typeof event != 'undefined') ? window.event : e; // IE : Moz 
    if (e.keyCode == 13) {
        var porcentaje = document.getElementById('recompra_por').value ;
    if(document.getElementById('todocompra').value > 0){
      var bono = parseInt(document.getElementById('todocompra').value) * parseInt(porcentaje) / 100;
    }
    document.getElementById('recompra').value = bono;
    }
}
</script>
<script type="text/javascript" src="js/js.js">
</script><script type="text/javascript" src="js/funciones.js"></script>
</script><link href="css/stylesforms.css" rel="stylesheet" type="text/css" />
<link href="css/styles2.css" rel="stylesheet" type="text/css" />
<link href="informes/styles.css" rel="stylesheet" type="text/css" />
</head>
<body <?php echo $sis?>>
<div id="total">
<form  name="forma" id="forma" action="man_bono_venta.php"  method="post">
<span class="textotabla01">

</span>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
   <td bgcolor="#D1D8DE" >
   <table width="100%" height="30" border="0" cellspacing="0" cellpadding="0" align="center" > 
      <tr>
        <td width="5" height="30">&nbsp;</td>
        <td width="20" ><img src="imagenes/icoguardar.png" alt="Nueno Registro" width="16" height="16" border="0" onClick="cambio_guardar()" style="cursor:pointer"/></td>
        <td width="61" class="ctablaform">Guardar</td>
        <td width="21" class="ctablaform"><a href="con_bonos.php?confirmacion=0&editar=<?php echo $editar?>&insertar=<?php echo $insertar?>&eliminar=<?php echo $eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
        <td width="22" class="ctablaform"><a href="#"><img src="imagenes/iconolupa.gif" alt="Buscar" width="16" height="16" border="0" onclick="buscar_producto()" /></a></td>
        <td width="70" class="ctablaform">Consultar</td>
        <td width="21" class="ctablaform"></td>
        <td width="60" class="ctablaform">&nbsp;</td>
        <td width="24" valign="middle" class="ctablaform">&nbsp;</td>
        <td width="193" valign="middle">

          <input type="hidden" name="editar"   id="editar"   value="<?php echo $editar?>">
      <input type="hidden" name="insertar" id="insertar" value="<?php echo $insertar?>">
      <input type="hidden" name="eliminar" id="eliminar" value="<?php echo $eliminar?>">
          <input type="hidden" name="bodega" id="bodega" value="<?php echo $bodega?>">
          <input type="hidden" name="tipo_bono" id="tipo_bono" value="<?php echo $tipo_bono?>">
          <input type="hidden" name="cliente" id="cliente" value="<?php echo $cliente?>">
          <input type="hidden" name="codigo_lista_cliente" id="codigo_lista_cliente" value="<?php echo $codigo_lista_cliente?>">
          <input type="hidden" name="codigo" id="codigo" value="<?php echo $codigo?>" /> </td>
        
        <td width="67" valign="middle">&nbsp;</td>
      </tr>
    </table>
  </td>
  </tr>
  <tr>
    <td height="4" valign="bottom"><img src="imagenes/lineasup3.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td class="textotabla01"> <?
 
    $db6 = new Database();
    $sql = "select conse_tbono + 1  as  num_bono from tipo_bono WHERE cod_tbono = $tipo_bono ";
    $db6->query($sql);

    if($db6->next_row())
    $num_bono = $db6->num_bono;

  ?>
    BONO DE VENTA  Nro. <?php echo $num_bono?></td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif"  width="100%" height="4"/></td>
  </tr>
  <tr>
    <td bgcolor="#D1D8DE" valign="top">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
        <td class="textotabla1">Fecha:</td>
        <td colspan="2" class="subtitulosproductos"><?php echo $fecha_venta?>
          <input name="fecha_fac" id="fecha_fac" type="hidden" value="<?php echo $fecha_venta?>"  /></td>
        <td class="textotabla1">Usuario:</td>
        <td class="subtitulosproductos">
    <?
    if ($codigo!=0) echo $dbdatos_edi->nom_usu;
    else  echo $_SESSION['global_3'];
    
    ?>
    <input name="usuario" id="usuario" type="hidden" value="<?php echo $usuario?>"></td>     
        <td class="textotabla1">Empresa:</td>
        <td colspan="2" class="subtitulosproductos">
    <?
    $sql ="SELECT nom_rso from rsocial where cod_rso=$empresa";
  $db->query($sql);
  while($db->next_row()){
    echo $db->nom_rso;
  }
    ?>
    <input name="empresa" id="empresa" type="hidden" value="<?php echo $empresa?>"></td>
        <td class="textotabla1"> Bodega:</td>
        <td class="subtitulosproductos"><span class="textoproductos1">
          <?
    $sql ="SELECT nom_bod from bodega where cod_bod=$bodega";
  $db->query($sql);
  while($db->next_row()){
    echo $db->nom_bod;
  }
    ?>
          <input name="bodega_fac" id="bodega_fac" type="hidden" value="<?php echo $bodega?>">
        </span></td>     
        <td>
      <input name="precio_lista" id="precio_lista" type="hidden" class="subtitulosproductos" />   </td>
       <td class="textotabla1">Cliente:</td>
       <td colspan="2" class="subtitulosproductos"><?
  $sql ="SELECT nom1_cli,apel1_cli,cupo_cli from cliente where cod_cli=$cliente";
  $db->query($sql);
  while($db->next_row())
  {
    echo $db->nom1_cli." ".$db->apel1_cli;

    $cupo_covinoc=$db->cupo_cli;
  }
  
   $sql ="SELECT SUM(((SELECT SUM(total_pro) FROM d_factura WHERE cod_mfac=m_factura.cod_fac)- valor_abono )) -(SUM(tot_dev_mfac)) AS cartera 
FROM m_factura
INNER JOIN cartera_factura ON cartera_factura.cod_fac= m_factura.cod_fac
WHERE  tipo_pago='Credito'   AND estado_car<>'CANCELADA' AND cod_cli=$cliente";
  $db->query($sql);
  while($db->next_row())
  {

    $cartera_ocupada=$db->cartera;
  }
  
  
  $cupo_covinoc=$cupo_covinoc-$cartera_ocupada;
    ?>
         <input name="cliente_fac" id="cliente_fac" type="hidden" value="<?php echo $cliente?>" /></td>
       <td class="textotabla1">Vendedor</td>
       <td class="subtitulosproductos"><input name="vendedor" id="vendedor" type="hidden" value="<?php echo $vendedor?>" /><?php echo $vend ?></td>
     </tr>
     <tr>
       <td class="textotabla1"></td>
       <td colspan="2"><input name="Credito" id="Credito" type="hidden"  value="Credito" />
         <div id="cupo" style="display:none"> <span class="textotabla1">Cupo:<span class="textorojo">
           <input name="cupo_credito" id="cupo_credito" type="hidden" class="caja_resalte1"  readonly="readonly"/>
           </span></span></div>
         <span  id="div_credito" style="display:none" class="textoproductos1"> $
           <?php echo number_format($cupo_covinoc ,0,",",".")?>
           <input name="cupo_covinoc" type="hidden" id="cupo_covinoc"  value="<?php echo $cupo_covinoc?>" readonly="readonly" align="right"/>
           </span>
         <textarea name="tipo_referencias"  id="tipo_referencias"   cols="45" rows="4"  style="display:none"></textarea>
         <span class="textotabla1">
         <input name="pago_1" id="pago_1" type="hidden" class="caja_resalte1" onkeypress="return validaInt_evento(this,'mas')" disabled="disabled" value="0"/>
         </span></td>
        <td class="textotabla1">&nbsp;</td>
        <td class="textotabla1">&nbsp;</td>
        
        <td colspan="2">&nbsp;</td>    
        </tr>
     <tr>
       <td class="textotabla1"> Efectivo:</td>
       <td><input name="efectivo" id="efectivo" type="checkbox"  value="efectivo" onclick="activa_casilla_efec('this',pago_2)" />
         <td><input name="pago_2" id="pago_2" type="text" class="caja_resalte1" onblur='calcula_saldo()' onkeypress="calcula_saldo()" disabled="disabled" value="0"/>
         </span></td>
       <td class="textorojo">Saldo:</td>
       <td class="textorojo"><input name="saldo" id="saldo" type="text" readonly='1' class="caja_resalte1" value='0'/></td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
     </tr>
    <tr>
      <td class="textotabla1">Datafono:</td>
      <td class="textotabla1" colspan="11"><input name="data" id="data" type="checkbox"  value="data" onclick="activa_tarjeta()" /></td>
    </tr>
      <?php
      //CONSULTA LAS TARJETAS DE CREDITO
      $dbt = new database();
      $sqlt = "SELECT * FROM tarjeta
      WHERE estado_tarjeta = 1";
      $dbt->query($sqlt);
      $i = 3;
      $j = 0;
      while($dbt->next_row()){
      ?>
      <?PHP if($j==0 or $j==2 or $j==4 or $j==6){ ?> 
      <tr>
      <? } ?>
      <?php echo "<td class='textotabla1'><div id='tarjeta_nom_$i' style='display:none'>$dbt->nom_tarjeta</div></td>      
      <td>
        <div id='tarjeta_chec_$i' style='display:none'>
          <input name='datafono_$i' id='datafono_$i' type='checkbox'  value='datafono_$i' onclick='activa_casilla_data($i)' />
        </div>
      </td>     
       ";

       echo "<td><div id='tarjeta_pago_$i' style='display:none'><span class='textotabla1'>
         <input name='pago_$i' id='pago_$i' type='text' class='caja_resalte1' onblur='calcula_saldo()' onkeypress='calcula_saldo()' 
         disabled='disabled' value='0'/>
         </span></div></td>
       <td class='textotabla1'><div id='tarjeta_no_$i' style='display:none'>No autorizacion</div></td>";
       ?>
       <td><?php echo "<div id='tarjeta_auto_$i' style='display:none'><input type='text' size='4' id='autorizacion_$i' name='autorizacion_$i'></div>";?></td>
      <?PHP if($j==1 or $j==3 or $j==5 or $j==7){ ?> 
      </tr>
      <? } ?> 
       
      <?php
        $j++; 
        $i++;
      } 
    ?>
     <tr>
       <td class="textotabla1">&nbsp;</td>
       <td class="subtitulosproductos">&nbsp;</td>
       <td class="subtitulosproductos">&nbsp;</td>
       <td class="textorojo">&nbsp;</td>
       <td class="textotabla1">&nbsp;</td>
       <td colspan="2">&nbsp;</td>
       </tr>
     <tr>
        <td colspan="16" class="textotabla1" >
    <table  width="100%" border="1">                        
     <tr >
      <td  colspan="11">
        <table width="100%">
        <tr >
        <td  class="ctablasup"><div align="left">Observaciones:</div></td>
        <td  class="ctablasup"><div align="right">Resumen Venta </div></td>
        </tr>
        <tr >
        <td width="47%" ><div align="left" >
          <textarea name="observaciones" id="observaciones" cols="45" rows="3" class="textfield02"><?php echo $dbdatos->obs_bono?></textarea>
          <?php 
$time_end = microtime_float(); 
$time = number_format($time_end - $time_start, 5); 

echo "$time";
echo $tipo; 
?>
        </div>          </td>
        <td width="53%" ><div align="right"><span class="ctablasup">Total  Venta:</span>
                                    <input name="todocompra" id="todocompra" type="text" class="textfield01" value="<?php if($codigo !=0) echo $dbdatos_edi->tot_fac; else echo "0"; ?>"/>
                            </div></td>
        </tr>

        </table>        </td>
      </tr>
    </table>
      </table>
      </td>
    </tr>
    <tr> 
      <td colspan="8" >     </td>
    </tr>
    </table>
<tr>

  <tr>
    <td>
  <input type="hidden" name="val_inicial" id="val_inicial" value="<?php if($codigo!=0) echo $jj-1; else echo "0"; ?>" />
  <input type="visible" name="guardar" id="guardar" />
     <?php  if ($codigo!="") $valueInicial = $aa; else $valueInicial = "1";?>
    <input type="visible" id="tipo" name='tipo' value="<?php echo $tipo?>"> 
     <input type="hidden" id="valDoc_inicial" value="<?php echo $valueInicial?>"> 
     <input type="hidden" name="cant_items" id="cant_items" value=" <?php  if ($codigo!="") echo $aa; else echo "0"; ?>">
  </td>
  </tr>
</table>
</form> 
</div>
</body>
</html>