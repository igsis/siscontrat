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
    public function listaAprovar():array
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

    public function desaprovar($post):string
    {
        unset($post['id']);
        unset ($post['_method']);
        $evento_id = $post['evento_id'];

        $dadosEvento['evento_status_id'] = 6;
        DbModel::update("eventos",$dadosEvento,$evento_id);

        $dadosPedido['status_pedido_id'] = 3;
        DbModel::updateCondicional("pedidos",$dadosPedido,"origem_tipo_id = 1 AND origem_id = $evento_id");

        session_start(['name' => 'sis']);
        $dadosChamado = MainModel::limpaPost($post);
        $dadosChamado['usuario_id'] = $_SESSION['usuario_id_s'];
        $dadosChamado['data'] = date('Y-m-d H:i:s');

        $insere = DbModel::insert('chamados', $dadosChamado);
        if ($insere->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
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
}