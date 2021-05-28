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
require_once "../controllers/FilmeController.php";

$tipo = $_GET['tipo'];
$idEvento = $_GET['id'];
$ano = date('Y');

$eventoObj = new EventoController();
$pedidoObj = new PedidoController();
$ocorrenciaObj = new OcorrenciaController();

$pedido = $pedidoObj->recuperaPedido(1,$idEvento);
$evento = $eventoObj->recuperaEvento($idEvento);
$objeto = $eventoObj->recuperaObjetoEvento($idEvento);
$periodo = $eventoObj->retornaPeriodo($idEvento);
$local = $eventoObj->retornaLocais($idEvento);

if ($pedido->pessoa_tipo_id == 1){
    $nomeTipo = "FÍSICA";
    $proponente = $pedido->nome;
    $documento = $pedido->cpf ?? $pedido->passaporte;
}
else{
    $nomeTipo = "JURÍDICA";
}

// GERANDO O WORD:
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=".date('d-m-Y')." - Processo SEI $pedido->numero_processo - Pedido de Pagamento.doc");
?>

<html lang="pt-br">
<meta http-equiv="Content-Language" content="pt-br">

<!-- HTML5 -->
<meta charset="utf-8"/>
<meta http-equiv="Content-Type" content="text/html; charset=Windows-1252">
<body>

<p align="center"><strong>PEDIDO DE PAGAMENTO DE PESSOA <?=$nomeTipo?></strong></p>
<p>&nbsp;</p>
<p><strong>
	Senhor(a) Diretor(a)<br>
	Secretaria Municipal de Cultura
</strong></p>
<p>&nbsp;</p>
<p>
<?php if ($pedido->pessoa_tipo_id == 1){ ?>
    <strong>Nome:</strong> <?= $pedido->nome ?><br>
    <strong>Nome Artístico:</strong> <?= $pedido->nome_artistico ?? null ?><br>
    <strong>Nacionalidade:</strong> <?= $pedido->nacionalidade ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>CCM:</strong> <?= (new MainModel)::checaCampo($pedido->ccm) ?><br>
    <strong>Data de Nascimento:</strong> <?= (new MainModel)->validaData($pedido->data_nascimento) ?><br>
    <strong>Inscrição no INSS ou nº PIS / PASEP:</strong> <?= $pedido->nit ?><br>
<?php } else { ?>
    <strong>Nome da empresa:</strong> <?= $pedido->razao_social ?><br>
    <strong>CCM:</strong> <?= (new MainModel)::checaCampo($pedido->ccm) ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>CNPJ:</strong> <?= $pedido->cnpj ?><br>
<?php } ?>
    <strong>Endereço:</strong> <?= $pedido->logradouro . ", " . $pedido->numero . " " . $pedido->complemento . " / - " . $pedido->bairro . " - " . $pedido->cidade . " / " . $pedido->uf . " - CEP: " . $pedido->cep ?><br>
    <strong>Telefone:</strong> <?= $pedido->telefones['tel_0'] ?? null . " " .$pedido->telefones['tel_1'] ?? null. " ".$pedido->telefones['tel_2'] ?? null ?><br>
    <strong>E-mail:</strong> <?= $pedido->email ?>
</p>
<p ><strong>Evento:</strong> <?= $objeto ?><br>
    <strong>Data / Período:</strong> <?= $periodo ?><br>
    <strong>Local:</strong> <?= $local ?><br>
    <strong>Valor:</strong> R$ <?= (new MainModel)->dinheiroParaBr(($pedido->valor_total)) . " ( " .  (new MainModel)->valorPorExtenso($pedido->valor_total) ?> )
</p>
<p>Venho, mui respeitosamente, requerer  que o(a) senhor(a) se digne  submeter a exame   à  decisão do órgão competente o pedido supra.</p>
<p>Declaro, sob as penas da Lei, não possuir débitos perante as Fazendas Públicas, em especial com a Prefeitura do Município de São Paulo.
Nestes termos, encaminho para deferimento.</p>
<p>&nbsp;</p>
<p>São Paulo, _______ de ________________________ de <?= date('Y') ?>.</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>________________________________________________<br>
<?php
if ($pedido->pessoa_tipo_id == 1){
    echo $pedido->nome . "<br>";
    if ($pedido->passaporte){
        echo "Passaporte: ".$pedido->passaporte;
    } else{
        echo "CPF: ".$pedido->cpf;
    }
} else {
    echo $pedido->rep1['nome'] . "<br>CPF: " . $pedido->rep1['cpf'];
    if ($pedido->rep2['nome']){
        echo "<p>&nbsp;</p><p>&nbsp;</p>";
        echo "________________________________________________<br>";
        echo $pedido->rep2['nome'] . "<br>CPF: " . $pedido->rep2['cpf'];
    }
} ?>
</p>
</body>
</html>