<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$pedidoAjax = true;
// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../config/configGeral.php";
require_once "../controllers/FormacaoController.php";
require_once "../controllers/PedidoController.php";

$formObj = new FormacaoController();
$pedidoObj = new PedidoController();

$pedido_id = intval($_POST['idPedido']);

$pedido = $formObj->recuperaPedido($pedido_id);

$pf = $formObj->recuperaPf($pedido->pessoa_fisica_id);
$contratacao = $formObj->recuperaContratacao($pedido_id, '0');

$dataAtual = date('d-m-Y');

header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=" . $pedido->numero_processo . "_em_$dataAtual.doc");
?>
<html lang="pt-br">
<header>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
</header>
<body>
    <p style="text-align: justify"><b>CONTRATANTE:</b> Secretaria Municipal de Cultura</p>
    <p style="text-align: justify"><b>CONTRATADO(S):</b> Contratação de <b><?=$pf->nome?></b>, <?= $pf->cpf ?> e demais integrantes relacionados na declaração de exclusividade.</p>
    <p style="text-align: justify"><b>EVENTO/SERV:</b> Apresentação do <?= $formObj->retornaObjetoFormacao($pedido_id) ?>, conforme segue: <?= $formObj->retornaLocaisFormacao($pedido_id) ?> <br></p>
    <p style="text-align: justify"><b>DATA/PERÍODO:</b> <?= $formObj->retornaPeriodoFormacao($pedido_id) ?></p>
    <p style="text-align: justify"><b>VALOR TOTAL DA CONTRATAÇÃO:</b> R$ <?= MainModel::dinheiroParaBr($pedido->valor_total) ?> ( <?= MainModel::valorPorExtenso($pedido->valor_total) ?> )<br> Quaisquer despesas aqui não ressalvadas, bem como direitos autorais, serão de responsabilidade do(a) contratado(a).</p>
    <p style="text-align: justify"><b>CONDIÇÕES DE PAGAMENTO:</b> <?= $pedido->forma_pagamento ?></p>
    <p style="text-align: justify">O pagamento será efetuado por crédito em conta corrente no BANCO DO BRASIL, em  conformidade com o Decreto 51.197/2010, publicado no DOC de 23/01/2010.<br/>
        De acordo com a Portaria nº 5/2012 de SF, haverá compensação financeira, se houver atraso no pagamento do valor devido, por culpa exclusiva do Contratante, dependendo de requerimento a ser formalizado pelo Contratado.</p>
    <p style="text-align: justify"><b>FISCALIZAÇÃO DO CONTRATO NA SMC: </b>Servidor <?=$pedido->fiscal_nome?> - RF <?=$pedido->fiscal_rf?> como fiscal do contrato e Sr(a) <?=$pedido->suplente_nome?> - RF <?=$pedido->suplente_rf?> como substituto(a).<br>
        <b> De acordo com a Portaria nº 5/2012 de SF, haverá compensação financeira, se houver atraso no pagamento do valor devido, por culpa exclusiva do Contratante, dependendo de requerimento a ser formalizado pelo Contratado.</b> </p>
    <p style="text-align: justify"><b>PENALIDADES:</b> <?= $pedidoObj->recuperaPenalidades(20) ?></p>
    <p style="text-align: justify"><b>RESCISÃO CONTRATUAL: </b> DESPACHO - Dar-se-á caso ocorra quaisquer dos atos cabíveis descritos na legislação vigente.<br>
        * Contratação, por inexigibilidade da licitação, com fundamento no artigo 25, Inciso III, da Lei Federal nº. 8.666/93, e alterações posteriores, e artigo 1º da Lei Municipal nº. 13.278/02, nos termos dos artigos 16 e 17 do Decreto Municipal nº. 44.279/03.</p>
    <p style="text-align: justify"><b> ** OBSERVAÇÕES:<br/>
        ESTE EMPENHO SUBSTITUI O CONTRATO, CONFORME ARTIGO 62 DA LEI FEDERAL Nº. 8.666/93.</b><br/>
    As idéias e opiniões expressas durante as apresentações artísticas e culturais não representam a posição da Secretaria Municipal de Cultura, sendo os artistas e seus representantes os únicos e exclusivos responsáveis pelo conteúdo de suas manifestações, ficando a Municipalidade de São Paulo com direito de regresso sobre os mesmos, inclusive em caso de indenização por dano material, moral ou à imagem de terceiros.
    </p>
</body>
</html>
