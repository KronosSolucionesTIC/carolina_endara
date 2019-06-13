<?php
include "../lib/sesion.php";
include("../lib/database.php");

//RECIBE LAS VARIABLES
$codigo_bodega = $_REQUEST['codigo_bodega'];
			
$db = new Database();
$db_ver = new Database();
$sql = "SELECT  *  FROM bodega  WHERE cod_bod=$codigo_bodega";
$db_ver->query($sql);	
if($db_ver->next_row()){ 
	$bodega=$db_ver->nom_bod;

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
 <style type="text/css">
<!--
.Estilo1 {font-size: 9px}
.Estilo2 {font-size: 9 }
-->
 </style>
 <link href="../css/styles.css" rel="stylesheet" type="text/css" />
 <link href="../css/stylesforms.css" rel="stylesheet" type="text/css" />
 <title><?=$nombre_aplicacion?> -- SALDOS DE BODEGA --</title>
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
			  		<td><div align="center"><span class="textoproductos1">&nbsp;&nbsp;Bodega:<span class="textotabla01">
		  		    <?=$bodega?>
		  		    </span></span><span class="textoproductos1">&nbsp;&nbsp;</span></div></td>
			    </tr>
				</table>					</TD>
		  </TR>
			
			
			<TR>
			  <TD align="center">
			  <table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="#333333" id="select_tablas" >
			    <tr >
			      <td  class="botones1"><div align="center">CODIGO</div></td>
			      <td   class="botones1"><div align="center">CATEGORIA</div></td>
			      <td  class="botones1"><div align="center">TIPO PRODUCTO</div></td>
			      <td  class="botones1"><div align="center">REFERENCIA</div></td>
			      <td   class="botones1"><div align="center">CANTIDAD</div></td>
			      <td   class="botones1"><div align="center">PRECIO</div></td>
		        </tr>
                
			    <?
				$total=0;
				$sql = " SELECT * FROM kardex	
					INNER JOIN producto ON kardex.cod_ref_kar=producto.cod_pro
					LEFT JOIN 	tipo_producto ON producto.cod_tpro_pro = tipo_producto.cod_tpro 
					LEFT JOIN  marca ON producto.cod_mar_pro = marca.cod_mar
					WHERE kardex.cod_bod_kar=$codigo_bodega and kardex.cant_ref_kar>0
					GROUP BY cod_ref_kar
					 order by nom_tpro,cod_fry_pro  ";
					$db->query($sql);
					$estilo="formsleo";
					while($db->next_row()){ 	
						
				?>
                <tr id="fila_0"  >
				
                  <td  class="textotabla01"><div align="center">
                    <?=$db->cod_fry_pro?>
                  </div></td>
				  <td  class="textotabla01"><div align="center">
				    <?=$db->nom_mar?>
				  </div></td>
                  
                  <td class="textotabla01"><div align="center">
                    <?=$db->nom_tpro?>
                  </div></td>
                  <td  class="textotabla01"><div align="center">
                    <?=$db->nom_pro?>
                  </div></td>
                  <?php
					//EXISTENCIAS
					$dbe = new database();
					$sqle = "SELECT SUM(cant_ref_kar) AS total_existencias FROM kardex	
					WHERE cod_ref_kar = $db->cod_pro AND cod_bod_kar = 1
					GROUP BY cod_ref_kar";
					$dbe->query($sqle);
					while($dbe->next_row()){
						$existencias = $dbe->total_existencias;
					} 	
                  ?>
				   <td class="textotabla01"><div align="right"><?=number_format($existencias,0,".",".")?></div></td>
				   <td class="textotabla01"><div align="right"><?=number_format($db->valor_pro,0,".",".")?></div></td>
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
      <td align="center" colspan='5'><a href="../exportar/word/productos.php?codigo=<?=$codigo_bodega?>"><img src='../imagenes/word.png'></a><a href="../exportar/excel/productos.php?codigo=<?=$codigo_bodega?>"><img src='../imagenes/excel.png'></a><a href="../exportar/pdf/productos.php?codigo=<?=$codigo_bodega?>"><img src='../imagenes/pdf.png'></a></td>
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
	