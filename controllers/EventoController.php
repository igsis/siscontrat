<?php
if ($pedidoAjax) {
    require_once "../models/EventoModel.php";
    require_once "../controllers/PessoaFisicaController.php";
    require_once "../controllers/PessoaJuridicaController.php";
} else {
    require_once "./models/EventoModel.php";
    require_once "./controllers/PessoaFisicaController.php";
    require_once "./controllers/PessoaJuridicaController.php";
}

class EventoController extends EventoModel
{
    public function listaEvento($usuario_id, $tipoContratacao){
        $consultaEvento = DbModel::consultaSimples("
            SELECT e.id, e.nome_evento, e.data_cadastro, tc.tipo_contratacao, e.publicado
            FROM eventos AS e 
                INNER JOIN tipos_contratacoes tc on e.tipo_contratacao_id = tc.id 
            WHERE e.publicado != 0 AND usuario_id = '$usuario_id' AND e.tipo_contratacao_id = '$tipoContratacao'");
        $eventos = $consultaEvento->fetchAll(PDO::FETCH_OBJ);
        return $eventos;
    }

    public function recuperaEvento($id) {
        $id = MainModel::decryption($id);
        $evento = EventoModel::getEvento($id);
        return $evento;
    }

    public function insereEvento($post, $oficina = false){
        /* executa limpeza nos campos */
        $dadosEvento = [];
        unset($post['_method']);
        foreach ($post as $campo => $valor) {
            if (($campo != "publicos") && ($campo != "fomento_id")) {
                $dadosEvento[$campo] = MainModel::limparString($valor);
                unset($post[$campo]);
            }
        }
        $dadosEvento['usuario_id'] = $_SESSION['usuario_id_s'];
        $dadosEvento['data_cadastro'] = date('Y-m-d H:i:s');
        /* /.limpeza */

        /* cadastro */
        $insere = DbModel::insert('eventos', $dadosEvento);
        if ($insere->rowCount() >= 1) {
            $evento_id = DbModel::connection()->lastInsertId();
            $_SESSION['origem_id_s'] = MainModel::encryption($evento_id);
            $atualizaRelacionamentoPublicos = MainModel::atualizaRelacionamento('evento_publico', 'evento_id', $evento_id, 'publico_id', $post['publicos']);

            if ($atualizaRelacionamentoPublicos) {
                if ($dadosEvento['fomento'] == 1) {
                    $atualizaRelacionamentoFomento = MainModel::atualizaRelacionamento('evento_fomento', 'evento_id', $evento_id, 'fomento_id', $post['fomento_id']);
                    if ($atualizaRelacionamentoFomento) {
                        if ($oficina) {
                            return $evento_id;
                        }
                        $alerta = [
                            'alerta' => 'sucesso',
                            'titulo' => 'Evento Cadastrado!',
                            'texto' => 'Dados cadastrados com sucesso!',
                            'tipo' => 'success',
                            'location' => SERVERURL . 'eventos/evento_cadastro&key=' . MainModel::encryption($evento_id)
                        ];
                    } else {
                        $alerta = [
                            'alerta' => 'simples',
                            'titulo' => 'Oops! Algo deu Errado!',
                            'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                            'tipo' => 'error',
                        ];
                    }
                } else {
                    if ($oficina) {
                        return $evento_id;
                    }
                    $alerta = [
                        'alerta' => 'sucesso',
                        'titulo' => 'Evento Cadastrado!',
                        'texto' => 'Dados cadastrados com sucesso!',
                        'tipo' => 'success',
                        'location' => SERVERURL . 'eventos/evento_cadastro&key=' . MainModel::encryption($evento_id)
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
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        /* /.cadastro */
        return MainModel::sweetAlert($alerta);
    }

    public function editaEvento($post,$evento_id, $oficina = false){
        /* executa limpeza nos campos */
        $dadosEvento = [];
        unset($post['_method']);
        unset($post['id']);
        foreach ($post as $campo => $valor) {
            if (($campo != "publicos") && ($campo != "fomento_id")) {
                $dadosEvento[$campo] = MainModel::limparString($valor);
                unset($post[$campo]);
            }
        }
        /* /.limpeza */

        // edição
        $edita = DbModel::update("eventos",$dadosEvento,$evento_id);
        if ($edita->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $atualizaRelacionamentoPublicos = MainModel::atualizaRelacionamento('evento_publico', 'evento_id', $evento_id, 'publico_id', $post['publicos']);
            if ($atualizaRelacionamentoPublicos) {
                if ($dadosEvento['fomento'] == 1) {
                    $atualizaRelacionamentoFomento = MainModel::atualizaRelacionamento('evento_fomento', 'evento_id', $evento_id, 'fomento_id', $post['fomento_id']);
                    if ($atualizaRelacionamentoFomento) {
                        $alerta = [
                            'alerta' => 'sucesso',
                            'titulo' => 'Evento Atualizado!',
                            'texto' => 'Dados atualizados com sucesso!',
                            'tipo' => 'success',
                            'location' => SERVERURL . 'eventos/evento_cadastro&key=' . MainModel::encryption($evento_id)
                        ];
                    } else {
                        $alerta = [
                            'alerta' => 'simples',
                            'titulo' => 'Oops! Algo deu Errado!',
                            'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                            'tipo' => 'error',
                        ];
                    }
                } else {
                    DbModel::consultaSimples("DELETE FROM evento_fomento WHERE evento_id = '$evento_id'");
                    $alerta = [
                        'alerta' => 'sucesso',
                        'titulo' => 'Evento Atualizado!',
                        'texto' => 'Dados atualizados com sucesso!',
                        'tipo' => 'success',
                        'location' => SERVERURL . 'eventos/evento_cadastro&key=' . MainModel::encryption($evento_id)
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

        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        /* /.edicao */
        return MainModel::sweetAlert($alerta);
    }

    public function apagaEvento($id){
        $apaga = DbModel::apaga("eventos", $id);
        if ($apaga){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Evento',
                'texto' => 'Evento apagado com sucesso!',
                'tipo' => 'danger',
                'location' => SERVERURL.'eventos/evento_lista'
            ];
        }else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function exibeDescricaoPublico() {
        $publicos = DbModel::consultaSimples("SELECT publico, descricao FROM publicos WHERE publicado = '1' ORDER BY 1");
        foreach ($publicos->fetchAll() as $publico) {
            ?>
            <tr>
                <td><?= $publico['publico'] ?></td>
                <td><?= $publico['descricao'] ?></td>
            </tr>
            <?php
        }
    }

    public function validaEvento($evento_id, $pedido_id) {
        $evento_id = MainModel::decryption($evento_id);
        $pedido_id = MainModel::decryption($pedido_id);
        $erros['Evento'] = EventoModel::validaEventoModel($evento_id, $pedido_id);

        $pedido = DbModel::consultaSimples("SELECT * FROM pedidos WHERE origem_id = '$evento_id' AND origem_tipo_id = '1'");
        if ($pedido->rowCount() > 0) {
                $pedido = $pedido->fetchObject();
            if ($pedido->pessoa_tipo_id == 1) {
                $erros['Proponente'] = (new PessoaFisicaController)->validaPf((int)$pedido->pessoa_fisica_id, 1, $evento_id, 1);
            } else {
                $erros['Proponente'] = (new PessoaJuridicaController)->validaPj((int)$pedido->pessoa_juridica_id);
            }
        }

        return MainModel::formataValidacaoErros($erros);
    }

    public function listaPublicoEvento($id)
    {
        $publico = DbModel::getInfo("publicos",$id)->fetch();
        return $publico;
    }

    public function envioEvento($id, $modulo)
    {
        $id = MainModel::decryption($id);
        $dados = [
            'publicado' => 2,
            'data_cadastro' => date('Y-m-d H-i-s')
        ];
        $edita = DbModel::update("eventos",$dados,$id);
        if ($edita->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Evento enviado com sucesso!',
                'texto' => 'Seu código do CAPAC é: '.$id.'<br><div class="row"><div class="offset-3 col-md-6"><a href="'.SERVERURL.'pdf/resumo_evento.php" class="btn btn-primary btn-block" target="_blank">Imprimir comprovante</a></div></div>',
                'tipo' => 'success',
                'location' => SERVERURL . $modulo.'/evento_lista'
            ];
        }
        else{
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function descriptografia($id)
    {
        $id = MainModel::decryption($id);
        return $id;
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

    function geraProtocolo($idEvento)
    {
        $tipo_evento = DbModel::consultaSimples("SELECT tipo_evento_id FROM eventos WHERE id ='$idEvento'")->fetchColumn(PDO::FETCH_OBJ);
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
        $locais = DbModel::consultaSimples("SELECT i.sigla, l.local FROM ocorrencias o INNER JOIN instituicoes i on o.instituicao_id = i.id INNER JOIN locais l on o.local_id = l.id and i.id = l.instituicao_id WHERE o.publicado = 1 AND origem_ocorrencia_id = '$idEvento'")->fetchAll(PDO::FETCH_OBJ);
        $lista = "";
        foreach ($locais as $local) {
            $lista .= "(" . $local->sigla . ") " . $local->local . ", ";
        }
        return substr($lista,0,-2);
    }

    public function modalLocais($idEvento):string
    {
        return "
        <div class='modal fade' id='listaLocais' aria-hidden='true' style='display: none;'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h4 class='modal-title'>Locais</h4>
                    </div>
                    <div class='modal-body'>
                        ". $this->retornaLocais($idEvento) ."
                    </div>
                    <div class='modal-footer justify-content-between'>
                        <button type='button' class='btn btn-default' data-dismiss=modal'>Fechar</button>
                    </div>
                </div>
            </div>
        </div>";
    }
}