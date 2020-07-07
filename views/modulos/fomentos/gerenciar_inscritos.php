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
                                        <td colspan="4" class="text-center">Digite o Edital para ver os resultados</td>
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
                        resultado.forEach((result) => {
                            console.log(result);
                            criarLinha(result);
                        })

                    } else if (data == 0) {
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
        let tr = document.createElement('tr');
        tr.appendChild(criarColuna(dados.titulo));
        tr.appendChild(criarColuna(ConverteData(dados.data_abertura)));
        tr.appendChild(criarColuna(ConverteData(dados.data_encerramento)));
        tr.appendChild(criarColuna(criarBotao(dados.id)));

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

    function criarBotao(id) {
        let a = document.createElement('a');
        a.classList.add('btn');
        a.classList.add('btn-primary');
        a.classList.add('btn-sm');
        a.classList.add('text-light');
        a.href = `<?=SERVERURL?>fomentos/listar_inscritos&id=${id}`;
        a.textContent = 'Listar Inscritos';
        return a;
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
        trs.forEach((tr) => {
            tr.remove();
        });
        if (nada) {
            mensagemSemEdital(tbody)
        }
    }

    function ConverteData(dt) {
        dataHora = dt.split(' ');
        data = new Date(dataHora[0]);
        mesCerto = ('00' + (data.getMonth() + 1)).slice(-2);

        return `${data.getDate()}/${mesCerto}/${data.getFullYear()} ${dataHora[1]}`;
    }


</script>