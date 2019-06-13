<?php include("lib/database.php");?>
<?php include("js/funciones.php");?>
<link href="informes/styles.css" rel="stylesheet" type="text/css" />
<link href="informes/styles1.css" rel="stylesheet" type="text/css" />
<link href="styles.css" rel="stylesheet" type="text/css" />
<link href="css/stylesforms.css" rel="stylesheet" type="text/css" />
<link href="css/styles2.css" rel="stylesheet" type="text/css" />
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<TABLE width="100%" border="1" cellpadding="2" cellspacing="1"   class="textoproductos1">
  <tr>
    <td colspan="18" class="ctablasup"> CARTERA POR EDAD </td>
  </tr>
  <TR>
    <TD width="7%" height="16" class="subfongris">N    <TD width="5%" height="16"class="subfongris">FECHA</TD>
    <TD width="3%" class="subfongris">N. FAC.</TD>
    <TD width="5%" class="subfongris">T. FAC.</TD>
    <TD width="4%" class="subfongris">S. FAC.</TD>
    <TD width="6%" class="subfongris" >F. VEN. </TD>
    <TD width="5%" class="subfongris" >DIAS FACTURA</TD>
    <TD width="5%" class="subfongris" >DIAS CREDITO</TD>
    <TD width="5%" class="subfongris"> CARTERA CORRIENTE <br />
      (0-30)</TD>
    <TD width="5%" class="subfongris">31-60 dias</TD>
    <TD width="5%" class="subfongris">61-90 dias</TD>
    <TD width="13%" class="subfongris">91-mas dias</TD>
  </tr>
  <?
$db = new Database();
$sql="SELECT 
	CF.cod_car_fac, CF.fec_car_fac, 
	F.num_fac, 
	CONCAT(cliente.nom1_cli,apel1_cli) as nombre,  	
	cliente.plazo_cli, 	
	(F.tot_fac  - ifnull(F.tot_dev_mfac,0)) AS saldo_neto, 
	(F.tot_fac  - ifnull(valor_abono,0) - ifnull(F.tot_dev_mfac,0)) AS saldo,  	
	datediff( curdate(), CF.fec_car_fac) AS dias,  
	DATE_ADD(CF.fec_car_fac,INTERVAL (SELECT plazo_cli FROM cliente WHERE cod_bod=cod_cli) DAY) AS vecimiento,  
	DATE_ADD(DATE_ADD(CF.fec_car_fac,INTERVAL (SELECT plazo_cli FROM cliente WHERE cod_bod=cod_cli) DAY),INTERVAL (1) DAY) AS aviso_de,  
	DATE_ADD(DATE_ADD(CF.fec_car_fac,INTERVAL (SELECT plazo_cli FROM cliente WHERE cod_bod=cod_cli) DAY),INTERVAL (15) DAY) AS aviso_hasta,
	DATE_ADD(DATE_ADD(CF.fec_car_fac,INTERVAL (SELECT plazo_cli FROM cliente WHERE cod_bod=cod_cli) DAY),INTERVAL (16) DAY) AS recla_de, 
	DATE_ADD(DATE_ADD(CF.fec_car_fac,INTERVAL (SELECT plazo_cli FROM cliente WHERE cod_bod=cod_cli) DAY),INTERVAL (30) DAY) AS recla_hasta, 
	datediff( curdate(), CF.fec_car_fac ) + 1 AS pasado 
	
	FROM cartera_factura  CF 	
	INNER JOIN m_factura F ON F.cod_fac=CF.cod_fac  
	INNER JOIN cliente ON F.cod_cli = cliente.cod_cli
	WHERE  ( CF.estado_car <>'CANCELADA' and  CF.estado_car <>'ANULADO' )    
	HAVING saldo >0	
	ORDER BY  pasado asc, cliente.nom1_cli asc, F.num_fac, CF.fec_car_fac ";
	 
$totalfacturacion=0;
$totalcorriente=0;
$total30=0;
$total60=0;
$total90=0;
$db->query($sql);
while($db->next_row()){
		
		$totalfacturacion= $totalfacturacion + $db->saldo;
	
		echo "<TR>";
		echo "<TD class='ctablablanc' >$db->nombre</TD>";
		echo "<TD class='ctablablanc' >$db->fec_car_fac</TD>";
		echo "<TD class='ctablablanc' >$db->num_fac</TD>";
		echo "<TD class='ctablablanc' align='right'><div align='right'>".number_format($db->saldo_neto,0,".",".")."</div></TD>";
		echo "<TD class='ctablablanc' align='right'><div align='right'>".number_format($db->saldo,0,".",".")."</div></TD>";
		
		
		if (!empty($db->vecimiento))
				echo "<TD class='ctablablanc' align='right'>$db->vecimiento</TD>";
		else 
			echo "<TD class='ctablablanc' align='right'>&nbsp;</TD>";
			
		$dbd = new Database();
		$sqld="SELECT datediff( curdate(),'$db->vecimiento') AS dias
		FROM cartera_factura";
		$dbd->query($sqld);
		$dbd->next_row();
		
		echo "<TD class='ctablablanc' >$dbd->dias</TD>";		
		echo "<TD class='ctablablanc' >$db->plazo_cli</TD>";
			
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
}
	?>
	<tr>
    <td colspan="18" ><br /></td>
  </tr>
  <TR>
    <TD height="16" colspan="18" class="subtitulosproductos">TOTAL FACTURAS:
      <?=number_format($totalfacturacion,0,".",".")?></TD>
  </TR>
  <TR>
    <TD height="16" colspan="18" class="subtitulosproductos">TOTAL CORRIENTE:
      <?=number_format($totalcorriente,0,".",".")?></TD>
  </TR>
  <TR>
    <TD height="16" colspan="18" class="subtitulosproductos">TOTAL MAS DE 30 DIAS:
      <?=number_format($total30,0,".",".")?></TD>
  </TR>
  <TR>
    <TD height="16" colspan="18" class="subtitulosproductos">TOTAL  MAS DE 60 DIAS:
      <?=number_format($total60,0,".",".")?></TD>
  </TR>
  <TR>
    <TD height="16" colspan="18" class="subtitulosproductos">TOTAL MAS DE 90 DIAS:
      <?=number_format($total90,0,".",".")?></TD>
  </TR>
  <TD height="16" colspan="18" class="tituloproductos" align="center"><INPUT type="button" value="Imprimir" class="botones"  onclick="abrir()">
  </TR>
</TABLE>
<script>
function abrir(){
	window.print();
}
</script>