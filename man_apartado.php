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
$tipo = $_REQUEST['tipo'];

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

if($guardar==1 and $codigo==0) 
	{ // RUTINA PARA  INSERTAR REGISTROS NUEVOS	

		$db6 = new Database();
		$sql = "select num_apa_rso + 1  as  num_factura from rsocial WHERE cod_rso=$empresa ";
		$db6->query($sql);

		if($db6->next_row())
		$num_factura = $db6->num_factura;
		
	//ACTUALIZA LA ULTIMA FACTURA
		$db_a = new Database();
		$sql_a = "UPDATE rsocial SET num_apa_rso = $num_factura  WHERE  cod_rso=$empresa";
		$db_a->query($sql_a);		
		
	$tipo_pago="Contado";

	//VALIDA BONO
	if($_REQUEST['bono_tot'] > 0){
		$bono = $_REQUEST['bono'];
	} else {
		$bono = 0;
	}

	//HORA ACTIUAL
	$horas = date('H');
	$minutos = date('i');
 	$segundos = date('s');

 	$fecha_comp = $_REQUEST['fecha_fac'].' '.$horas.':'.$minutos.':'.$segundos;

 	//SUMA EL TOTAL DE ABONOS
 	$total_apa = 0;
 	for($i = 1; $i <= 9; $i++){
 		$total_apa = $total_apa + $_REQUEST['pago_'.$i];
 	}

	$compos="(cod_usu,cod_ven,cod_cli,fecha,num_apa,cod_razon_apa,tipo_pago,obs,tot_apa,cod_bod,tipo_apa)";
	$valores="('".$_REQUEST['usuario']."','".$_REQUEST['vendedor']."','".$_REQUEST['cliente_fac']."',
		'".$fecha_comp."','".$num_factura."','".$_REQUEST['empresa']."','".$tipo_pago."',
		'".$_REQUEST['observaciones']."','".$total_apa."','".$_REQUEST['bodega_fac']."','".$_REQUEST['tipo']."')" ;
	
	$ins_id=insertar_maestro("m_apartado",$compos,$valores); 
	
	
// copia espejo

    $cliente_facs=$cliente_fac;  	
	
	$sql ="SELECT * from cliente where cod_cli=$cliente_facs";
	$dbdatos_cli= new  Database();
	$dbdatos_cli->query($sql);
	$dbdatos_cli->next_row();
	$lista=$dbdatos_cli->lista_cli;  
 
		
	if($tipo_pago != 'Contado' ) 
	{
		$sql = "INSERT INTO cartera_factura ( fec_car_fac, cod_fac) VALUES( '".$_REQUEST['fecha_fac']."', '".$ins_id."');";
		$db2->query($sql);	
	}
		
		//INSERCION DE LOS OTROS PAGOS
		for ($i=1; $i<=9; $i++){
			if(($i != 1)and($i != 2)){
				$valor_otro = $_REQUEST["pago_".$i];

				if($valor_otro > 0){
					$compos="(cod_usu_otro,fec_otro,cod_cli_otro,obs_otro,val_otro,cod_tpag_otro,cod_tarjeta,num_auto,cod_apa)";
					$valores="('".$usuario."','".$fecha_fac."','".$cliente_fac."','".$obs."','".$valor_otro."','".$i."','".$i."','".$_REQUEST['autorizacion_'.$i]."','".$ins_id."')" ;

					$error=insertar("otros_pagos",$compos,$valores); 
				}
			}
		}
	
	
	
	if ($ins_id > 0) 
	{
		//insercion del credito
		$compos="(cod_mapa,cod_tpro,cod_cat, cod_pro, cod_talla,cod_color, cant_pro, desc_pro,val_uni,total_pro) ";
		for ($ii=1 ;  $ii <= $_REQUEST['val_inicial'] + 1 ; $ii++){
			if($_REQUEST["codigo_referencia_".$ii]!=NULL){
						
				$val_uni=$_REQUEST["costo_ref_".$ii] / $_REQUEST["cantidad_ref_".$ii];				
				$valores="('".$ins_id."','".$_REQUEST["codigo_tipo_prodcuto_".$ii]."','".$_REQUEST["codigo_marca_".$ii]."',
				'".$_REQUEST["codigo_referencia_".$ii]."','".$_REQUEST["codigo_talla_".$ii]."','".$_REQUEST["codigo_color_".$ii]."','".$_REQUEST["cantidad_ref_".$ii]."','".$_REQUEST["descuento_".$ii]."',
				'".$_REQUEST["costo_ref_uni_".$ii]."','".$_REQUEST["costo_ref_total_".$ii]."')";
			
				$error=insertar("d_apartado",$compos,$valores);
			
				if($_REQUEST["costo_ref_total_".$ii] < 0){
					kardex("suma",$_REQUEST["codigo_referencia_".$ii],$bodega_fac,$_REQUEST["cantidad_ref_".$ii],$_REQUEST["costo_ref_".$ii],$_REQUEST["codigo_talla_".$ii],$_REQUEST["codigo_color_".$ii]);
				} else {
					kardex("resta",$_REQUEST["codigo_referencia_".$ii],$bodega_fac,$_REQUEST["cantidad_ref_".$ii],$_REQUEST["costo_ref_".$ii],$_REQUEST["codigo_talla_".$ii],$_REQUEST["codigo_color_".$ii]);
				}
			}	
		}

/*////REGISTRO CONTABLE DE FACTURA////
	$sql ="SELECT * FROM tipo_movimientos WHERE cod_tmov= 2";
	$dbda= new  Database();
	$dbda->query($sql);
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
	$valores="('".$consecutivo."','".$num_factura."','".$fecha_comp."','".$fecha_comp."','2','','')" ;
	$m_mov=insertar_maestro("m_movimientos",$campos,$valores); 
	//

	//MODIFICACION DEL CONSECUTIVO DEL MOVIMIENTO	
	$campos="num_cons='".$num."'";
	$error=editar("tipo_movimientos",$campos,'cod_tmov',2); 

			
			///EL INGRESO///
			//REGISTRO EN D_MOVIMIENTO
			$campos="(cod_mov,cuenta_dmov,concepto_dmov,debito_dmov,credito_dmov,cod_ter,centro_dmov)";		
			$valores="('".$m_mov."','2475','".'FACTURA DE VENTA No '.$num_factura."','0','".$_REQUEST["subtotal"]."','".$cliente_fac."','')";	
			$error=insertar("d_movimientos",$campos,$valores);
			
			//NIVEL 4
			//TOMA LOS 6 PRIMEROS CARACTERES DEL CODIGO CONTABLE DE LA CUENTA
			$cod_cuenta = 2475;
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
			$valores="('".$m_mov."','".$cuenta."','".'FACTURA DE VENTA No '.$num_factura."','0','".$_REQUEST["subtotal"]."','".$cliente_fac."','')";					
			$error=insertar("d_movimientos",$campos,$valores);
			
			
			//NIVEL 3
			//TOMA LOS 4 PRIMEROS CARACTERES DEL CODIGO CONTABLE DE LA CUENTA
			$cod_cuenta = 2475;
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
			$valores="('".$m_mov."','".$cuenta."','".'FACTURA DE VENTA No '.$num_factura."','0','".$_REQUEST["subtotal"]."','".$cliente_fac."','')";					
			$error=insertar("d_movimientos",$campos,$valores);
			
			//NIVEL 2
			//TOMA LOS 2 PRIMEROS CARACTERES DEL CODIGO CONTABLE DE LA CUENTA
			$cod_cuenta = 2475;
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
			$valores="('".$m_mov."','".$cuenta."','".'FACTURA DE VENTA No '.$num_factura."','0','".$_REQUEST["subtotal"]."','".$cliente_fac."','')";					
			$error=insertar("d_movimientos",$campos,$valores);
			
			//NIVEL 1
			//TOMA EL 1 PRIMER CARACTER DEL CODIGO CONTABLE DE LA CUENTA
			$cod_cuenta = 2475;
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
			$valores="('".$m_mov."','".$cuenta."','".'FACTURA DE VENTA No '.$num_factura."','0','".$_REQUEST["subtotal"]."','".$cliente_fac."','')";					
			$error=insertar("d_movimientos",$campos,$valores);

			///EL INGRESO///

			///EL DESCUENTO///
		if($_REQUEST['desc_tot'] > 0){
			//REGISTRO EN D_MOVIMIENTO
			$campos="(cod_mov,cuenta_dmov,concepto_dmov,debito_dmov,credito_dmov,cod_ter,centro_dmov)";		
			$valores="('".$m_mov."','2486','".'FACTURA DE VENTA No '.$num_factura."','".$_REQUEST["desc_tot"]."','0','".$cliente_fac."','')";	
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
			$valores="('".$m_mov."','".$cuenta."','".'FACTURA DE VENTA No '.$num_factura."','".$_REQUEST["desc_tot"]."','0','".$cliente_fac."','')";					
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
			$valores="('".$m_mov."','".$cuenta."','".'FACTURA DE VENTA No '.$num_factura."','".$_REQUEST["desc_tot"]."','0','".$cliente_fac."','')";					
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
			$valores="('".$m_mov."','".$cuenta."','".'FACTURA DE VENTA No '.$num_factura."','".$_REQUEST["desc_tot"]."','0','".$cliente_fac."','')";					
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
			$valores="('".$m_mov."','".$cuenta."','".'FACTURA DE VENTA No '.$num_factura."','".$_REQUEST["desc_tot"]."','0','".$cliente_fac."','')";					
			$error=insertar("d_movimientos",$campos,$valores);
		}
			///EL DESCUENTO///

			///EL IVA///
			$iva = $_REQUEST["todocompra"] * 0.16;
			//REGISTRO EN D_MOVIMIENTO
			$campos="(cod_mov,cuenta_dmov,concepto_dmov,debito_dmov,credito_dmov,cod_ter,centro_dmov)";		
			$valores="('".$m_mov."','2477','".'FACTURA DE VENTA No '.$num_factura."','0','".$iva."','".$cliente_fac."','')";	
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
			$valores="('".$m_mov."','".$cuenta."','".'FACTURA DE VENTA No '.$num_factura."','0','".$iva."','".$cliente_fac."','')";					
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
			$valores="('".$m_mov."','".$cuenta."','".'FACTURA DE VENTA No '.$num_factura."','0','".$iva."','".$cliente_fac."','')";					
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
			$valores="('".$m_mov."','".$cuenta."','".'FACTURA DE VENTA No '.$num_factura."','0','".$iva."','".$cliente_fac."','')";					
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
			$valores="('".$m_mov."','".$cuenta."','".'FACTURA DE VENTA No '.$num_factura."','0','".$iva."','".$cliente_fac."','')";					
			$error=insertar("d_movimientos",$campos,$valores);

			///EL IVA///

			///EFECTIVO///
		if($_REQUEST['pago_2'] > 0){
			//REGISTRO EN D_MOVIMIENTO
			$campos="(cod_mov,cuenta_dmov,concepto_dmov,debito_dmov,credito_dmov,cod_ter,centro_dmov)";		
			$valores="('".$m_mov."','2491','".'FACTURA DE VENTA No '.$num_factura."','".$_REQUEST['pago_2']."','0','".$cliente_fac."','')";	
			$error=insertar("d_movimientos",$campos,$valores);
			
			//NIVEL 4
			//TOMA LOS 6 PRIMEROS CARACTERES DEL CODIGO CONTABLE DE LA CUENTA
			$cod_cuenta = 2491;
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
			$valores="('".$m_mov."','".$cuenta."','".'FACTURA DE VENTA No '.$num_factura."','".$_REQUEST['pago_2']."','0','".$cliente_fac."','')";					
			$error=insertar("d_movimientos",$campos,$valores);
			
			
			//NIVEL 3
			//TOMA LOS 4 PRIMEROS CARACTERES DEL CODIGO CONTABLE DE LA CUENTA
			$cod_cuenta = 2491;
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
			$valores="('".$m_mov."','".$cuenta."','".'FACTURA DE VENTA No '.$num_factura."','".$_REQUEST['pago_2']."','0','".$cliente_fac."','')";					
			$error=insertar("d_movimientos",$campos,$valores);
			
			//NIVEL 2
			//TOMA LOS 2 PRIMEROS CARACTERES DEL CODIGO CONTABLE DE LA CUENTA
			$cod_cuenta = 2491;
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
			$valores="('".$m_mov."','".$cuenta."','".'FACTURA DE VENTA No '.$num_factura."','".$_REQUEST['pago_2']."','0','".$cliente_fac."','')";					
			$error=insertar("d_movimientos",$campos,$valores);
			
			//NIVEL 1
			//TOMA EL 1 PRIMER CARACTER DEL CODIGO CONTABLE DE LA CUENTA
			$cod_cuenta = 2491;
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
			$valores="('".$m_mov."','".$cuenta."','".'FACTURA DE VENTA No '.$num_factura."','".$_REQUEST['pago_2']."','0','".$cliente_fac."','')";					
			$error=insertar("d_movimientos",$campos,$valores);
		}
			///EFECTIVO///

	///REGISTRO CONTABLE DE LA FACTURA////*/

					 if ($regimen_cli=='SIMPLIFICADO' && $lista!=21)
                     { 	
		         
					  $sql =" select
					  d_factura.cod_dfac,
					  d_factura.cod_mfac,
					  d_factura.cod_pro as l,
					  producto.cod_pro ,
					  producto.cod_mar_pro,
					  producto.cod_tpro_pro,
					  d_factura.cod_tpro,
					  tipo_producto.cod_tpro,
					  tipo_producto.nom_tpro,
					  producto.cod_pes_pro,
					  marca.cod_mar,
					  marca.nom_mar,
					  m_factura.cod_fac,
					  cliente.cod_cli,
					  m_factura.cod_cli
					  
					  FROM
					  d_factura
					  INNER JOIN producto ON (d_factura.cod_pro = producto.cod_pro)
					  INNER JOIN tipo_producto ON (producto.cod_tpro_pro = tipo_producto.cod_tpro)
					  INNER JOIN marca ON (producto.cod_mar_pro = marca.cod_mar)
					  INNER JOIN m_factura ON (d_factura.cod_mfac = m_factura.cod_fac)
					  INNER JOIN cliente ON (m_factura.cod_cli = cliente.cod_cli)
										
					  where d_factura.cod_mfac=$ins_id AND m_factura.cod_cli=$cliente_facs ";
									
					  $dbdatos_pro= new  Database();
					  $dbdatos_pro->query($sql);
						
					  while($dbdatos_pro->next_row())
					  { 
						
						$productoss=$dbdatos_pro->l;
						
						  $sqll ="select 
						  listaprecio.cos_list,
						  listaprecio.nom_list,
						  det_lista.cod_pro,
						  det_lista.pre_reg,
						  det_lista.pre_list,
						  det_lista.lista_cli,
						  d_factura.cod_dfac,
						  d_factura.cod_mfac,
						  d_factura.cod_pro,
						  d_factura.cant_pro,
					  	  producto.cod_pro,
						  producto.cod_mar_pro,
						  producto.cod_tpro_pro,
						  d_factura.cod_tpro,
						  tipo_producto.cod_tpro,
						  tipo_producto.nom_tpro,
						  producto.cod_pes_pro,
						  marca.cod_mar,
						  marca.nom_mar
						  
					      FROM
						  listaprecio
						  INNER JOIN det_lista ON (listaprecio.cos_list = det_lista.lista_cli)
						  INNER JOIN d_factura ON (det_lista.cod_pro = d_factura.cod_pro)
						  INNER JOIN producto ON (d_factura.cod_pro = producto.cod_pro)
						  INNER JOIN tipo_producto ON (producto.cod_tpro_pro = tipo_producto.cod_tpro)
						  INNER JOIN marca ON (producto.cod_mar_pro = marca.cod_mar)
						  where listaprecio.cos_list=21 and det_lista.cod_pro=$productoss and  d_factura.cod_mfac=$ins_id ";
									
						  $dbdatos_list= new  Database();
						  $dbdatos_list->query($sqll);
						  $dbdatos_list->next_row();
						  $dbdatos_pro->total_pro;
						
						  $total_prod=($dbdatos_list->cant_pro * $dbdatos_list->pre_list);
						  $total_prodfact+=($dbdatos_list->cant_pro * $dbdatos_list->pre_list);
						  $valor_unitario=($dbdatos_list->pre_list);		
														
						  $composd="(cod_mfac,cod_tpro,cod_cat,cod_pro,cant_pro,val_uni,total_pro) ";
						  $valoresf="('".$ins_idet."','".$dbdatos_list->cod_tpro."','".$dbdatos_list->cod_mar."','".$dbdatos_list->cod_pro."','".$dbdatos_list->cant_pro."','".$valor_unitario."','".$total_prod."')";
						   
						  $error=insertar("d_factura_esp",$composd,$valoresf);
	 					 
	                    }
		 
						 // RUTINA PARA  editar REGISTROS
						  $compos="tot_fac='".$total_prodfact."'";
						  $error=editar("m_factura_esp",$compos,'cod_fac',$ins_idet); 
						
                     }
		
		header("Location: informes/ver_apartado_imp.php?codigo=$ins_id"); 	
		
	}
	
	else
		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>"; 	

    }


/*}//fin espejo*/


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>APARTADOS</title>
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
//CARGA EL TIPO DEL PRODUCTO
function cargar_tipo_producto(categoria,tipo_producto,bodega){
var combo=document.getElementById(tipo_producto);
combo.options.length=0;
var cant=0;
combo.options[cant] = new Option('Seleccione','0'); 
cant++;
<?
		$sqltp ="SELECT DISTINCT producto.cod_tpro_pro,tipo_producto.nom_tpro,producto.cod_mar_pro,kardex.cod_bod_kar FROM kardex
		LEFT OUTER JOIN producto ON (kardex.cod_ref_kar = producto.cod_pro)
		LEFT OUTER JOIN tipo_producto ON (producto.cod_tpro_pro = tipo_producto.cod_tpro)
		WHERE cant_ref_kar > 0 AND cod_bod_kar = $bodega
		GROUP by  cod_ref_kar
		ORDER BY  nom_tpro ASC
		";		
		$dbtp= new  Database();
		$dbtp->query($sqltp);
		while($dbtp->next_row()){ 
		echo "if(document.getElementById(categoria).value==$dbtp->cod_mar_pro) {";
		echo "combo.options[cant] = new Option('$dbtp->nom_tpro','$dbtp->cod_tpro_pro');";
		echo "cant++; } ";
		}
		$dbtp->close();
?>
}

//CARGA LA REFERENCIA DEL PRODUCTO
function cargar_referencia(tipo_producto,referencia,bodega){
var combo=document.getElementById(referencia);
combo.options.length=0;
var cant=0;
combo.options[cant] = new Option('Seleccione','0'); 
cant++;
<?
		$sqlr ="SELECT DISTINCT kardex.cod_ref_kar,nom_pro,producto.cod_tpro_pro FROM   kardex
		LEFT OUTER JOIN producto ON (kardex.cod_ref_kar = producto.cod_pro)
		LEFT OUTER JOIN tipo_producto ON (producto.cod_tpro_pro = tipo_producto.cod_tpro)
		WHERE cant_ref_kar > 0 AND cod_bod_kar = $bodega 
		GROUP by  cod_pro
		ORDER BY  nom_pro ASC";		
		$dbr= new  Database();
		$dbr->query($sqlr);
		while($dbr->next_row()){ 
		echo "if(document.getElementById(tipo_producto).value=='$dbr->cod_tpro_pro') {";
		echo "combo.options[cant] = new Option('$dbr->nom_pro','$dbr->cod_ref_kar');";
		echo "cant++; } ";
		}
		$dbr->close();
?> 
}

//CARGA EL ITEM, EL CODIGO DEL PRODUCTO Y LA TALLA
function cargar_codigo_talla(referencia,codigo,codigo_producto,bodega,valor_lista){
//CARGA EL ITEM Y EL CODIGO DEL PRODUCTO
var item_articulo = "";
var codigo_articulo = "";
<?
		$sqlcod ="SELECT cod_pro,cod_fry_pro,cod_ref_kar,cod_bod_kar,cant_ref_kar FROM kardex
		INNER JOIN producto ON (kardex.cod_ref_kar = producto.cod_pro)";		
		$dbcod= new  Database();
		$dbcod->query($sqlcod);
		while($dbcod->next_row()){ 
		echo "if(document.getElementById(referencia).value==$dbcod->cod_ref_kar && document.getElementById(bodega).value==$dbcod->cod_bod_kar && $dbcod->cant_ref_kar > 0) {";	
		echo "codigo_articulo = '$dbcod->cod_pro'; ";
		echo "item_articulo = '$dbcod->cod_fry_pro'; }";
		}
		$dbcod->close();
?>
document.getElementById(codigo_producto).value= codigo_articulo;
document.getElementById(codigo).value= item_articulo;
}

//CARGA EL VALOR DEL PRODUCTO
function cargar_valor(valor_lista,codigo_producto){
var valor=0;
<?
	$sqlv ="SELECT * FROM producto WHERE estado_producto = 1";		
	$dbv= new  Database();
	$dbv->query($sqlv);
	while($dbv->next_row()){ 
		if($codigo_lista_cliente == 1){
			$val = $dbv->valor_pro;
		}else if($codigo_lista_cliente == 2){
			$val = $dbv->promo_pro;
		}else if($codigo_lista_cliente == 3){
			$val = $dbv->temp_pro;
		}

		echo "if(document.getElementById(codigo_producto).value==$dbv->cod_pro) {";
		echo "valor = '$val'; }";
	}
	$dbv->close();
?>
if(document.getElementById('tipo_producto').value == 80){
	document.getElementById(valor_lista).readOnly = false;
} else {
	document.getElementById(valor_lista).readOnly = true;
}

document.getElementById(valor_lista).value= valor;
}

//CARGA TODA LA INFORMACION CON EL ITEM
function cargar_articulo(categoria,tipo_producto,referencia,codigo,codigo_producto,bodega,valor_lista){
	
//CARGA LA CATEGORIA
var combo=document.getElementById(categoria);
<?
		$sqltd ="SELECT cod_fry_pro,cod_mar FROM `producto`
		INNER JOIN marca ON (marca.cod_mar = producto.cod_mar_pro)";		
		$dbtd= new  Database();
		$dbtd->query($sqltd);
		while($dbtd->next_row()){ 
		echo "if(document.getElementById(codigo).value =='$dbtd->cod_fry_pro'){";
		echo "valor = '$dbtd->cod_mar';}";	
		}
?>
var cant = combo.options.length; 
for (i=0; i<=cant; i++){
if(combo[i].value == valor){
combo[i].selected = true;
	
	//CARGA EL TIPO DEL PRODUCTO
	cargar_tipo_producto(categoria,tipo_producto,bodega)	
	var combo=document.getElementById(tipo_producto);
	<?
		$sqltp ="SELECT cod_fry_pro,cod_tpro FROM `producto`
		INNER JOIN tipo_producto ON (tipo_producto.cod_tpro = producto.cod_tpro_pro)";		
		$dbtp= new  Database();
		$dbtp->query($sqltp);
		while($dbtp->next_row()){ 	
		echo "if(document.getElementById(codigo).value=='$dbtp->cod_fry_pro') {";
		echo "valor = '$dbtp->cod_tpro';}";
		}
	?>
	var cant = combo.options.length;
	for (i=0; i<=cant; i++){
	if(combo[i].value == valor){
	combo[i].selected = true;
		
		//CARGA LA REFERENCIA
		cargar_referencia(tipo_producto,referencia,bodega)
		var combo=document.getElementById(referencia);
		<?
			$sqlr ="SELECT cod_fry_pro,cod_pro FROM `producto`";		
			$dbr= new  Database();
			$dbr->query($sqlr);
			while($dbr->next_row()){ 	
			echo "if(document.getElementById(codigo).value=='$dbr->cod_fry_pro') {";
			echo "valor = '$dbr->cod_pro';}";
			}
		?>
		var cant = combo.options.length;
		for (i=0; i<=cant; i++){
		if(combo[i].value == valor){
		combo[i].selected = true;
		cargar_codigo_talla(referencia,codigo,codigo_producto,bodega,valor_lista)
		cargar_valor(valor_lista,codigo_producto)
		return true;
		}
		}
	}
	}
}
}
}

function  adicion() 
{

	if(document.getElementById('marca').value < 1 || document.getElementById('tipo_producto').value < 1 || document.getElementById('combo_referncia').value < 1 || document.getElementById('cantidad').value=="" ) 
	{
		alert("Datos Incompletos")
		return false;
	}
	
	if(validar_cantidad()==false)
		return false;
		
	if(buscar_datos_total('valor_lista')==false)
		return false;
	
	
	var  vali_ref= anti_trampa(document.getElementById("combo_referncia").value);
	
	if(vali_ref==1)
	{
		alert("Esta Referencia Ya fue agregada  Si desea Modificar la Cantidad  Elimine el Registro y Agregue nuevamente")
		return false;
	}

	if(document.getElementById("marca").value>0  && document.getElementById("tipo_producto").value > "" && document.getElementById('combo_referncia').value > 0 && document.getElementById("cantidad").value>0 ) 
	{
		Agregar_html_venta();						
		limpiar_combos();
		document.getElementById('marca').value=0;
		document.getElementById("codigo_fry").focus();
		return false;
	}
	
	else 
	{
		alert("Ingrese una Referencia Valida junto con los demas Valores")
		document.getElementById("codigo_fry").focus();
	}
}

//VALIDA QUE LA CANTIDAD NO SEA MAYOR A LA EXISTENTE
function validar_cantidad(){
var cantidad_existente = 0;
var cantidad_pedido = 0;
<?
	$sqlcan =" SELECT cod_bod_kar,cod_ref_kar,cant_ref_kar FROM kardex";		
	$dbcan= new  Database();
	$dbcan->query($sqlcan);
	while($dbcan->next_row()){ 
		echo "if(document.getElementById('bodega').value==$dbcan->cod_bod_kar &&  document.getElementById('codigo_producto').value==$dbcan->cod_ref_kar)";
		echo "cantidad_existente = '$dbcan->cant_ref_kar';";
	}
	$dbcan->close();
?>
cantidad_pedido = parseInt(document.getElementById('cantidad').value);
cantidad_existente = parseInt(cantidad_existente);
	if (cantidad_pedido > cantidad_existente) {
 		alert('Cantidad '+ cantidad_pedido +' mayor a la existente '+cantidad_existente);
		return false;	
	}
	else
	 	return true;
}

function buscar_datos_total(opc) {
if(opc=="valor_lista") {
	if(document.getElementById('valor_lista').value==""){
		alert("No hay Precio Asignado")
		return false;
	}
	else 
		return true;	
	}
}

function anti_trampa(cod_ref_comp)
{	
	var myString =document.getElementById("tipo_referencias").value;
	var mySplitResult = myString.split("@");
	var myString_sub;
	var mySplitResult_sub ;
	var validador=0;
		
	
	for(i = 1; i < mySplitResult.length; i++)
	{		

		myString_sub=mySplitResult[i];
		mySplitResult_sub = myString_sub.split(",");
		
		if(mySplitResult_sub[1]== cod_ref_comp) 
		{
			validador=1;
		}

	}
	
	return validador;
}

function limpiar_combos()
{	
	document.getElementById('marca').value=0;
	document.getElementById('tipo_producto').options.length=0;
	document.getElementById('combo_referncia').options.length=0;
	document.getElementById('codigo_fry').value="";
	document.getElementById('valor_lista').value="";
	document.getElementById('cantidad').value="";	
	document.getElementById('descuento').value="";	
	
}

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
		return true;
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
</script>
<script type="text/javascript" src="js/js.js">
</script><script type="text/javascript" src="js/funciones.js"></script>
</script><link href="css/stylesforms.css" rel="stylesheet" type="text/css" />
<link href="css/styles2.css" rel="stylesheet" type="text/css" />
<link href="informes/styles.css" rel="stylesheet" type="text/css" />
</head>
<body <?php echo $sis?>>
<div id="total">
<form  name="forma" id="forma" action="man_apartado.php"  method="post">
<span class="textotabla01">

</span>
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
   <td bgcolor="#D1D8DE" >
   <table width="100%" height="30" border="0" cellspacing="0" cellpadding="0" align="center" > 
      <tr>
        <td width="5" height="30">&nbsp;</td>
        <td width="20" ><img src="imagenes/icoguardar.png" alt="Nueno Registro" width="16" height="16" border="0" onClick="cambio_guardar()" style="cursor:pointer"/></td>
        <td width="61" class="ctablaform">Guardar</td>
        <td width="21" class="ctablaform"><a href="con_apartado.php?confirmacion=0&editar=<?php echo $editar?>&insertar=<?php echo $insertar?>&eliminar=<?php echo $eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
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
		$sql = "select num_apa_rso + 1  as  num_factura from rsocial WHERE cod_rso=$empresa ";
		$db6->query($sql);

		if($db6->next_row())
		$num_factura = $db6->num_factura;
	
	?>
    APARTADO Nro.      <?php echo $num_factura?></td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif"  width="100%" height="4"/></td>
  </tr>
  <tr>
    <td bgcolor="#D1D8DE" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
        <td width="62" class="textotabla1">Fecha:</td>
        <td width="275" colspan="2" class="subtitulosproductos"><?php echo $fecha_venta?>
          <input name="fecha_fac" id="fecha_fac" type="hidden" value="<?php echo $fecha_venta?>"  /></td>
        <td width="20" class="textorojo">*</td>
        <td width="77" class="textotabla1">Usuario:</td>
        <td width="145"  class="subtitulosproductos">
		<?
		if ($codigo!=0) echo $dbdatos_edi->nom_usu;
		else  echo $_SESSION['global_3'];
		
		?>
		<input name="usuario" id="usuario" type="hidden" value="<?php echo $usuario?>"></td>		 
        <td width="171" class="textorojo">&nbsp;</td>
       </tr>
	   <tr>
        <td width="62" height="24" class="textotabla1">Empresa:</td>
        <td width="275" colspan="2" class="subtitulosproductos">
		<?
		$sql ="SELECT nom_rso from rsocial where cod_rso=$empresa";
	$db->query($sql);
	while($db->next_row()){
		echo $db->nom_rso;
	}
		?>
		<input name="empresa" id="empresa" type="hidden" value="<?php echo $empresa?>"></td>
        <td width="20" class="textorojo">*</td>
        <td width="77" class="textotabla1"> Bodega:</td>
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
        <td width="171" >
			<input name="precio_lista" id="precio_lista" type="hidden" class="subtitulosproductos" />		</td>
       </tr>
	   <tr>
	     <td height="24" class="textotabla1">Cliente:</td>
	     <td colspan="2" class="subtitulosproductos"><?
	$sql ="SELECT nom1_cli,apel1_cli,cupo_cli from cliente where cod_cli=$cliente";
	$db->query($sql);
	while($db->next_row())
	{
		echo $db->nom1_cli." ".$db->apel1_cli;

		$cupo_covinoc=$db->cupo_cli;
	}
		?>
	       <input name="cliente_fac" id="cliente_fac" type="hidden" value="<?php echo $cliente?>" /></td>
	     <td class="textorojo">&nbsp;</td>
	     <td class="textotabla1">Vendedor</td>
	     <td class="subtitulosproductos"><input name="vendedor" id="vendedor" type="hidden" value="<?php echo $vendedor?>" /><?php echo $vend ?></td>
	     <td >&nbsp;</td>
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
        <td colspan="8" class="textotabla1" >
		<table  width="100%" border="1">         
          <tr >
            
            <td  class="ctablasup">Categoria</td>
			<td  class="ctablasup">Tipo Producto </td>
            <td colspan="2"  class="ctablasup">Referencia</td>
			<td  class="ctablasup">&nbsp;Codigo
			  <label></label></td>
            <td  class="ctablasup">Talla</td>
            <td  class="ctablasup">Color</td>
            <td class="ctablasup">Valor</td>
            <td  class="ctablasup">Cantidad</td>
            <td  class="ctablasup">Descuento</td>
			<td width="4%" class="ctablasup" align="center">Agregar:</td>
          </tr>
          <tr >
            <td >
			<?php 
  			$sql="SELECT cod_mar_pro,nom_mar  FROM kardex 
			INNER JOIN producto ON (kardex.cod_ref_kar = producto.cod_pro)  
 			INNER JOIN marca ON (producto.cod_mar_pro = marca.cod_mar)
			WHERE  cod_bod_kar = $bodega AND cant_ref_kar > 0
			GROUP BY  kardex.cod_bod_kar, cod_mar_pro
			ORDER BY  `marca`.`nom_mar` ASC";
			combo_sql_evento("marca","","cod_mar_pro","nom_mar","",$sql," onchange=\"cargar_tipo_producto('marca','tipo_producto','bodega') \"");  ?>			</td>
			<td >
			<select size="1" id="tipo_producto" name="tipo_producto" class='SELECT' onchange="cargar_referencia('tipo_producto','combo_referncia','bodega') " >
            </select>			</td>
            <td colspan="2" align="center">
		<select size="1" id="combo_referncia" name="combo_referncia"  class='SELECT'  onchange="cargar_codigo_talla('combo_referncia','codigo_fry','codigo_producto','bodega','valor_lista');cargar_valor('valor_lista','codigo_producto');">
            </select>
			
              <input name="text" type="hidden" id="codigo_producto" /></td>
             <td align="center">
			<input name="codigo_fry" id="codigo_fry" type="text" class="caja_resalte1" onkeypress=" return valida_evento(this)" onchange="cargar_articulo('marca','tipo_producto','combo_referncia','codigo_fry','codigo_producto','bodega','valor_lista')" >			</td>
            <td><?php combo_evento_where("talla","talla","cod_talla","nom_talla","",""," where estado_Talla = 1 ORDER BY nom_talla")?></td>
            <td><?php combo_evento_where("color","color","cod_color","nom_color","",""," where estado_color = 1 ORDER BY nom_color")?></td>
            <td><input class="caja_resalte" name="valor_lista" type="visible" id="valor_lista" /></td>    
			 <td align="center"><input name="cantidad" type="text" class="caja_resalte" id="cantidad" onkeypress="return validaInt_evento(this,'mas')"/></td>
			 <td align="center"><input name="descuento" type="text" class="caja_resalte" id="descuento" onkeypress="return validaInt_evento(this,'mas')"/></td>
			 	 			    </td>
			 
			 
		    <td align="center"> 
			 <input id="mas" type='button'  class='botones' value='  +  '  onclick="adicion()">			 </td>
          </tr>
		      
		  <tr >
		  <td  colspan="11">
			  <table width="100%">
				<tr id="fila_0">
				
				<td class="ctablasup">Categoria</td>
				<td class="ctablasup">Tipo Producto </td>
				<td class="ctablasup">Referencia</td>
				<td class="ctablasup">Codigo</td>
           	 	<td class="ctablasup">Talla</td>
            	<td class="ctablasup">Color</td>
				<td class="ctablasup">Cantidad</td>
				<td class="ctablasup">Descuento</td>
				<td class="ctablasup">Valor</td>
				<td class="ctablasup" align="center">Borrar</td>
				</tr>
				</table>			</td>
			</tr>			
		 <tr >
		  <td  colspan="11">
			  <table width="100%">
				<tr >
				<td  class="ctablasup"><div align="left">Observaciones:</div></td>
				<td  class="ctablasup"><div align="right">Resumen Venta </div></td>
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
				</div>				  </td>
				<td width="53%" ><div align="right"><span class="ctablasup">Sub total:</span>
				    <input name="subtotal" id="subtotal" type="text" class="textfield01" readonly="1" value="<?php if($codigo !=0) echo $dbdatos_edi->tot_fac; else echo "0"; ?>"/>
				  </div>
				  <div align="right"><span class="ctablasup">Descuento:</span>
                              <input name="desc_tot" id="desc_tot" type="text" class="textfield01" onchange="return validaInt_evento(this,'mas')" onkeypress="prueba()" value="<?php if($codigo !=0) echo $dbdatos_edi->tot_fac; else echo "0"; ?>"/>
                                  </div>
				  <div align="right"><span class="ctablasup">Bono:</span>
                              <input name="bono_tot" id="bono_tot" type="text" class="textfield01" readonly="1" value="<?php if($codigo !=0) echo $dbdatos_edi->tot_fac; else echo "0"; ?>"/>
                                  </div>
                                  <div align="right"><span class="ctablasup">Total  Venta:</span>
                                    <input name="todocompra" id="todocompra" type="text" class="textfield01" readonly="readonly" value="<?php if($codigo !=0) echo $dbdatos_edi->tot_fac; else echo "0"; ?>"/>
                            </div></td>
				</tr>

				</table>			  </td>
			</tr>
		</table>
		  </table>
	    </td>
	  </tr>
	  <tr> 
		  <td colspan="8" >		  </td>
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