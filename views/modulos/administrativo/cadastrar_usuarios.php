<?php

    $url = SERVERURL.'api/verificadorEmail.php';
    require_once "./controllers/AdministrativoController.php";
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $usuarioObj = new AdministrativoController();
    
    $usuario = $usuarioObj->recuperaUsuarios($id);
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-9">
                <h1 class="m-0 text-dark">Cadastrar Usuário</h1>
            </div><!-- /.col -->
            <!-- /.col -->
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
                    <div class="card-body">
                    <div class="row" >
                        <div class="col-12">
                        <form class="form-horizontal formulario-ajax" action="<?= SERVERURL ?>ajax/administrativoAjax.php" 
                        method="POST" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                            <input type="hidden" name="_method" value="<?= ($id) ? "editarUsuarios" : "cadastrarUsuarios" ?>">
                            <?php if ($id): ?>
                                <input type="hidden" name="id" id="usuario_id" value="<?= $id ?>">
                            <?php endif; ?>
                            <div class="box-body">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="nome_completo">Nome Completo *</label>
                                        <input type="text" id="nome_completo" name="nome_completo" value="<?= $usuario->nome_completo ?? "" ?>" class="form-control" required>
                                    </div>
                                    <?php if(isset($usuario->id)): ?>
                                        <div class="form-group col-md-2">
                                            <label for="tipo">É estagiário/jovem monitor? *</label> <br>
                                            <label><input type="radio" name="jovem_monitor" id="jovem_monitor" <?= $usuario->jovem_monitor == 1 ? 'checked' : NULL ?>> Sim </label>&nbsp;&nbsp;
                                            <label><input type="radio" name="jovem_monitor" id="jovem_monitor" <?= $usuario->jovem_monitor == 0 ? 'checked' : NULL ?>> Não </label>
                                        </div>
                                    <?php else: ?>
                                        <div class="form-group col-md-2">
                                            <label for="tipo">É estagiário/jovem monitor? *</label> <br>
                                            <label><input type="radio" name="jovem_monitor" id="jovem_monitor" value="1"> Sim </label>&nbsp;&nbsp;
                                            <label><input type="radio" name="jovem_monitor" id="jovem_monitor" value="0"> Não </label>
                                        </div>
                                    <?php endif ?>
                                    <div class="form-group col-md-2">
                                    <label for="rf_usuario">RF/RG* </label>
                                    <input type="text" id="rgrf_usuario" name="rf_rg" value="<?= $usuario->rf_rg ?? "" ?>" class="form-control" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="rf_usuario">Usuário *</label>
                                        <div id='resposta'></div>
                                        <input type="text" id="usuario" name="usuario" value="<?= $usuario->usuario ?? "" ?>" class="form-control" maxlength="7" required readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4" id="divEmail">
                                        <label for="email">E-mail *</label>
                                        <input type="email" id="email" name="email" value="<?= $usuario->email ?? "" ?>" class="form-control" maxlength="100" required>
                                        <span class="help-block" id="spanHelp"></span>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="telefone">Telefone *</label>
                                        <input data-mask="(00) 0000-00000" type="text" id="telefone" value="<?= $usuario->telefone ?? "" ?>" name="telefone" class="form-control" maxlength="100" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="perfil">Perfil </label> <br>
                                        <select class="form-control" id="perfil_id" name="perfil_id">
                                            <option value="<?= $usuario->perfil_id ?? "" ?>">Selecione...</option>
                                            <?php $usuarioObj->geraOpcao('perfis', $usuario->perfil_id ?? "", false, false, false); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->

                            <div class="card-footer">
                                <a href="<?= SERVERURL ?>administrativo/usuarios">
                                    <button type="button" class="btn btn-default pull-left">Voltar</button>
                                </a>
                                <button type="submit" name="cadastra" id="cadastra" class="btn btn-primary float-right">
                                    Gravar
                                </button>
                            </div >
                            <div class="resposta-ajax"></div>
                        </form>
                        </div>  
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
<script type="application/javascript">
    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#usuarios').addClass('active');
    })
</script>

<script>
    const url = `<?= $url ?>`;
    var email = $('#email');
    var usuario = $('#usuario');
    var rf_rg = $('#rgrf_usuario');

    email.blur(function () {
        $.ajax({
            url: url,
            type: 'POST',
            data: {"email": email.val()},

            success: function (data) {
                let emailCampo = document.querySelector('#email');

                if (data.ok) {
                    emailCampo.classList.remove("is-invalid");
                    $("#cadastra").attr('disabled', false);
                } else {
                    emailCampo.classList.add("is-invalid");
                    $("#cadastra").attr('disabled', true);
                }
            }
        })
    });

    rf_rg.blur(function () {
        $.ajax({
            url: url,
            type: 'POST',
            data: {"usuario": usuario.val()},

            success: function (data) {
                let usuarioCampo = document.querySelector('#usuario');

                if (data.ok) {
                    usuarioCampo.classList.remove("is-invalid");
                    $("#cadastra").attr('disabled', false);
                } else {
                    usuarioCampo.classList.add("is-invalid");
                    $("#cadastra").attr('disabled', true);
                }
            }
        })
    });

    function geraUsuarioRf() {

        // pega o valor que esta escrito no RF
        let usuarioRf = document.querySelector("#rgrf_usuario").value;

        // tira os pontos do valor, ficando apenas os numeros
        usuarioRf = usuarioRf.replace(/[^0-9]/g, '');
        usuarioRf = parseInt(usuarioRf);

        // adiciona o d antes do rf
        usuarioRf = "d" + usuarioRf;

        // limita o rf a apenas o d + 6 primeiros numeros do rf
        let usuario = usuarioRf.substr(0, 7);

        // passa o valor para o input
        document.querySelector("[name='usuario']").value = usuario;
    }


    function geraUsuarioRg() {

        // pega o valor que esta escrito no RG
        let usuarioRg = document.querySelector("#rgrf_usuario").value;

        // tira os pontos do valor, ficando apenas os numeros
        usuarioRg = usuarioRg.replace(/[^0-9]/g, '');
        usuarioRg = parseInt(usuarioRg);

        // adiciona o x antes do rg
        usuarioRg = "x" + usuarioRg;

        // limita o rg a apenas o d + 6 primeiros numeros do rf
        let usuario = usuarioRg.substr(0, 7);

        // passa o valor para o input
        document.querySelector("[name='usuario']").value = usuario;

    }

    $("input[name='jovem_monitor']").change(function () {
        $('#rgrf_usuario').attr("disabled", false);

        let jovemMonitor = document.getElementsByName("jovem_monitor");

        for (i = 0; i < jovemMonitor.length; i++) {
            if (jovemMonitor[i].checked) {
                let escolhido = jovemMonitor[i].value;

                if (escolhido == 1) {
                    $('#rgrf_usuario').val('');
                    $('#rgrf_usuario').focus();
                    $('#rgrf_usuario').unmask();
                    $('#rgrf_usuario').attr('maxlength', '');
                    $('#rgrf_usuario').keypress(function (event) {
                        geraUsuarioRg();
                    });
                    $('#rgrf_usuario').blur(function (event) {
                        geraUsuarioRg();
                    });

                } else if (escolhido == 0) {
                    $('#rgrf_usuario').val('');
                    $('#rgrf_usuario').focus();
                    $('#rgrf_usuario').mask('000.000.0');
                    $('#rgrf_usuario').keypress(function (event) {
                        geraUsuarioRf();
                    });
                    $('#rgrf_usuario').blur(function (event) {
                        geraUsuarioRf();
                    });
                }
            }
        }
    });

</script>