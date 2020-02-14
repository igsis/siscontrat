<li class="nav-item">
    <a href="<?= SERVERURL ?>fomentos/inicio" class="nav-link" id="fomentos_inicio">
        <i class="fa fa-info nav-icon"></i>
        <p>Lista Projetos</p>
    </a>
</li>
<hr/>
<?php if (isset($_SESSION['projeto_s'])): ?>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>fomentos/projeto_cadastro" class="nav-link" id="projeto">
            <i class="far fa-circle nav-icon"></i>
            <p>Projeto</p>
        </a>
    </li>
    <?php if (!isset($_SESSION['origem_id_s'])): ?>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>fomentos/proponente" class="nav-link" id="buscaProponente">
                <i class="fas fa-search-plus nav-icon"></i>
                <p>Buscar empresa</p>
            </a>
        </li>
    <?php endif; ?>
    <?php if (isset($_SESSION['origem_id_s'])): ?>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>fomentos/pj_cadastro&id=<?= $_SESSION['origem_id_s'] ?>" class="nav-link"
               id="proponente">
                <i class="far fa-circle nav-icon"></i>
                <p>Empresa</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>fomentos/anexos" class="nav-link" id="anexos">
                <i class="far fa-circle nav-icon"></i>
                <p>Anexos</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>fomentos/finalizar" class="nav-link" id="finalizar">
                <i class="far fa-circle nav-icon"></i>
                <p>Finalizar</p>
            </a>
        </li>
    <?php endif ?>
<?php endif; ?>
