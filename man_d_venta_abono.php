<?php include("lib/database.php");?>
<?php include("js/funciones.php");?>
<?php 

//RECIBE LAS VARIABLES
$vendedor = $_SESSION['global_2'];

//CONSULTA LOS DATOS DEL APARTADO
$db = new database();
$sql = "SELECT *,CONCAT(nom1_cli,' ',nom2_cli,' ',apel1_cli,' ',apel2_cli,' ',iden_cli) as nombre FROM m_apartado
INNER JOIN cliente ON cliente.cod_cli = m_apartado.cod_cli
WHERE cod_apa = $apartado";
$db->query($sql);
$db->next_row();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Facturación</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Estilo1 {font-size: 12px}
</style> 

<?php inicio() ?>
<script language="javascript">


function datos_completos_sigue()
{  
	if (document.getElementById('empresa').value > 0 && document.getElementById('fecha_venta').value != "") {
    document.forma.submit();
	}
	else {
		alert('Complete el Formulario, Gracias')
	}

}

function datos_completos(){
  return true;
}

//VALIDA QUE ES ENTER
function valida_enter(e){
  var e = (typeof event != 'undefined') ? window.event : e; // IE : Moz 
    if (e.keyCode == 13) {
      carga_cliente2();
    }
}
</script>
<script type="text/javascript" src="js/js.js"></script>
<script type="text/javascript" src="js/funciones.js"></script>
</head>
<body <?=$sis?>>
<div id="total">
<form  name="forma" id="forma" action="man_venta_abono.php"  method="post">
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
   <td bgcolor="#D1D8DE" >
   <table width="100%" height="30" border="0" cellspacing="0" cellpadding="0" align="center" > 
      <tr>
        <td width="5" height="30">&nbsp;</td>
        <td width="20" ><img src="imagenes/siguiente.png" alt="Nueno Registro" width="16" height="16" border="0" onClick="datos_completos_sigue()" style="cursor:pointer"/></td>
        <td width="61" class="ctablaform">Continuar</td>
        <td width="21" class="ctablaform"><a href="con_venta.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
        <td width="22" class="ctablaform"><a href="con_cargue.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"></a></td>
        <td width="70" class="ctablaform">&nbsp;</td>
        <td width="21" class="ctablaform"></td>
        <td width="60" class="ctablaform">&nbsp;</td>
        <td width="24" valign="middle" class="ctablaform">&nbsp;</td>
        <td width="193" valign="middle">
          <input type="hidden" name="editar"   id="editar"   value="<?=$editar?>">
		  <input type="hidden" name="insertar" id="insertar" value="<?=$insertar?>">
		  <input type="hidden" name="eliminar" id="eliminar" value="<?=$eliminar?>">
          <input type="hidden" name="codigo" id="codigo" value="<?=$codigo?>" /> </td>
        
        <td width="67" valign="middle">&nbsp;</td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td height="4" valign="bottom"><img src="imagenes/lineasup3.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td class="textotabla01">FACTURA DE VENTA :</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td bgcolor="#D1D8DE" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
        <td width="84" class="textotabla1">Empresa:</td>
        <td width="182" class="textotabla1">
          <?
		
		$sql="select distinct punto_venta.cod_rso as valor , nom_rso as nombre from punto_venta  inner join  rsocial  on punto_venta.cod_rso=rsocial.cod_rso where cod_ven=$vendedor";
		
		
		 combo_sql("empresa","rsocial","valor","nombre",$dbdatos_edi->nom_rso,$sql); 
		 
		 
		 ?>        </td>
        <td width="17" class="textorojo">*</td>
		<td ></td>
		<td></td>
		<td class='textorojo'>*</td>
       </tr>
      
       <tr>
         <td class="textotabla1">Bodega:</td>
         <td>
		 <?
		  $sql="select distinct punto_venta.cod_bod as valor , nom_bod as nombre from punto_venta  inner join  bodega  on punto_venta.cod_bod=bodega.cod_bod where cod_ven=$vendedor";
		 combo_sql("bodega","rsocial","valor","nombre",$dbdatos_edi->cod_bod,$sql); 
		 ?></td>
         <td><span class="textorojo">*</span></td>
         <td width="55" class="textotabla1" valign="top">Fecha</td>
         <td><input name="fecha_venta" type="text" class="fecha" id="fecha_venta" readonly="1" value="<?php echo date("Y-m-d");  ?>"/>
		 
           <span class="textorojo"><img src="imagenes/date.png" alt="Calendario3" name="calendario3" width="18" height="18" id="calendario3" style="cursor:pointer"/></span></td>
         <td><span class="textorojo">*</span></td>
       </tr>
	<tr>
		<td width="55" class="textotabla1" valign="top">Cliente:</td>
        <td width="211"><?php echo $db->nombre ?></td>
    <td width="201"><span class="textorojo">*</span></td>
    <td class="textotabla1">Tipo:</td>
		<td><select name='tipo' id='tipo' ><option value='A' selected>A</option><option value='B'>B</option></select></td>
		<td></td>
	</tr>
	   <tr>
         <td colspan="6" class="textotabla1" >
         	   </table>
		  
	    </td>
	  </tr>
	  <tr> 
		  <td colspan="8" >		  </td>
	  </tr>
    </table>
<tr>
  <tr>
    <td>
	<input type="hidden" name="val_inicial" id="val_inicial" value="<?php if($codigo!=0) echo $jj-1; else echo "0"; ?>" />
	<input type="hidden" name="guarda" id="guarda" />
  <input type="hidden" name="cliente" id="cliente" value="<?php echo $db->cod_cli?>"/>
  <input type="hidden" name="apartado" id="apartado" value="<?php echo $apartado ?>"/>
		 <?php  if ($codigo!="") $valueInicial = $aa; else $valueInicial = "1";?>
	   <input type="hidden" id="valDoc_inicial" value="<?=$valueInicial?>"> 
	   <input type="hidden" name="cant_items" id="cant_items" value=" <?php  if ($codigo!="") echo $aa; else echo "0"; ?>">
	</td>
  </tr>
</table>
</form> 
</div>
<script type="text/javascript">	
Calendar.setup(
				{
					inputField  : "fecha_venta",      
					ifFormat    : "%Y-%m-%d",    
					button      : "calendario3" ,  
					align       :"T3",
					singleClick :true
				}
			); 		
</script>
</body>
</html>