<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if(isset($_POST['_method'])){
    require_once "../controllers/AdministradorController.php";
    $perfilObj = new AdministradorController();

}
?>
