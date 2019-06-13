<?php require_once("../../lib/dompdf/dompdf_config.inc.php");?>
<?php include("../../lib/database.php");?>
<?php include("../../js/funciones.php");?>
<?php 

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

$codigoHTML='
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="http://app.skala.hostei.com/Blue_version_2_0/css/styles.css" rel="stylesheet" type="text/css" />
<title><?=$nombre_aplicacion?></title>
</head>
<body>
 <TABLE width="100%" border="0" cellspacing="0" cellpadding="0" class="tabla" >
	<TR>
		<TD align="center">
		<TABLE width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000" class="tabla">
		
			<INPUT type="hidden" name="mapa" value="<?php echo $mapa?>">
			<INPUT type="hidden" name="id" value="<?php echo $id?>">

			<TR>
			  <TD colspan="2" class="txtablas">
			  <table width="100%" border="0" cellpadding="1" cellspacing="0" bordercolor="#000" class="tabla">
		  	    <tr>
		  	        <td height="22" colspan="4"><div align="center"><strong>ENTRADA DE INVENTARIOS No<span class="textoproductos1">'.
		  	          $numero_doc.'
		  	        </span></strong><span class="textoproductos1"></span></div></td>
	  	        </tr>
		  	    <tr>
		  	      <td width="25%"><span class="ctablaform"><span class="textoproductos1">Fecha :</span><span class="textoproductos1">&nbsp;&nbsp;</span></span></td>
		  	      <td width="25%"><span class="textotabla01">'.$fecha.'</span></td>
			  		<td width="25%" height="22" class="ctablaform"> <span class="textoproductos1"> &nbsp;&nbsp;Proveedor:&nbsp;&nbsp;</span></td>
			  		<td width="25%" class="ctablaform"><span class="textotabla01">'.$proveedor.'</span></td>
		  	    </tr>
			  	<tr>
			  	  <td width="25%"><span class="ctablaform"><span class="textoproductos1">Factura No :</span><span class="textoproductos1">&nbsp;&nbsp;</span></span></td>
			  	  <td width="25%"><span class="textotabla01">'.$factura.'</span></td>
			  	  <td  class="ctablaform"><span class="textoproductos1">&nbsp;&nbsp;Bodega:</span></td>
			  	  <td  class="ctablaform"><span class="textotabla01">'.$bodega.'</span></td>
		  	    </tr>
				</table>					</TD>
		  </TR>
			
			
			<TR>
			  <TD colspan="2" align="center">
			  <table width="100%" border="0" cellpadding="0" cellspacing="1" bordercolor="#333333" id="select_tablas" class="tabla">
                
				  <tr >
            <td  class="botones1"> <div align="center">CODIGO</div></td>
            <td  class="botones1"><div align="center">CATEGORIA</div></td>
			<td  class="botones1"><div align="center">TIPO PRODUCTO</div></td>
            <td  class="botones1"><div align="center">REFERENCIA</div></td>
            <td   class="botones1"><div align="center">CANTIDAD</div></td>
          </tr>';

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

$codigoHTML.='<tr id="fila_0"  >
				  <td  class="textotabla01">'.$db->cod_fry_pro.'</td>
				  <td class="textotabla01">'.$db->nom_mar.'</td>
                  <td colspan="1" class="textotabla01">'.$db->nom_tpro.'</td>
                  <td  class="textotabla01">'.$db->nom_pro.'</td>
				   <td class="textotabla01"><div align="right">'.number_format($db->cant_dent,0,".",".").'</div></td>
              </tr>';
				  
					$total_cant = $total_cant + $db->cant_dent;
				  } 
				 				 
	$codigoHTML.='<tr >
			  
                  <td colspan="8" >
				  <table  width="100%"  class="tabla"> 
				  <tr>
				  <td class="subfongris"><div align="right">Total entrada </div></td>
				    <td><div align="right"><span class="tituloproductos">'.number_format($total_cant,0,".",".").' 
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
		      <TD width="87%" valign="top" ><span class="textotabla01">'.$obser.' 
		      </span></TD>
			</TR>
</TABLE>
</body>
</html>';

$codigoHTML=utf8_decode($codigoHTML);
$dompdf=new DOMPDF();
$dompdf->load_html($codigoHTML);
ini_set("memory_limit","128M");
$dompdf->render();
$dompdf->stream("Entradas.pdf");
?>