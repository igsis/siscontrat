<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$pedidoAjax = true;
// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../config/configGeral.php";
require_once "../views/plugins/fpdf/fpdf.php";
require_once "../controllers/FormacaoNotaEmpenhoController.php";
require_once "../controllers/FormacaoPedidoController.php";
require_once "../controllers/FormacaoController.php";
require_once "../controllers/PessoaFisicaController.php";

$formObj = new FormacaoNotaEmpenhoController();

$pedido_id = $_GET['id'];

class PDF extends FPDF
{
}

$ne = $formObj->recuperar($pedido_id);
$pedido = (new FormacaoPedidoController)->recuperar($pedido_id);
$pf = (new PessoaFisicaController)->recuperaPessoaFisica($pedido->pessoa_fisica_id);

$nome = $pf->nome_social != null ? "$pf->nome_social ($pf->nome)" : $pf->nome;

$data = date('d-m-Y');

$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();


$x = 20;
$l = 7; //DEFINE A ALTURA DA LINHA

$pdf->SetXY($x, 30);// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

$pdf->SetTitle('Nota de Empenho');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(180, 15, utf8_decode("RECIBO DE ENTREGA DE NOTA DE EMPENHO"), 0, 1, 'C');

$pdf->Ln(15);

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(160, $l, utf8_decode("Recebi, da Secretaria Municipal de Cultura - Contratos Artísticos a:"), 0, 'L', 0);

$pdf->Ln(5);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40, $l, utf8_decode("Nota de Empenho nº:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(120, $l, utf8_decode($ne->nota_empenho), 0, 'L', 0);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(23, $l, utf8_decode("Emitida em:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(120, $l, utf8_decode(MainModel::dataParaBR($ne->emissao_nota_empenho)), 0, 'L', 0);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(49, $l, utf8_decode("Referente ao processo nº:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(55, $l, utf8_decode($pedido->numero_processo), 0, 'L', 0);

$pdf->Ln(9);

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(40, $l, utf8_decode("São Paulo, " . MainModel::dataParaBR($ne->entrega_nota_empenho)));

$pdf->Ln(75);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(170, $l, utf8_decode($nome), 'T', 0, 'L');

$pdf->Ln();

$pdf->SetX($x);

if ($pf->passaporte != NULL) {
    $pdf->Cell(23, $l, utf8_decode("Passaporte:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(40, $l, utf8_decode($pf->passaporte), 0, 0, 'L');

    $pdf->Ln();
} else {
    $pdf->SetX($x);
    $pdf->Cell(8, $l, utf8_decode("RG:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(40, $l, utf8_decode(MainModel::checaCampo($pf->rg)), 0, 0, 'L');

    $pdf->Ln();

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(10, $l, utf8_decode("CPF:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(40, $l, utf8_decode($pf->cpf), 0, 0, 'L');

    $pdf->Ln();
}

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(14, $l, utf8_decode("E-mail:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(40, $l, utf8_decode($pf->email), 0, 0, 'L');

$pdf->Ln(7);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(15, $l, "Objeto:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(155, $l, utf8_decode((new FormacaoController)->retornarObjeto($pedido->origem_id)));

$pdf->Output('formacao_ne.pdf', 'I');
?>

