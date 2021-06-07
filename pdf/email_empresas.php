<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$pedidoAjax = true;
// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../config/configGeral.php";
require_once "../controllers/PedidoController.php";
require_once "../controllers/OcorrenciaController.php";
require_once "../controllers/EventoController.php";

$idEvento = $_GET['id'];
$modeloEmail = $_GET['modelo'];

$pedidoObj =  new PedidoController();
$pedido = $pedidoObj->recuperaPedido(1, $idEvento);
$periodo = (new OcorrenciaController())->retornaPeriodo($idEvento);
$evento_nome = (new EventoController())->recuperaEvento($idEvento)->nome_evento;

$rep1 = $pedido->rep1;

switch ($modeloEmail) {
    case 'empresas':
        $item4 = "<p align=\"justify\">d) Declaração do Simples Nacional (para ser assinada pelo(a) representante legal, somente em caso de Empresa optante pelo Simples Nacional).</p>";
        break;
    case 'cooperativas':
        $item4 = "<p align=\"justify\">d) Documento comprobatório quanto a isenção ou imunidade de impostos.</p>";
        break;
    case 'associacoes':
        $item4 = "<p align=\"justify\">d) Declaração de Associação sem fins lucrativos.</p>";
        break;
    default:
        $item4 = "";
        break;
}

$dataAtual = date('Y-m-d H:i:s', strtotime('-3 hours'));
session_start(['name' => 'sis']);

// GERANDO O WORD:
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=$dataAtual - Processo SEI ".$pedido->numero_processo." - Email". ucfirst($modeloEmail) .".doc");
?>
<html lang="pt-br">
<meta http-equiv="Content-Language" content="pt-br">
<!-- HTML 4 -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- HTML5 -->
<meta charset="utf-8"/>
<meta http-equiv="Content-Type" content="text/html; charset=Windows-1252">
<body>
<p align="justify">Prezado(a) Senhor(a) <?= $rep1['nome'] ?>,</p>
<p align="justify">Tendo em vista a apresentação <?= $evento_nome ?>, na data/período <?= $periodo ?>, encaminho em anexo, para fins de pagamento, os itens abaixo relacionados:</p>
<p align="justify">a) Recibo da nota de empenho (para ser assinado pelo(a) representante legal da Empresa);</p>
<p align="justify">b) Pedido de pagamento (para ser assinado pelo(a) representante legal);</p>
<p align="justify">c) Instruções para Emissão da Nota Fiscal Eletrônica;</p>
<?=$item4?>
<p align="justify">Para fins de arquivamento da empresa, segue também o Anexo e a Nota de Empenho da referida contratação.</p>
<p align="justify">Informo que a documentação acima citada deverá ser devolvida digitalizada, <strong>somente através do e-mail smc.pagamentosartisticos@gmail.com, em até 48 horas, impreterivelmente.</strong></p>
<p>&nbsp;</p>
<p align="justify">Atenciosamente,</p>
<br>
<p><?=$_SESSION['nome_s']?><br>
    SMC / Pagamentos Artísticos<br>
    Tel: (11) 3397-0191</p>
</body>
</html>