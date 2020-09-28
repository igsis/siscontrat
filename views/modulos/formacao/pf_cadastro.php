<?php
$id = isset($_GET['id']) ? $_GET['id'] : null;
require_once "./controllers/PessoaFisicaController.php";
$insPessoaFisica = new PessoaFisicaController();

if ($id) {
    $pf = $insPessoaFisica->recuperaPessoaFisica($id);
    $documento = $pf['cpf'];
}

if (isset($_POST['pf_cpf'])){
    $documento = $_POST['pf_cpf'];
    $pf = $insPessoaFisica->getCPF($documento)->fetch();
    if ($pf['cpf'] != ''){
        $id = MainModel::encryption($pf['id']);
        $pf = $insPessoaFisica->recuperaPessoaFisica($id);
        $documento = $pf['cpf'];
    }

    
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
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/FormacaoAjax.php" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
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
                                    <input type="text" class="form-control" name="pf_nome" placeholder="Digite o nome" maxlength="70" value="<?= $pf['nome'] ?? "" ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="nomeArtistico">Nome Artístico:</label>
                                    <input type="text" class="form-control" name="pf_nome_artistico" placeholder="Digite o nome artistico" maxlength="70" value="<?= $pf['nome_artistico'] ?? "" ?>">
                                </div>
                            </div>

                            <div class="row">
                                <?php
                                if (isset($_POST['pf_cpf']) && $pf['cpf'] != ""){
                                    ?>
                                    <div class="form-group col-md-2">
                                        <label for="rg">RG: *</label>
                                        <input type="text" class="form-control" name="pf_rg" placeholder="Digite o RG" maxlength="20" value="<?= $pf['rg'] ?? ""?>" required>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="cpf">CPF: </label>
                                        <input type="text" name="pf_cpf" class="form-control" id="cpf" value="<?= $documento ?>" readonly>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="ccm">CCM:</label>
                                        <input type="text" id="ccm" name="pf_ccm" class="form-control" placeholder="Digite o CCM" maxlength="11" value="<?= $pf['ccm'] ?? ""?>">
                                    </div>
                                    <?php
                                }
                                else{
                                    ?>
                                    <div class="form-group col-md-6">
                                        <label for="passaporte" id="documento">Passaporte: </label>
                                        <input type="text" id="passaporte" name="pf_passaporte" class="form-control" value="<?= $documento ?? "" ?>" readonly>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="form-group col-md-3">
                                    <label for="dataNascimento">Data de Nascimento: *</label>
                                    <input type="date" class="form-control" id="data_nascimento" name="pf_data_nascimento" onkeyup="barraData(this);" value="<?= $pf['data_nascimento'] ?? "" ?>" required/>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="nacionalidade">Nacionalidade: *</label>
                                    <select class="form-control" id="nacionalidade" name="pf_nacionalidade_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $insPessoaFisica->geraOpcao("nacionalidades",$pf['nacionalidade_id']);
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="email">E-mail: *</label>
                                    <input type="email" name="pf_email" class="form-control" maxlength="60" placeholder="Digite o E-mail" value="<?= $pf['email'] ?? "" ?>" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Telefone #1: *</label>
                                    <input type="text" id="telefone" name="te_telefone_1" onkeyup="mascara( this, mtel );"  class="form-control" placeholder="Digite o telefone" required value="<?= $pf['telefones']['tel_0'] ?? "" ?>" maxlength="15">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Telefone #2:</label>
                                    <input type="text" id="telefone1" name="te_telefone_2" onkeyup="mascara( this, mtel );"  class="form-control" placeholder="Digite o telefone" maxlength="15" value="<?= $pf['telefones']['tel_1'] ?? "" ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Telefone #3:</label>
                                    <input type="text" id="telefone2" name="te_telefone_3" onkeyup="mascara( this, mtel );"  class="form-control telefone" placeholder="Digite o telefone" maxlength="15" value="<?= $pf['telefones']['tel_2'] ?? "" ?>">
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="cep">CEP: *</label>
                                    <input type="text" class="form-control" name="en_cep" id="cep" onkeypress="mask(this, '#####-###')" maxlength="9" placeholder="Digite o CEP" required value="<?= $pf['cep'] ?? "" ?>" >
                                </div>
                                <div class="form-group col-md-2">
                                    <label>&nbsp;</label><br>
                                    <input type="button" class="btn btn-primary" value="Carregar">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="rua">Rua: *</label>
                                    <input type="text" class="form-control" name="en_logradouro" id="rua" placeholder="Digite a rua" maxlength="200" value="<?= $pf['logradouro'] ?? "" ?>" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="numero">Número: *</label>
                                    <input type="number" name="en_numero" class="form-control" placeholder="Ex.: 10" value="<?= $pf['numero'] ?? "" ?>" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="complemento">Complemento:</label>
                                    <input type="text" name="en_complemento" class="form-control" maxlength="20" placeholder="Digite o complemento" value="<?= $pf['complemento'] ??""?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="bairro">Bairro: *</label>
                                    <input type="text" class="form-control" name="en_bairro" id="bairro" placeholder="Digite o Bairro" maxlength="80" value="<?= $pf['bairro'] ?? ""?>" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cidade">Cidade: *</label>
                                    <input type="text" class="form-control" name="en_cidade" id="cidade" placeholder="Digite a cidade" maxlength="50" value="<?= $pf['cidade'] ?? "" ?>" readonly>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="estado">Estado: *</label>
                                    <input type="text" class="form-control" name="en_uf" id="estado" maxlength="2" placeholder="Ex.: SP" value="<?= $pf['uf'] ?? "" ?>" readonly>
                                </div>
                            </div>
                            <hr/>
                            <!-- <div class="row">
                                <div class="form-group col">
                                    <label for="regiao_id">Região: *</label>
                                    <select class="form-control" id="regiao_id" name="dt_regiao_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $insPessoaFisica->geraOpcao("regiaos",$pf['regiao_id']);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label for="etnia_id">Etnia: *</label>
                                    <select class="form-control" id="etnia_id" name="dt_etnia_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $insPessoaFisica->geraOpcao("etnias",$pf['etnia_id']);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label for="grau_instrucao_id">Grau de Instrução: *</label>
                                    <select class="form-control" id="grau_instrucao_id" name="dt_grau_instrucao_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $insPessoaFisica->geraOpcao("grau_instrucoes",$pf['grau_instrucao_id']);
                                        ?>
                                    </select>
                                </div>
                            </div> 
                            <hr/>-->
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nit">NIT: *</label>
                                    <input type="text" id="nit" name="ni_nit" class="form-control" maxlength="45" placeholder="Digite o NIT" required value="<?= $pf['nit'] ?? "" ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="drt">DRT: </label>
                                    <input type="text" id="drt" name="dr_drt" class="form-control" maxlength="45" placeholder="Digite o DRT em caso de artes cênicas" value="<?= $pf['drt'] ?? "" ?>">
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
                                    <select id="banco" name="bc_banco_id" class="form-control">
                                        <option value="">Selecione um banco...</option>
                                        <?php
                                        $insPessoaFisica->geraOpcao("bancos", $pf['banco_id']);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="agencia">Agência:</label>
                                    <input type="text" id="agencia" name="bc_agencia" class="form-control" placeholder="Digite a Agência" maxlength="12" value="<?= $pf['agencia'] ?? ""?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="conta">Conta:</label>
                                    <input type="text" id="conta" name="bc_conta" class="form-control" placeholder="Digite a Conta" maxlength="12" value="<?= $pf['conta'] ?? "" ?>">
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="<?= SERVERURL ?>formacao/pf_lista">
                                <button type="button" class="btn btn-default pull-left">Voltar</button>
                            </a>

                            <button type="submit" class="btn btn-info float-right">Gravar</button>
                        </div>
                        
                        <!-- /.card-footer -->
                        <div class="resposta-ajax"></div>
                    </form>
                    <hr/>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <form method="POST" action='#'
                            role="form">
                                <input type="hidden" name="idPf" value="">
                                    <button type="submit" class="btn btn-info pull-right btn-block">Demais
                                        Anexos
                                    </button>
                            </form>
                        </div>

                        <div class="form-group col-md-4">
                            <form method="post" action="3" role="form" target="_blank">
                                <input type="hidden" name="idPf" value="">
                                    <button type="submit" class="btn btn-info btn-block">Imprimir resumo
                                </button>
                            </form>
                        </div>

                        <div class="form-group col-md-4">
                            <form method="POST" action="#" role="form" target="_blank">
                                <input type="hidden" name="idPf" value="">
                                    <button type="submit" class="btn btn-info pull-right btn-block">Clique aqui para
                                    gerar a FACC
                                </button>
                            </form>
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


<script src="../views/dist/js/cep_api.js"></script>

<script type="application/javascript">
    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#dados_cadastrais').addClass('active');
    })
</script>