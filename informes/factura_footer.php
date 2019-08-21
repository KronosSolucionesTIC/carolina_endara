<?php
if (!empty($obs_fac)) {
    ?>
  <tr>
    <td colspan="5">
      <div align="justify" >OBSERVACIONES:<br> <?=$obs_fac?></div>
    </td>
  </tr>
        <?
}
?>

<tr>
  <td colspan="5"><div align="justify" ><p>&nbsp;</p></div></td>
</tr>

<tr>
  <td colspan="5" width="100%" align="center">
    <div align="center" >
      <?=$leyenda2?>
    </div>
  </td>
</tr>
  <?php if ($tipo_pago == "Credito") {?>
  <tr>
    <td colspan="5">
      <div align="center" >SELLO</div>
    </td>
  </tr>
  <?}?>