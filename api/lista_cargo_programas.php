<?php
$pedidoAjax = true;
require_once "../controllers/FormacaoController.php";
$formObj = new FormacaoController();

require_once "../models/MainModel.php";

$db = new MainModel();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Content-Type: application/json');

if(isset($_GET['todos'])):
    $consulta = "SELECT id, cargo FROM formacao_cargos WHERE publicado = 1";
    $res = $db->consultaSimples($consulta)->fetchAll();
    $cargos = json_encode($res);
    print_r($cargos);
endif;

if (isset($_GET['id'])):
    $programa_id = $_GET['id'];

    $consulta = "SELECT c.id, c.cargo FROM cargo_programas AS cp
                 INNER JOIN programas AS p ON cp.programa_id = p.id
                 INNER JOIN formacao_cargos AS c ON cp.formacao_cargo_id = c.id
                 WHERE p.publicado = 1 AND c.publicado = 1 AND cp.programa_id = $programa_id";

    if(isset($_GET['select'])):
        $res = $db->consultaSimples($consulta)->fetchAll();
        $cargos = json_encode($res);
        print_r($cargos);
    endif;
endif;
