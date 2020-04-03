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
        case "cadastraPerfil":
            echo $adminObj->inserePerfil($_POST);
            break;
        case "editaPerfil":
            echo $adminObj->editaPerfil($_POST);
            break;
        case "apagaPerfil":
            echo $adminObj->apagaPerfil($_POST);
            break;
    }
} else {
    include_once "../config/destroySession.php";
}