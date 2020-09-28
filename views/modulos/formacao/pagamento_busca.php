<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Pagamento</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header">
                    <h4 class="card-title">Buscar por pedido de contratação</h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="protocolo">Protocolo:</label>
                        </div>

                        <div class="col-md-4">
                            <label for="numProcesso">Número do Processo:</label>
                        </div>

                        <div class="col-md-4">
                            <label for="proponente">Proponente:</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group-append">
                                <input type="text" class="form-control" name="protocolo" id="buscaProtocolo">
                                <button type="button" class="btn btn-info btn-flat rounded-right"><i
                                            class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="input-group-append">
                                <input type="text" class="form-control" name="numProcesso" id="buscaProcesso">
                                <button type="button" class="btn btn-info btn-flat rounded-right"><i
                                            class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="input-group-append">
                                <select class="form-control" name="proponente" id="buscaProponente">
                                    <option value="">Selecione uma opção...</option>
                                    <?= MainModel::geraOpcao('pessoa_fisicas') ?>
                                </select>
                                <button type="button" class="btn btn-info btn-flat rounded-right"><i
                                            class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <table id="tblResultado" class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Processo</th>
                                <th>Protocolo</th>
                                <th>Proponente</th>
                                <th width="5%">Nota empenho</th>
                                <th width="5%">Pagamento</th>
                            </tr>
                            </thead>

                            <tbody id="tb-effect">
                            <tr>
                                <td colspan="5" style="text-align: center">Busque os resultados acima</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer">

                </div>

            </div>
        </div>
    </div>
</div>

<script>
    let pesquisaProcesso = document.querySelector('#buscaProcesso');
    let pesquisaProtocolo = document.querySelector('#buscaProtocolo');
    let pesquisaProponente = document.querySelector('#buscaProponente');
    let tbody = document.querySelector('tbody');

    //processo
    pesquisaProcesso.addEventListener("input", () => {
        limparTabela(false)
        if (pesquisaProcesso.value == '') {
            limparTabela();
        } else {
            $.ajax({
                type: "POST",
                url: "<?= SERVERURL ?>ajax/formacaoAjax.php",
                data: {
                    _method: 'pesquisa',
                    search: `${pesquisaProcesso.value}`,
                    where: 'processo',
                },
                success: function (data, text) {
                    limparTabela(false);
                    if (text == 'success' && data != 0) {
                        const resultado = JSON.parse(data)[0];
                        limparTabela(false);
                        resultado.forEach((result) => {
                            //console.log(result);
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

    //protocolo
    pesquisaProtocolo.addEventListener("input", () => {
        limparTabela(false)
        if (pesquisaProtocolo.value == '') {
            limparTabela();
        } else {
            $.ajax({
                type: "POST",
                url: "<?= SERVERURL ?>ajax/formacaoAjax.php",
                data: {
                    _method: 'pesquisa',
                    search: `${pesquisaProtocolo.value}`,
                    where: 'protocolo',
                },
                success: function (data, text) {
                    limparTabela(false);
                    if (text == 'success' && data != 0) {
                        const resultado = JSON.parse(data)[0];
                        limparTabela(false);
                        resultado.forEach((result) => {
                            //console.log(result);
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

    //proponente
    pesquisaProponente.addEventListener("input", () => {
        limparTabela(false)
        if (pesquisaProponente.value == '') {
            limparTabela();
        } else {
            $.ajax({
                type: "POST",
                url: "<?= SERVERURL ?>ajax/formacaoAjax.php",
                data: {
                    _method: 'pesquisa',
                    search: `${pesquisaProponente.value}`,
                    where: 'proponente',
                },
                success: function (data, text) {
                    limparTabela(false);
                    if (text == 'success' && data != 0) {
                        const resultado = JSON.parse(data)[0];
                        limparTabela(false);
                        resultado.forEach((result) => {
                            //console.log(result);
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
        tr.appendChild(criarColuna(dados.numero_processo));
        tr.appendChild(criarColuna(dados.protocolo));
        tr.appendChild(criarColuna(dados.nome));
        tr.appendChild(criarColuna(criarBotaoEmpenho(dados.pedido_id)));
        tr.appendChild(criarColuna(criarBotaoPgto(dados.id)));

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

    function criarBotaoEmpenho(id) {
        let a = document.createElement('a');
        a.classList.add('btn');
        a.classList.add('btn-primary');
        a.classList.add('btn-sm');
        a.classList.add('text-light');
        a.href = `<?=SERVERURL?>formacao/empenho_cadastro&id=${id}`;
        a.textContent = 'Empenho';
        return a;
    }

    function criarBotaoPgto(id) {
        let a = document.createElement('a');
        a.classList.add('btn');
        a.classList.add('btn-primary');
        a.classList.add('btn-sm');
        a.classList.add('text-light');
        a.href = `<?=SERVERURL?>formacao/pagamento&id=${id}`;
        a.textContent = 'Pagamento';
        return a;
    }

    function mensagemSemResultados(tbody) {
        let tr = document.createElement('tr');
        let td = criarColuna('Nenhum resultado encontrado');
        td.classList.add('text-center');
        td.colSpan = '5';
        tr.appendChild(td);

        tbody.appendChild(tr);
    }

    function limparTabela(nada = true) {
        let trs = document.querySelectorAll('tbody tr');
        trs.forEach((tr) => {
            tr.remove();
        });
        if (nada) {
            mensagemSemResultados(tbody)
        }
    }
</script>