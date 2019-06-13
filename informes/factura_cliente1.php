<link href="../css/styles.css" rel="stylesheet" type="text/css" />
 <link href="../css/styles1.css" rel="stylesheet" type="text/css" />
 <link href="../css/styles2.css" rel="stylesheet" type="text/css" />

<style type="text/css">
<!--
.Estilo12 {
	font-size: 14px;
	font-family: "Lucida Console";
}
-->
</style>
<table width="300" border="0">
  <tr>
    <td width="23%"><span class="Estilo12">Vendido a : </span></td>
    <td width="77%"><span class="Estilo12">
      <?
		  	$db_cliente = new Database();
			$db_fecha = new Database();
			$sql ='select * from cliente 
			INNER JOIN ciudad ON (ciudad.cod_ciudad = cliente.ciu_cli)
			where cod_cli = '.$codigo_salida;
			$db_cliente->query($sql);
			if($db_cliente->next_row()){ 
				
				$sql_fecha="select date_add('$fac_fecha',INTERVAL $db_cliente->plazo_cli DAY ) as fecha_vencimineto_factura";
				$db_fecha->query($sql_fecha);
				if($db_fecha->next_row()){ 
					$fecha_vencimineto_factura=$db_fecha->fecha_vencimineto_factura;
				}	
				
			?>
      <? $nombre = $db_cliente->nom1_cli.$db_cliente->apel1_cli?>
      <? echo $nombre; ?> </span></td>
  </tr>
  <tr>
    <td><span class="Estilo12">Nit/C.C.:</span></td>
    <td><span class="Estilo12"><? echo $db_cliente->iden_cli; ?></span></td>
  </tr>
  <tr>
    <td><span class="Estilo12">Direccion:</span></td>
    <td><span class="Estilo12"><? echo $db_cliente->dir_cli;?></span></td>
  </tr>
  <tr>
    <td><span class="Estilo12">Telefono</span></td>
    <td><span class="Estilo12"><? echo $db_cliente->tel_cli;?></span></td>
  </tr>
  <tr>
    <td><span class="Estilo12">Ciudad</span></td>
    <td class="textoproductos1"><span class="Estilo12"><? echo $db_cliente->desc_ciudad;?></span></td>
    <? } ?>
  </tr>
</table>
