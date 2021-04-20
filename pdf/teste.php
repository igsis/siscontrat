<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$pedidoAjax = true;
// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../config/configGeral.php";
require_once "../controllers/PedidoController.php";
require_once "../controllers/EventoController.php";

$pedidoObj = new PedidoController();
$eventoObj = new EventoController();

$pedido = $pedidoObj->recuperaPedido(2, 2);
$evento = $eventoObj->recuperaEvento(4);
?>

<html>
<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html. charset=Windows-1252\">
    <title>Teste de Controller</title>
</head>

<body>
<br>
<div align="left">
    <pre>
        <?php
        var_dump($evento);
        ?>
    </pre>
    <hr>
    <pre>
        <?php
        var_dump($pedido);
        ?>
    </pre>


</div>
</body>
</html>