<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$pedidoAjax = true;
// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../config/configGeral.php";
require_once "../views/plugins/fpdf/fpdf.php";
require_once "../controllers/FormacaoController.php";
require_once "../controllers/PessoaFisicaController.php";

$formacaoObj = new FormacaoController();
$pfObjeto = new PessoaFisicaController();

$id = $_GET['id'];
$inscrito = $formacaoObj->recuperaInscrito($id);
$telefones = $formacaoObj->recuperaTelInscrito($inscrito->pessoa_fisica_id);

class PDF extends FPDF
{
    function Header()
    {
        // Logo
        $this->Cell(80);
        $this->Image('../views/dist/img/logo_cultura.jpg', 20, 10);
        // Line break
        $this->Ln(20);
    }
}

// GERANDO O PDF:
$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();

$pdf->AddPage();

$x = 20;
$l = 7; //DEFINE A ALTURA DA LINHA
$f = 11; //tamanho da fonte

$pdf->SetXY($x, 25);// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(120, $l, utf8_decode(""), '0', 0, 'L');
$pdf->Cell(50, $l, utf8_decode("Protocolo"), 'TLR', 1, 'C');

$pdf->SetX($x);
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(120, $l, utf8_decode(""), '0', 0, 'L');
$pdf->Cell(50, $l, utf8_decode($inscrito->protocolo), 'BLR', 1, 'C');

$pdf->Ln(10);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 14);
$pdf->MultiCell(170, $l, utf8_decode("Dados Pessoais"), "B", 'C');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(14, $l, utf8_decode("Nome:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($inscrito->nome), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(29, $l, utf8_decode("Nome artístico:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($inscrito->nome_artistico), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(8, $l, utf8_decode("RG:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(50, $l, utf8_decode($inscrito->rg), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(10, $l, utf8_decode("CPF:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(50, $l, utf8_decode($inscrito->cpf), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(10, $l, utf8_decode("CCM:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($inscrito->ccm), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(39, $l, utf8_decode("Data de nascimento:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(55, $l, date("d/m/Y", strtotime($inscrito->data_nascimento)), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(29, $l, utf8_decode("Nacionalidade:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($inscrito->nacionalidade), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(14, $l, utf8_decode("E-mail:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($inscrito->email), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(21, $l, utf8_decode("Telefones:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($telefones), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(9, $l, utf8_decode("NIT:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(50, $l, utf8_decode($inscrito->nit), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(11, $l, utf8_decode("DRT:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($inscrito->drt), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(36, $l, utf8_decode("Grau de instrução:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($inscrito->grau_instrucao), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(12, $l, utf8_decode("Etnia:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(35, $l, utf8_decode($inscrito->etnia), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(16, $l, utf8_decode("Gênero:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(50, $l, utf8_decode($inscrito->genero), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(13, $l, utf8_decode("Trans:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($inscrito->trans), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(11, $l, utf8_decode("PCD:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($inscrito->pcd), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(21, $l, utf8_decode("Endereço:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->MultiCell(150, $l, utf8_decode($inscrito->logradouro . ", " . $inscrito->numero . " " . $inscrito->complemento . " " . $inscrito->bairro . " - " . $inscrito->cidade . "-" . $inscrito->uf . " CEP: " . $inscrito->cep));

if ($inscrito->banco) {
    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(14, $l, utf8_decode("Banco:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(20, $l, utf8_decode($inscrito->banco), 0, 1, 'L');
    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(17, $l, utf8_decode("Agência:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(20, $l, utf8_decode($inscrito->agencia), 0, 1, 'L');
    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(13, $l, utf8_decode("Conta:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(20, $l, utf8_decode($inscrito->conta), 0, 1, 'L');
}

$pdf->Ln(10);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 14);
$pdf->MultiCell(170, $l, utf8_decode("Dados Complementares"), "B", 'C');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(55, $l, utf8_decode("Ano de execução do serviço:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($inscrito->ano), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(38, $l, utf8_decode("Região preferencial:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($inscrito->regiao), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(20, $l, utf8_decode("Programa:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($formacaoObj->recuperaPrograma($formacaoObj->encryption($inscrito->programa_id))->programa), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(23, $l, utf8_decode("Linguagem:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($formacaoObj->recuperaLinguagem($formacaoObj->encryption($inscrito->linguagem_id))->linguagem), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(36, $l, utf8_decode("Função (1º opção):"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($formacaoObj->recuperaCargo($formacaoObj->encryption($inscrito->form_cargo_id))->cargo), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(36, $l, utf8_decode("Função (2º opção):"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($formacaoObj->recuperaCargo($formacaoObj->encryption($inscrito->form_cargo2_id))->cargo ?? "não cadastrado"), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(36, $l, utf8_decode("Função (3º opção):"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($formacaoObj->recuperaCargo($formacaoObj->encryption($inscrito->form_cargo3_id))->cargo ?? "não cadastrado"), 0, 1, 'L');

$pdf->Ln(20);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(170, $l, utf8_decode("Cadastro enviado em:"), 0, 1, 'C');

$pdf->SetX($x);
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(170, $l, date("d/m/Y H:i:s", strtotime($inscrito->data_envio)), 0, 1, 'C');

$pdf->Output();