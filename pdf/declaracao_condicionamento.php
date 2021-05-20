<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$pedidoAjax = true;

// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../config/configGeral.php";
require_once "../controllers/PedidoController.php";
require_once "../controllers/EventoController.php";

$idEvento = $_GET['id'];

$eventoObj = new EventoController();
$pedidoObj = new PedidoController();

//CONSULTA
$pedido = $pedidoObj->recuperaPedido(1,$idEvento);
$evento = $eventoObj->recuperaEvento($idEvento);
$objeto = $eventoObj->recuperaObjetoEvento($idEvento);
$periodo = $eventoObj->retornaPeriodo($idEvento);
$local = $eventoObj->retornaLocais($idEvento);

$dataAtual = date('d/m/Y');

// GERANDO O WORD:
//header("Content-type: application/vnd.ms-word");
//header("Content-Disposition: attachment;Filename=Condicionamento.doc");
?>
<html lang="pt-br">
<body>
<p style="text-align: center">DECLARAÇÃO</p>
<br>
<?php if ($pedido->pessoa_tipo_id == 1){//pessoa física ?>
    <p style="text-align: justify">DECLARO para os devidos fins, que eu <?=$pedido->nome?>, CPF: <?=$pedido->cpf?>, sediada na <?=$pedido->logradouro . ", " . $pedido->numero . " " . $pedido->complemento . " / - " . $pedido->bairro . " - " . $pedido->cidade . " / " . $pedido->uf?>, está ciente e de acordo que o pagamento dos serviços a serem prestados, referente a <?=$objeto?>, <?=$periodo?>, no(s) local(ais) <?=$local?>, ficará condicionado à apresentação do documento, abaixo listado, regularizado:</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p style="text-align: justify"><?=$dataAtual?></p>
    <p>&nbsp;</p>
    <p><strong>__________________________________________________________________ </strong></p>
    <p style="text-align: left"><?=$pedido->nome?></p>
    <p style="text-align: left">
        <?php
        if ($pedido->passaporte){
            echo "Passaporte: ".$pedido->passaporte;
        } else{
            echo "CPF: ".$pedido->cpf;
        }
        ?>
    </p>
<?php } else{ ?>
    <p style="text-align: justify">DECLARO para os devidos fins, que a empresa <?=$pedido->razao_social?>, CNPJ: <?=$pedido->cnpj?>, sediada na <?=$pedido->logradouro . ", " . $pedido->numero . " " . $pedido->complemento . " / - " . $pedido->bairro . " - " . $pedido->cidade . " / " . $pedido->uf?>, está ciente e de acordo que o pagamento dos serviços a serem prestados, referente a <?=$objeto?>, <?=$periodo?>, no(s) local(ais) <?=$local?>, ficará condicionado à apresentação do documento, abaixo listado, regularizado:</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p style="text-align: justify"><?=$dataAtual?></p>
    <p>&nbsp;</p>
    <p><strong>__________________________________________________________________ </strong></p>
    <p style="text-align: justify"><?=$pedido->razao_social?></p>
    <p>&nbsp;</p>
    <p style="text-align: left"><?=$pedido->rep1['nome']?><br>
        CPF: <?=$pedido->rep1['cpf']?></p>
<?php } ?>
</body>
</html>
