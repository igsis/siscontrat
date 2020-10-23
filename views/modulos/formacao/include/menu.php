<li class="nav-item">
    <a href="<?= SERVERURL ?>formacao/inicio" class="nav-link" id="inicio">
        <i class="fa fa-home nav-icon"></i>
        <p>Home</p>
    </a>
</li>
<?php
if ($_SESSION['perfil_s'] == 1){
?>
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
            Acesso Administrativo
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="<?= SERVERURL ?>formacao/cargo_lista" class="nav-link active" id="cargo_lista">
                <i class="far fa-circle nav-icon"></i>
                <p>Cargo</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>formacao/cargo_programa" class="nav-link active" id="cargo_programa">
                <i class="far fa-circle nav-icon"></i>
                <p>Vincular Cargo</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>formacao/coordenadoria_lista" class="nav-link" id="coordenadoria_lista">
                <i class="far fa-circle nav-icon"></i>
                <p>Coordenadoria</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>formacao/programa_lista" class="nav-link" id="programa_lista">
                <i class="far fa-circle nav-icon"></i>
                <p>Programa</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>formacao/linguagem_lista" class="nav-link" id="linguagem_lista">
                <i class="far fa-circle nav-icon"></i>
                <p>Linguagem</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>formacao/projeto_lista" class="nav-link" id="projeto_lista">
                <i class="far fa-circle nav-icon"></i>
                <p>Projeto</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>formacao/subprefeitura_lista" class="nav-link" id="subprefeitura_lista">
                <i class="far fa-circle nav-icon"></i>
                <p>Subprefeitura</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>formacao/territorio_lista" class="nav-link" id="territorio_lista">
                <i class="far fa-circle nav-icon"></i>
                <p>Território</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>formacao/vigencia_lista" class="nav-link" id="vigencia_lista">
                <i class="far fa-circle nav-icon"></i>
                <p>Vigência</p>
            </a>
        </li>
    </ul>
</li>
<?php
}
?>
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="fas fa-copyright"></i>
        <p>
            Gerenciar CAPAC
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <?php
        if ($_SESSION['perfil_s'] != 16) //habilitar apenas listar inscritos
        {
        ?>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>formacao/abertura_lista" class="nav-link" id="abertura_lista">
                <i class="far fa-circle nav-icon"></i>
                <p>Cadastrar abertura</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>formacao/documento_lista" class="nav-link" id="documento_lista">
                <i class="far fa-circle nav-icon"></i>
                <p>Lista de documentos</p>
            </a>
        </li>
        <?php
        }
        ?>

        <?php
        if ($_SESSION['perfil_s'] == 1 || $_SESSION['perfil_s'] == 16){
        ?>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>formacao/listar_inscritos" class="nav-link" id="listar_inscritos">
                <i class="far fa-circle nav-icon"></i>
                <p>Listar inscritos</p>
            </a>
        </li>
        <?php
        }
        ?>

        <?php
        if ($_SESSION['perfil_s'] == 1){
        ?>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>formacao/exportar_inscritos_capac" class="nav-link" id="exportar_inscritos_capac">
                <i class="far fa-circle nav-icon"></i>
                <p>Exportar inscritos</p>
            </a>
        </li>
        <?php
        }
        ?>
    </ul>
</li>
<?php
if ($_SESSION['perfil_s'] == 1){
?>
<li class="nav-item">
    <a href="<?= SERVERURL ?>formacao/pf_lista" class="nav-link" id="pf_lista">
        <i class="fas fa-user-friends"></i>
        <p>Pessoas Físicas</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= SERVERURL ?>formacao/dados_contratacao_lista" class="nav-link" id="dados_contratacao_lista">
        <i class="fas fa-file-contract"></i>
        <p>Dados para Contratação</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= SERVERURL ?>formacao/pedido_contratacao_lista" class="nav-link" id="pedido_contratacao_lista">
        <i class="fas fa-file-signature"></i>
        <p>Pedidos de Contratação</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= SERVERURL ?>formacao/pagamento_busca" class="nav-link" id="pagamento_busca">
        <i class="fas fa-file-invoice-dollar"></i>
        <p>Pagamento</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= SERVERURL ?>formacao/conclusao_busca" class="nav-link" id="conclusao_busca">
        <i class="fas fa-archive"></i>
        <p>Concluir Processo</p>
    </a>
</li>
<?php
}
?>