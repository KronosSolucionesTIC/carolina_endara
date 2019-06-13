<?
include "../lib/sesion.php";
include("../lib/database.php");

//RECIBE LAS VARIABLES
$codigo = $_REQUEST['codigo'];

$db = new Database();
$db_ver = new Database();
$sql = "SELECT  *  FROM m_entrada
INNER JOIN bodega ON bodega.cod_bod = m_entrada.cod_bod
WHERE cod_ment=$codigo";
$db_ver->query($sql);	
if($db_ver->next_row()){
	$cod_proveedor = $db_ver->cod_prove_ment;
	$dbp = new Database();
	$sqlp = "SELECT * FROM proveedor
	WHERE cod_pro = $cod_proveedor";
	$dbp->query($sqlp);
	$dbp->next_row();
		
	$proveedor = $dbp->nom_pro;
	$fecha=$db_ver->fec_ment;
	$obser=$db_ver->obs_ment;
	$bodega=$db_ver->nom_bod;
	$factura=$db_ver->fac_ment;	
	$total_nuevo_saldo=$db_ver->total_ment;
	$numero_doc=$db_ver->cod_ment;
}

?>
<script language="javascript">
function imprimir(){
	document.getElementById('exportar').style.display="none";
	window.print();
}


</script>
 <link href="styles.css" rel="stylesheet" type="text/css" />
 <link href="../styles.css" rel="stylesheet" type="text/css" />
 <link href="../css/styles.css" rel="stylesheet" type="text/css" />
 <link href="../css/stylesforms.css" rel="stylesheet" type="text/css" />
 <title><?php echo $nombre_aplicacion?> -- ENTRADAS DE INVENTARIO --</title>
 <TABLE width="100%" border="0" cellspacing="0" cellpadding="0"   >
	
	<TR>
		<TD align="center">
		<TABLE width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000" >
		
			<INPUT type="hidden" name="mapa" value="<?php echo $mapa?>">
			<INPUT type="hidden" name="id" value="<?php echo $id?>">

			<TR>
			  <TD colspan="2" class='txtablas'>
			  <table width="100%" border="0" cellpadding="1" cellspacing="0" bordercolor="#000">
		  	    <tr>
		  	        <td height="22" colspan="4"><div align="center"><strong>ENTRADA DE INVENTARIOS No<span class="textoproductos1">
		  	          <?php echo $numero_doc?>
		  	        </span></strong><span class="textoproductos1"></span></div></td>
	  	        </tr>
		  	    <tr>
		  	      <td width="25%"><span class="ctablaform"><span class="textoproductos1">Fecha :</span><span class="textoproductos1">&nbsp;&nbsp;</span></span></td>
		  	      <td width="25%"><span class="textotabla01">
		  	        <?php echo $fecha?>
		  	      </span></td>
			  		<td width="25%" height="22" class="ctablaform"> <span class="textoproductos1"> &nbsp;&nbsp;Proveedor:&nbsp;&nbsp;</span></td>
			  		<td width="25%" class="ctablaform"><span class="textotabla01">
			  		  <?php echo $proveedor?>
			  		</span></td>
		  	    </tr>
			  	<tr>
			  	  <td width="25%"><span class="ctablaform"><span class="textoproductos1">Factura No :</span><span class="textoproductos1">&nbsp;&nbsp;</span></span></td>
			  	  <td width="25%"><span class="textotabla01">
			  	    <?php echo $factura?>
			  	  </span></td>
			  	  <td  class="ctablaform"><span class="textoproductos1">&nbsp;&nbsp;Bodega:</span></td>
			  	  <td  class="ctablaform"><span class="textotabla01">
			  	    <?php echo $bodega?>
			  	  </span></td>
		  	    </tr>
				</table>					</TD>
		  </TR>
			
			
			<TR>
			  <TD colspan="2" align="center">
			  <table width="100%" border="0" cellpadding="0" cellspacing="1" bordercolor="#333333" id="select_tablas" >
                
				  <tr >
            <td  class="botones1"> <div align="center">CODIGO</div></td>
            <td  class="botones1"><div align="center">CATEGORIA</div></td>
			<td  class="botones1"><div align="center">TIPO PRODUCTO</div></td>
            <td  class="botones1"><div align="center">REFERENCIA</div></td>
            <td   class="botones1"><div align="center">CANTIDAD</div></td>
          </tr>
				<?
				$total=0;
				$total_cant = 0;
				 $sql = "  SELECT * FROM d_entrada 
				 INNER JOIN tipo_producto ON tipo_producto.cod_tpro=d_entrada.cod_tpro_dent 
				 INNER JOIN marca ON marca.cod_mar=d_entrada.cod_mar_dent 
				 INNER JOIN producto ON producto.cod_pro=d_entrada.cod_ref_dent
				 WHERE cod_ment_dent=$codigo order by cod_dent   ";
					$db->query($sql);
					$estilo="formsleo";
					while($db->next_row()){ 	
						
				?>
                <tr id="fila_0"  >
				  <td  class="textotabla01"><?php echo $db->cod_fry_pro?></td>
				  <td class="textotabla01"><?php echo $db->nom_mar?></td>
                  <td colspan="1" class="textotabla01"><?php echo $db->nom_tpro?></td>
                  <td  class="textotabla01"><?php echo $db->nom_pro?></td>
				   <td class="textotabla01"><div align="right"><?php echo number_format($db->cant_dent,0,".",".")?></div></td>
                </tr>
				  
				<?
					$total_cant = $total_cant + $db->cant_dent;
				  } 
				 
				 ?>
				 
				  <tr >
			  
                  <td colspan="8" >
				  <table  width="100%"  > 
				  <tr>
				  <td class="subfongris"><div align="right">Total entrada </div></td>
				    <td><div align="right"><span class="tituloproductos">
				      <?php echo number_format($total_cant,0,".",".")?> 
			        </span></div></td>	
				  </tr>
				  </table>				  </td>
				  </tr>
              </table></TD>
		  </TR>
			<TR>
			  <TD colspan="2" align="center">             </TD>
		  </TR>
			<TR>
			  <TD colspan="2" align="center"><p></TD>
		  </TR>
			<TR>
			
			
			
			  <TD width="13%" height="40" align="center" valign="top"><div align="center" class="textoproductos1">
			    <div align="left" class="subtitulosproductos">Observaciones:			    </div>
			  </div></TD>
		      <TD width="87%" valign="top" ><span class="textotabla01">
		        <?php echo $obser?> 
		      </span></TD>
			</TR>
</TABLE>

 
<TABLE width="70%" border="0" cellspacing="0" cellpadding="0">
     <tr>
      <td align="center" colspan='5'><div id='exportar'><a href="../exportar/word/entradas.php?codigo=<?=$codigo?>"><img src='../imagenes/word.png'></a><a href="../exportar/excel/entradas.php?codigo=<?=$codigo?>"><img src='../imagenes/excel.png'></a><a href="../exportar/pdf/entradas.php?codigo=<?=$codigo?>"><img src='../imagenes/pdf.png'></a></div></td>
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