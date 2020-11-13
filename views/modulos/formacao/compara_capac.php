<?php
$pfObj = new PessoaFisicaController();

$dados = $pfObj->comparaPf($_GET['id']);
?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Importar do Capac</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card card-info card-outline">
            <div class="card-header">
                <h3 class="card-title">Jão das Neves</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-success card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Capac</h3>
                                <div class="card-tools">
                                    <span class="badge badge-warning">Última atualização: 01/01/2020</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Nome:</label>
                                    <div class="input-group">
                                        <input type="text" name="message" class="form-control" id value="Jão" readonly>
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-success" onclick="passaValor('aeoo')">
                                                <i class="fas fa-arrow-alt-circle-right"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-primary card-outline">
                            <form>
                                <div class="card-header">
                                    <h3 class="card-title">Siscontrat</h3>
                                    <div class="card-tools">
                                        <span class="badge badge-warning">Última atualização: 10/07/2020</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Nome:</label>
                                        <div class="input-group">
                                            <span class="input-group-prepend">
                                                <button type="button" class="btn btn-danger">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                            </span>
                                            <input type="text" name="message" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-success float-right">Atualizar Dados</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function passaValor(campo) {
        let campoCpc = '#' + campo + "Cpc";
        let campoSis = '#' + campo + "Sis";

        $(campoSis).val($(campoCpc).val())
    }

    function resetaValor(campo) {
        let campoSis = '#' + campo + "Sis";
        let valorOriginal = $(campoSis).data("valor");

        $(campoSis).val(valorOriginal)
    }
</script>
