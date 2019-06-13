<?
include "../lib/sesion.php";
include("../lib/database.php");
include("../conf/clave.php");				
	$db = new Database();
	$db_ver = new Database();
	$sql = "select *, DATE_ADD(fecha ,interval 30 day) as fac_fecha_vence   from m_abono where cod_abo=$codigo";
	$db_ver->query($sql);	
	if($db_ver->next_row())
	{ 
		$rem_abo=$db_ver->rem_abo;
		$cod_razon=$db_ver->cod_razon_abo;
		$fac_numero=$db_ver->num_abo;
		$fac_fecha=$db_ver->fecha;
		$tipo_abo=$db_ver->tipo_abo;
		$codigo_bod=$db_ver->bod_cli_abo;
		$codigo_cli=$db_ver->cod_cli;
		$codigo_razon=$db_ver->cod_razon_abo;
		$tipo_pago=$db_ver->tipo_pago;
		$fac_fecha_vence=$db_ver->fac_fecha_vence;
		$estado_factura=$db_ver->estado;
		$cod_usuario=$db_ver->cod_usu;
		$obs_abo =$db_ver->obs;
		$tot_abo = $db_ver->tot_abo;
		$vendedor = $db_ver->cod_ven;
	}

$codigo_salida=$codigo_cli;
$db_fac = new Database();
$sql ='select * from rsocial where cod_rso='.$codigo_razon ;
$db_fac->query($sql);
if($db_fac->next_row()){ 
	$razon=$db_fac->nom_rso;
	$nit=$db_fac->nit_rso;
	$telefono=$db_fac->tel_rso;
	$direccion=$db_fac->dir_rso;
	$leyenda=$db_fac->desc1_rso;
	$leyenda2=$db_fac->desc2_rso;
	$logo=$db_fac->logo_rso;
	$regimen = $db_fac->reg_rso;
	$obs_fac = $db_ver->obs;
}




?>
<script language="javascript">
function imprimir(){
	window.print();
}


</script>
<title>ABONO</title>
<style type="text/css">
<!--
.Estilo3 {
	font-size: 20px;
	font-family: "verdana";
	margin: 0px;
    padding: 0px;
}
-->
</style>

<?
if($estado_factura=="anulado")
	$anulacion="background='../imagenes/anulacion.gif'";
?>
<body onload="imprimir()">
<TABLE  border="0" cellpadding="0" cellspacing="0"  width="100%" <?=$anulacion?> class='Estilo3'>
<tr>
	<img src='../imagenes/logo.jpg' align="center">
</tr>
	<TR>
			  <TD align="center"><table width="100%" border="0" >
			    <tr>
			      <td colspan="3"><div align="center"><span class="Estilo3"><?=$razon?></span></div></td>
			    </tr>
			    <tr>
			      <td colspan="3"><div align="center"><span class="Estilo3">NTI <?=$nit?> / IVA REGIMEN COMUN</span></div></td>
			    </tr>
			    <tr>
			      <td colspan="3"><div align="center"><span class="Estilo3"><?=$direccion?></span></div></td>
			    </tr>
			    <tr>
			      <td colspan="3"><div align="center"><span class="Estilo3">TELEFONOS: <?=$telefono?></span></div></td>
		        </tr>
			    <tr>
			      <td>&nbsp;</td>
			      <td colspan="2">&nbsp;</td>
		        </tr>
			    <tr>
			      <td colspan="6" align='center'><span class="Estilo3">
			        <? if ($rem_fac=="remision") { echo " Remision:"; } ?>
			        <? if ($rem_fac=="factura") { echo " Factura de venta:"; } ?>
			        <? if($es_abono!="si"){?>
			        ABONO No:
				  <?  
				  if ($tipo_fac == 'B') {
				  	echo '* '.$fac_numero;
				  } else {
				  	echo $fac_numero;
				  }
				  ?></span>
                  <?  }?>
		        </tr>
			    <tr>
			      <td ALIGN='center' colspan="6"><span class="Estilo3">FECHA:<? echo $fac_fecha; ?></td>
                </tr>
			    <tr>
			      <td colspan="4"><table width="100%" border="0" >
			        <tr>
			          <td><div align="justify"><span class="Estilo3">
			            <?=$leyenda?>
			            </span></div></td>
		            </tr>
			        </table></td>
		        </tr>
			    </table>
			    <div align="center">*****************************</div>
			    <table width="100%" border="0">
			    <tr>
			      <td><span class="Estilo3">CLIENTE:			        <?
		  	$db_cliente = new Database();
			$db_fecha = new Database();
			$sql ='select * from cliente 
			where cod_cli = '.$codigo_salida;
			$db_cliente->query($sql);
			if($db_cliente->next_row()){ 	
				
			?>
			        <? $nombre = $db_cliente->nom1_cli.' '.$db_cliente->nom2_cli.' '.$db_cliente->apel1_cli.' '.$db_cliente->apel2_cli; ?>
                    <? if($db_cliente->digito_cli != ''){?>
                    <? $identificacion = $db_cliente->iden_cli ?>
                    <? } else {?>
                    <? $identificacion = $db_cliente->iden_cli?>
                    <? } ?>
			        <? echo $nombre; ?></span></td>
			     </td>
		        </tr>
			    <tr>
			      <td><span class="Estilo3">NIT/C.C.:<? echo $identificacion; ?></span></td>
			      <td><div><span class="Estilo3"></span></div></td>
		        </tr>
			    <tr>
			      <td><span class="Estilo3">TELEFONO:<? echo $db_cliente->tel_cli;?></span></td>
			      <td><div><span class="Estilo3"></span></div></td>
		        </tr>
			    <tr>
			      <td><span class="Estilo3">CELULAR:<? echo $db_cliente->cel1_cli;?></span></td>
			      <td><div><span class="Estilo3"></span></div></td>
		        </tr>		 
			      <? } ?>
		      </table></TD>
		  </TR>
			<TR>
			  <TD align="center"><div align="center">*****************************</div></TD>
		  </TR>
			
			<TR>
			  <TD><table width="100%" align="center" border="0"  id="select_tablas">
                <tr >
                  <td><span class="Estilo3">CODIGO</span></td>
                  <td><span class="Estilo3">DESCRIPCION</span></td>
                  <td><div align="center" class="Estilo3"><span class="Estilo3">CANT.</span></div></td>
                  <td><div align="center" class="Estilo3">DCTO.</div></td>
                  <td><div align="center" class="Estilo3">VALOR</div></td>
                </tr>
                <?
				$total=0;
				$tot = 0;
				$sql = " select * from d_abono 
				left join tipo_producto on d_abono.cod_tpro=tipo_producto.cod_tpro
				left join marca on d_abono.cod_cat=marca.cod_mar
				left join talla on talla.cod_talla = d_abono.cod_peso
				left join producto  on d_abono.cod_pro= producto.cod_pro 
				WHERE cod_mabo= $codigo";
					$db->query($sql);
					$estilo="formsleo";
					while($db->next_row()){ 
						//$db->fec_ent;
						if($estilo=="formsleo")
							$estilo="formsleo1";
						else
							$estilo="formsleo";
				?>
                <tr id="fila_0"  >
                  <td class="textotabla01" ><div class="Estilo3"><?=$db->cod_fry_pro?></div></td>
                  <td class="textotabla01" ><div class="Estilo3"><?php echo $db->nom_tpro.' '.$db->nom_pro.' '.$db->nom_talla.' '.$db->nom_color?></div></td>
                  <td class="textotabla01" ><div align="right" class="Estilo3"><div align="center"><?=$db->cant_pro?></div></div></td>
                  <td class="textotabla01"><div align="center" class="Estilo3"><span class="Estilo3"><?=number_format($db->desc_pro,0,".",".")?></span></div></td>
                  <td class="textotabla01"><div align="right" class="Estilo3"><span class="Estilo3"><?=number_format($db->total_pro,0,".",".")?></span></div></td>
                </tr>
                <?
                $tot = $tot + $db->total_pro;
				$total++;
				  } 
				  
				  $sql = "SELECT tot_abo as total FROM m_abono WHERE cod_abo = $codigo";
			$db->query($sql);
			if($db->next_row()){ 
				$total = $db->total;
			}	
				$saldo = $tot - $tot_abo ; 
				$descuento = $total - $tot_abo;
				?>
                <tr>
                  <td colspan="5">&nbsp;</td>
                </tr>
				<?php 
				//CONSULTA BONO
				$dbb1 = new database();
				$sqlb1 = "SELECT * FROM bono 
				INNER JOIN m_abono ON m_abono.bono_abo = bono.cod_bono
				WHERE cod_abo = $codigo";
				$dbb1->query($sqlb1);
				if($dbb1->next_row()){
				?>
				<tr>
                  <td class="textotabla01"></td>
                  <td class="textotabla01"></td>
                  <td class="textotabla01"></td>
                  <td class="textotabla01"><div align="right" class="Estilo3">TOTAL</div></td>
                  <td class="textotabla01"><div align="right" class="Estilo3"><?PHP echo '$'.number_format($tot,0,".",".")?></span></div></td>
                </tr>
 				<tr>
                  <td class="textotabla01"></td>
                  <td class="textotabla01"></td>
                  <td class="textotabla01"></td>
                  <td class="textotabla01"><div align="right" class="Estilo3">BONO</div></td>
                  <td class="textotabla01"><div align="right" class="Estilo3"><?PHP echo '-$'.number_format($dbb1->valor_bono,0,".",".")?></span></div></td>
                </tr>
                <?php } ?>
				<tr>
                  <td class="textotabla01"></td>
                  <td class="textotabla01"></td>
                  <td class="textotabla01"></td>
                  <td class="textotabla01"><div align="right" class="Estilo3">TOTAL</div></td>
                  <td class="textotabla01"><div align="right" class="Estilo3"><?PHP echo '$'.number_format($tot,0,".",".")?></span></div></td>
                </tr>
                <tr>
                  <td class="textotabla01"></td>
                  <td class="textotabla01"></td>
                  <td class="textotabla01"></td>
                  <td class="textotabla01"><div align="right" class="Estilo3">ABONO</div></td>
                  <td class="textotabla01"><div align="right" class="Estilo3"><?PHP echo '$'.number_format($tot_abo,0,".",".")?></span></div></td>
                </tr>
               	<tr>
                  <td class="textotabla01"></td>
                  <td class="textotabla01"></td>
                  <td class="textotabla01"></td>
                  <td class="textotabla01"><div align="right" class="Estilo3">SALDO</div></td>
                  <td class="textotabla01"><div align="right" class="Estilo3"><?PHP echo '$'.number_format($saldo,0,".",".")?></span></div></td>
                </tr>
                <tr>
                  <td colspan="5">&nbsp;</td>
                </tr>   				
				<?php 
				//CONSULTA NOMBRE VENDEDOR
				$dbv = new database();
				$sqlv = "SELECT * FROM vendedor WHERE cod_ven = $vendedor";
				$dbv->query($sqlv);
				$dbv->next_row();
				$vend = $dbv->nom_ven;

				//CONSULTA PRECIO
				$dbp = new database();
				$sqlp = "SELECT cant_pro,valor_pro,total_pro,desc_pro FROM producto 
				INNER JOIN d_abono ON d_abono.cod_pro = producto.cod_pro
				INNER JOIN m_abono ON m_abono.cod_abo = d_abono.cod_mabo
				WHERE cod_mabo= $codigo";
				$dbp->query($sqlp);
				while($dbp->next_row()){
					if($dbp->desc_pro > 0){
						$subtot = $subtot + ($dbp->cant_pro * $dbp->valor_pro);
					}else{
						$subtot = $subtot + $dbp->total_pro;
					}
				}

				//CONSULTA AHORRO
				$ahorro = $subtot - $tot;
				?>
				<?php 
				//CONSULTA BONO
				$dbb = new database();
				$sqlb = "SELECT * FROM bono 
				INNER JOIN tipo_bono ON tipo_bono.cod_tbono = bono.tipo_bono
				INNER JOIN m_abono ON m_abono.bono_abo = bono.cod_bono
				WHERE cod_abo = $codigo";
				$dbb->query($sqlb);
				if($dbb->next_row()){
				?> 
				<tr>
					<td colspan='5' class='Estilo3'><?php echo $dbb->nom_tbono.' '.number_format($dbb->valor_bono,0,".",".") ?></td>
			    </tr>
				<?php
				} else { if($ahorro > 0){ 
				?>
				<tr>
					<td colspan='5' class='Estilo3'>SE AHORRO: <?php echo number_format($ahorro,0,".",".") ?></td>
			    </tr>
			    <?
			    	}
			    }
			    ?>
			    <tr>
					<td>&nbsp;</td>
			    </tr>
			    <tr>
					<td class='Estilo3'>RECIBIDOS ASI:</td>
			    </tr>
			    <?php
  				//CONSULTA LOS DATOS DEL APARTADO
  				$dbap = new database();
  				$sqlap = "SELECT *,DATE(DATE(m_apartado.fecha)) as fec  FROM m_apartado
  				INNER JOIN m_abono ON m_abono.cod_apa = m_apartado.cod_apa
  				WHERE m_abono.cod_abo = $codigo";
  				$dbap->query($sqlap);
  				while($dbap->next_row()){
    				$tot_apa = $dbap->tot_apa;
    				$saldo = $total - $tot_apa;
    				$apa = $dbap->num_apa;
    				$cod_apar = $dbap->cod_apa;
    				$fecha_de_apartado = $dbap->fec; 
  				}

  					if($tot_apa > 0){
        		?>
        		<tr>
					<td colspan="2" class='Estilo3'>APARTADO No <?php echo $apa ?> DEL <?php echo $fecha_de_apartado ?>:</td >
					<td align="right" class='Estilo3'><?php echo '$'.number_format($tot_apa,0,".",".")?></td>
					<td colspan="2">&nbsp;</td>
				</tr>
				<?php 
					} 
				?>
				<tr>
					<?php
					$dbo = new database();
					$sqlo = "SELECT * FROM otros_pagos
					INNER JOIN tarjeta ON tarjeta.cod_tarjeta = otros_pagos.cod_tarjeta
					WHERE cod_abono = $codigo";
					$dbo->query($sqlo);
					$tot_tar = 0;
					while($dbo->next_row()){
					?>
					<td></td>
					<td class='Estilo3'><?php echo $dbo->nom_tarjeta ?></td>
					<td class='Estilo3'><?php echo '$'.number_format($dbo->val_otro,0,".",".")?></td>
					<td class="Estilo3"><?php echo 'AUT.'.$dbo->num_auto?></td>
				</tr>
				<tr>
					<?php 
					$tot_tar = $tot_tar + $dbo->val_otro;
					}
					$efec = $tot_abo - $tot_tar
					?>
					<?php if($efec > 0) {?>
					<td class='Estilo3'></td>
					<td class='Estilo3'>EFECTIVO:</td>
					<td class='Estilo3'><?php echo '$'.number_format($efec,0,".",".")?></td>
					<?php } ?>
				</tr>
                <tr >
                  <td class="Estilo3" colspan='6' align='center'><span class="Estilo3">VENDEDOR:<?php echo $vend?></span></td>               
				</tr>  	  
				<?
				if($regimen=="Comun") { 
				$base = $total / 1.19;
				$iva_reg=$total-  $base ;
				?>
			    <tr >  
                  <td class="<?=$estilo?> Estilo3 Estilo4" >&nbsp;</td>
                  <td class="Estilo3 <?=$estilo?> Estilo3" >&nbsp;</td>
                  <td colspan="2" class="<?=$estilo?> Estilo3 Estilo4" >&nbsp;</td>
				</tr>   
				  
				 <? 
				 } 
				 ?>
				  
				  
				  
                  <?
			 $sql = "select * from usuario WHERE cod_usu= $cod_usuario";
			$db->query($sql);
			if($db->next_row()){ 
				$usuario = $db->nom_usu;
				$obs = $db->obs;
			}
			$sql = "SELECT SUM(total_pro) as total FROM d_abono WHERE cod_mabo= $codigo";
			$db->query($sql);
			if($db->next_row()){ 
				$total = $db->total;
			}	
				
			
			?>
                
              </table></TD>
		  </TR>
          			<TR>
			  <TD align="center"><div align="center">*****************************</div></TD>
		  </TR>
			<TR>

		  </TR>
			<TR>

		  </TR>
		  

			<TR><TD colspan="2" align="left">
			
			<?
			if( !empty($obs_fac) ) {
			?>
			<table width="100%" border="0" align="center" class="forms1">
              <tr>
                <td>
				<div align="justify" class="Estilo3">OBSERVACIONES:<br> <?=$obs_fac?>
                      
                </div></td>
              </tr>
            </table>
			<p>
			  <?
			}
			?>
			</p>
			<table width="100%" border="0" align="center">
              <tr>
                <td><div align="justify" class="Estilo3">
                  <p>&nbsp;</p>
                </div>                </td>
              </tr>
            </table>
			<br />

			<table width="100%" border="0" align="center">
              <tr>
                <td width="100%" align="center"><div align="center" class="Estilo3">PRENDAS APARTADAS NO TIENEN CAMBIO, SE GUARDA POR UN MES, NO SE HACE DEVOLUCION DE DINERO
     			</div>
                  <? if($tipo_pago == "Credito"){?>
                  <div align="center" class="Estilo3">
                    <table width="100%" height="100%" border="1">
                      <tr>
                        <td><div align="center" class="Estilo3">SELLO</div></td>
                      </tr>
                    </table>
                    <p>&nbsp;</p>
                  </div>
  <?  }  ?>
  </td>
              </tr>
            </table>
			</TD>
</TABLE>
</body>