<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$pedidoAjax = true;

// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../config/configGeral.php";
require_once "../views/plugins/fpdf/fpdf.php";
require_once "../controllers/PedidoController.php";
require_once "../controllers/EventoController.php";
require_once "../controllers/AtracaoController.php";

class PDF extends FPDF
{
}

$idEvento = $_GET['id'];

$pedidoObj = new PedidoController();
$pedido = $pedidoObj->recuperaPedido(1, $idEvento);
$representante1 = $pedido->rep1;
if (isset($pedido->rep2)) {
    $representante2 = $pedido->rep2;
}

// GERANDO O PDF:
$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();


$x = 20;
$l = 6; //DEFINE A ALTURA DA LINHA

$pdf->SetXY($x, 15);// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

$pdf->SetTitle("Declaração Simples", true);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(180, 5, utf8_decode("DECLARAÇÃO SIMPLES"), 0, 1, 'C');

$pdf->Ln();
$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(170, $l, utf8_decode("Senhor (a)"));

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(170, $l, utf8_decode("Secretario (a) Municipal de Cultura"));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(170, $l, utf8_decode($pedido->razao_social . ", com sede à " . $pedido->logradouro . ", " . $pedido->numero . " " . $pedido->complemento . " " . $pedido->bairro . " - " . $pedido->cidade . " - " . $pedido->uf . " CEP: " . $pedido->cep . ", inscrita no CNPJ sob o nº " . $pedido->cnpj . " DECLARA à Prefeitura de São Paulo, para fins de não incidência na fonte do Imposto sobre a Renda da Pessoa Jurídica (IRPJ), da Contribuição Social sobre o Lucro Líquido (CSLL), da Contribuição para o Financiamento da Seguridade Social (Cofins), e da Contribuição para o PIS/Pasep, a que se refere o art. 64 da Lei nº 9.430, de 27 de dezembro de 1996, que é regularmente inscrita no Regime Especial Unificado de Arrecadação de Tributos e Contribuições devidos pelas Microempresas e Empresas de Pequeno Porte - Simples Nacional, de que trata o art. 12 da Lei Complementar nº 123, de 14 de dezembro de 2006."));

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(170, $l, utf8_decode("Para esse efeito, a declarante informa que:"));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(170, $l, utf8_decode("I - preenche os seguintes requisitos:"));


$pdf->SetX($x);
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(170, $l, utf8_decode("(a) conserva em boa ordem, pelo prazo de cinco anos, contado da data da emissão, os documentos que comprovam a origem de suas receitas e a efetivação de suas despesas, bem assim a realização de quaisquer outros atos ou operações que venham a modificar sua situação patrimonial;"));


$pdf->SetX($x);
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(170, $l, utf8_decode("(b) cumpre as obrigações acessórias a que está sujeita, em conformidade com a legislação pertinente;"));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(170, $l, utf8_decode("II - o signatário é representante legal desta empresa, assumindo o compromisso de informar à Secretaria da Receita Federal do Brasil e à entidade pagadora, imediatamente, eventual desenquadramento da presente situação e está ciente de que a falsidade na prestação destas informações, sem prejuízo do disposto no art. 32 da Lei nº 9.430, de 1996, o sujeitará, juntamente com as demais pessoas que para ela concorrem, às penalidades previstas na legislação criminal e tributária, relativas à falsidade ideológica (art. 299 do Código Penal) e ao crime contra a ordem tributária (art. 1º da Lei nº 8.137, de 27 de dezembro de 1990)."));

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(128, $l, utf8_decode("São Paulo, _______ / _______ / " . date('Y') . "."), 0, 1, 'L');

//RODAPÉ PERSONALIZADO
$pdf->SetXY($x, 262);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(85, $l, utf8_decode($representante1['nome']), 'T', 0, 'L');
if (isset($representante2)) {
    $pdf->Cell(85, $l, utf8_decode($representante2['nome']), 'T', 1, 'L');
}

$pdf->Output();