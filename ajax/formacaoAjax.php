<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    session_start(['name' => 'sis']);
   // $idPf = $_SESSION['origem_id_s'];
    require_once "../controllers/FormacaoController.php";
    $insForm = new FormacaoController();

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
        case "cadastrarPedido":
            echo $insForm->cadastrarPedido($_POST);
            break;
        case "editarPedido":
            echo $insForm->editarPedido($_POST);
            break;
    }
} else {
    include_once "../config/destroySession.php";
}