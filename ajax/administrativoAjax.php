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
        case "cadastraPerfil":
            echo $adminObj->inserePerfil($_POST);
            break;
        case "editaPerfil":
            echo $adminObj->editaPerfil($_POST);
            break;
        case "apagaPerfil":
            echo $adminObj->apagaPerfil($_POST);
            break;
        case "cadastrarRelacoes":
            echo $adminObj->insereRelacoesJuridicas($_POST);
            break;
        case "editarRelacoes":
            echo $adminObj->editaRelacoesJuridicas($_POST);
            break;
        case "apagarRelacoes":
            echo $adminObj->apagaRelacoesJuridicas($_POST);
            break;
    }

    if ($_POST['_method'] == "cadastrar") {
        echo $adminObj->cadastrarCategoria($_POST);
    } elseif ($_POST['_method'] == "editar") {
        echo $adminObj->editarCategoria($_POST);
    }elseif ($_POST['_method'] == "deletar"){
        echo $adminObj->deletaCategoria($_POST);
    }elseif ($_POST['_method'] == "cadastrarModulo") {
        echo $adminObj->insereModulo($_POST);
    } elseif ($_POST['_method'] == "editarModulo") {
        echo $adminObj->editaModulo($_POST);
    }

} else {
    include_once "../config/destroySession.php";
}