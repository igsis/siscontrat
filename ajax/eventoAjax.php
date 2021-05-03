<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    session_start(['name' => 'sis']);
    require_once "../controllers/EventoController.php";
    $insEvento = new EventoController();

    switch ($_POST['_method']) {
        case "notificacao":
            echo $insEvento->notificacaoEventos($_POST['id']);
            break;
    }
} else {
    include_once "../config/destroySession.php";
}