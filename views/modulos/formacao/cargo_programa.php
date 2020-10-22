<?php
require_once "./controllers/FormacaoController.php";
$formObj = new FormacaoController();

$dados = $formObj->listaProgramas();

$link_api = SERVERURL . "api/lista_cargo_programas.php";
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Vincular cargos aos programas</h1>
            </div>
        </div>
    </div>
</div>


<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Listagem</h3>
                    </div>
                    <div class="card-body">
                        <table id="tabela" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Programas</th>
                                <th style="width: 15%">Vincular Novo Cargo</th>
                                <th style="width: 15%">Desvincular Cargo</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($dados as $dado): ?>
                                <tr>
                                    <td><?= $dado['programa'] ?></td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-block" id="btnModalVincula"
                                                onclick="listarCargo(<?= $dado['id'] ?>); mudarBotaoVincular()"
                                                data-toggle="modal" data-target="#modalCargos">
                                            <i class="fas fa-plus"></i> Vincular
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-block" id="btnModalDesvincula"
                                                onclick="listarCargoCadastrados(<?= $dado['id'] ?>); mudarBotaoDesvincular()"
                                                data-toggle="modal" data-target="#modalCargos">
                                            <i class="fas fa-trash"></i> Desvincular
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Programa</th>
                                <th style="width: 15%">Vincular Novo Cargo</th>
                                <th style="width: 15%">Desvincular Cargo</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalCargos" class="modal modal fade in" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Lista de Cargos</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="col-md">
                    <form action="<?= SERVERURL ?>ajax/formacaoAjax.php" class="form-horizontal formulario-ajax"
                          method="POST">
                        <input type="hidden" id="metodo" name="_method" value="">
                        <label for="formacao_cargo_id">Cargo: *</label>
                        <select name="formacao_cargo_id" id="cargo" class="form-control select2bs4" required>
                            <option value="">Selecione um cargo...</option>
                        </select>
                        <input type="hidden" name="programa_id" id="programa_id" value="">
                        <button type='submit' id='btnVincula' class='btn btn-success float-right'>Vincular</button>
                        <button type='submit' id='btnDesvincula' class='btn btn-danger float-right'>Desvincular</button>
                        <div class="resposta-ajax"></div>
                    </form>
                </div>
                <table class="table table-striped table-bordered">
                    <tbody id="conteudoModal">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    const link = `<?=$link_api?>`;
    let btnVincula = $('#btnVincula');
    let btnDesvincula = $('#btnDesvincula');

    function listarCargoCadastrados(id) {
        $('#programa_id').attr('value', id);
        $('#modalCargos').find('#conteudoModal').empty();
        $.ajax({
            method: "GET",
            url: link + "?id=" + id + "&select=1"
        })
            .done(function (cargos) {
                $('#cargo option').remove();
                $('#cargo').append('<option value="">Selecione um cargo...</option>');
                for (const cargo of cargos) {
                    $('#cargo').append(`<option value='${cargo.id}'>${cargo.cargo}</option>`);
                }
            })
    }

    function listarCargo(id) {
        $('#programa_id').attr('value', id);
        $('#modalCargos').find('#conteudoModal').empty();
        $.ajax({
            method: "GET",
            url: link + "?todos=1"
        })
            .done(function (cargos) {
                $('#cargo option').remove();
                $('#cargo').append('<option value="">Selecione um cargo...</option>');
                $('#modalCargos').find('#conteudoModal').append(`<tr><td>Cargos vinculados a este programa</td></tr>`);
                for (const cargo of cargos) {
                    $('#cargo').append(`<option value='${cargo.id}'>${cargo.cargo}</option>`);
                    $('#modalCargos').find('#conteudoModal').append(` ${cargo.cargo} <br>`);
                }
            });
    }

    function mudarBotaoDesvincular() {
        btnVincula.attr('disabled', true);
        btnVincula.hide();
        btnDesvincula.show();
        btnDesvincula.attr('disabled', false);
        $('#metodo').attr('value', 'desvincularCargo');
    }

    function mudarBotaoVincular() {
        btnDesvincula.attr('disabled', true);
        btnDesvincula.hide();
        btnVincula.show();
        btnVincula.attr('disabled', false);
        $('#metodo').attr('value', 'vinculaCargo')
    }
</script>

