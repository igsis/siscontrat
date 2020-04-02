<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {

    require_once "../controllers/InstituicaoController.php";
    $insInstituicao = new InstituicaoController();

    if ($_POST['_method'] == "cadastrar") {
        echo $insInstituicao->insereInstituicao($_POST);
    } elseif ($_POST['_method'] == "editar") {
        echo $insInstituicao->editaInstituicao($_POST, $_POST['id']);
    }
} else {
    include_once "../config/destroySession.php";
}