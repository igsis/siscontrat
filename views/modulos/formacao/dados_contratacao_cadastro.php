<?php

    require_once "./controllers/FormacaoController.php";
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $contratacaoObj = new FormacaoController();
    $dados_contratacao = $contratacaoObj->recuperaDadosContratacao($id);
    //var_dump($dados_contratacao);
    $pf = $contratacaoObj->listaPF();
    $classificacao = $contratacaoObj->listaClassificacao();
    $territorio = $contratacaoObj->listaTerritorios();
    $coordenadoria = $contratacaoObj->listaCoordenadorias();
    $subprefeitura = $contratacaoObj->listaSubprefeituras();
    $programa = $contratacaoObj->listaProgramas();
    $linguagem = $contratacaoObj->listaLinguagens();
    $projeto = $contratacaoObj->listaProjetos();
    $cargo = $contratacaoObj->listaCargos();
    $regiao = $contratacaoObj->listaRegiaoPrefencial();
    $ficalSuplente = $contratacaoObj->listaFiscalSuplente();
    $vigencia = $contratacaoObj->listaVigencias();


?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dados para contratação</h1>
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
                    <!-- form start -->
                    <div class="card-body">
                        <form class="form-horizontal formulario-ajax" action="<?= SERVERURL ?>ajax/formacaoAjax.php" 
                            method="POST" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                            <input type="hidden" name="_method" value="<?= ($id) ? "editarDadosContratacao" : "cadastrarDadosContratacao" ?>">
                            <input type="hidden" name="form_status_id" value="1">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" id="modulo_id" value="<?= $id ?>">
                        <?php endif; ?>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="ano">Ano: *</label>
                                <input type="number" min="2018" id="ano" name="ano"  value="<?= $dados_contratacao->ano ?? "" ?>" required class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="chamado">Chamado: *</label>
                                <input type="number" min="1" max="127" id="chamado" name="chamado" max="127" value="<?= $dados_contratacao->chamado ?? "" ?>" required class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="from-group col-md-12">
                                <label for="pf">Pessoa Física: *</label>
                                <select required value="" name="pessoa_fisica_id" id="pessoa_fisica_id" class="form-control">
                                    <option>Selecione a pessoa física...</option>
                                    <?php foreach ($pf as $linha): ?>
                                        <option value="<?= $linha->id ?>" <?= isset($dados_contratacao->pessoa_fisica_id) && ($linha->id == $dados_contratacao->pessoa_fisica_id) ? "selected" : "" ?>>
                                            <?php echo $linha->nome ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                                <br>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="classificacao">Classificação Indicativa: *</label>
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-default"><i class="fa fa-info"></i></button>
                                <select required class="form-control" name="classificacao" id="classificacao">
                                    <option value="">Selecione uma classificação indicativa...</option>
                                    <?php foreach ($classificacao as $linha): ?>
                                        <option value="<?= $linha->id ?>" <?= isset($dados_contratacao->classificacao) && ($linha->id == $dados_contratacao->classificacao) ? "selected" : "" ?>>
                                            <?php echo $linha->classificacao_indicativa ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="territorio">Território: *</label>
                                <select class="form-control" name="territorio_id" id="territorio_id" required>
                                <option value="">Selecione o território...</option>
                                    <?php foreach ($territorio as $linha): ?>
                                        <option value="<?= $linha->id ?>" <?= isset($dados_contratacao->territorio_id) && ($linha->id == $dados_contratacao->territorio_id) ? "selected" : "" ?>>
                                            <?php echo $linha->territorio ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="coordenadoria">Coordenadoria: *</label>
                                <select class="form-control" name="coordenadoria_id" id="coordenadoria_id" required>
                                    <option value="">Selecione a coordenadoria...</option>
                                    <?php foreach ($coordenadoria as $linha): ?>
                                        <option value="<?= $linha->id ?>" <?= isset($dados_contratacao->coordenadoria_id) && ($linha->id == $dados_contratacao->coordenadoria_id) ? "selected" : "" ?>>
                                            <?php echo $linha->coordenadoria ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="subprefeitura">Subprefeitura: *</label>
                                <select class="form-control" name="subprefeitura_id" id="subprefeitura_id" required>
                                    <option value="">Selecione a subprefeitura...</option>
                                    <?php foreach ($subprefeitura as $linha): ?>
                                        <option value="<?= $linha->id ?>" <?= isset($dados_contratacao->subprefeitura_id) && ($linha->id == $dados_contratacao->subprefeitura_id) ? "selected" : "" ?>>
                                            <?php echo $linha->subprefeitura ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="programa">Programa: *</label>
                                <select class="form-control" name="programa_id" id="programa_id" required>
                                    <option value="">Selecione o programa...</option>
                                    <?php foreach ($programa as $linha): ?>
                                        <option value="<?= $linha['id'] ?>" <?= isset($dados_contratacao->programa_id) && ($linha['id'] == $dados_contratacao->programa_id) ? "selected" : "" ?>>
                                            <?php echo $linha['programa'] ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="linguagem">Linguagem: *</label>
                                <select class="form-control" name="linguagem_id" id="linguagem_id" required>
                                    <option value="">Selecione a linguagem...</option>
                                    <?php foreach ($linguagem as $linha): ?>
                                        <option value="<?= $linha->id ?>" <?= isset($dados_contratacao->linguagem_id) && ($linha->id == $dados_contratacao->linguagem_id) ? "selected" : "" ?>>
                                            <?php echo $linha->linguagem ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="projeto">Projeto: *</label>
                                <select class="form-control" name="projeto_id" id="projeto_id" required>
                                    <option value="">Selecione o projeto...</option>
                                    <?php foreach ($projeto as $linha): ?>
                                        <option value="<?= $linha->id ?>" <?= isset($dados_contratacao->projeto_id) && ($linha->id == $dados_contratacao->projeto_id) ? "selected" : "" ?>>
                                            <?php echo $linha->projeto ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="cargo">Cargo: *</label>
                                <select class="form-control" name="form_cargo_id" id="form_cargo_id" required>
                                    <option value="">Selecione o cargo...</option>
                                    <?php foreach ($cargo as $linha): ?>
                                        <option value="<?= $linha->id ?>" <?= isset($dados_contratacao->form_cargo_id) && ($linha->id == $dados_contratacao->form_cargo_id) ? "selected" : "" ?>>
                                            <?php echo $linha->cargo ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="cargo">Vigência: *</label>
                                <select class="form-control" name="form_vigencia_id" id="form_vigencia_id" required>
                                    <option value="">Selecione a vigência...</option>
                                    <?php foreach ($vigencia as $linha): ?>
                                        <option value="<?= $linha->id ?>" <?= isset($dados_contratacao->form_vigencia_id) && ($linha->id == $dados_contratacao->form_vigencia_id) ? "selected" : "" ?>>
                                            <?php echo $linha->ano . ' (' . $linha->descricao . ')'?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4" id="msgEscondeAno">
                                <span style="color: red;"><b>Ano escolhido é maior que a vigência!</b></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="regiao">Região Preferencial: *</label>
                                <select class="form-control" name="regiao_preferencia_id" id="regiao_preferencia_id" required>
                                    <option value="">Selecione uma região...</option>
                                    <?php foreach ($regiao as $linha): ?>
                                        <option value="<?= $linha->id ?>" <?= isset($dados_contratacao->regiao_preferencia_id) && ($linha->id == $dados_contratacao->regiao_preferencia_id) ? "selected" : "" ?>>
                                            <?php echo $linha->regiao ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="observacao">Observação: </label>
                                <textarea name="observacao" id="observacao" rows="3" class="form-control"><?= $dados_contratacao->observacao ?? "" ?></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="fiscal">Fiscal: *</label>
                                <select name="fiscal_id" id="fiscal_id" class="form-control" required>
                                    <option value="">Selecione um fiscal...</option>
                                    <?php foreach ($ficalSuplente as $linha): ?>
                                        <option value="<?= $linha->id ?>" <?= isset($dados_contratacao->fiscal_id) && ($linha->id == $dados_contratacao->fiscal_id) ? "selected" : "" ?>>
                                            <?php echo $linha->nome_completo?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="fiscal">Suplente: </label>
                                <select name="suplente_id" id="suplente_id" class="form-control">
                                    <option value="">Selecione um suplente...</option>
                                    <?php foreach ($ficalSuplente as $linha): ?>
                                        <option value="<?= $linha->id ?>" <?= isset($dados_contratacao->suplente_id) && ($linha->id == $dados_contratacao->suplente_id) ? "selected" : "" ?>>
                                            <?php echo $linha->nome_completo?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="<?= SERVERURL ?>formacao/dados_contratacao_lista">
                                <button type="button" class="btn btn-default pull-left">Voltar</button>
                            </a>
                            <button type="submit" name="cadastra" id="cadastra" class="btn btn-primary float-right">
                                Gravar
                            </button>
                        </div >
                        <div class="resposta-ajax"></div>
                        <?php if ($id): ?>
                            <div class="col align-self-center">
                            <hr>
                                <a href="<?= SERVERURL . "formacao/pedido_contratacao_cadastro&id=" . $contratacaoObj->encryption($dados_contratacao->id) ?>" class="btn btn-success">
                                     Gerar pedido de contratação
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                    
                </div>
            </div>

        </div>
        <!-- /.card -->
    </div>
</div>



<script>
    let ano = $('#ano');
    let vigencia = $('#form_vigencia_id');
    let botao = $('#cadastra');
    var isMsgAno = $('#msgEscondeAno');
    isMsgAno.hide();

    function maior() {
        let valorVigencia = $('#form_vigencia_id option:selected').text();
        valorVigencia = parseInt(valorVigencia.substring(0,80))
        if (ano.val() > valorVigencia) {
            botao.prop('disabled', true);
            isMsgAno.show();
        } else {
            botao.prop('disabled', false);
            isMsgAno.hide();
        }
    }

    ano.on('change', maior);
    vigencia.on('change', maior);

    $(document).ready(maior);
</script>
