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
    // Page header
    function Header()
    {
        // Logo
        $this->Image('../views/dist/img/logo_smc.jpg', 30, 10);
        $this->Ln(20);
    }
}

$pf = $pfObj->recuperaPessoaFisica($id_pf);

if ($pf->passaporte == "") {
    $documento = $pf->rg;
    $cpf = $pf->cpf;
} else {
    $documento = $pf->passaporte;
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
$pdf->Cell(13, $l, utf8_decode("Nome:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(167, $l, utf8_decode($pf->nome_exibicao), 0, 'L', 0);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(30, $l, utf8_decode("Nome artístico:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(150, $l, utf8_decode($pf->nome_artistico), 0, 'L', 0);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
if ($pf->passaporte != NULL) {
    $pdf->Cell(21, $l, utf8_decode('Passaporte:'), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(50, $l, utf8_decode($pf->passaporte), 0, 1, 'L');

} else {
    $pdf->Cell(7, $l, utf8_decode('RG:'), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(50, $l, utf8_decode($pf->rg ?? "Não cadastrado"), 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(9, $l, utf8_decode('CPF:'), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(45, $l, utf8_decode($pf->cpf), 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(10, $l, utf8_decode('CCM:'), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(45, $l, utf8_decode($pf->ccm == NULL ? "Não cadastrado" : $pf->ccm), 0, 1, 'L');
}

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(36, $l, utf8_decode('Data de Nascimento:'), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(50, $l, (new MainModel)->validaData($pf->data_nascimento), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(26, $l, utf8_decode('Nacionalidade:'), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(25, $l, utf8_decode($pf->nacionalidade), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(13, $l, utf8_decode('E-mail:'), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(53, $l, utf8_decode($pf->email == NULL ? "Não Cadastrado" : $pf->email), 0, 1, 'L');

if ($pf->telefones){
    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(21, $l, 'Telefone(s):', '0', '0', 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(168, $l, utf8_decode($pf->telefones['tel_0'] ?? null . " " .$pf->telefones['tel_1'] ?? null. " ".$pf->telefones['tel_2'] ?? null), 0, 'L', 0);
}

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(19, $l, utf8_decode('Endereço:'), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(180, $l, utf8_decode($pf->logradouro.", ".$pf->numero." ".$pf->complemento." - ".$pf->bairro.", ".$pf->cidade." - ".$pf->uf.", ".$pf->cep));

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(8, $l, utf8_decode('NIT:'), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, $l, utf8_decode($pf->nit), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(9, $l, utf8_decode('DRT:'), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, $l, utf8_decode($pf->drt), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(33, $l, utf8_decode('Grau de instrução:'), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30, $l, utf8_decode($pf->grau_instrucao), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(11, $l, utf8_decode('Etnia:'), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(50, $l, utf8_decode($pf->descricao), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(12, $l, utf8_decode('Trans:'), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, $l, utf8_decode($pf->trans == 1 ? "Sim" : "Não"), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, $l, utf8_decode('PCD:'), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, $l, utf8_decode($pf->pcd == 1 ? "Sim" : "Não"), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(18, $l, utf8_decode('Currículo:'), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(162, $l, utf8_decode($pf->curriculo ?? "Não cadastrado"));

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(13, $l, utf8_decode('Banco:'), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(50, $l, utf8_decode(str_replace("–", "-", $pf->banco == NULL ? "Não Cadastrado" : $pf->banco)), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(16, $l, utf8_decode('Agência:'), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, $l, utf8_decode($pf->agencia == NULL ? "Não Cadastrado" : $pf->agencia), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(12, $l, utf8_decode('Conta:'), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(45, $l, utf8_decode($pf->conta == NULL ? "Não Cadastrado" : $pf->conta), 0, 1, 'L');

$pdf->Output('Formacao_resumo_pf.pdf', 'I');
?>