<?php
include("../lib/database.php");

//RECIBE LAS VARIABLES
$arreglo = $_REQUEST['arreglo'];
?>
<link href="styles.css" rel="stylesheet" type="text/css" />
<link href="../css/styles.css" rel="stylesheet" type="text/css">
<title>Cartera por Cliente</title>
<table width="700" border="1" cellpadding="2" cellspacing="1"   align="center" class="textoproductos1">
  <tr>
    <td  class="ctablasup" align="center"> CARTERA  POR CLIENTE </td>
  </tr>
  <tr>
    <td  width="100%"><br></td>
  </tr>
  <tr>
    <td  width="100%" ><?
$totalfacturacion=0;
$totalcorriente=0;
$total30=0;
$total60=0;
$total90=0;	
$codclientes = split("\,",$arreglo);  
for($g=0; $g<=count($codclientes); $g++)
{  
  $codCliente = $codclientes[$g]; 
  if ($codCliente!="") { 
	  $sqlg="SELECT DISTINCT iden_bod, CONCAT(nom_bod,' ',apel_bod) as nombre FROM bodega1  WHERE cod_bod=$codCliente";
	  $dbg= new  Database();
	  $dbg->query($sqlg);
	  while ($dbg->next_row()) { //inicio while de clientes
			$nombre=$dbg->nombre;
			$identificacion=$dbg->iden_bod;

			?>
      <table width="100%" border="1" cellpadding="2" cellspacing="1"  class="textoproductos1">
        <?
			$db = new Database();
			$sql=" 	SELECT 
			CF.cod_car_fac, CF.fec_car_fac, CF.cod_fac,  F.num_fac, F.cod_cli,  	
			(F.tot_fac  - ifnull(F.tot_dev_mfac,0)) AS saldo_neto, 
			(F.tot_fac  - ifnull(valor_abono,0) - ifnull(F.tot_dev_mfac,0)) AS saldo,  	
			datediff( curdate(), CF.fec_car_fac) AS dias,  
			bodega1.dias_credito AS dias_credito, 	
			DATE_ADD(CF.fec_car_fac,INTERVAL (SELECT dias_credito FROM bodega1 WHERE cod_bod=cod_cli) DAY) AS vecimiento,  	        
			datediff( curdate(), CF.fec_car_fac ) + 1 AS pasado 
			
			FROM cartera_factura  CF 	
			INNER JOIN m_factura F ON F.cod_fac=CF.cod_fac  
			INNER JOIN bodega1 ON F.cod_cli = bodega1.cod_bod	
			WHERE  ( CF.estado_car <>'CANCELADA' and  CF.estado_car <>'ANULADO' )  and  F.cod_cli=$codCliente   
			HAVING saldo >0	
			ORDER BY  CF.fec_car_fac,F.num_fac asc ";
	
			$db->query($sql);
			
			if ($db->num_rows() >0 ) {
			?>
        <tr>
          <td colspan="5" class="ctablasup"> CLIENTE:
            <?=$nombre?></td>
          <td colspan="6" class="ctablasup">IDENTIFICACION:
            <?=$identificacion?></td>
        </tr>
        <TR>
          <TD width="10%" height="16"class="subfongris">FECHA</TD>
          <TD width="6%" class="subfongris">N. FAC.</TD>
          <TD width="8%" class="subfongris">T. FAC.</TD>
          <TD width="8%" class="subfongris">S. FAC.</TD>
          <TD width="11%" class="subfongris" >F. VEN. </TD>
          <TD width="10%" class="subfongris" >DIAS CREDITO</TD>
          <TD width="10%" class="subfongris"> CARTERA CORRIENTE <br />
            (0-30)</TD>
          <TD width="10%" class="subfongris">31-60 dias</TD>
          <TD width="10%" class="subfongris">61-90 dias</TD>
          <TD width="10%" class="subfongris">91-mas dias</TD>
        </tr>
        <?
			}
			
			while($db->next_row()){ //while facturas
				$totalfacturacion= $totalfacturacion + $db->saldo;
				
				echo "<TR>";
				echo "<TD class='ctablablanc' >$db->fec_car_fac</TD>";
				echo "<TD class='ctablablanc' >$db->num_fac</TD>";
				echo "<TD class='ctablablanc' align='right'><div align='right'>".number_format($db->saldo_neto,0,".",".")."</div></TD>";
				echo "<TD class='ctablablanc' align='right'><div align='right'>".number_format($db->saldo,0,".",".")."</div></TD>";
				
				if (!empty($db->vecimiento))
					echo "<TD class='ctablablanc' align='right'>$db->vecimiento</TD>";
				else 
					echo "<TD class='ctablablanc' align='right'>&nbsp;</TD>";
				echo "<TD class='ctablablanc' >$db->dias_credito</TD>";
		
				if($db->pasado > 0 && $db->pasado <= 30) {
					echo "<TD class='ctablablanc' align='right'><div align='right'>".number_format($db->saldo,0,".",".")."</div></TD>";
					$totalcorriente = $totalcorriente + $db->saldo;
				}
				else {	
					echo "<TD class='ctablablanc' align='right'>&nbsp;</TD>";
				}
				if ($db->pasado > 30 && $db->pasado <= 60) {
					echo "<TD class='ctablablanc' align='right'><div align='right'>".number_format($db->saldo,0,".",".")."</div></TD>";
					$total30=$total30+$db->saldo;					
				}
				else {	
					echo "<TD class='ctablablanc' >&nbsp;</TD>";
				}
				if  ($db->pasado > 60 && $db->pasado <= 90){
					echo "<TD class='ctablablanc' align='right'><div align='right'>".number_format($db->saldo,0,".",".")."</div></TD>";
					$total60=$total60+$db->saldo;
				}
				else 	{
					echo "<TD class='ctablablanc' >&nbsp;</TD>";
				}	
				if($db->pasado > 90 ){
					echo "<TD class='ctablablanc' align='right'><div align='right'>".number_format($db->saldo,0,".",".")."</div></TD>";
					$total90=$total90+$db->saldo;
				}
				else 	{
					echo "<TD class='ctablablanc' >&nbsp;</TD>";
				}					
				echo "</TR>";
			} //fin del while facturas
	  ?>
      </table>
      <?
	  } //fin del while de clientes	

   } // fin del if
} // fin del for   		
	?>
    </td>
  </tr>
  <tr>
    <td height="16" colspan="11" class="subtitulosproductos">TOTAL FACTURAS:
      <?=number_format($totalfacturacion,0,".",".")?>
    </td>
  </tr>
  <tr>
    <td height="16" colspan="11" class="subtitulosproductos">TOTAL CORRIENTE:
      <?=number_format($totalcorriente,0,".",".")?></td>
  </tr>
  <tr>
    <td height="16" colspan="11" class="subtitulosproductos">TOTAL MAS 30 DIAS:
      <?=number_format($total30,0,".",".")?></td>
  </tr>
  <tr>
    <td height="16" colspan="11" class="subtitulosproductos">TOTAL  MAS 60 DIAS:
      <?=number_format($total60,0,".",".")?></td>
  </tr>
  <tr>
    <td height="16" colspan="11" class="subtitulosproductos">TOTAL MAS 90 DIAS:
      <?=number_format($total90,0,".",".")?></td>
  </tr>
  <tr>
    <td height="16" colspan="11" class="tituloproductos"><div align="center">
        <input name="button" type="button" class="botones"  onclick="window.print()" value="Imprimir" />
      </div></td>
  </tr>
</table>