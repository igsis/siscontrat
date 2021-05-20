<?php
$pedidoAjax = true;

require_once "../config/configGeral.php";
require_once "../controllers/PedidoController.php";
require_once "../controllers/EventoController.php";

$idEvento = $_GET['id'];

$eventoObj = new EventoController();
$pedidoObj = new PedidoController();

$pedido = $pedidoObj->recuperaPedido(1,$idEvento);
$objeto = $eventoObj->recuperaObjetoEvento($pedido->origem_id);

if ($pedido->pessoa_tipo_id == 1){
    $proponente = $pedido->nome;
} else{
    $proponente = $pedido->razao_social;
}
?>

<html lang="pt-br">
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
    <link rel="stylesheet" href="<?= SERVERURL ?>views/dist/css/custom.min.css">
    <title>Parecer da Comissão</title>
</head>

<body>
<br>
<div align="center">
    <div id="texto" class="texto">
        <p align='right'>Folha de Informação nº ___________</p>
        <p><strong>Do processo nº:</strong> <?= $pedido->numero_processo ?></p>
        <p align='right' class='style_01'>Data: _______ / _______ / <?= date('Y')?>.</p>
        <p>&nbsp;</p>
        <p><strong>INTERESSADO:</strong> <?= $proponente ?></p>
        <p><strong>ASSUNTO:</strong> <?= $objeto ?></p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p align='center'><strong>PARECER DA COMISSÃO TÉCNICA DE ATIVIDADES ARTÍSTICAS E CULTURAIS<br/>
                (Instituído pela Portaria nº 168/2019-SMC-G e nº 050/2019-SMC.G)</strong></p>
        <p>&nbsp;</p>
        <p align='justify'><?= $pedido->topico1 ?? null ?></p>
        <p align='justify'><?= $pedido->topico2 ?? null ?></p>
        <p align='justify'><?= $pedido->topico3 ?? null ?></p>
        <p align='justify'><?= $pedido->topico4 ?? null ?></p>
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

