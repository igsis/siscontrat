<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$pedidoAjax = true;

// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../config/configGeral.php";
require_once "../views/plugins/fpdf/fpdf.php";
require_once "../controllers/PedidoController.php";
require_once "../controllers/EventoController.php";
require_once "../controllers/NotaEmpenhoController.php";

$idEvento = $_GET['id'];
$ano = date('Y');

$eventoObj = new EventoController();
$pedidoObj = new PedidoController();
$neObj = new NotaEmpenhoController();

$pedido = $pedidoObj->recuperaPedido(1,$idEvento);
$objeto = $eventoObj->recuperaObjetoEvento($idEvento);
$ne = $neObj->recuperaNotaEmpenho($pedido->id);

$norte = $pedidoObj->recuperaValorRegiao($idEvento,1);
$sul = $pedidoObj->recuperaValorRegiao($idEvento,2);
$leste = $pedidoObj->recuperaValorRegiao($idEvento,3);
$oeste = $pedidoObj->recuperaValorRegiao($idEvento,4);
$centro = $pedidoObj->recuperaValorRegiao($idEvento,5);

$valores = "";
$texto = "";

if ($norte != "0.00") {
    $valores = "a região norte no valor de R$ " . $eventoObj->dinheiroParaBr($norte) . " ( " . $eventoObj->valorPorExtenso($norte) . " )";
}

if ($sul != "0.00") {
    $valores .= ", a região sul no valor de R$ " . $eventoObj->dinheiroParaBr($sul) . " ( " . $eventoObj->valorPorExtenso($sul) . " )";
}

if ($leste != "0.00") {
    $valores .= ", a região leste no valor de R$ " . $eventoObj->dinheiroParaBr($leste) . " ( " . $eventoObj->valorPorExtenso($leste) . " )";
}

if ($oeste != "0.00") {
    $valores .= ", a região oeste no valor de R$ " . $eventoObj->dinheiroParaBr($oeste) . " ( " . $eventoObj->valorPorExtenso($oeste) . " )";
}

if ($centro != "0.00") {
    $valores .= ", a região centro no valor de R$ " . $eventoObj->dinheiroParaBr($centro) . " (" . $eventoObj->valorPorExtenso($centro) . " )";
}

if ($norte != "0.00" || $sul != "0.00" || $leste != "0.00" || $oeste != "0.00" || $centro != "0.00") {
    $texto = "<p>&nbsp;</p><p>Em atendimento ao item referente a regionalização e georreferenciamento das despesas municipais com a implantação do detalhamento da ação, informo que a despesa aqui tratada se refere(m) " . $valores . ".</p>";
}

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
            font-size: 13px;
            font-family: Arial, Helvetica, sans-serif;
            text-align: justify;
        }
    </style>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= SERVERURL ?>views/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= SERVERURL ?>views/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?= SERVERURL ?>views/dist/css/custom.min.css">
    <title>Ateste</title>
</head>
<body>

<div align="center">
    <div id="texto" class="texto">
        <p><strong>Interessado:</strong> <?= $proponente ?></p>
        <p><strong>Do evento:</strong> <?= $objeto ?></p>
        <p>&nbsp;</p>
        <p>Atesto o recebimento em <strong>DATA</strong>, de toda a documentação: nota fiscal  <strong>LINK NOTA FISCAL</strong> e arquivos consolidados, previstos na Portaria SF 08/16.</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><strong>SMC - CONTABILIDADE</strong></p>
        <p><strong>Sr.(a) Contador(a)</strong></p>
        <p>&nbsp;</p>
        <p>Encaminho o presente para providências quanto ao pagamento, uma vez que os serviços foram realizados e confirmados a contento conforme documento <strong>LINK DA SOLICITAÇÃO</strong>.</p>
        <?= $texto ?>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>INFORMAÇÕES COMPLEMENTARES</p>
        <hr>
        <p><strong>Nota e Anexo de Empenho: </strong><?= $eventoObj->checaCampo($ne->nota_empenho) ?></p>
        <p><strong>Kit de Pagamento Assinado:</strong></p>
        <p><strong>Certdões Fiscais:</strong></p>
        <p><strong>FACC:</strong></p>
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