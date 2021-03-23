<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$pedidoAjax = true;
// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../config/configGeral.php";
require_once "../views/plugins/fpdf/fpdf.php";
require_once "../controllers/FormacaoController.php";
require_once "../controllers/PedidoController.php";

$formObj = new FormacaoController();

$pedido_id = $_GET['id'];

class PDF extends FPDF
{
    function Header()
    {
        // Move to the right

        // Logo
        $this->Cell(80);
        $this->Image('../views/dist/img/logo_smc.jpg', 170, 10);

        // Line break
        $this->Ln(20);
    }
}

$pedido = $formObj->recuperaPedido($pedido_id);
$contratacao = $formObj->recuperaContratacao($pedido->origem_id);
$pf = $formObj->recuperaPf($pedido->pessoa_fisica_id);
$telPf = $formObj->recuperaTelPf($pedido->pessoa_fisica_id);
$Observacao = "Todas as atividades dos programas da Supervisão de Formação são inteiramente gratuitas e é terminantemente proibido cobrar por elas sob pena de multa e rescisão de contrato.";
$penalidades = PedidoController::retornaPenalidades(20);
$dadosParcelas = $formObj->retornaDadosParcelas($pedido->origem_id);

$ano = date('Y');

$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();


$x = 20;
$l = 7; //DEFINE A ALTURA DA LINHA

$pdf->SetXY($x, 35);// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

$pdf->SetTitle("Proposta Vocacional");

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, 5, '(A)', 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(170, 5, 'CONTRATADO', 0, 1, 'C');

$pdf->Ln(5);


$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->MultiCell(200, $l, utf8_decode("(Quando se tratar de grupo, o líder do grupo)"), 0, 'L', 0);

$pdf->Ln(5);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(12, $l, 'Nome:', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(120, $l, utf8_decode($pf->nome), 0, 'L', 0);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(27, $l, utf8_decode("Nome Artístico:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(120, $l, utf8_decode(MainModel::checaCampo($pf->nome_artistico)), 0, 'L', 0);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
if ($pf->passaporte != NULL) {
    $pdf->Cell(21, $l, utf8_decode('Passaporte:'), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(50, $l, utf8_decode($pf->passaporte), 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', 10);

} else {
    $pdf->Cell(7, $l, utf8_decode('RG:'), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(50, $l, utf8_decode(MainModel::checaCampo($pf->rg)), 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(9, $l, utf8_decode('CPF:'), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(45, $l, utf8_decode($pf->cpf), 0, 0, 'L');
}

$pdf->Ln(7);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(36, $l, 'Data de Nascimento:', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30, $l, utf8_decode(MainModel::dataParaBR($pf->data_nascimento) == "00-00-0000" ? "Não cadastrado" : MainModel::dataParaBR($pf->data_nascimento)), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(26, $l, "Nacionalidade:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30, $l, utf8_decode(MainModel::checaCampo($pf->nacionalidade)), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, $l, "CCM:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30, $l, utf8_decode(MainModel::checaCampo($pf->ccm)), 0, 0, 'L');

$pdf->Ln(7);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, $l, 'DRT:', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(40, $l, utf8_decode(MainModel::checaCampo($pf->drt)), 0, 'L', 0);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(18, $l, utf8_decode("Endereço:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(160, $l, utf8_decode($pf->logradouro . ", " . $pf->numero . " " . $pf->complemento . " / - " . $pf->bairro . " - " . $pf->cidade . " / " . $pf->uf), 0, 'L', 0);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(21, $l, 'Telefone(s):', '0', '0', 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(168, $l, utf8_decode($telPf), 0, 'L', 0);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(11, $l, 'Email:', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(168, $l, utf8_decode($pf->email), 0, 'L', 0);

$pdf->SetX($x);
$pdf->Cell(180, 5, '', 'B', 1, 'C');

$pdf->Ln(5);

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, 10, '(B)', 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(160, 10, 'PROPOSTA', 0, 0, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, 10, utf8_decode($pedido->protocolo), 0, 1, 'R');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(13, $l, "Objeto:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(20, $l, utf8_decode($formObj->retornaObjetoFormacao($pedido->origem_id)), 0, 0, 'L');

$pdf->Ln(6);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(15, $l, utf8_decode('Período:'), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(180, $l, utf8_decode($formObj->retornaPeriodoFormacao($pedido->origem_id)), 0, 0, 'L');

$pdf->Ln(6);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(25, $l, utf8_decode("Carga Horária:"), '0', '0', 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(168, $l, utf8_decode($formObj->retornaCargaHoraria($pedido->origem_id) . " hora(s)"), 0, 0, 'L');

$pdf->Ln(7);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(16, $l, 'Local(s):', '0', '0', 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(165, $l, utf8_decode($formObj->retornaLocaisFormacao($pedido->origem_id)), 0, 'L', 0);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(11, $l, 'Valor:', '0', '0', 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(168, $l, utf8_decode("R$ " . MainModel::dinheiroParaBr($pedido->valor_total) . " ( " . MainModel::valorPorExtenso($pedido->valor_total) . ")"), 0, 'L', 0);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(38, $l, 'Forma de Pagamento:', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(122, $l, utf8_decode($pedido->forma_pagamento));

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(22, $l, 'Justificativa:', '0', '0', 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(155, $l, utf8_decode($pedido->cargo_justificativa));

//RODAPÉ PERSONALIZADO
$pdf->SetXY($x, 262);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(100, 4, utf8_decode($pf->nome), 'T', 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 10);
if ($pf->passaporte != NULL) {
    $pdf->Cell(100, 4, "Passaporte: " . $pf->passaporte, 0, 1, 'L');
} else {
    $rg = "RG: " . MainModel::checaCampo($pf->rg);
    $pdf->Cell(100, 4, utf8_decode($rg), 0, 1, 'L');
    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(100, 4, "CPF: " . $pf->cpf, 0, 1, 'L');
}

$pdf->AddPage('', '');

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, $l, '(C)', 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(160, $l, utf8_decode('OBSERVAÇÃO'), 0, 1, 'C');

$pdf->Ln(5);

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(155, $l, utf8_decode($Observacao), 0, 'J', 0);

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(0, 4, utf8_decode($penalidades), 0, 'J', 0);

$pdf->Ln(5);

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(180, $l, utf8_decode("Data: _________ / _________ / " . $ano) . ".", 0, 0, 'L');

$pdf->SetXY($x, 262);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(100, 4, utf8_decode($pf->nome), 'T', 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 10);
if ($pf->passaporte != NULL) {
    $pdf->Cell(100, 4, "Passaporte: " . $pf->passaporte, 0, 1, 'L');
} else {
    $pdf->Cell(100, 4, utf8_decode($rg), 0, 1, 'L');
    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(100, 4, "CPF: " . $pf->cpf, 0, 0, 'L');
}

$pdf->AddPage('', '');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(180, 5, "CRONOGRAMA", 0, 1, 'C');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(180, 5, utf8_decode($contratacao->programa), 0, 1, 'C');

$pdf->Ln(5);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(12, $l, 'Nome:', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(120, $l, utf8_decode($pf->nome), 0, 'L', 0);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(12, $l, 'Cargo:', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(100, $l, utf8_decode($contratacao->cargo), 0, 'L', 0);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(21, $l, 'Linguagem:', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(100, $l, utf8_decode($contratacao->linguagem), 0, 'L', 0);

$pdf->Ln(5);

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(160, $l, utf8_decode("O prestador de serviços acima citado é contratado nos termos do Edital " . $contratacao->edital
    . ", no período " . $formObj->retornaPeriodoFormacao($pedido->origem_id)
    . ", com carga horária total de até: " . $formObj->retornaCargaHoraria($pedido->origem_id)
    . " hora(s), na forma abaixo descrita:"), 0, 'L', 0);

$pdf->Ln(5);

for ($i = 0; $i < count($dadosParcelas); $i++):
    $inicio = MainModel::dataParaBR($dadosParcelas[$i]->data_inicio);
    $fim = MainModel::dataParaBR($dadosParcelas[$i]->data_fim);
    $horas = $dadosParcelas[$i]->carga_horaria;

    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(180, $l, utf8_decode("De $inicio a $fim - até $horas hora(s)"));
endfor;

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(180, $l, utf8_decode("São Paulo, ______ de ____________________ de " . $ano) . ".", 0, 0, 'L');

$pdf->SetXY($x, 262);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(100, 4, utf8_decode($pf->nome), 'T', 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 10);
if ($pf->passaporte != NULL) {
    $pdf->Cell(100, 4, "Passaporte: " . $pf->passaporte, 0, 1, 'L');
} else {
    $pdf->Cell(100, 4, utf8_decode($rg), 0, 1, 'L');
    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(100, 4, "CPF: " . $pf->cpf, 0, 0, 'L');
}

$pdf->Output('Proposta Formação', "I");
?>

