<?
include "../lib/sesion.php";
include("../lib/database.php");
include("../conf/clave.php");				
	$db = new Database();
	$db_ver = new Database();
	$sql = "select *, DATE_ADD(fecha ,interval 30 day) as fac_fecha_vence   from m_factura where cod_fac=$codigo";
	$db_ver->query($sql);	
	if($db_ver->next_row())
	{ 
		$rem_fac=$db_ver->rem_fac;
		$cod_razon=$db_ver->cod_razon_fac;
		$fac_numero=$db_ver->num_fac;
		$fac_fecha=$db_ver->fecha;
		$tipo_fac=$db_ver->tipo_fac;
		$codigo_bod=$db_ver->bod_cli_fac;
		$codigo_cli=$db_ver->cod_cli;
		$codigo_razon=$db_ver->cod_razon_fac;
		$tipo_pago=$db_ver->tipo_pago;
		$fac_fecha_vence=$db_ver->fac_fecha_vence;
		$estado_factura=$db_ver->estado;
		$cod_usuario=$db_ver->cod_usu;
		$obs_fac =$db_ver->obs;
		$tot_fac = $db_ver->tot_fac;
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
	$ciudad=$db_fac->ciu_razon;
	$leyenda=$db_fac->desc1_rso;
	$leyenda2=$db_fac->desc2_rso;
	$logo=$db_fac->logo_rso;
	$regimen = $db_fac->reg_rso;
	$obs_fac = $db_ver->obs;
}




?>
<script language="javascript">
function imprimir(){
	document.getElementById('imp').style.display="none";
	document.getElementById('cer').style.display="none";
	window.print();
}


</script>


<title>FACTURA DE VENTA</title>
<style type="text/css">
<!--
.Estilo4 {font-size: 16px}
.Estilo127 {font-family: Arial, Helvetica, sans-serif; font-size: 14px; }
.Estilo129 {font-family: Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo25 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
.Estilo28 {font-size: 10px}
.Estilo30 {font-family: Arial, Helvetica, sans-serif; font-size: 8px; }
.Estilo12 {
	font-size: 12px;
	font-family: "Lucida Console";
}
.Estilo121 {	font-size: 14px;
	font-family: "Lucida Console";
}

-->
</style>

<?
if($estado_factura=="anulado")
	$anulacion="background='../imagenes/anulacion.gif'";
?>
<TABLE border="0" cellpadding="2" cellspacing="0"  width="306" <?=$anulacion?> >
		
			<INPUT type="hidden" name="mapa" value="<?=$mapa?>">
			<INPUT type="hidden" name="id" value="<?=$id?>">


			<TR>
			  <TD align="center"><table width="250" border="0" >
			    <tr>
			      <td colspan="3"><div align="center"><span class="Estilo12">
			        <?=$razon?>
		          </span></div></td>
		        </tr>
			    <tr>
			      <td><span class="Estilo12">NIT:</span></td>
			      <td colspan="2"><div align="right"><span class="Estilo12">
			        <?=$nit?>
		          </span></div></td>
		        </tr>
			    <tr>
			      <td><span class="Estilo12">DIRECCION:</span></td>
			      <td colspan="2"><div align="right"><span class="Estilo12">
			        <?=$direccion?>
		          </span></div></td>
		        </tr>
			    <tr>
			      <td><span class="Estilo12">TELEFONO:</span></td>
			      <td colspan="2"><div align="right"><span class="Estilo12">
			        <?=$telefono?>
		          </span></div></td>
		        </tr>
			    <tr>
			      <td>&nbsp;</td>
			      <td colspan="2">&nbsp;</td>
		        </tr>
			    <tr>
			      <td colspan="2"><span class="Estilo12">
			        <? if ($rem_fac=="remision") { echo " Remision:"; } ?>
			        <? if ($rem_fac=="factura") { echo " Factura de venta:"; } ?>
			        <? if($es_abono!="si"){?>
			        Factura de venta No:</span></td>
			      <td width="8%"><div align="right"><span class="Estilo12">
				  <?  echo $fac_numero;?>
                  <?  }?>
		          </span></div></td>
		        </tr>
			    <tr>
			      <td><span class="Estilo12">FECHA:</span></td>
			      <td colspan="2"><div align="right"><span class="Estilo12"><? echo $fac_fecha; ?></span></div></td>
                </tr>
                <tr>
			      <td width="48%"><span class="Estilo12"><? if($es_abono!="si"){?>
			        TIPO PAGO:
			        </span></td>
                    <td colspan="2"><div align="right"><span class="Estilo12"><? echo $tipo_pago; ?>
		              <?  }  ?>
	                </span></div></td>
                    
		        </tr>
			    <? if($tipo_pago == "Credito"){?>
			    <tr>
			      <td><span class="Estilo12">FECHA DE VENCIMIENTO:</span></td>
			      <td colspan="3"><div align="right"><span class="Estilo12">
			        <?=$fac_fecha_vence?>
			        </span></div></td>
		        </tr>
			    <?  }  ?>
			    <tr>
			      <td colspan="4"><table width="248" border="0" >
			        <tr>
			          <td><div align="justify"><span class="Estilo12">
			            <?=$leyenda?>
			            </span></div></td>
		            </tr>
			        </table></td>
		        </tr>
			    </table>
			    <div align="center">*******************************</div>
			    <table width="250" border="0">
			    <tr>
			      <td width="23%"><span class="Estilo12">VENDIDO A: </span></td>
			      <td width="77%"><div align="right"><span class="Estilo12">
			        <?
		  	$db_cliente = new Database();
			$db_fecha = new Database();
			$sql ='select * from bodega1 
			INNER JOIN ciudad ON (ciudad.cod_ciudad = bodega1.ciu_bod)
			where cod_bod = '.$codigo_salida;
			$db_cliente->query($sql);
			if($db_cliente->next_row()){ 
				
				$sql_fecha="select date_add('$fac_fecha',INTERVAL $db_cliente->dias_credito DAY ) as fecha_vencimineto_factura";
				$db_fecha->query($sql_fecha);
				if($db_fecha->next_row()){ 
					$fecha_vencimineto_factura=$db_fecha->fecha_vencimineto_factura;
				}	
				
			?>
			        <? $nombre = $db_cliente->nom_bod.' '.$db_cliente->apel_bod.' '.$db_cliente->rsocial_bod?>
                    <? if($db_cliente->digito_bod != ''){?>
                    <? $identificacion = $db_cliente->iden_bod.'-'.$db_cliente->digito_bod ?>
                    <? } else {?>
                    <? $identificacion = $db_cliente->iden_bod?>
                    <? } ?>
			        <? echo $nombre; ?></span></div></td>
		        </tr>
			    <tr>
			      <td><span class="Estilo12">NIT/C.C.:</span></td>
			      <td><div align="right"><span class="Estilo12"><? echo $identificacion; ?></span></div></td>
		        </tr>
			    <tr>
			      <td><span class="Estilo12">DIRECCION:</span></td>
			      <td><div align="right"><span class="Estilo12"><? echo $db_cliente->dir_bod;?></span></div></td>
		        </tr>
			    <tr>
			      <td><span class="Estilo12">TELEFONO:</span></td>
			      <td><div align="right"><span class="Estilo12"><? echo $db_cliente->tel_bod;?></span></div></td>
		        </tr>
			    <tr>
			      <td><span class="Estilo12">CIUDAD:</span></td>
			      <td class="textoproductos1"><div align="right"><span class="Estilo12"><? echo $db_cliente->desc_ciudad;?></span></div></td>
			      <? } ?>
		        </tr>
		      </table></TD>
		  </TR>
			<TR>
			  <TD align="center"><div align="center">*******************************</div></TD>
		  </TR>
			
			<TR>
			  <TD><table width="250" align="center" border="0"  id="select_tablas">
                <tr >
                  <td width="58%" ><span class="Estilo12">DESCRIPCION</span></td>
                  <td width="12%" ><div align="center" class="Estilo12"><span class="Estilo12">CANT.</span></div></td>
                  <td colspan="2" ><div align="center" class="Estilo12">VALOR </div></td>
                </tr>
                <?
				$total=0;
				$sql = " select * from d_factura 
				left join tipo_producto on d_factura.cod_tpro=tipo_producto.cod_tpro
				left join marca on d_factura.cod_cat=marca.cod_mar left join peso on d_factura.cod_peso= peso.cod_pes 
				left join producto  on d_factura.cod_pro= producto.cod_pro 
				WHERE cod_mfac= $codigo";
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
                  <td ><span class="Estilo12">
				  <? if(($db->cod_cat == 1016)or($db->cod_cat == 1017)or($db->cod_cat == 1018)){?>
				  <? echo  $db->cod_fry_pro." ".substr($db->nom_pro,0,20)." - ".$db->nom_pes ; ?>
				  <? } else {?>
                  <? echo  substr($db->nom_pro,0,20)." - ".$db->nom_pes ; ?>
				  <? } ?>
                  </span></td>
                  <td colspan="1" class="textotabla01" ><div align="right" class="Estilo12">
                      <div align="center">
                        <?=$db->cant_pro?>
                      </div>
                  </div></td>
                  <td width="17%" class="textotabla01"><div align="right" class="Estilo12"><span class="Estilo12">
                    <?=number_format($db->total_pro,0,".",".")?>
                  </span></div></td>
                </tr>
                <?
				$total++;
				  } 
				  
				  $sql = "SELECT SUM(total_pro) as total FROM d_factura WHERE cod_mfac= $codigo";
			$db->query($sql);
			if($db->next_row()){ 
				$total = $db->total;
			}	
				$base = $total / 1.19;
				$iva_reg=$total-  $base ; 
				$descuento = $total - $tot_fac;
				?>
                <tr id="fila_0"  >
                  <td colspan="1" class="textotabla01 Estilo12" >&nbsp;</td>
                  <td colspan="2" class="textotabla01"><div align="right" class="Estilo127"><span class="Estilo12"><span class="Estilo12"><span class="Estilo12"><span class="Estilo12"><span class="Estilo12"></span></span></span></span></span></div></td>
                </tr>
				
                <tr >
                  <td class="<?=$estilo?> Estilo12 Estilo4" ><span class="Estilo12">TOTAL </span></td>
                  <td class="Estilo12 <?=$estilo?> Estilo12" >&nbsp;</td>
                  <td colspan="2" class="<?=$estilo?> Estilo12 Estilo4" ><div align="right" class="Estilo12">
                      <table  border="0">
                        <tr>
                          <td width="46"><div align="right" class="Estilo12" >
                            <?=number_format($tot_fac,0,".",".")?>
                          </div></td>
                        </tr>
                      </table>
                  </div></td>
				</tr>  
				  
				<?
				if($regimen=="Comun") { 
				$base = $total / 1.19;
				$iva_reg=$total-  $base ;
				?>
			    <tr >  
                  <td class="<?=$estilo?> Estilo12 Estilo4" >&nbsp;</td>
                  <td class="Estilo12 <?=$estilo?> Estilo12" >&nbsp;</td>
                  <td colspan="2" class="<?=$estilo?> Estilo12 Estilo4" >&nbsp;</td>
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
			$sql = "SELECT SUM(total_pro) as total FROM d_factura WHERE cod_mfac= $codigo";
			$db->query($sql);
			if($db->next_row()){ 
				$total = $db->total;
			}	
				
			
			?>
                
              </table></TD>
		  </TR>
          			<TR>
			  <TD align="center"><div align="center">*******************************</div></TD>
		  </TR>
			<TR>

		  </TR>
			<TR>

		  </TR>
		  

			<TR><TD colspan="2" align="left">
			
			<?
			if( !empty($obs_fac) ) {
			?>
			<table width="250" border="0" align="center" class="forms1">
              <tr>
                <td>
				<div align="justify" class="Estilo12">OBSERVACIONES:<br> <?=$obs_fac?>
                      
                </div></td>
              </tr>
            </table>
			<p>
			  <?
			}
			?>
			</p>
			<table width="250" border="0" align="center">
              <tr>
                <td><div align="justify" class="Estilo12">
                  <p>&nbsp;</p>
                </div>                </td>
              </tr>
			   <tr>
                <td class="Estilo4" ><span class="Estilo12">RECIBIDO POR:</span></td>
		      </tr>
              <tr>
                <td class="Estilo4" ><span class="Estilo12">FIRMA:____________________________</span></td>
              </tr>
              <tr>
                <td class="Estilo4" ><span class="Estilo12">CEDULA:___________________________</span></td>
              </tr>
            </table>
			<br />

			<table width="250" border="0" align="center">
              <tr>
                <td width="242" align="justify"><div align="justify" class="Estilo12"><?=$leyenda2?>
     			</div>
                  <? if($tipo_pago == "Credito"){?>
                  <div align="justify" class="Estilo12">
                    <table width="250" height="100" border="1">
                      <tr>
                        <td><div align="center" class="Estilo12">SELLO</div></td>
                      </tr>
                    </table>
                    <p>&nbsp;</p>
                  </div>
  <?  }  ?>
  </td>
              </tr>
            </table>
			</TD>
		  </TR>
		  
		  
				<TR><TD colspan="2" align="center" class="Estilo4">&nbsp;</TD>
		  </TR>
</TABLE>