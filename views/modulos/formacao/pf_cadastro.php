<?php
$id = isset($_GET['id']) ? $_GET['id'] : null;

$doc = isset($_GET['doc']) ? $_GET['doc'] : null;

$type = isset($_GET['type']) ? $_GET['type'] : null;

$idCapac = isset($_GET['capac']) ? $_GET['capac'] : null; //id do pf

require_once "./controllers/PessoaFisicaController.php";
$insPessoaFisica = new PessoaFisicaController();

if ($id && $type == null) {
    $pf = $insPessoaFisica->recuperaPessoaFisica($id);
    $documento = $pf->cpf;
}

if (isset($_POST['pf_cpf'])){
    $documento = $_POST['pf_cpf'];
    $pf = $insPessoaFisica->getCPF($documento)->fetch();
    if ($pf){
        $id = MainModel::encryption($pf->id);
        $pf = $insPessoaFisica->recuperaPessoaFisica($id);
        $documento = $pf->cpf;
    }
}

if ($type == 1){
    $documento = str_replace('p','.',$doc);
    $documento = str_replace('t','-',$documento);
}

if ($idCapac){
    $pf = $insPessoaFisica->recuperaPessoaFisicaCapac($idCapac);
    $documento = $pf->cpf;
}

?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Pessoa Física</h1>
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
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/formacaoAjax.php" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editarPF" : "cadastrarPF" ?>">
                        <input type="hidden" name="pagina" value="formacao/pf_cadastro">
                        <input type="hidden" name="pf_ultima_atualizacao" value="<?= date('Y-m-d H-i-s') ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" value="<?= $id ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nome">Nome: *</label>
                                    <input type="text" class="form-control" name="pf_nome" placeholder="Digite o nome" maxlength="70" value="<?= $pf->nome ?? "" ?>" required
                                           placeholder="Digite o nome" title="Apenas letras"
                                           pattern="[a-zA-ZàèìòùÀÈÌÒÙâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇáéíóúýÁÉÍÓÚÝ ]{1,70}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="nomeSocial">Nome Social:</label>
                                    <input type="text" class="form-control" name="ns_nome_social" placeholder="Digite o nome social" maxlength="70" value="<?= $pf->nome_social ?? "" ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="nomeArtistico">Nome Artístico:</label>
                                    <input type="text" class="form-control" name="pf_nome_artistico" placeholder="Digite o nome artistico" maxlength="70" value="<?= $pf->nome_artistico ?? "" ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="rg">RG: *</label>
                                    <input type="text" class="form-control" name="pf_rg" placeholder="Digite o RG" maxlength="20" value="<?= $pf->rg ?? ""?>" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cpf">CPF: </label>
                                    <input type="text" name="pf_cpf" class="form-control" id="cpf" value="<?= $documento ?? $doc ?> " readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="ccm">CCM:</label>
                                    <input type="text" id="ccm" name="pf_ccm" class="form-control" placeholder="Digite o CCM" maxlength="11" value="<?= $pf->ccm ?? ""?>">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="dataNascimento">Data de Nascimento: *</label>
                                    <input type="date" class="form-control" id="data_nascimento" name="pf_data_nascimento" onkeyup="barraData(this);" value="<?= $pf->data_nascimento ?? "" ?>" required/>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="nacionalidade">Nacionalidade: *</label>
                                    <select class="form-control select2bs4" id="nacionalidade" name="pf_nacionalidade_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $insPessoaFisica->geraOpcao("nacionalidades",$pf->nacionalidade_id);
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="email">E-mail: *</label>
                                    <input type="email" name="pf_email" class="form-control" maxlength="60" placeholder="Digite o E-mail" value="<?= $pf->email ?? "" ?>" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Telefone #1: *</label>
                                    <input type="text" id="telefone" name="te_telefone_1" onkeyup="mascara( this, mtel );"  class="form-control" placeholder="Digite o telefone" required value="<?= $pf->telefones['tel_0'] ?? "" ?>" maxlength="15">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Telefone #2:</label>
                                    <input type="text" id="telefone1" name="te_telefone_2" onkeyup="mascara( this, mtel );"  class="form-control" placeholder="Digite o telefone" maxlength="15" value="<?= $pf->telefones['tel_1'] ?? "" ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Telefone #3:</label>
                                    <input type="text" id="telefone2" name="te_telefone_3" onkeyup="mascara( this, mtel );"  class="form-control telefone" placeholder="Digite o telefone" maxlength="15" value="<?= $pf->telefones['tel_2'] ?? "" ?>">
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="cep">CEP: *</label>
                                    <input type="text" class="form-control" name="en_cep" id="cep" onkeypress="mask(this, '#####-###')" maxlength="9" placeholder="Digite o CEP" required value="<?= $pf->cep ?? "" ?>" >
                                </div>
                                <div class="form-group col-md-2">
                                    <label>&nbsp;</label><br>
                                    <input type="button" class="btn btn-primary" value="Carregar">
                                </div>
                            </div>
                            <div class="row align-items-end">
                                <div class="form-group col-3">
                                    <label for="rua">Rua: *</label>
                                    <input type="text" class="form-control" name="en_logradouro" id="rua" placeholder="Digite a rua" maxlength="200" value="<?= $pf->logradouro ?? "" ?>" readonly>
                                </div>
                                <div class="form-group col-2">
                                    <label for="numero">
                                        Número: *
                                        <button type="button" class="btn btn-sm btn-default rounded-circle"  data-toggle="popover" data-content="Caso não houver colocar 0" data-placement="top">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                    </label>
                                    <input type="number" min="0" name="en_numero" class="form-control" placeholder="Ex.: 10" value="<?= $pf->numero ?? "" ?>" required>
                                </div>
                                <div class="form-group col-2">
                                    <label for="complemento">Complemento:</label>
                                    <input type="text" name="en_complemento" class="form-control" maxlength="20" placeholder="Digite o complemento" value="<?= $pf->complemento ??""?>">
                                </div>
                                <div class="form-group col-2">
                                    <label for="bairro">Bairro: *</label>
                                    <input type="text" class="form-control" name="en_bairro" id="bairro" placeholder="Digite o Bairro" maxlength="80" value="<?= $pf->bairro ?? ""?>" readonly>
                                </div>
                                <div class="form-group col-2">
                                    <label for="cidade">Cidade: *</label>
                                    <input type="text" class="form-control" name="en_cidade" id="cidade" placeholder="Digite a cidade" maxlength="50" value="<?= $pf->cidade ?? "" ?>" readonly>
                                </div>
                                <div class="form-group col-1">
                                    <label for="estado">Estado: *</label>
                                    <input type="text" class="form-control" name="en_uf" id="estado" maxlength="2" placeholder="Ex.: SP" value="<?= $pf->uf ?? "" ?>" readonly>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <div class="row">
                                        <div class="form-group col">
                                            <label for="regiao_id">Região: *</label>
                                            <select class="form-control select2bs4" id="regiao_id" name="dt_regiao_id" required>
                                                <option value="">Selecione uma opção...</option>
                                                <?php
                                                $insPessoaFisica->geraOpcao("regiaos",$pf->regiao_id);
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col">
                                            <label for="nit">NIT: *</label>
                                            <input type="text" id="nit" name="ni_nit" class="form-control" maxlength="45" placeholder="Digite o NIT" required value="<?= $pf->nit ?? "" ?>">
                                        </div>
                                        <div class="form-group col">
                                            <label for="drt">DRT: </label>
                                            <input type="text" id="drt" name="dr_drt" class="form-control" maxlength="45" placeholder="Digite o DRT em caso de artes cênicas" value="<?= $pf->drt ?? "" ?>">
                                        </div>
                                        <div class="form-group col">
                                            <label for="grau_instrucao_id">Grau Instrução: *</label>
                                            <select class="form-control select2bs4" id="grau_instrucao_id" name="dt_grau_instrucao_id" required>
                                                <option value="">Selecione uma opção...</option>
                                                <?php
                                                $insPessoaFisica->geraOpcao("grau_instrucoes",$pf->grau_instrucao_id);
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <label for="etnia_id">Etnia: *</label>
                                            <select class="form-control select2bs4" id="etnia_id" name="dt_etnia_id" required>
                                                <option value="">Selecione uma opção...</option>
                                                <?php
                                                $insPessoaFisica->geraOpcao("etnias",$pf->etnia_id);
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col">
                                            <label for="genero">Gênero: </label>
                                            <select class="form-control select2bs4" id="genero" name="dt_genero_id" required>
                                                <option value="">Selecione uma opção...</option>
                                                <?php
                                                $insPessoaFisica->geraOpcao("generos",$pf->genero_id ?? '',true);
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-1">
                                            <label for="dt_trans">Trans</label><br>
                                            <input type="checkbox" class="form-control-sm checkbox-grid-2 float-left" id="dt_trans" name="dt_trans" value="1"
                                                <?php
                                                if (isset($pf->trans)){
                                                    if ($pf->trans == 1){
                                                        echo 'checked';
                                                    }
                                                }
                                                ?>
                                            >
                                        </div>
                                        <div class="form-group col-md-1">
                                            <label for="dt_pcd">PCD</label><br>
                                            <input type="checkbox" class="form-control-sm checkbox-grid-2 float-left" id="dt_pcd" name="dt_pcd" value="1"
                                                <?php
                                                if (isset($pf->pcd)){
                                                    if ($pf->pcd == 1){
                                                        echo 'checked';
                                                    }
                                                }
                                                ?>
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="curriculo">Currículo:</label>
                                    <textarea class="form-control" id="curriculo" name="dt_curriculo" rows="5"><?= $pf->curriculo ?? "" ?></textarea>
                                </div>
                            </div>
                            <hr/>
                            <div class="alert alert-warning alert-dismissible">
                                <h5><i class="icon fas fa-exclamation-triangle"></i> Atenção!</h5>
                                Pagamentos serão feitos unicamente em conta corrente de Pessoa Física no Banco do Brasil.<br/>
                                Não são aceitas: conta fácil, poupança e conjunta.<br/>
                                Candidato contratado que não possuir conta, receberá no ato da assinatura do contrato, carta de apresentação para abertura da conta.
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="banco">Banco:</label>
                                    <select id="banco" name="bc_banco_id" class="form-control select2bs4">
                                        <option value="">Selecione um banco...</option>
                                        <?php
                                        $insPessoaFisica->geraOpcao("bancos", $pf->banco_id);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="agencia">Agência:</label>
                                    <input type="text" id="agencia" name="bc_agencia" class="form-control" placeholder="Digite a Agência" maxlength="12" value="<?= $pf->agencia ?? ""?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="conta">Conta:</label>
                                    <input type="text" id="conta" name="bc_conta" class="form-control" placeholder="Digite a Conta" maxlength="12" value="<?= $pf->conta ?? "" ?>">
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="<?= SERVERURL ?>formacao/pf_lista">
                                <button type="button" class="btn btn-default pull-left">Voltar</button>
                            </a>

                            <button type="submit" class="btn btn-primary float-right">Gravar</button>
                        </div>
                        
                        <!-- /.card-footer -->
                        <div class="resposta-ajax"></div>
                    </form>
                    <hr/>
                    <?php
                        if ($id){
                    ?>
                        <div class="row">
                            <div class="form-group col">
                                <a href="<?= SERVERURL . "formacao/pf_demais_anexos&id=" . $id?>" class="btn btn-info pull-right btn-block">
                                     Demais Anexos
                                </a>
                            </div>
                            <?php if(isset($_GET['import'])): ?>
                                <div class="form-group col">
                                    <a href="<?= SERVERURL ?>api/downloadCapac.php?id=<?= $id ?>&_method=arquivosPf" target="_blank" class="btn btn-info pull-right btn-block">
                                        Baixar Arquivos
                                    </a>
                                </div>
                            <?php endif; ?>
                            <div class="form-group col">
                                <a href="<?= SERVERURL ?>pdf/rlt_formacao_pf.php?id=<?= $id ?>" target="_blank">
                                    <button type="submit" class="btn btn-info btn-block">Imprimir resumo
                                    </button>
                                </a>
                            </div>

                            <div class="form-group col">
                                <a href="<?= SERVERURL ?>pdf/facc_pf.php?id=<?= $id ?>" target="_blank">
                                    <button type="submit" class="btn btn-info pull-right btn-block">Clique aqui para
                                        gerar a FACC
                                    </button>
                                </a>
                            </div>
                        </div>
                    <?php
                        }
                    ?>

                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->


<script src="../views/dist/js/cep_api.js"></script>

<script type="application/javascript">
    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#dados_cadastrais').addClass('active');

        $('[data-toggle="popover"]').popover();
    })
</script>