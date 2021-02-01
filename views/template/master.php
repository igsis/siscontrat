<?php
$template = new ViewsController();

$pedidoAjax = false;

require_once './controllers/EventoController.php';

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>SisContrat | SMC</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= SERVERURL ?>views/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= SERVERURL ?>views/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?= SERVERURL ?>views/dist/css/custom.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= SERVERURL ?>views/plugins/datatables/dataTables.bootstrap4.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="<?= SERVERURL ?>views/plugins/daterangepicker/daterangepicker.css">
    <!-- Sweet Alert 2 -->
    <script src="<?= SERVERURL ?>views/plugins/sweetalert2/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="<?= SERVERURL ?>views/plugins/sweetalert2/sweetalert2.css">
    <!-- summernote -->
    <link rel="stylesheet" href="<?= SERVERURL ?>views/plugins/summernote/summernote-bs4.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- jQuery -->
    <script src="<?= SERVERURL ?>views/plugins/jquery/jquery.min.js"></script>
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= SERVERURL ?>views/dist/img/SisContratLogo.png" />
    <link rel="icon" href="<?= SERVERURL ?>views/dist/img/SisContratLogo.png" />
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= SERVERURL ?>views/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?= SERVERURL ?>views/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

</head>
<!--<body class="hold-transition login-page">-->
<body class="hold-transition sidebar-mini">
<?php

$view = $template->exibirViewController();
if ($view == 'index'):
    require_once "./views/modulos/inicio/login.php";
elseif ($view == 'login'):
    require_once "./views/modulos/inicio/login.php";
elseif ($view == 'cadastro'):
    require_once "./views/modulos/inicio/cadastro.php";
elseif ($view == 'recupera_senha'):
    require_once "./views/modulos/inicio/recupera_senha.php";
elseif($view == 'resete_senha'):
    require_once "./views/modulos/inicio/resete_senha.php";
else:
    session_start(['name' => 'sis']);
    require_once "./controllers/UsuarioController.php";
    $usuario = new UsuarioController();

    if (!isset($_SESSION['usuario_id_s'])) {
        $usuario->forcarFimSessao();
    }
    ?>
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <?php $template->navbar(); ?>
        </nav>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <?php include $view ?>
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <?php include $template->sidebar(); ?>
        </aside>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Sobre</h5>
                <p>Versão 2.0</p>
                <br>
                <p>Desenvolvido por:</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <?php $template->footer() ?>
        </footer>
    </div>
    <!-- ./wrapper -->
<?php endif; ?>
<!-- REQUIRED SCRIPTS -->
<?php if(isset($sectionJS))
        echo $sectionJS;
?>

<a href="https://forms.gle/ktjaMbEHmANLuFXi8" class="btn btn-warning" target="_blank"
   style="position:fixed;bottom:40px;right:40px;text-align:center;
   box-shadow: 1px 1px 2px #888;z-index:1000;">
    <i class="fas fa-exclamation-circle"></i>
    Deixe sua opnião</a>

<!-- jQuery -->
<script src="<?= SERVERURL ?>views/plugins/jquery/jquery.min.js"></script>
<script src="<?= SERVERURL ?>views/plugins/moment/moment.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= SERVERURL ?>views/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= SERVERURL ?>views/dist/js/adminlte.min.js"></script>
<!-- Summernote -->
<script src="<?= SERVERURL ?>views/plugins/summernote/summernote-bs4.min.js"></script>
<script src="<?= SERVERURL ?>views/plugins/summernote/lang/summernote-pt-BR.js"></script>
<script src="<?= SERVERURL ?>views/plugins/summernote/summernote-cleaner.js"></script>
<!-- Outros Scripts -->
<script src="<?= SERVERURL ?>views/dist/js/main.js"></script>
<script src="<?= SERVERURL ?>views/plugins/jquery-mask/jquery.mask.js"></script>
<!-- DataTables -->
<script src="<?= SERVERURL ?>views/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= SERVERURL ?>views/plugins/datatables/dataTables.bootstrap4.js"></script>
<!-- date-range-picker -->
<script src="<?= SERVERURL ?>views/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Select2 -->
<script src="<?= SERVERURL ?>views/plugins/select2/js/select2.full.min.js"></script>
<script src="<?= SERVERURL ?>views/plugins/select2/js/i18n/pt-BR.js" type="text/javascript"></script>

<script>
    $(document).ready(function (){
        //Initialize Select2 Elements
        $('.select2').select2();

        $('.select2bs4').select2({
            theme: 'bootstrap4',
            language: 'pt-BR'
        });
    });

    $('#rangeDate').daterangepicker({
        "locale": {
            "format": "DD/MM/YYYY",
            "separator": " - ",
            "applyLabel": "Aplicar",
            "cancelLabel": "Cancelar",
            "daysOfWeek": [
                "Dom",
                "Seg",
                "Ter",
                "Qua",
                "Qui",
                "Sex",
                "Sab"
            ],
            "monthNames": [
                "Janeiro",
                "Fevereiro",
                "Março",
                "Abril",
                "Maio",
                "Junho",
                "Julho",
                "Agosto",
                "Setembro",
                "Outubro",
                "Novembro",
                "Dezembro"
            ],
        }
    })
    $('#rangeDate').val('');

    $.ajax({
        type: "POST",
        url: "<?= SERVERURL ?>ajax/eventoAjax.php",
        data: {
            _method: 'notificacao',
            id: <?= $_SESSION['usuario_id_s'] ?>,
        },
        success: (data, text) => {
            if (data) {
                let dados = JSON.parse(data);
                let notificacao = document.querySelector('.nav-link .badge');
                let msgNotificacao = document.querySelector('.nav-item .dropdown-menu .dropdown-header');
                let menuNotificacao = document.querySelector('.nav-item .dropdown-menu');
                let divisor = document.createElement('div');
                divisor.classList.add('dropdown-divider');
                if (dados.length){
                    notificacao.innerHTML = dados.length;
                    msgNotificacao.innerHTML = `Você tem ${dados.length} eventos que foram reabertos`;

                    for (let x = 0; x < dados.length; x++){
                        menuNotificacao.append(divisor);

                        let nomeEvento = dados[x].nome_evento;
                        menuNotificacao.append(linhaNotificacao(`${nomeEvento.substr(0,25)}...`, dados[x].data_reabertura));
                    }

                    menuNotificacao.append(divisor);

                    let eventos = document.createElement('a');
                    eventos.classList.add('dropdown-item');
                    eventos.classList.add('dropdown-footer');
                    eventos.href = '<?= SIS2URL ?>?perfil=evento&p=evento_lista';
                    eventos.append('Veja Todos');

                    menuNotificacao.append(eventos);
                }
                else {

                }
            }

        },
        error: () => {

        }
    })

    function linhaNotificacao(nome, data){


        let linha = document.createElement('a');
        linha.classList.add('dropdown-item');
        linha.href = '#';

        let date = document.createElement('span');
        date.classList.add('float-right');
        date.classList.add('text-muted');
        date.classList.add('text-sm');
        date.append(data);

        linha.append(nome);
        linha.append(date);

        return linha;
    }
</script>
<?= (isset($javascript)) ? $javascript : ''; ?>
</body>
</html>
