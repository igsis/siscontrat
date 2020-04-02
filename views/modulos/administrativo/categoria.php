<?php
require_once "./controllers/CategoriaController.php";
$categoriaObj = new CategoriaController();

$categorias = $categoriaObj->listaCategorias();
?>

<div class="content">
    <div class="content-header">
        <h1>Lista de Categoria</h1>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" style="text-align:right">
                <a href="cadastra_categoria">
                    <button class="btn btn-success">Adicionar categoria</button>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header">
                    <h4 class="card-title">Listagem</h4>
                </div>
                <div class="card-body">
                    <table id="tabela" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Categoria</th>
                                <th width="5%">Editar</th>
                                <th width="5%">Excluir</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($categorias as $categoria): ?>
                            <tr>
                                    <td><?=$categoria->categoria_atracao?></td>
                                    <td align="center">
                                        <a href="<?= SERVERURL . "administrativo/cadastra_categoria&id=" . $categoriaObj->encryption($categoria->id) ?>">
                                           <button type="button" class="btn btn-sm btn-primary btn-block"><i class="fas fa-edit"></i></button>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#">
                                           <button type="button" class="btn btn-sm btn-danger btn-block"><i class="fas fa-trash"></i></button>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        
                        <tfoot>
                            <tr>
                                <th>Categoria</th>
                                <th width="5%">Editar</th>
                                <th width="5%">Excluir</th>
                            </tr>
                        </tfoot>
                        </table>
                </div>

                <div class="card-footer">
                </div>
            </div>
        </div>
    </div>
</div>