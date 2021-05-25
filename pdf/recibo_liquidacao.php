<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$pedidoAjax = true;

// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../config/configGeral.php";
require_once "../views/plugins/fpdf/fpdf.php";
require_once "../controllers/PedidoController.php";
require_once "../controllers/EventoController.php";
require_once "../controllers/LiquidacaoController.php";

$id = $_GET['id'];

$eventoObj = new EventoController();
$pedidoObj = new PedidoController();
$liquidObj = new LiquidacaoController();

$pedido = $pedidoObj->recuperaPedido(1,$id);
$objeto = $eventoObj->recuperaObjetoEvento($id);
$liquidacao = $liquidObj->recuperaLiquidacao($pedido->id);
$ccm = (new MainModel)->checaCampo($pedido->ccm);

class PDF extends FPDF
{
    function Header()
    {
        $this->Image(SERVERURL.'views/dist/img/logo_smc.jpg', 170, 10);
        $this->Ln(20);
    }
}

// GERANDO O PDF:
$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();


$x = 25;
$l = 6; //DEFINE A ALTURA DA LINHA

$pdf->SetXY($x, 45);// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

$pdf->SetTitle("Recibo Liquidação", true);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(160, 5, utf8_decode("RECIBO DE ENTREGA DE NOTA DE LIQUIDAÇÃO"), 0, 1, 'C');

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(160, $l, utf8_decode("Recebi nesta data, da Secretaria Municipal de Cultura, cópias dos seguintes documentos, conforme consta no processo nº:  $pedido->numero_processo."));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(10, 5, utf8_decode("(    )"), 0, 0, 'C');
$pdf->MultiCell(160, $l, utf8_decode("Extrato de Liquidação e Pagamento nº: $liquidacao->extrato_liquidacao."));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(10, 5, utf8_decode("(    )"), 0, 0, 'C');
$pdf->MultiCell(160, $l, utf8_decode("Retenções de I.N.S.S. - Guia de Recolhimento ou Depósito da Prefeitura do Município de São Paulo nº: $liquidacao->retencoes_inss."));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(10, 5, utf8_decode("(    )"), 0, 0, 'C');
$pdf->MultiCell(160, $l, utf8_decode("Retenções de I.S.S. - Documento de Arrecadação de Tributos Imobiliários - DARM n.º: $liquidacao->retencoes_iss."));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(10, 5, utf8_decode("(    )"), 0, 0, 'C');
$pdf->MultiCell(160, $l, utf8_decode("Retenções de I.R.R.F. - Guia Recibo de Recolhimento ou Depósito nº: $liquidacao->retencoes_irrf."));

$pdf->Ln();
$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(160, $l, utf8_decode("Em, ______ de _______________________ de " . date('Y') . "."));

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(160, $l, utf8_decode("Assinatura: ____________________________________________"));

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

if ($pedido->pessoa_tipo_id == 1) {
    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(100, $l, utf8_decode($pedido->nome), 0, 1, 'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', 11);
    if ($pedido->passaporte != NULL) {
        $pdf->Cell(100, $l, "Passaporte: " . $pedido->passaporte, 0, 1, 'L');
    } else {
        $rg = $pedido->rg == NULL ? "Não cadastrado" : $pedido->rg;
        $rg = "RG: " . $rg;
        $pdf->Cell(100, $l, utf8_decode($rg), 0, 1, 'L');
        $pdf->SetX($x);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(100, $l, "CPF: " . $pedido->cpf, 0, 1, 'L');
        $pdf->SetX($x);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(100, $l, utf8_decode("CCM: " . $ccm), 0, 0, 'L');
    }
} else {
    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(27, $l, utf8_decode('Razão Social:'), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(150, $l, utf8_decode($pedido->razao_social), 0, 1, 'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(14, $l, utf8_decode('CNPJ:'), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(150, $l, utf8_decode($pedido->cnpj), 0, 1, 'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(12, $l, utf8_decode('CCM:'), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(150, $l, utf8_decode($ccm), 0, 1, 'L');

    $pdf->Ln();

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(37, $l, utf8_decode('Responsável(eis):'), 0, 1, 'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(143, $l, utf8_decode($pedido->rep1['nome']), 0, 1, 'L');

    if($pedido->rep2['nome'] != ""):
        $pdf->SetX($x);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(143, $l, utf8_decode($pedido->rep2['nome']), 0, 1, 'L');
    endif;
}

$pdf->Output();