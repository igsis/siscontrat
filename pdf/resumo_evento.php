<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$pedidoAjax = true;

// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../config/configGeral.php";
require_once "../views/plugins/fpdf/fpdf.php";
require_once "../controllers/ArquivoController.php";
require_once "../controllers/EventoController.php";

$idEvento = $_GET['id'];

$eventoObj = new EventoController();
$evento = $eventoObj->recuperaEvento($idEvento);

class PDF extends FPDF
{
    function Header()
    {
        $this->Image('../views/dist/img/cultura_principal-horizontal.png', 20, 10);
        $this->Ln(20);
    }

    // Simple table
    function Cabecalho($header)
    {
        $w = array(90,50,40);
        foreach($header as $key => $col)
            $this->Cell($w[$key],7,$col,1);
        $this->Ln();
    }

    // Simple table
    function Tabela($data)
    {
        $w = array(90,50,40);
        foreach($data as $key => $col)
            $this->Cell($w[$key],7,$col,1);
        $this->Ln();
    }
}

// GERANDO O PDF:
$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();


$x=20; //DEFINE A MARGEM SUPERIOR
$l=5; //DEFINE A ALTURA DA LINHA
$f=10; //DEFINE TAMANHO DA FONTE

$pdf->SetXY( $x , 25 );// SetXY - DEFINE O X (altura) E O Y (largura) NA PÁGINA

// Detalhes do evento
include_once "includes/detalhes_evento.php";

// Detalhes da atração
if ($evento->tipo_evento_id == 1) {
    include_once "includes/detalhes_atracao.php";
}

// Detalhes filme
if ($evento->tipo_evento_id == 2) {
    /*
 * INSERIR DADOS DE QUANDO NÃO FOR EVENTO
 */
    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 12);
    $pdf->Cell(180, $l, utf8_decode("FILME"), 'B', 1, 'C');
    $pdf->Ln();
}

// Detalhes ocorrência
include_once "includes/detalhes_ocorrencia.php";

// arquivo comunicação produção
$arquivoObj = new ArquivoController();
$arquivosComProd = $arquivoObj->recuperaArquivoComProd($idEvento);

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 12);
$pdf->Cell(180, $l, utf8_decode("ARQUIVOS PARA COMUNICAÇÃO/PRODUÇÃO"), 'B', 1, 'C');
foreach ($arquivosComProd as $arquivo){
    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'U', $f);
    $pdf->Cell(150, $l, utf8_decode(mb_strimwidth($arquivo->arquivo, 15, 60, "...")), 0, 1, 'L', false,"../uploadsdocs/" . $arquivo->arquivo);
}
$pdf->Ln(15);
// fim aqrquivo comunicação produção

// Detalhes pedido
if ($evento->contratacao = 1){
    include_once "includes/detalhes_pedido.php";
}

/*
 * Chamados
 * Histórico de reabertura
 * Histórico de envio
 */

$pdf->Output("detalhes_evento","I");