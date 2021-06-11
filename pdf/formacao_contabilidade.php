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
$coordenaria = $formObj->recuperaContratacao($pedido->origem_id)->coordenadoria;
$locais = $formObj->retornaLocaisFormacao($pedido->origem_id, 1);

$data = date('d/m/Y');
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
    <title>Contabilidade</title>
</head>

<body>
<br>
<div align="center">
    <?php
    $conteudo =
        "<p>&nbsp;</p>" .
        "<p><strong>Interessado:</strong> " . $pf->nome . "</p>" .
        "<p><strong>Objeto:</strong> " . $formObj->retornaObjetoFormacao($pedido->origem_id) . "</p>" .
        "<p>&nbsp;</p>" .
        "<p>Atesto o recebimento em " . $data . ", de toda a documentação: recibo link SEI e arquivos consolidados, previstos na Portaria SF 08/16.</p>" .

        "<p>&nbsp;</p>" .
        "<p><strong>SMC - CONTABILIDADE</strong></p>" .
        "<p><strong>Sr.(a) Contador(a)</strong></p>" .
        "<p align='justify'>Encaminho o presente para providências quanto ao pagamento, uma vez que os serviços foram realizados e confirmados a contento conforme documento link SEI.</p>" .
        $regionalizacao .

        "<p>&nbsp;</p>" .

        "<p>INFORMAÇÕES COMPLEMENTARES</p>" .
        "<hr />" .
        "<p><strong>Nota de Empenho:</strong></p>" .
        "<p><strong>Anexo Nota de Empenho:</strong></p>" .
        "<p><strong>Recibo da Nota de Empenho:</strong></p>" .
        "<p><strong>Pedido de Pagamento:</strong></p>" .
        "<p><strong>Recibo de pagamento:</strong></p>" .
        "<p><strong>Relatório de Horas Trabalhadas:</strong></p>" .
        "<p><strong>NIT/PIS/PASEP:</strong></p>" .
        "<p><strong>Certidões fiscais:</strong></p>" .
        "<p><strong>CCM:</strong></p>" .
        "<p><strong>FACC:</strong></p>" .
        "<p>&nbsp;</p>" .

        "<p>São Paulo, $dia de $mes de $ano</p>";
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
        } catch (err) {
            alert('Texo não copiado, tente novamente.');
        }
    }
</script>

</body>
</html>