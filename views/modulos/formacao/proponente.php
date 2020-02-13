<?php
if (isset($_SESSION['origem_id_c'])) {
    unset($_SESSION['origem_id_c']);
}
if (isset($_SESSION['pedido_id_c'])) {
    unset($_SESSION['pedido_id_c']);
}
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cadastro</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <!-- Horizontal Form -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Pessoa Física</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal" method="POST" action="<?= SERVERURL ?>formacao/pf_cadastro"
                          role="form" id="formularioPf">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="cpf">CPF: *</label>
                                    <input type="text" class="form-control" id="cpf" name="pf_cpf" maxlength="14"
                                           required onkeypress="mask(this, '999.999.999-99')" minlength="14">
                                    <br>
                                    <span style="display: none;" id="dialogError" class="alert alert-danger"
                                          role="alert">CPF inválido</span>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info float-right">Pesquisar</button>
                        </div>
                        <!-- /.card-footer -->
                    </form>
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
        $('#proponente').addClass('active');
    })
</script>