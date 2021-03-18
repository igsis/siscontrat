<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    require_once "../controllers/GestaoPrazoController.php";
    require_once "../controllers/EventoController.php";
    $gestaoObj = new GestaoPrazoController();
    $eventoObj = new EventoController();

    if ($_POST['_method'] == "aprovar") {
        echo $eventoObj->enviaEvento("gestaoPrazo/inicio", $_POST['id']);
    } elseif ($_POST['_method'] == "desaprovar") {
        echo $gestaoObj->desaprovar($_POST);
    }
} else {
    include_once "../config/destroySession.php";
}