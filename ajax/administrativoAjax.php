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
        case "cadastraInstituicao":
            echo $adminObj->insereInstituicao($_POST);
            break;
        case "editaInstituicao":
            echo $adminObj->editaInstituicao($_POST);
            break;
    }
} else {
    include_once "../config/destroySession.php";
}