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
    if ($_POST['_method'] == 'aprovar'){
        echo $fomentoObj->aprovarProjeto($_POST['id'],$_POST['valor_projeto'],$_POST['edital_id']);
    }
    if ($_POST['_method'] == 'reprovar'){
        echo $fomentoObj->reprovarProjeto($_POST['id']);
    }
    if ($_POST['_method'] == 'adicionar_tipo'){
        echo $fomentoObj->insereTipoContratacao($_POST);
    }
} else {
    include_once "../config/destroySession.php";
}