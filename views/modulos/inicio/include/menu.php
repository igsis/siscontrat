<?php
$viewObj = new ViewsController();
$modulos = $viewObj->listaModulos($_SESSION['perfil_s']);

foreach ($modulos as $modulo) {
?>
    <li class="nav-item">
        <a href="<?= SERVERURL ?><?=$modulo->sigla?>/" class="nav-link">
            <i class="nav-icon fas fa-circle <?=$viewObj->getCor($modulo->cor_id)?>"></i>
            <p><?=$modulo->descricao?></p>
        </a>
    </li>
<?php
}