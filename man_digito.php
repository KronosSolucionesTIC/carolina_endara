<?php
include "lib/sesion.php";
include("lib/database.php");
include("js/funciones.php");

if($guardar==1) { // RUTINA PARA  INSERTAR REGISTROS NUEVOS
  for($i=1; $i <= $_REQUEST['contador']; $i++){
    $campos="digito_cli='".$_REQUEST['digito_'.$i]."'";
  
    $error=editar("cliente",$campos,'cod_cli',$_REQUEST['cod_cli_'.$i]); 
  }
    
  if ($error==1) {
    header("Location: con_cliente.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
  }
  else
    echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 
}

?>
<script language="javascript">
function datos_completos(){  
  return true;
}

//CALCULA EL DIGITO DE VERIFICACION DE UN NIT O CEDULA
function Calcular(){
var contador = parseInt(document.getElementById('contador').value);

  for(j = 1; j <= contador; j++){ 
    var vpri, x, y, z, i, nit1, dv1;
    nit1=document.getElementById('iden_'+ j ).value;
    
    if (isNaN(nit1)){
      document.getElementById('digito_'+ j ).value="X";
      alert('El valor digitado no es un numero valido ' + nit1);        
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
      
      for(i=0 ; i<z ; i++){ 
        y=(nit1.substr(i,1));
        //document.write(y+"x"+ vpri[z-i] +":");
        x+=(y*vpri[z-i]);
        //document.write(x+"<br>");     
      } 
        y=x%11
        //document.write(y+"<br>");
      if(y > 1){
        dv1=11-y;
      } else {
        dv1=y;
      }
    }

    document.getElementById('digito_'+ j).value=dv1;
  }
}
</script>
 <link href="styles.css" rel="stylesheet" type="text/css" />
 <link href="../styles.css" rel="stylesheet" type="text/css" />
 <style type="text/css">
<!--
.Estilo1 {font-size: 9px}
.Estilo2 {font-size: 9 }
-->
 </style>
 <link href="../css/styles.css" rel="stylesheet" type="text/css" />
 <link href="../css/stylesforms.css" rel="stylesheet" type="text/css" />
 <script type="text/javascript" src="js/funciones.js"></script>
 <title><?=$nombre_aplicacion?> -- SALDOS DE BODEGA --</title>
<form  name="forma" id="forma" action="man_digito.php"  method="post"> 
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
        </table>          </TD>
      </TR>
      

      <TR>
        <TD align="center">
        <table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="#333333" id="select_tablas" >
          <tr >
            <td  class="botones1"><div align="center">CODIGO</div></td>
            <td   class="botones1"><div align="center">NOMBRE</div></td>
            <td  class="botones1"><div align="center">NIT</div></td>
            <td  class="botones1"><div align="center">DIGITO</div></td>
          </tr>
                
          <?
        $j=1;
        $sql = " SELECT * FROM cliente WHERE estado_cli=1";
          $db->query($sql);
          $estilo="formsleo";
          while($db->next_row()){   
          
          echo "<tr>";                
          echo "<td  class='textotabla01'><input type='visible' value='$db->cod_cli' name='cod_cli_$j'>$db->cod_cli</td>";  
          echo "<td  class='textotabla01'><div align='center'>$db->nom1_cli</div></td>";  
          echo "<td  class='textotabla01'><input type='visible' value='$db->iden_cli' name='iden_$j' id='iden_$j'></td>";
          echo "<td  class='textotabla01'><input type='visible' name='digito_$j' id='digito_$j' value='$db->digito_cli'></td>";  
          echo "</tr>";  

          $j ++;
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

 
<TABLE width="70%" border="0" cellspacing="0" cellpadding="0">
  
  <TR>
    <TD colspan="3" align="center"><input name="button" type="button"  class="botones" onClick="Calcular()" value="Calcular">
        <input name="button" type="button"  class="botones"  id="cer" onClick="cambio_guardar()" value="Guardar">
      <input name="contador" id='contador' type="visible" value="<?=$j?>">
      </TD>
  </TR>

  <TR>
    <TD width="1%" background="images/bordefondo.jpg" style="background-repeat:repeat-y" rowspan="2"></TD>
    <TD bgcolor="#F4F4F4" class="pag_actual">&nbsp;</TD>
    <TD width="1%" background="images/bordefondo.jpg" style="background-repeat:repeat-y" rowspan="2"></TD>
  </TR>
  <tr>
    <td height="30"  > <input type="visible" name="guardar" id="guardar" />
  </td>
  <TR>
    <TD align="center">
</form>