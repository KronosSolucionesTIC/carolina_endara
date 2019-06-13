<?php include("lib/database.php");?>
<?php include("js/funciones.php");?>
<?php 

//recibe las variables
$fecha= $_REQUEST['fecha_abo'];
$valor = $_REQUEST['val_abono'];
$cliente = $_REQUEST['cliente'];
$cod_fac = $_REQUEST['combo_f'];
$tipo_pago = $_REQUEST['tipo_pago'];
$bodega = $_REQUEST['cliente'];
?>
<?
	$db = new Database();	
		    $sql="SELECT  cod_car_fac as codigo_cartera , 'CLIENTE' AS tipo_credito, 
			cod_car_fac,fec_car_fac, cartera_factura.cod_fac,m_factura.cod_fac, num_fac, cod_cli, cod_razon_fac,
			(SELECT SUM(total_pro) - tot_dev_mfac FROM d_factura WHERE cod_mfac=cartera_factura.cod_fac) AS total, 
			(SELECT plazo_cli FROM cliente WHERE cod_bod=cod_cli) AS dias , 
			datediff( curdate(),fec_car_fac) AS dias_factura,
			(SELECT nom1_cli FROM cliente WHERE cod_bod=cod_cli) AS nombre , 
			DATE_ADD(cartera_factura.fec_car_fac, INTERVAL (SELECT plazo_cli FROM cliente WHERE cod_bod=cod_cli) DAY) AS vecimiento,
			datediff(curdate(),DATE_ADD(cartera_factura.fec_car_fac, INTERVAL (SELECT plazo_cli FROM cliente WHERE cod_bod=cod_cli) DAY)) AS pasado ,
			(SELECT SUM(total_pro) - tot_dev_mfac FROM d_factura WHERE cod_mfac=cartera_factura.cod_fac) - IFNULL(valor_Abono,0)  AS saldo ,num_abono, valor_abono
			FROM cartera_factura
			INNER JOIN m_factura ON m_factura.cod_fac=cartera_factura.cod_fac 
			WHERE cod_cli > -1 and  cod_cli=$cliente AND estado_car <>'CANCELADA'
			ORDER BY fec_car_fac ";
			
$tabla='';
?>
<script language="javascript">

function validar_abonos(){
	document.forma.submit();
}

function validar_cacelar(){
	document.myForm.submit();
}

</script>
<link href="../styles.css" rel="stylesheet" type="text/css" />
<link href="../admon_cartera/styles1.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 12%}
-->
</style>
<link href="css/styles.css" rel="stylesheet" type="text/css">
<link href="css/styles1.css" rel="stylesheet" type="text/css">
<TABLE width="71%" border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" align="center">
		<FORM action="sav_abonos.php" method="post" name="forma" >
		
			<input type="hidden" name="editar"   id="editar"   value="<?php echo $editar?>">
			<input type="hidden" name="insertar" id="insertar" value="<?php echo $insertar?>">
			<input type="hidden" name="eliminar" id="eliminar" value="<?php echo $eliminar?>">
			<input type="hidden" name="codigo" id="codigo" value="<?php echo $codigo?>" />

			<INPUT type="hidden" value="<?php echo $cliente?>" name="cliente">
			<INPUT type="hidden" value="<?php echo $bodega?>" name="bodega">
			<INPUT type="hidden" value="<?php echo $valor?>" name="valor">
            <INPUT type="hidden" value="<?php echo $combo_f?>" name="factura">
			<INPUT type="hiddeN" value="<?php echo $fecha?>" name="fecha">
            <INPUT type="hidden" value="<?php echo $tipo_pago?>" name="tipo_pago">
			<INPUT type="hidden" value="<?php echo $observaciones?>" name="observacion_abo">
			<TR>
			  <TD class='ctablasup' align="center" colspan="9">LIQUIDACION DE ABONO </TD>
			<TR>
			  <TD width="10%" class='subtitulosproductos'>Factura</TD>
			  <TD width="9%"  class='subtitulosproductos'>Fecha</TD>
			  <TD width="17%"  class='subtitulosproductos'>Valor Factura</TD>
			   <TD width="11%"  class='subtitulosproductos'>Saldo Anterior</TD>
			    <TD width="11%"  class='subtitulosproductos'>Valor Abono</TD>
				<TD width="14%"  class='subtitulosproductos'>Saldo Actual</TD>
				<TD width="10%"  class='subtitulosproductos'>Forma de pago</TD>
			  <TD width="10%"  class='subtitulosproductos'>Estado</TD>
			</TR>
			<?			
				$descuento=$valor;			
				$db->query($sql);
				$i=1;
				$aa=0;
				$bb=0;
				$cont = 1;
				while($db->next_row()){ 
				$dbd = new Database();
				$sqld="SELECT datediff( curdate(),'$db->vecimiento') AS dias_ven
				FROM cartera_factura";
				$dbd->query($sqld);
				$dbd->next_row();
					//echo $db->num_abono;
					 $rsocial_fac=$db->cod_razon_fac;	
					 $nombre_abono=$db->nombre;
					 $total_factura=  $db->saldo - $db->valor_Abono;
					 $identifiacion=0;
					 $dbtp = new Database ();
					 $sqltp = "SELECT * FROM tipo_pago
					 WHERE cod_tpag = '$tipo_pago'";
					 $dbtp->query($sqltp);
					 $dbtp->next_row();
					 $tabla.='<TR>
						  <TD  class=\'textoproductos1\'><INPUT type="hidden" value="'.$db->num_abono.'" name="num_abonos_'.$i.'" >
						  	<INPUT type="hidden" value="'.$db->codigo_cartera.'" name="codigo_cartera_'.$i.'" > <INPUT type="hidden" value="'.$db->num_fac.'" name="factura_'.$i.'" >'.$db->num_fac.'</TD>
						  <TD  class=\'textoproductos1\'>'.$db->fec_car_fac.'</TD>
						  <INPUT type="hidden" value="'.$db->cod_fac.'" name="cod_fac_'.$i.'" >
						  <INPUT type="hidden" value="'.$db->fec_car_fac.'" name="fecha_'.$i.'" >
						  <TD  class=\'textoproductos1\'>'.number_format($db->total,0,".",".").'</TD>
						  <TD  class=\'textoproductos1\'>'.number_format($db->saldo,0,".",".").'</TD>';
						  
					if(($tipo_pago != 2)and($tipo_pago != 4)and($tipo_pago != 5)and($tipo_pago != 6)and($tipo_pago != 7)){
					if( $descuento >= $total_factura ){	  
						$tabla.='  <TD class=\'textoproductos1\'>'.number_format($total_factura,0,".",".").'</TD>
								<TD  class=\'textoproductos1\'>0</TD>
								<TD  class=\'textoproductos1\'>'.$dbtp->nom_tpag.'</TD>
								<TD width="10%" class=\'textoproductos1\'>CANCELADA
								<INPUT type="hidden" value="CANCELADA" name="accion_'.$i.'" >
							</TD></TR>';
							$identifiacion=1;
					}
					
					if( $descuento < $total_factura &&  $descuento > 0 ) {	  
						$tabla.='  <TD  class=\'textoproductos1\'>'.number_format($descuento,0,".",".").'</TD>
								<TD  class=\'textoproductos1\'>'.number_format($db->saldo - $descuento,0,".",".").'</TD>
								<TD  class=\'textoproductos1\'>'.$dbtp->nom_tpag.'</TD>
								<TD width="10%" class=\'textoproductos1\'>ABONADO
								<INPUT type="hidden" value="ABONADO" name="accion_'.$i.'" >
								<INPUT type="hidden" value="'.($db->valor_abono +  $descuento ).'" name="valor_abono_'.$i.'" >
							</TD></TR>';
							$identifiacion=1;
					}
					}
					if(($tipo_pago == 2)or($tipo_pago == 4)or($tipo_pago == 5)or($tipo_pago == 6)or($tipo_pago == 7)){
						$descuento = $valor;
						if($cod_fac == $db->cod_fac){  
							if( $descuento >= $total_factura ){	  
								$tabla.='  <TD class=\'textoproductos1\'>'.number_format($total_factura,0,".",".").'</TD>
								<TD  class=\'textoproductos1\'>0</TD>
								<TD  class=\'textoproductos1\'>'.$dbtp->nom_tpag.'</TD>
								<TD width="10%" class=\'textoproductos1\'>CANCELADA
								<INPUT type="hidden" value="CANCELADA" name="accion_'.$i.'" >
								</TD></TR>';
								$identifiacion=1;
							}
					
							if( $descuento < $total_factura &&  $descuento > 0 ) {	  
								$tabla.='  <TD  class=\'textoproductos1\'>'.number_format($descuento,0,".",".").'</TD>
								<TD  class=\'textoproductos1\'>'.number_format($db->saldo - $descuento,0,".",".").'</TD>
								<TD  class=\'textoproductos1\'>'.$dbtp->nom_tpag.'</TD>
								<TD width="10%" class=\'textoproductos1\'>ABONADO
								<INPUT type="hidden" value="ABONADO" name="accion_'.$i.'" >
								<INPUT type="hidden" value="'.($db->valor_abono +  $descuento ).'" name="valor_abono_'.$i.'" >
								</TD></TR>';
								$identifiacion=1;
							}
						}
					}
					$descuento=$descuento - $total_factura;	
					$i++;
					if($i== 2){
						$saldo_anterior = $db->saldo;	
					}
					
					$total_abono = $db->valor_abono + $valor;
				}
				
			if($i== 1){
				echo  "<span class=\'textoproductos1\'>No Existen Facturas Pendientes, No se puede Procesar el Abono</span>";
			}	
			
			
			echo $tabla;
			
			
			if($valor > $saldo_anterior){
				$bb=1;
				$mensaje="<span class=\'textoproductos1\' align='center'>El saldo supera la Cartera, por Favor Verifique... $valor $saldo_anterior</span>";
			}
			
			if($i > 1){
				$tabla='<TABLE width="92%" border="0" cellpadding="2" cellspacing="1" >
				<TR>
				 <TD class=\'subtitulosproductos \'>Factura</TD>
			  <TD  class=\'subtitulosproductos\'>Fecha		      </TD>
			  <TD  class=\'subtitulosproductos\'>Valor Factura</TD>
			   <TD  class=\'subtitulosproductos\'>Saldo Anterior</TD>
			    <TD  class=\'subtitulosproductos\'>Valor Abono</TD>
				<TD  class=\'subtitulosproductos\'>Saldo Actual</TD>
				<TD  class=\'subtitulosproductos\'>Forma de pago</TD>
			  <TD  class=\'subtitulosproductos\'>Accion</TD>
				</TR>
				'.$tabla.'</TABLE>';
				$i=$i-1;
				$aa=1;
				if($descuento > 0) $descuento=0;
				//$tabla.="<samp class='textoproductos1' > <BR> Nota: Saldo a Favor de: ".$descuento."</samp>";
			}
			
			?>
			 </TR>
				<TR>
			  <TD class='subtitulosproductos' align="left" colspan="9"><br> CLIENTE: <?php echo $nombre_abono?>  </TD>
			 
			</TR>
	<TR><TD colspan="9" align="center">
				
				<INPUT type="hidden"  name="saldo" value = "<?php echo $descuento?>"  >
                <INPUT type="hidden"  name="total_abono" value = "<?php echo $total_abono?>"  >
				<INPUT type="hidden" value="<?php echo $i?>" name="cantidad">
				<INPUT type="hidden" value="<?php echo $anotacion?>" name="anotacion">
				<INPUT type="hidden"  name="rsocial_fac" value = "<?php echo $rsocial_fac?>"  >
				
				
				<?
				if($aa == 1 && $bb == 0  ){ 
				?>
				<INPUT type="button" value="Aceptar" class="botones" onClick="validar_abonos()">
				<?php } ?>
				<input name="button" type="button" class="botones" onClick="validar_cacelar()" value="Cancelar" />
				
				
				
				<INPUT type="hidden"  name="leotabla" value = "<?php echo str_replace("\"","'",$tabla);   ?>">
				<!--<textarea style="display:inline" name="observacion"><?php echo $tabla?></textarea>-->
				</TD>
	</TR>
	</FORM>
</TABLE>
		
<?

if($aa==1){
	echo $mensaje;
}
?>
<FORM method="POST" action="con_abono.php" name="myForm">
<input type="hidden" name="editar"   id="editar"   value="<?php echo $editar?>">
<input type="hidden" name="insertar" id="insertar" value="<?php echo $insertar?>">
<input type="hidden" name="eliminar" id="eliminar" value="<?php echo $eliminar?>">
<input type="hidden" name="codigo" id="codigo" value="<?php echo $codigo?>" />
</FORM>