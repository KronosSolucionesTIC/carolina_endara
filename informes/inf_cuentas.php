<?
include "../lib/sesion.php";
include("../lib/database.php");

if($valor == ""){
	$where = "WHERE ESTADO = 1";
}
else{
	$where = "WHERE $filtro like '%$valor%' AND ESTADO = 1"; 
}
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
 <title><?=$nombre_aplicacion?> -- ENTRADAS DE INVENTARIO --</title>
 <style type="text/css">
<!--
.Estilo4 {font-size: 18px}
-->
 </style>
 <TABLE width="100%" border="0" cellspacing="0" cellpadding="0"   >
 <?=$credito?>
	
	<TR>
		<TD align="center">
		<TABLE width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" >
		
			<INPUT type="hidden" name="mapa" value="<?=$mapa?>">
			<INPUT type="hidden" name="id" value="<?=$id?>">

			<TR>
			  <TD width="100%" class='txtablas'>
			  <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#333333">
			  	<tr>
			  		<td width="47%" height="26"><div align="center">INFORME DE CUENTAS</div></td>
			    </tr>
				</table>					</TD>
		  </TR>
			
			<TR>
			  <TD align="center">             </TD>
		  </TR>
</TABLE>
		<table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="#333333" id="select_tablas" >
        <tr >
          <td width="12%"  class="botones1"><div align="center">CUENTA</div></td>
          <td width="11%"  class="botones1"><div align="center">NOMBRE</div></td>
          <td width="14%"  class="botones1"><div align="center">INDICATIVO</div></td>
          <td width="17%"  class="botones1"><div align="center">CONTROL</div></td>
          </tr>
        <?
				$db = new Database ();
				$sql = "SELECT * FROM MAECTA
				$where";
				$db->query($sql);
				$estilo="formsleo";
				while($db->next_row()){						
				?>
        <tr id="fila_0"  >
          <td class="textotabla01"><?=$db->CUENTA?></td>
          <td class="textotabla01"><?=$db->NOMBRE?></td>
          <td class="textotabla01"><?=$db->INDICATIVO?></td>
          <td class="textotabla01"><?=$db->CONTROL?></td>
          </tr>
        <? } ?>
        <tr >
          <td colspan="7" ><table  width="100%"  >
            <tr></tr>
          </table></td>
        </tr>
        </table>
		<TABLE width="70%" border="0" cellspacing="0" cellpadding="0">
	
	<TR><TD colspan="3" align="center"><input name="button" type="button"  class="botones1" id="imp" onClick="imprimir()" value="Imprimir">
        <input name="button" type="button"  class="botones1"  id="cer" onClick="window.close()" value="Cerrar"></TD>
	</TR>

	<TR>
		<TD width="1%" background="images/bordefondo.jpg" style="background-repeat:repeat-y" rowspan="2"></TD>
		<TD bgcolor="#F4F4F4" class="pag_actual">&nbsp;</TD>
		<TD width="1%" background="images/bordefondo.jpg" style="background-repeat:repeat-y" rowspan="2"></TD>
	</TR>
	<TR>
	  <TD align="center">
 