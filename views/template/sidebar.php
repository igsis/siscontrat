<?php
    $view = new ViewsController();

    $nomeUser = explode(' ', $_SESSION['nome_s'])[0];

?>
<!-- Brand Logo -->
<a href="<?= SERVERURL ?>inicio" class="brand-link">
    <img src="<?= SERVERURL ?>views/dist/img/SisContratLogo.png" alt="SisContrat Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light"><?= NOMESIS ?></span>
</a>

<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
            <a href="<?= SERVERURL ?>inicio/edita" class="d-block">Olá, <?= $nomeUser ?>!</a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <?php
            $menuTitulo = explode("/", $_GET['views']);
            echo "<li class='nav-header'>".strtoupper($menuTitulo['0'])."</li>";
            $menu = $view->exibirMenuController();
            if ($menu == 'login') {
                include "./views/template/menuExemplo.php";
            } else {
                include $menu;
            }
            ?>

            <?php if ($_SESSION['perfil_s'] == 1): ?>
                <li class="nav-header">SISCONTRAT2</li>
                <li class="nav-item">
                    <a href="<?= SIS2URL ?>" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Acessar</p>
                    </a>
                </li>
            <?php endif ?>

            <li class="nav-header">CONTA</li>
            <li class="nav-item">
                <a href="<?= SERVERURL ?>inicio/edita" class="nav-link">
                    <i class="fa fa-user"></i> 
                    <p>Minha conta</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="http://smcsistemas.prefeitura.sp.gov.br/manual/siscontrat" target="_blank" class="nav-link">
                    <i class="fa fa-question"></i>&nbsp;
                    <p>Ajuda</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= SERVERURL ?>inicio/logout" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i>&nbsp; <p>Sair</p>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->

<?= $view->retornaMenuAtivo() ?>