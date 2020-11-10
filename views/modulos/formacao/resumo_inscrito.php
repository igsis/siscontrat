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
                                        <span class="font-weight-bold">Nome: </span> <?= $inscrito->nome ?>
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
                                        <span class="font-weight-bold">CPF: </span> <?= $inscrito->cpf ?>
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
                                        <span class="font-weight-bold">Programa Selecionado: </span> <?= $formacaoObj->recuperaPrograma($formacaoObj->encryption($inscrito->programa_id))->programa ?>
                                    </li>
                                </ul>
                            </div>
                            <div class="col">
                                <ul class="list-group">
                                    <li class="list-group-item bg-secondary disabled color-palette">
                                        <span class="font-weight-bold">Endereço </span>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">CEP: </span> <?= $inscrito->cep ?>
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
                        <div class="row mt-3">
                            <div class="col">
                                <ul class="list-group">
                                    <li class="list-group-item bg-secondary disabled color-palette">
                                        <span class="font-weight-bold">Informações Complementares:</span>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">Etnia: </span> <?= $inscrito->etnia ?>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">Gênero: </span> <?= $inscrito->genero ?>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">Trans: </span> <?= $inscrito->trans ?>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">PCD: </span> <?= $inscrito->pcd ?>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">Grau Instituição: </span> <?= $inscrito->grau_instrucao ?>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">Linguagem: </span> <?= $formacaoObj->recuperaLinguagem($formacaoObj->encryption($inscrito->linguagem_id))->linguagem ?>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">Função: </span> <?= $formacaoObj->recuperaCargo($formacaoObj->encryption($inscrito->form_cargo_id))->cargo ?>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">Região Preferencial: </span> <?= $inscrito->regiao ?>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">Banco: </span> <?= $inscrito->banco ?>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">Agência: </span> <?= $inscrito->agencia ?>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">Conta: </span> <?= $inscrito->conta ?>
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