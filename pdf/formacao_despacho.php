<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$pedidoAjax = true;
// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../config/configGeral.php";
require_once "../controllers/FormacaoController.php";

$formObj = new FormacaoController();

$pedido_id = $_GET['id'];

$pedido = $formObj->recuperaPedido($pedido_id);

$periodo = $formObj->retornaPeriodoFormacao($pedido_id);
$pf = $formObj->recuperaPf($pedido->pessoa_fisica_id);
$contratacao = $formObj->recuperaContratacao($pedido->origem_id, '0');

if($pf->passaporte != NULL):
    $trecho_cpf_passaporte = "<p><strong>Contratado:</strong> " . $pf->nome . ", Passaporte (" . $pf->passaporte . ")</p>";
else:
    $trecho_cpf_passaporte = "<p><strong>Contratado:</strong> " . $pf->nome . ", CPF (" . $pf->cpf . ")</p>";
endif;

$dotacao = DbModel::consultaSimples("SELECT acao FROM verbas WHERE id = $contratacao->programa_verba_id")->fetchObject()->acao;
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
        "<p>&nbsp;</p>" .
        "<p align='justify'>I - À vista dos elementos constantes do presente, em especial da seleção realizada conforme Edital de chamamento para credenciamento de  Artistas-Educadores e Coordenadores Artístico-Pedagógicos do " . $contratacao->programa . " - " . $contratacao->edital . ", para atuar nos equipamentos públicos da Secretaria Municipal de Cultura e nos CEUS (Centros Educacionais Unificados)  da Secretaria Municipal de Educação na edição de 2020, publicado no DOC de  24/10/2019  (link SEI), no uso da competência a mim delegada pela Portaria nº 17/2018 - SMC/G , AUTORIZO com fundamento no artigo 25 “caput”, da Lei Federal nº 8.666/93, a contratação nas condições abaixo estipuladas, observada a legislação vigente e demais cautelas legais:</p>" .
        $trecho_cpf_passaporte .
        "<p><strong>Objeto:</strong> " . $formObj->retornaObjetoFormacao($pedido->origem_id) . "</p>" .
        "<p><strong>Data / Período:</strong> " . $formObj->retornaPeriodoFormacao($pedido_id) . "</p>" .
        "<p><strong>Local(ais):</strong> " . $formObj->retornaLocaisFormacao($pedido->origem_id) . "</p>" .
        "<p><strong>Carga Horária:</strong> " . PedidoController::retornaCargaHoraria($pedido_id, '1') . " Hora(s)" . "</p>" .
        "<p><strong>Valor:</strong> R$ " . MainModel::dinheiroParaBr($pedido->valor_total) . " (" . MainModel::valorPorExtenso($pedido->valor_total) . " )" . "</p>" .
        "<p><strong>Forma de Pagamento:</strong> Os valores devidos ao contratado serão apurados mensalmente de acordo com as horas efetivamente trabalhadas e pagos a partir do 1° dia útil do mês subseqüente ao trabalhado, desde que comprovada a execução dos serviços através da entrega à Supervisão de Formação Artística e Cultural dos documentos modelos preenchidos corretamente, sem rasuras, além da entrega do Relatório de Horas Trabalhadas atestadas pelo equipamento vinculado e, apenas para os artistas educadores/orientadores, as Listas de Presença de cada turma, nos termos do item 13.1 do Edital.</p>" .
        "<p><strong>Dotação Orçamentária: </strong>" . $dotacao . "</p>" .
        "<p align='justify'>II - Nos termos do art. 6º do Decreto nº 54.873/2014, designo a servidora Natalia Silva Cunha, RF 842.773.9,  como fiscal do contrato, e  Ilton T. Hanashiro Yogi, RF n.º 800.116.2, como suplente.</p>" .
        "<p align='justify'>III - Publique-se e encaminhe-se ao setor competente para providências cabíveis.</p>" .
        "<p>&nbsp;</p>" .
        "<p>&nbsp;</p>" .
        "<p>&nbsp;</p>" .
        "<p align='center'><b>Chefe de Gabinete<br/>S.M.C</b></p>" .
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
        <button class="btn btn-primary">CLIQUE AQUI PARA ACESSAR O <img src="../visual/images/logo_sei.jpg"></button>
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