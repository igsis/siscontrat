<?php
require_once "./controllers/FomentoController.php";
$id = $_GET['id'];

$fomentoObj = new FomentoController();

$edital = $fomentoObj->recuperaEdital($id);
$nomeEdital = $edital->titulo;
$idEdital = $edital->id;
$tipoCadastro = $edital->pessoa_tipos_id;

if ($idEdital < 11) {
    $editalAntigo = true;
    if ($tipoCadastro == 1) {
        require_once "./controllers/PessoaFisicaController.php";
        $pessoaFisicaObj = new PessoaFisicaController();
    } else if ($tipoCadastro == 2) {
        require_once "./controllers/PessoaJuridicaController.php";
        require_once "./controllers/RepresentanteController.php";
        $pessoaJuridicaObj = new PessoaJuridicaController();
        $representanteObj = new RepresentanteController();
    } else {
        require_once "./controllers/PessoaFisicaController.php";
        require_once "./controllers/PessoaJuridicaController.php";
        require_once "./controllers/RepresentanteController.php";

        $pessoaJuridicaObj = new PessoaJuridicaController();
        $representanteObj = new RepresentanteController();
        $pessoaFisicaObj = new PessoaFisicaController();
    }
} else {
    $editalAntigo = false;
}

$statusEdital = $fomentoObj->statusEdital($id);

$projetosAprovados = $fomentoObj;

if ($tipoCadastro != 3) {
    $inscritos = $fomentoObj->listaInscritos($id, $tipoCadastro);
} else {
    $inscritosPj = $fomentoObj->listaInscritos($id, 1);
    $inscritosPf = $fomentoObj->listaInscritos($id, 2);
}
?>

<style>
    .quadr {
        width: 50px;
        height: 15px;
        margin-right: 10px;
        border-radius: 2px;
        text-align: center;
    }
</style>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Projetos Inscritos</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 col-md-3 offset-md-1">
                <div class="info-box">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-thumbs-up"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Projetos Aprovados</span>
                        <span class="info-box-number"><?= $statusEdital->aprovados ?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-sm-6 col-md-4">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-hand-holding-usd"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Valor ainda disponível</span>
                        <span class="info-box-number dinheiro"><?= $statusEdital->valor_disponivel ?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <div class="col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-coins"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Valor Total do Edital</span>
                        <span class="info-box-number dinheiro"><?= $statusEdital->valor_total ?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"><?= $nomeEdital ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row mb-5 d-flex justify-content-end ">
                            <a href="<?= SERVERURL ?>pdf/fomento_inscritos_aprovados.php?id=<?= $id ?>" target="_blank"
                               class="btn btn-warning">
                                <i class="fas fa-download mr-1"></i> Exportar inscritos
                            </a>
                            <?php if ($statusEdital->aprovados): ?>
                                <div class="ml-1"><a
                                            href="<?= SERVERURL ?>pdf/fomento_inscritos_aprovados.php?id=<?= $id ?>&aprovado=true"
                                            target="_blank"
                                            class="btn btn-success">
                                        <i class="fas fa-download mr-1"></i> Inscritos Aprovados
                                    </a></div>
                            <?php endif ?>
                        </div>
                        <table id="tabela" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Protocolo</th>
                                <?php if ($editalAntigo) {
                                    if ($tipoCadastro == 1) {
                                        echo "<th>Nome do Inscrito</th>";
                                    } elseif ($tipoCadastro == 2) {
                                        echo "<th>Nome do Representante</th>";
                                    } else {
                                        echo "<th>Nome do Representante/Inscrito</th>";
                                    }
                                } else {
                                    echo "<th>Nome do projeto</th>";
                                }
                                ?>
                                <th>Valor</th>
                                <th>Status</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (isset($inscritos)):
                                foreach ($inscritos as $inscrito):
                                    ?>
                                    <tr>
                                        <td><?= $inscrito->protocolo ?></td>
                                        <?php if ($editalAntigo) {
                                            if ($tipoCadastro == 1) {
                                                $pfNome = $pessoaFisicaObj->recuperaPessoaFisica($fomentoObj->encryption($inscrito->pessoa_fisica_id), true)["nome"];
                                                echo "<td>$pfNome</td>";
                                            } else {
                                                $idRepresentante = $pessoaJuridicaObj->recuperaPessoaJuridica($fomentoObj->encryption($inscrito->pessoa_juridica_id), true)["representante_legal1_id"];
                                                $representanteNome = $representanteObj->recuperaRepresentante($fomentoObj->encryption($idRepresentante), true)->fetchObject()->nome;
                                                echo "<td>$representanteNome</td>";
                                            }
                                        } else {
                                            echo "<td>$inscrito->nome_projeto</td>";
                                        }
                                        ?>
                                        <td class="dinheiro"><?= $inscrito->valor_projeto ?></td>
                                        <td class="d-flex justify-content-center align-items-center">
                                            <?php switch ($inscrito->publicado) {
                                                case 2:
                                                    echo "<div class=\"quadr bg-green\" data-toggle=\"popover\" data-trigger=\"hover\"
                                                 data-content=\"Aprovado\"></div>";
                                                    break;
                                                case 3:
                                                    echo "<div class=\"quadr bg-danger\" data-toggle=\"popover\" data-trigger=\"hover\"
                                             data-content=\"Reprovado\"></div>";
                                                    break;
                                                default:
                                                    echo "Aguardando";
                                                    break;
                                            } ?>
                                        </td>
                                        <td>
                                            <a href="<?= SERVERURL . "fomentos/detalhes_inscrito&id=" . $fomentoObj->encryption($inscrito->id) ?>"
                                               class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Mais Detalhes</a>
                                        </td>
                                    </tr>
                                <?php
                                endforeach;
                            elseif (isset($inscritosPf)):
                                foreach ($inscritosPj as $inscrito):
                                    ?>
                                    <tr>
                                        <td><?= $inscrito->protocolo ?></td>
                                        <?php if ($editalAntigo) {
                                            $idRepresentante = $pessoaJuridicaObj->recuperaPessoaJuridica($fomentoObj->encryption($inscrito->pessoa_juridica_id), true)["representante_legal1_id"];
                                            $representanteNome = $representanteObj->recuperaRepresentante($fomentoObj->encryption($idRepresentante), true)->fetchObject()->nome;
                                            echo "<td>$representanteNome</td>";
                                        } else {
                                            echo "<td>$inscrito->nome_projeto</td>";
                                        }
                                        ?>
                                        <td class="dinheiro"><?= $inscrito->valor_projeto ?></td>
                                        <td class="d-flex justify-content-center align-items-center">
                                            <?php switch ($inscrito->publicado) {
                                                case 2:
                                                    echo "<div class=\"quadr bg-green\" data-toggle=\"popover\" data-trigger=\"hover\"
                                             data-content=\"Aprovado\"></div>";
                                                    break;
                                                case 3:
                                                    echo "<div class=\"quadr bg-danger\" data-toggle=\"popover\" data-trigger=\"hover\"
                                         data-content=\"Reprovado\"></div>";
                                                    break;
                                                default:
                                                    echo "Aguardando";
                                                    break;
                                            } ?>
                                        </td>
                                        <td>
                                            <a href="<?= SERVERURL . "fomentos/detalhes_inscrito&id=" . $fomentoObj->encryption($inscrito->id) ?>"
                                               class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Mais Detalhes</a>
                                        </td>
                                    </tr>
                                <?php
                                endforeach;
                                foreach ($inscritos as $inscrito):
                                    ?>
                                    <tr>
                                        <td><?= $inscrito->protocolo ?></td>
                                        <?php if ($editalAntigo) {
                                            $pfNome = $pessoaFisicaObj->recuperaPessoaFisica($fomentoObj->encryption($inscrito->pessoa_fisica_id), true)["nome"];
                                            echo "<td>$pfNome</td>";
                                        } else {
                                            echo "<td>$inscrito->nome_projeto</td>";
                                        }
                                        ?>
                                        <td class="dinheiro"><?= $inscrito->valor_projeto ?></td>
                                        <td class="d-flex justify-content-center align-items-center">
                                            <?php switch ($inscrito->publicado) {
                                                case 2:
                                                    echo "<div class=\"quadr bg-green\" data-toggle=\"popover\" data-trigger=\"hover\"
                                                 data-content=\"Aprovado\"></div>";
                                                    break;
                                                case 3:
                                                    echo "<div class=\"quadr bg-danger\" data-toggle=\"popover\" data-trigger=\"hover\"
                                             data-content=\"Reprovado\"></div>";
                                                    break;
                                                default:
                                                    echo "Aguardando";
                                                    break;
                                            } ?>
                                        </td>
                                        <td>
                                            <a href="<?= SERVERURL . "fomentos/detalhes_inscrito&id=" . $fomentoObj->encryption($inscrito->id) ?>"
                                               class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Mais Detalhes</a>
                                        </td>
                                    </tr>
                                <?php
                                endforeach;
                            else:
                                ?>
                                <tr>
                                    <td colspan="4" class="text-center">Este edital ainda não possui projetos
                                        inscritos
                                    </td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Protocolo</th>
                                <th>Nome do projeto</th>
                                <th>Valor</th>
                                <th>Status</th>
                                <th>Ação</th>
                            </tr>
                            </tfoot>
                        </table>
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
    window.addEventListener("load", () => {
        let dinheiros = document.querySelectorAll(".dinheiro");

        dinheiros.forEach((item) => {
            let valor = item.textContent;
            valor = parseFloat(valor);
            let dinheiroBr = valor.toLocaleString('pt-br', {style: 'currency', currency: 'BRL'});

            item.textContent = dinheiroBr;
        })
    })
    $(document).ready(function () {
        $('[data-toggle="popover"]').popover();
    });

</script>