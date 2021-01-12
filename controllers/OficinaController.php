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
    public function recuperaOficinaCapac($dados = []){

        $protocolo = '';
        $nomeEvento = '';
        $publico = '';

        if ($dados['protocolo'] != ""){
            $protocolo = " AND e.protocolo = '{$dados['protocolo']}'";
        }

        if ($dados['nome_evento'] != ""){
            $nomeEvento = " AND e.nome_evento = '{$dados['nome_evento']}'";
        }

        if ($dados['publico'] != ""){
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

    public function exibeDescricaoPublico() {
        return (new EventoController)->exibeDescricaoPublico();
    }
}