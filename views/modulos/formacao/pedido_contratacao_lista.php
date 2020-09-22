<?php
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Dados Para Contratação</h1>
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
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Listagem</h3>
                        <div class="card-tools">
                            <!-- button with a dropdown -->
                            <a href="<?= SERVERURL ?>formacao/pf_cadastro" class="btn btn-success btn-sm" >
                                <i class="fas fa-file-excel"></i> Exportar para Excel
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabela" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Protocolo</th>
                                    <th>Processo</th>
                                    <th>Proponente</th>
                                    <th>Local</th>
                                    <th>Ano</th>
                                    <th>Verba</th>
                                    <th>Status</th>
                                    <th width="15%">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>20200320.00001-F</td>
                                    <td>1111.1111/1111111-1</td>
                                    <td>Diego</td>
                                    <td>Biblioteca Brito Broca - Biblioteca Camila Cerqueira César - Biblioteca Chácara do Castelo</td>
                                    <td>2020</td>
                                    <td>Centros Culturais e Teatros 6391</td>
                                    <td>A1 (Aprovado na 1a fase)</td>
                                    <td>
                                        <button type="submit" class="btn bg-gradient-primary btn-sm">
                                            <i class="fas fa-user-edit"></i> Editar
                                        </button>
                                        <button type="submit" class="btn bg-gradient-danger btn-sm">
                                            <i class="fas fa-trash"></i> Apagar
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Protocolo</th>
                                    <th>Processo</th>
                                    <th>Proponente</th>
                                    <th>Local</th>
                                    <th>Ano</th>
                                    <th>Verba</th>
                                    <th>Status</th>
                                    <th width="15%">Ações</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->

                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<div class="modal fade" id="arquivarEdital" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Arquivar Edital</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p> </p>
            </div>
            <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/fomentoAjax.php" role="form" data-form="save">
                <input type="hidden" name="_method" value="arquivaEdital">
                <input type="hidden" name="id" id="id" value="">
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Arquivar</button>
                </div>
                <div class="resposta-ajax"></div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>