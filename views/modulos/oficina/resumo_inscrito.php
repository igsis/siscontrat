<?php

require_once "./controllers/OficinaController.php";

$oficinaObj = new OficinaController();

$id = $_GET['id'];

$oficina =  $oficinaObj->recuperaOficinaCapac($id);

?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Resumo oficina CAPAC</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="text-center">
                    <span class="font-weight-bold">Cadastrado enviado em:</span> <?= date("d/m/Y h:i", strtotime($oficina->data_envio)) ?>
                </div>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Dados pessoais</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col"><b>Nome:</b> <?php //$oficina->nome ?></div>
                            <div class="col"><b>Nome Artístico:</b> <?php //$oficina->nome_artistico ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col"><b>RG:</b> <?php //$oficina->rg ?></div>
                            <div class="col"><b>CPF:</b> <?php //$oficina->cpf ?></div>
                            <div class="col"><b>CCM:</b> <?php //$oficina->ccm ?></div>
                        </div>
                        <div class="row">
                            <div class="col"><b>Data de nascimento:</b> <?php //date("d/m/Y", strtotime($oficina->data_nascimento)) ?></div>
                            <div class="col"><b>Nacionalidade:</b> <?php //$oficina->nacionalidade ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md"><b>E-mail:</b> <?php //$oficina->email ?></div>
                            <div class="col"><b>Telefones:</b> <?php //$telefones ?></div>
                        </div>
                        <div class="row">
                            <div class="col"><b>NIT:</b> <?php //$oficina->nit ?></div>
                            <div class="col"><b>DRT:</b> <?php //$oficina->drt ?></div>
                            <div class="col"><b>Grau Instituição:</b> <?php //$oficina->grau_instrucao ?></div>
                        </div>
                        <div class="row">
                            <div class="col"><b>Etnia:</b> <?php //$oficina->etnia ?></div>
                            <div class="col"><b>Gênero:</b> <?php //$oficina->genero ?></div>
                            <div class="col"><b>Trans:</b> <?php //$oficina->trans ?></div>
                            <div class="col"><b>PCD:</b> <?php //$oficina->pcd ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <b>Endereço:</b> <?php //$oficina->logradouro . ", " . $oficina->numero . " " . $oficina->complemento . " " . $oficina->bairro . " - " . $oficina->cidade . "-" . $oficina->uf . " CEP: " . $oficina->cep ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col"><b>Banco:</b> <?php //$oficina->banco ?></div>
                            <div class="col"><b>Agência:</b> <?php //$oficina->agencia ?></div>
                            <div class="col"><b>Conta:</b> <?php //$oficina->conta ?></div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Dados oficina</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <span class="font-weight-bold">Protocolo: </span> <?php $oficina->protocolo ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <span class="font-weight-bold">Nome do Evento: </span> <?= $oficina->nome_evento ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <span class="font-weight-bold">Espaço Público: </span> <?= $oficina->espaco_publico ? 'Sim' : 'Não' ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <span class="font-weight-bold">Linguagem: </span> <?= $oficina->linguagem ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <span class="font-weight-bold">Sub-linguagem: </span> <?= $oficina->sublinguagem ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <span class="font-weight-bold">Sinopse: </span>
                                <p><?= $oficina->sinopse ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <span class="font-weight-bold">Tipo Contratação: </span> <?= $oficina->tipo_contratacao ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <span class="font-weight-bold">Integrantes: </span> <?= $oficina->integrantes ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <span class="font-weight-bold">Links: </span> <?= $oficina->links ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <span class="font-weight-bold">Data Inicio: </span> <?= $oficina->data_inicio ?> <span class="font-weight-bold">Data Fim: </span> <?= $oficina->data_fim ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <span class="font-weight-bold">Dia execução 1: </span> <?= $oficinaObj->exibeExecucaoDia($oficina->execucao_dia1_id) ?> <span class="font-weight-bold">Dia execução 2: </span> <?= $oficinaObj->exibeExecucaoDia($oficina->execucao_dia2_id) ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <span class="font-weight-bold">Modalidade: </span> <?= $oficina->modalidade ?>
                            </div>
                        </div>


                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->

        <!-- /.row -->
        <div class="card-footer">
            <a href="<?= SERVERURL ?>formacao/listar_inscritos" class="btn btn-default float-left">Voltar</a>
            <form class="formulario-ajax" action="<?= SERVERURL ?>ajax/formacaoAjax.php" method="POST">
                <input type="hidden" name="_method" value="importarInscrito">
                <input type="hidden" name="id" value="<?= $oficinaObj->encryption($oficina->id) ?>">
                <button class="btn btn-info float-right" id="importar">Importar Inscrito</button>
                <div class="resposta-ajax"></div>
            </form>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->