<?php 
include "../lib/sesion.php";
include("../lib/database.php");
include("../conf/clave.php");  

//RECIBE VARIABLES
$fecha_ini = $_REQUEST['fec_ini'];
$fecha_fin = $_REQUEST['fec_fin'];     
?>
<script language="javascript">
function imprimir(){
  document.getElementById('imp').style.display="none";
  document.getElementById('cer').style.display="none";
  window.print();
}
</script>
<title>CIERRE DE FACTURACION</title>
<style type="text/css">
<!--
.Estilo3 {
  font-size: 11px;
  font-family: "verdana";
  margin: 0px;
    padding: 0px;
}
-->
</style>

<?php 
if($estado_factura=="anulado")
  $anulacion="background='../imagenes/anulacion.gif'";
?>
<TABLE  border="0" cellpadding="0" cellspacing="0"  width="100%" <?php =$anulacion?> class='Estilo3'>
<?php php
//CONSULTA LOS DATOS DE LA EMPRESA
$db_fac = new database();
$sql_fac = "SELECT * FROM rsocial LIMIT 1";
$db_fac->query($sql_fac);
$db_fac->next_row();

  $razon=$db_fac->nom_rso;
  $nit=$db_fac->nit_rso;
?>
          <tr>
            <td colspan="3"><div align="center"><span class="Estilo3"><?php =$razon?></span></div></td>
          </tr>
          <tr>
            <td colspan="3"><div align="center"><span class="Estilo3">NTI <?php =$nit?> / IVA REGIMEN COMUN</span></div></td>
          </tr>
<tr>
  <td colspan='3' align='center'>CIERRE CAJA DEL <?php php echo $fecha_ini?> AL <?php php echo $fecha_fin?></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>FACTURA</td>
  <td>TIPO PAGO</td>
  <td align='right'>VALOR</td>
</tr>
<?php PHP
  $tot_fac = 0;
  $data = 0;
  $efe = 0;
  $bd = new database();
  $sql = "SELECT *,DATE(DATE(FECHA)) as fec FROM m_factura
  INNER JOIN otros_pagos ON otros_pagos.cod_fac = m_factura.cod_fac
  INNER JOIN tarjeta ON tarjeta.cod_tarjeta = otros_pagos.cod_tarjeta
  HAVING (fec >= '$fecha_ini') AND (fec <= '$fecha_fin') AND tipo_fac = 'A'";
  $db->query($sql);
  while($db->next_row()){
?>
<tr>
  <td><?php php echo $db->num_fac?></td>
  <td>
  <?php php 
    if($db->nom_tarjeta != ''){
      echo $db->nom_tarjeta;
      $data = $data + $db->val_otro;
    } else {
      echo 'EFECTIVO';
      $efe = $efe + $db->tot_fac - $db->val_otro;
    }
  ?>
  </td>
  <td align='right'>
  <?php php 
    if($db->nom_tarjeta != ''){
      echo number_format($db->val_otro,'','','.');
    } else {
      echo number_format($db->tot_fac,'','','.');
    }
  ?>
  </td>
</tr>
<?php php 
  if($db->tipo_pago == 'Credito'){
    $credito = $credito + $db->tot_fac;
  }

    //SUMA LOS TOTALES
    if($db->nom_tarjeta != ''){
      $tot_fac = $tot_fac + $db->val_otro;
    } else {
      $tot_fac = $tot_fac + $db->tot_fac;
    }
  } 
?>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>Total facturacion</td>
  <td>&nbsp;</td>
  <td align='right'><?php php echo number_format($tot_fac,'','','.')?></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<?php php
  $dbd = new database();
  $sqld = "SELECT * FROM otros_pagos
  WHERE (fec_otro >= '$fecha_ini') AND (fec_otro <= '$fecha_fin')";
  $dbd->query($sqld);
  while($dbd->next_row()){
    if($dbd->cod_tpag_otro == 5){
      $datafono = $datafono + $dbd->val_otro;
    }
  }
?>
<tr>
  <td>Datafono</td>
  <td>&nbsp;</td>
  <td align='right'><?php php echo number_format($data,'','','.')?></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>Efectivo</td>
  <td>&nbsp;</td>
  <td align='right'><?php php echo number_format($efe,'','','.')?></td>
</tr>
<?php php
  $efectivo = $tot_fac - $data;
  $datafono = $data ;
?>
</TABLE>