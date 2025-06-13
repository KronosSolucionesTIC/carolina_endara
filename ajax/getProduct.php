<?php
include("../lib/database.php");

if (isset($_POST['code'])) {
    $code = $_POST['code'];

    $db = new database();
	$sql = "SELECT cod_mar_pro, cod_tpro_pro, cod_pro FROM producto WHERE cod_fry_pro = '".$code."'";
	$db->query($sql);
	$db->next_row();

    $category = $db->cod_mar_pro;
    $productType = $db->cod_tpro_pro;
    $product = $db->cod_pro;

    echo json_encode(array(
        'category' => $category,
        'productType' => $productType,
        'product' => $product,
    ));

    $db->close();
}
?>
