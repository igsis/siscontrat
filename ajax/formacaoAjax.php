<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    session_start(['name' => 'sis']);
    // $idPf = $_SESSION['origem_id_s'];
    require_once "../controllers/FormacaoController.php";
    $insForm = new FormacaoController();
    require_once "../controllers/PessoaFisicaController.php";
    $insPessoaFisica = new PessoaFisicaController();

    switch ($_POST['_method']) {
        case "cadastrarPf":
            // echo $insForm->insereFormacao();
            break;
        case "editarPf":
            // echo $insForm->editaFormacao($_POST['id']);
            break;
        case "cadastrarCargo":
            echo $insForm->insereCargo($_POST);
            break;
        case "editarCargo":
            echo $insForm->editaCargo($_POST);
            break;
        case "apagarCargo":
            echo $insForm->apagaCargo($_POST);
            break;
        case "cadastrarCoordenadoria":
            echo $insForm->insereCoordenadoria($_POST);
            break;
        case "editarCoordenadoria":
            echo $insForm->editaCoordenadoria($_POST);
            break;
        case "apagarCoordenadoria":
            echo $insForm->apagaCoordenadoria($_POST);
            break;
        case "cadastrarPrograma":
            echo $insForm->inserePrograma($_POST);
            break;
        case "editarPrograma":
            echo $insForm->editaPrograma($_POST);
            break;
        case "apagarPrograma":
            echo $insForm->apagaPrograma($_POST);
            break;
        case "cadastrarLinguagem":
            echo $insForm->insereLinguagem($_POST);
            break;
        case "editarLinguagem":
            echo $insForm->editaLinguagem($_POST);
            break;
        case "apagarLinguagem":
            echo $insForm->apagaLinguagem($_POST);
            break;
        case "cadastrarProjeto":
            echo $insForm->insereProjeto($_POST);
            break;
        case "editarProjeto":
            echo $insForm->editaProjeto($_POST);
            break;
        case "apagarProjeto":
            echo $insForm->apagaProjeto($_POST);
            break;
        case "cadastrarSubprefeitura":
            echo $insForm->insereSubprefeitura($_POST);
            break;
        case "editarSubprefeitura":
            echo $insForm->editaSubprefeitura($_POST);
            break;
        case "apagarSubprefeitura":
            echo $insForm->apagaSubprefeitura($_POST);
            break;
        case "cadastrarTerritorio":
            echo $insForm->insereTerritorio($_POST);
            break;
        case "editarTerritorio":
            echo $insForm->editaTerritorio($_POST);
            break;
        case "apagarTerritorio":
            echo $insForm->apagaTerritorio($_POST);
            break;
        case "cadastrarVigencia":
            echo $insForm->insereVigencia($_POST);
            break;
        case "editarVigencia":
            echo $insForm->editaVigencia($_POST);
            break;
        case "apagarVigencia":
            echo $insForm->apagaVigencia($_POST);
            break;
        case "cadastrarParcelaVigencia":
            echo $insForm->insereParcelaVigencia($_POST);
            break;
        case "editarParcelaVigencia":
            echo $insForm->editaParcelaVigencia($_POST);
            break;
        case "cadastrarPedido":
            echo $insForm->cadastrarPedido($_POST);
            break;
        case "editarPedido":
            echo $insForm->editarPedido($_POST);
            break;
        case "deletarPedido":
            echo $insForm->deletarPedido($_POST);
            break;
        case "editarParcela":
            echo $insForm->editarParcela($_POST);
            break;
        case "cadastrarNotaEmpenho":
            echo $insForm->cadastrarNotaEmpenho($_POST);
            break;
        case "editarNotaEmpenho":
            echo $insForm->editarNotaEmpenho($_POST);
            break;
        case "cadastrarPF":
            echo $insPessoaFisica->inserePessoaFisica($_POST['pagina']);
            break;
        case "editarPF":
            echo $insPessoaFisica->editaPessoaFisica($_POST['id'], $_POST['pagina']);
            break;
        case "cadastrarDadosContratacao":
            echo $insForm->insereDadosContratacao($_POST);
            break;
        case "editarDadosContratacao":
            echo $insForm->editaDadosContratacao($_POST);
            break;
        case "apagarDadosContratacao":
            echo $insForm->apagaDadosContratacao($_POST);
            break;
        case "pesquisa":
            echo $insForm->pesquisas($_POST['search'], $_POST['where']);
            break;
        case "concluirPedido":
            echo $insForm->concluirPedido($_POST);
            break;
        case "removerArquivo":
            echo $insForm->excluirArquivo($_POST);
            break;
        case "cadastrarDocumento":
            echo $insForm->insereDocumento($_POST);
            break;
        case "editarDocumento":
            echo $insForm->editaDocumento($_POST);
            break;
        case "apagarDocumento":
            echo $insForm->apagaDocumento($_POST);
            break;
        case "cadastrarAbertura":
            echo $insForm->insereAbertura($_POST);
            break;
        case "editarAbertura":
            echo $insForm->editaAbertura($_POST);
            break;
        case "apagarAbertura":
            echo $insForm->apagaAbertura($_POST);
            break;

    }
    if ($_POST['_method'] == "pesquisaPf" && $_POST['search'] != "") {
        echo $insForm->listaDocumento($_POST['search'], $_POST['where']);
    }
} else {
    include_once "../config/destroySession.php";
}


