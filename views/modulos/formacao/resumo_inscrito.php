<?php

require_once "./controllers/FormacaoController.php";
require_once "./controllers/PessoaFisicaController.php";

$formacaoObj = new FormacaoController();
$pfObjeto = new PessoaFisicaController();

$id = $_GET['id'];
$inscrito = $formacaoObj->recuperaInscrito($id);
$telefones = $formacaoObj->recuperaTelInscrito($inscrito->pessoa_fisica_id);

if (isset($_POST['importar'])) {
    $formacaoObj->insereInscrito($inscrito);
}

$verifCpf = $pfObjeto->getCPF($inscrito->cpf)->fetchObject();

var_dump($inscrito);
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

<div class="row">
    <div class="col-12 p-4">
        <?php if ($verifCpf): ?>
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Atenção!</h5>
                O CPF <?= $inscrito->cpf ?>possui cadastro no sistema CAPAC e no SISCONTRAT.
            </div>
        <?php else: ?>
            <div class="alert alert-warning alert-dismissible">
                <h5><i class="icon fas fa-exclamation-triangle"></i> Atenção!</h5>
                Todos os arquivos precisam ser baixados e enviados manualmente na página de anexos!
            </div>
        <?php endif; ?>
    </div>
</div>

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
                            <div class="col">
                                <ul class="list-group">
                                    <li class="list-group-item bg-secondary disabled color-palette">
                                        <span class="font-weight-bold">Informações Pessoais </span>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col"><b>Nome:</b> <?= $inscrito->nome ?></div>

                                            <div class="col"><b>Nome Artístico:</b> <?= $inscrito->nome_artistico ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col"><b>CPF:</b> <?= $inscrito->cpf ?></div>

                                            <div class="col"><b>RG:</b> <?= $inscrito->rg ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col"><b>CCM:</b> <?= $inscrito->ccm ?></div>

                                            <div class="col"><b>NIT:</b> <?= $inscrito->nit ?></div>

                                            <div class="col"><b>DRT:</b> <?= $inscrito->drt ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col"><b>Data de
                                                    Nascimento:</b> <?= date("d/m/Y", strtotime($inscrito->data_nascimento)) ?>
                                            </div>

                                            <div class="col"><b>Nacionalidade:</b> <?= $inscrito->nacionalidade ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4"><b>E-mail:</b> <?= $inscrito->email ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <b>Telefones:</b>
                                                <?= $telefones ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <b>Endereço:</b> <?= $inscrito->logradouro . ", " . $inscrito->numero . " " . $inscrito->complemento . " " . $inscrito->bairro . " - " . $inscrito->cidade . "-" . $inscrito->uf . " CEP: " . $inscrito->cep ?>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <ul class="list-group">
                                    <li class="list-group-item bg-secondary disabled color-palette">
                                        <span class="font-weight-bold">Informações Complementares:</span>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col">
                                                <span class="font-weight-bold">Ano de execusão do serviço: </span> <?= $inscrito->ano ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <span class="font-weight-bold">Etnia: </span> <?= $inscrito->etnia ?>
                                            </div>

                                            <div class="col">
                                                <span class="font-weight-bold">Gênero: </span> <?= $inscrito->genero ?>
                                            </div>

                                            <div class="col">
                                                <span class="font-weight-bold">Trans: </span> <?= $inscrito->trans ?>
                                            </div>

                                            <div class="col">
                                                <span class="font-weight-bold">PCD: </span> <?= $inscrito->pcd ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <span class="font-weight-bold">Grau Instituição: </span> <?= $inscrito->grau_instrucao ?>
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
                                        <div class="row">
                                            <div class="col">
                                                <span class="font-weight-bold">Banco: </span> <?= $inscrito->banco ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <span class="font-weight-bold">Agência: </span> <?= $inscrito->agencia ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <span class="font-weight-bold">Conta: </span> <?= $inscrito->conta ?>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <a href="<?= SERVERURL ?>api/downloadInscritos.php?id=<?= $inscrito->id ?>&formacao=1"
                                           target="_blank"
                                           class="btn bg-gradient-purple btn-lg btn-block rounded-bottom"><i
                                                    class="fas fa-file-archive"></i> Baixar todos os arquivos</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <?php if (!$verifCpf): ?>
                            <form class="formulario-ajax" action="<?= SERVERURL ?>ajax/formacaoajax.php" method="POST">
                                <input type="hidden" name="_method" value="importarInscrito">
                                <input type="hidden" name="id" value="<?= $formacaoObj->encryption($inscrito->id) ?>">
                                <button class="btn btn-info float-right" id="importar">Importar Inscrito</button>
                                <div class="resposta-ajax"></div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->