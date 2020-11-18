<?php
require_once "./controllers/PessoaFisicaController.php";
$pfObj = new PessoaFisicaController();

$id = $_GET['id'];

$dados = $pfObj->comparaPf($_GET['id']);
?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Importar do Capac - Dados Divergentes</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card card-info card-outline">
            <div class="card-header">
                <h3 class="card-title"><?= $dados['pf_nome'] ?> - <small>CPF: <?= $dados['pf_cpf'] ?></small></h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-success card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Capac</h3>
                                <div class="card-tools">
                                    <span class="badge badge-warning">Última atualização: <?= $pfObj->dataParaBR($dados['dadosCapac']['pf_ultima_atualizacao']) ?></span>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php foreach ($dados['dadosCapac'] as $key => $dado) :
                                    if ($key == "pf_ultima_atualizacao") {continue;}
                                    $label = ucwords(preg_replace('/_/', " ", substr($key, 3))); ?>
                                    <div class="form-group">
                                        <label><?= $label ?>:</label>
                                        <div class="input-group">
                                            <?php $pfObj->recuperaDadoPorId($key, $dado, false) ?>
                                            <input type="text" name="message" class="form-control" id="<?=$key?>Cpc" value="<?=$dado?>" readonly>
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-success" onclick="passaValor('<?=$key?>')">
                                                    <i class="fas fa-arrow-alt-circle-right"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-primary card-outline">
                            <form class="form-horizontal formulario-ajax" method="POST" role="form"
                                  action="<?= SERVERURL ?>ajax/formacaoAjax.php" data-form="update">
                                <input type="hidden" name="_method" value="editarPF">
                                <input type="hidden" name="pagina" value="formacao/pf_cadastro">
                                <input type="hidden" name="id" value="<?=$pfObj->encryption($dados['id'])?>">
                                <?php if (!isset($dados['dadosSis']['pf_nome'])): ?>
                                    <input type="hidden" name="pf_nome" value="<?= $dados['pf_nome'] ?>">
                                <?php endif ?>
                                <div class="card-header">
                                    <h3 class="card-title">Siscontrat</h3>
                                    <div class="card-tools">
                                        <span class="badge badge-warning">Última atualização: <?= $pfObj->dataParaBR($dados['dadosSis']['pf_ultima_atualizacao']) ?></span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php foreach ($dados['dadosSis'] as $key => $dado) :
                                        if ($key == "pf_ultima_atualizacao") {continue;}
                                        $label = ucwords(preg_replace('/_/', " ", substr($key, 3))); ?>
                                        <div class="form-group">
                                            <label><?= $label ?>:</label>
                                            <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <button type="button" class="btn btn-danger" onclick="resetaValor('<?=$key?>')">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </span>
                                                <input type="text" name="<?= $key ?>" class="form-control"
                                                       id="<?= $key ?>Sis"
                                                       data-valor="<?= $dado ?>" value="<?= $dado ?>" readonly>
                                                <?php $pfObj->recuperaDadoPorId($key, $dado) ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-success float-right">Atualizar Dados</button>
                                </div>
                                <div class="resposta-ajax"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function passaValor(campo) {
        let campoCpc = '#' + campo + "Cpc";
        let campoSis = '#' + campo + "Sis";

        $(campoSis).val($(campoCpc).val())
    }

    function resetaValor(campo) {
        let campoSis = '#' + campo + "Sis";
        let valorOriginal = $(campoSis).data("valor");

        $(campoSis).val(valorOriginal)
    }
</script>
