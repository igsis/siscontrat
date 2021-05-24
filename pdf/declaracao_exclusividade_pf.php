<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$pedidoAjax = true;

// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../config/configGeral.php";
require_once "../views/plugins/fpdf/fpdf.php";
require_once "../controllers/PedidoController.php";
require_once "../controllers/EventoController.php";
require_once "../controllers/AtracaoController.php";

$id = $_GET['id'];

$eventoObj = new EventoController();
$pedidoObj = new PedidoController();
$atracaoObj = new AtracaoController();

$atracao = $atracaoObj->recuperaAtracao($id);
$idEvento = $atracao->evento_id;
$pedido = $pedidoObj->recuperaPedido(1,$idEvento);
$evento = $eventoObj->recuperaEvento($idEvento);

if ($pedido->passaporte){
    $documento = ", Passaporte: " . $pedido->passaporte;
} else{
    $documento = ", RG: " . $pedido->rg . ", CPF: " . $pedido->cpf;
}

class PDF extends FPDF
{
}

// GERANDO O PDF:
$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();


$x=20;
$l=8; //DEFINE A ALTURA DA LINHA

$pdf->SetXY( $x , 30 );// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

$pdf->SetTitle("Exclusividade PF");

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 12);
$pdf->Cell(180,5,utf8_decode('DECLARAÇÃO DE EXCLUSIVIDADE'),0,1,'C');

$pdf->Ln(10);

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(180,$l,utf8_decode("Eu, $pedido->nome $documento, sob penas da lei, sob as penas da Lei, que não sou servidor público municipal e que não me encontro em impedimento para contratar com a Prefeitura do Município de São Paulo / Secretaria Municipal de Cultura, mediante recebimento de cachê e/ou bilheteria, quando for o caso."));

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(180,$l,utf8_decode("Declaro, sob as penas da lei, dentre os integrantes abaixo listados não há crianças e adolescentes. Quando houver, estamos cientes que é de nossa responsabilidade a adoção das providências de obtenção  de  decisão judicial junto à Vara da Infância e Juventude."));

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(180,$l,utf8_decode("Declaro, ainda, neste ato, que autorizo, a título gratuito, por prazo indeterminado, a Municipalidade de São Paulo, através da SMC, o uso da nossa imagem, voz e performance nas suas publicações em papel e qualquer mídia digital, streaming ou internet existentes ou que venha a existir como também para os fins de arquivo e material de pesquisa e consulta."));

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(180,$l,utf8_decode("Fico autorizado a celebrar contrato, inclusive receber cachê e/ou bilheteria quando for o caso, outorgando quitação."));

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(180,$l,utf8_decode("Estou ciente de que o pagamento dos valores decorrentes dos serviços é de minha responsabilidade, não cabendo pleitear à Prefeitura quaisquer valores eventualmente não repassados."));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','', 10);
$pdf->MultiCell(180,$l,utf8_decode("Integrantes da atração $atracao->nome_atracao"));

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$integrantes = $atracaoObj->recuperaIntegrante($atracao->id);
$pdf->Cell(80, $l, utf8_decode("Nome"), 1, 0, 'L');
$pdf->Cell(30, $l, utf8_decode("RG"), 1, 0, 'L');
$pdf->Cell(30, $l, utf8_decode("CPF/Passaporte"), 1, 0, 'L');
$pdf->Cell(40, $l, utf8_decode("Função"), 1, 1, 'L');
foreach ($integrantes as $integrante) {
    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(80, $l, utf8_decode($integrante->nome), 1, 0, 'L');
    $pdf->Cell(30, $l, utf8_decode($integrante->rg), 1, 0, 'L');
    $pdf->Cell(30, $l, utf8_decode($integrante->cpf_passaporte), 1, 0, 'L');
    $pdf->Cell(40, $l, utf8_decode($integrante->funcao), 1, 1, 'L');
}

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(180, $l, utf8_decode("São Paulo, _______ / _______ / " . date('Y') . "."));

//RODAPÉ PERSONALIZADO
$pdf->SetXY($x, 262);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(100, 4, utf8_decode($pedido->nome), 'T', 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 10);

if ($pedido->passaporte != NULL) {
    $pdf->Cell(100, 4, "Passaporte: " . $pedido->passaporte, 0, 1, 'L');
} else {
    $rg = $pedido->rg == NULL ? "Não cadastrado" : $pedido->rg;
    $rg = "RG: " . $rg;
    $pdf->Cell(100, 4, utf8_decode($rg), 0, 1, 'L');
    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(100, 4, "CPF: " . $pedido->cpf, 0, 0, 'L');
}

$pdf->Output();