<?php
require_once "./controllers/FomentoController.php";
$fomentoObj = new FomentoController();

$fomentos = $fomentoObj->listaFomentos();
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Exportar inscritos</h1>
            </div><!-- /.col -->
            <div class="col-sm-3">
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
                        <h3 class="card-title">Pesquisa de Editais</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="pesquisaEdit">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-info btn-flat rounded-right"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                        <div class="row">
                            <table id="tbEdital" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">Edital</th>
                                    <th scope="col">Data de Abertura</th>
                                    <th scope="col">Data de Encerramento</th>
                                    <th scope="col">Ação</th>
                                </tr>
                                </thead>
                                <tbody id="tb-effect">
                                <tr>
                                    <td scope="row">PROGRAMA MUNICIPAL DE FOMENTO À DANÇA - 28ª Edição</td>
                                    <td>2020-02-14 00:01:00</td>
                                    <td>2020-02-14 00:01:00</td>
                                    <td><button type="button" class="btn btn-block btn-success"><i class="fas fa-file-export mr-1"></i> Exportar</button></td>
                                </tr>
                                <tr>
                                    <td scope="row">PROGRAMA MUNICIPAL DE FOMENTO À DANÇA - 28ª Edição</td>
                                    <td>2020-02-14 00:01:00</td>
                                    <td>2020-02-14 00:01:00</td>
                                    <td><button type="button" class="btn btn-block btn-success"><i class="fas fa-file-export mr-1"></i> Exportar</button></td>
                                </tr>
                                <tr>
                                    <td scope="row">PROGRAMA MUNICIPAL DE FOMENTO À DANÇA - 28ª Edição</td>
                                    <td>2020-02-14 00:01:00</td>
                                    <td>2020-02-14 00:01:00</td>
                                    <td><button type="button" class="btn btn-block btn-success"><i class="fas fa-file-export mr-1"></i> Exportar</button></td>
                                </tr>
                                <tr>
                                    <td scope="row">PROGRAMA MUNICIPAL DE FOMENTO À DANÇA - 28ª Edição</td>
                                    <td>2020-02-14 00:01:00</td>
                                    <td>2020-02-14 00:01:00</td>
                                    <td><button type="button" class="btn btn-block btn-success"><i class="fas fa-file-export mr-1"></i> Exportar</button></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->

                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<script>

    tbody = document.querySelector('tbody');
    let pesquisa = document.querySelector('#pesquisaEdit');
    let tr = document.querySelectorAll('tbody > tr');

    pesquisa.addEventListener("input", ()=>{
        tr.forEach((linha)=>{
            linha.remove();
        });

        $.ajax({
           type: GET,
           url: "",
           success: function (data, text) {
               console.log(data);
               console.log(text);

           },
           error: function (response,status,error) {

           }
        })

        let x = tbody.childElementCount;
        if (x == 0){
            mensagemSemEdital(tbody)
        }
    })

    function addTabela(edital) {
        let editalTr = criarLinhaTabela(edital);
        let tabela = document.querySelector('#tbEdital');
        tabela.appendChild(editalTr)
    }

    function criarLinhaTabela(edital) {
        let tr = document.createElement("tr");
        tr.appendChild(criarTd(edital.titulo));
        tr.appendChild(criarTd(edital.data_abertura));
        tr.appendChild(criarTd(edital.data_encerramento));
        tr.appendChild(criarTd('teste'));

        return tr;
    }

    function criarTd(dado) {
        let td = document.createElement("td");
        td.textContent = dado;
        return td;
    }

    function mensagemSemEdital(tbody) {

        let tr = document.createElement('tr');
        let td = criarTd('Nenhum Edital Encontrado');
        td.classList.add('text-center');
        td.colSpan = 4;
        tr.appendChild(td);

        tbody.appendChild(tr);
    }


</script>