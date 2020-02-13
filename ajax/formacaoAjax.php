<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    session_start(['name' => 'cpc']);
    $idPf = $_SESSION['origem_id_c'];
    require_once "../controllers/FormacaoController.php";
    $insForm = new FormacaoController();

    switch ($_POST['_method']) {
        case "cadastrar":
            echo $insForm->insereFormacao();
            break;
        case "editar":
            echo $insForm->editaFormacao($_POST['id']);
            break;
//        case "enviar":
//            echo $insForm->envioEvento($_POST['id'], $_POST['modulo']);
//            break;
    }
} else {
    include_once "../config/destroySession.php";
}