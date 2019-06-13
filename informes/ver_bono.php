<?php
include "../lib/sesion.php";
include("../lib/database.php");
include("../conf/clave.php");				
	$db = new Database();
	$db_ver = new Database();
	$sql = "select *, DATE_ADD(fec_bono ,interval 30 day) as fac_fecha_vence   from bono 
	INNER JOIN tipo_bono ON tipo_bono.cod_tbono = bono.tipo_bono 
	where cod_bono=$codigo";
	$db_ver->query($sql);	
	if($db_ver->next_row())
	{ 
		$fac_numero=$db_ver->num_bono;
		$fac_fecha=$db_ver->fec_bono;
		$codigo_cli=$db_ver->cli_bono;
		$codigo_razon=1;
		$obs_fac =$db_ver->obs_bono;
		$tot_bono = $db_ver->valor_bono;
		$vendedor = $db_ver->ven_bono;
		$nom_bono = $db_ver->nom_tbono;
		$estado_factura=$db_ver->estado;
		$leyenda_t = $db_ver->leyenda_tbono;
		$tipo_bono = $db_ver->tipo_bono;
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
	$obs_fac = $db_ver->obs_bono;
}




?>
<script language="javascript">
function imprimir(){
	document.getElementById('imp').style.display="none";
	document.getElementById('cer').style.display="none";
	window.print();
}


</script>
<title>BONO</title>
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
<TABLE  border="0" cellpadding="0" cellspacing="0"  width="100%" width='100%' <?=$anulacion?> class='Estilo3'>
<tr>
	<img src='../imagenes/logo.jpg' align="center" width='100%'>
</tr>
	<TR>
			  <TD align="center">
			  	<table width="100%" border="0" class='Estilo3'>
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
			      <td colspan="5">&nbsp;</td>
		        </tr>
			    <tr>
			      <td colspan="5" align='center'><span class="Estilo3">
			        <? if ($rem_fac=="remision") { echo " Remision:"; } ?>
			        <? if ($rem_fac=="factura") { echo " Bono:"; } ?>
			        <? if($es_abono!="si"){?>
			        BONO DE <?echo $nom_bono; ?> No:
				  <? echo $fac_numero; ?></span>
                  <?  }?>
		        </tr>
			    <tr>
			      <td ALIGN='center' colspan="5"><span class="Estilo3">FECHA:<? echo $fac_fecha; ?></td>
                </tr>
			    <tr>
			      <td colspan="5"><table width="100%" border="0" >
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
		      </table>
</TD>
		  </TR>
			<TR>
			  <TD align="center" colspan='5'><div align="center">*****************************</div></TD>
		  </TR>
			<TR>
			  <TD><table width="100%" align="center" border="0"  id="select_tablas">
                <tr>
                  <td colspan="5">&nbsp;</td>
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

				?> 
				<tr>
					<td colspan='5' class='Estilo3'>VALOR: <?php echo number_format($tot_bono,0,".",".") ?></td>
			    </tr>
			    <tr>
					<td colspan='5'>&nbsp;</td>
			    </tr>
			    <?php if($tipo_bono == 2){?>
			    <tr>
					<td colspan='5' class='Estilo3'>RECIBIDOS ASI:</td>
			    </tr>
				<tr>
					<?php
					$dbo = new database();
					$sqlo = "SELECT * FROM otros_pagos
					INNER JOIN tarjeta ON tarjeta.cod_tarjeta = otros_pagos.cod_tarjeta
					WHERE cod_bono = $codigo";
					$dbo->query($sqlo);
					$tot_tar = 0;
						while($dbo->next_row()){
					?>
					<td></td>
					<td colspan='5' class='Estilo3'><?php echo $dbo->nom_tarjeta ?><?php echo '$'.number_format($dbo->val_otro,0,".",".")?><?php echo 'AUT.'.$dbo->num_auto?></td>
				</tr>
				<tr>
					<?php 
							$tot_tar = $tot_tar + $dbo->val_otro;
						}
						$efec = $tot_bono - $tot_tar;
					?>
					<?php if($efec > 0) {?>
					<td class='Estilo3' colspan="5">EFECTIVO:<?php echo '$'.number_format($efec,0,".",".")?></td>
					<?php } ?>
				</tr>
				<? } ?>
								<?php 
				if($tipo_bono == 3){
					//TRAE EL NUMERO DE FACTURA
					$dbf = new database();
					$sqlf = "SELECT * FROM m_factura
					INNER JOIN bono ON bono.fac_bono = m_factura.cod_fac
					WHERE cod_bono = $codigo";
					$dbf->query($sqlf);
					if($dbf->next_row()){
						$num_fac = $dbf->num_fac;
						$obs_bono = $dbf->obs_bono;
					}
				?>
				<tr>
					<td colspan="5"><span class="Estilo3">NUM FACT CAMBIO:<?php echo $num_fac?></span></td>
				</tr>
				<tr>
					<td colspan="5"><span class="Estilo3">PRODUCTOS:<?php echo $obs_bono?></span></td>
				</tr>
				<?php } ?>
                <tr >
                  <td class="Estilo3" colspan='5'><span class="Estilo3">VENDEDOR:<?php echo $vend?></span></td>                
				</tr>  	  
				<tr >
				    <td class="Estilo3" colspan='5'><span class="Estilo3"><?php echo $leyenda_t?></span></td>
				</tr>  
				<?
				if($regimen=="Comun") { 
				$base = $total / 1.19;
				$iva_reg=$total-  $base ;
				?>
			    <tr >  
                  <td colspan="5" >&nbsp;</td>
				</tr>   
				  
				 <? 
				 } 
				 ?>
				  
                
              </table>
</TD>
		  </TR>
          			<TR>
			  <TD align="center" colspan="5"><div align="center">*****************************</div></TD>
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
                <td width="100%" align="center"><div align="center" class="Estilo3">
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