<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Gerenciar inscritos</h1>
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
                            <input type="text" class="form-control" id="pesquisaEdit" placeholder="Nome do Edital">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-info btn-flat rounded-right"><i
                                            class="fas fa-search"></i></button>
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
                                    <td>
                                        <button type="button" class="btn btn-block btn-success"><i
                                                    class="fas fa-file-export mr-1"></i> Exportar
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row">PROGRAMA MUNICIPAL DE FOMENTO À DANÇA - 28ª Edição</td>
                                    <td>2020-02-14 00:01:00</td>
                                    <td>2020-02-14 00:01:00</td>
                                    <td>
                                        <button type="button" class="btn btn-block btn-success"><i
                                                    class="fas fa-file-export mr-1"></i> Exportar
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row">PROGRAMA MUNICIPAL DE FOMENTO À DANÇA - 28ª Edição</td>
                                    <td>2020-02-14 00:01:00</td>
                                    <td>2020-02-14 00:01:00</td>
                                    <td>
                                        <button type="button" class="btn btn-block btn-success"><i
                                                    class="fas fa-file-export mr-1"></i> Exportar
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row">PROGRAMA MUNICIPAL DE FOMENTO À DANÇA - 28ª Edição</td>
                                    <td>2020-02-14 00:01:00</td>
                                    <td>2020-02-14 00:01:00</td>
                                    <td>
                                        <button type="button" class="btn btn-block btn-success"><i
                                                    class="fas fa-file-export mr-1"></i> Exportar
                                        </button>
                                    </td>
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
    let pesquisa = document.querySelector('#pesquisaEdit');
    let tbody = document.querySelector('tbody');

    pesquisa.addEventListener("input", () => {
        limparTabela(false)
        if (pesquisa.value == '') {
            limparTabela();
        } else {
            $.ajax({
                type: "POST",
                url: "<?= SERVERURL ?>ajax/fomentoAjax.php",
                data: {
                    _method: 'pesquisa',
                    search: `${pesquisa.value}`,
                },
                success: function (data, text) {
                    limparTabela(false);
                    if (text == 'success' && data != 0) {
                        const resultado = JSON.parse(data)[0];
                        limparTabela(false);
                        resultado.forEach((result) =>{
                           console.log(result);
                           criarLinha(result);
                        })

                    }else if (data == 0) {
                        limparTabela()
                    }
                },
                error: function (response, status, error) {
                    throw new Error(`Status: ${status} não possivel conectar com arquivo AJAX.\n Erro: ${error} `);
                }
            })
        }
    });

    function criarLinha(dados) {
        let tbody = document.querySelector('tbody');
        let tr =  document.createElement('tr');
        tr.appendChild(criarColuna(dados.titulo));
        tr.appendChild(criarColuna(dados.data_abertura));
        tr.appendChild(criarColuna(dados.data_encerramento));
        tr.appendChild(criarColuna('Aqui vai um botão'));

        tbody.appendChild(tr);
    }

    function criarColuna(dado) {
        let td = document.createElement('td');
        if (typeof dado != "object")
            td.textContent = dado;
        else
            td.appendChild(dado);
        return td;
    }

    function mensagemSemEdital(tbody) {
        let tr = document.createElement('tr');
        let td = criarColuna('Nenhum Edital Encontrado');
        td.classList.add('text-center');
        td.colSpan = '4';
        tr.appendChild(td);

        tbody.appendChild(tr);
    }

    function limparTabela(nada = true) {
       let trs = document.querySelectorAll('tbody tr');
       trs.forEach((tr)=>{
           tr.remove();
       });
        if (nada) {
            mensagemSemEdital(tbody)
        }
    }


</script>