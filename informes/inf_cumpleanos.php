<?php
include "../lib/sesion.php";
include("../lib/database.php");

//RECIBE LAS VARIABLES
$cliente = $_REQUEST['cliente'];
$fec_ini = $_REQUEST['fec_ini'];
$fec_fin = $_REQUEST['fec_fin'];

//VERIFICA SI ES UN CLIENTE O TODOS
if($cliente == 0){
	$where = '';
} else {
	$where = ' AND cliente.cod_cli ='.$cliente;
}
?>
<script language="javascript">
function imprimir(){
	document.getElementById('imp').style.display="none";
	document.getElementById('cer').style.display="none";
	window.print();
}

//ABRE EL DETALLE DEL INFORME
function abrir(opc){
	var fec_ini = document.getElementById('fec_ini').value;
	var fec_fin = document.getElementById('fec_fin').value;
	var vendedor = document.getElementById('vendedor').value;
	var opc = opc;
			
	imprimir_inf("../ver_factura_v.php",'0&fec_ini='+fec_ini+"&fec_fin="+fec_fin+"&vendedor="+vendedor+"&codigo="+opc,'mediano',"target = '_blank'");
}
</script>
<script type="text/javascript" src="../js/funciones.js"></script>
<script type="text/javascript" src="../informes/inf.js"></script>
 <link href="styles.css" rel="stylesheet" type="text/css" />
 <link href="../styles.css" rel="stylesheet" type="text/css" />
 <style type="text/css">
<!--
.Estilo1 {font-size: 9px}
.Estilo2 {font-size: 9 }
-->
 </style>
 <link href="../css/styles.css" rel="stylesheet" type="text/css" />
 <link href="../css/stylesforms.css" rel="stylesheet" type="text/css" />
 <title><?=$nombre_aplicacion?> -- INFORME DE CUMPLEAÑOS --</title>
<TABLE width="100%" border="0" cellspacing="0" cellpadding="0"   >
	
	<TR>
		<TD align="center">
		<TABLE width="98%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" >
		
			<INPUT type="hidden" name="mapa" value="<?=$mapa?>">
			<INPUT type="hidden" name="id" value="<?=$id?>">
			<INPUT type="hidden" name="fec_ini" id="fec_ini"  value="<?=$fec_ini?>">
			<INPUT type="hidden" name="fec_fin" id="fec_fin" value="<?=$fec_fin?>">
			<INPUT type="hidden" name="vendedor" id="vendedor"  value="<?=$vendedor?>">


			<TR>
			  <TD width="100%" class='txtablas'>
			  <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#333333">
			  	<tr>
			  		<td><div align="center" class="ctablasup">INFORME DE CUMPLEAÑOS</div></td>
			    </tr>
				</table>					</TD>
		  </TR>
			
			
			<TR>
			  <TD align="center">
			  <table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="#333333" id="select_tablas" >
			    <tr>
			      <td align="center">CLIENTE</td>
			      <td align="center">FECHA</td>
		        </tr>
		        <?php
		        //REALIZA LA CONSULTA DE VENTAS
		        $db = new database();
		        $sql = "SELECT *,CONCAT(nom1_cli,' ',nom2_cli,' ',apel1_cli,' ',apel2_cli) as nombre,MONTH(fcun_cli) as mes,DAY(fcun_cli) as dia FROM cliente
		        WHERE estado_cli = 1 AND fcun_cli != '00-00-0000'
		        ORDER BY mes,dia";
		        $db->query($sql);
		        while($db->next_row()){
		        	$mes = $db->mes;

		//FUNCION PARA LOS MESES
    	if($mes=="01"){$mes = "Enero";}
		if($mes=="02"){$mes = "Febrero";}
		if($mes=="03"){$mes = "Marzo";}
		if($mes=="04"){$mes = "Abril";}
		if($mes=="05"){$mes = "Mayo";}
		if($mes=="06"){$mes = "Junio";}
		if($mes=="07"){$mes = "Julio";}
		if($mes=="08"){$mes = "Agosto";}
		if($mes=="09"){$mes = "Septiembre";}
		if($mes=="10"){$mes = "Octubre";}
		if($mes=="11"){$mes = "Noviembre";}
		if($mes=="12"){$mes = "Diciembre";}
	     
	     ?>
			    <tr>
			      <td align="center"><?php echo $db->nombre?></td>
			      <td align="center"><?php echo $db->dia.' de '.$mes?></td>
		        </tr>
		        <?php } ?>			 
				<tr>			  
                  <td colspan="3" >&nbsp;</td>
				</tr>

              </table></TD>
		  </TR>
			<TR>
			  <TD align="center">             </TD>
		  </TR>
			<TR>
			  <TD align="center"><p></TD>
		  </TR>
</TABLE>

 
<TABLE width="70%" border="0" cellspacing="0" cellpadding="0">
     <tr>
      <td align="center" colspan='5'><a href="../exportar/word/cumpleanos.php"><img src='../imagenes/word.png'></a><a href="../exportar/excel/cumpleanos.php"><img src='../imagenes/excel.png'></a><a href="../exportar/pdf/cumpleanos.php"><img src='../imagenes/pdf.png'></a></td>
    </tr>	
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
	