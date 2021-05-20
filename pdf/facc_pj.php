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

$id_pj =  $_GET['id'];

$pj = $pjObj->recuperaPessoaJuridica($id_pj);
$rep = $repObj->recuperaRepresentante($pj->representante_legal1_id);

$data = date('d-m-Y');

class PDF extends FPDF{
    function Header()
    {
        // grade de fundo
        $this->Image('../views/dist/img/facc_pj.jpg', 15, 10, 180);
        $this->Ln(20);
    }
}

// GERANDO O PDF:
$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();

$x = 20;
$l = 7; //DEFINE A ALTURA DA LINHA

$pdf->SetXY($x, 40);// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

$pdf->SetTitle("FACC PJ");

$pdf->SetXY(112, 43);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, $l, utf8_decode('X'), 0, 0, 'L');

$pdf->SetXY($x, 45);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(53, $l, utf8_decode($pj->cnpj), 0, 0, 'L');

$pdf->SetXY(150, 43);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(53, $l, utf8_decode($pj->ccm), 0, 0, 'L');

$pdf->SetXY($x, 60);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(160, $l, utf8_decode($pj->razao_social), 0, 0, 'L');

$pdf->SetXY($x, 75);
$pdf->SetFont('Arial', '', 10);

if ($pj->complemento != null) {
    $pdf->Cell(160, $l, utf8_decode($pj->logradouro . ", " . $pj->numero . " - " . $pj->complemento), 0, 0, 'L');
} elseif ($pj->logradouro != NULL && $pj->complemento == NULL) {
    $pdf->Cell(160, $l, utf8_decode($pj->logradouro . ", " . $pj->numero), 0, 0, 'L');
}

$pdf->SetXY($x, 90);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(65, $l, utf8_decode($pj->bairro), 0, 0, 'L');
$pdf->Cell(83, $l, utf8_decode($pj->cidade), 0, 0, 'L');
$pdf->Cell(5, $l, utf8_decode($pj->uf), 0, 0, 'L');

$pdf->SetXY($x, 105);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(33, $l, utf8_decode($pj->cep), 0, 0, 'L');
$pdf->Cell(45, $l, utf8_decode($pj->telefones['tel_0']), 0, 0, 'L');

$pdf->SetXY(98, 107);
$pdf->Cell(15, $l, utf8_decode($pj->codigo), 0, 0, 'L');
$pdf->Cell(40, $l, utf8_decode($pj->agencia), 0, 0, 'L');
$pdf->Cell(37, $l, utf8_decode($pj->conta), 0, 0, 'L');

$pdf->SetXY($x, 127);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(80, $l, utf8_decode($rep->nome), 0, 0, 'L');
$pdf->Cell(50, $l, utf8_decode($rep->rg), 0, 0, 'L');

$pdf->Output();