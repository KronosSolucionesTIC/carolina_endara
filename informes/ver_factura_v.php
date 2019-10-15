<?
include "../lib/sesion.php";
include "../lib/database.php";
include "../conf/clave.php";
$db     = new Database();
$db_ver = new Database();
$sql    = "select *, DATE_ADD(fecha ,interval 30 day) as fac_fecha_vence   from m_factura where cod_fac=$codigo";
$db_ver->query($sql);
if ($db_ver->next_row()) {
    $rem_fac         = $db_ver->rem_fac;
    $cod_razon       = $db_ver->cod_razon_fac;
    $fac_numero      = $db_ver->num_fac;
    $fac_fecha       = $db_ver->fecha;
    $tipo_fac        = $db_ver->tipo_fac;
    $codigo_bod      = $db_ver->bod_cli_fac;
    $codigo_cli      = $db_ver->cod_cli;
    $codigo_razon    = $db_ver->cod_razon_fac;
    $tipo_pago       = $db_ver->tipo_pago;
    $fac_fecha_vence = $db_ver->fac_fecha_vence;
    $estado_factura  = $db_ver->estado;
    $cod_usuario     = $db_ver->cod_usu;
    $obs_fac         = $db_ver->obs;
    $tot_fac         = $db_ver->tot_fac;
    $vendedor        = $db_ver->cod_ven;
}

$codigo_salida = $codigo_cli;
$db_fac        = new Database();
$sql           = 'select * from rsocial where cod_rso=' . $codigo_razon;
$db_fac->query($sql);
if ($db_fac->next_row()) {
    $razon     = $db_fac->nom_rso;
    $nit       = $db_fac->nit_rso;
    $telefono  = $db_fac->tel_rso;
    $direccion = $db_fac->dir_rso;
    $leyenda   = $db_fac->desc1_rso;
    $leyenda2  = $db_fac->desc2_rso;
    $logo      = $db_fac->logo_rso;
    $regimen   = $db_fac->reg_rso;
    $obs_fac   = $db_ver->obs;
}

?>
<script language="javascript">
function imprimir(){
    window.print();
}
</script>
<title>FACTURA DE VENTA</title>
<style type="text/css">
.fuente {
    font-size: 10px;
    font-family: "Verdana";
    font-weight: bold;
    margin: 1px;
    padding: 1px;
}
</style>
<?
if ($estado_factura == "anulado") {
    $anulacion = "background='../imagenes/anulacion.gif'";
}
?>
<body>
    <table class="table fuente">
        <?php //include "factura_prueba.php";?>
        <?php include "factura_encabezado.php";?>
        <?php include "factura_cliente.php";?>
        <?php include "factura_cuerpo.php";?>
        <?php include "factura_footer.php";?>
    </table>
</body>