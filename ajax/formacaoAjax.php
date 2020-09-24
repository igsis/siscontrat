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
        case "editaPrograma":
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
    }
} else {
    include_once "../config/destroySession.php";
}