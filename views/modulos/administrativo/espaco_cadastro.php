<?php
require_once "./controllers/AdministrativoController.php";

$id = isset($_GET['id']) ? $_GET['id'] : null;
$local_id = $_GET['local_id'];

$espacObj = new AdministrativoController();
if ($id) {
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
                          data-form="<?= isset($local->id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= isset($espaco->id) ? "editaEspaco" : "cadastraEspaco" ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" id="espaco_id" value="<?= $espacObj->encryption($espaco->id) ?>">
                        <?php endif; ?>
                        <input type="hidden" name="local_id" id="local_id" value="<?= $local_id ?>">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <label for="espaco">Espaço:*</label>
                                    <input type="text" class="form-control" name="espaco" required value="<?= isset($espaco) ? $espaco->espaco : "" ?>">
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
</div>