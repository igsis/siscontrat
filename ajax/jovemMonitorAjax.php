<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    session_start(['name' => 'sis']);
    $idPf = $_SESSION['origem_id_s'];
    require_once "../controllers/JovemMonitorController.php";
    $insJm = new JovemMonitorController();

    if ($_POST['_method'] == "envioJovemMonitor") {
        echo $insJm->envioJovemMonitor($_POST['pagina'],$idPf);
    }
} else {
    include_once "../config/destroySession.php";
}