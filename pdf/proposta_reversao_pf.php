<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$pedidoAjax = true;

// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../config/configGeral.php";
require_once "../views/plugins/fpdf/fpdf.php";
require_once "../controllers/PedidoController.php";
require_once "../controllers/EventoController.php";
require_once "../controllers/OcorrenciaController.php";
require_once "../controllers/AtracaoController.php";

$tipo = $_GET['tipo'];
$id = $_GET['id'];
$idPenal = $_GET['penal'];
$ano = date('Y');

$pedidoObj = new PedidoController();
$eventoObj = new EventoController();
$ocorrenciaObj = new OcorrenciaController();

if ($tipo == 1){//atração
    $atracaoObj = new AtracaoController();
    $atracao = $atracaoObj->recuperaAtracao($id);
    $idEvento = $atracao->evento_id;
    $atracao_id = $atracao->id;
} elseif ($tipo == 2) {//filme
    $filme = $eventoObj->consultaSimples("SELECT id, evento_id FROM filme_eventos WHERE id = '$id'")->fetchObject();
    $idEvento = $filme->_evento_id;
    $atracao_id = $filme->id;
}

$pedido = $pedidoObj->recuperaPedido(1,$idEvento);
$penalidade = $pedidoObj->recuperaPenalidades($idPenal);
$evento = $eventoObj->recuperaEvento($idEvento);
$objeto = $eventoObj->recuperaObjetoEvento($idEvento);
$periodo = $eventoObj->retornaPeriodo($idEvento);
$local = $eventoObj->retornaLocais($idEvento);
$ocorrencias = $ocorrenciaObj->recuperaOcorrencia($idEvento);

$pedidoObj->inserePedidoEtapa(intval($pedido->id),"proposta");

class PDF extends FPDF
{
    function Header()
    {
        // Logo
        $this->Cell(80);
        $this->Image(SERVERURL.'views/dist/img/logo_smc.jpg', 170, 10);
        $this->Ln(20);
    }

    //INSERIR ARQUIVOS
    function ChapterBody($file)
    {
        // Read text file
        $txt = file_get_contents($file);
        // Font
        $this->SetFont('Arial','',9);
        // Output justified text
        $this->MultiCell(0,6,utf8_decode($txt));
        // Line break
        $this->Ln();
    }

    function PrintChapter($file)
    {
        $this->ChapterBody($file);
    }
}

$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();


$x = 20;
$l = 7; //DEFINE A ALTURA DA LINHA

$pdf->SetXY($x, 35);// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

$pdf->SetTitle("Reversão PF",true);

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, 5, '(A)', 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(170, 5, 'CONTRATADO', 0, 1, 'C');

$pdf->Ln(5);


$pdf->SetX($x);
$pdf->SetFont('Arial', 'I', 10);
$pdf->MultiCell(200, $l, utf8_decode("(Quando se tratar de grupo, o líder do grupo)"), 0, 'L', 0);

$pdf->Ln(5);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(12, $l, 'Nome:', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(120, $l, utf8_decode($pedido->nome), 0, 'L', 0);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(27, $l, utf8_decode("Nome Artístico:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(120, $l, utf8_decode($pedido->nome_artistico == null ? "Não cadastrado" : $pedido->nome_artistico), 0, 'L', 0);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);

if ($pedido->passaporte != NULL) {
    $pdf->Cell(21, $l, utf8_decode('Passaporte:'), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(50, $l, utf8_decode($pedido->passaporte), 0, 0, 'L');

} else {
    $pdf->Cell(7, $l, utf8_decode('RG:'), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(50, $l, utf8_decode($pedido->rg == NULL ? "Não cadastrado" : $pedido->rg), 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(9, $l, utf8_decode('CPF:'), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(45, $l, utf8_decode($pedido->cpf), 0, 0, 'L');
}

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(9, $l, utf8_decode("DRT:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(5, $l, utf8_decode($pedido->drt), 0, 0, 'L');

$pdf->Ln(7);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(35, $l, 'Data de Nascimento:', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(25, $l, utf8_decode((new MainModel)->validaData($pedido->data_nascimento)), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(26, $l, "Nacionalidade:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(44, $l, utf8_decode((new MainModel)->checaCampo($pedido->nacionalidade)), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, $l, "CCM:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30, $l, utf8_decode((new MainModel)->checaCampo($pedido->ccm)), 0, 0, 'L');

$pdf->Ln(7);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(18, $l, utf8_decode("Endereço:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(160, $l, utf8_decode($pedido->logradouro . ", " . $pedido->numero . " " . $pedido->complemento . " / - " . $pedido->bairro . " - " . $pedido->cidade . " / " . $pedido->uf));

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(21, $l, 'Telefone(s):', '0', '0', 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(168, $l, utf8_decode($pedido->telefones['tel_0'] ?? null . " " .$pedido->telefones['tel_1'] ?? null. " ".$pedido->telefones['tel_2'] ?? null));

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(11, $l, 'Email:', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(168, $l, utf8_decode($pedido->email), 0, 'L', 0);

$pdf->SetX($x);
$pdf->Cell(180, 5, '', 'B', 1, 'C');

$pdf->Ln(5);

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, 10, '(B)', 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(160, 10, 'PROPOSTA', 0, 0, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, 10, utf8_decode($evento->protocolo), 0, 1, 'R');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(13, $l, 'Objeto:', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(140, $l, utf8_decode($objeto), 0, 0, 'L');

$pdf->Ln(6);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(26, $l, utf8_decode('Data / Período:'), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(50, $l, utf8_decode($periodo), 0, 'L', 0);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(18, $l, 'Local(ais):', '0', '0', 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(165, $l, utf8_decode($local), 0, 'L', 0);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(11, $l, 'Valor:', '0', '0', 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(168, $l, utf8_decode("R$ " . (new MainModel)->dinheiroParaBr(($pedido->valor_total)) . " ( " .  (new MainModel)->valorPorExtenso($pedido->valor_total) . " )"), 0, 'L', 0);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(38, $l, 'Forma de Pagamento:', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(122, $l, utf8_decode($pedido->forma_pagamento));

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(22, $l, 'Justificativa:', '0', '0', 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(155, $l, utf8_decode($pedido->justificativa));

//RODAPÉ PERSONALIZADO
$pdf->SetXY($x, 262);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(100, 4, utf8_decode($pedido->nome), 'T', 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 10);

if ($pedido->passaporte != NULL) {
    $pdf->Cell(100, 4, "Passaporte: " . $pedido->passaporte, 0, 1, 'L');
} else {
    $rg = $pedido->rg == NULL ? "Não cadastrado" : $pedido->rg;
    $rg = "RG: " . $rg;
    $pdf->Cell(100, 4, utf8_decode($rg), 0, 1, 'L');
    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(100, 4, "CPF: " . $pedido->cpf, 0, 0, 'L');
}

$pdf->AddPage('', '');

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, $l, '(D)', 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(160, $l, utf8_decode('OBSERVAÇÃO'), 0, 1, 'C');

$pdf->SetX($x);
$pdf->PrintChapter('includes/proposta_observacao_padrao.txt');

$pdf->AddPage('', '');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(180, $l, utf8_decode('DECLARAÇÕES'), 0, 1, 'C');

$pdf->SetX($x);
$pdf->SetFont('Arial', '',9);
$pdf->MultiCell(180, 5, utf8_decode($penalidade));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','', 9);
$pdf->Cell(10,$l,'',0,0,'L');
$pdf->SetFont('Arial','B', 9);
$pdf->Cell(160,5,utf8_decode('NOS CASOS DE REVERSÃO DE BILHETERIA'),0,1,'C');

$pdf->SetX($x);
$pdf->SetFont('Arial','', 9);
$pdf->MultiCell(180,5,utf8_decode('1) No caso de pagamento do cachê por reversão de bilheteria, fica o valor dos ingressos sujeito ao atendimento no disposto nas Leis Municipais nº 10.973/91, regulamentada pelo Decreto Municipal nº 30.730/91; Leis Municipais 11.113/91; 11.357/93 e 12.975/2000 e Portaria nº 66/SMC/2007; Lei Estadual nº 7844/92, regulamentada pelo Decreto Estadual nº 35.606/92; Lei Estadual nº 10.858/2001, com as alterações da Lei Estadual 14.729/2012 e Lei Federal nº 12.933/2013.'));

$pdf->SetX($x);
$pdf->SetFont('Arial','', 9);
$pdf->MultiCell(180,5,utf8_decode('2) O pagamento do cachê corresponderá à reversão integral da renda obtida na bilheteria a/o ontratada/o, deduzidos os impostos e taxas pertinentes.'));

$pdf->SetX($x);
$pdf->SetFont('Arial','', 9);
$pdf->MultiCell(180,5,utf8_decode('3) Os ingressos poderão ser vendidos com preços reduzidos, em face de promoções realizadas pela produção do evento.'));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(10, $l, '', 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(160, 5, utf8_decode('RESCISÃO'), 0, 1, 'C');

$pdf->SetX($x);
$pdf->SetFont('Arial','', 9);
$pdf->MultiCell(180,5,utf8_decode('Este instrumento poderá ser rescindido, no interesse da administração, devidamente justificado ou em virtude da inexecução total ou parcial do serviço sem prejuízo de multa, nos termos da legislação vigente.'));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(180, 5, utf8_decode('FORO'), 0, 1, 'C');

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(180, 5, utf8_decode('Fica eleito o foro da Fazenda Pública para todo e qualquer procedimento judicial oriundo deste instrumento.'));

$pdf->Ln(5);

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(180, $l, "Data: _________ / _________ / " . "$ano" . ".", 0, 0, 'L');

$pdf->Ln(40);

//RODAPÉ PERSONALIZADO
$pdf->SetX($x);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(100, 4, utf8_decode($pedido->nome), 'T', 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 10);

if ($pedido->passaporte != NULL) {
    $pdf->Cell(100, 4, "Passaporte: " . $pedido->passaporte, 0, 1, 'L');
} else {
    $rg = $pedido->rg == NULL ? "Não cadastrado" : $pedido->rg;
    $rg = "RG: " . $rg;
    $pdf->Cell(100, 4, utf8_decode($rg), 0, 1, 'L');
    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(100, 4, "CPF: " . $pedido->cpf, 0, 0, 'L');
}

$pdf->Ln(60);

$pdf->SetX($x);
$pdf->SetFont('Arial','', 10);
$pdf->MultiCell(180,5,utf8_decode('Autorizo a execução do serviço.'));

$pdf->Ln();

$pdf->SetXY($x,262);
$pdf->SetFont('Arial','', 10);
$pdf->Cell(100,4,utf8_decode('Tais Ribeiro Lara'),'T',1,'L');

$pdf->SetX($x);
$pdf->SetFont('Arial','', 10);
$pdf->Cell(100,4,"Chefe de Gabinete",0,1,'L');

$pdf->SetX($x);
$pdf->SetFont('Arial','', 10);
$pdf->Cell(100,4,"Secretaria Municipal de Cultura",0,0,'L');

$pdf->AddPage('', '');
$f = 10; //tamanho da fonte
$l = 6;

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(180, 5, "CRONOGRAMA", 0, 1, 'C');

$pdf->Ln(5);
if ($tipo == 1) {//atracao
    $atracoes = $atracaoObj->listaAtracao($idEvento);
    foreach ($atracoes as $atracao) {
        $ocorrencias = $ocorrenciaObj->recuperaOcorrencia($idEvento, $tipo, $atracao->id);
        $excecao = $ocorrenciaObj->recuperaOcorrenciaExcecao($atracao->id);

        $pdf->SetX($x);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(180, $l, utf8_decode($atracao->nome_atracao), 'B', 1, 'L');

        foreach ($ocorrencias as $ocorrencia) {
            $pdf->SetX($x);
            $pdf->SetFont('Arial','', $f);
            $pdf->Cell(180, $l, utf8_decode("Ação: " . (new AtracaoController)->recuperaAcaoAtracao($ocorrencia->atracao_id)), 0, 1, 'L');

            $pdf->SetX($x);
            $pdf->SetFont('Arial','', $f);
            $pdf->Cell(28, $l, "Data: ".date('d/m/Y',strtotime($ocorrencia->data_inicio)), 0, 0, 'L');
            if ($ocorrencia->data_fim != "0000-00-00"){
                $pdf->Cell(22, $l, utf8_decode("à ".date('d/m/Y', strtotime($ocorrencia->data_fim))), 0, 0, 'L');
            }
            $pdf->Cell(31, $l, utf8_decode("das ".substr($ocorrencia->horario_inicio,0,-3)." às ".substr($ocorrencia->horario_fim,0,-3)), 0, 0, 'L');
            $pdf->Cell(21,$l,utf8_decode("(".$ocorrenciaObj->diadasemanaocorrencia($ocorrencia->id).")"),0,1,'L');

            $pdf->SetX($x);
            $pdf->SetFont('Arial','', $f);
            $pdf->MultiCell(180,$l,utf8_decode("Local: ($ocorrencia->sigla) {$ocorrencia->local}"));

            $pdf->SetX($x);
            $pdf->SetFont('Arial','', $f);
            $pdf->Cell(180, $l, utf8_decode("Subprefeitura: ".$ocorrencia->subprefeitura), 0, 1, 'L');

            if($ocorrencia->libras == 1 || $ocorrencia->audiodescricao == 1){
                if($ocorrencia->libras == 1){
                    $libras = "Libras";
                } else {
                    $libras = "";
                }
                if($ocorrencia->audiodescricao == 1){
                    $audio = "Audiodescrição";
                } else {
                    $audio = "";
                }
                $pdf->SetX($x);
                $pdf->Cell(130, $l, utf8_decode("Especial: ".$libras." ".$audio), 0, 1, 'L');
            }

            $pdf->SetX($x);
            $pdf->SetFont('Arial','', $f);
            $pdf->Cell(145, $l, utf8_decode("Retirada de ingresso: ".$ocorrencia->retirada_ingresso), 0, 0, 'L');
            $pdf->Cell(80,$l,utf8_decode("Valor: R$ ". (new MainModel)->dinheiroParaBr($ocorrencia->valor_ingresso)),0,1,'L');

            if ($ocorrencia->observacao){
                $pdf->SetX($x);
                $pdf->SetFont('Arial','', $f);
                $pdf->Cell(180, $l, utf8_decode("Observação: ".$ocorrencia->observacao), 0, 1, 'L');
            }

            $pdf->Ln();
        }
        if ($excecao){
            $pdf->SetX($x);
            $pdf->SetFont('Arial','', $f);
            $pdf->MultiCell(180, $l, utf8_decode("Exceto dia(s): ".$excecao));
        }
        $pdf->Ln(10);
    }
}

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(100, 4, utf8_decode($pedido->nome), 'T', 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', '', 10);

if ($pedido->passaporte != NULL) {
    $pdf->Cell(100, 4, "Passaporte: " . $pedido->passaporte, 0, 1, 'L');
} else {
    $rg = $pedido->rg == NULL ? "Não cadastrado" : $pedido->rg;
    $rg = "RG: " . $rg;
    $pdf->Cell(100, 4, utf8_decode($rg), 0, 1, 'L');
    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(100, 4, "CPF: " . $pedido->cpf, 0, 0, 'L');
}

$pdf->Output();