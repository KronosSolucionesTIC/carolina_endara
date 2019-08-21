  <tr>
    <td colspan="5">CLIENTE:
    <?php
$db_cliente = new Database();
$db_fecha   = new Database();
$sql        = 'select * from cliente
      where cod_cli = ' . $codigo_salida;
$db_cliente->query($sql);
if ($db_cliente->next_row()) {
    ?>
              <?php $nombre = $db_cliente->nom1_cli . ' ' . $db_cliente->nom2_cli . ' ' . $db_cliente->apel1_cli . ' ' . $db_cliente->apel2_cli;?>
                    <?php if ($db_cliente->digito_cli != '') {?>
                    <?php $identificacion = $db_cliente->iden_cli?>
                    <?php } else {?>
                    <?php $identificacion = $db_cliente->iden_cli?>
                    <?php }?>
              <?php echo $nombre; ?>
    </td>
  </tr>
  <tr>
    <td colspan="5">NIT/C.C.:<?php echo $identificacion; ?></td>
  </tr>
  <tr>
    <td colspan="5">TELEFONO:<?php echo $db_cliente->tel_cli; ?></td>
  </tr>
  <tr>
    <td colspan="5">CELULAR:<?php echo $db_cliente->cel1_cli; ?></td>
  </tr>
  <?php }?>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>