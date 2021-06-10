<?php
require_once "./controllers/EventoController.php";

$eventObj = new EventoController();

if (isset($_POST['busca'])) {
    $dados = $_POST;

    array_splice($dados, 0, 1);
    $eventos = $eventObj->buscarEventos($dados);
}else {
    $eventos = $eventObj->buscarEventos();
}

?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Listar Eventos</h1>
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
                        <h5>Formulario de pesquisa</h5>
                    </div>
                    <!-- /.card-header -->
                    <form method="post">
                        <input type="hidden" name="busca" value="1">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-sm-12">
                                    <label for="id">Protocolo do Evento</label>
                                    <input type="text" name="id" id="id" class="form-control"
                                           placeholder="Digite o codigo do Evento">
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <label for="id">Nome do Evento:</label>
                                    <input type="text" class="form-control" id="nome_evento" name="nome_evento" placeholder="Digite o nome do evento">
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <label for="status_id"> Status do evento: </label>
                                    <select name="status_id" id="status_id" class="form-control">
                                        <option value="">Selecione uma opção</option>
                                        <?= $eventObj->geraOpcao("evento_status", "") ?>
                                    </select>

                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label for="responsavel">Fiscal, suplente ou usuario que cadastrou o evento:</label>
                                    <select name="responsavel" id="responsavel"  class="form-control">
                                        <option value="">Selecione uma Opção</option>
                                        <?=  $eventObj->geraOpcao("usuarios",'','1'); ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="projeto_especial_id">Tipo de Projeto:</label>
                                    <select name="projeto_especial_id" id="projeto_especial_id" class="form-control">
                                        <option value="">Selecione uma opção</option>
                                        <?= $eventObj->geraOpcao("projeto_especiais","","1") ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button id="pesquisa" class="btn btn-info float-right">Pesquisar</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h5>Resultados</h5>
                    </div>
                    <div class="card-body overflow-auto">
                        <table id="tabela" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Protocolo</th>
                                <th>Processo</th>
                                <th>Nome do Evento</th>
                                <th>Fiscal / Suplente</th>
                                <th>Local</th>
                                <th>Período</th>
                                <th>Valor do Contrato</th>
                                <th>Chamados</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody style="text-align: center">
                            <?php foreach ($eventos as  $evento):
                                $id = $eventObj->encryption($evento->id);
                                ?>
                                <tr>
                                    <td><?= $evento->protocolo ?></td>
                                    <td><?= $evento->numero_processo ?></td>
                                    <td><?= $evento->nome_evento ?></td>
                                    <td><?= $evento->responsaveis ?></td>
                                    <td><button class="btn-sm btn-secondary" value="<?= $id ?>"> Locais </button></td>
                                    <td><?= $eventObj->retornaPeriodo($id) ?></td>
                                    <td><?= $eventObj->dinheiroParaBr($evento->valor_total) ?></td>
                                    <td><button class="btn btn-info btn-sm"><?= $eventObj->chamadosEventos($id, true) ?></button></td>
                                    <td><a class="btn btn-primary btn-md" href="<?= SERVERURL ?>curadoria/resumo&id=<?= $id ?>">Visualizar</a></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Protocolo</th>
                                <th>Processo</th>
                                <th>Nome do Evento</th>
                                <th>Fiscal / Suplente</th>
                                <th>Local</th>
                                <th>Período</th>
                                <th>Valor do Contrato</th>
                                <th>Chamados</th>
                                <th></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->