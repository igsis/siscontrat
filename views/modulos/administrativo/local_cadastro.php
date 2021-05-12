<?php
require_once "./controllers/AdministrativoController.php";

$id = isset($_GET['id']) ? $_GET['id'] : null;
$instituicao_id = isset($_GET['instituicao_id']) ? $_GET['instituicao_id'] : null;

$localObj = new AdministrativoController();

if ($id) {
    $local = $localObj->recuperaLocal($id);
    $espacos = $localObj->listaEspaco($id);
}
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cadastro de instituição</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Dados</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal formulario-ajax" method="POST"
                          action="<?= SERVERURL ?>ajax/administrativoAjax.php" role="form"
                          data-form="<?= isset($local->id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method"
                               value="<?= isset($local->id) ? "editaLocal" : "cadastraLocal" ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" id="local_id" value="<?= $local->id ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <input type="hidden" name="instituicao_id" value="<?= $instituicao_id ?>">
                            <div class="row">
                                <div class="col">
                                    <label for="local">Local: *</label>
                                    <input type="text" class="form-control" id="local" name="local"
                                           placeholder="Digite o local"
                                           value="<?= isset($local) ? $local->local : "" ?>" required>
                                </div>
                                <div class="col">
                                    <label for="cep">CEP: *</label>
                                    <input type="text" class="form-control" id="cep" name="cep" maxlength="9"
                                           onkeypress="mask(this, '#####-###')" placeholder="Digite o local"
                                           value="<?= isset($local) ? $local->cep : "" ?>" required>
                                </div>
                                <div class="col">
                                    <label for="zona">Zona: *</label>
                                    <select name="zona_id" id="zona" class="form-control" required>
                                        <option value="">Selecione uma opção</option>
                                        <?= $localObj->geraOpcao('zonas', isset($local) ? $local->zona_id : "") ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="logradouro">Rua: *</label>
                                    <input class="form-control" name="logradouro" id="rua" type="text"
                                           value="<?= isset($local) ? $local->logradouro : '' ?>" readonly>
                                </div>
                                <div class="col">
                                    <label for="numero">Número: *</label>
                                    <input class="form-control" name="numero" id="numero" type="number"
                                           value="<?= isset($local) ? $local->numero : '' ?>" required>
                                </div>
                                <div class="col">
                                    <label for="complemento">Complemento:</label>
                                    <input class="form-control" name="complemento" id="complemento"
                                           value="<?= isset($local) ? $local->complemento : '' ?>" type="text">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="bairro">Bairro: *</label>
                                    <input type="text" class="form-control" name="bairro" id="bairro"
                                           placeholder="Digite o Bairro" maxlength="80" readonly
                                           value="<?= isset($local) ? $local->bairro : '' ?>">
                                </div>
                                <div class="col">
                                    <label for="cidade">Cidade: *</label>
                                    <input type="text" class="form-control" name="cidade" id="cidade"
                                           placeholder="Digite a cidade" maxlength="50" readonly
                                           value="<?= isset($local) ? $local->cidade : '' ?>">
                                </div>
                                <div class="col-2">
                                    <label for="uf">Estado: *</label>
                                    <input type="text" class="form-control" name="uf" id="estado" maxlength="2"
                                           readonly value="<?= isset($local) ? $local->uf : '' ?>">
                                </div>
                                <div class="col">
                                    <label for="estado">Subprefeitura: *</label>
                                    <select name="subprefeitura_id" class="form-control select2bs4" required>
                                        <option value="">Selecione uma opção</option>
                                        <?= $localObj->geraOpcao('subprefeituras', isset($local) ? $local->subprefeitura_id : "") ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info float-right">Gravar</button>
                        </div>
                        <!-- /.card-footer -->
                        <div class="resposta-ajax">

                        </div>
                    </form>

                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->

    <?php if ($id): ?>
        <div class="d-flex flex-row-reverse m-3">
            <div class="col-3">
                <a href="<?= SERVERURL ?>administrativo/local_cadastro" class="btn btn-success btn-block">Adicionar novo
                    Local</a>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Horizontal Form -->
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Locais</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <div class="card-body">
                                        <table id="tabela" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>Espaço</th>
                                                <th>Ação</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($espacos as $espaco): ?>

                                                <tr>
                                                    <td><?= $espaco->espaco ?></td>
                                                    <td>
                                                        <a href="<?= SERVERURL . "administrativo/espaco_cadastro&id=" . $localObj->encryption($espaco->id) ?>"
                                                           class="btn btn-sm btn-primary"><i class="fas fa-edit"></i>
                                                            Editar</a>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>Espaço</th>
                                                <th>Ação</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">

                                    </div>
                                    <!-- /.card-footer -->

                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
        </div>
    <?php endif; ?>
</div>
<script src="../views/dist/js/cep_api.js"></script>