<?  include("lib/database.php"); 
 include("js/funciones.php"); ?>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript" src="calendario/javascript/calendar.js"></script>
<script type="text/javascript" src="calendario/javascript/calendar-es.js"></script>
<script type="text/javascript" src="calendario/javascript/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="calendario/styles/calendar-win2k-cold-1.css" title="win2k-cold-1" />
<script src="utilidades.js" type="text/javascript"> </script>
<title>
<?=$nombre_aplicacion?>
</title>
<script type="text/javascript">
var tWorkPath="menus/data.files/";
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

function abrir() {
    var arreglo_cliente = '';		
	var cod = 0;
    var cod_cliente= document.getElementById('cliente').value;	
	if (cod_cliente=='0'){
		agregar_cliente_masivo();
		arreglo_cliente = document.getElementById('arreglo_clientes').value;
	}
	else {
	    arreglo_cliente = cod_cliente +',';
		cod = 1;
	}	
	if(document.getElementById('tipo_informe').value==1) {
		imprimir_inf("con_carte_factu_cli_facturas1.php",''+cod+'&arreglo='+arreglo_cliente,'mediano');
	}
	else 
		if(document.getElementById('tipo_informe').value==2) {
			imprimir_inf("con_carte_factu_cli_abonos1.php",''+cod+'&arreglo='+arreglo_cliente,'mediano');
		}
		else 
			if(document.getElementById('tipo_informe').value==3) {
				imprimir_inf("con_carte_factu_cli1.php",''+cod+'&arreglo='+arreglo_cliente,'mediano');
			}
}

function agregar_cliente_masivo() {
	var cod_cliente=0;
	<? 
		$db = new Database();	
		$sql="SELECT distinct cod_bod from cliente where cod_bod  in  (select distinct cod_cli from m_factura F inner join cartera_factura CF ON  F.cod_fac = CF.cod_fac where F.tipo_pago = 'Credito' and CF.estado_car <> 'CANCELADA' ) ";
		$db->query($sql);
		while($db->next_row()){
			 echo "cod_cliente = '$db->cod_bod';";
			 echo "	document.getElementById('arreglo_clientes').value+=cod_cliente+',';";
		}
		$db->close();
	?>	
}

</script>
<script type="text/javascript" src="js/funciones.js"></script>
<script type="text/javascript" src="informes/inf.js"></script>
<link href="css/styles.css" rel="stylesheet" type="text/css">
</head>
<body  <?=$sis?> >
<table align="center">
  <tr>
    <td valign="top" ><table width="624" border="0" cellspacing="0" cellpadding="0" align="center" >
        <tr>
          <td><table width="557" border="0"  cellpadding="0" align="center">
              <tr>
                <td width="301"  class="ctablasup" >OPCION POR CLIENTE</td>
                <td width="111"  class="ctablasup" >INFORME</td>
                <td  class="ctablasup"  width="137">INFORME</td>
              </tr>
              <tr>
                <td ><?
                 combo_evento_where1("cliente","cliente ","cod_cli","CONCAT(nom1_cli,apel1_cli)","", " where estado_cli = 1 order by nombre ");  	
		?>
                </td>
                <td ><div align="center">
                    <select  id="tipo_informe" name="tipo_informe">
                      <option value="1">Facturas</option>
                      <option value="2">Abonos</option>
                      <option value="3">Cartera</option>
                    </select>
                  </div></td>
                <td aling='center' ><table width='100%' border='0' cellspacing='0' cellpadding='0'>
                    <tr>
                      <td align='center'><input type='hidden' name='codigo'> <input type="hidden" textarea  name="arreglo_clientes" id="arreglo_clientes" cols="40" rows="4" value = "" >
                    </textarea></td>
                      <td align='center'><img src='imagenes/mirar.png' width='16' height='16'  style="cursor:pointer"  onclick="abrir()" /></td>
                    </tr>
                  </table></td>
            </table ></td>
        </tr>
        <tr>
          <td><img src="imagenes/lineasup3.gif" width="624" height="4" /></td>
        </tr>
        <tr>
          <td height="30" align="center" valign="bottom"><table>
              <tr>
                <td></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>