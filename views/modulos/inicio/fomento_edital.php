<?php
if (isset($_SESSION)) {
    unset($_SESSION['origem_id_s']);
    unset($_SESSION['pedido_id_s']);
    unset($_SESSION['modulo_s']);
    unset($_SESSION['edital_s']);
}
require_once "./controllers/FomentoController.php";
$fomentoObj = new FomentoController();
?>
<div class="background">
<div class="content-header bg-dark mb-5 elevation-5">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center justify-content-around">
            <div class="col-sm-10 bg-dark">
                <a href="<?= SERVERURL ?>" class="brand-link">
                    <img src="<?= SERVERURL ?>views/dist/img/AdminLTELogo.png" alt="CAPAC Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light"><?= NOMESIS ?> - Fomentos</span>
                </a>
            </div>
            <div class="col-sm-1 mr-5">
                <img src="<?= SERVERURL ?>views/dist/img/CULTURA_PB_NEGATIVO_HORIZONTAL.png" alt="logo cultura">
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="content">
    <div class="container-fluid">
        <?php
        foreach ($fomentoObj->listaFomentos() as $fomento){
            ?>
            <div class="row">
                <div class="offset-1 col-10">
                    <div class="card card-dark card-outline collapsed-card elevation-5">
                        <div class="card-header">
                            <h5 class="m-0"><?= $fomento['titulo'] ?></h5>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <?= nl2br($fomento['descricao']) ?>
                        </div>
                        <div class="card-footer">
                            <a href="login&modulo=8&edital=<?= MainModel::encryption($fomento['id']) ?>" class="small-box-footer">
                                Inscreva-se <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>

                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
            <?php
        }
        ?>
    </div><!-- /.container-fluid -->
</div>
</div>