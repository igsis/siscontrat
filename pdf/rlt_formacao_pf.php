<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$pedidoAjax = true;
// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../config/configGeral.php";
require_once "../views/plugins/fpdf/fpdf.php";
require_once "../controllers/PessoaFisicaController.php";
require_once "../controllers/FormacaoController.php";
$pfObj = new PessoaFisicaController();
$enderecoObj = new FormacaoController();

$id_pf =  $_GET['id'];

class PDF extends FPDF{
}

$pf = $pfObj->recuperaPessoaFisica($id_pf);
$endereco = $enderecoObj->recuperaEnderecoPf($id_pf);

if ($pf['passaporte'] == "") {
    $documento = $pf['rg'];
    $cpf = $pf['cpf'];
} else {
    $documento = $pf['passaporte'];
}

$data = date('d-m-Y');

$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();


$x = 20;
$l = 7; //DEFINE A ALTURA DA LINHA

$pdf->SetXY($x, 35);// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

$pdf->SetTitle('Imprimir Resumo');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(180, 15, utf8_decode("REGISTRO DE PESSOA FÍSICA"), 0, 1, 'C');

$pdf->Ln(5);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40, $l, utf8_decode("Nome:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(168, $l, utf8_decode($pf['nome']), 0, 'L', 0);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(28, $l, utf8_decode('RG/Passaporte:'), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(50, $l, utf8_decode($documento == NULL ? "Não cadastrado" : $documento), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, $l, utf8_decode('CPF:'), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, $l, utf8_decode($pf['cpf'] == NULL ? "Não cadastrado" : $pf['cpf']), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, $l, utf8_decode('CCM:'), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(45, $l, utf8_decode($pf['ccm'] == NULL ? "Não cadastrado" : $pf['ccm']), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(36, $l, utf8_decode('Data de Nascimento:'), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(25, $l, MainModel::dataParaBr($pf['data_nascimento']), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(19, $l, utf8_decode('Endereço:'), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(180, $l, utf8_decode($endereco));

$pdf->Output('rlt_formacao_pf.pdf', 'I');
?>