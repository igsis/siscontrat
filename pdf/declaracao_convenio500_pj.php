<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$pedidoAjax = true;
// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../config/configGeral.php";
require_once "../views/plugins/fpdf/fpdf.php";
require_once "../controllers/PessoaJuridicaController.php";
require_once "../controllers/RepresentanteController.php";
$pjObj = new PessoaJuridicaController();
$repObj = new RepresentanteController();

$id =  $_GET['id'];

$pj = $pjObj->recuperaPessoaJuridica($id);
$representante = $repObj->recuperaRepresentante($pj->representante_legal1_id);

$ano = date('Y');

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

$pdf->SetTitle("Convênio 500 PJ", true);

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 12);
$pdf->Cell(180,5,utf8_decode('DECLARAÇÃO DE CONDIÇÕES PARA PAGAMENTO'),0,1,'C');

$pdf->Ln(20);

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(167,$l,utf8_decode("Eu, ".$representante->nome .", RG ".$representante->rg.", CPF ".$representante->cpf.", representante da empresa ".$pj->razao_social.", inscrita no CNPJ ".$pj->cnpj.", declaro para os devidos fins que a empresa não possui conta no Banco do Brasil."));

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(167,$l,utf8_decode("Por se tratar de uma contratação de natureza eventual e não continuada e o cachê não exceder R$ 5.000,00 (cinco mil reais), solicito que o pagamento seja efetuado na conta informada na FACC, através de recursos 500, conforme art. 3º da portaria SF 255/15."));

$pdf->Ln(15);

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->Cell(180,$l,utf8_decode("São Paulo, _________ de ________________________________ de "."$ano"."."),0,0,'L');

$pdf->SetXY($x,262);
$pdf->SetFont('Arial','', 10);
$pdf->Cell(100,4,utf8_decode($representante->nome),'T',1,'L');

$pdf->SetX($x);
$pdf->SetFont('Arial','', 10);
$pdf->Cell(100,4,"RG: ".$representante->rg,0,1,'L');

$pdf->SetX($x);
$pdf->SetFont('Arial','', 10);
$pdf->Cell(100,4,"CPF: ".$representante->cpf,0,0,'L');

$pdf->Output();