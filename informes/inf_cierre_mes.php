<?
include "../lib/sesion.php";
include("../lib/database.php");
include("../js/funciones.php");


if($guardar==1) { // RUTINA PARA INSERTAR REGISTROS NUEVOS

	$ano = substr($fecha,0,-6);
	$mes = substr($fecha,-4,2);
	$mes = $mes + 1;
	$dia = 1;
	$fec = $ano.'-'.$mes.'-'.$dia;
	$campos="(fec_emi,fec_venci,tipo_mov)";
	$valores="('".$fec."','".$fec."','5')" ;
	$ins_id=insertar_maestro("m_movimientos",$campos,$valores); 
	
	$campos="(cod_mov,cuenta_dmov,concepto_dmov,debito_dmov,credito_dmov,cod_ter)";
	for ($ii=1 ;  $ii <= $val_inicial ; $ii++) 
		{			
			$valores="('".$ins_id."','".$_POST["cod_auxiliar_".$ii]."','35','".$_POST["debito_".$ii]."','".$_POST["credito_".$ii]."','4')";	
			$error=insertar("d_movimientos",$campos,$valores);
			
			//NIVEL 4
			//TOMA LOS 6 PRIMEROS CARACTERES DEL CODIGO CONTABLE DE LA CUENTA
			$cod_cuenta = $_POST["cod_auxiliar_".$ii];
			$dbc = new Database();
			$sqlc = "SELECT substring(cod_contable,1,6) as cadena FROM cuenta
			WHERE cod_cuenta = $cod_cuenta";
			$dbc->query($sqlc);
			$dbc->next_row();
			$cod = $dbc->cadena;
			
			//BUSCA EL CODIGO DE LA CUENTA MAYOR
			$dbcm = new Database();
			$sqlcm = "SELECT cod_cuenta FROM cuenta
			WHERE cod_contable = $cod";
			$dbcm->query($sqlcm);
			$dbcm->next_row();
			$cuenta = $dbcm->cod_cuenta;
			
			//INGRESA REGISTROS DEL NIVEL 4
			$valores="('".$ins_id."','".$cuenta."','35','".$_POST["debito_".$ii]."','".$_POST["credito_".$ii]."','4')";					
			$error=insertar("d_movimientos",$campos,$valores);
			
			
			//NIVEL 3
			//TOMA LOS 4 PRIMEROS CARACTERES DEL CODIGO CONTABLE DE LA CUENTA
			$cod_cuenta = $_POST["cod_auxiliar_".$ii];
			$dbc = new Database();
			$sqlc = "SELECT substring(cod_contable,1,4) as cadena FROM cuenta
			WHERE cod_cuenta = $cod_cuenta";
			$dbc->query($sqlc);
			$dbc->next_row();
			$cod = $dbc->cadena;
			
			//BUSCA EL CODIGO DE LA CUENTA MAYOR
			$dbcm = new Database();
			$sqlcm = "SELECT cod_cuenta FROM cuenta
			WHERE cod_contable = $cod";
			$dbcm->query($sqlcm);
			$dbcm->next_row();
			$cuenta = $dbcm->cod_cuenta;
			
			//INGRESA REGISTROS DEL NIVEL 3
			$valores="('".$ins_id."','".$cuenta."','35','".$_POST["debito_".$ii]."','".$_POST["credito_".$ii]."','4')";					
			$error=insertar("d_movimientos",$campos,$valores);
			
			//NIVEL 2
			//TOMA LOS 2 PRIMEROS CARACTERES DEL CODIGO CONTABLE DE LA CUENTA
			$cod_cuenta = $_POST["cod_auxiliar_".$ii];
			$dbc = new Database();
			$sqlc = "SELECT substring(cod_contable,1,2) as cadena FROM cuenta
			WHERE cod_cuenta = $cod_cuenta";
			$dbc->query($sqlc);
			$dbc->next_row();
			$cod = $dbc->cadena;
			
			//BUSCA EL CODIGO DE LA CUENTA MAYOR
			$dbcm = new Database();
			$sqlcm = "SELECT cod_cuenta FROM cuenta
			WHERE cod_contable = $cod";
			$dbcm->query($sqlcm);
			$dbcm->next_row();
			$cuenta = $dbcm->cod_cuenta;
			
			//INGRESA REGISTROS DEL NIVEL 2
			$valores="('".$ins_id."','".$cuenta."','35','".$_POST["debito_".$ii]."','".$_POST["credito_".$ii]."','4')";					
			$error=insertar("d_movimientos",$campos,$valores);
			
			//NIVEL 1
			//TOMA EL 1 PRIMER CARACTER DEL CODIGO CONTABLE DE LA CUENTA
			$cod_cuenta = $_POST["cod_auxiliar_".$ii];
			$dbc = new Database();
			$sqlc = "SELECT substring(cod_contable,1,1) as cadena FROM cuenta
			WHERE cod_cuenta = $cod_cuenta";
			$dbc->query($sqlc);
			$dbc->next_row();
			$cod = $dbc->cadena;
			
			//BUSCA EL CODIGO DE LA CUENTA MAYOR
			$dbcm = new Database();
			$sqlcm = "SELECT cod_cuenta FROM cuenta
			WHERE cod_contable = $cod";
			$dbcm->query($sqlcm);
			$dbcm->next_row();
			$cuenta = $dbcm->cod_cuenta;
			
			//INGRESA REGISTROS DEL NIVEL 1
			$valores="('".$ins_id."','".$cuenta."','35','".$_POST["debito_".$ii]."','".$_POST["credito_".$ii]."','4')";					
			$error=insertar("d_movimientos",$campos,$valores);
			
		}
		
	if ($error == 1) {
		echo "<script language='javascript'> alert('Cierre de mes realizado') </script>" ;
		echo "<script language='javascript'> window.close ();</script>" ;
	}
	else
		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ;
}
?>


<script language="javascript">
function imprimir(){
	document.getElementById('imp').style.display="none";
	document.getElementById('cer').style.display="none";
	window.print();
}

function datos_completos(){ 
	return true;	
}
</script>
<script type="text/javascript" src="../js/funciones.js"></script>
 <link href="styles.css" rel="stylesheet" type="text/css" />
 <link href="../styles.css" rel="stylesheet" type="text/css" />
 <link href="../css/styles.css" rel="stylesheet" type="text/css" />
 <link href="../css/stylesforms.css" rel="stylesheet" type="text/css" />
 <title><?=$nombre_aplicacion?> -- CIERRE DE MES --</title>
 <style type="text/css">
<!--
.Estilo4 {font-size: 18px}
-->
 </style>
 <body <?=$sis?>>
<form  name="forma" id="forma" action="inf_cierre_mes.php"  method="post">
 <TABLE width="100%" border="0" cellspacing="0" cellpadding="0"   >
 <?=$credito?>
	
	<TR>
		<TD align="center">
		<TABLE width="98%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" >
		
			<INPUT type="hidden" name="fecha" id="fecha" value="<?=$fec_fin?>">
			<INPUT type="hidden" name="id" value="<?=$id?>">

			<TR>
			  <TD width="100%" class='txtablas'>
			  <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#333333">
			  	<tr>
			  		<td width="47%" height="26"><div align="center"><span class="Estilo4">CIERRE DE MES DE <?=$fec_ini?> HASTA <?=$fec_fin?></span></div></td>
			    </tr>
				</table>					</TD>
		  </TR>
			
			
			<TR>
			  <TD align="center">
			  <table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="#333333" id="select_tablas" >
                
				  <tr >
            <td width="9%"  class="botones1"><div align="center">CUENTA</div></td>
            <td width="34%"  class="botones1"><div align="center">NOMBRE DE LA CUENTA</div></td>
            <td width="16%"  class="botones1"><div align="center">DEBITO INICIAL</div></td>
            <td width="16%"  class="botones1"><div align="center">CREDITO INICIAL</div></td>
            <td width="14%"  class="botones1"><div align="center">DEBITOS</div></td>
            <td width="13%"  class="botones1"><div align="center">CREDITOS</div></td>
            <td width="14%"  class="botones1"><div align="center">DEBITO NUEVO</div></td>
			<td width="14%"  class="botones1"><div align="center">CREDITO NUEVO</div></td>
            </tr>
				<?
				//INICIA CONTADOR DE REGISTROS
				$jj = 0;
				$db = new Database ();
				$sql = "SELECT * FROM cuenta
				INNER JOIN d_movimientos ON d_movimientos.cuenta_dmov = cuenta.cod_cuenta
				INNER JOIN m_movimientos ON m_movimientos.cod_mov = d_movimientos.cod_mov
				WHERE (fec_emi >='$fec_ini') AND (fec_emi <='$fec_fin') AND(cod_contable LIKE '1%')or(cod_contable LIKE '5%')or(cod_contable LIKE '6%') AND estado_mov = 1
				GROUP BY cod_cuenta
				ORDER BY  `cuenta`.`cod_contable` ASC";
				$db->query($sql);
				$estilo="formsleo";
				while($db->next_row()){
					if($db->nivel == 5){
						$jj++;
					}

                echo "<tr id='fila_0'  >";
                echo "  <td  class='textotabla01'>";
				
				if($db->nivel == 5){
					echo "<INPUT type='hidden' name='cod_auxiliar_$jj' value='$db->cuenta_dmov'>";
				}
				echo " $db->cod_contable</td>";
				echo "  <td  class='textotabla01'>$db->desc_cuenta</td>";
				
                $dbsi = new Database ();
				$sqlsi = "SELECT SUM(debito_dmov) AS suma_debito,SUM(credito_dmov) AS suma_credito FROM `d_movimientos`
				INNER JOIN m_movimientos ON m_movimientos.cod_mov = d_movimientos.cod_mov
				where cuenta_dmov = $db->cod_cuenta AND (fec_emi ='$fec_ini') AND concepto_dmov = 35 AND estado_mov = 1";
				$dbsi->query($sqlsi);
				$dbsi->next_row();	
				if($dbsi->suma_debito == ""){
					$debito1 = 0;	
				}
				else {
					$debito1 = $dbsi->suma_debito;
				};		
				if ($db->nivel == 1){
					$total_debito1 = $total_debito1 + $debito1;
				}			
				?>
                
				    <td class="textotabla01"><div align="right"><?=number_format($debito1,0,".",".")?></div></td>
                <?
				if($dbsi->suma_credito == ""){
					$credito1 = 0;	
				}
				else {
					$credito1 = $dbsi->suma_credito;
				};		
				if ($db->nivel == 1){
					$total_credito1 = $total_credito1 + $credito1;
				}			
				?>
                
					<td class="textotabla01"><div align="right"><?=number_format($credito1,0,".",".")?></div></td>
				<?
                $dbb = new Database ();
				$sqlb = "SELECT sum(debito_dmov) as debito FROM `d_movimientos`
				INNER JOIN m_movimientos ON m_movimientos.cod_mov = d_movimientos.cod_mov
				where cuenta_dmov = $db->cod_cuenta AND ((fec_emi >='$fec_ini')AND(fec_emi <='$fec_fin')) AND concepto_dmov != 35 AND estado_mov = 1";
				$dbb->query($sqlb);
				$dbb->next_row();						
				if($dbb->debito == ""){
					$debito2 = 0;	
				}
				else {
					$debito2 = $dbb->debito;
				};
				if ($db->nivel == 1){
					$total_debito2 = $total_debito2 + $debito2;
				}
				?>
				  <td class="textotabla01">
			      <div align="right"><?=number_format($debito2,0,".",".")?></div>
                  </td>
                <?
				$dbc = new Database ();
				$sqlc = "SELECT sum(credito_dmov) as credito FROM `d_movimientos`
				INNER JOIN m_movimientos ON m_movimientos.cod_mov = d_movimientos.cod_mov
				where cuenta_dmov = $db->cod_cuenta AND ((fec_emi >='$fec_ini')AND(fec_emi <='$fec_fin')) AND estado_mov = 1";
				$dbc->query($sqlc);
				$dbc->next_row();		
				if($dbc->credito == ""){
					$credito2 = 0;	
				}
				else {
					$credito2 = $dbc->credito;
				};
				if ($db->nivel == 1){
					$total_credito2 = $total_credito2 + $credito2;
				}	
				
				$total = $debito1 - $credito1 + $debito2 - $credito2;
				$nuevo_debito = $total;
				$nuevo_credito = 0;
				?>               
				 <td class="textotabla01">
			     <div align="right"><?=number_format($credito2,0,".",".")?></div>
                 </td>
                 <? 
				 $num = number_format($nuevo_debito,0,".",".");
				 echo "<td class='textotabla01'>";
				 
				if($db->nivel == 5){
					echo "<INPUT type='hidden' name='debito_$jj' id='debito_$jj' value='$nuevo_debito'>";
				}
				
				 echo "";
				 echo "<div align='right'>$num</div></td>";			 
				 
				 if ($db->nivel == 1){
					$total_nuevo_debito = $total_nuevo_debito  + $nuevo_debito ;
					settype($total_nuevo_credito, "integer");
					settype($nuevo_credito, "integer");
					$total_nuevo_credito = $total_nuevo_credito  + $nuevo_credito ;
				 }

				 $num2 = number_format($nuevo_credito,0,".",".");
				 echo "<td class='textotabla01'>";
				 
				if($db->nivel == 5){
					echo "<INPUT type='hidden' name='credito_$jj' value='$nuevo_credito'>";
				}
				
				 echo "<div align='right'>$num2</div></td>";	
				 
				 } ?>
                 <tr >
                   <td colspan="8" >&nbsp;</td>
                 </tr>
                 <tr >
                   <td colspan="8" >&nbsp;</td>
                 </tr>
                 <tr >
            <td width="9%"  class="botones1"><div align="center">CUENTA</div></td>
            <td width="34%"  class="botones1"><div align="center">NOMBRE DE LA CUENTA</div></td>
            <td width="16%"  class="botones1"><div align="center">DEBITO INICIAL</div></td>
            <td width="16%"  class="botones1"><div align="center">CREDITO INICIAL</div></td>
            <td width="14%"  class="botones1"><div align="center">DEBITOS</div></td>
            <td width="13%"  class="botones1"><div align="center">CREDITOS</div></td>
            <td width="14%"  class="botones1"><div align="center">DEBITO NUEVO</div></td>
			<td width="14%"  class="botones1"><div align="center">CREDITO NUEVO</div></td>
            </tr>
				<?
				$db = new Database ();
				$sql = "SELECT * FROM cuenta
				INNER JOIN d_movimientos ON d_movimientos.cuenta_dmov = cuenta.cod_cuenta
				INNER JOIN m_movimientos ON m_movimientos.cod_mov = d_movimientos.cod_mov
				WHERE (fec_emi >='$fec_ini') AND (fec_emi <='$fec_fin') AND ((cod_contable LIKE '2%')or(cod_contable LIKE '3%') or(cod_contable LIKE '4%')) AND estado_mov = 1
				GROUP BY cod_cuenta
				ORDER BY  `cuenta`.`cod_contable` ASC";
				$db->query($sql);
				$estilo="formsleo";
				$total = 0;
				while($db->next_row()){	
					if($db->nivel == 5){
						$jj++;
					}	
									
                echo "<tr id='fila_0'  >";
                echo "<td  class='textotabla01'>";
				
				if($db->nivel == 5){
					echo "<INPUT type='hidden' name='cod_auxiliar_$jj' value='$db->cuenta_dmov'>";
				}
				echo "$db->cod_contable</td>";
				echo "<td  class='textotabla01'>$db->desc_cuenta</td>";
				
                $dbsi = new Database ();
				$sqlsi = "SELECT SUM(debito_dmov) AS suma_debito,SUM(credito_dmov) AS suma_credito FROM `d_movimientos`
				INNER JOIN m_movimientos ON m_movimientos.cod_mov = d_movimientos.cod_mov
				where cuenta_dmov = $db->cod_cuenta AND (fec_emi ='$fec_ini') AND concepto_dmov = 35 AND estado_mov = 1";
				$dbsi->query($sqlsi);
				$dbsi->next_row();
				if($dbsi->suma_debito == ""){
					$debito1 = 0;	
				}
				else {
					$debito1 = $dbsi->suma_debito;
				};		
				if ($db->nivel == 1){
					$total_debito1 = $total_debito1 + $debito1;
				}					
				?>
				    <td class="textotabla01"><div align="right"><?=number_format($debito1,0,".",".")?></div></td>
                <?
				if($dbsi->suma_credito == ""){
					$credito1 = 0;	
				}
				else {
					$credito1 = $dbsi->suma_credito;
				};		
				if ($db->nivel == 1){
					$total_credito1 = $total_credito1 + $credito1;
				}			
				?>
                
					<td class="textotabla01"><div align="right"><?=number_format($credito1,0,".",".")?></div></td>
               <?
				$dbb = new Database ();
				$sqlb = "SELECT sum(debito_dmov) as debito FROM `d_movimientos`
				INNER JOIN m_movimientos ON m_movimientos.cod_mov = d_movimientos.cod_mov
				where cuenta_dmov = $db->cod_cuenta AND ((fec_emi >='$fec_ini')AND(fec_emi <='$fec_fin')) AND concepto_dmov != 35 AND estado_mov = 1";
				$dbb->query($sqlb);
				$dbb->next_row();
				if($dbb->debito == ""){
					$debito2 = 0;	
				}
				else {
					$debito2 = $dbb->debito;
				};		
				if ($db->nivel == 1){
					$total_debito2 = $total_debito2 + $debito2;
				}				
				?>
				  <td class="textotabla01">
			      <div align="right"><?=number_format($debito2,0,".",".")?></div></td>
                <?
				$dbc = new Database ();
				$sqlc = "SELECT sum(credito_dmov) as credito FROM `d_movimientos`
				INNER JOIN m_movimientos ON m_movimientos.cod_mov = d_movimientos.cod_mov
				where cuenta_dmov = $db->cod_cuenta AND ((fec_emi >='$fec_ini')AND(fec_emi <='$fec_fin'))  AND concepto_dmov != 35 AND estado_mov = 1";
				$dbc->query($sqlc);
				$dbc->next_row();	
				if($dbc->credito == ""){
					$credito2 = 0;	
				}
				else {
					$credito2 = $dbc->credito;
				};		
				if ($db->nivel == 1){
					$total_credito2 = $total_credito2 + $credito2;
				}	
							  				 
				$total = $credito1 - $debito1 + $credito2 - $debito2;
				$nuevo_credito = $total;
				$nuevo_debito = 0;
				  ?>					                
				  <td class="textotabla01">
			      <div align="right"><?=number_format($credito2,0,".",".")?></div></td>
                 <? 
				 $num3 = number_format($nuevo_debito,0,".",".");
				 echo "<td class='textotabla01'>";
				 
				if($db->nivel == 5){
					echo "<INPUT type='hidden' name='debito_$jj' value='$nuevo_debito'>";
				}
				
				 echo "";
				 echo "<div align='right'>$num3</div></td>";	
				 	
				 $num4 = number_format($nuevo_credito,0,".",".");
				 echo "<td class='textotabla01'>";
				 
				if($db->nivel == 5){
					echo "<INPUT type='hidden' name='credito_$jj' value='$nuevo_credito'>";
				}
				
				 echo "<div align='right'>$num4</div></td>";
				 ?>
                </tr>
				<? 				 
				 
				 if ($db->nivel == 1){
					$total_nuevo_debito = $total_nuevo_debito + $nuevo_debito ;
					$total_nuevo_credito = $total_nuevo_credito + $nuevo_credito ;
				 }
				 ?>
				<?
				  } 
				 ?>
				 
				  <tr >
				    <td colspan="8" >&nbsp;</td>
			    </tr>
				  <tr >
				    <td colspan="2" ><div align="right"><strong>Total:</strong></div></td>
				    <td ><strong>
				      <div align="right">
				        <?=number_format($total_debito1,0,".",".")?>
			        </div>
				    </strong></td>
				    <td ><strong><div align="right">
				      <?=number_format($total_credito1,0,".",".")?>
			        </div></strong></td>
				    <td ><strong><div align="right">
				      <?=number_format($total_debito2,0,".",".")?>
			        </div></strong></td>
				    <td ><strong><div align="right">
				      <?=number_format($total_credito2,0,".",".")?>
			        </div></strong></td>
				    <td ><strong><div align="right">
				      <?=number_format($total_nuevo_debito,0,".",".")?>
			        </div></strong></td>
				    <td ><strong><div align="right">
				      <?=number_format($total_nuevo_credito,0,".",".")?>
			        </div></strong></td>
			    </tr>
				  <tr >
				    <td colspan="8" ><div align="center">
				      <input name="cierre" type="button"  class="botones" id="cierre" onclick="cambio_guardar()" value="CIERRE DE MES" />
			        </div></td>
			    </tr>
				  <tr >
				    <td colspan="6" ><input type="hidden" name="val_inicial" id="val_inicial" value="<? echo $jj;?>" />
			        <input type="hidden" name="guardar" id="guardar" /></td>
				    <td >&nbsp;</td>
				    <td >&nbsp;</td>
			    </tr>
				  <tr >
			  
                  <td colspan="8" >
				  <table  width="100%"  > 
				  <tr>
				    </tr>
				  </table>				  </td>
				  </tr>
              </table></TD>
		  </TR>
			<TR>
			  <TD align="center">             </TD>
		  </TR>
</TABLE>

 
<TABLE width="70%" border="0" cellspacing="0" cellpadding="0">
	
	<TR><TD colspan="3" align="center"><input name="button" type="button"  class="botones" id="imp" onClick="imprimir()" value="Imprimir">
        <input name="button" type="button"  class="botones"  id="cer" onClick="window.close()" value="Cerrar"></TD>
	</TR>

	<TR>
		<TD width="1%" background="images/bordefondo.jpg" style="background-repeat:repeat-y" rowspan="2"></TD>
		<TD bgcolor="#F4F4F4" class="pag_actual">&nbsp;</TD>
		<TD width="1%" background="images/bordefondo.jpg" style="background-repeat:repeat-y" rowspan="2"></TD>
	</TR>
	<TR>
	  <TD align="center">
     </TD>
     </TR>
     </TABLE>
     </TD>
     </TR>
     </table>
</form>
</body>	