<?php

require_once "./controllers/ArquivoController.php";
$arqObj = new ArquivoController();

$id = $_GET['id'];

$arqObj->downloadArquivos($id);