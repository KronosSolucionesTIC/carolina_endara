<?php include("../lib/database.php") ;?>
<?php 

//CODIGO
$codigo = $_REQUEST['codigo'];

$es_abono="si";
	$db = new Database();
	$db_ver = new Database();
	$sql = "select * , (select nom_usu  from usuario where cod_usu=abono.cod_usu_abo) as usuario  from abono where cod_abo=$codigo";
//	exit;
	$db_ver->query($sql);	
	if($db_ver->next_row()){ 
		$fac_numero=$db_ver->cod_abo;
		$codigo_salida=$db_ver->cod_bod_Abo;
		$valor=$db_ver->val_abo;
		$usuario=$db_ver->cod_usu_abo;
		$fac_fecha=$db_ver->fec_abo;
		$usuario=$db_ver->usuario;
		$observacion=$db_ver->observacion;
		$anotacion=$db_ver->anotacion;
		$fac_fecha_abono = $db_ver->fec_abo;
		$cod_razon_abo = $db_ver->cod_rso_abo;
		$cod_abono = $db_ver->cod_abo;
	}

$db_fac = new Database();

if(!empty($cod_razon_abo)) {
	 $sql ='select * from rsocial where cod_rso='.$cod_razon_abo ;
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
	}
}

?>

 <link href="styles.css" rel="stylesheet" type="text/css" />
 
 <title>IMPRESION ABONO</title><TABLE width="95%" border="0" cellspacing="0" cellpadding="0">


	<TR>
		<TD width="1%" background="images/bordefondo.jpg" style="background-repeat:repeat-y" rowspan="2"></TD>
		<TD bgcolor="#F4F4F4" class="pag_actual">&nbsp;</TD>
		<TD width="1%" background="images/bordefondo.jpg" style="background-repeat:repeat-y" rowspan="2"></TD>
	</TR>
	<TR>
		<TD align="center">
		<TABLE width="94%" border="1" cellpadding="2" cellspacing="2" >
		
			<INPUT type="hidden" name="mapa" value="<?php echo $mapa?>">
			<INPUT type="hidden" name="id" value="<?php echo $id?>">


			<TR>
			  <TD width="50%" class='txtablas'>			  </TD>
			  <TD width="50%" class='subtitulosproductos'>ABONO  <?php echo $cod_abono?></TD>
		  </TR>
			<TR>
			  <TD colspan="2" class='txtablas'>
			  <?php include("factura_cabezote1.php") ?></TD>
			  </TR>
			<TR>
			  <TD colspan="2" class='txtablas'> <?php include("factura_cliente1.php") ?>	</TD>
			  </TR>
			
			<TR>
			  <TD colspan="2" align="center"><div align="right"><span class="subtitulosproductos">TOTAL ABONO
			    <input type="text" name="total_traslado"  id="total_traslado" class="box" size="15"  value="<?php echo number_format($valor,0,".",".")?>" readonly="1" />
		      </span></div></TD>
		  </TR>
			<TR>
			  <TD colspan="2" align="center">             </TD>
			  </TR>
			<TR><TD colspan="2" align="center"><table width="97%" class="textoproductos1">
                      <tr>
                        <td colspan="2" class='txtablas'>Observaciones:<?php echo $anotacion?> <p> </td>
                      </tr>
					  <tr>
                        <td colspan="2" class='txtablas'>Detalle del Abono:<?php echo $observacion?> <p> </td>
                      </tr>
                      <tr>
                        <td width="362" class='txtablas'>Firma Entregado ________________<p><?php echo $usuario?> </td>
                        <td width="288" class='txtablas'>Firma Recibido ________________<p></td>
                      </tr>
                    </table></TD>
					</TR>
				<TR><TD colspan="2" align="center">
					<INPUT type="button" value="Imprimir" class="botones" onClick="window.print()">
					<INPUT type="button" value="Cerrar" class="botones" onClick="window.close()"></TD>
					</TR>
</TABLE>

 
<TABLE width="70%" border="0" cellspacing="0" cellpadding="0">
	
	<TR><TD colspan="3" align="center"></TD>
	</TR>

	<TR>
		<TD width="1%" background="images/bordefondo.jpg" style="background-repeat:repeat-y" rowspan="2"></TD>
		<TD bgcolor="#F4F4F4" class="pag_actual">&nbsp;</TD>
		<TD width="1%" background="images/bordefondo.jpg" style="background-repeat:repeat-y" rowspan="2"></TD>
	</TR>
	<TR>
	  <TD align="center">	