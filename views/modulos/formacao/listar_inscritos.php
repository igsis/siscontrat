<?php
require_once "./controllers/FormacaoController.php";

$apiCargos = CAPACURL . 'api/api_formacao_cargos.php';
$apiInscritos = CAPACURL . 'api/api_formacao_cargos.php';


$formacaoObj = new FormacaoController();

if (isset($_GET['busca'])) {
    $dados = $_GET;

    if (isset($dados['rangeDate'])) {
        $dados['rangeDate'] = str_replace('t', '-', $dados['rangeDate']);
        $dados['rangeDate'] = str_replace('b', '/', $dados['rangeDate']);
    }

    array_splice($dados, 0, 2);

    $resultados = $formacaoObj->listarIncritos($dados);

}

?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Listar Cadastrados no CAPAC</h1>
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
                        <h5>Formulario de pesquisa</h5>
                    </div>
                    <!-- /.card-header -->
                    <form method="post">
                        <div class="card-body">
                            <div class="row d-flex align-items-center">
                                <div class="col-sm-12 col-md-4">
                                    <label for="ano_inscricao">Ano de inscrição: </label>
                                    <input type="number" id="ano" name="ano_inscricao" class="form-control inputs"
                                           value="<?= isset($dados['ano']) ? $dados['ano'] : '' ?>">
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group pt-3">
                                        <label for="periodo">Periodo :</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                              </span>
                                            </div>
                                            <input type="text" class="form-control inputs" name="periodo"
                                                   id="rangeDate"
                                                   value="<?= isset($dados['rangeDate']) ? $dados['rangeDate'] : '' ?>">
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="programa">Programa: </label>
                                    <select name="programa" id="programa_id" class="form-control inputs">
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $formacaoObj->geraOpcao("form_programas", isset($dados['programa']) ? $dados['programa'] : '', false, false, true)
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <label for="funcao">Função:</label>
                                    <select name="funcao" id="form_cargo_id" class="form-control inputs">

                                    </select>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="regiao_preferencial">Região Preferencial: </label>
                                    <select name="regiao_preferencial" id="regiao_preferencial_id"
                                            class="form-control inputs">
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $formacaoObj->geraOpcao("regiaos", isset($dados['regiao']) ? $dados['regiao'] : '', false, false, true);
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="linguagem">Linguagem</label>
                                    <select name="linguagem" id="linguagem_id" class="form-control inputs">
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $formacaoObj->geraOpcao("form_linguagens", isset($dados['linguagem']) ? $dados['linguagem'] : '', false, false, true);
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-sm-12 col-md-4">
                                    <label for="genero">Gênero: </label>
                                    <select name="genero" id="genero_id" class="form-control inputs">
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $formacaoObj->geraOpcao("generos", isset($dados['genero']) ? $dados['genero'] : '', false, false, true);
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-6 col-md-2 d-flex flex-column align-items-center">
                                    <label for="trans">Trans:</label>
                                    <input type="checkbox" name="trans" id="trans" class="form-control check"
                                           value="trans" <?= isset($dados['trans']) ? 'checked' : '' ?>>
                                </div>
                                <div class="col-sm-6 col-md-2 d-flex flex-column align-items-center">
                                    <label for="pcd">PCD: </label>
                                    <input type="checkbox" name="pcd" id="pcd" class="form-control check"
                                           value="pcd" <?= isset($dados['pcd']) ? 'checked' : '' ?>>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button id="pesquisa" class="btn btn-info float-right">Pesquisar</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <?php if (isset($_GET['busca'])): ?>
            <div class="row">
                <div class="col-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h5>Resultados</h5>
                        </div>
                        <div class="card-body overflow-auto">
                            <table id="tabela" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>Programa</th>
                                    <th>Função</th>
                                    <th>Região preferencial</th>
                                    <th>Etnia</th>
                                    <th>PCD</th>
                                    <th>Trans</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php foreach ($resultados as $resultado) { ?>
                                    <td><?= $resultado->nome ?></td>
                                    <td><?= $resultado->cpf ?></td>
                                    <td><?= $resultado->programa ?></td>
                                    <td><?= $formacaoObj->recuperaCargo($formacaoObj->encryption($resultado->form_cargo_id))->cargo ?></td>
                                    <td><?= $resultado->regiao ?></td>
                                    <td><?= $resultado->descricao ?></td>
                                    <td><?= $resultado->pcd ? 'Sim' : 'Não' ?></td>
                                    <td><?= $resultado->trans ? 'Sim' : 'Não' ?></td>
                                    <td>
                                        <a href="<?= SERVERURL ?>resumo_inscrito&id=<?= $resultado->id ?>" class="btn btn-success btn-sm"> Resumo</a>
                                    </td>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>Programa</th>
                                    <th>Função</th>
                                    <th>Região preferencial</th>
                                    <th>Etnia</th>
                                    <th>PCD</th>
                                    <th>Trans</th>
                                    <th></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<script defer>
    const url_cargos = '<?= $apiCargos ?>';

    let pesquisa = document.querySelector('#pesquisa');
    let programa = document.querySelector('#programa_id');
    let resultados = document.querySelector('#resultPesquisa');

    programa.addEventListener('change', function (){
        getFuncao(this.value);
    });

    pesquisa.addEventListener('click', function (event){
        event.preventDefault();

        let inputs = document.querySelectorAll('.inputs');
        let dados = [] ;

        inputs.forEach(input => {
            let dado = {};

            dado.id = input.id;
            dado.val = input.value;

            dados.push(dado);
        })

        console.log(dados);

    });

    function checkValue(id){
        let input = document.querySelector(id).value;
        return  input != '' ? input : false;
    }

    function createObj(dados){

    }

    function getFuncao(idPrograma, funcao = ''){
        fetch(`${url_cargos}?busca=1&programa_id=${idPrograma}`)
            .then(response => response.json())
            .then(cargos => {
                console.log(cargos)
                $('#form_cargo_id option').remove();
                $('#form_cargo_id').append('<option value="">Selecione uma opção...</option>');

                for (const cargo of cargos) {
                    if (cargo.id == funcao) {
                        $('#form_cargo_id').append(`<option value='${cargo.id}' selected>${cargo.cargo}</option>`).focus();
                    }
                    $('#form_cargo_id').append(`<option value='${cargo.id}'>${cargo.cargo}</option>`).focus();
                }
            });
    }

    <?php if (isset($_GET['programa_id'])): ?>
    getFuncao('<?= $dados['programa_id']?>', '<?= isset($dados['form_cargo_id']) ? $dados['form_cargo_id'] : '' ?>');
    <?php endif; ?>

</script>