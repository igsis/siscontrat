<?php
require_once "./controllers/AdministrativoController.php";

$id = isset($_GET['id']) ? $_GET['id'] : null;
$instituicaoObj = new AdministrativoController();

if ($id){
    $instituicao = $instituicaoObj->recuperaInstituicao($id);
    $locais = $instituicaoObj->listaLocal($id);
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
                    data-form="<?= ($id) ? "update" : "save" ?>">
                    <input type="hidden" name="_method" value="<?= ($id) ? "editaInstituicao" : "cadastraInstituicao" ?>">
                    <?php if ($id): ?>
                        <input type="hidden" name="id" id="instituicao_id" value="<?= $id ?>">
                    <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <label for="instituicao">Instituição: *</label>
                                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite a instituição" value="<?=($instituicao) ? $instituicao->nome : ""?>" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="sigla">Sigla: *</label>
                                    <input type="text" class="form-control" id="sigla" name="sigla" placeholder="Digite a sigla" value="<?=($instituicao) ? $instituicao->sigla : ""?>" required>
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
            <a href="<?= SERVERURL ?>administrativo/local_cadastro&instituicao_id=<?= $instituicaoObj->encryption($instituicao->id) ?>" class="btn btn-success btn-block">Adicionar novo Local</a>
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
                                            <th>Local</th>
                                            <th>Logradouro</th>
                                            <th>Subprefeitura</th>
                                            <th>Ação</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($locais as $local): ?>

                                            <tr>
                                                <td><?= $local->local ?></td>
                                                <td><?= $local->logradouro ?></td>
                                                <td><?= $local->subprefeitura ?></td>
                                                <td>
                                                    <a href="<?= SERVERURL . "administrativo/local_cadastro&id=" . $instituicaoObj->encryption($local->id) . "&instituicao_id=" . $id ?>"
                                                       class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Editar</a>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>Local</th>
                                            <th>Logradouro</th>
                                            <th>Subprefeitura</th>
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

<script type="application/javascript">
    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#instituicoes').addClass('active');
    })
</script>