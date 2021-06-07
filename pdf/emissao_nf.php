<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$pedidoAjax = true;

// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../config/configGeral.php";
require_once "../controllers/PedidoController.php";
require_once "../controllers/EventoController.php";
require_once "../controllers/OcorrenciaController.php";
require_once "../controllers/NotaEmpenhoController.php";

$idEvento = $_GET['id'];

$pedidoObj = new PedidoController();
$pedido = $pedidoObj->recuperaPedido(1, $idEvento);
$evento = (new EventoController())->recuperaEvento($idEvento);
$ocorrencias = (new OcorrenciaController())->recuperaOcorrencia($idEvento);
$nota_empenho = (new NotaEmpenhoController())->recuperaNotaEmpenho($pedido->id);


//$query = "SELECT p.numero_processo, pj.razao_social, p.valor_total, e.nome_evento, pg.nota_empenho, pg.entrega_nota_empenho, e.id AS idEvento
//FROM pedidos p
//INNER JOIN pessoa_juridicas pj on p.pessoa_juridica_id = pj.id
//INNER JOIN eventos as e ON p.origem_id = e.id
//INNER JOIN pagamentos pg on p.id = pg.pedido_id
//WHERE p.publicado = 1 AND e.publicado = 1 AND p.origem_tipo_id = 1 AND p.id = '$idPedido'";
//$pedido = $con->query($query)->fetch_array();
//
//$parcela = $con->query("SELECT id FROM parcelas WHERE pedido_id = '$idPedido' AND publicado = 1")->fetch_array();
//if($parcela['id'] == NULL){
//    $valor = $pedido['valor_total'];
//} else {
//    $idParcela = $parcela['id'];
//    $parc = $con->query("SELECT valor FROM parcelas WHERE pedido_id = '$idPedido' AND publicado = 1 AND id = '$idParcela'")->fetch_assoc();
//    $valor = $parc['valor'];
//}

$dataAtual = date('Y-m-d H:i:s', strtotime("-3 hours"));

// GERANDO O WORD:
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=$dataAtual - Processo SEI ".$pedido->numero_processo." - NF.doc");
?>
<html lang="pt-br">
<meta http-equiv="Content-Language" content="pt-br">
<!-- HTML 4 -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- HTML5 -->
<meta charset="utf-8"/>
<meta http-equiv="Content-Type" content="text/html; charset=Windows-1252">
<body>

<p><strong><?= $pedido->razao_social ?></strong></p>
<p>&nbsp;</p>
<p>Segue abaixo os dados para emissão da Nota Fiscal:  </p>
<p>&nbsp;</p>
<p><strong>Sacado:</strong> Secretaria Municipal de Cultura <br>
    <strong>Unidade:</strong> Gabinete do Secretário<br>
    <strong>CNPJ:</strong> 49.269.244/0001-63<br>
    <strong>Endereço:</strong> Av. São João, 473 - 11º andar - Centro - CEP: 01035-000<br>
    <strong>Município:</strong> São Paulo &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Estado:</strong> São Paulo &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>I. Est. Nº</strong>: Isento </p>
<p>&nbsp;</p>
<p><strong>Nota Fiscal:</strong> </p>
<p align="justify"><strong>Valor:</strong> R$ <?= $pedidoObj->dinheiroParaBr($pedido->valor_total) ?> ( <?= $pedidoObj->valorPorExtenso($pedido->valor_total)?> )</p>
<p align="justify"><strong>Descrição:</strong> </p>
<p align="justify">Pagamento referente ao evento <?= $evento->nome_evento ?></p>
<p>&nbsp;</p>
<?php
foreach ($ocorrencias as $ocorrencia){
    if($ocorrencia->data_fim == NULL){
        echo "<p align='justify'><strong>Data:</strong> dia ". $pedidoObj->dataParaBR($ocorrencia->data_inicio)."<br>";
    } else{
        echo "<p align='justify'><strong>Período:</strong> de ".$pedidoObj->dataParaBR($ocorrencia->data_inicio)." a ". $pedidoObj->dataParaBR($ocorrencia->data_fim)."<br>";
    }
    echo "<strong>Horário:</strong> ". $pedidoObj->hora($ocorrencia->horario_inicio) ."<br>";
    echo "<strong>Local:</strong> (".$ocorrencia->sigla.") ".$ocorrencia->local."</p>";
    echo "<p>&nbsp;</p>";
}
?>
<p><strong>Nota de Empenho nº:</strong> <?= $nota_empenho->nota_empenho ?><br>
    <strong>Emitida em:</strong> <?= $pedidoObj->dataParaBR($nota_empenho->entrega_nota_empenho) ?></p>

</body>
</html>