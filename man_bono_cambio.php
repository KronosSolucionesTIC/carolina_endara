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

  $compos="(tipo_bono,valor_bono,num_bono,cli_bono,fac_bono,ven_bono,fec_bono)";
  $valores="('".$_REQUEST['tipo_bono']."','".$_REQUEST['todocompra']."','".$num_bono."','".$cliente."','".$_REQUEST['factura']."','".$_REQUEST['vendedor']."','".$fecha_comp."')" ;
  
  $ins_id=insertar_maestro("bono",$compos,$valores); 
  
  $cliente_facs=$cliente_fac;  

  //VALIDA LOS PRODUCTOS Y SUMA AL KARDEX
  $descuento = 0;
  $costo = 0;
  for($i=1; $i <= $_REQUEST['val_inicial']; $i++){
    if($_REQUEST['cant_cambio_'.$i] > 0){
          kardex("suma",$_REQUEST["codigo_referencia_".$i],$bodega,$_REQUEST["cant_cambio_".$i],'0','3','4');
          $cadena = $cadena.' '.$_REQUEST["codigo_marca_".$i].' '.$_REQUEST["codigo_tipo_prodcuto_".$i].' '.$_REQUEST["referencia_".$i].' '.$_REQUEST["cant_cambio_".$i].' '.$_REQUEST["val_cambio_".$i] ;
          $cadena = $cadena.'<br>';
          if($_REQUEST['descuento_'.$i] > 0){
            $descuento = $descuento + ($_REQUEST['valor_ref_'.$i] - $_REQUEST['val_tot_'.$i]);
          }
          $costo = $costo + ($_REQUEST["cant_cambio_".$i] * $_REQUEST["costo_uni_".$i]);
    }
  }
  $descuento_original = $descuento; 

  //ACTUALIZA LA ULTIMA FACTURA
  $db_b = new Database();
  $sql_b = "UPDATE bono SET obs_bono = '$cadena' WHERE  cod_bono=$ins_id";
  $db_b->query($sql_b);

////REGISTRO CONTABLE DE FACTURA////
  $sqla ="SELECT * FROM tipo_movimientos WHERE cod_tmov= 7";
  $dbda= new  Database();
  $dbda->query($sqla);
  $dbda->next_row(); 
      
  $letra=$dbda->nom_tmov;
  $num=$dbda->num_cons+1;
  if($num > 999) {
    $cadena = "0";
  }
  elseif($num > 99) {
    $cadena = "00";
  }
  elseif($num > 9) {
    $cadena = "000";
  }
  else {
    $cadena = "0000";
  }
  $consecutivo = $letra.'-'.$cadena.$num; 

  //REGISTRO EN M_MOVIMIENTO
  $campos="(conse_mov,num_mov,fec_emi,fec_venci,tipo_mov,cod_mov_pago,obs_mov)";
  $valores="('".$consecutivo."','','".$fecha_comp."','".$fecha_comp."','7','','')" ;
  $m_mov=insertar_maestro("m_movimientos",$campos,$valores); 
  //

  //MODIFICACION DEL CONSECUTIVO DEL MOVIMIENTO 
  $campos="num_cons='".$num."'";
  $error=editar("tipo_movimientos",$campos,'cod_tmov',7); 

      ///LA DEVOLUCION///
      //REGISTRO EN D_MOVIMIENTO
      $devolucion = round($_REQUEST['todocompra'] / 1.19);
      $campos="(cod_mov,cuenta_dmov,concepto_dmov,debito_dmov,credito_dmov,cod_ter,centro_dmov)";   
      $valores="('".$m_mov."','2524','".'NOTA CREDITO No '.$num."','".$devolucion."','0','".$cliente."','')"; 
      $error=insertar("d_movimientos",$campos,$valores);
      
      //NIVEL 4
      //TOMA LOS 6 PRIMEROS CARACTERES DEL CODIGO CONTABLE DE LA CUENTA
      $cod_cuenta = 2524;
      $dbc = new Database();
      $sqlc = "SELECT substring(cod_contable,1,6) as cadena FROM cuenta
      WHERE cod_cuenta = $cod_cuenta";
      $dbc->query($sqlc);
      $dbc->next_row();
      $cod = $dbc->cadena;
      
      //BUSCA EL CODIGO DE LA CUENTA MAYOR
      $dbcm = new Database();
      $sqlcm = "SELECT cod_cuenta FROM cuenta
      WHERE cod_contable = $cod";
      $dbcm->query($sqlcm);
      $dbcm->next_row();
      $cuenta = $dbcm->cod_cuenta;
      
      //INGRESA REGISTROS DEL NIVEL 4
      $valores="('".$m_mov."','".$cuenta."','".'NOTA CREDITO No  '.$num_factura."','".$devolucion."','0','".$cliente."','')";          
      $error=insertar("d_movimientos",$campos,$valores);
      
      
      //NIVEL 3
      //TOMA LOS 4 PRIMEROS CARACTERES DEL CODIGO CONTABLE DE LA CUENTA
      $cod_cuenta = 2524;
      $dbc = new Database();
      $sqlc = "SELECT substring(cod_contable,1,4) as cadena FROM cuenta
      WHERE cod_cuenta = $cod_cuenta";
      $dbc->query($sqlc);
      $dbc->next_row();
      $cod = $dbc->cadena;
      
      //BUSCA EL CODIGO DE LA CUENTA MAYOR
      $dbcm = new Database();
      $sqlcm = "SELECT cod_cuenta FROM cuenta
      WHERE cod_contable = $cod";
      $dbcm->query($sqlcm);
      $dbcm->next_row();
      $cuenta = $dbcm->cod_cuenta;
      
      //INGRESA REGISTROS DEL NIVEL 3
      $valores="('".$m_mov."','".$cuenta."','".'NOTA CREDITO No  '.$num_factura."','".$devolucion."','0','".$cliente."','')";          
      $error=insertar("d_movimientos",$campos,$valores);
      
      //NIVEL 2
      //TOMA LOS 2 PRIMEROS CARACTERES DEL CODIGO CONTABLE DE LA CUENTA
      $cod_cuenta = 2524;
      $dbc = new Database();
      $sqlc = "SELECT substring(cod_contable,1,2) as cadena FROM cuenta
      WHERE cod_cuenta = $cod_cuenta";
      $dbc->query($sqlc);
      $dbc->next_row();
      $cod = $dbc->cadena;
      
      //BUSCA EL CODIGO DE LA CUENTA MAYOR
      $dbcm = new Database();
      $sqlcm = "SELECT cod_cuenta FROM cuenta
      WHERE cod_contable = $cod";
      $dbcm->query($sqlcm);
      $dbcm->next_row();
      $cuenta = $dbcm->cod_cuenta;
      
      //INGRESA REGISTROS DEL NIVEL 2
      $valores="('".$m_mov."','".$cuenta."','".'NOTA CREDITO No  '.$num_factura."','".$devolucion."','0','".$cliente."','')";          
      $error=insertar("d_movimientos",$campos,$valores);
      
      //NIVEL 1
      //TOMA EL 1 PRIMER CARACTER DEL CODIGO CONTABLE DE LA CUENTA
      $cod_cuenta = 2524;
      $dbc = new Database();
      $sqlc = "SELECT substring(cod_contable,1,1) as cadena FROM cuenta
      WHERE cod_cuenta = $cod_cuenta";
      $dbc->query($sqlc);
      $dbc->next_row();
      $cod = $dbc->cadena;
      
      //BUSCA EL CODIGO DE LA CUENTA MAYOR
      $dbcm = new Database();
      $sqlcm = "SELECT cod_cuenta FROM cuenta
      WHERE cod_contable = $cod";
      $dbcm->query($sqlcm);
      $dbcm->next_row();
      $cuenta = $dbcm->cod_cuenta;
      
      //INGRESA REGISTROS DEL NIVEL 1
      $valores="('".$m_mov."','".$cuenta."','".'NOTA CREDITO No  '.$num_factura."','".$devolucion."','0','".$cliente."','')";          
      $error=insertar("d_movimientos",$campos,$valores);

      ///LA DEVOLUCION///

      ///EL DESCUENTO///

  if($descuento > 0){
      $descuento = round($descuento / 1.19);
      //REGISTRO EN D_MOVIMIENTO
      $campos="(cod_mov,cuenta_dmov,concepto_dmov,debito_dmov,credito_dmov,cod_ter,centro_dmov)";   
      $valores="('".$m_mov."','2486','".'NOTA CREDITO No '.$num."','0','".$descuento."','".$cliente."','')"; 
      $error=insertar("d_movimientos",$campos,$valores);
      
      //NIVEL 4
      //TOMA LOS 6 PRIMEROS CARACTERES DEL CODIGO CONTABLE DE LA CUENTA
      $cod_cuenta = 2486;
      $dbc = new Database();
      $sqlc = "SELECT substring(cod_contable,1,6) as cadena FROM cuenta
      WHERE cod_cuenta = $cod_cuenta";
      $dbc->query($sqlc);
      $dbc->next_row();
      $cod = $dbc->cadena;
      
      //BUSCA EL CODIGO DE LA CUENTA MAYOR
      $dbcm = new Database();
      $sqlcm = "SELECT cod_cuenta FROM cuenta
      WHERE cod_contable = $cod";
      $dbcm->query($sqlcm);
      $dbcm->next_row();
      $cuenta = $dbcm->cod_cuenta;
      
      //INGRESA REGISTROS DEL NIVEL 4
      $valores="('".$m_mov."','".$cuenta."','".'NOTA CREDITO No  '.$num_factura."','0','".$descuento."','".$cliente."','')";          
      $error=insertar("d_movimientos",$campos,$valores);      
      
      //NIVEL 3
      //TOMA LOS 4 PRIMEROS CARACTERES DEL CODIGO CONTABLE DE LA CUENTA
      $cod_cuenta = 2486;
      $dbc = new Database();
      $sqlc = "SELECT substring(cod_contable,1,4) as cadena FROM cuenta
      WHERE cod_cuenta = $cod_cuenta";
      $dbc->query($sqlc);
      $dbc->next_row();
      $cod = $dbc->cadena;
      
      //BUSCA EL CODIGO DE LA CUENTA MAYOR
      $dbcm = new Database();
      $sqlcm = "SELECT cod_cuenta FROM cuenta
      WHERE cod_contable = $cod";
      $dbcm->query($sqlcm);
      $dbcm->next_row();
      $cuenta = $dbcm->cod_cuenta;
      
      //INGRESA REGISTROS DEL NIVEL 3
      $valores="('".$m_mov."','".$cuenta."','".'NOTA CREDITO No  '.$num_factura."','0','".$descuento."','".$cliente."','')";          
      $error=insertar("d_movimientos",$campos,$valores);
      
      //NIVEL 2
      //TOMA LOS 2 PRIMEROS CARACTERES DEL CODIGO CONTABLE DE LA CUENTA
      $cod_cuenta = 2486;
      $dbc = new Database();
      $sqlc = "SELECT substring(cod_contable,1,2) as cadena FROM cuenta
      WHERE cod_cuenta = $cod_cuenta";
      $dbc->query($sqlc);
      $dbc->next_row();
      $cod = $dbc->cadena;
      
      //BUSCA EL CODIGO DE LA CUENTA MAYOR
      $dbcm = new Database();
      $sqlcm = "SELECT cod_cuenta FROM cuenta
      WHERE cod_contable = $cod";
      $dbcm->query($sqlcm);
      $dbcm->next_row();
      $cuenta = $dbcm->cod_cuenta;
      
      //INGRESA REGISTROS DEL NIVEL 2
      $valores="('".$m_mov."','".$cuenta."','".'NOTA CREDITO No  '.$num_factura."','0','".$descuento."','".$cliente."','')";          
      $error=insertar("d_movimientos",$campos,$valores);
      
      //NIVEL 1
      //TOMA EL 1 PRIMER CARACTER DEL CODIGO CONTABLE DE LA CUENTA
      $cod_cuenta = 2486;
      $dbc = new Database();
      $sqlc = "SELECT substring(cod_contable,1,1) as cadena FROM cuenta
      WHERE cod_cuenta = $cod_cuenta";
      $dbc->query($sqlc);
      $dbc->next_row();
      $cod = $dbc->cadena;
      
      //BUSCA EL CODIGO DE LA CUENTA MAYOR
      $dbcm = new Database();
      $sqlcm = "SELECT cod_cuenta FROM cuenta
      WHERE cod_contable = $cod";
      $dbcm->query($sqlcm);
      $dbcm->next_row();
      $cuenta = $dbcm->cod_cuenta;
      
      //INGRESA REGISTROS DEL NIVEL 1
      $valores="('".$m_mov."','".$cuenta."','".'NOTA CREDITO No  '.$num_factura."','".$descuento."','0','".$cliente."','')";          
      $error=insertar("d_movimientos",$campos,$valores);
  }
      ///EL DESCUENTO///

      ///EL IVA///
      //REGISTRO EN D_MOVIMIENTO
  if($descuento > 0){
    $iva = round(($devolucion * 0.16) - ($descuento * 0.16)); 
  } else {
    $iva = round($_REQUEST['todocompra'] / 1.19 * 0.16);
  }
      $campos="(cod_mov,cuenta_dmov,concepto_dmov,debito_dmov,credito_dmov,cod_ter,centro_dmov)";   
      $valores="('".$m_mov."','2477','".'NOTA CREDITO No '.$num."','".$iva."','0','".$cliente."','')"; 
      $error=insertar("d_movimientos",$campos,$valores);
      
      //NIVEL 4
      //TOMA LOS 6 PRIMEROS CARACTERES DEL CODIGO CONTABLE DE LA CUENTA
      $cod_cuenta = 2477;
      $dbc = new Database();
      $sqlc = "SELECT substring(cod_contable,1,6) as cadena FROM cuenta
      WHERE cod_cuenta = $cod_cuenta";
      $dbc->query($sqlc);
      $dbc->next_row();
      $cod = $dbc->cadena;
      
      //BUSCA EL CODIGO DE LA CUENTA MAYOR
      $dbcm = new Database();
      $sqlcm = "SELECT cod_cuenta FROM cuenta
      WHERE cod_contable = $cod";
      $dbcm->query($sqlcm);
      $dbcm->next_row();
      $cuenta = $dbcm->cod_cuenta;
      
      //INGRESA REGISTROS DEL NIVEL 4
      $valores="('".$m_mov."','".$cuenta."','".'NOTA CREDITO No  '.$num_factura."','".$iva."','0','".$cliente."','')";          
      $error=insertar("d_movimientos",$campos,$valores);
      
      
      //NIVEL 3
      //TOMA LOS 4 PRIMEROS CARACTERES DEL CODIGO CONTABLE DE LA CUENTA
      $cod_cuenta = 2477;
      $dbc = new Database();
      $sqlc = "SELECT substring(cod_contable,1,4) as cadena FROM cuenta
      WHERE cod_cuenta = $cod_cuenta";
      $dbc->query($sqlc);
      $dbc->next_row();
      $cod = $dbc->cadena;
      
      //BUSCA EL CODIGO DE LA CUENTA MAYOR
      $dbcm = new Database();
      $sqlcm = "SELECT cod_cuenta FROM cuenta
      WHERE cod_contable = $cod";
      $dbcm->query($sqlcm);
      $dbcm->next_row();
      $cuenta = $dbcm->cod_cuenta;
      
      //INGRESA REGISTROS DEL NIVEL 3
      $valores="('".$m_mov."','".$cuenta."','".'NOTA CREDITO No  '.$num_factura."','".$iva."','0','".$cliente."','')";          
      $error=insertar("d_movimientos",$campos,$valores);
      
      //NIVEL 2
      //TOMA LOS 2 PRIMEROS CARACTERES DEL CODIGO CONTABLE DE LA CUENTA
      $cod_cuenta = 2477;
      $dbc = new Database();
      $sqlc = "SELECT substring(cod_contable,1,2) as cadena FROM cuenta
      WHERE cod_cuenta = $cod_cuenta";
      $dbc->query($sqlc);
      $dbc->next_row();
      $cod = $dbc->cadena;
      
      //BUSCA EL CODIGO DE LA CUENTA MAYOR
      $dbcm = new Database();
      $sqlcm = "SELECT cod_cuenta FROM cuenta
      WHERE cod_contable = $cod";
      $dbcm->query($sqlcm);
      $dbcm->next_row();
      $cuenta = $dbcm->cod_cuenta;
      
      //INGRESA REGISTROS DEL NIVEL 2
      $valores="('".$m_mov."','".$cuenta."','".'NOTA CREDITO No  '.$num_factura."','".$iva."','0','".$cliente."','')";          
      $error=insertar("d_movimientos",$campos,$valores);
      
      //NIVEL 1
      //TOMA EL 1 PRIMER CARACTER DEL CODIGO CONTABLE DE LA CUENTA
      $cod_cuenta = 2477;
      $dbc = new Database();
      $sqlc = "SELECT substring(cod_contable,1,1) as cadena FROM cuenta
      WHERE cod_cuenta = $cod_cuenta";
      $dbc->query($sqlc);
      $dbc->next_row();
      $cod = $dbc->cadena;
      
      //BUSCA EL CODIGO DE LA CUENTA MAYOR
      $dbcm = new Database();
      $sqlcm = "SELECT cod_cuenta FROM cuenta
      WHERE cod_contable = $cod";
      $dbcm->query($sqlcm);
      $dbcm->next_row();
      $cuenta = $dbcm->cod_cuenta;
      
      //INGRESA REGISTROS DEL NIVEL 1
      $valores="('".$m_mov."','".$cuenta."','".'NOTA CREDITO No  '.$num_factura."','".$iva."','0','".$cliente."','')";          
      $error=insertar("d_movimientos",$campos,$valores);

      ///EL IVA///

      ///ANTICIPO DE CLIENTES///
      //REGISTRO EN D_MOVIMIENTO
  if($descuento > 0){
    $anticipo = $_REQUEST['todocompra'] - $descuento_original;
  } else {
    $anticipo = $_REQUEST['todocompra'];
  }
      $campos="(cod_mov,cuenta_dmov,concepto_dmov,debito_dmov,credito_dmov,cod_ter,centro_dmov)";   
      $valores="('".$m_mov."','2525','".'NOTA CREDITO No '.$num."','0','".$anticipo."','".$cliente."','')"; 
      $error=insertar("d_movimientos",$campos,$valores);
      
      //NIVEL 4
      //TOMA LOS 6 PRIMEROS CARACTERES DEL CODIGO CONTABLE DE LA CUENTA
      $cod_cuenta = 2525;
      $dbc = new Database();
      $sqlc = "SELECT substring(cod_contable,1,6) as cadena FROM cuenta
      WHERE cod_cuenta = $cod_cuenta";
      $dbc->query($sqlc);
      $dbc->next_row();
      $cod = $dbc->cadena;
      
      //BUSCA EL CODIGO DE LA CUENTA MAYOR
      $dbcm = new Database();
      $sqlcm = "SELECT cod_cuenta FROM cuenta
      WHERE cod_contable = $cod";
      $dbcm->query($sqlcm);
      $dbcm->next_row();
      $cuenta = $dbcm->cod_cuenta;
      
      //INGRESA REGISTROS DEL NIVEL 4
      $valores="('".$m_mov."','".$cuenta."','".'NOTA CREDITO No  '.$num_factura."','0','".$anticipo."','".$cliente."','')";          
      $error=insertar("d_movimientos",$campos,$valores);
      
      
      //NIVEL 3
      //TOMA LOS 4 PRIMEROS CARACTERES DEL CODIGO CONTABLE DE LA CUENTA
      $cod_cuenta = 2525;
      $dbc = new Database();
      $sqlc = "SELECT substring(cod_contable,1,4) as cadena FROM cuenta
      WHERE cod_cuenta = $cod_cuenta";
      $dbc->query($sqlc);
      $dbc->next_row();
      $cod = $dbc->cadena;
      
      //BUSCA EL CODIGO DE LA CUENTA MAYOR
      $dbcm = new Database();
      $sqlcm = "SELECT cod_cuenta FROM cuenta
      WHERE cod_contable = $cod";
      $dbcm->query($sqlcm);
      $dbcm->next_row();
      $cuenta = $dbcm->cod_cuenta;
      
      //INGRESA REGISTROS DEL NIVEL 3
      $valores="('".$m_mov."','".$cuenta."','".'NOTA CREDITO No  '.$num_factura."','0','".$anticipo."','".$cliente."','')";          
      $error=insertar("d_movimientos",$campos,$valores);
      
      //NIVEL 2
      //TOMA LOS 2 PRIMEROS CARACTERES DEL CODIGO CONTABLE DE LA CUENTA
      $cod_cuenta = 2525;
      $dbc = new Database();
      $sqlc = "SELECT substring(cod_contable,1,2) as cadena FROM cuenta
      WHERE cod_cuenta = $cod_cuenta";
      $dbc->query($sqlc);
      $dbc->next_row();
      $cod = $dbc->cadena;
      
      //BUSCA EL CODIGO DE LA CUENTA MAYOR
      $dbcm = new Database();
      $sqlcm = "SELECT cod_cuenta FROM cuenta
      WHERE cod_contable = $cod";
      $dbcm->query($sqlcm);
      $dbcm->next_row();
      $cuenta = $dbcm->cod_cuenta;
      
      //INGRESA REGISTROS DEL NIVEL 2
      $valores="('".$m_mov."','".$cuenta."','".'NOTA CREDITO No  '.$num_factura."','0','".$anticipo."','".$cliente."','')";          
      $error=insertar("d_movimientos",$campos,$valores);
      
      //NIVEL 1
      //TOMA EL 1 PRIMER CARACTER DEL CODIGO CONTABLE DE LA CUENTA
      $cod_cuenta = 2525;
      $dbc = new Database();
      $sqlc = "SELECT substring(cod_contable,1,1) as cadena FROM cuenta
      WHERE cod_cuenta = $cod_cuenta";
      $dbc->query($sqlc);
      $dbc->next_row();
      $cod = $dbc->cadena;
      
      //BUSCA EL CODIGO DE LA CUENTA MAYOR
      $dbcm = new Database();
      $sqlcm = "SELECT cod_cuenta FROM cuenta
      WHERE cod_contable = $cod";
      $dbcm->query($sqlcm);
      $dbcm->next_row();
      $cuenta = $dbcm->cod_cuenta;
      
      //INGRESA REGISTROS DEL NIVEL 1
      $valores="('".$m_mov."','".$cuenta."','".'NOTA CREDITO No  '.$num_factura."','0','".$anticipo."','".$cliente."','')";          
      $error=insertar("d_movimientos",$campos,$valores);

      ///ANTICIPO DE CLIENTE///

      ///AUTORETENCION CREE 0,4% CREDITO///
  if($descuento > 0){
    $cree = round(($devolucion - $descuento) * 0.4 / 100);
  } else {
    $cree = round($devolucion * 0.4 / 100);
  }
      //REGISTRO EN D_MOVIMIENTO
      $campos="(cod_mov,cuenta_dmov,concepto_dmov,debito_dmov,credito_dmov,cod_ter,centro_dmov)";   
      $valores="('".$m_mov."','2479','".'NOTA CREDITO No '.$num."','0','".$cree."','".$cliente."','')"; 
      $error=insertar("d_movimientos",$campos,$valores);
      
      //NIVEL 4
      //TOMA LOS 6 PRIMEROS CARACTERES DEL CODIGO CONTABLE DE LA CUENTA
      $cod_cuenta = 2479;
      $dbc = new Database();
      $sqlc = "SELECT substring(cod_contable,1,6) as cadena FROM cuenta
      WHERE cod_cuenta = $cod_cuenta";
      $dbc->query($sqlc);
      $dbc->next_row();
      $cod = $dbc->cadena;
      
      //BUSCA EL CODIGO DE LA CUENTA MAYOR
      $dbcm = new Database();
      $sqlcm = "SELECT cod_cuenta FROM cuenta
      WHERE cod_contable = $cod";
      $dbcm->query($sqlcm);
      $dbcm->next_row();
      $cuenta = $dbcm->cod_cuenta;
      
      //INGRESA REGISTROS DEL NIVEL 4
      $valores="('".$m_mov."','".$cuenta."','".'NOTA CREDITO No  '.$num_factura."','0','".$cree."','".$cliente."','')";          
      $error=insertar("d_movimientos",$campos,$valores);
      
      
      //NIVEL 3
      //TOMA LOS 4 PRIMEROS CARACTERES DEL CODIGO CONTABLE DE LA CUENTA
      $cod_cuenta = 2479;
      $dbc = new Database();
      $sqlc = "SELECT substring(cod_contable,1,4) as cadena FROM cuenta
      WHERE cod_cuenta = $cod_cuenta";
      $dbc->query($sqlc);
      $dbc->next_row();
      $cod = $dbc->cadena;
      
      //BUSCA EL CODIGO DE LA CUENTA MAYOR
      $dbcm = new Database();
      $sqlcm = "SELECT cod_cuenta FROM cuenta
      WHERE cod_contable = $cod";
      $dbcm->query($sqlcm);
      $dbcm->next_row();
      $cuenta = $dbcm->cod_cuenta;
      
      //INGRESA REGISTROS DEL NIVEL 3
      $valores="('".$m_mov."','".$cuenta."','".'NOTA CREDITO No  '.$num_factura."','0','".$cree."','".$cliente."','')";          
      $error=insertar("d_movimientos",$campos,$valores);
      
      //NIVEL 2
      //TOMA LOS 2 PRIMEROS CARACTERES DEL CODIGO CONTABLE DE LA CUENTA
      $cod_cuenta = 2479;
      $dbc = new Database();
      $sqlc = "SELECT substring(cod_contable,1,2) as cadena FROM cuenta
      WHERE cod_cuenta = $cod_cuenta";
      $dbc->query($sqlc);
      $dbc->next_row();
      $cod = $dbc->cadena;
      
      //BUSCA EL CODIGO DE LA CUENTA MAYOR
      $dbcm = new Database();
      $sqlcm = "SELECT cod_cuenta FROM cuenta
      WHERE cod_contable = $cod";
      $dbcm->query($sqlcm);
      $dbcm->next_row();
      $cuenta = $dbcm->cod_cuenta;
      
      //INGRESA REGISTROS DEL NIVEL 2
      $valores="('".$m_mov."','".$cuenta."','".'NOTA CREDITO No  '.$num_factura."','0','".$cree."','".$cliente."','')";          
      $error=insertar("d_movimientos",$campos,$valores);
      
      //NIVEL 1
      //TOMA EL 1 PRIMER CARACTER DEL CODIGO CONTABLE DE LA CUENTA
      $cod_cuenta = 2479;
      $dbc = new Database();
      $sqlc = "SELECT substring(cod_contable,1,1) as cadena FROM cuenta
      WHERE cod_cuenta = $cod_cuenta";
      $dbc->query($sqlc);
      $dbc->next_row();
      $cod = $dbc->cadena;
      
      //BUSCA EL CODIGO DE LA CUENTA MAYOR
      $dbcm = new Database();
      $sqlcm = "SELECT cod_cuenta FROM cuenta
      WHERE cod_contable = $cod";
      $dbcm->query($sqlcm);
      $dbcm->next_row();
      $cuenta = $dbcm->cod_cuenta;
      
      //INGRESA REGISTROS DEL NIVEL 1
      $valores="('".$m_mov."','".$cuenta."','".'NOTA CREDITO No  '.$num_factura."','0','".$cree."','".$cliente."','')";          
      $error=insertar("d_movimientos",$campos,$valores);

      ///AUTORETENCION CREE 0,4% CREDITO///

      ///AUTORETENCION CREE 0,4% DEBITO///
      //REGISTRO EN D_MOVIMIENTO
      $campos="(cod_mov,cuenta_dmov,concepto_dmov,debito_dmov,credito_dmov,cod_ter,centro_dmov)";   
      $valores="('".$m_mov."','2481','".'NOTA CREDITO No '.$num."','".$cree."','0','".$cliente."','')"; 
      $error=insertar("d_movimientos",$campos,$valores);
      
      //NIVEL 4
      //TOMA LOS 6 PRIMEROS CARACTERES DEL CODIGO CONTABLE DE LA CUENTA
      $cod_cuenta = 2481;
      $dbc = new Database();
      $sqlc = "SELECT substring(cod_contable,1,6) as cadena FROM cuenta
      WHERE cod_cuenta = $cod_cuenta";
      $dbc->query($sqlc);
      $dbc->next_row();
      $cod = $dbc->cadena;
      
      //BUSCA EL CODIGO DE LA CUENTA MAYOR
      $dbcm = new Database();
      $sqlcm = "SELECT cod_cuenta FROM cuenta
      WHERE cod_contable = $cod";
      $dbcm->query($sqlcm);
      $dbcm->next_row();
      $cuenta = $dbcm->cod_cuenta;
      
      //INGRESA REGISTROS DEL NIVEL 4
      $valores="('".$m_mov."','".$cuenta."','".'NOTA CREDITO No  '.$num_factura."','".$cree."','0','".$cliente."','')";          
      $error=insertar("d_movimientos",$campos,$valores);
      
      
      //NIVEL 3
      //TOMA LOS 4 PRIMEROS CARACTERES DEL CODIGO CONTABLE DE LA CUENTA
      $cod_cuenta = 2481;
      $dbc = new Database();
      $sqlc = "SELECT substring(cod_contable,1,4) as cadena FROM cuenta
      WHERE cod_cuenta = $cod_cuenta";
      $dbc->query($sqlc);
      $dbc->next_row();
      $cod = $dbc->cadena;
      
      //BUSCA EL CODIGO DE LA CUENTA MAYOR
      $dbcm = new Database();
      $sqlcm = "SELECT cod_cuenta FROM cuenta
      WHERE cod_contable = $cod";
      $dbcm->query($sqlcm);
      $dbcm->next_row();
      $cuenta = $dbcm->cod_cuenta;
      
      //INGRESA REGISTROS DEL NIVEL 3
      $valores="('".$m_mov."','".$cuenta."','".'NOTA CREDITO No  '.$num_factura."','".$cree."','0','".$cliente."','')";          
      $error=insertar("d_movimientos",$campos,$valores);
      
      //NIVEL 2
      //TOMA LOS 2 PRIMEROS CARACTERES DEL CODIGO CONTABLE DE LA CUENTA
      $cod_cuenta = 2481;
      $dbc = new Database();
      $sqlc = "SELECT substring(cod_contable,1,2) as cadena FROM cuenta
      WHERE cod_cuenta = $cod_cuenta";
      $dbc->query($sqlc);
      $dbc->next_row();
      $cod = $dbc->cadena;
      
      //BUSCA EL CODIGO DE LA CUENTA MAYOR
      $dbcm = new Database();
      $sqlcm = "SELECT cod_cuenta FROM cuenta
      WHERE cod_contable = $cod";
      $dbcm->query($sqlcm);
      $dbcm->next_row();
      $cuenta = $dbcm->cod_cuenta;
      
      //INGRESA REGISTROS DEL NIVEL 2
      $valores="('".$m_mov."','".$cuenta."','".'NOTA CREDITO No  '.$num_factura."','".$cree."','0','".$cliente."','')";          
      $error=insertar("d_movimientos",$campos,$valores);
      
      //NIVEL 1
      //TOMA EL 1 PRIMER CARACTER DEL CODIGO CONTABLE DE LA CUENTA
      $cod_cuenta = 2481;
      $dbc = new Database();
      $sqlc = "SELECT substring(cod_contable,1,1) as cadena FROM cuenta
      WHERE cod_cuenta = $cod_cuenta";
      $dbc->query($sqlc);
      $dbc->next_row();
      $cod = $dbc->cadena;
      
      //BUSCA EL CODIGO DE LA CUENTA MAYOR
      $dbcm = new Database();
      $sqlcm = "SELECT cod_cuenta FROM cuenta
      WHERE cod_contable = $cod";
      $dbcm->query($sqlcm);
      $dbcm->next_row();
      $cuenta = $dbcm->cod_cuenta;
      
      //INGRESA REGISTROS DEL NIVEL 1
      $valores="('".$m_mov."','".$cuenta."','".'NOTA CREDITO No  '.$num_factura."','".$cree."','0','".$cliente."','')";          
      $error=insertar("d_movimientos",$campos,$valores);

      ///AUTORETENCION CREE 0,4% DEBITO///

      ///INVENTARIO///
      //REGISTRO EN D_MOVIMIENTO
      $campos="(cod_mov,cuenta_dmov,concepto_dmov,debito_dmov,credito_dmov,cod_ter,centro_dmov)";   
      $valores="('".$m_mov."','2483','".'NOTA CREDITO No '.$num."','".$costo."','0','".$cliente."','')"; 
      $error=insertar("d_movimientos",$campos,$valores);
      
      //NIVEL 4
      //TOMA LOS 6 PRIMEROS CARACTERES DEL CODIGO CONTABLE DE LA CUENTA
      $cod_cuenta = 2483;
      $dbc = new Database();
      $sqlc = "SELECT substring(cod_contable,1,6) as cadena FROM cuenta
      WHERE cod_cuenta = $cod_cuenta";
      $dbc->query($sqlc);
      $dbc->next_row();
      $cod = $dbc->cadena;
      
      //BUSCA EL CODIGO DE LA CUENTA MAYOR
      $dbcm = new Database();
      $sqlcm = "SELECT cod_cuenta FROM cuenta
      WHERE cod_contable = $cod";
      $dbcm->query($sqlcm);
      $dbcm->next_row();
      $cuenta = $dbcm->cod_cuenta;
      
      //INGRESA REGISTROS DEL NIVEL 4
      $valores="('".$m_mov."','".$cuenta."','".'NOTA CREDITO No  '.$num_factura."','".$costo."','0','".$cliente."','')";          
      $error=insertar("d_movimientos",$campos,$valores);
      
      
      //NIVEL 3
      //TOMA LOS 4 PRIMEROS CARACTERES DEL CODIGO CONTABLE DE LA CUENTA
      $cod_cuenta = 2483;
      $dbc = new Database();
      $sqlc = "SELECT substring(cod_contable,1,4) as cadena FROM cuenta
      WHERE cod_cuenta = $cod_cuenta";
      $dbc->query($sqlc);
      $dbc->next_row();
      $cod = $dbc->cadena;
      
      //BUSCA EL CODIGO DE LA CUENTA MAYOR
      $dbcm = new Database();
      $sqlcm = "SELECT cod_cuenta FROM cuenta
      WHERE cod_contable = $cod";
      $dbcm->query($sqlcm);
      $dbcm->next_row();
      $cuenta = $dbcm->cod_cuenta;
      
      //INGRESA REGISTROS DEL NIVEL 3
      $valores="('".$m_mov."','".$cuenta."','".'NOTA CREDITO No  '.$num_factura."','".$costo."','0','".$cliente."','')";          
      $error=insertar("d_movimientos",$campos,$valores);
      
      //NIVEL 2
      //TOMA LOS 2 PRIMEROS CARACTERES DEL CODIGO CONTABLE DE LA CUENTA
      $cod_cuenta = 2483;
      $dbc = new Database();
      $sqlc = "SELECT substring(cod_contable,1,2) as cadena FROM cuenta
      WHERE cod_cuenta = $cod_cuenta";
      $dbc->query($sqlc);
      $dbc->next_row();
      $cod = $dbc->cadena;
      
      //BUSCA EL CODIGO DE LA CUENTA MAYOR
      $dbcm = new Database();
      $sqlcm = "SELECT cod_cuenta FROM cuenta
      WHERE cod_contable = $cod";
      $dbcm->query($sqlcm);
      $dbcm->next_row();
      $cuenta = $dbcm->cod_cuenta;
      
      //INGRESA REGISTROS DEL NIVEL 2
      $valores="('".$m_mov."','".$cuenta."','".'NOTA CREDITO No  '.$num_factura."','".$costo."','0','".$cliente."','')";          
      $error=insertar("d_movimientos",$campos,$valores);
      
      //NIVEL 1
      //TOMA EL 1 PRIMER CARACTER DEL CODIGO CONTABLE DE LA CUENTA
      $cod_cuenta = 2483;
      $dbc = new Database();
      $sqlc = "SELECT substring(cod_contable,1,1) as cadena FROM cuenta
      WHERE cod_cuenta = $cod_cuenta";
      $dbc->query($sqlc);
      $dbc->next_row();
      $cod = $dbc->cadena;
      
      //BUSCA EL CODIGO DE LA CUENTA MAYOR
      $dbcm = new Database();
      $sqlcm = "SELECT cod_cuenta FROM cuenta
      WHERE cod_contable = $cod";
      $dbcm->query($sqlcm);
      $dbcm->next_row();
      $cuenta = $dbcm->cod_cuenta;
      
      //INGRESA REGISTROS DEL NIVEL 1
      $valores="('".$m_mov."','".$cuenta."','".'NOTA CREDITO No  '.$num_factura."','".$costo."','0','".$cliente."','')";          
      $error=insertar("d_movimientos",$campos,$valores);

      ///INVENTARIO///

      ///COSTO///
      //REGISTRO EN D_MOVIMIENTO
      $campos="(cod_mov,cuenta_dmov,concepto_dmov,debito_dmov,credito_dmov,cod_ter,centro_dmov)";   
      $valores="('".$m_mov."','2484','".'NOTA CREDITO No '.$num."','0','".$costo."','".$cliente."','')"; 
      $error=insertar("d_movimientos",$campos,$valores);
      
      //NIVEL 4
      //TOMA LOS 6 PRIMEROS CARACTERES DEL CODIGO CONTABLE DE LA CUENTA
      $cod_cuenta = 2484;
      $dbc = new Database();
      $sqlc = "SELECT substring(cod_contable,1,6) as cadena FROM cuenta
      WHERE cod_cuenta = $cod_cuenta";
      $dbc->query($sqlc);
      $dbc->next_row();
      $cod = $dbc->cadena;
      
      //BUSCA EL CODIGO DE LA CUENTA MAYOR
      $dbcm = new Database();
      $sqlcm = "SELECT cod_cuenta FROM cuenta
      WHERE cod_contable = $cod";
      $dbcm->query($sqlcm);
      $dbcm->next_row();
      $cuenta = $dbcm->cod_cuenta;
      
      //INGRESA REGISTROS DEL NIVEL 4
      $valores="('".$m_mov."','".$cuenta."','".'NOTA CREDITO No  '.$num_factura."','0','".$costo."','".$cliente."','')";          
      $error=insertar("d_movimientos",$campos,$valores);
      
      
      //NIVEL 3
      //TOMA LOS 4 PRIMEROS CARACTERES DEL CODIGO CONTABLE DE LA CUENTA
      $cod_cuenta = 2484;
      $dbc = new Database();
      $sqlc = "SELECT substring(cod_contable,1,4) as cadena FROM cuenta
      WHERE cod_cuenta = $cod_cuenta";
      $dbc->query($sqlc);
      $dbc->next_row();
      $cod = $dbc->cadena;
      
      //BUSCA EL CODIGO DE LA CUENTA MAYOR
      $dbcm = new Database();
      $sqlcm = "SELECT cod_cuenta FROM cuenta
      WHERE cod_contable = $cod";
      $dbcm->query($sqlcm);
      $dbcm->next_row();
      $cuenta = $dbcm->cod_cuenta;
      
      //INGRESA REGISTROS DEL NIVEL 3
      $valores="('".$m_mov."','".$cuenta."','".'NOTA CREDITO No  '.$num_factura."','0','".$costo."','".$cliente."','')";          
      $error=insertar("d_movimientos",$campos,$valores);
      
      //NIVEL 2
      //TOMA LOS 2 PRIMEROS CARACTERES DEL CODIGO CONTABLE DE LA CUENTA
      $cod_cuenta = 2484;
      $dbc = new Database();
      $sqlc = "SELECT substring(cod_contable,1,2) as cadena FROM cuenta
      WHERE cod_cuenta = $cod_cuenta";
      $dbc->query($sqlc);
      $dbc->next_row();
      $cod = $dbc->cadena;
      
      //BUSCA EL CODIGO DE LA CUENTA MAYOR
      $dbcm = new Database();
      $sqlcm = "SELECT cod_cuenta FROM cuenta
      WHERE cod_contable = $cod";
      $dbcm->query($sqlcm);
      $dbcm->next_row();
      $cuenta = $dbcm->cod_cuenta;
      
      //INGRESA REGISTROS DEL NIVEL 2
      $valores="('".$m_mov."','".$cuenta."','".'NOTA CREDITO No  '.$num_factura."','0','".$costo."','".$cliente."','')";          
      $error=insertar("d_movimientos",$campos,$valores);
      
      //NIVEL 1
      //TOMA EL 1 PRIMER CARACTER DEL CODIGO CONTABLE DE LA CUENTA
      $cod_cuenta = 2484;
      $dbc = new Database();
      $sqlc = "SELECT substring(cod_contable,1,1) as cadena FROM cuenta
      WHERE cod_cuenta = $cod_cuenta";
      $dbc->query($sqlc);
      $dbc->next_row();
      $cod = $dbc->cadena;
      
      //BUSCA EL CODIGO DE LA CUENTA MAYOR
      $dbcm = new Database();
      $sqlcm = "SELECT cod_cuenta FROM cuenta
      WHERE cod_contable = $cod";
      $dbcm->query($sqlcm);
      $dbcm->next_row();
      $cuenta = $dbcm->cod_cuenta;
      
      //INGRESA REGISTROS DEL NIVEL 1
      $valores="('".$m_mov."','".$cuenta."','".'NOTA CREDITO No  '.$num_factura."','0','".$costo."','".$cliente."','')";          
      $error=insertar("d_movimientos",$campos,$valores);

      ///INVENTARIO///

////REGISTRO CONTABLE DE FACTURA////

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
function datos_completos(){   
    return true;
}

//LISTA LOS PRODUCTO DE UNA FACTURA
function listar_productos(){
  Agregar_html_factura();
}

function factura(){
var num = 0;

  <?php 
  //CONSULTA LOS PRODUCTOS DE LA FACTURA
  $db = new database();
  $sql = " select * from d_factura 
  left join m_factura on m_factura.cod_fac = d_factura.cod_mfac
  left join tipo_producto on d_factura.cod_tpro=tipo_producto.cod_tpro
  left join marca on d_factura.cod_cat=marca.cod_mar
  left join producto  on d_factura.cod_pro= producto.cod_pro 
  WHERE cod_cli = $cliente";
  $db->query($sql);
  while($db->next_row()){
        echo "if(document.getElementById('factura').value==$db->cod_fac) {";
        echo "marca = '$db->nom_mar';";
        echo "tipo_producto = '$db->nom_tpro';";
        echo "referencia = '$db->nom_pro';";
        echo "cod_referencia = $db->cod_pro;";
        echo "cod_fry_pro = $db->cod_fry_pro;";
        echo "valor = $db->val_uni;";
        echo "cantidad = $db->cant_pro;";
        echo "descuento = $db->desc_pro;";
        echo "valor_tot = $db->total_pro;";

  //CALCULA EL PROMEDIO DEL COSTO
  $dbpc = new database();
  $sqlpc = " select * from d_entrada
  WHERE cod_ref_dent = $db->cod_pro";
  $dbpc->query($sqlpc);
  while($dbpc->next_row()){
    $cantidad = $cantidad + $dbpc->cant_dent;
    $costo_uni = $costo_uni + $dbpc->cos_dent;
  }

  $costo_ref =  round($costo_uni / $cantidad);

        echo "costo_ref = $costo_ref;";
  ?>

  var lastRow = document.getElementById('fila_' + num);
  if(lastRow){
    num = parseInt(num) + 1;
    var newRow = document.createElement('tr');
    newRow.id = 'fila_' + num;        

    //CATEGORIA
    var td = document.createElement('td');
    td.innerHTML  = "<INPUT type=\"hidden\"  name=\"codigo_marca_" + num + "\" value=\"" + marca + "\" >  <span  class=\"textfield01\">" + marca +  "</span> "; 
    newRow.appendChild(td);
      
    //TIPO DE PRODUCTO
    var td = document.createElement('td');
    td.innerHTML  = "<INPUT type=\"hidden\"  name=\"codigo_tipo_prodcuto_" + num + "\" value=\"" + tipo_producto + "\" >  <span  class=\"textfield01\">" + tipo_producto +  "</span> ";  
    newRow.appendChild(td);

    //REFERENCIA
    var td = document.createElement('td');
    td.innerHTML  = "<INPUT type=\"hidden\"  name=\"codigo_referencia_" + num + "\" value=\"" + cod_referencia + "\" > <INPUT type=\"hidden\"  name=\"referencia_" + num + "\" value=\"" + referencia + "\" > <span  class=\"textfield01\">" + referencia +  "</span> "; 
    newRow.appendChild(td);
    
    //CODIGO
    var td = document.createElement('td');
    td.innerHTML  = "<INPUT type=\"hidden\"  name=\"codigo_fry_" + num + "\" value=\"" + cod_fry_pro + "\" >  <span  class=\"textfield01\">" + cod_fry_pro +  "</span> "; 
    newRow.appendChild(td);

    //VALOR
    var td = document.createElement('td');
    td.innerHTML  = "<INPUT type=\"hidden\"  id=\"valor_ref_" + num + "\"  name=\"valor_ref_" + num + "\" value=\"" + valor + "\" >  <span  class=\"textfield01\"><div align=\"right\">" + valor +  "</div></span> ";  
    newRow.appendChild(td);
  
    //CANTIDAD
    var td = document.createElement('td');
    td.innerHTML  = "<INPUT type=\"hidden\" id=\"cantidad_ref_" + num + "\"  name=\"cantidad_ref_" + num + "\" value=\"" + cantidad + "\" >  <span  class=\"textfield01\"><div align=\"right\">" + cantidad +  "</div></span> ";  
    newRow.appendChild(td);

    //DESCUENTO
    var td = document.createElement('td');
    td.innerHTML  = "<INPUT type=\"hidden\" id=\"descuento_" + num + "\" name=\"descuento_" + num + "\" value=\"" + descuento + "\" >  <span  class=\"textfield01\"><div align=\"right\">" + descuento +  "</div></span> "; 
    newRow.appendChild(td);
    
    //valor referencias
    var td = document.createElement('td');
    td.innerHTML  = "<INPUT type=\"hidden\"  id=\"costo_uni_" + num + "\"  name=\"costo_uni_" + num + "\" value=\"" + costo_ref + "\" ><INPUT type=\"hidden\" id=\"val_tot_" + num + "\" name=\"val_tot_" + num + "\" value=\"" + valor_tot + "\" ><span  class=\"textfield01\"><div align=\"right\">" + valor_tot +  "</div></span> ";  
    newRow.appendChild(td);
    
    //CANTIDAD CAMBIO
    var td = document.createElement('td');
    td.innerHTML  = "<span  class=\"textfield01\"><INPUT type=\"text\"  id=\"cant_cambio_" + num + "\" name=\"cant_cambio_" + num + "\"></span> ";  
    newRow.appendChild(td);

    //VALOR CAMBIO
    var td = document.createElement('td');
    td.innerHTML  = "<span  class=\"textfield01\"><INPUT type=\"text\" id=\"val_cambio_" + num + "\" name=\"val_cambio_" + num + "\" readonly='1'></span> ";  
    newRow.appendChild(td);
    
    var td = document.createElement('td');
    td.innerHTML = "<div align=\"center\"><INPUT type=\"button\" class=\"botones\" value=\"  CALCULA  \" onclick=\"calcula_cambio('" + num +"');\"></div>";
    newRow.appendChild(td);
    
    lastRow.parentNode.insertBefore(newRow, lastRow.nextSibling);
    
  }
  <?phP
    echo " } ";
  } 
  ?>

  document.getElementById('val_inicial').value = num;
}

function Agregar_html_factura(){ 
  //VALIDA QUE NO HALLA FACTURA LISTADA SI LA HAY BORRA
  if(document.getElementById('val_inicial').value != 0){
    var cant = parseInt(document.getElementById('val_inicial').value);

    for(i=1; i <= cant; i++){
      //REMUEVE EL NODO
      var fila = document.getElementById('fila_'+i);
      fila.parentNode.removeChild(fila);
    }

    document.getElementById('val_inicial').value = 0;
    
    factura();
  }   else {
    factura();
  }
}

function calcula_cambio(val){
  cambio = 0;
  var cant_fac = document.getElementById('cantidad_ref_' + val).value;
  var cant = document.getElementById('cant_cambio_' + val).value;
  var valor = document.getElementById('valor_ref_' + val).value;
  var cambio = parseInt(cant) * parseInt(valor);

  if(parseInt(cant) > parseInt(cant_fac)){
    alert('La cantidad a cambiar debe ser igual o menor al de la factura');
  } else {
    document.getElementById('val_cambio_' + val).value = cambio;
    document.getElementById('todocompra').value = parseInt(document.getElementById('todocompra').value) + cambio;
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
<form  name="forma" id="forma" action="man_bono_cambio.php"  method="post">
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
    BONO DE CAMBIO  Nro. <?php echo $num_bono?></td>
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
        <td class="textotabla1">Facturas:</td>
        <td><?php combo_evento_where("factura","m_factura","cod_fac","num_fac","",""," WHERE estado is null AND cod_cli = $cliente")?></td>
        <td class="subtitulosproductos"><input name="button" type="button"  class="botones" id="imp" onClick="listar_productos()" value="LISTAR"></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textotabla1">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan='7'>&nbsp;</td>
      </tr>
      <table  width="100%" border="1">  
        <tr>
          <td class="ctablasup">Categoria</td>
          <td class="ctablasup">Tipo Producto </td>
          <td class="ctablasup">Referencia</td>
          <td class="ctablasup">Codigo</td>
          <td class="ctablasup">Valor</td>
          <td class="ctablasup">Cantidad</td>
          <td class="ctablasup">Descuento</td>
          <td class="ctablasup">Total registro</td>
          <td class="ctablasup">Cantidad cambio</td>
          <td class="ctablasup">Valor cambio</td>
        </tr>
        <tr id="fila_0">
        </tr>
      </table>
     <tr>
        <td colspan="16" class="textotabla1" >
    <table  width="100%" border="1">                        
     <tr >
      <td  colspan="11">
        <table width="100%">
        <tr >
        <td  class="ctablasup"><div align="left">Observaciones:</div></td>
        <td  class="ctablasup"><div align="right">Resumen cambio </div></td>
        </tr>
        <tr >
        <td width="47%" ><div align="left" >
          <textarea name="observaciones" cols="45" rows="3" class="textfield02"  onchange='buscar_rutas()' ><?php echo $dbdatos->obs_tras?></textarea>
          <?php 
$time_end = microtime_float(); 
$time = number_format($time_end - $time_start, 5); 

echo "$time";
echo $tipo; 
?>
        </div>          </td>
        <td width="53%" ><div align="right"><span class="ctablasup">Total  cambio:</span>
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
  <input type="hidden" name="guardar" id="guardar" />
     <?php  if ($codigo!="") $valueInicial = $aa; else $valueInicial = "1";?>
    <input type="hidden" id="tipo" name='tipo' value="<?php echo $tipo?>"> 
     <input type="hidden" id="valDoc_inicial" value="<?php echo $valueInicial?>"> 
     <input type="hidden" name="cant_items" id="cant_items" value=" <?php  if ($codigo!="") echo $aa; else echo "0"; ?>">
  </td>
  </tr>
</table>
</form> 
</div>
</body>
</html>