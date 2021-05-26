<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$pedidoAjax = true;
// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../config/configGeral.php";
require_once "../controllers/EventoController.php";
require_once "../controllers/AtracaoController.php";
require_once "../controllers/PedidoController.php";

$pedidoObj = new PedidoController();
$eventoObj = new EventoController();

$tipo = $_GET['tipo'];

if ($tipo == 1){//atração
    $idAtracao = $_GET['id'];
    $atracao = (new AtracaoController)->recuperaAtracao($idAtracao);
    $idEvento = $atracao->evento_id;
} elseif ($tipo == 2) {//filme
    $idEvento = $_GET['id'];
}

$pedido = $pedidoObj->recuperaPedido(1,$idEvento);
$evento = $eventoObj->recuperaEvento($idEvento);
$objeto = $eventoObj->recuperaObjetoEvento($pedido->origem_id);
$periodo = $eventoObj->retornaPeriodo($idEvento);
$local = $eventoObj->retornaLocais($idEvento);
$totalApresentacao = $eventoObj->retornaTotalApresentacao($idEvento);

if ($pedido->pessoa_tipo_id == 1){
    $nomeTipo = "FÍSICA";
    $proponente = $pedido->nome;
    $documento = $pedido->cpf ?? $pedido->passaporte;
}
else{
    $nomeTipo = "JURÍDICA";
    $proponente = $pedido->razao_social;
    $documento = $pedido->cnpj;
}
?>

<html lang="PT">
<head>
    <meta http-equiv="Content-Type" content="text/html. charset=Windows-1252">
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
    <link rel="stylesheet" href="<?= SERVERURL ?>views/dist/css/custom.min.css">
    <title>Pedido de Contratação</title>
</head>

<body>
<br>
<div align="center">
    <div id="texto" class="texto">
        <h4 align="center"><strong>PEDIDO DE  CONTRATAÇÃO DE PESSOA <?= $nomeTipo ?></strong></h4>
        <p>&nbsp;</p>
        <p><strong>Sr(a).</strong></p>
        <p>Solicitamos a contratação a seguir:</p>
        <p>&nbsp;</p>
        <p align="left"><strong>Protocolo:</strong> <?= $evento->protocolo ?><br>
            <strong>Processo SEI nº:</strong> <?= $pedido->numero_processo ?><br>
            <strong>Processo SEI de reserva global:</strong> <?= $pedido->numero_processo_mae ?><br>
            <strong>Setor  solicitante:</strong> <?= $eventoObj->instituicaoSolicitante($evento->id) ?> </p>
        <p align="left"><strong>Proponente:</strong> <?= $proponente ?> <br>
            <strong>Documento:</strong> <?= $documento ?><br>
            <strong>Telefone(s):</strong> <?= $pedido->telefones['tel_0'] ?? null . " " .$pedido->telefones['tel_1'] ?? null. " ".$pedido->telefones['tel_2'] ?? null ?> <br>
            <strong>E-mail:</strong> <?= $pedido->email ?> </p>
        <?php
        if ($tipo == 1){
            ?>
            <p align="left">
                <b>Produtor:</b><br>
                <b>Nome:</b> <?= $atracao->nome ?> <br>
                <b>Telefone:</b> <?= $atracao->telefone1 ?> <?= $atracao->telefone2 ? " / ".$atracao->telefone2 : null ?> <br>
                <b>E-mail:</b> <?= $atracao->email ?><br>
                <b>Atração: <?= $atracao->nome_atracao ?></b>
            </p>
        <?php
        }
        ?>
        <p><strong>Objeto:</strong> <?= $objeto ?>.</p>
        <p><strong>Data / Período:</strong> <?= $periodo ?>, totalizando <?= $totalApresentacao ?> <?php if ($totalApresentacao >1) echo "apresentações"; else echo "apresentacao"; ?> conforme proposta/cronograma.</p>
        <p class="text-justify"><strong>Local(ais):</strong> <?= $local ?>.</p>
        <p><strong>Valor: </strong> R$ <?= $eventoObj->dinheiroParaBr($pedido->valor_total) . " ( " .$eventoObj->valorPorExtenso($pedido->valor_total) . ")" ?>.</p>
        <p class="text-justify"><strong>Forma de pagamento:</strong> <?=  $pedido->forma_pagamento ?></p>
        <p class="text-justify"><strong>Justificativa:</strong> <?= $pedido->justificativa ?></p>
        <p class="text-justify">Nos termos do art. 6º do decreto 54.873/2014, fica designado como fiscal desta contratação artística o(a) servidor(a) <?= $evento->fiscal_nome . ", RF " . $evento->fiscal_rf . " e, como substituto, " . $evento->suplente_nome . ", RF " . $evento->suplente_rf  ?>. Diante do exposto, solicitamos autorização para prosseguimento do presente.</p>
    </div>
</div>

<p>&nbsp;</p>

<div align="center">
    <button id="botao-copiar" class="btn btn-primary" onclick="copyText(getElementById('texto'))">
        COPIAR TODO O TEXTO
        <i class="fa fa-copy"></i>
    </button>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="https://sei.prefeitura.sp.gov.br" target="_blank">
        <button class="btn btn-primary">CLIQUE AQUI PARA ACESSAR O <img src="../views/dist/img/logo_sei.jpg" alt="logo_sei"></button>
    </a>
</div>
<p>&nbsp;</p>
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