<?php

require_once "./controllers/FormacaoController.php";
require_once "./controllers/PessoaFisicaController.php";
require_once "./controllers/ArquivoController.php";

$formacaoObj = new FormacaoController();
$pfObjeto = new PessoaFisicaController();
$arquivosObj =  new ArquivoController();

$id = $_GET['id'];
$inscrito = $formacaoObj->recuperaInscrito($id);
$telefones = $formacaoObj->recuperaTelInscrito($inscrito->pessoa_fisica_id);
$arquivos = $arquivosObj->listarArquivosCapac($id)->fetchAll(PDO::FETCH_OBJ);
;
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-10">
                <h1 class="m-0 text-dark">Resumo Inscrito CAPAC</h1>
            </div><!-- /.col -->
            <div class="col-sm-2">
                <a href="<?= SERVERURL ?>pdf/formacao_resumo_inscrito.php?id=<?= $formacaoObj->encryption($inscrito->id) ?>" target="_blank" class="btn bg-gradient-primary btn-sm btn-block rounded-bottom"><i class="fas fa-file-pdf"></i> Imprimir</a>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row mb-5">
            <div class="col">
                <div class="text-left">
                    <a href="#" target="_blank" class="btn btn-sm btn-primary"> Gerar PDF</a>
                </div>
            </div>
            <div class="col">
                <div class="text-right">
                    <span class="font-weight-bold">Cadastrado enviado em:</span> <?= date("d/m/Y h:i", strtotime($inscrito->data_envio)) ?>
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
                            <div class="col"><b>Nome:</b> <?= $inscrito->nome ?></div>
                            <div class="col"><b>Nome Artístico:</b> <?= $inscrito->nome_artistico ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col"><b>RG:</b> <?= $inscrito->rg ?></div>
                            <div class="col"><b>CPF:</b> <?= $inscrito->cpf ?></div>
                            <div class="col"><b>CCM:</b> <?= $inscrito->ccm ?></div>
                        </div>
                        <div class="row">
                            <div class="col"><b>Data de nascimento:</b> <?= date("d/m/Y", strtotime($inscrito->data_nascimento)) ?></div>
                            <div class="col"><b>Nacionalidade:</b> <?= $inscrito->nacionalidade ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md"><b>E-mail:</b> <?= $inscrito->email ?></div>
                            <div class="col"><b>Telefones:</b> <?= $telefones ?></div>
                        </div>
                        <div class="row">
                            <div class="col"><b>NIT:</b> <?= $inscrito->nit ?></div>
                            <div class="col"><b>DRT:</b> <?= $inscrito->drt ?></div>
                            <div class="col"><b>Grau Instituição:</b> <?= $inscrito->grau_instrucao ?></div>
                        </div>
                        <div class="row">
                            <div class="col"><b>Etnia:</b> <?= $inscrito->etnia ?></div>
                            <div class="col"><b>Gênero:</b> <?= $inscrito->genero ?></div>
                            <div class="col"><b>Trans:</b> <?= $inscrito->trans ?></div>
                            <div class="col"><b>PCD:</b> <?= $inscrito->pcd ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <b>Endereço:</b> <?= $inscrito->logradouro . ", " . $inscrito->numero . " " . $inscrito->complemento . " " . $inscrito->bairro . " - " . $inscrito->cidade . "-" . $inscrito->uf . " CEP: " . $inscrito->cep ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col"><b>Banco:</b> <?= $inscrito->banco ?></div>
                            <div class="col"><b>Agência:</b> <?= $inscrito->agencia ?></div>
                            <div class="col"><b>Conta:</b> <?= $inscrito->conta ?></div>
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
                        <h3 class="card-title">Dados complementares</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <span class="font-weight-bold">Ano de execusão do serviço: </span> <?= $inscrito->ano ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <span class="font-weight-bold">Região Preferencial: </span> <?= $inscrito->regiao ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <span class="font-weight-bold">Programa: </span> <?= $formacaoObj->recuperaPrograma($formacaoObj->encryption($inscrito->programa_id))->programa ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <span class="font-weight-bold">Linguagem: </span> <?= $formacaoObj->recuperaLinguagem($formacaoObj->encryption($inscrito->linguagem_id))->linguagem ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <span class="font-weight-bold">Função (1º Opção): </span> <?= $formacaoObj->recuperaCargo($formacaoObj->encryption($inscrito->form_cargo_id))->cargo ?>
                            </div>
                        </div>
                        <?php if ($inscrito->form_cargo2_id): ?>
                            <div class="row">
                                <div class="col">
                                    <span class="font-weight-bold">Função (2º Opção): </span> <?= $formacaoObj->recuperaCargo($formacaoObj->encryption($inscrito->form_cargo2_id))->cargo ?>
                                </div>
                            </div>
                        <?php endif;
                        if ($inscrito->form_cargo3_id): ?>
                            <div class="row">
                                <div class="col">
                                    <span class="font-weight-bold">Função (3º Opção): </span> <?= $formacaoObj->recuperaCargo($formacaoObj->encryption($inscrito->form_cargo3_id))->cargo ?>
                                </div>
                            </div>
                        <?php endif; ?>
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
                        <h3 class="card-title">Anexos</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md alert alert-warning alert-dismissible">
                                <h5><strong><i class="icon fas fa-exclamation-triangle"></i> Atenção!</strong></h5>
                                <p><br>Todos os arquivos precisam ser baixados e enviados manualmente na página de anexos!</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <?php foreach ($arquivos as $arquivo): ?>
                                    <div class="row">
                                        <div class="col">
                                            <a href="<?= CAPACURL ?>/uploads/<?= $arquivo->arquivo ?>" target="_blank"><?= $arquivosObj->getDocumento($arquivo->form_lista_documento_id) ?></a><br/>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <a href="<?= SERVERURL ?>api/downloadInscritos.php?id=<?= $inscrito->id ?>&formacao=1" target="_blank" class="btn bg-gradient-purple btn-sm btn-block rounded-bottom"><i class="fas fa-file-archive"></i> Baixar todos os arquivos</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
        <div class="card-footer">
            <a href="<?= SERVERURL ?>formacao/listar_inscritos" class="btn btn-default float-left">Voltar</a>
            <form class="formulario-ajax" action="<?= SERVERURL ?>ajax/formacaoAjax.php" method="POST">
                <input type="hidden" name="_method" value="importarInscrito">
                <input type="hidden" name="id" value="<?= $formacaoObj->encryption($inscrito->id) ?>">
                <button class="btn btn-info float-right" id="importar">Importar Inscrito</button>
                <div class="resposta-ajax"></div>
            </form>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->