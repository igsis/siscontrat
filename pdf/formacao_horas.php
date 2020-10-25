<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$pedidoAjax = true;
// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../config/configGeral.php";
require_once "../views/plugins/fpdf/fpdf.php";
require_once "../controllers/FormacaoController.php";

$formObj = new FormacaoController();

$pedido_id = $_GET['id'];

class PDF extends FPDF
{
    // Simple table
    function ImprovedTable($header, $line)
    {
        // Column widths
        $w = array(35, 50, 35, 35);
        // Header
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
        }

        $this->Ln();

        $this->SetX(20);

        // Line
        for ($a = 0; $a <= 20; $a++) {
            for ($i = 0; $i < count($line); $i++) {
                $this->Cell($w[$i], 6, $line[$i], 1, 0, 'C');
            }
            $this->Ln();
            $this->SetX(20);
        }

        //last line
        $this->SetX(20);
        $this->Cell(120, 6, "TOTAL HORAS", 1, 0, 'L');
        $this->Cell(35, 6, " ", 1, 0, 'L');
    }
}

$pedido = $formObj->recuperaPedido($pedido_id);
$pf = $formObj->recuperaPf($pedido->pessoa_fisica_id);

$contratacao = $formObj->recuperaContratacao($pedido->origem_id, '0');

$header = array('DATA', 'ATIVIDADE DESENVOLVIDA', 'LOCAL', 'HORAS');
$line = array('', '', '', '');

$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();


$x = 20;
$l = 7; //DEFINE A ALTURA DA LINHA

$pdf->SetXY($x, 35);// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

$pdf->SetTitle('Relatorio de horas');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(180, 15, utf8_decode("PREFEITURA  MUNICIPAL DE SÃO PAULO"), 0, 1, 'C');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(180, 15, utf8_decode("SECRETARIA  MUNICIPAL DE CULTURA - DIVISÃO DE FORMAÇÃO"), 0, 1, 'C');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(180, 15, utf8_decode("RELATÓRIO DE HORAS  TRABALHADAS"), 0, 1, 'C');

$pdf->Ln(5);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(19, $l, "Programa:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(20, $l, utf8_decode($contratacao->programa), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(21, $l, "Linguagem:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(20, $l, utf8_decode($contratacao->linguagem), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(15, $l, utf8_decode("Função:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(20, $l, utf8_decode($contratacao->cargo), 0, 0, 'L');

$pdf->Ln(7);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(12, $l, utf8_decode("Nome:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(165, $l, utf8_decode($pf->nome), 0, 'L', 0);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(11, $l, utf8_decode("Mês:"), 0, 0, 'L');

$pdf->Ln(7);

$pdf->SetX($x);
$pdf->ImprovedTable($header, $line);

$pdf->SetY(260);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(75, $l, utf8_decode($pf->nome), 'T', 0, 'L');

$pdf->SetX(100);
$pdf->MultiCell(75, $l, utf8_decode("Assinatura Articulador/Coordenado"), 'T', 'L', 0);

$pdf->Output('Relátório de horas.pdf', 'I');
?>

