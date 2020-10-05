<?php

require_once "./controllers/FormacaoController.php";

$id = isset($_GET['id']) ? $_GET['id'] : null;


?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Formação</h1>
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
                <div class="card card-info card-outline     ">
                    <div class="card-header">
                        <h3 class="card-title">Pesquisar por pessoa física</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row justify-content-center">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="row mx-2">
                                <div class="col-12">
                                    <div class="row">
                                        <label for="tipoDocumento">Tipo de documento: </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="tipoDocumento" value="1" onclick="defineCampo()"
                                                   id="cpf_check">CPF
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="tipoDocumento" value="2" id="passaporte_check" 
                                                   onclick="defineCampo()">Passaporte
                                        </label>
                                    </div>
                                    <div class="row">
                                        <label for="procurar">Pesquisar:</label>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <label for="cpf" id="textoDocumento"></label>
                                            <input type="text" class="form-control" name=""
                                                   id="documento">

                                        </div>
                                    </div>

                                    <div class="panel panel-default">
                                        <!-- Default panel contents
                                        Table -->
                                        <table class="table" id="tabela">
                                            <thead>
                                            <tr>
                                                <th>Nome</th>
                                                <th id="trocaDoc">CPF</th>
                                                <th>E-mail</th>
                                                <th>Ação</th>
                                            </tr>
                                            </thead>
                                            <tbody id="tb-effect">
                                            <tr>

                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<script>
    let pesquisaDocumento = document.querySelector('#documento');
    let tbody = document.querySelector('tbody');
    let cpf = $('#documento').val();


    function defineCampo() {
        let checkbox_cpf = $('#cpf_check');
        let checkbox_passaporte = $('#passaporte_check');
        let documento = $('#documento');
        if (checkbox_cpf.prop('checked')) {
            documento.attr("data-mask", "999.999.999-99");
            documento.attr("name", "cpf");
            documento.attr("data-id", "cpf");
        } else if (checkbox_passaporte.prop('checked')) {
            documento.attr("name", "passaporte");
            documento.removeAttr("data-mask");
            documento.removeAttr("maxlength");
            documento.attr("data-id", "passaporte");
        }
        documento.val('');
    }


    pesquisaDocumento.addEventListener("keyup", () => {
        let tipo_doc = $('#documento').attr("data-id");
        limparTabela(false)
        if (pesquisaDocumento.value == '') {
            limparTabela();
        } else {
            $.ajax({
                type: "POST",
                url: "<?= SERVERURL ?>ajax/formacaoAjax.php",
                data: {
                    _method: 'pesquisaPf',
                    search: `${pesquisaDocumento.value}`,
                    where: tipo_doc,
                },
                success: function (data, text) {
                    limparTabela(false);
                    if (text == 'success' && data != 0) {
                        const resultado = JSON.parse(data)[0];
                        //limparTabela(false);
                        resultado.forEach((result) => {
                            //console.log(result);
                            criarLinha(result);
                        })

                    } else if (data == 0) {
                        limparTabela(true)
                        //mensagemSemResultados(tbody);
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
        tr.appendChild(criarColuna(dados.nome));
        tr.appendChild(criarColuna(dados.documento));
        tr.appendChild(criarColuna(dados.email));
        tr.appendChild(criarColuna(criarBotaoSelecionar(dados.id)));

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

    function criarBotaoSelecionar(id) {
        let a = document.createElement('a');
        a.classList.add('btn');
        a.classList.add('btn-primary');
        a.classList.add('btn-sm');
        a.classList.add('text-light');
        a.href = `<?=SERVERURL?>formacao/pf_cadastro&id=${id}`;
        a.textContent = 'Selecionar';
        return a;
    }

    function criarBotaoAdicionar() {
        let strCPF = document.querySelector('#documento').value;
        //Verificar qual documento será enviado

        if ($("#cpf_check").is(':checked')) {
            var tipo_documento = 1;
            
        } else {
            var tipo_documento = 2;
            let documento = $('#documento').val();
            doc = documento.replace(/[.]+/g, 'p');
            doc = doc.replace('-', 't');
            let a = document.createElement('a');
                a.classList.add('btn');
                a.classList.add('btn-primary');
                a.classList.add('btn-sm');
                a.classList.add('text-light');
                a.href = `<?=SERVERURL?>formacao/pf_cadastro&doc=${doc}&type=${tipo_documento}`;
                a.textContent = 'Adicionar';
                return a;
        }
        let documento = $('#documento').val();
        if (documento.length >= 14 && tipo_documento == 1) {
            var validado = TestaCPF(strCPF);
            if (!validado) {
                event.preventDefault()
                alert("CPF inválido")
            }
        else{
                doc = documento.replace(/[.]+/g, 'p');
                doc = doc.replace('-', 't');
                let a = document.createElement('a');
                a.classList.add('btn');
                a.classList.add('btn-primary');
                a.classList.add('btn-sm');
                a.classList.add('text-light');
                a.href = `<?=SERVERURL?>formacao/pf_cadastro&doc=${doc}&type=${tipo_documento}`;
                a.textContent = 'Adicionar';
                return a;
            
        }
            
        }
        
    }

    function TestaCPF(cpf) {
        
        var Soma;
        var Resto;
        var strCPF = cpf.replace(/[.]+/g, '');
        strCPF = strCPF.replace('-','');
        Soma = 0;

        if (strCPF === "11111111111" ||
            strCPF === "22222222222" ||
            strCPF === "33333333333" ||
            strCPF === "44444444444" ||
            strCPF === "55555555555" ||
            strCPF === "66666666666" ||
            strCPF === "77777777777" ||
            strCPF === "88888888888" ||
            strCPF === "99999999999")
            return false;

        for (i = 1; i <= 9; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (11 - i);
        Resto = (Soma * 10) % 11;

        if ((Resto == 10) || (Resto == 11)) Resto = 0;
        if (Resto != parseInt(strCPF.substring(9, 10))) return false;

        Soma = 0;
        for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (12 - i);
        Resto = (Soma * 10) % 11;

        if ((Resto == 10) || (Resto == 11)) Resto = 0;
        if (Resto != parseInt(strCPF.substring(10, 11))) return false;
        return true;
    }

    function mensagemSemResultados(tbody) {
        let tr = document.createElement('tr');
        console.log()
        let td = criarColuna(criarBotaoAdicionar());
        //td.classList.add('text-center');
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
            mensagemSemResultados(tbody)
        }
    }
</script>