<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    require_once "../controllers/GestaoPrazoController.php";
    $gestaoObj = new GestaoPrazoController();

    if ($_POST['_method'] == "aprovar") {
        echo $gestaoObj->aprovar($_POST['evento_id']);
    } elseif ($_POST['_method'] == "desaprovar") {
        echo $gestaoObj->desaprovar($_POST);
    }
} else {
    include_once "../config/destroySession.php";
}