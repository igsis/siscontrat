<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$pedidoAjax = true;
// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../config/configGeral.php";
require_once "../views/plugins/fpdf/fpdf.php";
require_once "../controllers/PessoaFisicaController.php";
require_once "../controllers/FormacaoController.php";
$pfObj = new PessoaFisicaController();
$formObj = new FormacaoController();

$id_pf =  $_GET['id'];

class PDF extends FPDF{
    function Header()
    {
        // Logo
        $this->Image('../views/dist/img/fac_pf.jpg', 15, 10, 180);

        // Line break
        $this->Ln(20);
    }
}

$pf = $pfObj->recuperaPessoaFisica($id_pf);


$data = date('d-m-Y');

$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();


$x = 20;
$l = 7; //DEFINE A ALTURA DA LINHA

$pdf->SetXY($x, 40);// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

$pdf->SetTitle('Imprimir Facc');

$pdf->SetXY(113, 40);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, $l, utf8_decode('X'), 0, 0, 'L');

$pdf->SetXY($x, 40);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(53, $l, utf8_decode($pf['cpf']), 0, 0, 'L');

$pdf->SetXY(155, 40);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(53, $l, utf8_decode($pf['ccm'] == NULL ? "Não cadastrado" : $pf['ccm']), 0, 0, 'L');

$pdf->SetXY($x, 55);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(160, $l, utf8_decode($pf['nome']), 0, 0, 'L');

$pdf->SetXY($x, 68);
$pdf->SetFont('Arial', '', 10);

if ($pf['complemento'] != null) {
    $pdf->Cell(160, $l, utf8_decode($pf['logradouro'] . ", " . $pf['numero'] . " - " . $pf['complemento']), 0, 0, 'L');
} elseif ($pf['logradouro'] != NULL && $pf['complemento'] == NULL) {
    $pdf->Cell(160, $l, utf8_decode($pf['logradouro'] . ", " . $pf['numero']), 0, 0, 'L');
}

$pdf->SetXY($x, 82);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(68, $l, utf8_decode($pf['bairro']), 0, 0, 'L');
$pdf->Cell(88, $l, utf8_decode($pf['cidade']), 0, 0, 'L');
$pdf->Cell(5, $l, utf8_decode($pf['uf']), 0, 0, 'L');

$pdf->SetXY($x, 96);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(33, $l, utf8_decode($pf['cep']), 0, 0, 'L');
$pdf->Cell(57, $l, utf8_decode($pf['cep']), 0, 0, 'L');
$pdf->Cell(15, $l, utf8_decode($pf['codigo']), 0, 0, 'L');
$pdf->Cell(35, $l, utf8_decode($pf['agencia']), 0, 0, 'L');
$pdf->Cell(37, $l, utf8_decode($pf['conta']), 0, 0, 'L');

$pdf->SetXY($x, 107);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(87, $l, utf8_decode($pf['nit']), 0, 0, 'L');
$pdf->Cell(52, $l, utf8_decode(MainModel::dataParaBr($pf['data_nascimento'])), 0, 0, 'L');
$pdf->Cell(33, $l, utf8_decode(""), 0, 0, 'L');

$pdf->SetXY($x, 122);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(87, $l, utf8_decode($pf['nome']), 0, 0, 'L');
$pdf->Cell(50, $l, utf8_decode($pf['rg']), 0, 0, 'L');


$pdf->Output('facc_pf.pdf', 'I');
?>