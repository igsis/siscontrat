<?php
if ($pedidoAjax) {
    require_once "../models/FormacaoModel.php";
    require_once "../controllers/PedidoController.php";
} else {
    require_once "./models/FormacaoModel.php";
    require_once "./controllers/PedidoController.php";
}

class FormacaoController extends FormacaoModel
{
    public function listaCargos()
    {
        return parent::getCargos();
    }

    public function insereCargo($post){
        unset($post['_method']);
        $dados = MainModel::limpaPost($post);
        $insert = DbModel::insert('formacao_cargos', $dados, false);
        if ($insert->rowCount() >= 1) {
            $cargo_id = DbModel::connection(true)->lastInsertId();
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

    public function recuperaCargo($cargo_id) {
        $cargo_id = MainModel::decryption($cargo_id);
        return DbModel::getInfo('formacao_cargos', $cargo_id, false)->fetchObject();
    }

    public function editaCargo($post)
    {
        $cargo_id = MainModel::decryption($post['id']);
        unset($post['id']);
        unset ($post['_method']);
        $dados = MainModel::limpaPost($post);
        $update = DbModel::update('formacao_cargos', $dados, $cargo_id, false);
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
        $apaga = DbModel::apaga("formacao_cargos", $id, false);
        if ($apaga){
                $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Cargo Deletado!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'formacao/cargo_lista'
                ];
        }else {
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
        return parent::getCoordenadorias();
    }

    public function insereCoordenadoria($post){
        unset($post['_method']);
        $dados = MainModel::limpaPost($post);
        $insert = DbModel::insert('coordenadorias', $dados, false);
        if ($insert->rowCount() >= 1) {
            $coordenadoria_id = DbModel::connection(true)->lastInsertId();
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

    public function recuperaCoordenadoria($coordenadoria_id) {
        $coordenadoria_id = MainModel::decryption($coordenadoria_id);
        return DbModel::getInfo('coordenadorias', $coordenadoria_id, false)->fetchObject();
    }


    public function editaCoordenadoria($post)
    {
        $coordenadoria_id = MainModel::decryption($post['id']);
        unset($post['id']);
        unset ($post['_method']);
        $dados = MainModel::limpaPost($post);
        $update = DbModel::update('coordenadorias', $dados, $coordenadoria_id, false);
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
        $apaga = DbModel::apaga("coordenadorias", $id, false);
        if ($apaga){
                $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Coordenadoria Deletada!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'formacao/coordenadoria_lista'
                ];
        }else {
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
        return parent::getProgramas();
    }

    public function listaVerbas()
    {
        return parent::getVerbas();
    }


    public function recuperaPrograma($programa_id) {
        $programa_id = MainModel::decryption($programa_id);
        return DbModel::getInfo('programas', $programa_id, false)->fetchObject();
    }

    public function inserePrograma($post){
        unset($post['_method']);
        $dados = MainModel::limpaPost($post);
        $insert = DbModel::insert('programas', $dados, false);
        if ($insert->rowCount() >= 1) {
            $programa_id = DbModel::connection(true)->lastInsertId();
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
        $update = DbModel::update('programas', $dados, $programa_id, false);
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
        $apaga = DbModel::apaga("programas", $id, false);
        if ($apaga){
                $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Programa Deletado!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'formacao/programa_lista'
                ];
        }else {
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
        return parent::getLinguagens();
    }

    public function recuperaLinguagem($linguagem_id) {
        $linguagem_id = MainModel::decryption($linguagem_id);
        return DbModel::getInfo('linguagens', $linguagem_id, false)->fetchObject();
    }

    public function insereLinguagem($post){
        unset($post['_method']);
        $dados = MainModel::limpaPost($post);
        $insert = DbModel::insert('linguagens', $dados, false);
        if ($insert->rowCount() >= 1) {
            $linguagem_id = DbModel::connection(true)->lastInsertId();
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
        $update = DbModel::update('linguagens', $dados, $linguagem_id, false);
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
        $apaga = DbModel::apaga("linguagens", $id, false);
        if ($apaga){
                $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Linguagem Deletada!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'formacao/linguagem_lista'
                ];
        }else {
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
        return parent::getProjetos();
    }

    public function recuperaProjeto($projeto_id) {
        $projeto_id = MainModel::decryption($projeto_id);
        return DbModel::getInfo('projetos', $projeto_id, false)->fetchObject();
    }

    public function insereProjeto($post){
        unset($post['_method']);
        $dados = MainModel::limpaPost($post);
        $insert = DbModel::insert('projetos', $dados, false);
        if ($insert->rowCount() >= 1) {
            $projeto_id = DbModel::connection(true)->lastInsertId();
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
        $update = DbModel::update('projetos', $dados, $projeto_id, false);
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
        $apaga = DbModel::apaga("projetos", $id, false);
        if ($apaga){
                $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Projeto Deletado!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'formacao/projeto_lista'
                ];
        }else {
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
        return parent::getSubprefeituras();
    }

    public function recuperaSubprefeitura($subprefeitura_id) {
        $subprefeitura_id = MainModel::decryption($subprefeitura_id);
        return DbModel::getInfo('subprefeituras', $subprefeitura_id, false)->fetchObject();
    }

    public function insereSubprefeitura($post){
        unset($post['_method']);
        $dados = MainModel::limpaPost($post);
        $insert = DbModel::insert('subprefeituras', $dados, false);
        if ($insert->rowCount() >= 1) {
            $subprefeitura_id = DbModel::connection(true)->lastInsertId();
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
        $update = DbModel::update('subprefeituras', $dados, $subprefeitura_id, false);
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
        $apaga = DbModel::apaga("subprefeituras", $id, false);
        if ($apaga){
                $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Subprefeitura Deletada!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'formacao/subprefeitura_lista'
                ];
        }else {
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
        return parent::getTerritorios();
    }
    
    public function recuperaTerritorio($territorio_id) {
        $territorio_id = MainModel::decryption($territorio_id);
        return DbModel::getInfo('territorios', $territorio_id, false)->fetchObject();
    }

    public function insereTerritorio($post){
        unset($post['_method']);
        $dados = MainModel::limpaPost($post);
        $insert = DbModel::insert('territorios', $dados, false);
        if ($insert->rowCount() >= 1) {
            $territorio_id = DbModel::connection(true)->lastInsertId();
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
        $update = DbModel::update('territorios', $dados, $territorio_id, false);
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
        $apaga = DbModel::apaga("territorios", $id, false);
        if ($apaga){
                $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Território Deletado!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'formacao/territorio_lista'
                ];
        }else {
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
        return parent::getVigencias();
    }

    public function recuperaParcelasVigencias($id_parcela_vigencia) {
        $parcela_id = MainModel::decryption($id_parcela_vigencia)??"";
        return DbModel::consultaSimples("SELECT * FROM formacao_parcelas where formacao_vigencia_id = $parcela_id")->fetchAll(PDO::FETCH_OBJ);
    }

    public function recuperaVigencia($vigencia_id) {
        $vigencia_id = MainModel::decryption($vigencia_id);
        return DbModel::getInfo('formacao_vigencias', $vigencia_id, false)->fetchObject();
    }

    public function insereVigencia($post){
        unset($post['_method']);
        $arrayVigencia = [
            'ano' => $post['ano'],
            'numero_parcelas' => $post['quantidade_parcelas'],
            'descricao' => $post['descricao']
        ];
        $dados = MainModel::limpaPost($arrayVigencia);
        $insert = DbModel::insert('formacao_vigencias', $dados, false);
        if ($insert->rowCount() >= 1) {
            $vigencia_id = DbModel::connection(true)->lastInsertId();
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

    // public function insereParcelaVigencia($post){
    //     unset($post['_method']);
    //     $dados = MainModel::limpaPost($post);
    //     insert = DbModel::insert('formacao_parcelas', $dados, false);
    //     if ($insert->rowCount() >= 1) {
    //         $parcela_id = DbModel::connection(true)->lastInsertId();
    //         $alerta = [
    //             'alerta' => 'sucesso',
    //             'titulo' => 'Parcelas Cadastradas!',
    //             'texto' => 'Dados cadastrados com sucesso!',
    //             'tipo' => 'success',
    //             'location' => SERVERURL . 'formacao/vigencia_cadastro&id=' . MainModel::encryption($parcela_id)
    //         ];
    //     } else {
    //         $alerta = [
    //             'alerta' => 'simples',
    //             'titulo' => 'Oops! Algo deu Errado!',
    //             'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
    //             'tipo' => 'error',
    //         ];
    //     }
    //     return MainModel::sweetAlert($alerta);
    // }
    
//    public function editaVigencia($post)
//    {
//        $vigencia_id = MainModel::decryption($post['id']);
//        unset($post['id']);
//        unset ($post['_method']);
//        $dados = MainModel::limpaPost($post);
//        $arrayVigencia = [
//            'ano' => $post['ano'],
//            'numero_parcelas' => $post['numero_parcelas'],
//            'descricao' => $post['descricao']
//            ];
//        $update = DbModel::update('formacao_vigencias', $dados, $vigencia_id, false);
//        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
//            $alerta = [
//                'alerta' => 'sucesso',
//                'titulo' => 'Vigência Atualizada!',
//                'texto' => 'Dados atualizados com sucesso!',
//                'tipo' => 'success',
//                'location' => SERVERURL . 'formacao/vigencia_cadastro&id=' . MainModel::encryption($vigencia_id)
//            ];
//        } else {
//            $alerta = [
//                'alerta' => 'simples',
//                'titulo' => 'Oops! Algo deu Errado!',
//                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
//                'tipo' => 'error',
//            ];
//        }
//        return MainModel::sweetAlert($alerta);
//    }

    public function editaParcelaVigencia($post)
    {
        unset($post['_method']);
        $vigencia_id = MainModel::decryption($post['id']);
        unset($post['parcela_id']);

        $arrayVigencia = [
            'ano' => $post['ano'],
            'numero_parcelas' => $post['quantidade_parcelas'],
            'descricao' => $post['descricao']
            ];

        $update = DbModel::update('formacao_vigencias', $arrayVigencia, $vigencia_id);

        $parcelas = DbModel::consultaSimples("SELECT * FROM formacao_parcelas WHERE formacao_vigencia_id = '$vigencia_id' AND publicado = 1")->fetchAll(PDO::FETCH_ASSOC);
        if (count($parcelas) > 0) {
            DbModel::consultaSimples("DELETE FROM formacao_parcelas WHERE formacao_vigencia_id = '$vigencia_id'");
        }

        for ($i = 0; $i < count($post['numero_parcelas']); $i++):
                $array = [
                    'formacao_vigencia_id' => $vigencia_id,
                    'numero_parcelas' => $i,
                    'valor' => $post['valor'][$i],
                    'data_inicio' => $post['data_inicio'][$i],
                    'data_fim' => $post['data_fim'][$i],
                    'data_pagamento' => $post['data_pagamento'][$i],
                    'carga_horaria' => $post['carga'][$i],
                    'publicado' => '1',
                ];
                $insert = DbModel::insert('formacao_parcelas', $array);
        endfor;

        if(DbModel::connection()->errorCode() == 0){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Parcelas Atualizadas!',
                'texto' => 'Parcelas atualizadas com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/vigencia_cadastro&id=' . MainModel::encryption($vigencia_id)
            ];
        }else{
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
        $apaga = DbModel::apaga("formacao_vigencias", $id, false);
        if ($apaga){
                $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Vigência Deletada!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'formacao/vigencia_lista'
                ];
        }else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao apagar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function listaPedidos()
    {
        return parent::getPedidos();
    }

    public function retornaLocaisFormacao($contratacao_id, $obj = NULL)
    {
        return parent::getLocaisFormacao($contratacao_id, $obj);
    }

    public function retornaValorTotalVigencia($contratacao_id)
    {
        return parent::getValorTotalVigencia($contratacao_id);
    }

    public function recuperaPedido($pedido_id)
    {
        $pedido_id = MainModel::decryption($pedido_id);
        return DbModel::consultaSimples("SELECT origem_id, valor_total, data_kit_pagamento, numero_processo, numero_parcelas, valor_total,numero_processo_mae, forma_pagamento, justificativa, observacao, verba_id FROM pedidos
                                                  WHERE id = $pedido_id AND publicado = 1 AND origem_tipo_id = 2")->fetchObject();
    }

    public function recuperaContratacao($contratacao_id)
    {
        $contratacao_id = MainModel::decryption($contratacao_id);
        return DbModel::consultaSimples("SELECT fc.ano, fc.chamado, ci.classificacao_indicativa, t.territorio, cord.coordenadoria, s.subprefeitura, 
                                                         pro.programa, l.linguagem, pj.projeto, c.cargo, v.id AS 'idVigencia',v.ano AS 'vigencia', v.descricao, v.numero_parcelas,
		                                                 fc.observacao, fiscal.nome_completo AS 'fiscal', suplente.nome_completo AS 'suplente', pf.nome
                                                  FROM formacao_contratacoes AS fc
                                                  INNER JOIN classificacao_indicativas AS ci ON ci.id = fc.classificacao
                                                  INNER JOIN territorios AS t ON t.id = fc.territorio_id
                                                  INNER JOIN coordenadorias AS cord ON cord.id = fc.coordenadoria_id
                                                  INNER JOIN subprefeituras AS s ON s.id = fc.subprefeitura_id
                                                  INNER JOIN programas AS pro ON pro.id = fc.programa_id
                                                  INNER JOIN pessoa_fisicas AS pf ON fc.pessoa_fisica_id = pf.id
                                                  INNER JOIN linguagens AS l ON l.id = fc.linguagem_id
                                                  INNER JOIN projetos AS pj ON pj.id = fc.projeto_id
                                                  INNER JOIN formacao_cargos AS c ON c.id = fc.form_cargo_id
                                                  INNER JOIN formacao_vigencias AS v ON v.id = fc.form_vigencia_id
                                                  INNER JOIN usuarios AS fiscal ON fiscal.id = fc.fiscal_id
                                                  LEFT JOIN usuarios AS suplente ON suplente.id = fc.suplente_id
                                                  WHERE fc.id = $contratacao_id AND fc.publicado = 1")->fetchObject();
    }


    public function cadastrarPedido($post)
    {
        unset($post['_method']);

        $dados = MainModel::limpaPost($post);

        $insert = DbModel::insert('pedidos', $dados);
        if ($insert->rowCount() >= 1) {
            $pedido_id = DbModel::connection()->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pedido Cadastrado',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/pedido_contratacao_cadastro&id=' . MainModel::encryption($pedido_id)
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
        $contratacao_id = MainModel::decryption($post['contratacao_id']);
        unset($post['_method']);
        unset($post['id']);
        unset($post['contratacao_id']);

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

        unset($post['local_id']);
        $dados = MainModel::limpaPost($post);
        $update = DbModel::update('pedidos', $dados, $pedido_id);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pedido Atualizado',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/pedido_contratacao_cadastro&id=' . MainModel::encryption($pedido_id)
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
        if($delete->rowCount() >= 1 || DbModel::connection()->errorCode() == 0){
            $alerta = [
              'alerta' => 'sucesso',
              'titulo' => 'Pedido Apagado!',
              'texto' => 'Pedido apagado com sucesso!',
              'tipo' => 'success',
              'location' => SERVERURL . 'formacao/pedido_contratacao_lista'
            ];
        }else{
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu errado!',
                'texto' => 'Falha ao salvar os dados no servidos, tente novamente mais tarde',
                'tipo' => 'error'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function recuperaParcelasPedido($pedido_id){
        return PedidoController::getParcelasPedido($pedido_id);
    }

    public function editarParcela($post){
        unset($post['_method']);
        $pedido_id = MainModel::decryption($post['pedido_id']);
        unset($post['pedido_id']);
        $parcelas = DbModel::consultaSimples("SELECT * FROM parcelas WHERE pedido_id = $pedido_id AND publicado = 1")->fetchAll(PDO::FETCH_ASSOC);
        if (count($parcelas) > 0) {
            foreach ($parcelas as $parcela) {
                DbModel::consultaSimples("UPDATE parcelas SET publicado = 0 WHERE pedido_id = $pedido_id AND numero_parcelas = " . $parcela['numero_parcelas']);
            }
        }

        for ($i = 0; $i < count($post['numero_parcelas']); $i++):
                $array = [
                    'pedido_id' => $pedido_id,
                    'numero_parcelas' => $i,
                    'valor' => $post['valor'][$i],
                    'data_pagamento' => $post['data_pagamento'][$i],
                    'publicado' => '1',
                ];
                $insert = DbModel::insert('parcelas', $array);
        endfor;
        if(DbModel::connection()->errorCode() == 0){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Parcelas Atualizadas!',
                'texto' => 'Parcelas atualizadas com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/pedido_edita_parcelas&id=' . MainModel::encryption($pedido_id)
            ];
        }else{
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function retornaNotaEmpenho($pedido_id){
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

    public function pesquisasPagamento($post, $where)
    {
        $sqlProtocolo = "";
        $sqlProponente = "";
        $sqlProcesso = "";

        if ($where == "protocolo") {
            $protocolo = $post;
            $sqlProtocolo = " AND fc.protocolo LIKE '%$protocolo%'";
        }

        if ($where == "proponente") {
            $proponente = $post;
            $sqlProponente = " AND p.pessoa_fisica_id = '$proponente'";
        }
        if ($where == "processo"){
            $processo = $post;
            $sqlProcesso = " AND p.numero_processo LIKE '%$processo%'";
        }


        $consulta = DbModel::consultaSimples("SELECT fc.id, p.id AS pedido_id, fc.protocolo, pf.nome, p.numero_processo 
                                                  FROM formacao_contratacoes fc 
                                                  INNER JOIN pedidos p ON fc.id = p.origem_id
                                                  LEFT JOIN pessoa_fisicas pf ON p.pessoa_fisica_id = pf.id
                                                  WHERE p.origem_tipo_id = 2 AND fc.publicado = 1 $sqlProponente $sqlProcesso $sqlProtocolo")->fetchAll(PDO::FETCH_ASSOC);
        if (count($consulta) > 0) {
            for ($i = 0; $i < count($consulta); $i++) {
                $consulta[$i]['id'] = MainModel::encryption($consulta[$i]['id']);
                $consulta[$i]['pedido_id'] = MainModel::encryption($consulta[$i]['pedido_id']);
            }
            return json_encode(array($consulta));
        }

        return '0';
    }


    public function listaDadosContratacao()
    {
        return parent::getDadosContratacao();
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
                                        WHERE f.id = $contratacao_id 'AND f.publicado = 1'")->fetchObject();
    }

    public function listaPF()
    {
        return parent::getPF();
    }

}