<?php include("../../lib/database.php");?>
<?php include("../../js/funciones.php");?>
<? 
//RECIBE LAS VARIABLES
header ( "Content-type: application/x-msexcel" );
header ( "Content-Disposition: attachment; filename=productos.xls" );
header ( "Content-Description: Generador XLS" );

//RECIBE LAS VARIABLES
$codigo_bodega = $_REQUEST['codigo'];

$db = new Database();
$db_ver = new Database();
$sql = "SELECT  *  FROM bodega  WHERE cod_bod=$codigo_bodega";
$db_ver->query($sql);	
if($db_ver->next_row()){ 
	$bodega=$db_ver->nom_bod;

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
		        </tr>
                
			    <?
				$total=0;
				$sql = " SELECT * FROM kardex	
					INNER JOIN producto ON kardex.cod_ref_kar=producto.cod_pro
					LEFT JOIN 	tipo_producto ON producto.cod_tpro_pro = tipo_producto.cod_tpro 
					LEFT JOIN  marca ON producto.cod_mar_pro = marca.cod_mar
					WHERE kardex.cod_bod_kar=$codigo_bodega and kardex.cant_ref_kar>0 order by nom_tpro,cod_fry_pro  ";
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
                  
                  <td  class="textotabla01"><div align="center">
                    <?=$db->nom_tpro?>
                  </div></td>
                  <td  class="textotabla01"><div align="center">
                    <?=$db->nom_pro?>
                  </div></td>
				   <td class="textotabla01"><div align="right"><?=number_format($db->cant_ref_kar,0,".",".")?></div></td>
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
</body>
</html>