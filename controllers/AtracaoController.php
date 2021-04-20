<?php
if ($pedidoAjax) {
    require_once "../models/AtracaoModel.php";
    require_once "../controllers/ProdutorController.php";
} else {
    require_once "./models/AtracaoModel.php";
    require_once "./controllers/ProdutorController.php";
}

class AtracaoController extends AtracaoModel
{
    /**
     * @param int|string $idEvento
     * @return object
     */
    public function recuperaAtracao($idEvento):stdClass
    {
        if (gettype($idEvento) == "string") {
            $idEvento = MainModel::decryption($idEvento);
        }
        $atracao =  DbModel::consultaSimples("SELECT a.*, ci.classificacao_indicativa, p.nome, p.email, p.telefone1, p.telefone2, p.observacao 
            FROM atracoes a 
            INNER JOIN classificacao_indicativas ci on a.classificacao_indicativa_id = ci.id 
            LEFT JOIN produtores p on a.produtor_id = p.id
            WHERE evento_id = '$idEvento' AND publicado = 1
        ")->fetchAll(PDO::FETCH_OBJ);

        $acoes = DbModel::consultaSimples("SELECT a.acao FROM acao_atracao at INNER JOIN acoes a on at.acao_id = a.id WHERE atracao_id = '{$atracao['id']}'")->fetchAll(PDO::FETCH_ASSOC);
        $lista = "";
        foreach ($acoes as $acao) {
            $lista .= $acao['acao'] . ", ";
        }
        $atracao['acoes'] = substr($lista,0,-2);

        return (object)$atracao;
    }

    /**
     * @param $idAtracao
     * @return array
     */
    public function recuperaIntegrante($idAtracao)
    {
        if (gettype($idAtracao) == "string") {
            $idAtracao = MainModel::decryption($idAtracao);
        }
        return DbModel::consultaSimples("SELECT * FROM integrantes i INNER JOIN atracao_integrante ai on i.id = ai.integrante_id WHERE atracao_id = '$idAtracao'")->fetchAll(PDO::FETCH_OBJ);
    }
}