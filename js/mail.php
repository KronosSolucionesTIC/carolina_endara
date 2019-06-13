<?

$fondo= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
}
-->
</style>
</head>

<body>
<table width="545" cellpadding="0" cellspacing="0"  bgcolor="#CCCCFF">
  <tr>
    <td valign="top" ><table cellspacing="2" cellpadding="2"  align="center">
      <tbody>
        <tr>
          <td width="439"></td>
        </tr>
        <tr>
          <td><div align="center"><img src="http://www.lasmarcas.net/images/logomail.jpg" width="262" height="105" /></div></td>
        </tr>
        <tr>
          <td><span class="style1"><a href="http://www.lasmarcas.net">www.lasmarcas.net</a>    es una compañía joven, que dedica sus esfuerzos a  ofertar  las mejores <strong>opciones y alternativas </strong> en prendas y accesorios de vestir. <br />
              <a href="http://www.lasmarcas.net"></a></span></td>
        </tr>
        <tr>
          <td><p align="justify"><span class="style1"><a href="http://www.lasmarcas.net">www.lasmarcas.net</a>    es una compañía joven, que dedica sus esfuerzos a  ofertar  las mejores <strong>opciones y alternativas </strong> en prendas y accesorios de vestir. <br />
                <a href="http://www.lasmarcas.net">www.lasmarcas.net</a>  conoce  las    preferencias y gustos de sus clientes,  busca  ofrecer  prendas y accesorios de   vestir de las más <strong>reconocidas </strong> marcas del mundo, las cuales   ofrece a  precios que se encuentran al alcance de  los consumidores   colombianos.<br />
              
            <strong>“Las mejores marcas a su alcance”</strong>  es la   promesa de servicio que nuestra compañía garantiza a sus clientes.<br />
            <a href="http://www.lasmarcas.net">www.lasmarcas.net</a>  nuestros clientes son   personas modernas,  informadas, que se preocupan por estar actualizadas y   preparadas para toda ocasión. <br />
            Nuestros clientes  se preocupan por su   apariencia y son reconocidos  por usar prendas y accesorios de vestir  de las   mejores marcas.  <br />
            <a href="http://www.lasmarcas.net"><strong>www.lasmarcas.net</strong></a>  posee   convenio con los principales fondos de empleados del país, confirme con su fondo   si tiene convenio con nosotros, de lo contrario invítelo a formar parte de   nuestro  grupo de clientes, y reciba por esta gestión un gran  incentivo.   Contáctenos a través de nuestro portal</span>.   </p></td>
        </tr>
      </tbody>
    </table>
        <table cellspacing="2" cellpadding="2" width="430" align="center">
          <tbody>
          </tbody>
        </table>
      <br /></td>
  </tr>
  
  <tr>
    <td valign="top"> </td>
  </tr>
</table>
</body>
</html>';

//mail("leonardo@kaome.com", "las marcas", $fondo, "From: leodistrital@yahoo.com");


?>

<?php
include ("email.inc.php");
$e = new Email();
$e->isHTML = true;
$e->setEmailFrom("Nombre Desde", "leonardo@kaome.com");
$e->addEmailFor("Nombre Para", "leonardo@kaome.com");
$e->setSubject("Asunto");
$e->setBody($fondo);
if ($e->send()) {
	echo "Enviado correctamentexxxxxx";	
} else {
	echo "No enviado";
}
?>

