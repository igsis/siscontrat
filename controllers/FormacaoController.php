<?php
if ($pedidoAjax) {
    require_once "../models/FormacaoModel.php";
    //require_once "../controllers/PedidoController.php";
    require_once "../controllers/PessoaFisicaController.php";
} else {
    require_once "./models/FormacaoModel.php";
    //require_once "./controllers/PedidoController.php";
    require_once "./controllers/PessoaFisicaController.php";
}

class FormacaoController extends FormacaoModel
{
    public function listaCargos()
    {
        return DbModel::listaPublicado("formacao_cargos", null);
    }

    public function insereCargo($post)
    {
        unset($post['_method']);
        $dados = MainModel::limpaPost($post);
        $insert = DbModel::insert('formacao_cargos', $dados);
        if ($insert->rowCount() >= 1) {
            $cargo_id = DbModel::connection()->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Cargo Cadastrado!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/cargo_cadastro&id=' . MainModel::encryption($cargo_id)
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

    public function recuperaCargo($cargo_id)
    {
        $cargo_id = MainModel::decryption($cargo_id);
        return DbModel::getInfo('formacao_cargos', $cargo_id)->fetchObject();
    }

    public function editaCargo($post)
    {
        $cargo_id = MainModel::decryption($post['id']);
        unset($post['id']);
        unset ($post['_method']);
        $dados = MainModel::limpaPost($post);
        $update = DbModel::update('formacao_cargos', $dados, $cargo_id);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Cargo Atualizado!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/cargo_cadastro&id=' . MainModel::encryption($cargo_id)
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

    public function apagaCargo($id)
    {
        $id = MainModel::decryption($id['id']);
        $apaga = DbModel::apaga("formacao_cargos", $id);
        if ($apaga) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Cargo Deletado!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/cargo_lista'
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao apagar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);

    }

    public function listaCoordenadorias()
    {
        return DbModel::listaPublicado("coordenadorias", null);
    }

    public function insereCoordenadoria($post)
    {
        unset($post['_method']);
        $dados = MainModel::limpaPost($post);
        $insert = DbModel::insert('coordenadorias', $dados);
        if ($insert->rowCount() >= 1) {
            $coordenadoria_id = DbModel::connection()->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Coordenadoria Cadastrada!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/coordenadoria_cadastro&id=' . MainModel::encryption($coordenadoria_id)
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

    public function recuperaCoordenadoria($coordenadoria_id)
    {
        $coordenadoria_id = MainModel::decryption($coordenadoria_id);
        return DbModel::getInfo('coordenadorias', $coordenadoria_id)->fetchObject();
    }


    public function editaCoordenadoria($post)
    {
        $coordenadoria_id = MainModel::decryption($post['id']);
        unset($post['id']);
        unset ($post['_method']);
        $dados = MainModel::limpaPost($post);
        $update = DbModel::update('coordenadorias', $dados, $coordenadoria_id);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Coordenadoria Atualizada!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/coordenadoria_cadastro&id=' . MainModel::encryption($coordenadoria_id)
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

    public function apagaCoordenadoria($id)
    {
        $id = MainModel::decryption($id['id']);
        $apaga = DbModel::apaga("coordenadorias", $id);
        if ($apaga) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Coordenadoria Deletada!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/coordenadoria_lista'
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao apagar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function listaProgramas()
    {
        return DbModel::consultaSimples(
            "SELECT p.id as id, p.programa as programa, p.verba_id as verba_id, p.edital as edital, p.descricao as descricao, p.publicado, v.verba as nome_verba 
                    FROM programas p
                    INNER JOIN verbas v ON p.verba_id = v.id
                    WHERE p.publicado = 1");
    }

    public function recuperaPrograma($programa_id)
    {
        $programa_id = MainModel::decryption($programa_id);
        return DbModel::getInfo('programas', $programa_id)->fetchObject();
    }

    public function inserePrograma($post)
    {
        unset($post['_method']);
        $dados = MainModel::limpaPost($post);
        $insert = DbModel::insert('programas', $dados);
        if ($insert->rowCount() >= 1) {
            $programa_id = DbModel::connection()->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Programa Cadastrado!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/programa_cadastro&id=' . MainModel::encryption($programa_id)
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


    public function editaPrograma($post)
    {
        $programa_id = MainModel::decryption($post['id']);
        unset($post['id']);
        unset ($post['_method']);
        $dados = MainModel::limpaPost($post);
        $update = DbModel::update('programas', $dados, $programa_id);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Programa Atualizado!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/programa_cadastro&id=' . MainModel::encryption($programa_id)
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

    public function apagaPrograma($id)
    {
        $id = MainModel::decryption($id['id']);
        $apaga = DbModel::apaga("programas", $id);
        if ($apaga) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Programa Deletado!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/programa_lista'
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao apagar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function listaLinguagens()
    {
        return DbModel::listaPublicado("linguagens", null);
    }

    public function recuperaLinguagem($linguagem_id)
    {
        $linguagem_id = MainModel::decryption($linguagem_id);
        return DbModel::getInfo('linguagens', $linguagem_id)->fetchObject();
    }

    public function insereLinguagem($post)
    {
        unset($post['_method']);
        $dados = MainModel::limpaPost($post);
        $insert = DbModel::insert('linguagens', $dados);
        if ($insert->rowCount() >= 1) {
            $linguagem_id = DbModel::connection()->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Linguagem Cadastrada!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/linguagem_cadastro&id=' . MainModel::encryption($linguagem_id)
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

    public function editaLinguagem($post)
    {
        $linguagem_id = MainModel::decryption($post['id']);
        unset($post['id']);
        unset ($post['_method']);
        $dados = MainModel::limpaPost($post);
        $update = DbModel::update('linguagens', $dados, $linguagem_id);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Linguagem Atualizada!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/linguagem_cadastro&id=' . MainModel::encryption($linguagem_id)
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

    public function apagaLinguagem($id)
    {
        $id = MainModel::decryption($id['id']);
        $apaga = DbModel::apaga("linguagens", $id);
        if ($apaga) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Linguagem Deletada!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/linguagem_lista'
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao apagar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function listaProjetos()
    {
        return DbModel::listaPublicado("projetos", null);
    }

    public function recuperaProjeto($projeto_id)
    {
        $projeto_id = MainModel::decryption($projeto_id);
        return DbModel::getInfo('projetos', $projeto_id)->fetchObject();
    }

    public function insereProjeto($post)
    {
        unset($post['_method']);
        $dados = MainModel::limpaPost($post);
        $insert = DbModel::insert('projetos', $dados);
        if ($insert->rowCount() >= 1) {
            $projeto_id = DbModel::connection()->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Projeto Cadastrado!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/projeto_cadastro&id=' . MainModel::encryption($projeto_id)
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

    public function editaProjeto($post)
    {
        $projeto_id = MainModel::decryption($post['id']);
        unset($post['id']);
        unset ($post['_method']);
        $dados = MainModel::limpaPost($post);
        $update = DbModel::update('projetos', $dados, $projeto_id);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Projeto Atualizado!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/projeto_cadastro&id=' . MainModel::encryption($projeto_id)
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

    public function apagaProjeto($id)
    {
        $id = MainModel::decryption($id['id']);
        $apaga = DbModel::apaga("projetos", $id);
        if ($apaga) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Projeto Deletado!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/projeto_lista'
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao apagar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function listaSubprefeituras()
    {
        return DbModel::listaPublicado("subprefeituras", null);
    }

    public function recuperaSubprefeitura($subprefeitura_id)
    {
        $subprefeitura_id = MainModel::decryption($subprefeitura_id);
        return DbModel::getInfo('subprefeituras', $subprefeitura_id)->fetchObject();
    }

    public function insereSubprefeitura($post)
    {
        unset($post['_method']);
        $dados = MainModel::limpaPost($post);
        $insert = DbModel::insert('subprefeituras', $dados);
        if ($insert->rowCount() >= 1) {
            $subprefeitura_id = DbModel::connection()->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Subprefeitura Cadastrada!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/subprefeitura_cadastro&id=' . MainModel::encryption($subprefeitura_id)
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

    public function editaSubprefeitura($post)
    {
        $subprefeitura_id = MainModel::decryption($post['id']);
        unset($post['id']);
        unset ($post['_method']);
        $dados = MainModel::limpaPost($post);
        $update = DbModel::update('subprefeituras', $dados, $subprefeitura_id);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Subprefeitura Atualizada!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/subprefeitura_cadastro&id=' . MainModel::encryption($subprefeitura_id)
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

    public function apagaSubprefeitura($id)
    {
        $id = MainModel::decryption($id['id']);
        $apaga = DbModel::apaga("subprefeituras", $id);
        if ($apaga) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Subprefeitura Deletada!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/subprefeitura_lista'
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao apagar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    }


    public function listaTerritorios()
    {
        return DbModel::listaPublicado("territorios", null);
    }

    public function recuperaTerritorio($territorio_id)
    {
        $territorio_id = MainModel::decryption($territorio_id);
        return DbModel::getInfo('territorios', $territorio_id)->fetchObject();
    }

    public function insereTerritorio($post)
    {
        unset($post['_method']);
        $dados = MainModel::limpaPost($post);
        $insert = DbModel::insert('territorios', $dados);
        if ($insert->rowCount() >= 1) {
            $territorio_id = DbModel::connection()->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Território Cadastrado!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/territorio_cadastro&id=' . MainModel::encryption($territorio_id)
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

    public function editaTerritorio($post)
    {
        $territorio_id = MainModel::decryption($post['id']);
        unset($post['id']);
        unset ($post['_method']);
        $dados = MainModel::limpaPost($post);
        $update = DbModel::update('territorios', $dados, $territorio_id);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Território Atualizado!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/territorio_cadastro&id=' . MainModel::encryption($territorio_id)
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

    public function apagaTerritorio($id)
    {
        $id = MainModel::decryption($id['id']);
        $apaga = DbModel::apaga("territorios", $id);
        if ($apaga) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Território Deletado!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/territorio_lista'
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao apagar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function listaVigencias()
    {
        return DbModel::listaPublicado("formacao_vigencias", null);
    }

    public function recuperaParcelasVigencias($id_parcela_vigencia)
    {
        $parcela_id = MainModel::decryption($id_parcela_vigencia) ?? "";
        return DbModel::consultaSimples("SELECT * FROM formacao_parcelas where formacao_vigencia_id = $parcela_id")->fetchAll(PDO::FETCH_OBJ);
    }

    public function recuperaVigencia($vigencia_id)
    {
        $vigencia_id = MainModel::decryption($vigencia_id);
        return DbModel::getInfo('formacao_vigencias', $vigencia_id)->fetchObject();
    }

    public function insereVigencia($post)
    {
        unset($post['_method']);
        $dados = MainModel::limpaPost($post);
        $insert = DbModel::insert('formacao_vigencias', $dados);
        if ($insert->rowCount() >= 1) {
            $vigencia_id = DbModel::connection()->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Vigência Cadastrada!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/vigencia_cadastro&id=' . MainModel::encryption($vigencia_id)
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

    public function insereParcelaVigencia($post)
    {
        $id = $post['id'];
        $vigencia_id = MainModel::decryption($post['id']);
        unset($post['_method']);
        unset($post['id']);
        $dados = [];

        foreach ($post as $campo => $dado) {
            foreach ($dado as $key => $valor) {
                if ($campo === "valor")
                    $dados[$key][$campo] = MainModel::dinheiroDeBr($valor);
                else
                    $dados[$key][$campo] = MainModel::limparString($valor);
            }
        }

        foreach ($dados as $key => $dado) {
            $dado['formacao_vigencia_id'] = $vigencia_id;
            $insert = DbModel::insert('formacao_parcelas', $dado);
            if ($insert->rowCount() >= 1) {
                $erro = false;
            } else {
                $erro = true;
            }
        }

        if (!$erro) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Parcelas Cadastradas!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/vigencia_cadastro&id=' . $id
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

    public function editaVigencia($post)
    {
        $vigencia_id = MainModel::decryption($post['id']);
        unset($post['id']);
        unset ($post['_method']);
        $dados = MainModel::limpaPost($post);;
        $update = DbModel::update('formacao_vigencias', $dados, $vigencia_id);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $queryParcelas = DbModel::consultaSimples("SELECT * FROM formacao_parcelas WHERE formacao_vigencia_id = '$vigencia_id' ORDER BY id DESC");
            $numParcelas = $queryParcelas->rowCount();
            if ($numParcelas > 0) {
                $parcelas = $queryParcelas->fetchAll(PDO::FETCH_ASSOC);
                if ($dados['numero_parcelas'] < $numParcelas) {
                    for ($i = 0; $i < ($numParcelas - $dados['numero_parcelas']); $i++) {
                        DbModel::deleteEspecial('formacao_parcelas', 'id', $parcelas[$i]['id']);
                    }
                } else {
                    $data = $parcelas[0];
                    $parcela = $data['numero_parcelas'];
                    unset($data['id']);
                    for ($i = 0; $i < ($dados['numero_parcelas'] - $numParcelas); $i++) {
                        $data['numero_parcelas'] = $parcela + 1;
                        DbModel::insert('formacao_parcelas', $data);
                        $parcela++;
                    }
                }
            }
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Vigência Atualizada!',
                'texto' => 'Dados atualizados com sucesso! Lembre-se de editar as parcelas se necessário.',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/vigencia_cadastro&id=' . MainModel::encryption($vigencia_id)
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

    public function editaParcelaVigencia($post)
    {
        $vigencia_id = $post['id'];
        unset($post['_method']);
        unset($post['id']);

        $dados = [];

        foreach ($post as $campo => $dado) {
            foreach ($dado as $key => $valor) {
                if ($campo === "valor")
                    $dados[$key][$campo] = MainModel::dinheiroDeBr($valor);
                else
                    $dados[$key][$campo] = MainModel::limparString($valor);
            }
        }

        foreach ($dados as $key => $dado) {
            $id = $dado['parcela_id'];
            unset($dado['parcela_id']);
            unset($dado['numero_parcelas']);
            $update = DbModel::update('formacao_parcelas', $dado, $id);
            if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
                $erro = false;
            } else {
                $erro = true;
            }
        }

        if (!$erro) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Parcelas Atualizadas!',
                'texto' => 'Parcelas atualizadas com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/vigencia_cadastro&id=' . $vigencia_id
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function apagaVigencia($id)
    {
        $id = MainModel::decryption($id['id']);
        $apagaParcelas = DbModel::deleteEspecial('formacao_parcelas', 'formacao_vigencia_id', $id);
        if ($apagaParcelas) {
            $apaga = DbModel::apaga("formacao_vigencias", $id);
            if ($apaga) {
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Vigência Deletada!',
                    'texto' => 'Dados atualizados com sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL . 'formacao/vigencia_lista'
                ];
            } else {
                $alerta = [
                    'alerta' => 'simples',
                    'titulo' => 'Oops! Algo deu Errado!',
                    'texto' => 'Falha ao apagar os dados no servidor, tente novamente mais tarde',
                    'tipo' => 'error',
                ];
            }
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao apagar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function listaPedidos($ano = 0, $pedido = 0)
    {
        $whereAno = "";
        if ($ano) {
            $whereAno = "AND fc.ano = {$ano}";
        }

        $whereStatusPedido = "";
        if ($pedido) {
            if ($pedido == 2) {
                $whereStatusPedido = "AND p.status_pedido_id = 2";
            } else {
                $whereStatusPedido = "AND p.status_pedido_id != 2";
            }
        }

        $sql = "SELECT   p.id, p.origem_id,fc.protocolo, fc.ano,
                         p.numero_processo,fc.num_processo_pagto, 
                         pf.id AS 'pessoa_fisica_id', pf.nome, ns.nome_social, pf.cpf, pf.passaporte, v.verba, 
                         ps.`status`, fc.form_status_id 
            FROM pedidos p 
            LEFT JOIN pedido_status ps ON p.status_pedido_id = ps.id
            INNER JOIN formacao_contratacoes fc ON fc.id = p.origem_id 
            INNER JOIN pessoa_fisicas pf ON fc.pessoa_fisica_id = pf.id                
            LEFT JOIN pf_nome_social ns ON pf.id = ns.pessoa_fisica_id                
            INNER JOIN verbas v on p.verba_id = v.id 
            INNER JOIN formacao_status fs on fc.form_status_id = fs.id
            WHERE p.publicado = 1 AND p.origem_tipo_id = 2 {$whereAno} {$whereStatusPedido}";

        return DbModel::consultaSimples($sql)->fetchAll(PDO::FETCH_OBJ);
    }

    public function anosPedido()
    {
        $sql = "SELECT MIN(ano) AS min, MAX(ano) AS max                                              
            FROM pedidos p                                                           
            INNER JOIN formacao_contratacoes fc ON fc.id = p.origem_id               
            INNER JOIN pessoa_fisicas pf ON fc.pessoa_fisica_id = pf.id              
            INNER JOIN verbas v on p.verba_id = v.id                                 
            INNER JOIN formacao_status fs on fc.form_status_id = fs.id               
            WHERE fc.form_status_id != 5 AND p.publicado = 1 AND p.origem_tipo_id = 2";
        return DbModel::consultaSimples($sql)->fetchObject();
    }

    //retorna uma string ou um objeto com todos os locais que o pedido possui
    public function retornaLocaisFormacao($contratacao_id, $obj = 0, $decryption = 0)
    {
        if ($decryption != 0) {
            $contratacao_id = MainModel::decryption($contratacao_id);
        }
        $locais = "";
        $locaisArrays = DbModel::consultaSimples("SELECT l.id, l.local, l.instituicao_id, l.subprefeitura_id, s.subprefeitura FROM formacao_locais AS fl INNER JOIN locais AS l ON fl.local_id = l.id LEFT JOIN subprefeituras AS s ON l.subprefeitura_id = s.id WHERE form_pre_pedido_id = $contratacao_id AND subprefeitura_id IS NOT NULL AND subprefeitura_id != 0")->fetchAll();
        if ($obj != 0):
            return $locaisArrays;
        else:
            foreach ($locaisArrays as $locaisArray) {
                $locais = $locais . $locaisArray['local'] . '; ';
            }
            return substr($locais, 0, -2);
        endif;
    }

    public function retornaValorTotalVigencia($contratacao_id, $decryption = 0)
    {
        if ($decryption != 0) {
            $contratacao_id = MainModel::decryption($contratacao_id);
        }

        $valor = 0;
        $consultaValores = DbModel::consultaSimples("SELECT fp.valor FROM formacao_parcelas AS fp INNER JOIN formacao_contratacoes AS fc ON fc.form_vigencia_id = fp.formacao_vigencia_id WHERE fc.id = $contratacao_id AND fp.publicado = 1 AND fp.valor != 0.00");
        $count = $consultaValores->rowCount();
        if ($count > 0) {
            $arrayValores = $consultaValores->fetchAll(PDO::FETCH_OBJ);
            for ($i = 0; $i < $count; $i++):
                $valor = $valor + $arrayValores[$i]->valor;
            endfor;
        }
        return $valor;
    }

    public function retornaDadosParcelas($contratacao_id, $decryption = 0, $unica = 0, $parcela_id = NULL)
    {
        if ($decryption != 0) {
            $contratacao_id = MainModel::decryption($contratacao_id);
        }

        if ($unica != 0 && $parcela_id != NULL):
            return DbModel::consultaSimples("SELECT fp.* FROM formacao_parcelas AS fp INNER JOIN formacao_contratacoes AS fc ON fc.form_vigencia_id = fp.formacao_vigencia_id WHERE fc.id = $contratacao_id AND fp.publicado = 1 AND fp.id = $parcela_id")->fetchObject();
        else:
            return DbModel::consultaSimples("SELECT fp.* FROM formacao_parcelas AS fp INNER JOIN formacao_contratacoes AS fc ON fc.form_vigencia_id = fp.formacao_vigencia_id WHERE fc.id = $contratacao_id AND fp.publicado = 1")->fetchAll(PDO::FETCH_OBJ);
        endif;
    }

    public function retornaCargaHoraria($contratacao_id, $decryption = 0)
    {
        if ($decryption != 0) {
            $contratacao_id = MainModel::decryption($contratacao_id);
        }

        $carga = 0;
        $consultaParcelas = DbModel::consultaSimples("SELECT fp.carga_horaria FROM formacao_parcelas AS fp INNER JOIN formacao_contratacoes AS fc ON fc.form_vigencia_id = fp.formacao_vigencia_id WHERE fc.id = $contratacao_id AND fp.publicado = 1")->fetchAll();
        foreach ($consultaParcelas as $consultaParcela) {
            $carga = $carga + $consultaParcela['carga_horaria'];
        }
        return $carga;
    }

    public function recuperaPedido($pedido_id, $excel = 0, $ano = 0, $programa = 3)
    {
        if ($excel != 0 && $ano != 0):

            if ($programa != 3) {
                $programa = " AND pro.id = {$programa}";
            } else {
                $programa = "";
            }

            return DbModel::consultaSimples("SELECT p.origem_id, p.numero_processo, p.pessoa_fisica_id,fc.protocolo, fc.programa_id, pf.id, pf.nome, 
                                                            pro.programa, c.cargo AS 'funcao', c.justificativa AS 'cargo_justificativa', l.linguagem, 
                                                            pf.email, CONCAT(pe.logradouro, ', ', pe.numero, ' - ', pe.bairro, ', ', pe.cidade, ' - ', pe.uf) AS 'endereco', pe.cep, s.status, lo.`local`,
                                                            ge.genero,pd.trans,pd.pcd
                                                        FROM pedidos AS p
                                                        LEFT JOIN pessoa_fisicas AS pf ON p.pessoa_fisica_id = pf.id
                                                        LEFT JOIN pf_detalhes AS pd ON pf.id = pd.pessoa_fisica_id
                                                        LEFT JOIN generos AS ge ON pd.genero_id = ge.id
                                                        LEFT JOIN formacao_contratacoes AS fc ON fc.id = p.origem_id  
                                                        LEFT JOIN formacao_locais AS fl ON fl.form_pre_pedido_id = fc.id
                                                        LEFT JOIN locais AS lo ON fl.local_id = lo.id
                                                        LEFT JOIN subprefeituras AS su ON lo.subprefeitura_id = su.id
                                                        LEFT JOIN programas AS pro ON fc.programa_id = pro.id
                                                        LEFT JOIN formacao_cargos AS c ON fc.form_cargo_id = c.id
                                                        LEFT JOIN linguagens AS l ON fc.linguagem_id = l.id
                                                        LEFT JOIN formacao_status AS s ON fc.form_status_id = s.id
                                                        LEFT JOIN pf_enderecos AS pe ON pf.id = pe.pessoa_fisica_id
                                                    WHERE p.publicado = 1 AND p.origem_tipo_id = 2 AND p.status_pedido_id = 2 AND  fc.ano = {$ano} {$programa} group by pf.id")->fetchAll(PDO::FETCH_OBJ);
        else:
            $pedido_id = MainModel::decryption($pedido_id);
            return DbModel::consultaSimples("SELECT p.id, p.origem_id, p.valor_total, p.data_kit_pagamento, p.numero_processo, p.numero_parcelas, p.pessoa_fisica_id, p.valor_total, p.numero_processo_mae, 
                                                            p.forma_pagamento, p.justificativa AS 'cargo_justificativa', p.observacao, p.verba_id, s.status, fc.protocolo, pf.nome, c.cargo, fc.programa_id, l.linguagem, fis.nome_completo as fiscal_nome, fis.rf_rg as fiscal_rf, sup.nome_completo as suplente_nome, sup.rf_rg as suplente_rf, c2.coordenadoria
                                                  FROM pedidos AS p
                                                  INNER JOIN pedido_status AS s ON s.id = p.status_pedido_id 
                                                  INNER JOIN formacao_contratacoes AS fc ON fc.id = p.origem_id 
                                                  INNER JOIN linguagens AS l ON fc.linguagem_id = l.id
                                                  INNER JOIN coordenadorias c2 on fc.coordenadoria_id = c2.id
                                                  INNER JOIN pessoa_fisicas AS pf ON pf.id = p.pessoa_fisica_id
                                                  INNER JOIN formacao_cargos AS c ON fc.form_cargo_id = c.id
                                                    LEFT JOIN usuarios fis on fc.fiscal_id = fis.id
                                                    LEFT JOIN usuarios sup on fc.suplente_id = sup.id
                                                  WHERE p.id = $pedido_id AND p.publicado = 1 AND p.origem_tipo_id = 2")->fetchObject();
        endif;

    }

    public function recuperaContratacao($contratacao_id, $decription = 0)
    {
        if ($decription != 0) {
            $contratacao_id = MainModel::decryption($contratacao_id);
        }
        $sql = "SELECT fc.id, pro.programa, pro.edital, pro.verba_id AS 'programa_verba_id', fc.protocolo, fc.pessoa_fisica_id, pf.nome AS 'nome_pf', c.cargo, c.justificativa as cargo_justificativa, l.linguagem, cor.coordenadoria, fiscal.nome_completo AS 'fiscal', suplente.nome_completo AS 'suplente', vb.verba, fc.form_vigencia_id
                FROM formacao_contratacoes AS fc
                INNER JOIN programas AS pro ON pro.id = fc.programa_id
                INNER JOIN formacao_cargos AS c ON c.id = fc.form_cargo_id
                INNER JOIN linguagens AS l ON l.id = fc.linguagem_id
                INNER JOIN coordenadorias AS cor ON cor.id = fc.coordenadoria_id
                INNER JOIN pessoa_fisicas AS pf ON pf.id = fc.pessoa_fisica_id
                INNER JOIN verbas AS vb ON vb.id = pro.verba_id
                LEFT JOIN usuarios AS fiscal ON fiscal.id = fc.fiscal_id
                LEFT JOIN usuarios AS suplente ON suplente.id = fc.suplente_id      
                WHERE fc.id = {$contratacao_id} AND fc.publicado = 1";

        return DbModel::consultaSimples($sql)->fetchObject();
    }

    //retorna um obj com os dados de uma determinada pessoa fisica
    public function recuperaPf($pessoa_fisica_id)
    {
        return DbModel::consultaSimples("SELECT pf.*, ns.nome_social, n.nacionalidade, pe.*, d.drt 
                                                  FROM pessoa_fisicas AS pf 
                                                  LEFT JOIN nacionalidades AS n ON pf.nacionalidade_id = n.id  
                                                  LEFT JOIN pf_enderecos AS pe ON pf.id = pe.pessoa_fisica_id
                                                  LEFT JOIN drts AS d ON pf.id = d.pessoa_fisica_id
                                                  LEFT JOIN pf_nome_social AS ns ON pf.id = ns.pessoa_fisica_id
                                                  WHERE pf.id = $pessoa_fisica_id")->fetchObject();
    }

    public function recuperaTelPf($pessoa_fisica_id, $obj = 0, $capac = 0)
    {
        $tel = "";
        if ($capac != 0):
            $telArrays = DbModel::consultaSimples("SELECT telefone FROM pf_telefones WHERE pessoa_fisica_id = $pessoa_fisica_id", '1')->fetchAll();
        else:
            $telArrays = DbModel::consultaSimples("SELECT telefone FROM pf_telefones WHERE pessoa_fisica_id = $pessoa_fisica_id AND publicado = 1")->fetchAll();
        endif;

        if ($obj != 0):
            return $telArrays;
        else:
            foreach ($telArrays as $telArray) {
                $tel = $tel . $telArray['telefone'] . '; ';
            }
            return substr($tel, 0, -2);
        endif;
    }

    public function vincularCargo($post)
    {
        unset($post['_method']);

        $testa = DbModel::consultaSimples("SELECT * FROM cargo_programas WHERE programa_id = " . $post['programa_id'] . " AND formacao_cargo_id = " . $post['formacao_cargo_id']);
        if ($testa->rowCount() > 0):
            DbModel::consultaSimples("DELETE FROM cargo_programas WHERE programa_id = " . $post['programa_id'] . " AND formacao_cargo_id = " . $post['formacao_cargo_id']);
        endif;

        $dados = MainModel::limpaPost($post);
        $update = DbModel::insert('cargo_programas', $dados);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Cargo Vinculado',
                'texto' => 'Dados gravados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/cargo_programa'
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function desvincularCargo($post)
    {
        unset($post['_method']);

        $update = DbModel::consultaSimples("DELETE FROM cargo_programas WHERE programa_id = " . $post['programa_id'] . " AND formacao_cargo_id = " . $post['formacao_cargo_id']);

        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Cargo Desvinculado',
                'texto' => 'Dados gravados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/cargo_programa'
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function retornaPeriodoFormacao($contratacao_id, $decryption = 0, $unico = 0, $parcela_id = NULL)
    {
        if ($decryption != 0) {
            $contratacao_id = MainModel::decryption($contratacao_id);
        }

        if ($unico != 0 && $parcela_id != NULL) {
            $testaDataInicio = DbModel::consultaSimples("SELECT fp.data_inicio FROM formacao_parcelas AS fp INNER JOIN formacao_contratacoes AS fc ON fc.form_vigencia_id = fp.formacao_vigencia_id WHERE fc.id = $contratacao_id AND fp.publicado = 1 AND fp.id = $parcela_id");
            if ($testaDataInicio->rowCount() > 0) {
                $data_inicio = $testaDataInicio->fetchObject()->data_inicio;
                $data_fim = DbModel::consultaSimples("SELECT fp.data_fim FROM formacao_parcelas AS fp INNER JOIN formacao_contratacoes AS fc ON fc.form_vigencia_id = fp.formacao_vigencia_id WHERE fc.id = $contratacao_id AND fp.publicado = 1 AND fp.id = $parcela_id")->fetchObject()->data_fim;
                return "de " . MainModel::dataParaBR($data_inicio) . " à " . MainModel::dataParaBR($data_fim);
            } else {
                return "(Parcelas não cadastradas)";
            }
        } else {
            $testaDataInicio = DbModel::consultaSimples("SELECT fp.data_inicio FROM formacao_parcelas AS fp INNER JOIN formacao_contratacoes AS fc ON fc.form_vigencia_id = fp.formacao_vigencia_id WHERE fc.id = $contratacao_id AND fp.publicado = 1 ORDER BY fp.data_inicio ASC LIMIT 0,1");
            if ($testaDataInicio->rowCount() > 0) {
                $data_inicio = $testaDataInicio->fetchObject()->data_inicio;
                $data_fim = DbModel::consultaSimples("SELECT fp.data_fim FROM formacao_parcelas AS fp INNER JOIN formacao_contratacoes AS fc ON fc.form_vigencia_id = fp.formacao_vigencia_id WHERE fc.id = $contratacao_id AND fp.publicado = 1 ORDER BY fp.data_fim DESC LIMIT 0,1")->fetchObject()->data_fim;
                /*if ($data_inicio == $data_fim || $data_fim == "0000-00-00") {
                    return MainModel::dataParaBR($data_inicio);
                } else {
                    return "de " . MainModel::dataParaBR($data_inicio) . " à " . MainModel::dataParaBR($data_fim);
                }*/
                return "de " . MainModel::dataParaBR($data_inicio) . " à " . MainModel::dataParaBR($data_fim);
            } else {
                return "(Parcelas não cadastradas)";
            }
        }

    }

    public function cadastrarPedido($post)
    {
        unset($post['_method']);

        $dadosParcelas = DbModel::consultaSimples("SELECT fp.* FROM formacao_parcelas AS fp INNER JOIN formacao_contratacoes AS fc ON fc.form_vigencia_id = fp.formacao_vigencia_id WHERE fp.publicado = 1 AND fc.id = " . $post['origem_id'])->fetchAll(PDO::FETCH_OBJ);
        $formaCompleta = "";
        for ($i = 0; $i < count($dadosParcelas); $i++) :
            $forma = $i + 1 . "º parcela R$ " . MainModel::dinheiroParaBr($dadosParcelas[$i]->valor) . ". Entrega de documentos a partir de " . MainModel::dataParaBR($dadosParcelas[$i]->data_pagamento) . ".\n";
            $formaCompleta = $formaCompleta . $forma;
        endfor;
        $formaCompleta = $formaCompleta . "\nA liquidação de cada parcela se dará em 3 (três) dias úteis após a data de confirmação da correta execução do(s) serviço(s).";

        if (isset($post['valor_total'])) {
            $post['valor_total'] = MainModel::dinheiroDeBr($post['valor_total']);
        }

        $dados = MainModel::limpaPost($post);

        $insert = DbModel::insert('pedidos', $dados);
        if ($insert->rowCount() >= 1) {
            $pedido_id = DbModel::connection()->lastInsertId();
            DbModel::consultaSimples("UPDATE formacao_contratacoes SET pedido_id = '$pedido_id' WHERE publicado = 1 AND id = " . $dados['origem_id']);
            DbModel::consultaSimples("UPDATE pedidos SET forma_pagamento = '$formaCompleta' WHERE id = $pedido_id AND origem_tipo_id = 2");
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pedido Cadastrado',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/pedido_contratacao_cadastro&pedido_id=' . MainModel::encryption($pedido_id)
            ];
        } else {
            $alerta = [
                'Alerta' => 'simples',
                'titulo' => 'Oops! Algo deu errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde.',
                'tipo' => 'error'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function editarPedido($post)
    {
        $pedido_id = MainModel::decryption($post['id']);
        unset($post['_method']);
        unset($post['id']);

        if (isset($post['valor_total'])) {
            $post['valor_total'] = MainModel::dinheiroDeBr($post['valor_total']);
        }
        $dados = MainModel::limpaPost($post);
        $update = DbModel::update('pedidos', $dados, $pedido_id);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pedido Atualizado',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/pedido_contratacao_cadastro&pedido_id=' . MainModel::encryption($pedido_id)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function deletarPedido($post)
    {
        unset($post['_method']);
        $pedido_id = MainModel::decryption($post['id']);
        unset($post['id']);
        $delete = DbModel::apaga('pedidos', $pedido_id);
        if ($delete->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pedido Apagado!',
                'texto' => 'Pedido apagado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/pedido_contratacao_lista'
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu errado!',
                'texto' => 'Falha ao salvar os dados no servidos, tente novamente mais tarde',
                'tipo' => 'error'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function concluirPedido($post)
    {
        unset($post['_method']);
        $pedido_id = MainModel::decryption($post['id']);
        unset($post['id']);
        $update = DbModel::consultaSimples("UPDATE pedidos SET status_pedido_id = 21 WHERE id = $pedido_id AND origem_tipo_id = 2 AND publicado = 1");
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pedido Concluído!',
                'texto' => 'Pedido concluído com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/conclusao_busca'
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu errado!',
                'texto' => 'Falha ao salvar os dados no servidos, tente novamente mais tarde',
                'tipo' => 'error'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    /*public function editarParcela($post)
    {
        unset($post['_method']);
        $pedido_id = MainModel::decryption($post['pedido_id']);
        unset($post['pedido_id']);
        $parcelas = DbModel::consultaSimples("SELECT * FROM parcelas WHERE pedido_id = $pedido_id AND publicado = 1")->fetchAll(PDO::FETCH_ASSOC);
        if (count($parcelas) > 0) {
            foreach ($parcelas as $parcela) {
                DbModel::consultaSimples("UPDATE parcela_complementos SET publicado = '0' WHERE parcela_id = '{$parcela['id']}'");
                DbModel::consultaSimples("UPDATE parcelas SET publicado = '0' WHERE pedido_id = $pedido_id AND numero_parcelas = '{$parcela['numero_parcelas']}'");
            }

        }

        //insere as parcelas dentro da tabela parcelas e parcelas_complementos
        for ($i = 0; $i < count($post['numero_parcelas']); $i++):
            $arrayParcela = [
                'pedido_id' => $pedido_id,
                'numero_parcelas' => $i + 1,
                'valor' => $post['valor'][$i],
                'data_pagamento' => $post['data_pagamento'][$i],
                'publicado' => '1',
            ];
            $insertParcelas = DbModel::insert('parcelas', $arrayParcela);
            if ($insertParcelas && DbModel::connection()->errorCode() == 0):
                $arrayParcelaComplementos = [
                    'parcela_id' => DbModel::connection()->lastInsertId(),
                    'data_inicio' => $post['data_inicio'][$i],
                    'data_fim' => $post['data_fim'][$i],
                    'carga_horaria' => $post['carga_horaria'][$i],
                    'publicado' => '1',
                ];
                DbModel::insert('parcela_complementos', $arrayParcelaComplementos);
            endif;
        endfor;

        if (DbModel::connection()->errorCode() == 0) {
            $dadosParcelas = DbModel::consultaSimples("SELECT * FROM parcelas WHERE pedido_id = $pedido_id AND publicado = 1")->fetchAll(PDO::FETCH_OBJ);
            $formaCompleta = "";
            for ($i = 0; $i < count($dadosParcelas); $i++) :
                $forma = $i + 1 . "º parcela R$ " . MainModel::dinheiroParaBr($dadosParcelas[$i]->valor) . ". Entrega de documentos a partir de " . MainModel::dataParaBR($dadosParcelas[$i]->data_pagamento) . ".\n";
                $formaCompleta = $formaCompleta . $forma;
            endfor;

            $formaCompleta = $formaCompleta . "\nA liquidação de cada parcela se dará em 3 (três) dias úteis após a data de confirmação da correta execução do(s) serviço(s).";
            DbModel::consultaSimples("UPDATE pedidos SET forma_pagamento = '$formaCompleta' WHERE id = $pedido_id AND origem_tipo_id = 2");

            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Parcelas Atualizadas!',
                'texto' => 'Parcelas atualizadas com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/pedido_contratacao_cadastro&pedido_id=' . MainModel::encryption($pedido_id)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }*/

    public function consultaPedido($contratacao_id)
    {
        $contratacao_id = MainModel::decryption($contratacao_id);
        $testaPedido = DbModel::consultaSimples("SELECT id FROM pedidos WHERE origem_id = $contratacao_id AND publicado = 1 AND origem_tipo_id = 2")->rowCount();
        $consulta = $testaPedido > 0;
        return $consulta;
    }

    public function retornaNotaEmpenho($pedido_id)
    {
        $pedido_id = MainModel::decryption($pedido_id);
        return DbModel::consultaSimples("SELECT nota_empenho, emissao_nota_empenho, entrega_nota_empenho FROM pagamentos WHERE pedido_id = $pedido_id")->fetchObject();
    }

    public function cadastrarNotaEmpenho($post)
    {
        unset($post['_method']);
        $post['pedido_id'] = MainModel::decryption($post['pedido_id']);
        $dados = MainModel::limpaPost($post);

        $insert = DbModel::insert('pagamentos', $dados);
        if ($insert->rowCount() >= 1) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Nota de Empenho Cadastrada!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/empenho_cadastro&id=' . MainModel::encryption($post['pedido_id'])
            ];
        } else {
            $alerta = [
                'Alerta' => 'simples',
                'titulo' => 'Oops! Algo deu errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde.',
                'tipo' => 'error'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function editarNotaEmpenho($post)
    {
        unset($post['_method']);
        $pedido_id = MainModel::decryption($post['pedido_id']);
        $post['pedido_id'] = $pedido_id;
        $dados = MainModel::limpaPost($post);

        $update = DbModel::updateEspecial('pagamentos', $dados, "pedido_id", $pedido_id);

        if ($update || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Nota de Empenho',
                'texto' => 'Alteração realizada com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/empenho_cadastro&id=' . MainModel::encryption($pedido_id)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . 'formacao/empenho_cadastro&id=' . MainModel::encryption($pedido_id)
            ];
        }

        return MainModel::sweetAlert($alerta);
    }

    public function pesquisas($post, $where)
    {
        $sqlProtocolo = "";
        $sqlProponente = "";
        $sqlProcesso = "";
        $sqlStatus = "";

        if ($where == "protocolo") {
            $protocolo = $post;
            $sqlProtocolo = " AND fc.protocolo LIKE '%$protocolo%'";
        }

        if ($where == "proponente") {
            $proponente = $post;
            $sqlProponente = " AND p.pessoa_fisica_id = '$proponente'";
        }
        if ($where == "processo") {
            $processo = $post;
            $sqlProcesso = " AND p.numero_processo LIKE '%$processo%'";
        }
        if ($where == "status") {
            $status = $post;
            $sqlStatus = " AND p.status_pedido_id = '$status'";
        }


        $consulta = DbModel::consultaSimples("SELECT p.id AS pedido_id, fc.protocolo, pf.nome, ns.nome_social, p.numero_processo, s.status 
                                                  FROM formacao_contratacoes fc 
                                                  INNER JOIN pedidos p ON fc.id = p.origem_id
                                                  LEFT JOIN pessoa_fisicas pf ON p.pessoa_fisica_id = pf.id
                                                  LEFT JOIN pf_nome_social ns ON ns.pessoa_fisica_id = pf.id
                                                  INNER JOIN pedido_status s ON s.id = p.status_pedido_id
                                                  WHERE p.origem_tipo_id = 2 AND p.publicado = 1$sqlProponente $sqlProcesso $sqlProtocolo $sqlStatus")->fetchAll(PDO::FETCH_ASSOC);
        if (count($consulta) > 0) {
            for ($i = 0; $i < count($consulta); $i++) {
                $consulta[$i]['pedido_id'] = MainModel::encryption($consulta[$i]['pedido_id']);
            }
            return json_encode(array($consulta));
        }

        return '0';
    }

    public function retornaObjetoFormacao($contratacao_id, $decryption = 0)
    {
        if ($decryption != 0) {
            $contratacao_id = MainModel::decryption($contratacao_id);
        }

        $consultaNomes = DbModel::consultaSimples("SELECT fc.programa_id, p.programa, l.linguagem, p.edital, fcargo.cargo FROM programas AS p 
                                        INNER JOIN formacao_contratacoes AS fc ON p.id = fc.programa_id
                                        INNER JOIN formacao_cargos AS fcargo ON fc.form_cargo_id = fcargo.id
                                        INNER JOIN linguagens l ON fc.linguagem_id = l.id
                                        WHERE fc.id = $contratacao_id AND fc.publicado = 1");
        if ($consultaNomes->rowCount() > 0) {
            $nomesObj = $consultaNomes->fetchObject();

            if ($nomesObj->programa_id == 1) {
                $texto['programa'] = "VOCACIONAL";
            } else {
                $texto['programa'] = "DE INICIAÇÃO ARTÍSTICA";
            }

            $objeto = "CONTRATAÇÃO COMO $nomesObj->cargo de $nomesObj->linguagem DO PROGRAMA {$texto['programa']} - 2021 NOS TERMOS DO $nomesObj->edital - PROGRAMAS DA SUPERVISÃO DE FORMAÇÃO CULTURAL.";
            $encoding = 'UTF-8';
            return mb_convert_case($objeto, MB_CASE_UPPER, $encoding);
        } else {
            return "";
        }
    }

    public function listaDadosContratacao($ano = 0)
    {
        $whereAno = "";
        if ($ano) {
            $whereAno = " AND c.ano = {$ano}";
        }

        $sql = "SELECT
                    c.id AS 'id',
                    c.protocolo AS 'protocolo',
                    pf.nome AS 'pessoa',
                    ns.nome_social,
                    c.ano AS 'ano',
                    p.programa AS 'programa',
                    l.linguagem AS 'linguagem',
                    fc.cargo AS 'cargo'
                FROM formacao_contratacoes AS c
                INNER JOIN pessoa_fisicas AS pf ON pf.id = c.pessoa_fisica_id
                LEFT JOIN pf_nome_social AS ns ON pf.id = ns.pessoa_fisica_id                    
                INNER JOIN programas AS p ON p.id = c.programa_id
                INNER JOIN linguagens AS l ON l.id = c.linguagem_id
                INNER JOIN formacao_cargos AS fc ON fc.id = c.form_cargo_id
                WHERE c.publicado = 1 {$whereAno}";
        return DbModel::consultaSimples($sql);
    }

    public function listaDadosContratacaoCapac($ano = 0)
    {

        $whereAno = "";
        if ($ano) {
            $whereAno = " AND fc.ano = {$ano}";
        }

        $sqlFormacao = "SELECT fc.*, pf.id AS 'pf_id', pf.nome, pf.cpf FROM form_cadastros fc
                        INNER JOIN pessoa_fisicas pf on fc.pessoa_fisica_id = pf.id
                        WHERE fc.protocolo IS NOT NULL AND fc.publicado = 1 {$whereAno}";

        $formacoes = MainModel::consultaSimples($sqlFormacao, true)->fetchAll(PDO::FETCH_OBJ);

        foreach ($formacoes as $key => $formacao) {
            $formacoes[$key]->cargo = MainModel::getInfo('formacao_cargos', $formacao->form_cargo_id)->fetchObject()->cargo;
            $formacoes[$key]->programa = MainModel::getInfo('programas', $formacao->programa_id)->fetchObject()->programa;
            $formacoes[$key]->linguagem = MainModel::getInfo('linguagens', $formacao->linguagem_id)->fetchObject()->linguagem;
        }
        return $formacoes;
    }

    public function chegaProtocolo($protocolo)
    {
        $protocolo = DbModel::consultaSimples("SELECT * FROM formacao_contratacoes WHERE protocolo = '$protocolo'")->rowCount();
        return $protocolo > 0 ? true : false;
    }


    public function recuperaDetalhesContratacao($contratacao_id)
    {
        $contratacao_id = MainModel::decryption($contratacao_id);
        //var_dump($contratacao_id);
        return DbModel::consultaSimples("SELECT f.id, 
                                                f.ano,
                                                f.chamado,
                                                cla.classificacao_indicativa,
                                                t.territorio,
                                                c.coordenadoria,
                                                s.subprefeitura,
                                                prog.programa,
                                                l.linguagem,
                                                proj.projeto,
                                                fc.cargo,
                                                fv.ano AS 'vigencia',
                                                f.observacao,
                                                fiscal.nome_completo AS 'fiscal',
                                                suplente.nome_completo AS 'suplente',       
                                                f.num_processo_pagto AS 'numpgt'
                                        FROM formacao_contratacoes AS f 
                                        INNER JOIN classificacao_indicativas AS cla ON f.classificacao = cla.id
                                        INNER JOIN territorios AS t ON f.territorio_id = t.id
                                        INNER JOIN coordenadorias AS c ON f.coordenadoria_id = c.id
                                        INNER JOIN subprefeituras AS s ON f.subprefeitura_id = s.id
                                        INNER JOIN programas AS prog ON f.programa_id = prog.id
                                        INNER JOIN linguagens AS l ON f.linguagem_id = l.id
                                        INNER JOIN projetos AS proj ON f.projeto_id = proj.id
                                        INNER JOIN formacao_cargos fc ON f.form_cargo_id = fc.id
                                        INNER JOIN formacao_vigencias fv ON f.form_vigencia_id = fv.id
                                        INNER JOIN usuarios AS fiscal ON f.fiscal_id = fiscal.id
                                        LEFT JOIN usuarios AS suplente ON f.suplente_id = suplente.id 
                                        WHERE f.id = $contratacao_id AND f.publicado = 1 ")->fetchObject();
    }

    public function listaPF()
    {
        return parent::getPF();
    }

    public function listaRegiaoPrefencial()
    {
        return parent::getRegiaoPreferencial();
    }

    public function insereDadosContratacao($post)
    {
        unset($post['_method']);
        $locais_id = $post['local_id'];
        unset($post['local_id']);

        $dados = MainModel::limpaPost($post);

        $insert = DbModel::insert('formacao_contratacoes', $dados);
        if ($insert->rowCount() >= 1) {
            $contratacao_id = DbModel::connection()->lastInsertId();
            if (isset($post['protocolo'])) {
                //caso seja importação do capac, pegar o protocolo ja exixtente
                $protocolo = $post['protocolo'];
            } else {
                $protocolo = MainModel::geraProtocoloEFE($contratacao_id) . '-F';
            }
            DbModel::consultaSimples("UPDATE formacao_contratacoes SET protocolo = '$protocolo' WHERE id = $contratacao_id");
            for ($i = 0; $i < count($locais_id); $i++):
                if ($locais_id[$i] > 0):
                    $array = [
                        'form_pre_pedido_id' => $contratacao_id,
                        'local_id' => $locais_id[$i],
                    ];
                    DbModel::insert('formacao_locais', $array);
                endif;
            endfor;
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Dados de contratação Cadastrados',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/dados_contratacao_cadastro&id=' . MainModel::encryption($contratacao_id)
            ];
        } else {
            $alerta = [
                'Alerta' => 'simples',
                'titulo' => 'Oops! Algo deu errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde.',
                'tipo' => 'error'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }


    public function recuperaDadosContratacao($contratacao_id)
    {
        $contratacao_id = MainModel::decryption($contratacao_id);
        return DbModel::getInfo('formacao_contratacoes', $contratacao_id)->fetchObject();
    }

    public function recuperaDadosContratacaoCapac($capac_id)
    {
        $capac_id = MainModel::decryption($capac_id);
        return DbModel::getInfo('form_cadastros', $capac_id, true)->fetchObject();
    }

    public function editaDadosContratacao($post)
    {
        $contratacao_id = MainModel::decryption($post['id']);
        unset($post['id']);
        unset ($post['_method']);

        $consultaLocais = DbModel::consultaSimples("SELECT * FROM formacao_locais WHERE form_pre_pedido_id = $contratacao_id")->rowCount();
        if ($consultaLocais > 0) :
            DbModel::deleteEspecial('formacao_locais', 'form_pre_pedido_id', $contratacao_id);
        endif;

        for ($i = 0; $i < count($post['local_id']); $i++):
            if ($post['local_id'][$i] > 0):
                $array = [
                    'form_pre_pedido_id' => $contratacao_id,
                    'local_id' => $post['local_id'][$i]
                ];
                DbModel::insert('formacao_locais', $array);
            endif;
        endfor;
        unset ($post['local_id']);

        $dados = MainModel::limpaPost($post);
        $update = DbModel::update('formacao_contratacoes', $dados, $contratacao_id);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Dados de Contratação Atualizados!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/dados_contratacao_cadastro&id=' . MainModel::encryption($contratacao_id)
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

    public function apagaDadosContratacao($post)
    {
        unset($post['_method']);
        $contratacao_id = MainModel::decryption($post['id']);
        unset($post['id']);
        $delete = DbModel::apaga('formacao_contratacoes', $contratacao_id);
        if ($delete->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Dados de contratação Apagados!',
                'texto' => 'Dados apagados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/dados_contratacao_lista'
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu errado!',
                'texto' => 'Falha ao salvar os dados no servidos, tente novamente mais tarde',
                'tipo' => 'error'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function listaDocumento($documento, $tipo_documento)
    {
        return parent::getDocumento($documento, $tipo_documento);
    }

    public function recuperaEnderecoPf($idPf)
    {
        $idPf = MainModel::decryption($idPf);

        $testaEnderecos = DbModel::consultaSimples("SELECT * FROM pf_enderecos WHERE pessoa_fisica_id = $idPf");

        if ($testaEnderecos->rowCount() > 0) {
            while ($enderecoArray = $testaEnderecos->fetch(PDO::FETCH_ASSOC)) {
                $endereco = $enderecoArray['logradouro'] . ", " . $enderecoArray['numero'] . " " . $enderecoArray['complemento'] . " / - " . $enderecoArray['bairro'] . " - " . $enderecoArray['cidade'] . " / " . $enderecoArray['uf'];
            }
        } else {
            $endereco = "Não cadastrado";
        }
        return $endereco;
    }

    public function recuperaTelefonePf($idPf)
    {
        $idPf = MainModel::decryption($idPf);
        $sqlTelefone = DbModel::consultaSimples("SELECT * FROM pf_telefones WHERE pessoa_fisica_id = '$idPf' AND publicado = 1");
        $telefones = $sqlTelefone->fetch(PDO::FETCH_ASSOC);
        $numTelefone = $sqlTelefone->rowCount();

        return $telefones;
    }

    public function recuperaTelefonePf2($idPf)
    {
        $idPf = MainModel::decryption($idPf);
        return DbModel::consultaSimples("SELECT * FROM pf_telefones WHERE pessoa_fisica_id = '$idPf' AND publicado = 1")->fetchAll(PDO::FETCH_OBJ);
        //$telefones = $sqlTelefone->fetch(PDO::FETCH_ASSOC);
        //$numTelefone = $sqlTelefone->rowCount();

        //return $telefones;
    }

    public function listaDocumentos()
    {
        return $this->listaPublicado("formacao_lista_documentos", null);
    }

    public function recuperaDocumento($id)
    {
        $id = $this->decryption($id);
        return $this->getInfo("formacao_lista_documentos", $id)->fetch(PDO::FETCH_OBJ);
    }

    public function insereDocumento($post)
    {
        $dados = [];
        unset($post['_method']);
        $dados = MainModel::limpaPost($post);

        $insere = DbModel::insert("formacao_lista_documentos", $dados, false);

        if ($insere || DbModel::connection()->errorCode() == 0) {
            $documento_id = $this->encryption(DbModel::connection()->lastInsertId());
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Documento',
                'texto' => 'Cadastro realizado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/documento_cadastro&id=' . $documento_id
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . 'formacao/documento_cadastro'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function editaDocumento($post)
    {
        $id = MainModel::decryption($post['id']);
        $dados = [];
        unset($post['_method']);
        unset($post['id']);

        $dados = MainModel::limpaPost($post);

        $edita = $this->update("formacao_lista_documentos", $dados, $id);

        if ($edita || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Documento',
                'texto' => 'Alteração realizada com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/documento_cadastro&id=' . MainModel::encryption($id)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . 'formacao/documento_cadastro' . MainModel::encryption($id)
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function apagaDocumento($post)
    {
        $id = MainModel::decryption($post['id']);
        $apaga = DbModel::apaga("formacao_lista_documentos", $id);
        if ($apaga || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Documento Deletado!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/documento_lista'
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao apagar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function listaAbertura()
    {
        $sql = "SELECT fa.*, fe.edital FROM form_aberturas AS fa
                INNER JOIN form_editais fe on fe.id = fa.form_edital_id";
        return DbModel::consultaSimples($sql, true)->fetchAll(PDO::FETCH_OBJ);
    }

    public function recuperaAbertura($id)
    {
        $id = MainModel::decryption($id);
        return DbModel::getInfo('form_aberturas', $id, true)->fetchObject();
    }

    public function insereAbertura($post)
    {
        $dados = [];
        unset($post['_method']);

        $dados = MainModel::limpaPost($post);

        //validação para forçar null em campos vazios
        if ($dados['ano_referencia'] == "")
            $dados['ano_referencia'] = null;

        if ($dados['data_abertura'] != "")
            $dados['data_abertura'] = MainModel::dataHoraParaSQL($dados['data_abertura']);
        else
            $dados['data_abertura'] = null;

        if ($dados['data_encerramento'] != "")
            $dados['data_encerramento'] = MainModel::dataHoraParaSQL($dados['data_encerramento']);
        else
            $dados['data_encerramento'] = null;

        $insere = DbModel::insert("form_aberturas", $dados, true);

        if ($insere || DbModel::connection()->errorCode() == 0) {
            $abertura_id = $this->encryption(DbModel::connection()->lastInsertId());
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Abertura',
                'texto' => 'Cadastro realizado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/abertura_cadastro&id=' . $abertura_id
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . 'formacao/abertura_cadastro'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function editaAbertura($post)
    {
        $id = MainModel::decryption($post['id']);
        $dados = [];
        unset($post['_method']);
        unset($post['id']);

        $dados = MainModel::limpaPost($post);

        //validação para forçar null em campos vazios
        if ($dados['ano_referencia'] == "")
            $dados['ano_referencia'] = null;

        if ($dados['data_abertura'] != "")
            $dados['data_abertura'] = MainModel::dataHoraParaSQL($dados['data_abertura']);
        else
            $dados['data_abertura'] = null;

        if ($dados['data_encerramento'] != "")
            $dados['data_encerramento'] = MainModel::dataHoraParaSQL($dados['data_encerramento']);
        else
            $dados['data_encerramento'] = null;

        $edita = $this->update("form_aberturas", $dados, $id, true);

        if ($edita || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Abertura',
                'texto' => 'Alteração realizada com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/abertura_cadastro&id=' . MainModel::encryption($id)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . 'formacao/abertura_cadastro' . MainModel::encryption($id)
            ];
        }

        return MainModel::sweetAlert($alerta);
    }

    public function apagaAbertura($post)
    {
        $id = MainModel::decryption($post['id']);
        $apaga = DbModel::apaga("form_aberturas", $id, true);
        if ($apaga || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Abertura Deletada!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/abertura_lista'
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao apagar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function recuperaAnoVigente()
    {
        return DbModel::consultaSimples("SELECT MAX(ano_referencia) as ano_vigente FROM capac_new.form_aberturas WHERE publicado != 0", true)->fetchObject();
    }

    public function listarIncritos($dados)
    {
        $where = " ";
        if (count($dados)) {

            foreach ($dados as $key => $value) {
                if ($value != '') {
                    if ($key != 'data') {
                        $where .= " AND {$key} = {$value}";
                    } else {
                        if (count($value) == 2 && ($value[0] != '' && $value[1] != '')) {
                            $where .= " AND (fc.data_envio BETWEEN '{$value[0]}' AND '{$value[1]}') ";
                        } elseif (count($value) == 1) {
                            if ($value[0] != '') {
                                $where .= " AND fc.data_envio = '{$value[0]}' ";
                            } elseif ($value[1] != '') {
                                $where .= " AND fc.data_envio = '{$value[1]}' ";
                            }
                        }
                    }
                }
            }
        }

        $sql = "SELECT 	    fc.id, fc.protocolo, pf.nome, pf.cpf, fc.ano, fr.regiao, 
                            fc.form_cargo_id, fc.programa_id, 
                            fc.linguagem_id, e.descricao AS `etnia`, g.genero, 
                            IF (pd.trans, 'Sim', 'Não') AS `trans`,
                            IF (pd.pcd, 'Sim', 'Não') AS `pcd`
                 FROM form_cadastros fc
                 LEFT JOIN pessoa_fisicas					pf  ON fc.pessoa_fisica_id = pf.id
                 LEFT JOIN form_regioes_preferenciais	    fr  ON fc.regiao_preferencial_id = fr.id
                 LEFT JOIN pf_detalhes						pd  ON pf.id = pd.pessoa_fisica_id
                 LEFT JOIN etnias							e   ON e.id = pd.etnia_id
                 LEFT JOIN generos							g   ON g.id = pd.genero_id
                 WHERE protocolo IS NOT NULL AND `fc`.`publicado` = 1";

        $sql .= $where;

        return DbModel::consultaSimples($sql, true)->fetchAll(PDO::FETCH_OBJ);
    }

    public function recuperaInscrito(string $id)
    {
        $id = $this->decryption($id);

        $sql = "SELECT 	fc.id, fc.protocolo, pf.nome, pf.rg, pf.passaporte, pf.ccm, pf.nome_artistico, pf.email,
                        pf.cpf, pf.data_nascimento, fc.ano, pf.nacionalidade_id, na.nacionalidade, fr.regiao,
                        fc.pessoa_fisica_id, pe.logradouro, pe.numero, pe.complemento, pe.bairro, pe.cidade,
                        fc.form_cargo_id, gi.grau_instrucao, pe.uf, pe.cep, e.descricao AS `etnia`, g.genero, 
                        ba.banco, pb.agencia, pb.conta, fc.programa_id, fc.regiao_preferencial_id, 
                        fc.linguagem_id, pb.banco_id, pd.grau_instrucao_id, pd.etnia_id, pd.genero_id,
                        fcd.form_cargo2_id, form_cargo3_id, nt.nit, dr.drt, fc.data_envio,                       
                        IF (pd.trans, 'Sim', 'Não') AS `trans`,
                        IF (pd.pcd, 'Sim', 'Não') AS `pcd`
             FROM form_cadastros fc
             LEFT JOIN pessoa_fisicas					pf  ON fc.pessoa_fisica_id = pf.id
             LEFT JOIN nits					            nt  ON nt.pessoa_fisica_id = pf.id
             LEFT JOIN drts					            dr  ON dr.pessoa_fisica_id = pf.id
             LEFT JOIN pf_enderecos						pe  ON pf.id = pe.pessoa_fisica_id 
             LEFT JOIN nacionalidades					na  ON pf.nacionalidade_id = na.id
             LEFT JOIN form_regioes_preferenciais	    fr  ON fc.regiao_preferencial_id = fr.id
             LEFT JOIN pf_detalhes						pd  ON pf.id = pd.pessoa_fisica_id
             LEFT JOIN pf_bancos                        pb  ON pf.id = pb.pessoa_fisica_id
             LEFT JOIN bancos                           ba  ON ba.id = pb.banco_id
             LEFT JOIN grau_instrucoes					gi  ON pd.grau_instrucao_id = gi.id
             LEFT JOIN etnias							e   ON e.id = pd.etnia_id
             LEFT JOIN generos							g   ON g.id = pd.genero_id
             LEFT JOIN form_cargos_adicionais           fcd ON fc.id = fcd.form_cadastro_id
             WHERE protocolo IS NOT NULL AND fc.id = {$id}";

        return $this->consultaSimples($sql, true)->fetchObject();
    }

    public function recuperaTelInscrito($pesquisa_fisica_id, $obj = 0)
    {
        $tel = "";

        $telArrays = DbModel::consultaSimples("SELECT telefone FROM pf_telefones WHERE pessoa_fisica_id = $pesquisa_fisica_id", true)->fetchAll(PDO::FETCH_ASSOC);
        if ($obj != NULL):
            return $telArrays;
        else:
            foreach ($telArrays as $telArrays) {
                $tel = $tel . $telArrays['telefone'] . '/ ';
            }
            return substr($tel, 0, -2);
        endif;
    }

    public function recuperaArquivosCapacInscritos($id)
    {
        $sql = "SELECT fl.documento, far.arquivo
                FROM formacao_arquivos far
                LEFT JOIN formacao_lista_documentos AS fl ON far.formacao_lista_documento_id = fl.id
                WHERE far.publicado = 1 AND far.form_cadastro_id = {$id}";

        return $this->consultaSimples($sql)->fetchAll(PDO::FETCH_OBJ);
    }

//    public function insereInscrito($id)
//    {
//        $inscrito = $this->recuperaInscrito($id);
//
//        $phones = $this->recuperaTelInscrito($inscrito->id, 1);
//
//        //Tabela pessoa_fisicas
//        $pessoaFisica = [];
//        $pessoaFisica['nome'] = $inscrito->nome;
//        $pessoaFisica['nome_artistico'] = $inscrito->nome_artistico;
//        $pessoaFisica['rg'] = $inscrito->rg;
//        $pessoaFisica['passaporte'] = $inscrito->passaporte;
//        $pessoaFisica['cpf'] = $inscrito->cpf;
//        $pessoaFisica['ccm'] = $inscrito->ccm;
//        $pessoaFisica['data_nascimento'] = $inscrito->data_nascimento;
//        $pessoaFisica['nacionalidade_id'] = $inscrito->nacionalidade_id;
//        $pessoaFisica['email'] = $inscrito->email;
//
//        //Tabela pf_detalhes
//        $pfDetalhes = [];
//        $pfDetalhes['etnia_id'] = $inscrito->etnia_id;
//        $pfDetalhes['genero_id'] = $inscrito->genero_id;
//        $pfDetalhes['regiao_id'] = $inscrito->regiao_preferencial_id;
//        $pfDetalhes['grau_instrucao_id'] = $inscrito->grau_instrucao_id;
//        $pfDetalhes['curriculo'] = '';
//        $pfDetalhes['trans'] = $inscrito->trans == 'Sim' ? 1 : 0;
//        $pfDetalhes['pcd'] = $inscrito->pcd == 'Sim' ? 1 : 0;
//
//        //Tabela pf_enderecos
//        $pfEndereco = [];
//        $pfEndereco['logradouro'] = $inscrito->logradouro;
//        $pfEndereco['numero'] = $inscrito->numero;
//        $pfEndereco['complemento'] = $inscrito->complemento;
//        $pfEndereco['bairro'] = $inscrito->bairro;
//        $pfEndereco['cidade'] = $inscrito->cidade;
//        $pfEndereco['uf'] = $inscrito->uf;
//        $pfEndereco['cep'] = $inscrito->cep;
//
//        //Tabela pf_bancos
//        $pfBanco = [];
//        $pfBanco['banco_id'] = $inscrito->banco_id;
//        $pfBanco['agencia'] = $inscrito->agencia;
//        $pfBanco['conta'] = $inscrito->conta;
//
//        try {
//            $insertPf = DbModel::insert('pessoa_fisicas', $pessoaFisica);
//            if ($insertPf || DbModel::connection()->errorCode() == 0) {
//                $pessoaFisica_id = DbModel::connection()->lastInsertId();
//                $pfDetalhes['pessoa_fisica_id'] = $pessoaFisica_id;
//                $pfEndereco['pessoa_fisica_id'] = $pessoaFisica_id;
//                $pfBanco['pessoa_fisica_id'] = $pessoaFisica_id;
//
//
//                $insertDetalhes = DbModel::insert('pf_detalhes', $pfDetalhes);
//                if ($insertDetalhes || DbModel::connection()->errorCode() == 0) {
//                    $insertEndereco = DbModel::insert('pf_enderecos', $pfEndereco);
//                    if ($insertEndereco || DbModel::connection()->errorCode() == 0) {
//                        $insertBanco = DbModel::insert('pf_bancos', $pfBanco);
//                        if ($insertBanco || DbModel::connection()->errorCode() == 0) {
//                            foreach ($phones as $phone) {
//                                $pfPhone = [];
//                                $pfPhone['pessoa_fisica_id'] = $pessoaFisica_id;
//                                $pfPhone['telefone'] = $phone['telefone'];
//
//                                DbModel::insert('pf_telefones', $pfPhone);
//                            }
//                            if (DbModel::connection()->errorCode() == 0) {
//                                $alerta = [
//                                    'alerta' => 'sucesso',
//                                    'titulo' => 'Importação de inscrito',
//                                    'texto' => 'Importação de inscrito realizada com sucesso!',
//                                    'tipo' => 'success',
//                                    'location' => SERVERURL . 'formacao/resumo_inscrito&id=' . $id
//                                ];
//                                return MainModel::sweetAlert($alerta);
//                            }
//                        }
//                    }
//                }
//            }
//        } catch (Exception $e) {
//            $alerta = [
//                'alerta' => 'simples',
//                'titulo' => 'Erro!',
//                'texto' => 'Erro ao importar!<br>' . $e->getMessage() . '!',
//                'tipo' => 'error',
//                'location' => SERVERURL . 'formacao/resumo_inscrito&id=' . $id
//            ];
//            return MainModel::sweetAlert($alerta);
//        }
//    }

    public function insereInscrito($id, $novoImport = true, $pfSis_id = null)
    {

        if ($novoImport) {
            $pfCapac_id = MainModel::encryption(self::recuperaInscrito($id)->pessoa_fisica_id);

            $idPfInscrito = (new PessoaFisicaController)->importarPf($pfCapac_id, true);
            if (!$idPfInscrito) {
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'O CPF possui divergencias',
                    'texto' => 'O CPF selecionado já possui cadastro no Siscontrat, selecione os dados que deseja atualizar antes de completar a importação',
                    'tipo' => 'warning',
                    'location' => SERVERURL . "formacao/compara_capac&id=$pfCapac_id&capac=$id"
                ];
            } else {
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Proponente Importado!',
                    'texto' => 'O CPF selecionado foi importado ao Siscontrat. Conclua o cadastro na próxima tela.',
                    'tipo' => 'success',
                    'location' => SERVERURL . "formacao/dados_contratacao_cadastro&capac=$id"
                ];
            }
        } else {
            $pf = PessoaFisicaController::editaPessoaFisica($pfSis_id, "", true);

            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Proponente Importado!',
                'texto' => 'O CPF selecionado foi importado ao Siscontrat. Conclua o cadastro na próxima tela.',
                'tipo' => 'success',
                'location' => SERVERURL . "formacao/dados_contratacao_cadastro&capac=$id"
            ];
        }

        return MainModel::sweetAlert($alerta);
    }

    public function recuperaIdContratacao($protocoloCapac)
    {
        $idContratacao = DbModel::consultaSimples("SELECT * FROM formacao_contratacoes WHERE protocolo = '$protocoloCapac'")->fetchObject()->id; //sis
        return MainModel::encryption($idContratacao);
    }

    /**
     * @param int|string $contratacao_id <p>id da tabela formacao_contratacoes</p>
     * @return object
     */
    public function recuperaFormacaoContratacao($contratacao_id): stdClass //para o PedidoController::recuperaPedido
    {
        if (gettype($contratacao_id) == "string") {
            $contratacao_id = MainModel::decryption($contratacao_id);
        }
        $form = DbModel::consultaSimples("SELECT fc.protocolo, fc.pessoa_fisica_id, fc.ano, fs.status, fc.chamado, fc.classificacao, t.territorio, cor.coordenadoria, s.subprefeitura, pro.programa, l.linguagem, prj.projeto, c.cargo, fc.form_vigencia_id, fc.observacao, fis.nome_completo as fiscal_nome, fis.rf_rg as fiscal_rf, sup.nome_completo as suplente_nome, sup.rf_rg as suplente_rf, fc.num_processo_pagto, user.nome_completo as usuario_nome, fc.data_envio, rp.regiao
            FROM formacao_contratacoes AS fc
                INNER JOIN formacao_status fs on fc.form_status_id = fs.id
                INNER JOIN territorios t on fc.territorio_id = t.id
                INNER JOIN coordenadorias AS cor ON cor.id = fc.coordenadoria_id
                INNER JOIN subprefeituras s on fc.subprefeitura_id = s.id
                INNER JOIN programas AS pro ON pro.id = fc.programa_id
                INNER JOIN linguagens AS l ON l.id = fc.linguagem_id
                INNER JOIN projetos prj on fc.projeto_id = prj.id
                INNER JOIN formacao_cargos AS c ON c.id = fc.form_cargo_id
                LEFT JOIN usuarios fis on fc.fiscal_id = fis.id
                LEFT JOIN usuarios sup on fc.suplente_id = sup.id
                LEFT JOIN usuarios user on fc.usuario_id = user.id
                INNER JOIN regiao_preferencias rp on fc.regiao_preferencia_id = rp.id
                WHERE fc.id = '$contratacao_id' AND fc.publicado = 1
        ")->fetch(PDO::FETCH_ASSOC);
        $pfObj = new PessoaFisicaController();
        $idPf = $this->encryption($form['pessoa_fisica_id']);
        $pf = $pfObj->recuperaPessoaFisica($idPf);
        $contratacao = array_merge((array)$form, (array)$pf);
        return (object)$contratacao;
    }

    public function recuperaSubprefeituraContratacao($contratacao_id)
    {
        $locais = $this->retornaLocaisFormacao($contratacao_id, 1);
        $subprefeituras = "";
        for ($i = 0; $i < sizeof($locais); $i++) {
            if ($i === 0) {
                $subprefeituras .= $locais[$i]['subprefeitura'];
            } else {
                $subprefeituras .= " ; " . $locais[$i]['subprefeitura'];
            }
        }
        return $subprefeituras;
    }

    public function listaLocais()
    {
        return DbModel::consultaSimples("SELECT 	l.id, l.`local`, CONCAT(l.logradouro, ', ', l.numero, ' - ', l.bairro, ', ', l.cidade, ' - ', l.uf) AS 'endereco',
                                                            l.cep, z.zona, s.subprefeitura, CONCAT(i.nome, '(',i.sigla,')') AS 'instituicao'
                                                FROM locais AS l
                                                LEFT JOIN instituicoes AS i ON l.instituicao_id = i.id
                                                LEFT JOIN subprefeituras AS s ON l.subprefeitura_id = s.id
                                                LEFT JOIN zonas AS z ON l.zona_id = z.id")->fetchAll(PDO::FETCH_OBJ);
    }
}


