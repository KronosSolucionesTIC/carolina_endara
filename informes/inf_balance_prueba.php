<?php
include "../lib/sesion.php";
include("../lib/database.php");

//RECIBE LAS VARIABLES
$fec_ini = $_REQUEST['fec_ini'];
$fec_fin = $_REQUEST['fec_fin'];
$cliente = $_REQUEST['cliente'];
$cuenta = $_REQUEST['cuenta'];

if($cliente > 0){
	$where_cliente = " AND cod_cli = $cliente";
} else {
	$where_cliente = "";
}

if($cuenta > 0){
	$where_cuenta = " AND cod_cuenta = $cuenta";
} else {
	$where_cuenta = "";
}
?>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script language="javascript">
function imprimir(){
	document.getElementById('imp').style.display="none";
	document.getElementById('cer').style.display="none";
	window.print();
}

function abrir(aux) {			
	var fec_ini = document.getElementById('fec_ini').value;
	var fec_fin = document.getElementById('fec_fin').value;

	ancho=900;
	alto=600;

var marginleft = (screen.width - ancho) / 2;
var margintop = (screen.height - alto) / 2;
propiedades = 'menubar=0,resizable=1,height='+alto+',width='+ancho+',top='+margintop+',left='+marginleft+',toolbar=0,scrollbars=yes';
	window.open("../informes/inf_balance_prueba.php?cliente="+aux+'&fec_ini='+fec_ini+"&fec_fin="+fec_fin,propiedades); 
}

</script>
<script type="text/javascript" src="../informes/inf.js"></script> 
</head>
 <link href="styles.css" rel="stylesheet" type="text/css" />
 <link href="../styles.css" rel="stylesheet" type="text/css" />
 <link href="../css/styles.css" rel="stylesheet" type="text/css" />
 <link href="../css/stylesforms.css" rel="stylesheet" type="text/css" />
 <title><?=$nombre_aplicacion?> -- BALANCE DE PRUEBA --</title>
 <style type="text/css">
<!--
.Estilo4 {font-size: 18px}
-->
 </style>
 <TABLE width="100%" border="0" cellspacing="0" cellpadding="0"   >
 <?=$credito?>
	
	<TR>
		<TD align="center">
		<TABLE width="98%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" >
		
			<INPUT type="hidden" name="mapa" value="<?=$mapa?>">
			<INPUT type="hidden" name="id" value="<?=$id?>">

			<TR>
			  <TD width="100%" class='txtablas'>
			  <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#333333">
			  	<tr>
			  		<td width="47%" height="26"><div align="center"><span class="Estilo4">BALANCE DE PRUEBA DE <?=$fec_ini?> HASTA <?=$fec_fin?></span></div></td>
			    </tr>
				</table>					</TD>
		  </TR>
			
			
			<TR>
			  <TD align="center">
			  <table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="#333333" id="select_tablas" >
                
				  <tr >
            <td width="9%"  class="botones1"><div align="center">CUENTA</div></td>
            <td width="34%"  class="botones1"><div align="center">NOMBRE DE LA CUENTA</div></td>
            <td width="16%"  class="botones1"><div align="center">SALDO INICIAL</div></td>
            <td width="14%"  class="botones1"><div align="center">DEBITOS</div></td>
            <td width="13%"  class="botones1"><div align="center">CREDITOS</div></td>
			<td width="14%"  class="botones1"><div align="center">NUEVO SALDO</div></td>
            </tr>
				<?
				$db = new Database ();
				$sql = "SELECT * FROM cuenta
				INNER JOIN d_movimientos ON d_movimientos.cuenta_dmov = cuenta.cod_cuenta
				INNER JOIN m_movimientos ON m_movimientos.cod_mov = d_movimientos.cod_mov
				WHERE (fec_emi >='$fec_ini') AND (fec_emi <='$fec_fin') AND estado_mov = 1 $where_cliente $where_cuenta
				GROUP BY cod_cuenta
				ORDER BY  `cuenta`.`cod_contable` ASC";
				$db->query($sql);
				$estilo="formsleo";
				$total_saldo = 0;
				$total_debito = 0;
				$total_credito = 0;
				$total_nuevo_saldo = 0;
				while($db->next_row()){					
				?>
                <tr id="fila_0"  >
                <?php if($db->nivel == 5){ ?>
                  <td  class="textotabla01"><?=$db->cod_contable?> <img src='../imagenes/mirar.png' width='16' height='16'  style="cursor:pointer"  onclick='abrir(<?=$db->cod_cuenta?>)' /></td>
                <? } else {?>
 				  <td  class="textotabla01"><?=$db->cod_contable?></td>
 				<? } ?>               
				  <td  class="textotabla01"><?=$db->desc_cuenta?></td>
                <?
                $dbsi = new Database ();
				$sqlsi = "SELECT SUM(debito_dmov) AS suma_debito,SUM(credito_dmov) AS suma_credito FROM `d_movimientos`
				INNER JOIN m_movimientos ON m_movimientos.cod_mov = d_movimientos.cod_mov
				where cuenta_dmov = $db->cod_cuenta AND (fec_emi <='$fec_ini') AND estado_mov = 1";
				$dbsi->query($sqlsi);
				$dbsi->next_row();	

				$saldo = $dbsi->suma_debito - $dbsi->suma_credito;
				
				if ($db->nivel == 5){
					$total_saldo = $total_saldo + $saldo;
				}				
				?>
				  <td class="textotabla01"><div align="right"><?=$saldo?></div></td>
				<?
                $dbb = new Database ();
				$sqlb = "SELECT sum(debito_dmov) as debito FROM `d_movimientos`
				INNER JOIN m_movimientos ON m_movimientos.cod_mov = d_movimientos.cod_mov
				where cuenta_dmov = $db->cod_cuenta AND ((fec_emi >='$fec_ini')AND(fec_emi <='$fec_fin')) AND estado_mov = 1";
				$dbb->query($sqlb);
				$dbb->next_row();						
				if($dbb->debito == ""){
					$debito = 0;	
				}
				else {
					$debito = $dbb->debito;
				};
				if ($db->nivel == 5){
					$total_debito = $total_debito + $debito;
				}
				?>
				  <td class="textotabla01">
			      <div align="right"><?=number_format($debito,0,".",".")?></div>
                  </td>
                <?
				$dbc = new Database ();
				$sqlc = "SELECT sum(credito_dmov) as credito FROM `d_movimientos`
				INNER JOIN m_movimientos ON m_movimientos.cod_mov = d_movimientos.cod_mov
				where cuenta_dmov = $db->cod_cuenta AND ((fec_emi >='$fec_ini')AND(fec_emi <='$fec_fin')) AND estado_mov = 1";
				$dbc->query($sqlc);
				$dbc->next_row();		
				if($dbc->credito == ""){
					$credito = 0;	
				}
				else {
					$credito = $dbc->credito;
				};
				if ($db->nivel == 5){
					$total_credito = $total_credito + $credito;
				}				
				?>               
				 <td class="textotabla01">
			     <div align="right"><?=number_format($credito,0,".",".")?></div>
                 </td>
                 <? 
				 $nuevo_saldo = $saldo + $debito - $credito;
				 
				 if ($db->nivel == 5){
					$total_nuevo_saldo = $total_nuevo_saldo + $nuevo_saldo;
				 }
				 ?>
				 <td colspan="1" class="textotabla01"><div align="right">
				   <?=number_format($nuevo_saldo,0,".",".")?>				 </div></td>
                </tr>
                <? } ?>
                <tr>
                	<td colspan='2' align='right'>Totales:</td>	
                	<td><?=number_format($total_saldo,0,".",".")?></td>
                	<td><?=number_format($total_debito,0,".",".")?></td>
                	<td><?=number_format($total_credito,0,".",".")?></td>
                	<td><?=number_format($total_nuevo_saldo,0,".",".")?></td>
                </tr>
				<tr >
			  
                  <td colspan="6" >
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
<td><input type='hidden' value='<?=$fec_ini?>' name='fec_ini' id='fec_ini'><input type='hidden' value='<?=$fec_fin?>' name='fec_fin' id='fec_fin'></td>
 
<TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
     <tr>
      <td align="center" colspan='5'><a href="../exportar/word/balance_prueba.php?fec_ini=<?=$fec_ini?>&fec_fin=<?=$fec_fin?>&cliente=<?=$cliente?>&cuenta=<?=$cuenta?>"><img src='../imagenes/word.png'></a><a href="../exportar/excel/balance_prueba.php?fec_ini=<?=$fec_ini?>&fec_fin=<?=$fec_fin?>&cliente=<?=$cliente?>&cuenta=<?=$cuenta?>"><img src='../imagenes/excel.png'></a><a href="../exportar/pdf/balance_prueba.php?fec_ini=<?=$fec_ini?>&fec_fin=<?=$fec_fin?>&cliente=<?=$cliente?>&cuenta=<?=$cuenta?>"><img src='../imagenes/pdf.png'></a></td>
    </tr>	
	<TR>
		<TD colspan="6" align="center"><input name="button" type="button"  class="botones" id="imp" onClick="imprimir()" value="Imprimir">
        <input name="button" type="button"  class="botones"  id="cer" onClick="window.close()" value="Cerrar"></TD>
	</TR>

	<TR>
		<TD width="1%" background="images/bordefondo.jpg" style="background-repeat:repeat-y" rowspan="2"></TD>
		<TD bgcolor="#F4F4F4" class="pag_actual">&nbsp;</TD>
		<TD width="1%" background="images/bordefondo.jpg" style="background-repeat:repeat-y" rowspan="2"></TD>
	</TR>
	<TR>
	  <TD align="center">
	