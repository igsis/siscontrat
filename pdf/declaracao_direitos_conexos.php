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
$periodo = $eventoObj->retornaPeriodo($idEvento);
$local = $eventoObj->retornaLocais($idEvento);

$ano = date('Y');

header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=Direitos_Conexos.doc");
?>
<html lang="pt-br">
<header>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</header>
<body>
    <p style="text-align: center"><strong>AUTORIZAÇÃO DE USO DE DIREITOS CONEXOS</strong></p>
    <p>&nbsp;</p>
    <p style="text-align: justify">Nós, abaixo assinadas, AUTORIZAMOS, gratuitamente, a PREFEITURA DO MUNICÍPIO DE SÃO PAULO, por meio da Secretaria Municipal de Cultura, a utilizar os direitos conexos relativos às gravações de áudio e vídeo da nossa participação, captado no concerto a ser realizado em <?= $periodo ?> no(s) local(is) <?= $local ?>, para fins de inserção no site, exclusivamente para fins não comerciais, pelo prazo de proteção do artigo 96 da Lei 9.610/98.</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>Data: ____ / ____ / <?= $ano ?>.</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>Integrantes:</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>Assinaturas:</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
</body>
</html>