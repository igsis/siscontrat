<?php
require_once "./controllers/FormacaoController.php";

$formacaoObj = new FormacaoController();

if (isset($_POST['busca'])) {
    $dados = $_POST;

    array_splice($dados, 0, 1);

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
                        <input type="hidden" name="busca" value="1">
                        <div class="card-body">
                            <div class="row d-flex align-items-center">
                                <div class="col-sm-12 col-md-4">
                                    <label for="ano_inscricao">Ano de inscrição: </label>
                                    <input type="number" id="ano" name="ano" class="form-control inputs"
                                           value="<?= isset($dados['ano']) ? $dados['ano'] : '' ?>">
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <label for="dataInicio">Data Início:</label>
                                    <input type="date" class="form-control inputsData" name="data[]" id="dataInicio" value="<?= isset($dados['data'][0]) ? $dados['data'][0] : '' ?>">
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <label for="dataFim">Data Fim:</label>
                                    <input type="date" class="form-control inputsData" name="data[]" id="dataFim" value="<?= isset($dados['data'][1]) ? $dados['data'][1] : '' ?>">
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="programa">Programa: </label>
                                    <select name="programa_id" id="programa_id" class="form-control inputs">
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $formacaoObj->geraOpcao("programas", isset($dados['programa_id']) ? $dados['programa_id'] : '')
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <label for="funcao">Função:</label>
                                    <select name="form_cargo_id" id="form_cargo_id" class="form-control inputs">

                                    </select>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="regiao_preferencial">Região Preferencial: </label>
                                    <select name="regiao_preferencial_id" id="regiao_preferencial_id"
                                            class="form-control inputs">
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $formacaoObj->geraOpcao("regiao_preferencias", isset($dados['regiao_preferencial_id']) ? $dados['regiao_preferencial_id'] : '');
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="linguagem">Linguagem</label>
                                    <select name="linguagem_id" id="linguagem_id" class="form-control inputs">
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $formacaoObj->geraOpcao("linguagens", isset($dados['linguagem_id']) ? $dados['linguagem_id'] : '');
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-sm-12 col-md-4">
                                    <label for="genero">Gênero: </label>
                                    <select name="genero_id" id="genero_id" class="form-control inputs">
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $formacaoObj->geraOpcao("generos", isset($dados['genero_id']) ? $dados['genero_id'] : '', false, false, true);
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-6 col-md-2 d-flex flex-column align-items-center">
                                    <label for="trans">Trans:</label>
                                    <input type="checkbox" name="trans" id="trans" class="form-control checks"
                                           value="1" <?= isset($dados['trans']) ? 'checked' : '' ?>>
                                </div>
                                <div class="col-sm-6 col-md-2 d-flex flex-column align-items-center">
                                    <label for="pcd">PCD: </label>
                                    <input type="checkbox" name="pcd" id="pcd" class="form-control checks"
                                           value="1" <?= isset($dados['pcd']) ? 'checked' : '' ?>>
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
        <?php if (isset($_POST['busca'])): ?>
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
                                    <th>Protocolo</th>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>Programa</th>
                                    <th>Linguagem</th>
                                    <th>Função</th>
                                    <th>Região preferencial</th>
                                    <th>Etnia</th>
                                    <th>PCD</th>
                                    <th>Trans</th>
                                    <th>Arquivos</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($resultados as $resultado) { ?>
                                    <tr>
                                        <td><?= $resultado->protocolo ?></td>
                                        <td><?= $resultado->nome ?></td>
                                        <td><?= $resultado->cpf ?></td>
                                        <td><?= $formacaoObj->recuperaPrograma($formacaoObj->encryption($resultado->programa_id))->programa ?></td>
                                        <td><?= $formacaoObj->recuperaLinguagem($formacaoObj->encryption($resultado->linguagem_id))->linguagem ?></td>
                                        <td><?= $formacaoObj->recuperaCargo($formacaoObj->encryption($resultado->form_cargo_id))->cargo ?></td>
                                        <td><?= $resultado->regiao ?></td>
                                        <td><?= $resultado->etnia ?></td>
                                        <td><?= $resultado->pcd ?></td>
                                        <td><?= $resultado->trans ?></td>
                                        <td>
                                            <a href="<?= SERVERURL ?>api/downloadInscritos.php?id=<?= $resultado->id ?>&formacao=1"
                                               target="_blank"
                                               class="btn bg-gradient-purple btn-sm rounded-bottom">Arquivos</a>
                                        </td>
                                        <td>
                                            <a href="<?= SERVERURL ?>formacao/resumo_inscrito&id=<?= $formacaoObj->encryption($resultado->id) ?>"
                                               class="btn btn-success btn-sm"> Resumo</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Protocolo</th>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>Programa</th>
                                    <th>Linguagem</th>
                                    <th>Função</th>
                                    <th>Região preferencial</th>
                                    <th>Etnia</th>
                                    <th>PCD</th>
                                    <th>Trans</th>
                                    <th>Arquivos</th>
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

    document.querySelector('body').classList.toggle('sidebar-open');
    document.querySelector('body').classList.toggle('sidebar-collapse');

    let pesquisa = document.querySelector('#pesquisa');
    let programa = document.querySelector('#programa_id');

    programa.addEventListener('change', function () {
        getFuncao(this.value);
    });

    // pesquisa.addEventListener('click', function (event) {
    //     event.preventDefault();
    //     let inputs = document.querySelectorAll('.inputs');
    //     dados = createArray();
    //
    //     window.location.href = montaUrl(dados);
    // });

    function createArray() {
        let inputs = document.querySelectorAll('.inputs');
        let checks = document.querySelectorAll('.checks');

        let datas = document.querySelectorAll('.inputsData');

        let dados = [];
        for (let input of inputs) {
            console.log(input.id, input.id == 'dataInicio' ? true : false);
            let elemento = {}
            if (input.value != "") {
                if (input.id != "rangeDate") {
                    elemento.id = input.id;
                    elemento.dado = input.value;
                } else {
                    elemento.id = input.id;
                    elemento.dado = alterDate(input.value);
                }
                dados.push(elemento);
            }
        }

        for (let check of checks) {
            let elemento = {};
            if (check.checked) {
                elemento.id = check.id
                elemento.dado = 1

                dados.push(elemento)
            }
        }

        if (datas.length == 1) {
            let data = {};
            data.id = 'rangeDate';
            data.dado = alterDate(data.value)

            dados.push(data);
        } else if (datas.length == 2) {
            let strData = '';
            strData = datas[0].value + ' / ' + datas[1].value;

            data = {};

            data.id = 'rangeDate';
            data.dado = alterDate(strData)

            dados.push(data);
        }

        return dados;
    }

    function alterDate(date) {
        date = date.replace(date.substr(10, 3), 't');
        return date.split('-').join('b');
    }

    function checkValue(id) {
        let input = document.querySelector(id).value;
        return input != '' ? input : false;
    }

    function getFuncao(idPrograma, funcao = '') {
        fetch(`${url_cargos}?busca=1&programa_id=${idPrograma}`)
            .then(response => response.json())
            .then(cargos => {
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

    <?php if (isset($_POST['programa_id'])): ?>
    getFuncao('<?= $dados['programa_id']?>', '<?= isset($dados['form_cargo_id']) ? $dados['form_cargo_id'] : '' ?>');
    <?php endif; ?>

    function montaUrl(dados) {
        let url = '<?= SERVERURL ?>formacao/listar_inscritos&busca=1';
        dados.forEach((dado) => {
            url = `${url}&${dado.id}=${dado.dado}`;
        })

        return url;
    }
</script>