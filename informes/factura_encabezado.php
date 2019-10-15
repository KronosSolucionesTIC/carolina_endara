<tr>
  <td colspan="5"><img src='../imagenes/logo.jpg' width='100%' align="center"></td>
</tr>
<tr>
  <td colspan="5"><div align="center"><?php echo $razon ?></div></td>
</tr>
<tr>
  <td colspan="5"><div align="center">NIT <?php echo $nit ?> / IVA REGIMEN COMUN</div></td>
</tr>
<tr>
  <td colspan="5"><div align="center"><?php echo $direccion ?></div></td>
</tr>
<tr>
  <td colspan="5"><div align="center">TELEFONOS: <?php echo $telefono ?></div></td>
</tr>
<tr>
  <td  colspan="5">&nbsp;</td >
</tr>
<tr>
  <td  colspan="5" align='center'>
    <?php if ($rem_fac == "remision") {echo " Remision:";}?>
    <?php if ($rem_fac == "factura") {echo " Factura de venta:";}?>
    <?php
if ($es_abono != "si") {
    ?>
    FACTURA DE VENTA No:
    <?php
if ($tipo_fac == 'B') {
        echo '* ' . $fac_numero;
    } else {
        echo $fac_numero;
    }
}
?>
  </td>
</tr>
<tr>
  <td  ALIGN='center' colspan="5">FECHA:<?php echo $fac_fecha; ?></td>
</tr>
<tr>
  <td colspan="5"><div align="justify"><?php echo $leyenda ?></div></td>
</tr>