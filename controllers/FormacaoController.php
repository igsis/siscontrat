<?php
if ($pedidoAjax) {
    require_once "../models/ValidacaoModel.php";
    require_once "../controllers/PessoaFisicaController.php";
} else {
    require_once "./models/ValidacaoModel.php";
    require_once "./controllers/PessoaFisicaController.php";
}

class FormacaoController extends ValidacaoModel
{
    //
}