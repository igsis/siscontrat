<?php

require_once "./controllers/FormacaoController.php";

$formacaoObj = new FormacaoController();

$inscrito = $formacaoObj->recuperaInscrito($_GET['id']);
$telefones = $formacaoObj->recuperaTelInscrito($inscrito->pessoa_fisica_id);

var_dump($inscrito, $telefones);

?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Resumo Inscrito CAPAC</h1>
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
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <ul class="list-group">
                                    <li class="list-group-item bg-secondary disabled color-palette">
                                        <span class="font-weight-bold">Informações Pessoais</span>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">Nome:</span> <?= $inscrito->nome ?>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">Nome artístico: </span> <?= $inscrito->nome_artistico ?>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">Data de Nascimento: </span> <?= $inscrito->data_nascimento ?>
                                    </li>
                                    <li class="list-group-item">
                                        <?php if ($inscrito->rg): ?>
                                            <span class="font-weight-bold">RG: </span> <?= $inscrito->rg ?>
                                        <?php else: ?>
                                            <span class="font-weight-bold">Passaporte: </span> <?= $inscrito->passaporte ?>
                                        <?php endif; ?>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">CPF: </span> <?= $inscrito->nome ?>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">CCM: </span> <?= $inscrito->ccm ?>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">Email: </span> <?= $inscrito->email ?>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">Telefone: </span> <?= $telefones ?>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">Nacionalidade: </span> <?= $inscrito->nacionalidade ?>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">Programa Selecionado: </span> <?= $inscrito->programa ?>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <ul class="list-group">
                                    <li class="list-group-item bg-secondary disabled color-palette">
                                        <span class="font-weight-bold">Endereço</span>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">CEP:</span> <?= $inscrito->cep ?>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">Logradouro: </span> <?= $inscrito->logradouro ?>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">Número: </span> <?= $inscrito->numero ?>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">Complemento: </span> <?= $inscrito->complemento ?>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">Bairro: </span> <?= $inscrito->bairro ?>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">Cidade: </span> <?= $inscrito->nome ?>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">Estado: </span> <?= $inscrito->uf ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-sm-6">
                                <ul class="list-group">
                                    <li class="list-group-item bg-secondary disabled color-palette">
                                        <span class="font-weight-bold">Informações Complementares:</span>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">Etnia:</span>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">Etnia:</span>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">Etnia:</span>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">Etnia:</span>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">Etnia:</span>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
