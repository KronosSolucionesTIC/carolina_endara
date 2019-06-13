<? include("conf/clave.php")?>
<? 
if(!isset($verifica_seg)) {
  setcookie("verifica_seg", "1", time() + 86400); 
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BLUE Version 1.0</title>
<link href="imagenes/icono.png" type="image/x-icon" rel="shortcut icon">
</head>
<script language="javascript">


function DetectaBloqueoPops()
{

  var popup
  try
  {
    if(!(popup = window.open('about:blank','_blank','width=0,height=0')))
      throw "ErrPop"
    popup.close()
  }
  catch(err)
  {
    if(err=="ErrPop"){
      msj = "Esta Pagina funciona con ventanas emergentes recuerde habilitarlas"
       alert(msj);  
   }
    else
    {
      msj1="Hubo un erro en la página.nn"
      msj1+="Descripción del error: " + err.description + "nn"
     }
  }
 
 
}
function salta(e)
{
tecla = (document.all) ? e.keyCode : e.which
  if(tecla==13)
  {
    //window.e.keyCode=0; 
    document.getElementById("txt_clave").focus();
  }
}

function enviar(e,conf)
{
tecla = (document.all) ? e.keyCode : e.which
if(tecla==13 || conf==1)
{

  if (document.getElementById("txt_usuario").value !="" & document.getElementById("txt_clave").value != "") {
    document.getElementById("confirmacion").value =1;
  document.forma.submit();
  }
  else 
  {
      alert("Datos Incompletos");
    document.getElementById("txt_usuario").focus();
  }
  return false;
}


}


<? if ($confirmacion!=1 || $confirmacion!=1){ ?>
  DetectaBloqueoPops();
<? } ?>



</script>
<style type="text/css">
td img {display: block;}
</style>
<link href="css/styles.css" rel="stylesheet" type="text/css">
<body>
<?
if ($_POST['confirmacion']==1){
    include ("validar.php");
}

if ($usu_atu==1 && $_POST['confirmacion']==1){
  $usu_atu==0; 
  $confirmacion==0;
?>
<script type="text/javascript">
  menu=window.open('aplicacion.php','');
  menu.focus();
</script>
<?
}

//$refresca=1;

if($usu_atu==0 && $_POST['confirmacion']==1){
?>
<script type="text/javascript">
  alert('Usuario No Autorizado, Rectifique sus Datos ');
</script>
<?
}
?>
<form  action="inicio.php"  name="forma" method="post" >
<div class="fondo">
<table width="860"  border="0" align="center" cellpadding="0" cellspacing="0">  
  <tr>
    <td height="272"  ><img src="imagenes/cabezotelog.png" width="876" height="220"></td>
  </tr>
    <tr>
    <td  ></td>
  </tr>
  <tr>
    <td  align="center"><table width="88%" border="0" cellpadding="0" cellspacing="0" >
      <tr>
        <!--TABLA INTERNA DE USUARIO Y CLAVE-->
        <td width="255" colspan="3" align="center"><table width="80%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="190" class="textotabla2"><div align="right">Usuario:</div></td>
            <td width="427" class="textotabla2"><div align="center">
              <input name="txt_usuario" id="txt_usuario" type="text" class="textotabla01" size="30" onKeyDown="salta(event)"/>
            </div></td>
            </tr>
          <tr>
            <td class="textotabla2"><div align="right">Clave:</div></td>
            <td class="textotabla2"><div align="center">
              <input name="txt_clave" id="txt_clave" type="password" class="textotabla01" size="30" onKeyDown="enviar(event,0)" />
              <input name="confirmacion" type="hidden" id="confirmacion" value="0" />
            </div></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="center"><img src="imagenes/entrar_boton.jpg" alt="" width="116" height="29" style="cursor:pointer" onClick="enviar(event,1)"></div></td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2"><div align="center" class="bradleyazul16"><em>Desarrollado por <strong>Grupo Soluciones Tecnologicas sas</a></strong> copyright
              <?=date("Y");?>
              </STRONG></FONT></em></div></td>
            </tr>
          <tr>
            <td colspan="2" align="right"></td>
            </tr>
          </table></td>
        <!--FIN TABLA INTERNA DE USUARIO Y CLAVE-->
        </tr>
    </table></td>
    </tr>
  </table>
  </div>
</form>
<script language="javascript">
<?
if($refresca==1)
{
?>
document.forma.submit()

<?
}
else 
{
?>
document.forma.txt_usuario.focus();
<?
}
?>

</script>
</body>