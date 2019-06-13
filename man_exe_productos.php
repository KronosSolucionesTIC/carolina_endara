<? include("lib/database.php")?>
<? include("js/funciones.php")?>
<?
if($guardar == 1 and $codigo==0){
					
		$campos="(cod_mar_pro,cod_tpro_pro,nom_pro,cod_fry_pro)";
		for ($ii=1 ;  $ii <= $val_inicial; $ii++) 
			{

			//VALIDA SI ESTA CREADA LA CATEGORIA
			$nom = $_POST["CATEGORIA_".$ii];

			$dbc = new database();
			$sqlc = "SELECT * FROM marca
			WHERE nom_mar = '$nom'";
			$dbc->query($sqlc);
			if($dbc->next_row()){
				$cat = $dbc->cod_mar;
			}
			else{
				$campo_mar="(nom_mar,estado_marca)";
				$valores="('".$_POST["CATEGORIA_".$ii]."','1')" ; 
				$cat = insertar_maestro("marca",$campo_mar,$valores); 
			}
			//

			//VALIDA SI ESTA CREADA EL TIPO DE PRODUCTO
			$tipo = $_POST["TIPO_".$ii];

			$dbt = new database();
			$sqlt = "SELECT * FROM tipo_producto
			INNER JOIN marca ON marca.cod_mar = tipo_producto.cod_marca
			WHERE nom_tpro = '$tipo' AND nom_mar = '$nom'";
			$dbt->query($sqlt);
			if($dbt->next_row()){
				$tipo_pro = $dbc->cod_mar;
			}
			else{
				$campos_tpro ="(nom_tpro,desc_tpro,cod_marca,estado_tipo_producto)";
				$valores ="('".$_POST["TIPO_".$ii]."','','".$cat."','1')" ;
				$tipo_pro =insertar_maestro("tipo_producto",$campos_tpro,$valores); 
			}
			//
			
			//INGRESA REGISTROS
			$valores="('".$cat."','".$tipo_pro."','".$_POST["NOMBRE_".$ii]."','".$_POST["CODIGO_".$ii]."')";					
			$cod_pro =insertar_maestro("producto",$campos,$valores);

			//INGRESA EL PRECIO
			$campos_precio = "(cod_lista,cod_pro,pre_list)";
			$valores="('".$_POST["lista"]."','".$cod_pro."','".$_POST["PRECIO_".$ii]."')";					
			$error=insertar("det_lista",$campos_precio,$valores);

			//INGRESA EXISTENCIAS
			kardex("suma",$cod_pro,$_POST["bodega"],$_REQUEST["CANTIDAD_".$ii],$_REQUEST["CANTIDAD_".$ii],'1');
			
		}
	
	if ($error==1) {
		echo "<script language='javascript'> alert('Se ingreso correctamente') </script>" ;
	}
	else
		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
    <? inicio() ?>
    <script language="javascript">
function datos_completos(){ 
		document.getElementById('procesar').style.display = "none";
		document.getElementById('guardando').style.display = "inline";
		return true;	
}
</script>
	<link rel="stylesheet" type="text/css" href="css/excel.css">
    <script type="text/javascript" src="js/funciones.js"></script>
	<script type="text/javascript" src="js/js.js"></script>
	</head>
	<body <?=$sis?>>
    <form  name="forma" id="forma" action="man_exe_productos.php"  method="post">
	  <h1>SUBIR CUENTAS POR EXCEL
		    <input type="hidden" name="editar"   id="editar"   value="<?=$editar?>">
            <input type="hidden" name="insertar" id="insertar" value="<?=$insertar?>">
            <input type="hidden" name="eliminar" id="eliminar" value="<?=$eliminar?>">
            <input type="hidden" name="codigo" id="codigo" value="<?=$codigo?>" />
	  </h1>
		<table border="0" width="100%" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
				  <th>Lista de precio</th>
				  <th><?php combo("lista","listaprecio","cos_list","nom_list",$dbdatos->cod_lista); ?></th>
				  <th>Bodega:</th>
                  <th><?php combo("bodega","bodega","cod_bod","nom_bod",$dbdatos->cod_bod_cli); ?></th>
                  <th></th>
                  <th></th>
				  <th></th>
				</tr>
				<tr>
				  <th>CATEGORIA</th>
				  <th>TIPO PRODUCTO</th>
				  <th>NOMBRE</th>
                  <th>CODIGO</th>
                  <th>PRECIO</th>
                  <th>EXISTENCIAS</th>
				  <th>OBSERVACION</th>
				</tr>
		    </thead>
			<tbody>
			  <?php
					//incluimos la clase
					require_once 'php/ext/PHPExcel-1.7.7/Classes/PHPExcel/IOFactory.php';
					
					//cargamos el archivo que deseamos leer
					$objPHPExcel = PHPExcel_IOFactory::load('xls/PRODUCTOS.xls');
					//obtenemos los datos de la hoja activa (la primera)
					$objHoja=$objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
					
					//recorremos las filas obtenidas
					$jj=1;
					foreach ($objHoja as $iIndice=>$objCelda) {
						//imprimimos el contenido de la celda utilizando la letra de cada columna
					echo "<tr>";

						echo "<td><span class='textfield01'><INPUT type='hidden' name='CATEGORIA_$jj' id='CATEGORIA_$jj' value='$objCelda[A]'>$objCelda[A]</span></td>";
						echo "<td><span class='textfield01'><INPUT type='hidden' name='TIPO_$jj' id='TIPO_$jj' value='$objCelda[B]'>$objCelda[B] </span></td>";
						echo "<td><span class='textfield01'><INPUT type='hidden' name='NOMBRE_$jj' id='NOMBRE_$jj' value='$objCelda[C]'>$objCelda[C] </span></td>";
						echo "<td><span class='textfield01'><INPUT type='hidden' name='CODIGO_$jj' id='CODIGO_$jj' value='$objCelda[D]'>$objCelda[D] </span></td>";
						echo "<td><span class='textfield01'><INPUT type='hidden' name='PRECIO_$jj' id='PRECIO_$jj' value='$objCelda[E]'>$objCelda[E] </span></td>";
						echo "<td><span class='textfield01'><INPUT type='hidden' name='CANTIDAD_$jj' id='CANTIDAD_$jj' value='$objCelda[F]'>$objCelda[F] </span></td>";


					//VALIDA SI ESTA CREADO EL CODIGO
					$bandera = 0;
					$dbco = new database();
					$sqlco = "SELECT * FROM producto
					WHERE cod_fry_pro = '$objCelda[D]'";
					$dbco->query($sqlco);
					if($dbco->next_row()){
						$bandera = 1;
						echo "<td><span class='textfield01'><INPUT type='hidden' name='COD_$jj' id='COD_$jj' value='1'><img src='imagenes/error.png'/> EL CODIGO YA ESTA CREADO</span></td>";
					}
					else{
						echo "<td><span class='textfield01'><INPUT type='hidden' name='COD_$jj' id='COD_$jj' value='2'><img src='imagenes/ok.png'/></span></td>";
					}
					//

					echo "</tr>";
						$jj++;
					}
				?>
               	<tr>
               	  <th>&nbsp;</th>
               	  <th>&nbsp;</th>
               	  <th>&nbsp;</th>
               	  <th>&nbsp;</th>
               	  <th>&nbsp;</th>
               	  <th>&nbsp;</th>
               	  <th>&nbsp;</th>
           	  </tr>
           	  <?php 
              if($bandera != 1){
              ?>
              <tr>
				  <th colspan="7"><div align="center">
				  <div id="procesar"><input type='button'  class='botones' value='PROCESAR' onclick='cambio_guardar()' /></div>
                  <div id="guardando" style="display:none"><img src="imagenes/guardando.gif" width="21" height="21" align="absmiddle" />GUARDANDO...</div>	
				    <input type="hidden" name="guardar" id="guardar" value='0' />
				    <input type="hidden" name="val_inicial" id="val_inicial" value="<? echo $jj-1;?>" />
			      </div></th>
			  </tr>
			  <?php } else {?>
              <tr>
				  <th colspan="7">HAY ALGUN CODIGO YA EN USO</th>
			  </tr>
			  <?php } ?>
		    </tbody>
			<tfoot>
				<td colspan="4"></td>
				</tfoot>
		</table>
    </form>
	</body>
</html>