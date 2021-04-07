<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$pedidoAjax = true;
// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../config/configGeral.php";
require_once "../controllers/FormacaoController.php";
require_once "../controllers/PedidoController.php";

$formObj = new FormacaoController();
$pedidoObj = new PedidoController();

$pedido_id = $_GET['id'];
//$tipo = $_GET['tipo'];

$pedido = $formObj->recuperaPedido($pedido_id);

$verba = $pedidoObj->recuperaVerba($pedido->verba_id);

$pf = $formObj->recuperaPf($pedido->pessoa_fisica_id);
$contratacao = $formObj->recuperaContratacao($pedido->origem_id);
$objeto = $formObj->retornaObjetoFormacao($pedido->origem_id);

$nome = $pf->nome_social != null ? "$pf->nome_social ($pf->nome)" : $pf->nome;

if ($pedido->verba_id == 22){ //Transferência de outra secretaria
    $topico = "<p>Assim, solicito a reserva de recursos, que deverá onerar os recursos da Nota de Reserva com Transferência da SME nº 22.671/2019 e para o INSS Patronal a Nota de Reserva com Transferência nº 22.711/2019 SEI (link do SEI).</p>";
} else{
    $topico = "<p>Assim, solicito a reserva de recursos que deverá onerar a ação $verba->acao.</p>";
}

/*switch ($tipo) {
    case "pia":

        break;
    case "sme":
        $topico = "<p>Assim, solicito a reserva de recursos, que deverá onerar os recursos da Nota de Reserva com Transferência da SME nº 22.671/2019 e para o INSS Patronal a Nota de Reserva com Transferência nº 22.711/2019 SEI (link do SEI).</p>";
        break;
    case "vocacional":
        $topico = "<p>Assim, solicito a reserva de recursos que deverá onerar a ação 6375 – Dotação 25.10.13.392.3001.6375.</p>";
        break;
    default:
        $topico = "";
        break;
}*/
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
    <title>Pedido de Reserva</title>
</head>

<body>
<br>
<div align="center">
    <div id="texto" class="texto">
        <p><b>Do processo nº:</b> <?=$pedido->numero_processo?></p>
        <p>&nbsp;</p>
        <p><b>INTERESSADO:</b> <?= $nome ?><br>
            <b>OBJETO:</b> <?= $objeto ?></p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><b>CONTABILIDADE</b></p>
        <p>&nbsp;</p>
        <p>
            <strong>Sr(a). Responsável,</strong><br>
            O presente processo trata de <?= $nome ?>, <?= $contratacao->programa ?>, <?= $contratacao->linguagem ?> NOS TERMOS DO EDITAL - <?= strtoupper($contratacao->edital) ?> - PROGRAMAS DA SUPERVISÃO DE FORMAÇÃO CULTURAL, no valor de R$ <?= (new MainModel)->dinheiroParaBr($pedido->valor_total) ?> ( <?=  (new MainModel)->valorPorExtenso($pedido->valor_total) ?>), conforme solicitação (link da solicitação), foram anexados os documentos necessários exigidos no edital, no período de <?= $formObj->retornaPeriodoFormacao($pedido->origem_id) ?>.
        </p>
        <p>&nbsp;</p>
        <?= $topico ?>
        <p>&nbsp;</p>
        <p>Após, enviar para SMC/AJ, para prosseguimento.</p>
    </div>
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
        }
        catch (err) {
            alert('Texto não copiado, tente novamente.');
            selection.removeAllRanges();
        }
    }
</script>

</body>
</html>