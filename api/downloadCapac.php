<?php
$pedidoAjax = true;
require_once "../controllers/ArquivoController.php";
$arqObj = new ArquivoController();

$id = $_GET['id'];
$formacao = isset($_GET['formacao']) ? $_GET['formacao'] : "";

if ($formacao != ""):
    $arqObj->downloadArquivos( '', $formacao, $id);
else:
    $arqObj->downloadArquivos($id);
endif;