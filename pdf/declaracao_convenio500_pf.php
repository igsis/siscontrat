<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$pedidoAjax = true;
// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../config/configGeral.php";
require_once "../views/plugins/fpdf/fpdf.php";
require_once "../controllers/PessoaFisicaController.php";
$pfObj = new PessoaFisicaController();

$id =  $_GET['id'];

$pf = $pfObj->recuperaPessoaFisica($id);
$proponente = $pf->nome;
if ($pf->passaporte){
    $documento = ", Passaporte: " . $pf->passaporte;
    $tipo_documento = "do Passaporte original";
} else{
    $documento = ", RG: " . $pf->rg . ", CPF: " . $pf->cpf;
    $tipo_documento = "de RG e CPF originais";
}

$ano = date('Y');

class PDF extends FPDF{}

// GERANDO O PDF:
$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();

$x=20;
$l=8; //DEFINE A ALTURA DA LINHA

$pdf->SetXY( $x , 30 );// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

$pdf->SetTitle("Convênio 500 PF", true);

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 12);
$pdf->Cell(180,5,utf8_decode('DECLARAÇÃO DE CONDIÇÕES PARA PAGAMENTO'),0,1,'C');

$pdf->Ln(20);

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(167,$l,utf8_decode("Eu, ". $proponente . $documento .", declaro para os devidos fins que não possuo conta no Banco do Brasil."));

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(167,$l,utf8_decode("Por se tratar de uma contratação de natureza eventual e não continuada e o cachê não exceder R$ 5.000,00 (cinco mil reais), solicito que o pagamento seja efetuado através de Ordem de Pagamento ou Ordem Bancária/Contra Recibo, através de recursos 500, conforme art. 2º da portaria SF 255/15."));

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(167,$l,utf8_decode("Estou ciente que o pagamento pode ser retirado no guichê do caixa, em qualquer agência do Bando do Brasil S.A, mediante a apresentação " . $tipo_documento . ", ficando disponível pelo período de 30 dias após a realização do crédito."));

$pdf->Ln(15);

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->Cell(180,$l,utf8_decode("São Paulo, _________ de ________________________________ de $ano."),0,0,'L');

$pdf->SetXY($x,262);
$pdf->SetFont('Arial','', 10);
$pdf->Cell(100,4,utf8_decode($proponente),'T',1,'L');

$pdf->SetX($x);
$pdf->SetFont('Arial','', 10);

if($pf->passaporte != NULL){
    $pdf->Cell(100, 4, "Passaporte: " . $pf->passaporte, 0, 1, 'L');
}else{
    $pdf->Cell(100, 4, utf8_decode("RG: ".$pf->rg), 0, 1, 'L');
    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(100, 4, "CPF: " . $pf->cpf, 0, 0, 'L');
}

$pdf->Output();