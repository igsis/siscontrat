<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$pedidoAjax = true;
// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../config/configGeral.php";
require_once "../controllers/FormacaoController.php";

$formObj = new FormacaoController();

$pedido_id = $_GET['id'];

$pedido = $formObj->recuperaPedido($pedido_id);

$pf = $formObj->recuperaPf($pedido->pessoa_fisica_id);

if ($pf->passaporte != NULL) {
    $cpf_passaporte = "<strong>Passaporte: </strong> " . $pf->passaporte . "<br />";
} else {
    $cpf_passaporte = "<strong>CPF:</strong> " . $pf->cpf . "<br />";
}

$data = date('d/m/Y');
$dia = date('d');
$mes = MainModel::retornaMes(date('m'));
$ano = date('Y');

if ($pedido->programa_id == 1) {
    $objetivo = "CONTRATAÇÃO COMO {$pedido->cargo} de {$pedido->linguagem} DO PROGRAMA DE INICIAÇÃO ARTÍSTICA - {$ano}  NOS TERMOS DO EDITAL 026/2020 - SMC/CFOC/SFC - PROGRAMAS DA SUPERVISÃO DE FORMAÇÃO CULTURAL.";
}else {
    $objetivo = "CONTRATAÇÃO COMO {$pedido->cargo} de {$pedido->linguagem} DO PROGRAMA VOCACIONAL - {$ano} NOS TERMOS DO EDITAL 027/2020 - SMC/CFOC/SFC -  PROGRAMAS DA SUPERVISÃO DE FORMAÇÃO CULTURAL.";
}
?>

<html>
<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html. charset=Windows-1252\">

    <style>

        .texto {
            width: 900px;
            border: solid;
            padding: 20px;
            font-size: 12px;
            font-family: Arial, Helvetica, sans-serif;
            text-align: justify;
        }
    </style>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= SERVERURL ?>views/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= SERVERURL ?>views/dist/css/adminlte.min.css">
    <title>Pedido de Contratacao</title>
</head>

<body>
<br>
<div align="center">
    <?php
    $conteudo =
        "<p align='center'><strong>PEDIDO DE  CONTRATAÇÃO DE PESSOA FÍSICA </strong></p>" .
        "<p>&nbsp;</p>" .
        "<p><strong>Sr(a) </strong></p>" .
        "<p>Solicitamos a contratação a seguir:</p>" .
        "<p>&nbsp;</p>" .
        "<p><strong>Pedido de Contratação nº:</strong> " . $ano . '-' . $pedido->id . "</p>" .
        "<p><strong>Processo SEI nº:</strong> " . MainModel::checaCampo($pedido->numero_processo) . "</p>" .
        "<p><strong>Setor  solicitante:</strong> Supervisão de Formação Cultural</p>" .
        "<p>&nbsp;</p>" .
        "<p><strong>Nome:</strong> " . $pf->nome . " <br />" .
        $cpf_passaporte .
        "<strong>Telefone(s):</strong> " . $formObj->recuperaTelPf($pedido->pessoa_fisica_id) . "<br />" .
        "<strong>E-mail:</strong> " . $pf->email . "</p>" .
        "<p>&nbsp;</p>" .
        "<p><strong>Objeto:</strong> {$objetivo}</p>" .
        "<p><strong>Data / Período:</strong> " . $formObj->retornaPeriodoFormacao($pedido->origem_id) . " - conforme Proposta/Cronograma</p>" .
        "<p><strong>Carga Horária:</strong> " . $formObj->retornaCargaHoraria($pedido->origem_id) . " hora(s)" . "</p>" .
        "<p align='justify'><strong>Local(ais):</strong> " . $formObj->retornaLocaisFormacao($pedido->origem_id) . "</p>" .
        "<p><strong>Valor: </strong> R$ " . MainModel::dinheiroParaBr($pedido->valor_total) . "  (" . MainModel::valorPorExtenso($pedido->valor_total) . " )</p>" .
        "<p align='justify'><strong>Forma de Pagamento:</strong> " . $pedido->forma_pagamento . "</p>" .
        "<p align='justify'><strong>Justificativa: </strong> " . $pedido->cargo_justificativa . "</p>" .
        "<p align='justify'>Nos termos do art. 6º do decreto 54.873/2014, fica designado como fiscal desta contratação artística a servidora Natalia Silva Cunha, RF 842.773.9 e, como substituto, Ilton T. Hanashiro Yogi, RF 800.116.2. Diante do exposto, solicitamos autorização para prosseguimento do presente." . "</p>";
    ?>

    <div id="texto" class="texto"><?php echo $conteudo; ?></div>
</div>

<div align="center">
    <button id="botao-copiar" class="btn btn-primary" onclick="copyText(getElementById('texto'))">
        COPIAR TODO O TEXTO
        <i class="fa fa-copy"></i>
    </button>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="http://sei.prefeitura.sp.gov.br" target="_blank">
        <button class="btn btn-primary">CLIQUE AQUI PARA ACESSAR O <img src="../views/dist/img/logo_sei.jpg"></button>
    </a>
</div>

<script>
    function copyText(element) {
        var range, selection, worked;

        if (document.body.createTextRange) {
            range = document.body.createTextRange();
            range.moveToElementText(element);
            range.select();
        } else if (window.getSelection) {
            selection = window.getSelection();
            range = document.createRange();
            range.selectNodeContents(element);
            selection.removeAllRanges();
            selection.addRange(range);
        }

        try {
            document.execCommand('copy');
            alert('Copiado com sucesso!');
            selection.removeAllRanges();
        } catch (err) {
            alert('Texto não copiado, tente novamente.');
            selection.removeAllRanges();
        }
    }
</script>

</body>
</html>