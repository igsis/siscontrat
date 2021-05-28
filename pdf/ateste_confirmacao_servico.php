<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$pedidoAjax = true;

// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../config/configGeral.php";
require_once "../views/plugins/fpdf/fpdf.php";
require_once "../controllers/PedidoController.php";
require_once "../controllers/EventoController.php";

$idEvento = $_GET['id'];
$ano = date('Y');

$eventoObj = new EventoController();
$pedidoObj = new PedidoController();

$pedido = $pedidoObj->recuperaPedido(1,$idEvento);
$evento = $eventoObj->recuperaEvento($idEvento);
$objeto = $eventoObj->recuperaObjetoEvento($idEvento);
$periodo = $eventoObj->retornaPeriodo($idEvento);

if ($pedido->pessoa_tipo_id == 1){
    $proponente = $pedido->nome;
}
else{
    $proponente = $pedido->razao_social;
}
?>

<html lang="pt-br">
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
    <title>Confirmação de Serviço</title>
</head>
<body>
<div align="center">
    <div id="texto" class="texto">
        <p style="text-align: center"><strong><u>ATESTADO DE CONFIRMAÇÃO DE SERVIÇOS</u></strong></p>
        <p>&nbsp;</p>
        <p>Informamos que os serviços prestados por: <?= $proponente ?></p>
        <p>&nbsp;</p>
        <p>
            <strong>Processo:</strong> <?= $pedido->numero_processo ?><br>
            <strong>Evento:</strong> <?= $objeto ?><br>
            <strong>Período:</strong> <?= $periodo ?>
        </p>
        <p>&nbsp;</p>
        <p>
            ( X ) FORAM REALIZADOS A CONTENTO<br>
            (&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;) NÃO FORAM REALIZADOS<br>
            (&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;) NÃO FORAM REALIZADOS A CONTENTO, PELO SEGUINTE MOTIVO:
        </p>
        <p>&nbsp;</p>
        <p><strong>DADOS DO SERVIDOR (A) QUE ESTÁ CONFIRMANDO OU NÃO A REALIZAÇÃO DOS SERVIÇOS:</strong></p>
        <p>
            <strong>FISCAL:</strong> <?=$evento->fiscal_nome ?><br>
            <strong>RF:</strong> <?= $evento->fiscal_rf ?><br>
            <strong>SUPLENTE:</strong> <?=$evento->suplente_nome ?><br>
            <strong>RF:</strong> <?= $evento->suplente_rf ?><br>
        </p>
        <p>&nbsp;</p>
        <p>Atesto que os serviços prestados discriminados no documento:<strong> LINK NOTA FISCAL OU RECIBO DE PAGAMENTO</strong>, foram executados a contento nos termos previstos no instrumento contracontratual (ou documento equivalente) nos dias:</p>
        <p>&nbsp;</p>
        <p>Dentro do prazo previsto.</p>
        <p>O prazo contratual é <?= $periodo ?></p>
        <p>À área gestora de liquidação e pagamento encaminho para prosseguimento.</p>
    </div>
</div>

<p>&nbsp;</p>

<div align="center">
    <button id="botao-copiar" class="btn btn-primary" onclick="copyText(getElementById('texto'))">
        COPIAR TODO O TEXTO
        <i class="fa fa-copy"></i>
    </button>
    <a href="https://sei.prefeitura.sp.gov.br" target="_blank">
        <button class="btn btn-primary">CLIQUE AQUI PARA ACESSAR O <img src="../views/dist/img/logo_sei.jpg" alt="logo_sei"></button>
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