<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {

    require_once "../controllers/ModuloController.php";
    $moduloObj = new ModuloController();

    if ($_POST['_method'] == "cadastra") {
        echo $moduloObj->insereModulo($_POST);
    } elseif ($_POST['_method'] == "editar") {
        echo $moduloObj->editaModulo($_POST);
    }

    
} else {
    include_once "../config/destroySession.php";
}