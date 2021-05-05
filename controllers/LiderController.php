<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class LiderController extends MainModel
{
    /**
     * @param int|string $pedido_id
     * @param int|string $atracao_id
     * @param false $capac
     * <p>True se for para conectar no banco capac</p>
     * @return object
     */
    public function recuperaLider($pedido_id, $atracao_id, $capac = false):stdClass
    {
        $pedido_id = MainModel::decryption($pedido_id);
        $atracao_id = MainModel::decryption($atracao_id);
        $pf = DbModel::consultaSimples(
            "SELECT pf.id, pf.nome, pf.nome_artistico, pf.rg, pf.passaporte, pf.cpf, pf.email, d.*, ns.nome_social 
            FROM lideres AS l 
            INNER JOIN pessoa_fisicas pf on l.pessoa_fisica_id = pf.id
            LEFT JOIN drts d on pf.id = d.pessoa_fisica_id
            LEFT JOIN pf_nome_social ns on pf.id = ns.pessoa_fisica_id
            WHERE l.pedido_id = '$pedido_id' AND l.atracao_id = '$atracao_id'", $capac)->fetch(PDO::FETCH_ASSOC);

        if ($pf['nome_social']){
            $pf['nome_exibicao'] = $pf['nome_social'] . " (" . $pf['nome'] . ")";
        } else {
            $pf['nome_exibicao'] = $pf['nome'];
        }

        $telefones = DbModel::consultaSimples("SELECT * FROM pf_telefones WHERE pessoa_fisica_id = '{$pf['id']}'", $capac)->fetchAll(PDO::FETCH_ASSOC);
        foreach ($telefones as $key => $telefone) {
            $pf['telefones']['tel_'.$key] = $telefone['telefone'];
        }
        return (object)$pf;
    }
}