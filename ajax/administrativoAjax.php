<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {

    require_once "../controllers/AdministrativoController.php";
    $adminObj = new AdministrativoController();

    switch ($_POST['_method']) {
        case "cadastraAviso":
            echo $adminObj->insereAviso($_POST);
            break;
        case "editaAviso":
            echo $adminObj->editaAviso($_POST);
            break;
    }

    if ($_POST['_method'] == "cadastrarModulo") {
        echo $adminObj->insereModulo($_POST);
    } elseif ($_POST['_method'] == "editarModulo") {
        echo $adminObj->editaModulo($_POST);
    }

} else {
    include_once "../config/destroySession.php";
}