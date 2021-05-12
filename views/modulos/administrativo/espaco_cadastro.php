<?php
require_once "./controllers/AdministrativoController.php";

$id = isset($_GET['id']) ? $_GET['id'] : null;
$local_id = $_GET['local_id'];

$espacObj = new AdministrativoController();
if ($id){
    $espaco = $espacObj->recuperaEspaco($id);
}
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cadastro de Local</h1>
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
                          data-form="<?= isset($espaco->id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method"
                               value="<?= isset($espaco->id) ? "editaLocal" : "cadastraLocal" ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" id="local_id" value="<?= $espaco->id ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <input type="hidden" name="instituicao_id" value="<?= $local_id ?>">
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
