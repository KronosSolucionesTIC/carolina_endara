<style type="text/css">
<!--
.Estilo12 {
	font-size: 14px;
	font-family: "Lucida Console";
}
.Estilo46 {font-size: 12px}
-->
</style>

<table width="277" border="0" >
  <tr>
    <td colspan="3"><span class="Estilo12">
      <? if ($rem_fac=="remision") { echo " Remision:"; } ?>
      <? if ($rem_fac=="factura") { echo " Factura de venta:"; } ?>
	<? if($es_abono!="si"){?>
	<span class="Estilo12">Factura       No:<? echo $fac_numero; ?></span></span>
	<?  }  ?>  
      </td>
  </tr>
  <tr>
    <td colspan="2"><span class="Estilo12">Fecha:<? echo $fac_fecha; ?></span></td>
    <td width="57%"><span class="Estilo12">
	<? if($es_abono!="si"){?>
	Tipo Pago :<? echo $tipo_pago; ?>
	<?  }  ?>
	</span></td>
  </tr>
  <? if($tipo_pago == "Credito"){?>
  <tr>
    <td><span class="Estilo12">Fecha de vencimiento:</span></td>
    <td colspan="2"><span class="Estilo12"><?=$fac_fecha_vence?></span></td>
  </tr>
  <?  }  ?>
  <tr>
    <td width="21%"><span class="Estilo12">Nombre: </span></td>
    <td colspan="2"><span class="Estilo12">
      <?=$razon?>
    </span></td>
  </tr>
  <tr>
    <td><span class="Estilo12">Nit:</span></td>
    <td colspan="2"><span class="Estilo12">
      <?=$nit?>
    </span></td>
  </tr>
  <tr>
    <td><span class="Estilo12">Direccion:</span></td>
    <td colspan="2"><span class="Estilo12">
      <?=$direccion?>
    </span></td>
  </tr>
  <tr>
    <td><span class="Estilo12">Telefono</span></td>
    <td colspan="2"><span class="Estilo12">
      <?=$telefono?>
    </span></td>
  </tr>
  <tr>
    <td colspan="3"><span class="Estilo12" >
	<table width="238" border="0" >
	<tr>
	<td>
	<span class="Estilo12">
      <?=$leyenda?>
	 </span>	</td>
	</tr>
	 </table>
    </span></td>
  </tr>
</table>
