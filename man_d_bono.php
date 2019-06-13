<?php include("lib/database.php");?>
<?php include("js/funciones.php");?>
<?php 

//RECIBE LAS VARIABLES
$vendedor = $_SESSION['global_2'];
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
	if (document.getElementById('empresa').value > 0 && document.getElementById('fecha_venta').value != "" && 
    document.getElementById('vendedor').value > 0  && document.getElementById('nombre1').value != "" && document.getElementById('tipo_bono').value > 0) {
		document.getElementById('guarda').value=1;
    cambia_ruta(document.getElementById("tipo_bono").options[document.getElementById("tipo_bono").selectedIndex].text);
    document.forma.submit();
	}
	else {
		alert('Complete el Formulario, Gracias')
	}

}

function datos_completos(){
  return true;
}

//CARGA LOS DATOS DEL CLIENTE
function carga_cliente(){
  if(document.getElementById('cliente').value == 0){
    document.getElementById('nombre1').value = "";
    document.getElementById('nombre2').value = "";
    document.getElementById('apellido1').value = "";
    document.getElementById('apellido2').value = "";
    document.getElementById('direccion').value = "";
    document.getElementById('tipo_id').value = 0;
    document.getElementById('nit').value = "";
    document.getElementById('dv').value = "";
    document.getElementById('correo').value = "";
    document.getElementById('telefono').value = "";
    document.getElementById('celular').value = "";
    document.getElementById('departamento').value = 0;
    document.getElementById('ciudad').value = 0;
    document.getElementById('credito').value = "";
    document.getElementById('dias').value = "";
    document.getElementById('obser').value = "";
    document.getElementById('fecha_cum').value = "";
    document.getElementById('nombres').focus();
  }
  else{
  <?
    $i=0;
    $sqlc ="SELECT * FROM `cliente` ";    
    $dbc= new  Database();
    $dbc->query($sqlc);
    while($dbc->next_row()){ 
    echo "if(document.getElementById('cliente').value==$dbc->cod_cli){ "; 
    echo "document.getElementById('nombre1').value = '$dbc->nom1_cli'; ";
    echo "document.getElementById('nombre2').value = '$dbc->nom2_cli'; ";
    echo "document.getElementById('apellido1').value = '$dbc->apel1_cli'; "; 
    echo "document.getElementById('apellido2').value = '$dbc->apel2_cli'; "; 
    echo "document.getElementById('tipo_id').value = '$dbc->tipo_id_cli'; "; 
    echo "document.getElementById('direccion').value = '$dbc->dir_cli'; ";  
    echo "document.getElementById('nit').value = '$dbc->iden_cli'; "; 
    echo "document.getElementById('dv').value = '$dbc->digito_cli'; "; 
    echo "document.getElementById('correo').value = '$dbc->email_cli'; "; 
    echo "document.getElementById('telefono').value = '$dbc->tel_cli'; ";
    echo "document.getElementById('celular').value = '$dbc->cel1_cli'; ";    
    echo "document.getElementById('departamento').value = '$dbc->dpto_cli'; ";  
    echo "document.getElementById('ciudad').value = '$dbc->ciu_cli'; "; 
    echo "document.getElementById('credito').value = '$dbc->cupo_cli'; ";   
    echo "document.getElementById('dias').value = '$dbc->plazo_cli'; ";    
    echo "document.getElementById('obser').value = '$dbc->osber_cli'; ";
    echo "document.getElementById('fecha_cum').value = '$dbc->fcun_cli'; ";      
    echo "} ";
    }
  ?>
  }
  
}

//CALCULA EL DIGITO DE VERIFICACION DE UN NIT O CEDULA
function CalcularDv(nit,dv)
{ 
 var vpri, x, y, z, i, nit1, dv1;
 nit1=document.getElementById(nit).value;
    if (isNaN(nit1))
    {
    document.getElementById(dv).value="X";
  alert('El valor digitado no es un numero valido');        
    } else {
  vpri = new Array(16); 
    x=0 ; y=0 ; z=nit1.length ;
    vpri[1]=3;
    vpri[2]=7;
    vpri[3]=13; 
    vpri[4]=17;
    vpri[5]=19;
    vpri[6]=23;
    vpri[7]=29;
    vpri[8]=37;
    vpri[9]=41;
    vpri[10]=43;
    vpri[11]=47;  
    vpri[12]=53;  
    vpri[13]=59; 
    vpri[14]=67; 
    vpri[15]=71;
  for(i=0 ; i<z ; i++)
    { 
     y=(nit1.substr(i,1));
        //document.write(y+"x"+ vpri[z-i] +":");
   x+=(y*vpri[z-i]);
        //document.write(x+"<br>");     
    } 
  y=x%11
    //document.write(y+"<br>");
  if (y > 1)
    {
   dv1=11-y;
    } else {
   dv1=y;
    }
    document.getElementById(dv).value=dv1;
    }
}

//VALIDA QUE ES ENTER
function valida_enter(e){
  var e = (typeof event != 'undefined') ? window.event : e; // IE : Moz 
    if (e.keyCode == 13) {
      carga_cliente2();
    }
}

//CARGA CLIENTE CON NIT
function carga_cliente2(){
var bandera = 0;
  <?
    $sql ="SELECT * FROM `cliente` ";    
    $db= new  Database();
    $db->query($sql);
    while($db->next_row()){ 
    echo "if(document.getElementById('nit').value=='$db->iden_cli'){ "; 
    echo "document.getElementById('cliente').value = '$db->cod_cli'; ";
    echo "document.getElementById('nombre1').value = '$db->nom1_cli'; ";
    echo "document.getElementById('nombre2').value = '$db->nom2_cli'; ";
    echo "document.getElementById('apellido1').value = '$db->apel1_cli'; "; 
    echo "document.getElementById('apellido2').value = '$db->apel2_cli'; "; 
    echo "document.getElementById('tipo_id').value = '$db->tipo_id_cli'; "; 
    echo "document.getElementById('direccion').value = '$db->dir_cli'; ";  
    echo "document.getElementById('dv').value = '$db->digito_cli'; "; 
    echo "document.getElementById('correo').value = '$db->email_cli'; "; 
    echo "document.getElementById('telefono').value = '$db->tel_cli'; ";
    echo "document.getElementById('celular').value = '$db->cel1_cli'; ";    
    echo "document.getElementById('departamento').value = '$db->dpto_cli'; ";  
    echo "document.getElementById('ciudad').value = '$db->ciu_cli'; "; 
    echo "document.getElementById('credito').value = '$db->cupo_cli'; ";   
    echo "document.getElementById('dias').value = '$db->plazo_cli'; ";    
    echo "document.getElementById('obser').value = '$db->osber_cli'; ";
    echo "document.getElementById('fecha_cum').value = '$db->fcun_cli'; ";    
    echo "bandera = 1;";
    echo "} ";
    }  
  ?>

    if(bandera == 0){
      document.getElementById('cliente').value = 0;
      document.getElementById('nombre1').value = "";
      document.getElementById('nombre2').value = "";
      document.getElementById('apellido1').value = "";
      document.getElementById('apellido2').value = "";
      document.getElementById('direccion').value = "";
      document.getElementById('tipo_id').value = 0;
      document.getElementById('nit').value = "";
      document.getElementById('dv').value = "";
      document.getElementById('correo').value = "";
      document.getElementById('telefono').value = "";
      document.getElementById('celular').value = "";
      document.getElementById('departamento').value = 0;
      document.getElementById('ciudad').value = 0;
      document.getElementById('credito').value = "";
      document.getElementById('dias').value = "";
      document.getElementById('obser').value = "";
      document.getElementById('fecha_cum').value = "";
      document.getElementById('nombre1').focus();
      alert('No existe el cliente');
    }

}

//CAMBIA LA RUTA SEGUN EL TIPO DE BONO
function cambia_ruta(valor){
  var ruta = 'man_bono_'+ valor +'.php';
  document.forma.action= ruta;
}
</script>
<script type="text/javascript" src="js/js.js"></script>
<script type="text/javascript" src="js/funciones.js"></script>
</head>
<body <?=$sis?>>
<div id="total">
<form  name="forma" id="forma" action="<?=$ruta?>"  method="post">
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
   <td bgcolor="#D1D8DE" >
   <table width="100%" height="30" border="0" cellspacing="0" cellpadding="0" align="center" > 
      <tr>
        <td width="5" height="30">&nbsp;</td>
        <td width="20" ><img src="imagenes/siguiente.png" alt="Nueno Registro" width="16" height="16" border="0" onClick="datos_completos_sigue()" style="cursor:pointer"/></td>
        <td width="61" class="ctablaform">Continuar</td>
        <td width="21" class="ctablaform"><a href="con_bonos.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
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
    <td class="textotabla01">BONO:</td>
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
		<td class='textotabla1'>Vendedor</td>
		<td><?php echo combo_evento_where("vendedor","vendedor","cod_ven","nom_ven","",""," where estado_vendedor = 1 ORDER BY nom_ven")?></td>
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
        <td width="211"><?php 		
	
		 combo_evento_where_cli("cliente","cliente","cod_cli","CONCAT(nom1_cli,' ',nom2_cli,' ',apel1_cli,' ',apel2_cli,' ',iden_cli)",
      $dbdatos_edi->cod_bod,"onchange='carga_cliente()'"," where estado_cli = 1 order by nombre"); 
		
		?></td>
    <td width="201"><span class="textorojo">*</span></td>
    <td class="textotabla1">Tipo de bono:</td>
		<td><?php echo combo_evento_where("tipo_bono","tipo_bono","cod_tbono","nom_tbono",$dbdatos->tipo_bono,"onchange='conse()'"," where estado_tbono = 1")?></td>
		<td><span class="textorojo">*</span></td>
	</tr>
      <tr>
        <td width="105" class="textotabla1">Primer nombre o razon social:</td>
        <td width="159"><input name="nombre1" id="nombre1" type="text" class="textfield2"  value="<?php echo $dbdatos->nom1_cli?>" />
          <span class="textorojo">*</span>
        <td>&nbsp;</td>
        <td width="105" class="textotabla1">Segundo nombre:</td>
        <td width="159"><input name="nombre2" id="nombre2" type="text" class="textfield2"  value="<?php echo $dbdatos->nom2_cli?>" /></td>
        <td width="20" align="left" class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Primer apellido:</td>
        <td><input name="apellido1" id="apellido1" type="text" class="textfield2"  value="<?php echo $dbdatos->apel1_cli?>" /></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textotabla1">Segundo apellido:</td>
        <td><input name="apellido2" id="apellido2" type="text" class="textfield2"  value="<?php echo $dbdatos->apel2_cli?>" /></td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td width="84" class="textotabla1">Tipo ID</td>
        <td colspan='4'><?php echo combo_evento_where("tipo_id","tipo_identificacion","cod_tiden","nom_tiden",$dbdatos->tipo_id_cli,""," where estado_tiden = 1");?>
          <span class="textorojo">*</span></td>
      </tr>    
      <tr>
        <td width="84" class="textotabla1">Nit/CC:</td>
        <td width="220"><input name="nit" id="nit" type="text" class="textfield2" onblur="CalcularDv('nit','dv')" onkeypress="valida_enter(event)" value="<?php echo $dbdatos->iden_cli?>"  />
          <input name="dv" id="dv" type="text" maxlength="1" class="textfield0010" readonly='readonly' value="<?php echo $dbdatos->digito_cli?>"  />
          <span class="textorojo">*</span></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textotabla1">Direccion:</td>
        <td><input name="direccion" id="direccion" type="text" class="textfield2"  value="<?php echo $dbdatos->dir_cli?>" /></td>
        <td class="textorojo">&nbsp;</td>
      </tr>    
      <tr>
        <td class="textotabla1">Telefono:</td>
        <td><input name="telefono" id="telefono" type="text" class="textfield2"  value="<?php echo $dbdatos->tel_cli?>" /></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textotabla1">Celular:</td>
        <td><input name="celular" id="celular" type="text" class="textfield2"  value="<?php echo $dbdatos->cel1_cli?>" /></td>
        <td class="textorojo">&nbsp;</td>
        </tr>
      <tr>
        <td class="textotabla1">Departamento:</td>
        <td><?php combo_evento("departamento","departamento","cod_departamento","desc_departamento",$dbdatos->dpto_cli,"onchange='cargar_ciudad(\"departamento\",\"ciudad\")'","desc_departamento"); ?></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textotabla1">Ciudad:</td>
        <td><?php 
		if ($codigo == 0) {
			combo_evento_where("ciudad","ciudad","cod_ciudad","desc_ciudad","","","");
		}
		else {
		combo_evento_where("ciudad","ciudad","cod_ciudad","desc_ciudad",$dbdatos->ciu_cli,""," where departamento = $dbdatos->dpto_cli ");
		}?></td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">E-mail:</td>
        <td><input name="correo" id="correo" type="text" class="textfield2"  value="<?php echo $dbdatos->email_cli?>" /></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textotabla1">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="textorojo">&nbsp;</td>
        </tr>
	  <tr>
	    <td class="textotabla1">Valor credito:</td>
	    <td><input name="credito" id="credito" type="text" class="textfield2" onkeypress="return validaInt()"  value="<?php echo $dbdatos->cupo_cli?>" /></td>
	    <td class="textorojo">&nbsp;</td>
	    <td class="textotabla1">Dias factura: </td>
	    <td><input name="dias" id="dias" onkeypress="return validaInt('%d', this,event)"  type="text" class="textfield2"  value="<?php echo $dbdatos->plazo_cli?>" /></td>
	    <td class="textorojo">&nbsp;</td>
	  </tr>
    <tr>
      <td class="textotabla1">Cumpleaños:</td>
      <td><input name="fecha_cum" type="text" class="fecha" id="fecha_cum" readonly="1" value="<?php echo $db->fcun_cli?>"/><img src="imagenes/date.png" alt="Calendario4" name="calendario4" width="18" height="18" id="calendario4" style="cursor:pointer"/></td>
      <td class="textotabla1">Observaciones:</td>
      <td><input name="obser" id="obser" type="text" class="textarea" value="<?php echo $dbdatos->obser_cli?>" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
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
Calendar.setup(
        {
          inputField  : "fecha_cum",      
          ifFormat    : "%Y-%m-%d",    
          button      : "calendario4" ,  
          align       :"T3",
          singleClick :true
        }
      );  		
</script>
</body>
</html>