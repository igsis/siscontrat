<?php
if ($pedidoAjax) {
    require_once "../models/PedidoModel.php";
    require_once "../controllers/PessoaJuridicaController.php";
    require_once "../controllers/PessoaFisicaController.php";
    require_once "../controllers/ProdutorController.php";
    require_once "../controllers/AtracaoController.php";
    require_once "../controllers/LiderController.php";
    require_once "../controllers/RepresentanteController.php";
    require_once "../controllers/FormacaoController.php";
} else {
    require_once "./models/PedidoModel.php";
    require_once "./controllers/PessoaJuridicaController.php";
    require_once "./controllers/PessoaFisicaController.php";
    require_once "./controllers/ProdutorController.php";
    require_once "./controllers/AtracaoController.php";
    require_once "./controllers/LiderController.php";
    require_once "./controllers/RepresentanteController.php";
    require_once "./controllers/FormacaoController.php";
}

class PedidoController extends PedidoModel
{
    public function inserePedidoJuridica($pagina, $origem_tipo)
    {
        $idPj = PessoaJuridicaController::inserePessoaJuridica($pagina, true);
        $pedido = PedidoModel::inserePedido($origem_tipo, 2, $idPj);
        if ($pedido) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pessoa Jurídica',
                'texto' => 'Cadastro realizado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . $pagina . '/pj_cadastro&id=' . MainModel::encryption($idPj)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . $pagina . '/proponente'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function editaPedidoJuridica($idPj, $pagina, $origem_tipo)
    {
        $pj = PessoaJuridicaController::editaPessoaJuridica($idPj, $pagina, true);
        $pedido = PedidoModel::inserePedido($origem_tipo, 2, $pj);
        if ($pedido) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pessoa Jurídica',
                'texto' => 'Cadastro alterado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . $pagina . '/pj_cadastro&id=' . $idPj
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . $pagina . '/proponente'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function inserePedidoFisica($pagina, $origem_tipo)
    {
        $idPf = PessoaFisicaController::inserePessoaFisica($pagina, true);
        $pedido = PedidoModel::inserePedido($origem_tipo, 1, $idPf);
        if ($pedido) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pessoa Física',
                'texto' => 'Cadastro realizado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . $pagina . '/pf_cadastro&id=' . MainModel::encryption($idPf)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . $pagina . '/proponente'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function editaPedidoFisica($idPf, $pagina, $origem_tipo)
    {
        $pf = PessoaFisicaController::editaPessoaFisica($idPf, $pagina, true);
        $pedido = PedidoModel::inserePedido($origem_tipo, 1, $pf);
        if ($pedido) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pessoa Física',
                'texto' => 'Cadastro alterado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . $pagina . '/pf_cadastro&id=' . $idPf
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . $pagina . '/proponente'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function recuperaPedido($origem_tipo, $oficina = false)
    {
        $origem_id = MainModel::decryption($_SESSION['origem_id_s']);
        $pedido = DbModel::consultaSimples(
            "SELECT * FROM pedidos WHERE origem_tipo_id = '$origem_tipo' AND origem_id = '$origem_id'"
        )->fetchObject();

        if ($pedido->pessoa_tipo_id == 1) {
            $pedido->proponente = PedidoModel::buscaProponente(1, $pedido->pessoa_fisica_id);
            if ($oficina) {
                $atracao = (new AtracaoController)->recuperaAtracao($_SESSION['atracao_id_s']);
                if ($atracao->produtor_id == null) {
                    $dadosProdutor = [
                        'nome' => $pedido->proponente->nome,
                        'email' => $pedido->proponente->email,
                        'telefone1' => $pedido->proponente->telefone1,
                        'telefone2' => $pedido->proponente->telefone2 ?? ""
                    ];
                    (new ProdutorController)->insereProdutor($dadosProdutor, $_SESSION['atracao_id_s'], "", true);
                }
            }
        } else {
            $pedido->proponente = PedidoModel::buscaProponente(2, $pedido->pessoa_juridica_id);

            if ($oficina) {
                $atracao = (new AtracaoController)->recuperaAtracao($_SESSION['atracao_id_s']);
                $liderCadastrado = DbModel::consultaSimples("SELECT * FROM lideres WHERE pedido_id = '$pedido->id' AND atracao_id = '$atracao->id'");
                if ($liderCadastrado->rowCount() > 0) {
                    $lider = (new LiderController)->recuperaLider($_SESSION['pedido_id_s'], $_SESSION['atracao_id_s']);
                    if ($atracao->produtor_id == null) {
                        $dadosProdutor = [
                            'nome' => $lider->nome,
                            'email' => $lider->email,
                            'telefone1' => $lider->telefone1,
                            'telefone2' => $lider->telefone2 ?? ""
                        ];
                        (new ProdutorController)->insereProdutor($dadosProdutor, $_SESSION['atracao_id_s'], "", true);
                    }
                    $dadosRepresentante = [
                        'nome' => $lider->nome,
                        'rg' => $lider->rg,
                        'cpf' => $lider->cpf
                    ];
                    (new RepresentanteController)->insereRepresentanteOficina($dadosRepresentante, $pedido->proponente->id);
                }
            }
        }

        return $pedido;
    }

    public function getPedido($id)
    {
        $id = MainModel::decryption($id);
        return $id;
    }

    public function startPedido()
    {
        $idEvento = $_SESSION['origem_id_s'];
        $idEvento = MainModel::decryption($idEvento);
        $consulta = DbModel::consultaSimples("SELECT id FROM pedidos WHERE origem_tipo_id = 1 AND origem_id = $idEvento AND publicado = 1");
        if ($consulta->rowCount() > 0) {
            $consulta = $consulta->fetch(PDO::FETCH_ASSOC);
            $resultado = $consulta['id'];
            if ($resultado != null) {
                $_SESSION['pedido_id_s'] = MainModel::encryption($resultado);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function recuperaProponente($pedido_id) {
        $pedido_id = MainModel::decryption($pedido_id);
        $sql = "SELECT pessoa_tipo_id, pessoa_juridica_id, pessoa_fisica_id FROM pedidos WHERE id = '$pedido_id'";
        $proponente = DbModel::consultaSimples($sql)->fetchObject();

        return $proponente;
    }

    public function getParcelasPedido($pedido_id)
    {
        $pedido_id = MainModel::decryption($pedido_id);
        return DbModel::consultaSimples("SELECT * FROM parcelas WHERE pedido_id = $pedido_id AND publicado = 1")->fetchAll(PDO::FETCH_OBJ);
    }

    public function getParcelarPedidoFomentos($id)
    {
        $pedido_id = MainModel::decryption($id);

        $sql = "SELECT  fp.id,
                        CONCAT(DATE_FORMAT(fp.data_inicio,'%d/%m/%Y'),' à ', DATE_FORMAT(fp.data_fim,'%d/%m/%Y')) AS periodo, 
                        fp.numero_parcelas,
                        fp.data_inicio, 
                        fp.data_fim, 
                        fp.data_pagamento, 
                        fp.valor, fc.pedido_id
                FROM formacao_contratacoes AS fc
                INNER JOIN formacao_vigencias AS fv ON fc.form_vigencia_id = fv.id
                INNER JOIN formacao_parcelas AS fp ON fv.id = fp.formacao_vigencia_id
                WHERE fc.pedido_id = $pedido_id AND fp.publicado = 1";

        return DbModel::consultaSimples($sql)->fetchAll(PDO::FETCH_OBJ);

    }

    public function retornaPenalidades($penal_id){
        return DbModel::consultaSimples("SELECT texto FROM penalidades WHERE id = $penal_id")->fetchObject()->texto;
    }

    public function recuperaVerba($id)
    {
        return DbModel::getInfo("verbas",$id)->fetchObject();
    }

    public function listaPedidos($origem_tipo_id, $ano = false)
    {
        $pedidos = PedidoModel::listaBasePedido($origem_tipo_id);
        if ($origem_tipo_id == 1) { //evento
            foreach ($pedidos as $pedido) {
                if ($pedido->pessoa_tipo_id == 2) { //pessoa jurídica
                    $pjObj = new PessoaJuridicaController();
                    $idPj = $this->encryption($pedido->pessoa_juridica_id);
                    $pj = $pjObj->recuperaPessoaJuridica($idPj);
                    $pedido->proponente = $pj->razao_social;
                    $pedido->documento = $pj->cnpj;
                } else {
                    $pfObj = new PessoaFisicaController();
                    $idPf = $this->encryption($pedido->pessoa_fisica_id);
                    $pf = $pfObj->recuperaPessoaFisica($idPf);
                    $pedido->proponente = $pf->nome;
                    $pedido->documento = $pf->cpf;
                }
            }
        }
        if ($origem_tipo_id == 2){ //formação
            $formObj = new FormacaoController();
            foreach ($pedidos as $pedido) {
                $form = $formObj->recuperaFormacaoContratacao(intval($pedido->origem_id));
                $pedido->proponente = $form->nome;
                $pedido->documento = $form->cpf;
            }
        }
        return (object)$pedidos;
    }
}