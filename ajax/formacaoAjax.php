<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    session_start(['name' => 'sis']);
    $idPf = $_SESSION['origem_id_s'];
    require_once "../controllers/FormacaoController.php";
    $insForm = new FormacaoController();

    switch ($_POST['_method']) {
        case "cadastrarPf":
            // echo $insForm->insereFormacao();
            break;
        case "editarPf":
            // echo $insForm->editaFormacao($_POST['id']);
            break;
    }
} else {
    include_once "../config/destroySession.php";
}