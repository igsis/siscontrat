<?php
if (isset($_GET['id'])) {
    $_SESSION['projeto_s'] = $id = $_GET['id'];
} elseif (isset($_SESSION['projeto_s'])){
    $id = $_SESSION['projeto_s'];
} else {
    $id = null;
}

require_once "./controllers/ProjetoController.php";
$objProjeto = new ProjetoController();

if ($id) {
    $projeto = $objProjeto->recuperaProjeto($id);
}
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cadastro do projeto</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
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
                        <h3 class="card-title">Dados</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/projetoAjax.php" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editar" : "cadastrar" ?>">
                        <input type="hidden" name="pagina" value="fomentos">
                        <input type="hidden" name="usuario_id" value="<?= $_SESSION['usuario_id_s'] ?>">
                        <input type="hidden" name="pessoa_tipo_id" value="2">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" value="<?= $id ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="instituicao">Instituição responsável: *</label>
                                    <input type="text" class="form-control" id="instituicao" name="instituicao" maxlength="80" value="<?= $projeto['instituicao'] ?? null ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="usuario_nome">Responsável pela inscrição: *</label>
                                    <input type="text" class="form-control" id="usuario_nome" name="usuario_nome" value="<?= $_SESSION['nome_s'] ?>" disabled>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="site">Site: *</label>
                                    <input type="text" class="form-control" id="site" name="site"
                                           value="<?= $projeto['site'] ?? null ?>" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="valor_projeto">Valor do projeto: *</label>
                                    <input type="text" class="form-control" id="valor_projeto" name="valor_projeto"
                                           value="<?= isset($projeto['valor_projeto']) ? $objProjeto->dinheiroParaBr($projeto['valor_projeto']) : null ?>"
                                           onKeyPress="return(moeda(this,'.',',',event))" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="duracao">Duração: (em meses) *</label>
                                    <input type="number" class="form-control" id="duracao" name="duracao" value="<?= $projeto['duracao'] ?? null ?>" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md">
                                    <label for="nucleo_artistico">Núcleo artístico: *</label>
                                    <textarea class="form-control" rows="5" id="nucleo_artistico" name="nucleo_artistico" required><?= $projeto['nucleo_artistico'] ?? null ?></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md">
                                    <label for="representante_nucleo">Representante do núcleo: *</label>
                                    <input type="text" class="form-control" id="representante_nucleo" name="representante_nucleo" maxlength="100" value="<?= $projeto['representante_nucleo'] ?? null ?>" required>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info float-right">Gravar</button>
                        </div>
                        <!-- /.card-footer -->
                        <div class="resposta-ajax"></div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
<script type="application/javascript">
    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#projeto').addClass('active');
    })
</script>