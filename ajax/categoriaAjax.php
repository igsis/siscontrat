<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    require_once "../controllers/CategoriaController.php";
    $categoriaObj = new CategoriaController();

    if ($_POST['_method'] == "cadastrar") {
        echo $categoriaObj->cadastrarCategoria($_POST);
    } elseif ($_POST['_method'] == "editar") {
        echo $categoriaObj->editarCategoria($_POST);
    }

} else {
    include_once "../config/destroySession.php";
}
?>