<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class FormacaoModel extends MainModel
{

    protected function getCargos()
    {
        return DbModel::consultaSimples("SELECT * FROM formacao_cargos where publicado = 1")->fetchAll(PDO::FETCH_OBJ);
    }

    protected function getCoordenadorias()
    {
        return DbModel::consultaSimples("SELECT * FROM coordenadorias where publicado = 1")->fetchAll(PDO::FETCH_OBJ);
    }

    protected function getProgramas()
    {

        $sql = "SELECT p.id as id, p.programa as programa, p.verba_id as verba_id, p.edital as edital, p.descricao as descricao, p.publicado, v.verba as nome_verba 
                FROM programas p
                INNER JOIN verbas v ON p.verba_id = v.id
                WHERE p.publicado = 1";
        $pdo = parent::connection();
        $statement = $pdo->prepare($sql);
        $statement->execute();
        return $statement;
    }

    protected function getLinguagens()
    {
        return DbModel::consultaSimples("SELECT * FROM linguagens where publicado = 1")->fetchAll(PDO::FETCH_OBJ);
    }

    protected function getProjetos()
    {
        return DbModel::consultaSimples("SELECT * FROM projetos where publicado = 1")->fetchAll(PDO::FETCH_OBJ);
    }

    protected function getSubprefeituras()
    {
        return DbModel::consultaSimples("SELECT * FROM subprefeituras where publicado = 1")->fetchAll(PDO::FETCH_OBJ);
    }

    protected function getTerritorios()
    {
        return DbModel::consultaSimples("SELECT * FROM territorios where publicado = 1")->fetchAll(PDO::FETCH_OBJ);
    }

    protected function getVigencias()
    {
        return DbModel::consultaSimples("SELECT * FROM formacao_vigencias where publicado = 1")->fetchAll(PDO::FETCH_OBJ);
    }

    protected function getPedidos()
    {
        return DbModel::consultaSimples("SELECT p.id, p.origem_id,fc.protocolo, fc.ano, p.numero_processo,fc.num_processo_pagto, pf.nome, v.verba, fs.status, fc.form_status_id 
            FROM pedidos p 
            INNER JOIN formacao_contratacoes fc ON fc.id = p.origem_id 
            INNER JOIN pessoa_fisicas pf ON fc.pessoa_fisica_id = pf.id
            INNER JOIN verbas v on p.verba_id = v.id 
            INNER JOIN formacao_status fs on fc.form_status_id = fs.id
            WHERE fc.form_status_id != 5 AND p.publicado = 1 AND fc.publicado = 1 AND p.origem_tipo_id = 2")->fetchAll(PDO::FETCH_OBJ);
    }

    //retorna uma string ou um objeto com todos os locais que o pedido possui
    protected function getLocaisFormacao($contratacao_id, $obj = NULL)
    {
        $locais = "";
        $locaisArrays = DbModel::consultaSimples("SELECT l.id, l.local FROM formacao_locais AS fl INNER JOIN locais AS l ON fl.local_id = l.id WHERE form_pre_pedido_id = $contratacao_id")->fetchAll();
        if ($obj != NULL):
            return $locaisArrays;
        else:
            foreach ($locaisArrays as $locaisArray) {
                $locais = $locais . $locaisArray['local'] . '; ';
            }
            return substr($locais, 0, -2);
        endif;
    }

    protected function getValorTotalVigencia($vigencia_id)
    {
        $valor = "";
        $arrayValores = DbModel::consultaSimples("SELECT valor FROM formacao_parcelas WHERE formacao_vigencia_id = '$vigencia_id' AND publicado = 1 AND valor != 0.00")->fetchAll();
        foreach ($arrayValores as $arrayValor):
            $valor = $valor + $arrayValor['valor'];
        endforeach;

        return $valor;
    }

    protected function getVerbas()
    {
        return DbModel::consultaSimples("SELECT * FROM verbas where publicado = 1")->fetchAll(PDO::FETCH_OBJ);
    }

    protected function getDadosContratacao()
    {

        $sql = "SELECT
                c.id AS 'id',
                c.protocolo AS 'protocolo',
                pf.nome AS 'pessoa',
                c.ano AS 'ano',
                p.programa AS 'programa',
                l.linguagem AS 'linguagem',
                fc.cargo AS 'cargo'
                FROM formacao_contratacoes AS c
                INNER JOIN pessoa_fisicas AS pf ON pf.id = c.pessoa_fisica_id
                INNER JOIN programas AS p ON p.id = c.programa_id
                INNER JOIN linguagens AS l ON l.id = c.linguagem_id
                INNER JOIN formacao_cargos AS fc ON fc.id = c.form_cargo_id
                WHERE c.publicado = 1";
        $pdo = parent::connection();
        $statement = $pdo->prepare($sql);
        $statement->execute();
        return $statement;
    }

    protected function getPF()
    {
        return DbModel::consultaSimples("SELECT * FROM pessoa_fisicas")->fetchAll(PDO::FETCH_OBJ);
    }

}

