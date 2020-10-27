<?php
require_once "./controllers/FormacaoController.php";

$apiCapac = CAPACURL.'api/api_formacao_cargos.php';

$formacaoObj = new FormacaoController();


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
                    <form>
                        <div class="card-body">
                            <div class="row d-flex align-items-end">
                                <div class="col-sm-12 col-md-2">
                                    <label for="ano_inscricao">Ano de inscrição: </label>
                                    <input type="number" id="ano" name="ano_inscricao" class="form-control inputs">
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <label for="data_inicial">Data Inicial: </label>
                                    <input type="date" id="data_inicial" class="form-control inputs" name="data_inicial">
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <label for="data_final">Data Final: </label>
                                    <input type="date" id="data_final" class="form-control inputs" name="data_final">
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="programa">Programa: </label>
                                    <select name="programa" id="programa" class="form-control inputs">
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                            $formacaoObj->geraOpcao("form_programas", '', false, false, true)
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <label for="funcao">Função:</label>
                                    <select name="funcao" id="funcao" class="form-control inputs">

                                    </select>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="regiao_preferencial">Região Preferencial: </label>
                                    <select name="regiao_preferencial" id="regiao_preferencial" class="form-control inputs">
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                            $formacaoObj->geraOpcao("regiaos", '', false, false, true);
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="linguagem">Linguagem</label>
                                    <select name="linguagem" id="linguagem" class="form-control inputs">
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                            $formacaoObj->geraOpcao("form_linguagens", '', false, false, true);
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-sm-12 col-md-4">
                                    <label for="genero">Gênero: </label>
                                    <select name="genero" id="genero" class="form-control inputs">
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                            $formacaoObj->geraOpcao("generos", '', false, false, true);
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-6 col-md-2 d-flex flex-column align-items-center">
                                    <label for="trans">Trans:</label>
                                    <input type="checkbox" name="trans" id="trans" class="form-control inputs" value="trans">
                                </div>
                                <div class="col-sm-6 col-md-2 d-flex flex-column align-items-center">
                                    <label for="pcd">PCD: </label>
                                    <input type="checkbox" name="pcd" id="pcd" class="form-control inputs" value="pcd">
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
        <div class="row" id="resultPesquisa">
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
                                <th>Função</th>
                                <th>Região preferencial</th>
                                <th>PCD</th>
                                <th>Etnia</th>
                                <th>Trans</th>
                                <th>Arquivos</th>
                                <th>Resumo</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Protocolo</th>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>Programa</th>
                                <th>Função</th>
                                <th>Região preferencial</th>
                                <th>PCD</th>
                                <th>Etnia</th>
                                <th>Trans</th>
                                <th>Arquivos</th>
                                <th>Resumo</th>
                                <th>Ação</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<script defer>
    const url_cargos = '<?= $apiCapac ?>';

    let pesquisa = document.querySelector('#pesquisa');
    let programa = document.querySelector('#programa');
    let resultados = document.querySelector('#resultPesquisa');

    resultados.style.display = "none";

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

    function getFuncao(idPrograma){
        fetch(`${url_cargos}?busca=1&programa_id=${idPrograma}`)
        .then(response => response.json())
        .then(cargos => {
            console.log(cargos)
            $('#funcao option').remove();
            $('#funcao').append('<option value="">Selecione uma opção...</option>');

            for (const cargo of cargos) {
                    $('#funcao').append(`<option value='${cargo.id}'>${cargo.cargo}</option>`).focus();
            }
        });
    }


</script>