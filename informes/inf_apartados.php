<?php
include "../lib/sesion.php";
include("../lib/database.php");
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
 <style type="text/css">
<!--
.Estilo1 {font-size: 9px}
.Estilo2 {font-size: 9 }
-->
 </style>
 <link href="../css/styles.css" rel="stylesheet" type="text/css" />
 <link href="../css/stylesforms.css" rel="stylesheet" type="text/css" />
 <title><?=$nombre_aplicacion?> -- INFORME DE APARTADOS --</title>
<TABLE width="100%" border="0" cellspacing="0" cellpadding="0"   >
	
	<TR>
		<TD align="center">
		<TABLE width="98%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" >
		
			<INPUT type="hidden" name="mapa" value="<?=$mapa?>">
			<INPUT type="hidden" name="id" value="<?=$id?>">

			<TR>
			  <TD width="100%" class='txtablas'>
			  <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#333333">
			  	<tr>
			  		<td><div align="center">INFORME DE APARTADOS</div></td>
			    </tr>
				</table>					</TD>
		  </TR>
			
			
			<TR>
			  <TD align="center">
			  <table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="#333333" id="select_tablas" >
			    <tr >
			      <td  class="botones1"><div align="center">NUMERO</div></td>
			      <td   class="botones1"><div align="center">ESTADO</div></td>
			      <td  class="botones1"><div align="center">FECHA</div></td>
			      <td  class="botones1"><div align="center">DIAS</div></td>
			      <td   class="botones1"><div align="center">FACTURA</div></td>
		        </tr>
                
			    <?
				$total=0;
				$sql = " SELECT *,m_factura.cod_apa as codigo_apartado,DATEDIFF(DATE(DATE(m_factura.fecha)),DATE(DATE(m_apartado.fecha))) AS dias,DATE(DATE(m_apartado.fecha)) as fec FROM m_apartado
				LEFT JOIN otros_pagos ON otros_pagos.cod_apa = m_apartado.cod_apa
				LEFT JOIN m_factura ON m_factura.cod_apa = m_apartado.cod_apa";
					$db->query($sql);
					$estilo="formsleo";
					while($db->next_row()){	
				?>
                <tr id="fila_0"  >
				   <td class="textotabla01"><?php echo $db->num_apa?></td>
				   <?php 
				   	if($db->estado_apa == 1){ 
				   		$estado = 'PENDIENTE';
				   	} else { 
				   		$estado = 'REDIMIDO';
				   	}
				   ?>
				   <td class="textotabla01"><?php echo $estado?></td>
				   <td class="textotabla01"><?php echo $db->fec?></td>
				   <td class="textotabla01"><?php echo $db->dias?></td>
				   <td class="textotabla01"><?php echo $db->num_fac ?> </td>
			    </tr>
				  
				<?
	
				  } 
				 
				 ?>
				 
				  <tr >
			  
                  <td colspan="6" >&nbsp;</td>
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
      <td align="center" colspan='5'><a href="../exportar/word/apartados.php "><img src='../imagenes/word.png'></a><a href="../exportar/excel/apartados.php "><img src='../imagenes/excel.png'></a><a href="../exportar/pdf/apartados.php "><img src='../imagenes/pdf.png'></a></td>
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