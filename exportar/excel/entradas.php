<?php include("../../lib/database.php");?>
<?php include("../../js/funciones.php");?>
<? header ( "Content-type: application/x-msexcel" );
	header ( "Content-Disposition: attachment; filename=entradas.xls" );
	header ( "Content-Description: Generador XLS" );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$nombre_aplicacion?></title>

</head>
<body>
<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" class='tabla' >
	<TR>
		<TD align="center">
		<TABLE width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000" class='tabla'>
		
			<INPUT type="hidden" name="mapa" value="<?php echo $mapa?>">
			<INPUT type="hidden" name="id" value="<?php echo $id?>">

			<TR>
			  <TD colspan="2" class='txtablas'>
			  <table width="100%" border="0" cellpadding="1" cellspacing="0" bordercolor="#000" class='tabla'>
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
			  <table width="100%" border="0" cellpadding="0" cellspacing="1" bordercolor="#333333" id="select_tablas" class='tabla'>
                
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
				  <table  width="100%"  class='tabla'> 
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
</body>
</html>