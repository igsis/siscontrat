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
                    <div class="row" >
                        <div class="col-12">
                        <div class="row mx-2">
                            <div class="col-12">
                                <form class="form-horizontal formulario-ajax" action="<?= SERVERURL ?>ajax/formacaoAjax.php" 
                                method="POST" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                                    <input type="hidden" name="_method" value="">
                                    <?php if ($id): ?>
                                        <input type="hidden" name="id" id="modulo_id" value="<?= $id ?>">
                                    <?php endif; ?>
                                    <div class="row">
                                        <label for="tipoDocumento">Tipo de documento: </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="tipoDocumento" value="1" checked>CPF
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="tipoDocumento" value="2">Passaporte
                                        </label>
                                    </div>
                                    <div class="row">
                                        <label for="procurar">Pesquisar:</label>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <label for="cpf" id="textoDocumento">CPF *</label>
                                                <input type="text" class="form-control" minlength=14 name="procurar"
                                                value="" id="cpf" data-mask="000.000.000-00" minlength="14">
                                            <input type="text" class="form-control" name="passaporte" id="passaporte"
                                                value="" maxlength="10">
                                                
                                        </div>        
                                    </div>                                        
                                    
                                    <div class="card-footer">
                                        <a href="<?= SERVERURL ?>formacao/pf_lista">
                                            <button type="button" class="btn btn-default pull-left">Voltar</button>
                                        </a>
                                        <button type="submit" name="cadastra" id="cadastra" class="btn btn-primary float-right">
                                            Buscar
                                        </button>
                                    </div >
                                    <div class="resposta-ajax"></div>
                                </form>

                                <div class="panel panel-default">
                                    <!-- Default panel contents -->
                                    <!-- Table -->
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th id="trocaDoc">CPF</th>
                                            <th>E-mail</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <!-- <?php
                                        if ($exibir) {
                                            echo $resultado;
                                        } elseif (!$exibir) {
                                            echo $resultado;
                                        } else {
                                            echo $resultado;
                                        }
                                        ?> -->
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
    let tipos = document.querySelectorAll("input[type='radio'][name='tipoDocumento']");
    let passaporte = document.querySelector("input[name='passaporte']");
    let procurar = document.querySelector("input[name='procurar']");
    let trocaDoc = document.querySelector("#trocaDoc");

    for (const tipo of tipos) {
        tipo.addEventListener('change', tp => {

            const nulo = null;

            passaporte.value = nulo
            procurar.value = nulo

            if (tp.target.value == 1) {
                passaporte.style.display = 'none'
                procurar.disabled = false
                passaporte.disabled = true
                procurar.style.display = 'block'
                procurar.value = ''
                $('#textoDocumento').text('CPF *')
            } else {
                passaporte.style.display = 'block'
                passaporte.disabled = false
                passaporte.value = ''
                procurar.disabled = true
                procurar.style.display = 'none'
                $('#textoDocumento').text('Passaporte *')
            }
        })
    }

    if (`<?=$tipoDocumento?>` == 2) {
        trocaDoc.innerHTML = 'Passaporte'
        tipos[1].checked = true
        passaporte.style.display = 'block'
        passaporte.disabled = false
        procurar.disabled = true
        procurar.style.display = 'none'
    } else {
        passaporte.style.display = 'none'
        passaporte.disabled = true
    }

    /**
     * @return {boolean}
     */
    function TestaCPF(cpf) {
        var Soma;
        var Resto;
        var strCPF = cpf;
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

    function validacao() {
        var strCPF = document.querySelector('#cpf').value;

        if (strCPF != null) {
            // tira os pontos do valor, ficando apenas os numeros
            strCPF = strCPF.replace(/[^0-9]/g, '');

            var validado = TestaCPF(strCPF);

            if (!validado)
                $("#adicionar").attr("disabled", true);
            else
                $("#adicionar").attr("disabled", false);

        }
    }


    $('#formulario').submit(function (event) {
        var strCPF = document.querySelector('#cpf').value;

        if (strCPF !== '' && `<?=$tipoDocumento?>` != 2) {
            console.log(`<?=$tipoDocumento?>`)
            // tira os pontos do valor, ficando apenas os numeros
            strCPF = strCPF.replace(/[^0-9]/g, '');

            var validado = TestaCPF(strCPF);

            if (!validado) {
                event.preventDefault()
                alert("CPF inválido")
            }
        }
    })


</script>
