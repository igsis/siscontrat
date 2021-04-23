<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    session_start(['name' => 'sis']);
    // $idPf = $_SESSION['origem_id_s'];
    require_once "../controllers/FormacaoController.php";
    require_once "../controllers/FormacaoCargoController.php";
    require_once "../controllers/FormacaoCoordenadoriaController.php";
    require_once "../controllers/FormacaoProgramaController.php";
    require_once "../controllers/FormacaoParcelaVigenciaController.php";
    require_once "../controllers/FormacaoVigenciaController.php";
    require_once "../controllers/FormacaoContratacaoController.php";
    require_once "../controllers/FormacaoSubprefeituraController.php";
    require_once "../controllers/FormacaoTerritorioController.php";
    require_once "../controllers/FormacaoPedidoController.php";

    require_once "../controllers/PessoaFisicaController.php";
    $insPessoaFisica = new PessoaFisicaController();

    switch ($_POST['_method']) {

//      Cargo
        case "cadastrarCargo":
            echo (new FormacaoCargoController)->inserir($_POST);
            break;
        case "editarCargo":
            echo (new FormacaoCargoController)->editar($_POST);
            break;
        case "apagarCargo":
            echo (new FormacaoCargoController)->apagar($_POST);
            break;
        case "vincularCargo":
            echo (new FormacaoCargoController)->vincular($_POST);
            break;
        case "desvincularCargo":
            echo (new FormacaoCargoController)->desvincular($_POST);
            break;

//      Coordenadoria
        case "cadastrarCoordenadoria":
            echo (new FormacaoCoordenadoriaController)->inserir($_POST);
            break;
        case "editarCoordenadoria":
            echo (new FormacaoCoordenadoriaController)->editar($_POST);
            break;
        case "apagarCoordenadoria":
            echo (new FormacaoCoordenadoriaController)->apagar($_POST);
            break;

//      Programa
        case "cadastrarPrograma":
            echo (new FormacaoProgramaController)->inserir($_POST);
            break;
        case "editarPrograma":
            echo (new FormacaoProgramaController)->editar($_POST);
            break;
        case "apagarPrograma":
            echo (new FormacaoProgramaController)->apagar($_POST);
            break;

//      Linguagem
        case "cadastrarLinguagem":
            echo (new FormacaoLinguagemController)->inserir($_POST);
            break;
        case "editarLinguagem":
            echo (new FormacaoLinguagemController)->editar($_POST);
            break;
        case "apagarLinguagem":
            echo (new FormacaoLinguagemController)->apagar($_POST);
            break;

//      Projeto
        case "cadastrarProjeto":
            echo (new FormacaoProjetoController)->inserir($_POST);
            break;
        case "editarProjeto":
            echo (new FormacaoProjetoController)->editar($_POST);
            break;
        case "apagarProjeto":
            echo (new FormacaoProjetoController)->apagar($_POST);
            break;

//      Subprefeitura
        case "cadastrarSubprefeitura":
            echo (new FormacaoSubprefeituraController)->inserir($_POST);
            break;
        case "editarSubprefeitura":
            echo (new FormacaoSubprefeituraController)->editar($_POST);
            break;
        case "apagarSubprefeitura":
            echo (new FormacaoSubprefeituraController)->apagar($_POST);
            break;

//      Territorio
        case "cadastrarTerritorio":
            echo (new FormacaoTerritorioController)->inserir($_POST);
            break;
        case "editarTerritorio":
            echo (new FormacaoTerritorioController)->editar($_POST);
            break;
        case "apagarTerritorio":
            echo (new FormacaoTerritorioController)->apagar($_POST);
            break;

//      Vigencia
        case "cadastrarVigencia":
            echo (new FormacaoVigenciaController)->inserir($_POST);
            break;
        case "editarVigencia":
            echo (new FormacaoVigenciaController)->editar($_POST);
            break;
        case "apagarVigencia":
            echo (new FormacaoVigenciaController)->apagar($_POST);
            break;

//      Parcela vigencia
        case "cadastrarParcelaVigencia":
            echo (new FormacaoParcelaVigenciaController())->inserir($_POST);
            break;
        case "editarParcelaVigencia":
            echo (new FormacaoParcelaVigenciaController)->editar($_POST);
            break;

//      Parcela
//        case "editarParcela":
//            echo (new FormacaoParcelaVigenciaController)->editar($_POST);
//            break;

//      Pedido
        case "cadastrarPedido":
            echo (new FormacaoPedidoController)->inserir($_POST);
            break;
        case "editarPedido":
            echo (new FormacaoPedidoController)->editar($_POST);
            break;
        case "deletarPedido":
            echo (new FormacaoPedidoController)->apagar($_POST);
            break;
        case "concluirPedido":
            echo (new FormacaoPedidoController)->concluir($_POST);
            break;

//      Nota Empenho
        case "cadastrarNotaEmpenho":
            echo (new FormacaoNotaEmpenhoController)->inserir($_POST);
            break;
        case "editarNotaEmpenho":
            echo (new FormacaoNotaEmpenhoController)->editar($_POST);
            break;

//      Pessoa Fisica
        case "cadastrarPF":
            echo $insPessoaFisica->inserePessoaFisica($_POST['pagina']);
            break;
        case "editarPF":
            echo $insPessoaFisica->editaPessoaFisica($_POST['id'], $_POST['pagina']);
            break;
        case "editarPFImportadoCapac":
            echo $insPessoaFisica->editaPessoaFisica($_POST['id'], $_POST['pagina'], false, true);
            break;
        case "editarPFImport":
            echo (new FormacaoInscritoController)->inserir($_POST['capac_id'], false, $_POST['id']);
            break;
        case "importarInscrito":
            echo (new FormacaoInscritoController)->inserir($_POST['id']);
            break;
        case "importarPf":
            echo $insPessoaFisica->importarPf($_POST['id']);
            break;

//      Perdido por ai
        case "pesquisa":
            echo (new FormacaoController)->pesquisar($_POST['search'], $_POST['where']);
            break;

//      Dados contratacao
        case "cadastrarDadosContratacao":
            echo (new FormacaoContratacaoController)->inserir($_POST);
            break;
        case "editarDadosContratacao":
            echo (new FormacaoContratacaoController)->editar($_POST);
            break;
        case "apagarDadosContratacao":
            echo (new FormacaoContratacaoController)->apagar($_POST);
            break;

//      Documentos
        case "cadastrarDocumento":
            echo (new FormacaoDocumentoController)->inserir($_POST);
            break;
        case "editarDocumento":
            echo (new FormacaoDocumentoController)->editar($_POST);
            break;
        case "apagarDocumento":
            echo (new FormacaoDocumentoController)->apagar($_POST);
            break;

//      Edital
        case "cadastrarAbertura":
            echo (new FormacaoEditalController)->inserir($_POST);
            break;
        case "editarAbertura":
            echo (new FormacaoEditalController)->editar($_POST);
            break;
        case "apagarAbertura":
            echo (new FormacaoEditalController)->apagar($_POST);
            break;
    }
    if (isset($_POST['_method'])) {
        if ($_POST['_method'] == "pesquisaPf" && $_POST['search'] != "") {
                echo (new FormacaoDocumentoController)->pesquisar($_POST['search'], $_POST['where']);
        }
    }
} else {
    include_once "../config/destroySession.php";
}


