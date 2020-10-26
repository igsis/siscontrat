<?php
require_once "./models/DbModel.php";
$dbObj = new DbModel();
$ano = $dbObj->consultaSimples("SELECT ano FROM form_cadastros ORDER BY ano ASC LIMIT 0,1", TRUE)->fetchObject()->ano;
?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Exportar Inscritos</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Escolha o ano</h3>
                    </div>
                    <form class="form-horizontal" action="<?= SERVERURL ?>pdf/formacao_capac_inscritos_excel.php" method="GET" target="_blank">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md">
                                    <div class="row">
                                        <div class="form-group col-md">
                                            <label for="sigla">Ano: *</label>
                                            <input type="number" class="form-control" name="ano" required min="<?= $ano ?>"
                                                   data-mask="9999">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" name="cadastra" id="cadastra"
                                    class="btn btn-success btn-sm float-right">
                                <i class="fas fa-file-excel"></i> Exportar para Excel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>