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
    $nomeTipo = "Física";
    $proponente = $pedido->nome;
    $documento = $pedido->cpf ?? $pedido->passaporte;
}
else{
    $nomeTipo = "Jurídica";
    $proponente = $pedido->razao_social;
    $documento = $pedido->cnpj;
}

$pedidoObj->inserePedidoEtapa(intval($pedido->id),"reserva");
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
    <title>Reserva Global</title>
</head>
<body>
<div align="center">
    <div id="texto" class="texto">
        <p>
            <b>INTERESSADO:</b> <?= $proponente ?><br>
            <b>ASSUNTO:</b> <?= $objeto ?>
        </p>
        <p>&nbsp;</p>
        <p>
            <b>SMC/CAF/SCO</b><br>
            <b>Senhor Supervisor</b>
        </p>
        <p>&nbsp;</p>
        <p><b>Objeto:</b> <?= $objeto ?></p>
        <p><b>Data/período:</b> <?= $periodo ?></p>
        <p><b>Local(is):</b> <?= $local ?></p>
        <p><b>Valor:</b> <?= "R$ " . (new MainModel)->dinheiroParaBr(($pedido->valor_total)) . " ( " .  (new MainModel)->valorPorExtenso($pedido->valor_total) . " )."?></p>
        <p>&nbsp;</p>
        <p align="justify">Diante do exposto, autorizo a reserva de recursos proveniente da nota de reserva inclusa no processo <?= $pedido->numero_processo_mae ?> - (Pessoa <?=$nomeTipo?>) para a presente contratação.</p>
        <p>&nbsp;</p>
        <p>Após, enviar para SMC/AJ para prosseguimento.</p>
        <p>&nbsp;</p>
        <p>Chefe de Gabinete</p>
    </div>
</div>

<p>&nbsp;</p>

<div align="center">
    <button id="botao-copiar" class="btn btn-primary" onclick="copyText(getElementById('texto'))">
        COPIAR TODO O TEXTO
        <i class="fa fa-copy"></i>
    </button>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="http://sei.prefeitura.sp.gov.br" target="_blank">
        <button class="btn btn-primary">CLIQUE AQUI PARA ACESSAR O <img src="../siscontrat2/visual/images/logo_sei.jpg"></button>
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

