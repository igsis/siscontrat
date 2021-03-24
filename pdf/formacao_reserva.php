<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$pedidoAjax = true;
// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../config/configGeral.php";
require_once "../controllers/FormacaoController.php";

$formObj = new FormacaoController();

$pedido_id = $_GET['id'];
$tipo = $_GET['tipo'];
$ano = date('Y');

$pedido = $formObj->recuperaPedido($pedido_id);

$pf = $formObj->recuperaPf($pedido->pessoa_fisica_id);
$contratacao = $formObj->recuperaContratacao($pedido->origem_id);
$vigencia = $formObj->dadosVigencia($contratacao->form_vigencia_id);
switch ($tipo) {
    case "pia":
        $topico = "<p>Assim, solicito a reserva de recursos que deverá onerar a ação 6374 – Dotação 25.10.13.392.3001.6374</p>";
        $objetivo = "O presente processo trata de {$pf->nome}, contratação como {$pedido->cargo} de {$pedido->linguagem} do {$contratacao->programa} - 2021 nos termos do  EDITAL  026/2020 - SMC/CFOC/SFC - PROGRAMAS DA SUPERVISÃO DE FORMAÇÃO CULTURAL. , no valor de {$formObj->dinheiroParaBr($vigencia->valorTotal)} , conforme solicitação (  link SEI ), foram anexados os documentos necessários exigidos no edital, no período de {$formObj->retornaPeriodoFormacao($contratacao->id)}.";
        break;
    case "sme":
        $topico = "<p>Assim, solicito a reserva de recursos, que deverá onerar os recursos da Nota de Reserva com Transferência da SME nº 22.671/2019 e para o INSS Patronal a Nota de Reserva com Transferência nº 22.711/2019 SEI (link do SEI)</p>";
        $objetivo = "";
        break;
    case "vocacional":
        $topico = "<p>Assim, solicito a reserva de recursos que deverá onerar a ação 6375 – Dotação 25.10.13.392.3001.6375</p>";
        $objetivo = "O presente processo trata de {$pf->nome}, contratação como {$pedido->cargo} de {$pedido->linguagem} do {$contratacao->programa} - 2021 nos termos do  EDITAL  027/2020 - SMC/CFOC/SFC - PROGRAMAS DA SUPERVISÃO DE FORMAÇÃO CULTURAL. , no valor de {$formObj->dinheiroParaBr($vigencia->valorTotal)}, conforme solicitação (  link SEI ), foram anexados os documentos necessários exigidos no edital, no período de {$formObj->retornaPeriodoFormacao($contratacao->id)}.";
        break;
    default:
        $topico = "";
        break;
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
    <title>Pedido de Reserva</title>
</head>

<body>
<br>
<div align="center">
    <?php
    $conteudo =
        "<p><strong>Do processo nº:</strong> " . $pedido->protocolo . "</p>" .
        "<p>&nbsp;</p>" .
        "<p><strong>INTERESSADO:</strong> " . $pf->nome . "  </span></p>" .
        "<p><strong>Objeto:</strong> " . $objetivo . "</p>" .
        "<p>&nbsp;</p>" .
        "<p><strong>CONTABILIDADE</strong></p>" .
        "<p><strong>Sr(a). Responsável</strong></p>" .
        "<p>&nbsp;</p>" .
        "<p>O presente processo trata de " . $pf->nome . ", " . $contratacao->programa . ", " . $contratacao->linguagem . " NOS TERMOS DO EDITAL - " . $contratacao->programa . ", no valor de " . "R$ " . "  " . MainModel::dinheiroParaBr($pedido->valor_total) . " ( ". MainModel::valorPorExtenso($pedido->valor_total) . ")" .  ", conforme solicitação (link da solicitação), foram anexados os documentos necessários exigidos no edital, no período de " . $formObj->retornaPeriodoFormacao($pedido->origem_id) . " </p>" .
        "<p>&nbsp;</p>" .
        $topico .
        "<p>&nbsp;</p>" .
        "<p>Após, enviar para SMC/AJ, para prosseguimento.</p>" .
        "<p>&nbsp;</p>"
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
        }
        catch (err) {
            alert('Texto não copiado, tente novamente.');
            selection.removeAllRanges();
        }
    }
</script>

</body>
</html>