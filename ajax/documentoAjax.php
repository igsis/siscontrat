<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {

    require_once "../controllers/DocumentoController.php";
    $insDocumento = new DocumentoController();

    if ($_POST['_method'] == "cadastrar") {
        echo $insDocumento->insereDocumento($_POST);
    } elseif ($_POST['_method'] == "editar") {
        echo $insDocumento->editaDocumento($_POST, $_POST['id']);
    }
} else {
    include_once "../config/destroySession.php";
}