<?php
$viewObj = new ViewsController();
$modulos = $viewObj->listaModulos($_SESSION['perfil_s']);

foreach ($modulos as $modulo) {
?>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>inicio" class="nav-link">
            <i class="nav-icon fas fa-home"></i>
            <p><?=$modulo->descricao?></p>
        </a>
    </li>
<?php
}