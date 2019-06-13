<? include("lib/database.php");?>
<? include("js/funciones.php");?>
<? 
//RECIBE VALORES
$guardar = 1;
$fec_ini = $_REQUEST['fec_ini'];
$fec_fin = $_REQUEST['fec_fin'];

if($guardar==1) { // RUTINA PARA  INSERTAR REGISTROS NUEVOS
	$campos="fec_ini='".$_REQUEST['fec_ini']."',fec_fin='".$_REQUEST['fec_fin']."'";
	
	$error=editar("datos_contables",$campos,'cod_dato',1); 
	if ($error==1) {
		echo "<script language='javascript'> alert('Se guardo correctamente') </script>" ; 
	}
	else
		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 
}

?>