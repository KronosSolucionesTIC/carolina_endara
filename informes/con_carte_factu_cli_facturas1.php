<?php
include("../lib/database.php");

//RECIBE LAS VARIABLES
$arreglo = $_REQUEST['arreglo'];
?>
<link href="styles.css" rel="stylesheet" type="text/css" />
<link href="../css/styles.css" rel="stylesheet" type="text/css">
<title>Facturacion por Cliente</title>
<script language="javascript">
function imprimir_factura(ruta,codigo,tamano){
	var ancho=0;
	var alto=0;
		
	if(tamano=="mediano") {
		ancho=900;
		alto=600;
	}
	
	if(tamano=="grande") {
		ancho=900;
		alto=700;
	}
	
	var marginleft = (screen.width - ancho) / 2;
	var margintop = (screen.height - alto) / 2;
	propiedades = 'menubar=0,resizable=1,height='+alto+',width='+ancho+',top='+margintop+',left='+marginleft+',toolbar=0,scrollbars=yes';
	window.open(""+ruta+"?codigo="+codigo,"factura",propiedades)
}
</script>

<table width="644" border="1" align="center" cellpadding="2" cellspacing="1"   class="textoproductos1">
  <tr>
    <td  class="ctablasup" align="center"> FACTURACION  POR CLIENTE </td>
  </tr>
  <tr>
    <td  width="100%"><br></td>
  </tr>
  <tr>
    <td  width="100%" ><?
$codclientes = split("\,",$arreglo);  
for($g=0; $g<=count($codclientes); $g++)
{  
  $codCliente = $codclientes[$g]; 
  if ($codCliente!="") { 
	  $sqlg="SELECT DISTINCT iden_bod, nom_bod FROM bodega1  WHERE cod_bod=$codCliente";
	  $dbg= new  Database();
	  $dbg->query($sqlg);
	  while ($dbg->next_row()) { //inicio while de clientes
			  $nombre=$dbg->nom_bod;
			  $identificacion=$dbg->iden_bod;
			  $total_cliente=0;
			 ?>
      <table width="100%" border="1" cellpadding="2" cellspacing="1"  class="textoproductos1">
        <tr>
          <td colspan="6" class="ctablasup"> CLIENTE :
            <?=$identificacion?> - <?=$nombre?></td>
        </tr>
        <td width="17%" height="16" class="botones1">FECHA</td>
          <td width="20%" height="16" class="botones1">TIPO DE PAGO </td>
          <td width="25%" class="botones1">VALOR</td>
          <td width="23%" class="botones1">N. FAC.</td>
          <td width="15%" colspan="2" class="botones1">OPCION</td>
        </tr>
        <?
			$db = new Database();
			$sql=" SELECT 
				  F.fecha, 
				 F.num_fac, 
				 F.tipo_pago, 
				 F.tot_fac, 
				 F.tot_dev_mfac, 
				 F.cod_fac
				FROM m_factura F
				INNER  JOIN bodega1 ON ( F.cod_cli = bodega1.cod_bod ) 
				WHERE   F.cod_cli=$codCliente AND F.estado IS NULL
				ORDER BY   F.fecha ASC";
		
			$totalfacturacion=0;
			$db->query($sql);
			while($db->next_row()){
			    $saldo = $db->tot_fac - $db->tot_dev_mfac;
				$total_cliente += $saldo;
				if ( $saldo >0) {
					echo "<TR>";
					echo "<TD class='ctablablanc' >$db->fecha</TD>";
					echo "<TD class='ctablablanc' >$db->tipo_pago</TD>";
					echo "<TD class='ctablablanc' ><div align='right'>".number_format($saldo,0,".",".")."</div></TD>";
					echo "<TD class='ctablablanc' >$db->num_fac</TD>";			
					echo "<td align='center'><img src='../imagenes/mirar.png' width='16' height='16'  style=\"cursor:pointer\" onClick=\"imprimir_factura('ver_factura_v.php',$db->cod_fac,'grande')\" /></td>";	
					echo "</TR>";	
				}
			}
			?>
        <tr>
          <td height="16" colspan="6" class="subtitulosproductos"><b>TOTAL FACTURACION CLIENTE:
            <?=number_format($total_cliente,0,".",".")?>
            </b></td>
        </tr>
      </table>
      <?
	  } //fin del while de clientes
	  $totalfacturacion= $totalfacturacion + $total_cliente;

   } // fin del if
} // fin del for   		
	?>
    </td>
  </tr>
  <tr>
    <td height="16" colspan="6" class="subtitulosproductos"><b>TOTAL FACTURACION:
      <?=number_format($totalfacturacion,0,".",".")?>
      </b></td>
  </tr>
  <tr>
    <td height="16" colspan="6" class="tituloproductos"><div align="center">
        <input name="button" type="button" class="botones"  onclick="window.print()" value="Imprimir" />
      </div></td>
  </tr>
</table>