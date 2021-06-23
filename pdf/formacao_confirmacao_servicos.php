<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$pedidoAjax = true;
// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../config/configGeral.php";
require_once "../controllers/FormacaoController.php";
require_once "../controllers/FormacaoPedidoController.php";

$formObj = new FormacaoController();

$parcela_id = $_GET['parcela'];
$pedido_id = $_GET['id'];

$dataAtual = date('d/m/Y');
$contratacao = (new FormacaoPedidoController)->recuperar($pedido_id);
$contratacao_id = $contratacao->origem_id;
$dadosParcela = $formObj->recuperaDadosParcelas($contratacao_id, '1', $parcela_id);
$periodo = $formObj->retornaPeriodoFormacao($contratacao_id, '1', $parcela_id);
$locais = $formObj->retornaLocaisFormacao($pedido->origem_id, 1);

$data_inicio = MainModel::dataParaBR($dadosParcela->data_inicio);
$data_fim = MainModel::dataParaBR($dadosParcela->data_fim);

$dia = date('d');
$mes = MainModel::retornaMes(date('m'));
$ano = date('Y');

if (sizeof($locais) === 2)
    $regionalizacao = "<p align='justify'>Em virtude da Regionalização e Georreferenciamento das Despesas Municipais com a nova implantação do Detalhamento da Ação em 2021 no Sistema SOF, informamos que os valores do presente pagamento foram gastos nas subprefeituras:   {$locais[0]['subprefeitura']},  50% do valor da parcela e {$locais[1]['subprefeitura']}, 50% do valor da parcela.</p>";
else
    $regionalizacao = "<p align='justify'>Em virtude da Regionalização e Georreferenciamento das Despesas Municipais com a nova implantação do Detalhamento da Ação em 2021 no Sistema SOF, informamos que os valores do presente pagamento foram gastos nas subprefeituras: {$locais[0]['subprefeitura']},  100% do valor da parcela.</p>";

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
    <title>Atestado de Serviço</title>
</head>

<br>
<body>

<div align="center">
    <div id="texto" class="texto">
        <p align="center"><strong><u>Anexo I da Portaria SF nº 170, de 31 agosto de 2020</u></strong></p>
        <p>&nbsp;</p>
        <p><strong>Recebimento da Documentação </strong></p>
        <p>Atesto:</p>
        <p align="justify">( X ) o recebimento em <?= $dataAtual ?> de toda a documentação [INSERIR NÚMERO SEI DA NOTA FISCAL E ARQUIVOS CONSOLIDADOS] prevista na Portaria SF nº 170/2020.<br>O prazo contratual é <?= $periodo ?>.</p>
        <p align="justify">( &nbsp; ) o recebimento em <?= $dataAtual ?> da documentação [INSERIR NÚMERO SEI DA NOTA FISCAL E ARQUIVOS CONSOLIDADOS] prevista na Portaria SF nº 170/2020, ressalvado (s) [RELACIONAR OS DOCUMENTOS IRREGULARES].<br>O prazo contratual é <?= $periodo ?>.</p>
        <p>&nbsp;</p>
        <p align="justify"><strong>Recebimento de material e/ou serviços: </strong></p>
        <p>Atesto:</p>
        <p align="justify">( X ) que os materiais/serviços prestados discriminados no documento fiscal [INSERIR NÚMERO SEI DA NOTA FISCAL ] foram entregues e/ou executados a contento nos termos previstos no instrumento contratual (ou documento equivalente) no dia <?= $data_inicio ?>, dentro do prazo previsto.<br>O prazo contratual é <?= $periodo ?>.</p>
        <p align="justify">( &nbsp; ) que os materiais/serviços prestados discriminados no documento fiscal [INSERIR NÚMERO SEI DA NOTA FISCAL ] foram entregues e/ou executados parcialmente, nos termos previstos no instrumento contratual (ou documento
            equivalente), do dia <?= $data_fim ?>, dentro do prazo previsto.<br>O prazo contratual é <?= $periodo ?>. </p>
        <p align="justify">( &nbsp; ) que os materiais/serviços prestados discriminados no documento fiscal [INSERIR NÚMERO SEI DA NOTA FISCAL] foram entregues e/ou executados a contento nos termos previstos no instrumento contratual (ou documento equivalente) no dia _____ / _____ / _____, com atraso de ____ dias.<br>O prazo contratual é <?= $periodo ?>.</p>
        <p>&nbsp;</p>
        <p align="justify">
            <b>Nota de Empenho:</b> <br>
            <b>Anexo da Nota de Empenho:</b> <br>
            <b>Recibo da Nota de Empenho:</b> <br>
            <b>Pedido de Pagamento:</b> <br>
            <b>Recibo de Pagamento:</b> <br>
            <b>Relatório de Horas Trabalhadas:</b> <br>
            <b>PIS/NIT/PASEP:</b> <br>
            <b>Certidões Fiscais / CCM:</b> <br>
            <b>FACC:</b>
        </p>
        <p><?= $regionalizacao ?></p>
        <p>&nbsp;</p>
        <p>À área gestora / de liquidação e pagamento. </p>
        <p>&nbsp;</p>
        <p>Encaminho para prosseguimento </p>
        <p>São Paulo, <?= $dia ?> de <?= $mes ?> de <?= $ano ?>.</p>

    </div>
</div>

<div align="center">
    <button id="botao-copiar" class="btn btn-primary" onclick="copyText(getElementById('texto'))">
        CLIQUE AQUI PARA COPIAR O TEXTO
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
        }
        catch (err) {
            alert('Texo não copiado, tente novamente.');
        }
    }
</script>

</body>
</html>