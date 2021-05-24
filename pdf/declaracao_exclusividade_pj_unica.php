<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$pedidoAjax = true;

// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../config/configGeral.php";
require_once "../views/plugins/fpdf/fpdf.php";
require_once "../controllers/PedidoController.php";
require_once "../controllers/EventoController.php";
require_once "../controllers/AtracaoController.php";
require_once "../controllers/LiderController.php";

$id = $_GET['id'];

$eventoObj = new EventoController();
$pedidoObj = new PedidoController();
$liderObj = new LiderController();
$atracaoObj = new AtracaoController();

$atracao = $atracaoObj->recuperaAtracao($id);
$idEvento = $atracao->evento_id;
$pedido = $pedidoObj->recuperaPedido(1,$idEvento);
$evento = $eventoObj->recuperaEvento($idEvento);
$lider = $liderObj->recuperaLider($pedido->id, $atracao->id);
$integrantes = $atracaoObj->recuperaIntegrante($id);

if ($lider->passaporte){
    $documento = ", Passaporte: " . $lider->passaporte;
} else{
    $documento = ", RG: " . $lider->rg . ", CPF: " . $lider->cpf;
}

class PDF extends FPDF
{
}

// GERANDO O PDF:
$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();


$x = 20;
$l = 6; //DEFINE A ALTURA DA LINHA

$pdf->SetXY($x, 30);// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

$pdf->SetTitle("Exclusividade PJ");

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(180, $l, utf8_decode('DECLARAÇÃO DE EXCLUSIVIDADE'), 0, 1, 'C');

$pdf->Ln(10);

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(180, $l, utf8_decode("Eu, " . $lider->nome . $documento . ", sob penas da lei, declaro que sou representado exclusivamente pela empresa " . $pedido->razao_social . ", CNPJ " . $pedido->cnpj . ""));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(180, $l, utf8_decode("Estou ciente de que o pagamento dos valores decorrentes dos serviços é de responsabilidade da minha representante, não me cabendo pleitear à Prefeitura quaisquer valores eventualmente não repassados."));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(180, $l, utf8_decode($pedido->razao_social . ", CNPJ " . $pedido->cnpj . " representada por " . $pedido->rep1['nome'] . ", RG " . $pedido->rep1['rg'] . ", CPF " . $pedido->rep1['cpf'] . " declara sob penas da lei ser representante de " . $lider->nome . "."));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(180, $l, utf8_decode("Declaro, sob as penas da lei, que não sou servidor público municipal e que não me encontro em impedimento para contratar com a Prefeitura do Município de São Paulo / Secretaria Municipal de Cultura, mediante recebimento de cachê e/ou bilheteria, quando for o caso."));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(180, $l, utf8_decode("Declaro, ainda, neste ato, que autorizo, a título gratuito, por prazo indeterminado, a Municipalidade de São Paulo, através da SMC, o uso da nossa imagem, voz e performance nas suas publicações em papel e qualquer mídia digital, streaming ou internet existentes ou que venha a existir como também para os fins de arquivo e material de pesquisa e consulta."));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(180, $l, utf8_decode("A empresa fica autorizada a celebrar contrato, inclusive receber cachê e/ou bilheteria quando for o caso, outorgando quitação."));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(180, $l, utf8_decode("São Paulo, _______ / _______ /" . date('Y') . "."));

$pdf->Ln(20);

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(100, 4, utf8_decode("Nome do Líder do Grupo: " . $lider->nome), 'T', 1, 0);

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 9);
if ($lider->passaporte != NULL) { //testa e exibe o passaporte do lider, caso não haja passaporte exibe o rg juntamente do cpf
    $pdf->MultiCell(100, 4, "Passaporte: " . $lider->passaporte, 0, 'L', 0);
} else {
    $pdf->MultiCell(100, 4, "RG: " . $lider->rg, 0, 'L', 0);
    $pdf->SetX($x);
    $pdf->MultiCell(100, 4, "CPF: " . $lider->cpf, 0, 'L', 0);
}

$pdf->Ln(20);

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(100, 4, utf8_decode("Representante Legal: " . $pedido->rep1['nome']), 'T', 'L', 0);

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(100, 4, "RG: " . $pedido->rep1['rg'], 0, 'L', 0);

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(100, 4, "CPF: " . $pedido->rep1['cpf'], 0, 'L', 0);

$pdf->Output();