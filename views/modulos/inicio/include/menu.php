<?php
$viewObj = new ViewsController();
$modulos = $viewObj->listaModulos($_SESSION['perfil_s']);

foreach ($modulos as $modulo) {
    $url = $modulo->sistema == 1 ? SERVERURL : SIS2URL."?perfil=";
    if ($_SESSION['perfil_s'] != 1 && $modulo->sistema == 2) {
        continue;
    }
?>
    <li class="nav-item">
        <a href="<?= $url . $modulo->sigla ?>" class="nav-link">
            <i class="nav-icon fas fa-circle <?= $viewObj->getCor($modulo->cor_id) ?>"></i>
            <p><?= $modulo->descricao ?></p>
        </a>
    </li>
<?php
}