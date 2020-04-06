<?php
require_once "./controllers/AdministrativoController.php";
$verbaObj = new AdministrativoController();

$verbas = $verbaObj->listaVerbas();
?>

<div class="content">
    <div class="content-header">
        <div class="row">
            <div class="col-md-9">
                <h1>Lista de Verbas</h1>
            </div>
            <div class="col-md-3">
                <a href="verbas_cadastro">
                    <button class="btn btn-success float-right">Adicionar verba</button>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header">
                    <h4 class="card-title">Listagem</h4>
                </div>
                <div class="card-body">
                    <table id="tabela" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Verba</th>
                            <th width="5%">Editar</th>
                            <th width="5%">Excluir</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($verbas as $verba): ?>
                            <tr>
                                <td><?= $verba->verba ?></td>
                                <td align="center">
                                    <a href="<?= SERVERURL . "administrativo/verbas_cadastro&id=" . $verbaObj->encryption($verba->id) ?>">
                                        <button type="button" class="btn btn-sm btn-primary btn-block"><i
                                                class="fas fa-edit"></i></button>
                                    </a>
                                </td>
                                <td>
                                    <form class="form-horizontal formulario-ajax" method="POST"
                                          action="<?= SERVERURL ?>ajax/administrativoAjax.php" role="form"
                                          data-form="update">
                                        <input type="hidden" name="_method" value="deletarVerba">
                                        <input type="hidden" name="idVerba"
                                               value="<?= $verbaObj->encryption($verba->id) ?>">
                                        <button type="submit" class="btn btn-sm btn-danger btn-block"><i
                                                class="fas fa-trash"></i></button>
                                        <div class="resposta-ajax"></div>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>

                        <tfoot>
                        <tr>
                            <th>Verba</th>
                            <th width="5%">Editar</th>
                            <th width="5%">Excluir</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="card-footer">
                </div>
            </div>
        </div>
    </div>
</div>
