<?php
require_once "../../controllers/AtracaoController.php";
$atracaoObj = new AtracaoController();
$atracoes = $atracaoObj->recuperaAtracao($idEvento);

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 12);
$pdf->Cell(180, $l, utf8_decode("ATRAÇÕES"), 'B', 1, 'C');

$pdf->Ln();

foreach ($atracoes as $atracao) {

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(26, 6, utf8_decode("ATRAÇÃO: " . $atracao->nome_atracao), 0, 1, 'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(11, $l, utf8_decode("Ação:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(115, $l, utf8_decode($atracao->acoes), 0, 1, 'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(23, $l, utf8_decode("Integrantes:"), 0, 1, 'L');
    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $integrantes = $atracaoObj->recuperaIntegrante($atracao->id);
    $pdf->Cell(80, $l, utf8_decode("Nome"), 1, 0, 'L');
    $pdf->Cell(30, $l, utf8_decode("RG"), 1, 0, 'L');
    $pdf->Cell(30, $l, utf8_decode("CPF/Passaporte"), 1, 0, 'L');
    $pdf->Cell(40, $l, utf8_decode("Função"), 1, 1, 'L');
    foreach ($integrantes as $integrante) {
        $pdf->SetX($x);
        $pdf->SetFont('Arial', '', $f);
        $pdf->Cell(80, $l, utf8_decode($integrante->nome), 1, 0, 'L');
        $pdf->Cell(30, $l, utf8_decode($integrante->rg), 1, 0, 'L');
        $pdf->Cell(30, $l, utf8_decode($integrante->cpf_passaporte), 1, 0, 'L');
        $pdf->Cell(40, $l, utf8_decode($integrante->funcao), 1, 1, 'L');
    }

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(42, $l, utf8_decode("Classificação indicativa:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(25, $l, utf8_decode($atracao->classificacao_indicativa), 0, 1, 'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(18, $l, utf8_decode("Release:"), 0, 1, 'L');
    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', $f);
    $pdf->MultiCell(180, $l, utf8_decode($atracao->release_comunicacao));

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(13, $l, utf8_decode("Links:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->MultiCell(163, $l, utf8_decode($atracao->links));

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(51, $l, utf8_decode("Quantidede de apresentação:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(25, $l, utf8_decode($atracao->quantidade_apresentacao), 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(29, $l, utf8_decode("Valor individual:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(15, $l, utf8_decode("R$ " . $eventoObj->dinheiroBr($atracao->valor_individual)), 0, 1, 'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(18, $l, utf8_decode("Produtor:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(15, $l, utf8_decode($atracao->nome), 0, 1, 'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(13, $l, utf8_decode("E-mail:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(75, $l, utf8_decode($atracao->email), 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(19, $l, utf8_decode("Telefones:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(15, $l, utf8_decode($atracao->telefone1 . " | " . $atracao->telefone2), 0, 1, 'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(24, $l, utf8_decode("Observação:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->MultiCell(146, $l, utf8_decode($atracao->observacao));

    $pdf->Ln();
}
$pdf->Ln(10);