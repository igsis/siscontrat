<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
    require_once "../controllers/PessoaFisicaController.php";
    require_once "../controllers/PessoaJuridicaController.php";
} else {
    require_once "./models/MainModel.php";
    require_once "./controllers/PessoaFisicaController.php";
    require_once "./controllers/PessoaJuridicaController.php";
}

class EventoController extends MainModel
{
    /**
     * @param int|string $idEvento
     * @return object
     */
    public function recuperaEvento($idEvento):stdClass
    {
        if (gettype($idEvento) == "string") {
            $idEvento = MainModel::decryption($idEvento);
        }
        $evento = DbModel::consultaSimples("SELECT eve.*, te.tipo_evento, rj.relacao_juridica, pe.projeto_especial, fis.nome_completo as fiscal_nome, fis.rf_rg as fiscal_rf, sup.nome_completo as suplente_nome, sup.rf_rg as suplente_rf, user.nome_completo as usuario_nome, f.fomento
            FROM eventos eve
            INNER JOIN tipo_eventos te on eve.tipo_evento_id = te.id
            INNER JOIN relacao_juridicas rj on eve.relacao_juridica_id = rj.id
            INNER JOIN projeto_especiais pe on eve.projeto_especial_id = pe.id
            LEFT JOIN usuarios fis on eve.fiscal_id = fis.id
            LEFT JOIN usuarios sup on eve.suplente_id = sup.id
            LEFT JOIN usuarios user on eve.usuario_id = user.id
            INNER JOIN evento_status es on eve.evento_status_id = es.id 
            LEFT JOIN evento_fomento ef on eve.id = ef.evento_id
            LEFT JOIN fomentos f on ef.fomento_id = f.id
            WHERE eve.id = '$idEvento' AND eve.publicado = 1
        ")->fetch(PDO::FETCH_ASSOC);

        $publicos = DbModel::consultaSimples("SELECT * FROM evento_publico ep INNER JOIN publicos p on ep.publico_id = p.id WHERE evento_id = '{$evento['id']}'")->fetchAll(PDO::FETCH_ASSOC);
        $lista = "";
        foreach ($publicos as $publico) {
            $lista .= $publico['publico'] . ", ";
        }
        $evento['publicos'] = substr($lista,0,-2);

        return (object)$evento;
    }

    /**
     * @param int|string $idEvento
     * @return string
     */
    public function recuperaObjetoEvento($idEvento):string
    {
        $idEvento = MainModel::decryption($idEvento);
        $evento = DbModel::consultaSimples("SELECT tipo_evento,nome_evento FROM eventos e INNER JOIN tipo_eventos te ON e.tipo_evento_id = te.id WHERE e.id = '$idEvento'")->fetchObject();
        return $evento->tipo_evento . " " . $evento->nome_evento;
    }

    public function notificacaoEventos($id)
    {
        $sql = "SELECT ev.nome_evento, DATE_FORMAT(er.data_reabertura, '%d/%m/%Y') AS 'data_reabertura' 
            FROM eventos ev
            LEFT JOIN evento_reaberturas er ON ev.id = er.evento_id
            WHERE ev.evento_status_id = 1 
            AND (ev.fiscal_id = '{$id}' OR ev.suplente_id = '{$id}' OR ev.usuario_id = '{$id}')
            AND data_reabertura != ''  AND ev.publicado = 1
            ORDER BY er.data_reabertura";

        $resultado = DbModel::consultaSimples($sql)->fetchAll(PDO::FETCH_OBJ);

        return json_encode($resultado);
    }

    function geraProtocolo($idEvento):string
    {
        $tipo_evento = DbModel::consultaSimples("SELECT tipo_evento_id FROM eventos WHERE id ='$idEvento'")->fetchColumn();
        $date = date('Ymd', strtotime('-3 hours'));
        $preencheZeros = str_pad($idEvento, 5, '0', STR_PAD_LEFT);
        if ($tipo_evento == 1){
            return $date . '.' . $preencheZeros ."-E";
        } elseif ($tipo_evento == 2) {
            return $date . '.' . $preencheZeros . "-C";
        }
    }

    public function retornaPeriodo($idEvento):string
    {
        $idEvento = MainModel::decryption($idEvento);
        $primeiroDia = DbModel::consultaSimples("SELECT MIN(data_inicio) as data_inicio, virada FROM ocorrencias WHERE publicado = 1 AND origem_ocorrencia_id = '$idEvento' LIMIT 0,1")->fetch(PDO::FETCH_OBJ);
        $ultimoDia = DbModel::consultaSimples("SELECT MAX(data_fim) as data_fim FROM ocorrencias WHERE publicado = 1 AND origem_ocorrencia_id = '$idEvento' LIMIT 0,1")->fetch(PDO::FETCH_OBJ);

        if ($primeiroDia->virada == 1){
            $virada = " DE ACORDO COM PROGRAMAÇÃO DO EVENTO NO PERÍODO DA VIRADA CULTURAL.";
        } else{
            $virada = "";
        }

        if ($ultimoDia->data_fim == null || $ultimoDia->data_fim == '0000-00-00'){
            $periodo = date('d/m/Y', strtotime($primeiroDia->data_inicio)) . $virada;
        } else{
            $periodo = date('d/m/Y', strtotime($primeiroDia->data_inicio)) . " até " . date('d/m/Y', strtotime($ultimoDia->data_fim)) . $virada;
        }
        return $periodo;
    }

    public function retornaLocais($idEvento):string
    {
        $idEvento = MainModel::decryption($idEvento);
        $locais = DbModel::consultaSimples("SELECT i.sigla, l.local FROM ocorrencias o INNER JOIN instituicoes i on o.instituicao_id = i.id INNER JOIN locais l on o.local_id = l.id and i.id = l.instituicao_id WHERE o.publicado = 1 AND origem_ocorrencia_id = '$idEvento'")->fetchAll(PDO::FETCH_OBJ);
        $lista = "";
        foreach ($locais as $local) {
            $lista .= "(" . $local->sigla . ") " . $local->local . ", ";
        }
        return substr($lista,0,-2);
    }

    public function enviaEvento($pagina, $evento_id):string
    {
        unset ($_POST['_method']);
        $data = date('Y-m-d H:i:s');

        // tabela eventos
        $dadosEvento['evento_status_id'] = 3;//enviado
        $verificaProtocolo = DbModel::consultaSimples("SELECT protocolo FROM eventos WHERE id = '$evento_id'")->fetchColumn();
        if (!$verificaProtocolo){
            $verificaProtocolo = $dadosEvento['protocolo'] = $this->geraProtocolo($evento_id);
        }
        $editaEvento = DbModel::update("eventos", $dadosEvento,$evento_id);
        if ($editaEvento->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            // tabela evento_envios
            $dadosEnvio['evento_id'] = $evento_id;
            $dadosEnvio['data_envio'] = $data;
            $insereEnvio = DbModel::insert("evento_envios",$dadosEnvio);
            if ($insereEnvio->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
                // tabela pedidos
                $dadosPedido['status_pedido_id'] = 2;
                $editaPedido = DbModel::updateCondicional("pedidos",$dadosPedido,"origem_tipo_id = 1 AND origem_id = $evento_id");
                if ($editaPedido->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
                    //tabela producao_eventos
                    $verificaProducao = DbModel::consultaSimples("SELECT evento_id FROM producao_eventos WHERE evento_id = '$evento_id'")->fetchColumn();
                    if (!$verificaProducao){
                        session_start(['name' => 'sis']);
                        $dadosProducao['evento_id'] = $evento_id;
                        $dadosProducao['usuario_id'] = $_SESSION['usuario_id_s'];
                        $dadosProducao['data'] = $data;
                        DbModel::insert("producao_eventos", $dadosProducao);
                    }
                    $alerta = [
                        'alerta' => 'sucesso',
                        'titulo' => 'Evento Aprovado!',
                        'texto' => 'Evento enviado com protocolo: '. $verificaProtocolo,
                        'tipo' => 'success',
                        'location' => SERVERURL . $pagina
                    ];
                } else{
                    exit("Erro ao salvar pedido.");
                }
            } else{
                exit("Erro ao salvar data de envio.");
            }
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function instituicaoSolicitante($evento_id) {
        return DbModel::consultaSimples("SELECT i.nome FROM eventos as eve
            INNER JOIN usuarios u on eve.usuario_id = u.id
            INNER JOIN instituicoes i on u.instituicao_id = i.id
            WHERE eve.id = '$evento_id'")->fetchColumn();
    }

    public function retornaTotalApresentacao($evento_id)
    {
        return DbModel::consultaSimples("SELECT SUM(quantidade_apresentacao) as apresentacoes FROM atracoes WHERE publicado = 1 AND evento_id = '$evento_id'")->fetchColumn();
    }
}