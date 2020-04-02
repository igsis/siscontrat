<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {

    require_once "../controllers/ModuloController.php";
    $moduloObj = new ModuloController();

    if ($_POST['_method'] == "cadastra") {
        echo $fomentoObj->insereModulo($_POST);
    } elseif ($_POST['_method'] == "editar") {
        echo $fomentoObj->editaModulo($_POST);
    }

    if ($_POST['_method'] == 'pesquisa' && $_POST['search'] != ''){
        echo $fomentoObj->pesquisaEdital($_POST['search']);
    }
    
} else {
    include_once "../config/destroySession.php";
}