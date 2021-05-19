<?php
if ($pedidoAjax) {
    require_once "../models/AdministrativoModel.php";
} else {
    require_once "./models/AdministrativoModel.php";
}

class AdministrativoController extends AdministrativoModel
{
    public function listaMural()
    {
        return parent::getAvisos();
    }

    public function recuperaAviso($id)
    {
        $id = MainModel::decryption($id);
        return DbModel::getInfo('avisos', $id)->fetchObject();
    }

    public function insereAviso($post)
    {
        unset ($post['_method']);

        $dados = MainModel::limpaPost($post);
        $dados['data'] = MainModel::dataHoraParaSQL($dados['data']);

        $insert = DbModel::insert('avisos', $dados);
        if ($insert->rowCount() >= 1) {
            $aviso_id = DbModel::connection(true)->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Aviso Cadastrado!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/aviso_cadastro&id=' . MainModel::encryption($aviso_id)
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

    public function editaAviso($post)
    {
        $aviso_id = MainModel::decryption($post['id']);
        unset($post['id']);
        unset($post['_method']);

        $dados = MainModel::limpaPost($post);
        $dados['data'] = MainModel::dataHoraParaSQL($dados['data']);

        $update = DbModel::update('avisos', $dados, $aviso_id);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Aviso Editado!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/aviso_cadastro&id=' . MainModel::encryption($aviso_id)
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

    public function listaCategorias()
    {
        $categorias = DbModel::listaPublicado("categoria_atracoes", null, false);

        return $categorias;
    }

    public function cadastrarCategoria($post)
    {

        unset ($post['_method']);

        $dados = MainModel::limpaPost($post);

        $insert = DbModel::insert('categoria_atracoes', $dados, false);
        if ($insert->rowCount() >= 1) {
            $categoria_id = DbModel::connection()->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Categoria Cadastrada!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/cadastra_categoria&id=' . MainModel::encryption($categoria_id)
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

    public function editarCategoria($post)
    {
        $categoria_id = MainModel::decryption($post['id']);
        unset($post['id']);
        unset ($post['_method']);

        $dados = MainModel::limpaPost($post);

        $update = DbModel::update('categoria_atracoes', $dados, $categoria_id, false);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Categoria Atualizada!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/cadastra_categoria&id=' . MainModel::encryption($categoria_id)
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

    public function deletaCategoria($post)
    {
        $categoria_id = MainModel::decryption($post['idCategoria']);
        unset($post['idCategoria']);

        $update = DbModel::apaga('categoria_atracoes', $categoria_id, false);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Categoria Deletada!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/categoria&id=' . MainModel::encryption($categoria_id)
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

    public function recuperaCategoria($categoria_id)
    {
        $categoria_id = MainModel::decryption($categoria_id);
        return DbModel::getInfo('categoria_atracoes', $categoria_id, false)->fetchObject();
    }

    public function listaInstituicoes()
    {
        $instituicoes = DbModel::consultaSimples("
            SELECT * FROM instituicoes ")->fetchAll(PDO::FETCH_OBJ);
        return $instituicoes;
    }

    public function recuperaInstituicao($instituicao_id)
    {
        $instituicao_id = MainModel::decryption($instituicao_id);
        return DbModel::getInfo('instituicoes', $instituicao_id, false)->fetchObject();
    }

    public function insereInstituicao($post)
    {
        unset ($post['_method']);
        $dados = MainModel::limpaPost($post);
        $insert = DbModel::insert('instituicoes', $dados, false);
        if ($insert) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Instituição Inserido!',
                'texto' => 'Dados inseridos com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/instituicoes'
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

    public function recuperaLocal($id)
    {
        $id = MainModel::decryption($id);
        return DbModel::consultaSimples("SELECT * FROM locais WHERE id = '$id'")->fetchObject();
    }

    public function listaLocal($id)
    {
        $id = MainModel::decryption($id);
        return DbModel::consultaSimples("SELECT l.*,s.subprefeitura FROM locais AS l  LEFT JOIN subprefeituras AS s ON l.subprefeitura_id = s.id WHERE l.instituicao_id = '$id' AND l.publicado = 1")->fetchAll(PDO::FETCH_OBJ);
    }

    public function recuperaEspaco($id)
    {
        $id = MainModel::decryption($id);
        return DbModel::consultaSimples("SELECT * FROM espacos WHERE id = '$id' AND publicado = 1")->fetchObject();
    }

    public function insereLocal($post)
    {
        $post['instituicao_id'] = MainModel::decryption($post['instituicao_id']);
        unset ($post['_method']);
        $dados = MainModel::limpaPost($post);
        $inserir = MainModel::insert('locais', $dados);

        if ($inserir) {
            $id = DbModel::connection()->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Instituição Inserido!',
                'texto' => 'Dados inseridos com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/local_cadastro&id=' . MainModel::encryption($id) . "&instituicao_id=" . MainModel::encryption($post['instituicao_id'])
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

    public function editaLocal($post)
    {
        $local_id = $post['id'];
        $post['instituicao_id'] = MainModel::decryption($post['instituicao_id']);
        unset($post['id']);
        unset ($post['_method']);

        $dados = MainModel::limpaPost($post);

        $update = DbModel::update('locais', $dados, $local_id, false);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Categoria Atualizada!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/local_cadastro&id=' . MainModel::encryption($local_id) . '&instituicao_id=' . MainModel::encryption($post['instituicao_id'])
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

    public function editaInstituicao($post)
    {
        unset ($post['_method']);
        $id = MainModel::decryption($post['id']);
        $dados = MainModel::limpaPost($post);
        $dados['id'] = $id;
        $update = DbModel::update('instituicoes', $dados, $id, false);
        if ($update) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Instituição Editada!',
                'texto' => 'Dados editados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/instituicoes'
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao editar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }

        return MainModel::sweetAlert($alerta);
    }

    public function insereModulo($post)
    {
        unset($post['_method']);
        $dados = MainModel::limpaPost($post);
        $insert = DbModel::insert('modulos', $dados, false);
        if ($insert->rowCount() >= 1) {
            $modulo_id = DbModel::connection(true)->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Módulo Cadastrado!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/cadastrar_modulo&id=' . MainModel::encryption($modulo_id)
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

    public function listaModulo()
    {
        $pdo = self::connection($capac = false);
        $sql = "SELECT * FROM modulos";
        $statement = $pdo->query($sql);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_OBJ);
        // foreach ($modulos as $key => $modulo) {
        //     $modulos = DbModel::getInfo('modulos', $modulo->modulo_id, false)->fetchObject();
        //     $modulos[$key]->modulos = $modulos->modulos;
        // }
        // return $modulos;

    }

    public function recuperaModulo($modulo_id)
    {
        $modulo_id = MainModel::decryption($modulo_id);
        return DbModel::getInfo('modulos', $modulo_id, false)->fetchObject();
    }

    public function editaModulo($post)
    {
        $modulo_id = MainModel::decryption($post['id']);
        unset($post['id']);
        unset ($post['_method']);
        $dados = MainModel::limpaPost($post);
        $update = DbModel::update('modulos', $dados, $modulo_id, false);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Módulo Atualizado!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/cadastrar_modulo&id=' . MainModel::encryption($modulo_id)
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

    // PERFIL
    public function listaPerfil()
    {
        return parent::getPerfil();
    }

    public function recuperaPerfil($id)
    {
        $id = MainModel::decryption($id);
        return DbModel::getInfo('perfis', $id)->fetchObject();
    }

    public function inserePerfil($post)
    {
        unset ($post['_method']);

        $dados = MainModel::limpaPost($post);

        $insert = DbModel::insert('perfis', $dados);
        if ($insert->rowCount() >= 1) {
            $perfil_id = DbModel::connection(true)->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Aviso Cadastrado!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/perfil_cadastro&id=' . MainModel::encryption($perfil_id)
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

    public function editaPerfil($post)
    {
        $perfil_id = MainModel::decryption($post['id']);
        unset($post['id']);
        unset($post['_method']);

        $dados = MainModel::limpaPost($post);

        $update = DbModel::update('perfis', $dados, $perfil_id);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Aviso Editado!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/perfil_cadastro&id=' . MainModel::encryption($perfil_id)
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

    public function apagaPerfil($id)
    {
        $id = MainModel::decryption($id['id']);
        $apaga = DbModel::apaga("perfis", $id);
        if ($apaga) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Perfil',
                'texto' => 'Perfil apagado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/perfil'
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

    public function listaVerbas()
    {
        $verbas = DbModel::listaPublicado("verbas", null, false);

        return $verbas;
    }

    public function insereVerba($post)
    {

        unset ($post['_method']);

        $dados = MainModel::limpaPost($post);

        $insert = DbModel::insert('verbas', $dados, false);
        if ($insert->rowCount() >= 1) {
            $verba_id = DbModel::connection()->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Verba Cadastrada!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/verbas_cadastro&id=' . MainModel::encryption($verba_id)
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

    public function editarVerba($post)
    {
        $verba_id = MainModel::decryption($post['id']);
        unset($post['id']);
        unset ($post['_method']);

        $dados = MainModel::limpaPost($post);

        $update = DbModel::update('verbas', $dados, $verba_id, false);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Verba Atualizada!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/verbas_cadastro&id=' . MainModel::encryption($verba_id)
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

    public function deletarVerba($post)
    {
        $verba_id = MainModel::decryption($post['idVerba']);
        unset($post['idVerba']);

        $update = DbModel::apaga('verbas', $verba_id, false);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Verba Deletada!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/verbas&id=' . MainModel::encryption($verba_id)
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

    public function recuperaVerba($verba_id)
    {
        $verba_id = MainModel::decryption($verba_id);
        return DbModel::getInfo('verbas', $verba_id, false)->fetchObject();
    }

    public function ListaRelacoesJuridicas()
    {
        return parent::getRelacoesJuridicas();
    }

    public function recuperaRelacoesJuridicas($relacao_id)
    {
        $relacao_id = MainModel::decryption($relacao_id);
        return DbModel::getInfo('relacao_juridicas', $relacao_id, false)->fetchObject();
    }

    public function editaRelacoesJuridicas($post)
    {
        $relacao_id = MainModel::decryption($post['id']);
        unset($post['id']);
        unset ($post['_method']);
        $dados = MainModel::limpaPost($post);
        $update = DbModel::update('relacao_juridicas', $dados, $relacao_id, false);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Relação Jurídica Atualizada!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/cadastrar_relacoes&id=' . MainModel::encryption($relacao_id)
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

    public function insereRelacoesJuridicas($post)
    {
        unset($post['_method']);
        $dados = MainModel::limpaPost($post);
        $insert = DbModel::insert('relacao_juridicas', $dados, false);
        if ($insert->rowCount() >= 1) {
            $relacao_id = DbModel::connection(true)->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Relação Jurídica Cadastrada!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/cadastrar_relacoes&id=' . MainModel::encryption($relacao_id)
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


    public function apagaRelacoesJuridicas($id)
    {
        $id = MainModel::decryption($id['id']);
        $apaga = DbModel::apaga("relacao_juridicas", $id, false);
        if ($apaga) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Relação Jurídica Deletada!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/relacoes_juridicas'
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

    public function listaUsuarios()
    {
        return parent::getUsuarios();
    }

    public function recuperaUsuarios($usuario_id)
    {
        $usuario_id = MainModel::decryption($usuario_id);
        return DbModel::getInfo('usuarios', $usuario_id, false)->fetchObject();
    }

    public function editaUsuarios($post)
    {
        $usuario_id = MainModel::decryption($post['id']);
        unset($post['id']);
        unset ($post['_method']);
        $dados = MainModel::limpaPost($post);
        $update = DbModel::update('usuarios', $dados, $usuario_id, false);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Usuário Atualizado!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/cadastrar_usuarios&id=' . MainModel::encryption($usuario_id)
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

    public function insereUsuarios($post)
    {
        unset($post['_method']);
        $dados = MainModel::limpaPost($post);
        $insert = DbModel::insert('usuarios', $dados, false);
        if ($insert->rowCount() >= 1) {
            $relacao_id = DbModel::connection(true)->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Usuário Cadastrado!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/usuarios'
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

    public function apagaUsuarios($id)
    {
        $id = MainModel::decryption($id['id']);
        $apaga = DbModel::apaga("usuarios", $id, false);
        if ($apaga) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Usuário Deletado!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/usuarios'
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

    public function resetaSenha($id)
    {
        $id = MainModel::decryption($id['id']);
        $pdo = self::connection($capac = false);
        $senha = MainModel::encryption('siscontrat2019');
        $sql = "UPDATE usuarios SET senha =  :senha  WHERE id = :id";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":id", $id);
        $statement->bindValue(":senha", $senha);
        $statement->execute();
        $reseta = $statement;

        if ($reseta) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Senha Resetada!',
                'texto' => 'A senha foi resetada para: siscontrat2019',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/usuarios'
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao resetar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    }
}