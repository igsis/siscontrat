<?php
require_once "./controllers/FormacaoController.php";
$pfObj = new PessoaFisicaController();

$lista_pf = $pfObj->listaPf(true);

?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Pessoas Físicas - CAPAC</h1>
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
                        <h3 class="card-title">Listagem de Pessoas Físicas</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabela" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>Data Nascimento</th>
                                <th>E-mail</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($lista_pf as $pf): ?>
                                <tr>
                                    <td><?= $pf->nome?></td>
                                    <td><?= $pf->cpf?></td>
                                    <td><?= $pfObj->dataParaBR($pf->data_nascimento)?></td>
                                    <td><?= $pf->email?></td>
                                    <td>
                                        <?php if($pfObj->getCPF($pf->cpf)->rowCount() == 0): ?>
                                            <a href="<?= SERVERURL . "formacao/pf_cadastro&capac=" . $pfObj->encryption($pf->id)?>" class="btn bg-gradient-info btn-sm" >
                                                Importar  &nbsp;
                                            </a>
                                        <?php else : ?>
                                            <a href="<?= SERVERURL . "formacao/pf_cadastro&id=" . $pfObj->encryption($pfObj->recuperaIdPfSis($pf->id))?>" class="btn bg-gradient-warning btn-sm" >
                                                Importado
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>Data Nascimento</th>
                                <th>E-mail</th>
                                <th>Ação</th>
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

