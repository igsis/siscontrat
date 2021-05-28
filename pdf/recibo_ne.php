<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$pedidoAjax = true;

// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../config/configGeral.php";
require_once "../views/plugins/fpdf/fpdf.php";
require_once "../controllers/PedidoController.php";
require_once "../controllers/EventoController.php";
require_once "../controllers/NotaEmpenhoController.php";

$id = $_GET['id'];

$eventoObj = new EventoController();
$pedidoObj = new PedidoController();
$neObj = new NotaEmpenhoController();

$pedido = $pedidoObj->recuperaPedido(1,$id);
$objeto = $eventoObj->recuperaObjetoEvento($id);
$ne = $neObj->recuperaNotaEmpenho($pedido->id);

class PDF extends FPDF
{
}

// GERANDO O PDF:
$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();

$x=20;
$l=6; //DEFINE A ALTURA DA LINHA   
   
$pdf->SetXY( $x , 30 );// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

$pdf->SetTitle("Recibo");

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 14);
$pdf->Cell(180,5,utf8_decode("RECIBO DE ENTREGA DE NOTA DE EMPENHO"),0,1,'C');

$pdf->Ln(20);

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(180,$l,utf8_decode("Recebi, da Secretaria Municipal de Cultura / Contratos Artísticos a:"));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(41,$l,utf8_decode('Nota de Empenho nº:'),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->Cell(128,$l,utf8_decode($ne->nota_empenho),0,1,'L');

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(24,$l,utf8_decode('Emitida em:'),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->Cell(60,$l,utf8_decode(date('d/m/Y', strtotime($ne->emissao_nota_empenho))),0,1,'L');

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(50,$l,utf8_decode('Referente ao processo nº:'),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->Cell(60,$l,utf8_decode($pedido->numero_processo),0,1,'L');

$pdf->Ln(10);

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(180,$l,utf8_decode("São Paulo, ".date('d/m/Y', strtotime($ne->entrega_nota_empenho))."."));

$pdf->Ln(10);

if ($pedido->pessoa_tipo_id == 2) {
    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(170, $l, utf8_decode('Razão Social'), 0, 1, 'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(170, $l, utf8_decode($pedido->razao_social), 0, 1, 'L');

    $pdf->Ln(10);

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(170, $l, utf8_decode('REPRESENTANTES LEGAIS'), 0, 1, 'L');

    $pdf->Ln(40);

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(165, $l, utf8_decode($pedido->rep1['nome']), 'T', 1, 'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(8, $l, utf8_decode('RG:'), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(50, $l, utf8_decode($pedido->rep1['rg']), 0, 1, 'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(11, $l, utf8_decode('CPF:'), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(50, $l, utf8_decode($pedido->rep1['cpf']), 0, 1, 'L');

    $pdf->Ln(40);

    if($pedido->rep2['nome'] != NULL) {
        $pdf->SetX($x);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(165, $l, utf8_decode($pedido->rep2['nome']), 'T', 1, 'L');

        $pdf->SetX($x);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(8, $l, utf8_decode('RG:'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(50, $l, utf8_decode($pedido->rep2['rg']), 0, 1, 'L');

        $pdf->SetX($x);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(11, $l, utf8_decode('CPF:'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(50, $l, utf8_decode($pedido->rep2['cpf']), 0, 1, 'L');
    }
} else{
    $pdf->Ln(10);

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(165,$l,utf8_decode($pedido->nome),'T',1,'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(8,$l,utf8_decode('RG:'),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(50,$l,utf8_decode($pedido->rg),0,1,'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(11,$l,utf8_decode('CPF:'),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(50,$l,utf8_decode($pedido->cpf),0,1,'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(15,$l,utf8_decode('E-mail:'),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(60,$l,utf8_decode($pedido->email),0,1,'L');
}
$pdf->Ln(10);

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(16,$l,'Objeto:',0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(170,$l,utf8_decode($objeto));
   
$pdf->Output();