<?php include("lib/database.php");?>
<?php include("js/funciones.php");?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BLUE Version 2.0</title>
<link href="imagenes/icono.png" type="image/x-icon" rel="shortcut icon">
<script type="text/javascript">var tWorkPath="menus/data.files/";</script>
<script type="text/javascript" src="menus/data.files/dtree.js"></script>
<link href="css/styles.css" rel="stylesheet" type="text/css">

<style type="text/css">
/* Inset 3D Curved */
.inset {background: transparent; width:99%; height:99%;  }
.inset h1, .inset p {margin:0 1px;}
.inset h1 {font-size:1em; color:#fff; letter-spacing:1px;}
.inset p {padding-bottom:0.5em;}

.inset .top, .inset .bottom {display:block; background:transparent; font-size:1px;}
.inset .b1, .inset .b2, .inset .b3, .inset .b4, .inset .b1b, .inset .b2b, .inset .b3b, .inset .b4b {display:block; overflow:hidden;}
.inset .b1, .inset .b2, .inset .b3, .inset .b1b, .inset .b2b, .inset .b3b {height:1px;}
.inset .b2 {background:#ccc; border-left:1px solid #999; border-right:1px solid #aaa;}
.inset .b3 {background:#ccc; border-left:1px solid #999; border-right:1px solid #ddd;}
.inset .b4 {background:#ccc; border-left:1px solid #999; border-right:1px solid #eee;}


.inset .b4b {background:#ccc; border-left:1px solid #aaa; border-right:1px solid #fff;}
.inset .b3b {background:#ccc; border-left:1px solid #ddd; border-right:1px solid #fff;}
.inset .b2b {background:#ccc; border-left:1px solid #eee; border-right:1px solid #fff;}


.inset .b1 {margin:0 1px; background:#999;}
.inset .b2, .inset .b2b {margin:0 3px; border-width:0 2px;}
.inset .b3, .inset .b3b {margin:0 2px;}
.inset .b4, .inset .b4b {height:2px; margin:0 1px;}
.inset .b1b {margin:0 5px; background:#fff;}

.inset .boxcontent {display:block; background:#ccc; border-left:1px solid #999; border-right:1px solid #fff;}


.Estilo1 {color: #0000CC}
body {
	margin-left: 2px;
	margin-top: 2px;
	margin-right: 2px;
	margin-bottom: 5px;
}
</style>



<script language="JavaScript1.2">
<!--

window.moveTo(0,0);
if (document.all) {
	top.window.resizeTo(screen.availWidth,screen.availHeight);
}
else if (document.layers||document.getElementById) {
if (top.window.outerHeight<screen.availHeight||top.window.outerWidth<screen.availWidth){
	top.window.outerHeight = screen.availHeight;
	top.window.outerWidth = screen.availWidth;
}
}
//-->
</script>
<script language="javascript">
function cerrar() {
window.close();

}
</script>
</head>
<body  bgcolor="#FAFAFA" <?php echo $sis?> onLoad="window.focus();" >
<div class="inset">
<b class="top"><b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b></b>
<div class="boxcontent" align="center">
<table width="99%" height="99%" align="center" border="0" bgcolor="#FFFFFF">
        <tr> 
          <td height="22" align="right" valign="middle" bgcolor="#1F6FC6" class="nombreusuario" style="height:19px">
            <span class="nombreusuario" style="height:19px"><span class="titulosup">USUARIO: </span>
              <?php echo $_SESSION['global_3']?>
              <span class="titulosup">FECHA: </span>
              <?php echo date("d/m/y")?>
              </span>	</td>
          </tr>
  <tr>
    <td valign="top">
      <table width="100%" height="100%" border="0">
        <tr>
          <td valign="top">
            <?php include("menu.php");?>         
            <iframe  frameborder="0" scrolling="auto"   src="interna.php" name="interna" width="99%" height="95%" bgcolor="#FAFAFA"> </iframe>    
          </td>
          </tr>
        </table>
      </td>
  </tr>
 <tr>
        <td width="100%" height="26" bgcolor="#1F6FC6">&nbsp;</td>
        </tr>
            </td>
  </tr>
</table>
</div>
<b class="bottom"><b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b></b>
</div>
</body>
</html>