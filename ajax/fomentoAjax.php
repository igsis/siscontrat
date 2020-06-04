<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {

    require_once "../controllers/FomentoController.php";
    $fomentoObj = new FomentoController();

    switch ($_POST['_method']) {
        case "cadastrar":
            echo $fomentoObj->insereEdital($_POST);
            break;
        case "editar":
            echo $fomentoObj->editaEdital($_POST);
            break;
        case "arquivaEdital":
            echo $fomentoObj->arquivaEdital($_POST);
            break;
        case "aprovar":
            echo $fomentoObj->aprovarProjeto($_POST['id'],$_POST['valor_projeto'],$_POST['edital_id']);
            break;
        case "reprovar":
            echo $fomentoObj->reprovarProjeto($_POST['id']);
            break;
        case "adicionar_tipo":
            echo $fomentoObj->insereTipoContratacao($_POST);
            break;
        case "cadastrarAnexo":
            echo $fomentoObj->insereAnexoEdital($_POST);
            break;
        case "editarAnexo":
            echo $fomentoObj->editaAnexoEdital($_POST);
            break;
        case "apagarAnexo":
            echo $fomentoObj->apagaAnexoEdital($_POST);
            break;
    }
    if ($_POST['_method'] == 'pesquisa' && $_POST['search'] != ''){
        echo $fomentoObj->pesquisaEdital($_POST['search']);
    }
} else {
    include_once "../config/destroySession.php";
}