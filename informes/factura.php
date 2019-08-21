<?php
include "../lib/sesion.php";
include "../lib/database.php";
include "../conf/clave.php";
$db     = new Database();
$db_ver = new Database();
$sql    = "select *, DATE_ADD(fecha ,interval 30 day) as fac_fecha_vence   from m_factura where cod_fac=$codigo";
$db_ver->query($sql);
if ($db_ver->next_row()) {
    $rem_fac         = $db_ver->rem_fac;
    $cod_razon       = $db_ver->cod_razon_fac;
    $fac_numero      = $db_ver->num_fac;
    $fac_fecha       = $db_ver->fecha;
    $tipo_fac        = $db_ver->tipo_fac;
    $codigo_bod      = $db_ver->bod_cli_fac;
    $codigo_cli      = $db_ver->cod_cli;
    $codigo_razon    = $db_ver->cod_razon_fac;
    $tipo_pago       = $db_ver->tipo_pago;
    $fac_fecha_vence = $db_ver->fac_fecha_vence;
    $estado_factura  = $db_ver->estado;
    $cod_usuario     = $db_ver->cod_usu;
    $obs_fac         = $db_ver->obs;
    $tot_fac         = $db_ver->tot_fac;
    $vendedor        = $db_ver->cod_ven;
}

$codigo_salida = $codigo_cli;
$db_fac        = new Database();
$sql           = 'select * from rsocial where cod_rso=' . $codigo_razon;
$db_fac->query($sql);
if ($db_fac->next_row()) {
    $razon     = $db_fac->nom_rso;
    $nit       = $db_fac->nit_rso;
    $telefono  = $db_fac->tel_rso;
    $direccion = $db_fac->dir_rso;
    $leyenda   = $db_fac->desc1_rso;
    $leyenda2  = $db_fac->desc2_rso;
    $logo      = $db_fac->logo_rso;
    $regimen   = $db_fac->reg_rso;
    $obs_fac   = $db_ver->obs;
}

?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
<div class="table-responsive">
<?
if ($estado_factura == "anulado") {
    $anulacion = "background='../imagenes/anulacion.gif'";
}

?>
<table class="table">
<tr>
	<img src='../imagenes/logo.jpg' width='100%' align="center">
</tr>
	<TR>
			  <td  align="center">
			    <tr>
			      <td  colspan="3"><div align="center"><?=$razon?></div></td >
			    </tr>
			    <tr>
			      <td  colspan="3"><div align="center">NTI <?=$nit?> / IVA REGIMEN COMUN</div></td >
			    </tr>
			    <tr>
			      <td  colspan="3"><div align="center"><?=$direccion?></div></td >
			    </tr>
			    <tr>
			      <td  colspan="3"><div align="center">TELEFONOS: <?=$telefono?></div></td >
		        </tr>
			    <tr>
			      <td >&nbsp;</td >
			      <td  colspan="2">&nbsp;</td >
		        </tr>
			    <tr>
			      <td  colspan="6" align='center'>
			        <?if ($rem_fac == "remision") {echo " Remision:";}?>
			        <?if ($rem_fac == "factura") {echo " Factura de venta:";}?>
			        <?if ($es_abono != "si") {
    ?>
			        FACTURA DE VENTA No:
				  <?
    if ($tipo_fac == 'B') {
        echo '* ' . $fac_numero;
    } else {
        echo $fac_numero;
    }
    ?>
                  <?}?>
		        </tr>
			    <tr>
			      <td  ALIGN='center' colspan="6">FECHA:<?echo $fac_fecha; ?></td >
                </tr>
			    <tr>
			      <td  colspan="4">
			        <tr>
			          <td ><div align="justify">
			            <?=$leyenda?>
			            </div></td >
		            </tr>
		        </td >
		        </tr>
			    <tr>
			      <td >CLIENTE:			        <?
$db_cliente = new Database();
$db_fecha   = new Database();
$sql        = 'select * from cliente
			where cod_cli = ' . $codigo_salida;
$db_cliente->query($sql);
if ($db_cliente->next_row()) {

    ?>
			        <?$nombre = $db_cliente->nom1_cli . ' ' . $db_cliente->nom2_cli . ' ' . $db_cliente->apel1_cli . ' ' . $db_cliente->apel2_cli;?>
                    <?if ($db_cliente->digito_cli != '') {?>
                    <?$identificacion = $db_cliente->iden_cli?>
                    <?} else {?>
                    <?$identificacion = $db_cliente->iden_cli?>
                    <?}?>
			        <?echo $nombre; ?></td >
			     </td >
		        </tr>
			    <tr>
			      <td >NIT/C.C.:<?echo $identificacion; ?></td >
			      <td ><div></div></td >
		        </tr>
			    <tr>
			      <td >TELEFONO:<?echo $db_cliente->tel_cli; ?></td >
			      <td ><div></div></td >
		        </tr>
			    <tr>
			      <td >CELULAR:<?echo $db_cliente->cel1_cli; ?></td >
			      <td ><div></div></td >
		        </tr>
			      <?}?>
			  </td >
		  </TR>
			<TR>
			  <td colspan="5">&nbsp;</td >
		  </TR>

			<TR>
			  <td>
			  	<table border="0" cellpadding="0" cellspacing="0"  width="100%" class='Estilo4'>
			  		<tr>
                  		<td>CODIGO</td >
                  		<td>DESCRIPCION</td >
                  		<td align="center">CANT.</td >
                  		<td align="center">DCTO.</td >
                  		<td align="center">VALOR</td >
                	</tr>
                <?
$total = 0;
$tot   = 0;
$sql   = " select * from d_factura
				left join tipo_producto on d_factura.cod_tpro=tipo_producto.cod_tpro
				left join marca on d_factura.cod_cat=marca.cod_mar
				left join producto  on d_factura.cod_pro= producto.cod_pro
				WHERE cod_mfac= $codigo";
$db->query($sql);

while ($db->next_row()) {
    //CONSULTA LA TALLA Y COLOR
    $talla = '';
    $dbt   = new database();
    $sqlt  = " select * from talla
						inner join d_factura on d_factura.cod_talla = talla.cod_talla
						WHERE cod_dfac= $db->cod_dfac";
    $dbt->query($sqlt);
    if ($dbt->next_row()) {
        $talla = $dbt->nom_talla;
    }

    $color = '';
    $dbc   = new database();
    $sqlc  = " select * from color
						inner join d_factura on d_factura.cod_color = color.cod_color
						WHERE cod_dfac= $db->cod_dfac";
    $dbc->query($sqlc);
    if ($dbc->next_row()) {
        $color = $dbc->nom_color;
    }
    ?>
                <tr>
                  <td ><?=$db->cod_fry_pro?></td >
                  <td ><?php echo $db->nom_tpro . ' ' . $db->nom_pro . ' ' . $talla . ' ' . $color ?></td >
                  <td align="right" ><?=$db->cant_pro?></td>
                  <td align="center" ><?php echo number_format($db->desc_pro, 0, ".", ".") ?></td >
                  <td align="right"><?php echo '$' . number_format($db->total_pro, 0, ".", ".") ?></td >
                </tr>
                <?
    $tot = $tot + $db->total_pro;
    $total++;
}

$sql = "SELECT tot_fac as total FROM m_factura WHERE cod_fac= $codigo";
$db->query($sql);
if ($db->next_row()) {
    $total = $db->total;
}
$base      = $total / 1.19;
$iva_reg   = $total - $base;
$descuento = $total - $tot_fac;
?>
				<tr>
                  <td  colspan="5">&nbsp;</td >
                </tr>
				<tr>
                  <td></td >
                  <td colspan='2' align="right">SUBTOTAL</td >
                  <td colspan='2' align="right"><?PHP echo '$' . number_format($base, 0, ".", ".") ?></td >
                </tr>
                <tr>
                  <td></td >
                  <td colspan='2' align="right" >IVA</td >
                  <td colspan='2' align="right"><?PHP echo '$' . number_format($iva_reg, 0, ".", ".") ?></td >
                </tr>
               	<tr>
                  <td></td >
                  <td colspan='2' align="right">TOTAL</td >
                  <td colspan='2' align="right"><?PHP echo '$' . number_format($tot_fac, 0, ".", ".") ?></td >
                </tr>
                <tr>
                  <td  colspan="5">&nbsp;</td >
                </tr>
                <?php
//CONSULTA NOMBRE VENDEDOR
$dbv  = new database();
$sqlv = "SELECT * FROM vendedor WHERE cod_ven = $vendedor";
$dbv->query($sqlv);
$dbv->next_row();
$vend = $dbv->nom_ven;

//CONSULTA PRECIO
$tot_tot     = 0;
$sub_tot_tot = 0;
$dbp         = new database();
$sqlp        = "SELECT cant_pro,valor_pro,total_pro,desc_pro FROM producto
				INNER JOIN d_factura ON d_factura.cod_pro = producto.cod_pro
				INNER JOIN m_factura ON m_factura.cod_fac = d_factura.cod_mfac
				WHERE cod_mfac= $codigo";
$dbp->query($sqlp);
while ($dbp->next_row()) {
    if ($dbp->desc_pro > 0) {
        $subtot = $subtot + ($dbp->cant_pro * $dbp->valor_pro);
    } else {
        $subtot = $subtot + $dbp->total_pro;
    }

    //SUMA LOS VALORES DE LISTA 1
    $tot_tot = $tot_tot + ($dbp->cant_pro * $dbp->valor_pro);

    //SUMA LOS VALORES A LOS QUE SE FACTURA
    $sub_tot_tot = $sub_tot_tot + $dbp->total_pro;
}

//CONSULTA AHORRO
$ahorro = $subtot - $tot_fac;
//CONSULTA AHORRO POR LISTA
$ahorro_lista = $tot_tot - $sub_tot_tot;
?>
				<?php
//CONSULTA BONO
$dbb  = new database();
$sqlb = "SELECT * FROM bono
				INNER JOIN tipo_bono ON tipo_bono.cod_tbono = bono.tipo_bono
				INNER JOIN m_factura ON m_factura.bono_fac = bono.cod_bono
				WHERE cod_fac = $codigo";
$dbb->query($sqlb);
if ($dbb->next_row()) {
    ?>
				<?php
} else {
    if ($ahorro > 0) {
        ?>
				<tr>
					<td  colspan='5' >SE AHORRO: <?php echo number_format($ahorro, 0, ".", ".") ?></td >
			    </tr>
			    <?php
}
    ?>
			    <?php
if ($ahorro_lista > 0) {
        ?>
				<tr>
					<td  colspan='5' >SE AHORRO PROMOCION: <?php echo number_format($ahorro_lista, 0, ".", ".") ?></td >
			    </tr>
			    <?php
}
    ?>
			    <?
}
?>
			    <tr>
					<td colspan="5">&nbsp;</td >
			    </tr>
			    <tr>
					<td colspan="5">RECIBIDOS ASI:</td >
			    </tr>
			    <?php
//CONSULTA LOS DATOS DEL APARTADO
$dbap  = new database();
$sqlap = "SELECT *,DATE(DATE(m_apartado.fecha)) as fec  FROM m_apartado
  				INNER JOIN m_factura ON m_factura.cod_apa = m_apartado.cod_apa
  				WHERE cod_fac = $codigo";
$dbap->query($sqlap);
while ($dbap->next_row()) {
    $tot_apa           = $dbap->tot_apa;
    $saldo             = $total - $tot_apa;
    $apa               = $dbap->num_apa;
    $cod_apar          = $dbap->cod_apa;
    $fecha_de_apartado = $dbap->fec;
}

if ($tot_apa > 0) {
    ?>
        		<tr>
					<td colspan="2">APARTADO No <?php echo $apa ?> DEL <?php echo $fecha_de_apartado ?>:</td >
					<td align="right"><?php echo '$' . number_format($tot_apa, 0, ".", ".") ?></td>
					<td colspan="2">&nbsp;</td>
				</tr>
				<?php
}
?>
				<?php
if ($cod_apar) {
    //CONSULTA LOS ABONOS DEL APARTADO
    $dba  = new database();
    $sqla = "SELECT * FROM m_abono
        			WHERE cod_apa = $cod_apar";
    $dba->query($sqla);
    $tot_abono = 0;
    while ($dba->next_row()) {
        ?>
        		<tr>
					<td colspan="2">ABONO No <?php echo $dba->num_abo ?>:</td >
					<td align="right"><?php echo '$' . number_format($dba->tot_abo, 0, ".", ".") ?></td>
					<td colspan="2">&nbsp;</td>
				</tr>
        		<?php
$tot_abono = $tot_abono + $dba->tot_abo;
    }
}
?>
			    </tr>
				<?php
//CONSULTA BONO
$dbb1  = new database();
$sqlb1 = "SELECT * FROM bono
				INNER JOIN m_factura ON m_factura.bono_fac = bono.cod_bono
				INNER JOIN tipo_bono ON tipo_bono.cod_tbono = bono.tipo_bono
				WHERE cod_fac = $codigo";
$dbb1->query($sqlb1);
if ($dbb1->next_row()) {
    ?>
                <tr>
                  <td colspan='2'>BONO DE <?php echo $dbb1->nom_tbono ?> No <?php echo $dbb1->num_bono ?>:</td >
                  <td align="right"><?PHP echo '$' . number_format($dbb1->valor_bono, 0, ".", ".") ?></td>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <?php }?>
				<tr>
					<?php
$dbo  = new database();
$sqlo = "SELECT * FROM otros_pagos
					LEFT JOIN tarjeta ON tarjeta.cod_tarjeta = otros_pagos.cod_tarjeta
					LEFT JOIN tipo_pago ON tipo_pago.cod_tpag = otros_pagos.cod_tpag_otro
					WHERE cod_fac = $codigo";
$dbo->query($sqlo);
$tot_tar = 0;
while ($dbo->next_row()) {
    ?>
					<td colspan="2"><?php echo $dbo->nom_tpag ?></td >
					<td align="right"><?php echo '$' . number_format($dbo->val_otro, 0, ".", ".") ?><?php if ($dbo->num_auto) {
        echo 'AUT.' . $dbo->num_auto;
    }
    ?></td>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<?php }?>
				</tr>
                <tr >
                  <td   colspan='5' align='center'>VENDEDOR:<?php echo $vend ?></td >
				</tr>
			    <tr >
                  <td>&nbsp;</td >
                  <td>&nbsp;</td >
                  <td>&nbsp;</td >
				</tr>
				<?php
//CONSULTA DE BONO
$dbr  = new database();
$sqlr = "SELECT * FROM bono
				WHERE tipo_bono = 5 AND fac_bono = $codigo";
$dbr->query($sqlr);
if ($dbr->next_row()) {
    ?>
                <tr >
                  <td   colspan='5' align='center'>BONO RECOMPRA:<?php echo 'No. ' . $dbr->num_bono . ' Valor ' . number_format($dbr->valor_bono, 0, ".", ".") ?></td >
				</tr>
				<?
}
?>
				<?
if ($regimen == "Comun") {
    $base    = $total / 1.19;
    $iva_reg = $total - $base;
    ?>
			    <tr >
                  <td colspan='5'>&nbsp;</td >
				</tr>

				 <?
}
?>
                  <?
$sql = "select * from usuario WHERE cod_usu= $cod_usuario";
$db->query($sql);
if ($db->next_row()) {
    $usuario = $db->nom_usu;
    $obs     = $db->obs;
}
$sql = "SELECT SUM(total_pro) as total FROM d_factura WHERE cod_mfac= $codigo";
$db->query($sql);
if ($db->next_row()) {
    $total = $db->total;
}

?>
			  	</table>
			  </td >
		  </TR>
			<TR>

		  </TR>
			<TR>

		  </TR>


			<TR><td  colspan="2" align="left">

			<?
if (!empty($obs_fac)) {
    ?>
              <tr>
                <td >
				<div align="justify" >OBSERVACIONES:<br> <?=$obs_fac?>

                </div></td >
              </tr>
			<p>
			  <?
}
?>
			</p>
              <tr>
                <td ><div align="justify" >
                  <p>&nbsp;</p>
                </div>                </td >
              </tr>
			<br />
              <tr>
                <td  width="100%" align="center"><div align="center" ><?=$leyenda2?>
     			</div>
                  <?if ($tipo_pago == "Credito") {?>
                  <div align="center" >
                      <tr>
                        <td ><div align="center" >SELLO</div></td >
                      </tr>
                    <p>&nbsp;</p>
                  </div>
  <?}?>
  </td >
              </tr>
			</td >
  </table>
</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
