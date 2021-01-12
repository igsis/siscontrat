<?php
require_once "./controllers/OficinaController.php";

$oficinaObj = new OficinaController();

if (isset($_POST['busca'])) {
    $dados = $_POST;

    array_splice($dados, 0, 1);

    $resultados = $oficinaObj->recuperaOficinaCapac($dados);

}

?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
<!--                <h1 class="m-0 text-dark">Buscar no CAPAC</h1>-->
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="card card-info">
                    <div class="card-header">
                        <h5>Buscar no CAPAC</h5>
                    </div>
                    <!-- /.card-header -->
                    <form method="post">
                        <input type="hidden" name="busca" value="1">
                        <div class="card-body">
                            <div class="row d-flex align-items-center">
                                <div class="col-md-4 col-sm-12 form-group">
                                    <label for="protocolo">Protocolo de Cadastro no CAPAC:</label>
                                    <input type="text" name="protocolo" id="protocolo" class="form-control" data-mask="00000000.00000-E" maxlength="15" value="<?= isset($dados) ? $dados['protocolo'] : '' ?>">
                                </div>
                                <div class="col-md-4 col-sm-12 form-group">
                                    <label for="nome">Nome do Evento:</label>
                                    <input type="text" name="nome_evento" id="nome_evento" class="form-control" value="<?= isset($dados) ? $dados['nome_evento'] : '' ?>">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="publico">Público:</label>
                                    <select name="publico" id="publico" class="form-control">
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                            $oficinaObj->geraOpcao('publicos', isset($dados) ? $dados['publico'] : '');
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button id="pesquisa" class="btn btn-info float-right">Pesquisar</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <?php if (isset($_POST['busca'])): ?>
            <div class="row">
                <div class="col-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h5>Resultados</h5>
                        </div>
                        <div class="card-body overflow-auto">
                            <table id="tabela" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Protocolo</th>
                                        <th>Nome do Evento</th>
                                        <th>Data do cadastro</th>
                                        <th>Público</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($resultados as $resultado){
                                        ?>
                                        <tr>
                                            <td><?= $resultado->protocolo ?></td>
                                            <td><?= $resultado->nome_evento ?></td>
                                            <td><?= $resultado->data_cadastro ?></td>
                                            <td><?= $resultado->publico ?></td>
                                            <td class="text-center">
                                                <a href="#" class="btn btn-success"> Visualizar </a>
                                            </td>
                                        </tr>
                                    <?php
                                    } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Protocolo</th>
                                        <th>Nome do Evento</th>
                                        <th>Data do cadastro</th>
                                        <th>Público</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->