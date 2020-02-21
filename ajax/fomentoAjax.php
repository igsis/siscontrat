<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {

    require_once "../controllers/FomentoController.php";
    $fomentoObj = new FomentoController();

    if ($_POST['_method'] == "cadastrar") {
        echo $fomentoObj->insereEdital($_POST);
    } elseif ($_POST['_method'] == "editar") {
        echo $fomentoObj->editaEdital($_POST);
    }

    if ($_POST['_method'] == 'pesquisa' && $_POST['search'] != ''){
        echo $fomentoObj->pesquisaEdital($_POST['search']);

    }
} else {
    include_once "../config/destroySession.php";
}