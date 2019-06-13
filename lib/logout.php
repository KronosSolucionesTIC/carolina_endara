<?
error_reporting("E_ERROR");
require("sesion.php");
session_start();
session_unregister("usid");
session_unregister("usnom");
session_unregister("ussex");
session_unregister("usidi");
session_unregister("usest");
session_unregister("usper");
session_unregister("pagina_inicio");
session_destroy();
print "<script>window.location='../index.php';</script>";
exit;
?>
