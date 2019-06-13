<?PHP
include "../lib/sesion.php";
include("../lib/database.php");		

//RECIBE LAS VARIABLES
$codigo = $_REQUEST['codigo'];		
?>
<script language="javascript">
function imprimir(){
	document.getElementById('imp').style.display="none";
	document.getElementById('cer').style.display="none";
	window.print();
}
</script>
 <link href="styles.css" rel="stylesheet" type="text/css" />
 <link href="../styles.css" rel="stylesheet" type="text/css" />
 <link href="../css/styles.css" rel="stylesheet" type="text/css" />
 <link href="../css/stylesforms.css" rel="stylesheet" type="text/css" />
 <title><?PHP echo $nombre_aplicacion?> -- MOVIMIENTOS CONTABLES --</title>
 <style type="text/css">
<!--
.Estilo4 {font-size: 18px}
-->
 </style>
 <TABLE width="100%" border="0" cellspacing="0" cellpadding="0"   >
	
	<TR>
		<TD align="center">
		<TABLE width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" >
		
			<INPUT type="hidden" name="mapa" value="<?PHP echo $mapa?>">
			<INPUT type="hidden" name="id" value="<?PHP echo $id?>">

			<TR>
			  <TD colspan="2" class='txtablas'>
			  <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#333333">
			  	<tr>
			  		<td width="47%" height="22" class="textotabla01"><div align="center">MOVIMIENTOS CONTABLES</div></td>
			    </tr>
				</table>					</TD>
		  </TR>
			
			
			<TR>
				<TD colspan="2" align="center">
					<table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="#333333" id="select_tablas" >
						<tr >
							<td width="5%"  class="botones1">TIPO</td>
            				<td width="5%"  class="botones1">No DOC</td>
            				<td width="5%"  class="botones1">FECHA</td>
            			</tr>
    <?PHP  
    $db = new Database();
	$sql = "SELECT fec_emi,desc_tmov,conse_mov,SUM(debito_dmov) AS debitos,SUM(credito_dmov) AS creditos FROM d_movimientos
	INNER JOIN m_movimientos ON m_movimientos.cod_mov = d_movimientos.cod_mov
	INNER JOIN tipo_movimientos ON tipo_movimientos.cod_tmov = m_movimientos.tipo_mov
	GROUP BY m_movimientos.cod_mov" ;
	$db->query($sql);
	while($db->next_row()){
		if($db->creditos != $db->debitos){
	?>
                <tr id="fila_0"  >
                  <td  class="textotabla01"><?PHP echo $db->desc_tmov?></td>
                  <td  class="textotabla01"><?PHP echo $db->conse_mov?></td>
                  <td  class="textotabla01"><?PHP echo $db->fec_emi?></td>
    <?PHP 
        }
	} 
	?>
			    </tr>			 
				  <tr >
				    <td colspan="5" >&nbsp;</td>
			    </tr>
              </table></TD>
		  </TR>
</TABLE>

 
<TABLE width="70%" border="0" cellspacing="0" cellpadding="0">
     <tr>
      <td align="center" colspan='5'><a href="../exportar/word/descuadrados.php"><img src='../imagenes/word.png'></a><a href="../exportar/excel/descuadrados.php"><img src='../imagenes/excel.png'></a><a href="../exportar/pdf/descuadrados.php"><img src='../imagenes/pdf.png'></a></td>
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