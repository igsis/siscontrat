<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$pedidoAjax = true;
// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../config/configGeral.php";
require_once "../views/plugins/fpdf/fpdf.php";
require_once "../controllers/FormacaoPedidoController.php";
require_once "../controllers/FormacaoController.php";
require_once "../controllers/PessoaFisicaController.php";

$formObj = new FormacaoPedidoController();

$parcela_id = $_GET['parcela'];
$pedido_id = $_GET['id'];

class PDF extends FPDF
{
}

$pedido = $formObj->recuperar($pedido_id);
$pf = (new PessoaFisicaController)->recuperaPessoaFisica($pedido->pessoa_fisica_id);
$telPf = "";
foreach ($pf->telefones as $key => $telefone) {
    if ($key !== "tel_0"){
        $telPf .= " / ";
    }
    $telPf .= "{$telefone}";
}
$parcelaDados = (new FormacaoController)->recuperaDadosParcelas($pedido->origem_id, true, $parcela_id);

$nome = $pf->nome_social != null ? "$pf->nome_social ($pf->nome)" : $pf->nome;

$ano = date('Y');

$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();


$x = 20;
$l = 6; //DEFINE A ALTURA DA LINHA

$pdf->SetXY($x, 25);// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

$pdf->SetTitle('Pagamento');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(180, 15, utf8_decode("PEDIDO DE PAGAMENTO"), 0, 1, 'C');

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(180, $l, utf8_decode("Senhor(a)"), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(180, $l, utf8_decode("Chefe de Gabinete da"), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(180, $l, utf8_decode("Secretaria Municipal de Cultura"), 0, 1, 'L');

$pdf->Ln(14);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(16, $l, utf8_decode("Assunto:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(166, $l, utf8_decode("Pedido de Pagamento de R$ " . MainModel::dinheiroParaBr($parcelaDados->valor) . " ( " . MainModel::valorPorExtenso($parcelaDados->valor) . ")"), 0, 'L', 0);

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(14, $l, utf8_decode("Objeto:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(166, $l, utf8_decode((new FormacaoController)->retornarObjeto($pedido->origem_id)));

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(15, $l, utf8_decode("Local(s):"), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(165, $l, utf8_decode((new FormacaoController)->retornaLocaisFormacao($pedido->origem_id)), 0, 'L', 0);

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(35, $l, utf8_decode("Período de locação:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(145, $l, utf8_decode((new FormacaoController)->retornaPeriodoFormacao($pedido->origem_id, '', '1', $parcela_id)), 0, 'L', 0);

$pdf->Ln();

$pdf->SetX($x);
$pdf->MultiCell(200, $l, utf8_decode("PAGAMENTO LIBERÁVEL A PARTIR DE " . MainModel::dataParaBR($parcelaDados->data_pagamento) . " MEDIANTE CONFIRMAÇÃO DA UNIDADE PROPONENTE."), 0, 'L', 0);

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(12, $l, 'Nome:', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(120, $l, utf8_decode($nome), 0, 'L', 0);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
if ($pf->passaporte != NULL) {
    $pdf->Cell(21, $l, utf8_decode('Passaporte:'), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(50, $l, utf8_decode($pf->passaporte), 0, 1, 'L');
} else {
    $pdf->Cell(7, $l, utf8_decode('RG:'), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(50, $l, utf8_decode($pf->rg ?? "Não cadastrado"), 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(9, $l, utf8_decode('CPF:'), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(45, $l, utf8_decode($pf->cpf), 0, 1, 'L');
}

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(37, $l, 'Data de Nascimento:', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(120, $l, utf8_decode(MainModel::dataParaBR($pf->data_nascimento) == "00-00-0000" ? "Não Cadastrado" : MainModel::dataParaBR($pf->data_nascimento)), 0, 'L', 0);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(18, $l, utf8_decode("Endereço:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(160, $l, utf8_decode( $pf->logradouro . ", " . $pf->numero . " " . $pf->complemento . " / - " . $pf->bairro . " - " . $pf->cidade . " / " . $pf->uf));

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(21, $l, 'Telefone(s):', '0', '0', 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(95, $l, utf8_decode($telPf), 0, 'L', 0);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(12, $l, 'Email:', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(168, $l, utf8_decode($pf->email), 0, 1, 'L');

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(180, $l, utf8_decode("Venho, mui respeitosamente, requerer que o(a) senhor(a) se digne submeter a exame à decisão do órgão competente o pedido supra.
Declaro, sob as penas da Lei, não possuir débitos perante as Fazendas Públicas, em especial com a Prefeitura do Município de São Paulo.
Nestes termos, encaminho para deferimento."));

$pdf->Ln(10);

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(180, $l, utf8_decode("São Paulo, _______ de ________________________ de " . $ano . "."));

$pdf->SetXY($x, 262);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(100, $l, utf8_decode($nome), 'T', 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 10);

if ($pf->passaporte != NULL) {
    $pdf->Cell(100, 4, "Passaporte: " . $pf->passaporte, 0, 1, 'L');
} else {
    $rg = "RG: " . MainModel::checaCampo($pf->rg);
    $pdf->Cell(100, 4, utf8_decode($rg), 0, 1, 'L');
}

$pdf->Output('formacao_pagamento.pdf', 'I');
?>