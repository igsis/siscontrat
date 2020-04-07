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
        case "editarUsuarios":
            echo $adminObj->editaUsuarios($_POST);
            break;
        case "cadastrarUsuarios":
            echo $adminObj->insereUsuarios($_POST);
            break;
        case "apagarUsuarios":
            echo $adminObj->apagaUsuarios($_POST);
            break;
    }

    if ($_POST['_method'] == "cadastrarCategoria") {
        echo $adminObj->cadastrarCategoria($_POST);
    } elseif ($_POST['_method'] == "editarCategoria") {
        echo $adminObj->editarCategoria($_POST);
    }elseif ($_POST['_method'] == "deletarCategoria"){
        echo $adminObj->deletaCategoria($_POST);
    }elseif ($_POST['_method'] == "cadastrarModulo") {
        echo $adminObj->insereModulo($_POST);
    } elseif ($_POST['_method'] == "editarModulo") {
        echo $adminObj->editaModulo($_POST);
    }elseif($_POST['_method'] == "cadastrarVerba"){
        echo $adminObj->insereVerba($_POST);
    }elseif($_POST['_method'] == "editarVerba"){
        echo $adminObj->editarVerba($_POST);
    }elseif($_POST['_method'] == "deletarVerba"){
        echo $adminObj->deletarVerba($_POST);
    }

} else {
    include_once "../config/destroySession.php";
}