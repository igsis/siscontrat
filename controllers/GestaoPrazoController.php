<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
    require_once "../controllers/EventoController.php";

} else {
    require_once "./models/MainModel.php";
    require_once "./controllers/EventoController.php";
}

class GestaoPrazoController extends MainModel
{
    public function listaAprovar()
    {
        return DbModel::consultaSimples("SELECT e.id, 
        e.nome_evento,
		fiscal.nome_completo AS 'fiscal',
        e.usuario_id
        FROM eventos as e
        INNER JOIN usuarios AS fiscal ON e.fiscal_id = fiscal.id
        WHERE e.evento_status_id = 2 AND e.publicado = 1")->fetchAll(PDO::FETCH_OBJ);
    }

    public function aprovar($evento_id)
    {
        /* executa limpeza nos campos */

        $data = date('Y-m-d H:i:s');

        $dadosPedido['status_pedido_id'] = 2;
        $dadosPedido['evento_id'] = $evento_id;
        $edita = DbModel::updateEspecial("pedidos",$dadosPedido,"origem_id",$evento_id);
        if ($edita->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $dadosEnvio['evento_id'] = $evento_id;
            $dadosEnvio['data_envio'] = $data;
            $envio = DbModel::insert("evento_envios",$dadosEnvio);
            if ($envio->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
                $dadosEvento['protocolo'] = (new EventoController)->geraProtocolo($evento_id);
                $dadosEvento['evento_status_id'] = 3;
                $eventoProtocolo = DbModel::update("eventos", $dadosEvento,$evento_id);
                if ($eventoProtocolo->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
                    $dadosProducao['evento_id'] = $evento_id;
                    $dadosProducao['usuario_id'] = $_SESSION['usuario_id_s'];
                    $dadosProducao['data'] = $data;
                    $producaoEvento = DbModel::insertignore("producao_eventos", $dadosProducao);
                    if ($producaoEvento->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
                        $alerta = [
                            'alerta' => 'sucesso',
                            'titulo' => 'Evento Aprovado!',
                            'texto' => 'Evento enviado com protocolo ".$protocolo',
                            'tipo' => 'success',
                            'location' => SERVERURL . 'gestao_prazo&p=busca_gestao'
                        ];
                    }
                }
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
}