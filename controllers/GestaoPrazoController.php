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
        op.nome_completo as operador,
        e.usuario_id
        FROM eventos as e
        INNER JOIN usuarios AS fiscal ON e.fiscal_id = fiscal.id
        INNER JOIN pedidos as p on p.origem_id = e.id
        LEFT JOIN usuarios as op on p.operador_id = op.id
        WHERE e.evento_status_id = 2 AND e.publicado = 1 GROUP BY e.id")->fetchAll(PDO::FETCH_OBJ);
    }

    public function desaprovar($post)
    {
        unset($post['id']);
        unset ($post['_method']);
        $evento_id = $post['evento_id'];

        $dadosEvento['evento_status_id'] = 6;
        DbModel::update("eventos",$dadosEvento,$evento_id);

        $dadosPedido['status_pedido_id'] = 3;
        DbModel::updateEspecial("pedidos",$dadosPedido,"origem_id",$evento_id);

        $dadosChamado = MainModel::limpaPost($post);

        $update = DbModel::update('chamados', $dadosChamado, $evento_id);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Evento Vetado!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'gestaoPrazo/inicio'
            ];
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

    public function aprovar($evento_id)
    {
        /* executa limpeza nos campos */

        $data = date('Y-m-d H:i:s');

        $dadosPedido['status_pedido_id'] = 2;
        //$dadosPedido['evento_id'] = $evento_id;
        $edita = DbModel::updateEspecial("pedidos",$dadosPedido,"origem_id",$evento_id);
        if ($edita->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $dadosEnvio['evento_id'] = $evento_id;
            $dadosEnvio['data_envio'] = $data;
            $envio = DbModel::insert("evento_envios",$dadosEnvio);
            if ($envio->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
                $verificaProtocolo = DbModel::consultaSimples("SELECT protocolo FROM eventos WHERE id = '$evento_id'")->fetchColumn(PDO::FETCH_OBJ);
                if (!$verificaProtocolo){
                    $dadosEvento['protocolo'] = (new EventoController)->geraProtocolo($evento_id);
                    $dadosEvento['evento_status_id'] = 3;
                    DbModel::update("eventos", $dadosEvento,$evento_id);
                }
                if ($edita->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
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
                    else {
                        $alerta = [
                            'alerta' => 'simples',
                            'titulo' => 'Oops! Algo deu Errado! Produção',
                            'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                            'tipo' => 'error',
                        ];
                    }
                }
            }
            else {
                $alerta = [
                    'alerta' => 'simples',
                    'titulo' => 'Oops! Algo deu Errado! Envio',
                    'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                    'tipo' => 'error',
                ];
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