<? 
include("lib/sesion.php");
include("lib/database.php");

$txt_usuario = $_POST["txt_usuario"];
$txt_clave = $_POST["txt_clave"];
 
	$db= new  Database();
	$sql="SELECT cod_usu, nom_usu, log_usu FROM permisos INNER JOIN usuario ON cod_usu= cod_usu_per WHERE log_usu='$txt_usuario'  AND pas_usu='$txt_clave' ";

	$db->query($sql);
	if($db->next_row()) {
			$global[3]=$db->nom_usu; 
			$global[4]=$db->log_usu;
		    $global[2]=$db->cod_usu;
			
			$_SESSION['global_2']=$db->cod_usu;
			$_SESSION['global_3']=$db->nom_usu;
			$_SESSION['global_4']=$db->log_usu;

	}

	if( $db->num_rows()>0 ){
		$usu_atu=1;
	}
	else {
		$usu_atu=0;
	}
	$db->close();
?>


