<?php
include("../lib/database.php");

//RECIBE LAS VARIABLES
$arreglo = $_REQUEST['arreglo'];
?>
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
<link href="styles.css" rel="stylesheet" type="text/css" />
<link href="../css/styles.css" rel="stylesheet" type="text/css">
<title>Abonos por Cliente</title>
<table width="645" border="1" cellpadding="2" cellspacing="1"  class="textoproductos1" align="center">
  <tr>
    <td colspan="5" class="ctablasup" align="center"> ABONOS  POR CLIENTE </td>
  </tr>
  <tr>
    <td  width="100%"><br></td>
  </tr>
  <tr>
    <td  width="100%" ><?
$codclientes = split("\,",$arreglo);  
$totalfacturacion = 0;
for($g=0; $g<=count($codclientes); $g++)
{  
  $codCliente = $codclientes[$g]; 
  if ($codCliente!="") { 
	  $sqlg="SELECT iden_bod, nom_bod FROM bodega1  WHERE cod_bod=$codCliente  and  cod_bod in (select distinct cod_bod_Abo from abono )";
	  $dbg= new  Database();
	  $dbg->query($sqlg);
	  while ($dbg->next_row()) { //inicio while de clientes
			  $nombre=$dbg->nom_bod;
			  $identificacion=$dbg->iden_bod;
			  $total_cliente=0;
			 ?>
      <table width="100%" border="1" cellpadding="2" cellspacing="1"  class="textoproductos1">
        <tr>
          <td colspan="5" class="ctablasup"> CLIENTE :
            <?=$identificacion?>
            -
            <?=$nombre?></td>
        </tr>
        <tr>
          <td width="17%" height="16" class="botones1">FECHA</td>
          <td width="25%" class="botones1">VALOR</td>
          <td width="10%" class="botones1">N. ABONO</td>
		  <td width="23%" class="botones1">OBSERVACION</td>
          <td width="15%" colspan="2" class="botones1">OPCION</td>
        </tr>
        <?
		$db = new Database();
		
		$sql=" SELECT 
			  abono.cod_abo,
			  abono.val_abo,
			  abono.observacion,
			  abono.fec_abo
			FROM
			  abono
			  INNER JOIN bodega1 ON (abono.cod_bod_Abo = bodega1.cod_bod)
			WHERE
			  abono.cod_bod_Abo=$codCliente ORDER BY fec_abo DESC";
				
		$db->query($sql);
		$total_cliente=0;

		while($db->next_row()){
			$total_cliente+= $db->val_abo ;
			echo "<TR>";
			echo "<TD class='ctablablanc' >$db->fec_abo</TD>";
			echo "<TD class='ctablablanc' ><div align='right'>".number_format($db->val_abo,0,".",".")."</div></TD>";
			echo "<TD class='ctablablanc' >$db->cod_abo</TD>";	
			echo "<TD class='ctablablanc' >$db->observacion</TD>";		
			echo "<td align='center'><img src='../imagenes/mirar.png' width='16' height='16'  style=\"cursor:pointer\" onClick=\"imprimir_factura('ver_abono.php',$db->cod_abo,'mediano')\" /></td>";	
			echo "</TR>";
		}
		$totalfacturacion += $total_cliente; 
	?>
        <tr>
          <td height="16" colspan="5" class="subtitulosproductos"><b>TOTAL ABONOS DEL CLIENTE:
            <?=number_format($total_cliente,0,".",".")?>
            </b> </td>
        </tr>
        <?
	  } //del while de clientes
   } // del if
} //del for  
?>
      </table></td>
  </tr>
  <tr>
    <td height="16" colspan="5" class="subtitulosproductos"><b>TOTAL ABONOS:
      <?=number_format($totalfacturacion,0,".",".")?>
      </b> </td>
  </tr>
  <tr>
    <td height="16" colspan="5" class="tituloproductos"><div align="center">
        <input name="button" type="button" class="botones"  onclick="window.print()" value="Imprimir" />
      </div></td>
  </tr>
</table>