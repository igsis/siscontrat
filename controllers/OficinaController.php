<?php
if ($pedidoAjax) {
    require_once "../models/OficinaModel.php";
    require_once "../controllers/EventoController.php";
} else {
    require_once "./models/OficinaModel.php";
    require_once "./controllers/EventoController.php";
}

class OficinaController extends OficinaModel
{
    public function recuperaOficinasCapac($dados = [])
    {

        $protocolo = '';
        $nomeEvento = '';
        $publico = '';

        if ($dados['protocolo'] != "") {
            $protocolo = " AND e.protocolo = '{$dados['protocolo']}'";
        }

        if ($dados['nome_evento'] != "") {
            $nomeEvento = " AND e.nome_evento = '{$dados['nome_evento']}'";
        }

        if ($dados['publico'] != "") {
            $publico = " AND p.id = '{$dados['publico']}'";
        }

        $sql = "SELECT 	e.id,
                        e.nome_evento,
                        e.protocolo,
                        DATE_FORMAT(e.data_cadastro, '%d/%m/%Y')  as 'data_cadastro',
                        (SELECT GROUP_CONCAT(' ',p.publico) FROM capac_new.evento_publico AS ep
                                INNER JOIN capac_new.publicos AS p ON ep.publico_id = p.id
                                WHERE ep.evento_id = e.id
                            ) AS publico
                FROM capac_new.eventos AS e
                LEFT JOIN capac_new.evento_publico AS ep ON e.id = ep.evento_id
                LEFT JOIN capac_new.publicos AS p ON p.id = ep.publico_id
                WHERE e.publicado = 2 AND protocolo != '' {$protocolo} {$publico} {$nomeEvento} ";

        return DbModel::consultaSimples($sql, true)->fetchAll(PDO::FETCH_OBJ);
    }

    public function recuperaOficinaCapac($id)
    {
        $idEvento = MainModel::decryption($id);
        $sql = "SELECT 	ev.id, ev.protocolo, ev.nome_evento, ev.espaco_publico, ev.sinopse, tc.tipo_contratacao,
                        ev.data_cadastro, ev.data_envio, oc.data_inicio, oc.data_fim, oc.integrantes, oc.links,
                        oc.quantidade_apresentacao, mo.modalidade, of.linguagem, os.sublinguagem, ofn.nivel,
                        oc.execucao_dia1_id, oc.execucao_dia2_id, p.*
                FROM eventos AS ev
                LEFT JOIN tipos_contratacoes AS tc ON ev.tipo_contratacao_id = tc.id
                LEFT JOIN ofic_cadastros AS oc ON ev.id = oc.evento_id
                LEFT JOIN modalidades AS mo ON oc.modalidade_id = mo.id
                LEFT JOIN ofic_linguagens AS of ON oc.ofic_linguagem_id = of.id
                LEFT JOIN ofic_sublinguagens AS os ON oc.ofic_sublinguagem_id = os.id
                LEFT JOIN ofic_niveis AS ofn ON oc.ofic_nivel_id = ofn.id 
                LEFT JOIN pedidos AS p on oc.id = p.origem_id 
                WHERE ev.id = {$idEvento}";

        return DbModel::consultaSimples($sql, true)->fetchObject();
    }

    public function exibeDescricaoPublico()
    {
        return (new EventoController)->exibeDescricaoPublico();
    }

    public function recuperaPublico($id)
    {
        $idEvento = MainModel::decryption($id);

        $sql = "SELECT p.publico, p.descricao 
                FROM evento_publico AS ep LEFT JOIN publicos AS p  ON ep.publico_id = p.id
                WHERE ep.evento_id = {$idEvento}";

        return DbModel::consultaSimples($sql, true)->fetchAll(PDO::FETCH_OBJ);
    }

    public function recuperaPfCapac($id)
    {
        $pf = DbModel::consultaSimples(
            "SELECT pf.*, pe.*, pb.*, n.nacionalidade, e.descricao, g.genero, gi.grau_instrucao, pd.trans, pd.pcd, d.drt, ni.nit
                        FROM pessoa_fisicas AS pf
                        LEFT JOIN pf_detalhes AS pd ON pf.id = pd.pessoa_fisica_id
                        LEFT JOIN etnias AS e ON pd.etnia_id = e.id
                        LEFT JOIN generos AS g ON pd.genero_id = g.id
                        LEFT JOIN grau_instrucoes AS gi ON pd.grau_instrucao_id = gi.id
                        LEFT JOIN pf_enderecos AS pe ON pf.id = pe.pessoa_fisica_id
                        LEFT JOIN pf_bancos AS pb ON pf.id = pb.pessoa_fisica_id
                        LEFT JOIN nacionalidades AS n ON pf.nacionalidade_id = n.id
                        LEFT JOIN drts AS d ON pf.id = d.pessoa_fisica_id
                        LEFT JOIN nits AS ni ON pf.id = ni.pessoa_fisica_id
                        WHERE pf.id = '$id'", true);

        $pf = $pf->fetch(PDO::FETCH_ASSOC);

        $telefones = DbModel::consultaSimples("SELECT * FROM pf_telefones WHERE pessoa_fisica_id = '$id'", true)->fetchAll(PDO::FETCH_ASSOC);

        foreach ($telefones as $key => $telefone) {
            $pf['telefones']['tel_' . $key] = $telefone['telefone'];
        }
        return $pf;
    }

    public function recuperaPjCapac($id)
    {
        $pj = DbModel::consultaSimples(
            "SELECT pj.* , bc.banco, pe.logradouro, pe.numero, pe.complemento, pe.bairro, pe.cidade, pe.uf, pe.cep, pb.agencia, pb.conta
                      FROM pessoa_juridicas AS pj
                      LEFT JOIN pj_enderecos pe on pj.id = pe.pessoa_juridica_id
                      LEFT JOIN pj_bancos pb on pj.id = pb.pessoa_juridica_id
                      LEFT JOIN bancos bc on pb.banco_id = bc.id
                    WHERE pj.id = '$id'", true);
        $pj = $pj->fetch(PDO::FETCH_ASSOC);
        $telefones = DbModel::consultaSimples("SELECT * FROM pj_telefones WHERE pessoa_juridica_id = '$id'", true)->fetchAll(PDO::FETCH_ASSOC);


        foreach ($telefones as $key => $telefone) {
            $pj['telefones']['tel_' . $key] = $telefone['telefone'];
        }

        return $pj;
    }

    public function exibeExecucaoDia($id)
    {
        $sql = "SELECT dia FROM execucao_dias WHERE id = '{$id}'";

        return DbModel::consultaSimples($sql, true)->fetchObject()->dia;
    }
}