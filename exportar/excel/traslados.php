<?php include("../../lib/database.php");?>
<?php include("../../js/funciones.php");?>
<? header ( "Content-type: application/x-msexcel" );
	header ( "Content-Disposition: attachment; filename=entradas.xls" );
	header ( "Content-Description: Generador XLS" );

//RECIBE LAS VARIABLES
$codigo = $_REQUEST['codigo'];
		
$db = new Database();
$db_ver = new Database();
$sql ="SELECT * , (SELECT nom_bod FROM bodega WHERE cod_bod=cod_bod_sal_tras) AS bodega_salida, (SELECT nom_bod FROM bodega WHERE cod_bod=cod_bod_ent_tras) AS bodega_entrada FROM m_traslado WHERE cod_tras=$codigo";
$db_ver->query($sql);	
if($db_ver->next_row()){ 
	$ven_entrega=$db_ver->bodega_salida;
	$ven_recibe=$db_ver->bodega_entrada;
	$fecha=$db_ver->fec_tras;
	$obs_tras=$db_ver->obs_tras;
	$numero_tras=$db_ver->cod_tras;	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$nombre_aplicacion?></title>

</head>
<body>
<TABLE width="100%" border="0" cellspacing="0" cellpadding="0"   >
	
	<TR>
		<TD align="center">
		<TABLE width="94%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" >
		
			<INPUT type="hidden" name="mapa" value="<?php echo $mapa?>">
			<INPUT type="hidden" name="id" value="<?php echo $id?>">

			<TR>
			  <TD colspan="2" class='txtablas'>
			  <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#333333">
			  	<tr>
			  		<td width="46%" rowspan="2"><span class="Estilo4">TRASLADO DE INVENTARIOS</span></td>
				    <td width="26%" height="22" class="ctablaform"> <span class="textoproductos1">&nbsp;Bodega Entrega :</span><span class="textotabla01"> <?php echo $ven_entrega?></span></td>
			  	   
			  	    <td width="28%" class="ctablaform"><span class="textoproductos1">&nbsp;&nbsp;Fecha:</span><span class="textotabla01"> <?php echo $fecha?> </span></td>
			  	</tr>
			  	<tr>
			  	  <td  class="ctablaform"><span class="textoproductos1"> &nbsp;Bodega  Recibe :<span class="textotabla01">
			  	    <?php echo $ven_recibe?>
			  	  </span></span><span class="textoproductos1">&nbsp;&nbsp;</span></td>
			      <td  class="ctablaform"> <span class="textoproductos1">&nbsp;&nbsp;Documento No:&nbsp;&nbsp;<?php echo $numero_tras?> </span></td>
			  	</tr>
				</table>					</TD>
			  </TR>
			
			
			<TR>
			  <TD colspan="2" align="center">
			  <table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="#333333" id="select_tablas" >
                
				  <tr >
            <td  class="botones1"><div align="center">CODIGO</div></td>
            <td   class="botones1"><div align="center">CATEGORIA</div></td>
			<td  class="botones1"><div align="center">TIPO PRODUCTO</div></td>
            <td  class="botones1"><div align="center">REFERENCIA</div></td>
            <td   class="botones1"><div align="center">CANTIDAD</div></td>
	
          </tr>
				<?
				$total=0;
				$sql = " SELECT * FROM d_traslado 
				LEFT JOIN producto ON producto.cod_pro=d_traslado.cod_ref_dtra
				LEFT JOIN tipo_producto ON tipo_producto.cod_tpro=producto.`cod_tpro_pro`
				LEFT JOIN marca ON marca.cod_mar=producto.`cod_mar_pro`
				WHERE cod_mtras_dtra=$codigo  ORDER BY cod_dtra ";
					$db->query($sql);
					$estilo="formsleo";
					while($db->next_row()){ 	
						
				?>
                <tr id="fila_0"  >
                  <td  class="textotabla01"><div align="center"><?php echo $db->cod_fry_pro?></div></td>
                  <td colspan="1" class="textotabla01"><div align="center"><?php echo $db->nom_mar?></div></td>
                  <td  class="textotabla01"><div align="right"><?php echo $db->nom_tpro?></div></td>
                  <td  class="textotabla01"><div align="right"><?php echo $db->nom_pro?></div></td>
				   <td class="textotabla01"><div align="right"><?php echo number_format($db->cant_dtra,0,".",".")?></div></td>

                </tr>
				  
				<?
					$total = $total + $db->cant_dtra;
				  } 
				 
				 ?>
				 
				  <tr >
			  
                  <td colspan="7" >
				   </td>
				  </tr>
              </table>
			  </TD>
			  </TR>
			<TR>
			  <TD colspan="2" align="center">             </TD>
			  </TR>
			<?
			$dbt = new Database();
            $sqlt = " SELECT SUM(cant_dtra) AS suma,nom_mar FROM d_traslado 
			LEFT JOIN producto ON producto.cod_pro=d_traslado.cod_ref_dtra
			LEFT JOIN tipo_producto ON tipo_producto.cod_tpro=producto.`cod_tpro_pro`
			LEFT JOIN marca ON marca.cod_mar=producto.`cod_mar_pro`
			WHERE cod_mtras_dtra=$codigo 
			GROUP BY cod_mar ORDER BY cod_dtra";
			$dbt->query($sqlt);
			while($dbt->next_row()){ 
			?>
            <TR>            
			  <TD colspan="2" class="textotabla01" align="center"><p align="right">TOTAL
              <?php echo $dbt->nom_mar?> : 
			    <?php echo number_format($dbt->suma,0,".",".")?>
              </TD>
		  	</TR>
            <?php } ?>
			<TR>
			  <TD width="13%" height="40" align="center" valign="top"><div align="center" class="textoproductos1">
			    <div align="left" class="subtitulosproductos">Observaciones:			    </div>
			  </div></TD>
		      <TD width="87%"  valign="top"><span class="textotabla01">
		        <?php echo $obs_tras?>
		      </span></TD>
			</TR>
</TABLE>
</body>
</html>