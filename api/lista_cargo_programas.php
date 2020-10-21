<?php
$pedidoAjax = true;
require_once "../controllers/FormacaoController.php";
$formObj = new FormacaoController();

if (isset($_GET['id'])) {
    $programa_id = $_GET['id'];
    $cargos = $formObj->listaCargo_Programas($programa_id);
    $i = 0;
    foreach ($cargos as $cargo) {
        echo $cargo->cargo . "<br>";
    }
}
