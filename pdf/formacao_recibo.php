<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$pedidoAjax = true;
// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../config/configGeral.php";
require_once "../views/plugins/fpdf/fpdf.php";
require_once "../controllers/FormacaoController.php";
require_once "../controllers/PessoaFisicaController.php";
require_once "../controllers/FormacaoPedidoController.php";

$formObj = new FormacaoController();

$parcela_id = $_GET['parcela'];
$pedido_id = $_GET['id'];

class PDF extends FPDF
{
}

$pedido = (new FormacaoPedidoController)->recuperar($pedido_id);
$pf = (new PessoaFisicaController)->recuperaPessoaFisica($pedido->pessoa_fisica_id);
$telPf = "";
foreach ($pf->telefones as $key => $telefone) {
    if ($key !== "tel_0"){
        $telPf .= " / ";
    }
    $telPf .= "{$telefone}";
}
$parcelaDados = $formObj->recuperaDadosParcelas($pedido->origem_id, 1, $parcela_id);

$nome = $pf->nome_social != null ? "$pf->nome_social ($pf->nome)" : $pf->nome;

$ano = date('Y', strtotime("now"));

$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();

$x = 20;
$l = 7; //DEFINE A ALTURA DA LINHA

$pdf->SetXY($x, 35);// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

$pdf->SetTitle('Recibo');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(180, 15, utf8_decode("RECIBO"), 0, 1, 'C');

$pdf->Ln(5);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(14, $l, 'Nome:', 0, 0, 'L');
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(166, $l, utf8_decode($nome), 0, 'L', 0);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(14, $l, utf8_decode("Objeto:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(166, $l, utf8_decode((new FormacaoController)->retornarObjeto($pedido->origem_id)));

$pdf->Ln(6);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(14, $l, 'C.C.M.:', 0, 0, 'L');
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(40, $l, utf8_decode(MainModel::checaCampo($pf->ccm)), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 11);
if ($pf->passaporte != NULL) {
    $pdf->Cell(23, $l, utf8_decode('Passaporte:'), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(50, $l, utf8_decode($pf->passaporte), 0, 0, 'L');
} else {
    $pdf->Cell(8, $l, utf8_decode('RG:'), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(50, $l, utf8_decode(MainModel::checaCampo($pf->rg)), 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(9, $l, utf8_decode('CPF:'), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(45, $l, utf8_decode($pf->cpf), 0, 0, 'L');
}

$pdf->Ln(7);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(20, $l, utf8_decode("Endereço:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(160, $l, utf8_decode($pf->logradouro . ", " . $pf->numero . " " . $pf->complemento . " / - " . $pf->bairro . " - " . $pf->cidade . " / " . $pf->uf));

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(23, $l, 'Telefone(s):', '0', '0', 'L');
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(95, $l, utf8_decode($telPf), 0, 'L', 0);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(13, $l, 'Email:', 0, 0, 'L');
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(168, $l, utf8_decode($pf->email), 0, 'L', 0);

$pdf->Ln(16);

$pdf->SetX($x);
$pdf->MultiCell(170, $l, utf8_decode("Atesto que recebi da Prefeitura do Múnicípio de São Paulo - Secretaria Municipal de Cultura a importância de R$ " . MainModel::dinheiroParaBr($parcelaDados->valor) . " ( " . MainModel::valorPorExtenso($parcelaDados->valor) . ")  referente ao período " . $formObj->retornaPeriodoFormacao($pedido->origem_id, '1', $parcela_id) . " da " . (new FormacaoController)->retornarObjeto($pedido->origem_id)), 0, 'L', 0);

$pdf->Ln(16);

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(180, $l, utf8_decode("São Paulo, _______ de ________________________ de " . $ano . "."));

$pdf->Ln(16);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 11);
$pdf->MultiCell(180, $l, utf8_decode("OBSERVAÇÃO: A validade deste recibo está condicionada ao respectivo depósito do pagamento na conta corrente indicada pelo Artista."));

$pdf->SetXY($x, 262);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(100, $l, utf8_decode($nome), 'T', 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 12);
if ($pf->passaporte != NULL) {
    $pdf->Cell(100, 4, "Passaporte: " . $pf->passaporte, 0, 1, 'L');
} else {
    $pdf->SetX($x);
    $rg = "RG: " . MainModel::checaCampo($pf->rg);
    $pdf->Cell(100, 4, utf8_decode($rg), 0, 1, 'L');
}

$pdf->Output('formacao_recibo.pdf', 'I');
?>