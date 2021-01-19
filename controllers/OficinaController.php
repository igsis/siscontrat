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
                        oc.execucao_dia1_id, oc.execucao_dia2_id
                FROM eventos AS ev
                LEFT JOIN tipos_contratacoes AS tc ON ev.tipo_contratacao_id = tc.id
                LEFT JOIN ofic_cadastros AS oc ON ev.id = oc.evento_id
                LEFT JOIN modalidades AS mo ON oc.modalidade_id = mo.id
                LEFT JOIN ofic_linguagens AS of ON oc.ofic_linguagem_id = of.id
                LEFT JOIN ofic_sublinguagens AS os ON oc.ofic_sublinguagem_id = os.id
                LEFT JOIN ofic_niveis AS ofn ON oc.ofic_nivel_id = ofn.id WHERE ev.id = {$idEvento}";

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

    public function exibeExecucaoDia($id)
    {
        $sql = "SELECT dia FROM execucao_dias WHERE id = '{$id}'";

        return DbModel::consultaSimples($sql, true)->fetchObject()->dia;
    }
}