<?
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

<?
if($estado_factura=="anulado")
  $anulacion="background='../imagenes/anulacion.gif'";
?>
<TABLE  border="0" cellpadding="0" cellspacing="0"  width="50%" <?=$anulacion?> class='Estilo3'>
<tr>
  <td colspan='3' align='center'>INFORME REMISION DEL <?php echo $fecha_ini?> AL <?php echo $fecha_fin?></td>
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
<?PHP
  $tot_fac = 0;
  $data = 0;
  $efe = 0;
  $bd = new database();
  $sql = "SELECT *,DATE(DATE(FECHA)) as fec FROM m_factura
  INNER JOIN otros_pagos ON otros_pagos.cod_fac = m_factura.cod_fac
  LEFT JOIN tarjeta ON tarjeta.cod_tarjeta = otros_pagos.cod_tarjeta
  HAVING (fec >= '$fecha_ini') AND (fec <= '$fecha_fin') AND estado is null
  ORDER BY tipo_fac";
  $db->query($sql);
  while($db->next_row()){
?>
<tr>
  <td><?php echo $db->num_fac?></td>
  <td>
  <?php 
    if($db->nom_tarjeta != ''){
      echo $db->nom_tarjeta;
      $data = $data + $db->val_otro;
    } else {
      echo 'EFECTIVO';
      $efe = $efe + $db->val_otro;
    }
  ?>
  </td>
  <td align='right'>  <?php 
    if($db->nom_tarjeta != ''){
      echo number_format($db->val_otro,'','','.');
    } else {
      echo number_format($db->val_otro,'','','.');
    }
  ?></td>
</tr>
<?php 
  if($db->tipo_pago == 'Credito'){
    $credito = $credito + $db->tot_fac;
  }

    //SUMA LOS TOTALES
      $tot_fac = $tot_fac + $db->val_otro;
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
  <td align='right'><?php echo number_format($tot_fac,'','','.')?></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<?php
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
  <td align='right'><?php echo number_format($data,'','','.')?></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>Efectivo</td>
  <td>&nbsp;</td>
  <td align='right'><?php echo number_format($efe,'','','.')?></td>
</tr>
<?php
  $dba = new database();
  $sqla = "SELECT * FROM m_abono
  WHERE (fecha >= '$fecha_ini') AND (fecha <= '$fecha_fin')";
  $dba->query($sqla);
  if($dba->next_row()){
 ?>
<tr>
  <td>&nbsp;</td>
  <td>ABONOS</td>
  <td>&nbsp;</td>
</tr>
<? } ?>
<?php
  $dba = new database();
  $sqla = "SELECT * FROM m_abono
  WHERE (fecha >= '$fecha_ini') AND (fecha <= '$fecha_fin')";
  $dba->query($sqla);
  while($dba->next_row()){
    if($dba->tipo_pago == 2){
      $abo_efec = $abo_efec + $dba->val_abo;
    }else{
      $abo_data = $abo_data + $dba->val_abo;
    }
      $tot_abo = $tot_abo + $dba->val_abo;
  }

  if($dba->next_row()){
?>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>Efectivo</td>
  <td>&nbsp;</td>
  <td align='right'><?php echo number_format($abo_efec,'','','.')?></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>Datafono</td>
  <td>&nbsp;</td>
  <td align='right'><?php echo number_format($abo_data,'','','.')?></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>TOTAL ABONOS</td>
  <td>&nbsp;</td>
  <td align='right'><?php echo number_format($tot_abo,'','','.')?></td>
</tr>
<?php } ?>
<?php
  $dbv= new database();
  $sqlv = "SELECT * FROM m_abono
  WHERE (fecha >= '$fecha_ini') AND (fecha <= '$fecha_fin')";
  $dbv->query($sqlv);
  while($dbv->next_row()){
    if($dbv->tipo_pago == 2){
      $abo_efec = $abo_efec + $dbv->val_abo;
    }else{
      $abo_data = $abo_data + $dbv->val_abo;
    }
      $tot_abo = $tot_abo + $dbv->val_abo;
  }

  if($dbv->next_row()){
?>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>Efectivo</td>
  <td>&nbsp;</td>
  <td align='right'><?php echo number_format($abo_efec,'','','.')?></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>Datafono</td>
  <td>&nbsp;</td>
  <td align='right'><?php echo number_format($abo_data,'','','.')?></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>TOTAL BONOS VENTA</td>
  <td>&nbsp;</td>
  <td align='right'><?php echo number_format($tot_abo,'','','.')?></td>
</tr>
<?php } ?>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<?php
  $dbg = new database();
  $sqlg = "SELECT * FROM gastos
  INNER JOIN tipo_gastos ON tipo_gastos.cod_gas = gastos.tipo_gasto
  WHERE (fecha_gasto >= '$fecha_ini') AND (fecha_gasto <= '$fecha_fin')";
  $dbg->query($sqlg);
  if($dbg->next_row()){
?>
<tr>
  <td>&nbsp;</td>
  <td>GASTOS</td>
  <td>&nbsp;</td>
</tr>
<?php
  $dbg = new database();
  $sqlg = "SELECT * FROM gastos
  INNER JOIN tipo_gastos ON tipo_gastos.cod_gas = gastos.tipo_gasto
  WHERE (fecha_gasto >= '$fecha_ini') AND (fecha_gasto <= '$fecha_fin')";
  $dbg->query($sqlg);
  while($dbg->next_row()){
?>
<tr>
  <td><?php echo $dbg->nom_gas ?></td>
  <td>&nbsp;</td>
  <td align='right'><?php echo number_format($dbg->valor_gasto,'','','.')?></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<?php 
  $tot_gas = $tot_gas + $dbg->valor_gasto;
  } 
?>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>TOTAL GASTOS</td>
  <td>&nbsp;</td>
  <td align='right'><?php echo number_format($tot_gas,'','','.')?></td>
</tr>
<?php } ?>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<?php
  $efectivo = $tot_fac - $data + $abo_efec - $tot_gas ;
  $datafono = $data + $abo_data;
?>
<tr>
  <td>EFECTIVO FINAL</td>
  <td>&nbsp;</td>
  <td align='right'><?php echo number_format($efectivo,'','','.')?></td>
</tr>
<tr>
  <td>DATAFONO FINAL</td>
  <td>&nbsp;</td>
  <td align='right'><?php echo number_format($datafono,'','','.')?></td>
</tr>
</TABLE>