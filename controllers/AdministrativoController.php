<?php
if ($pedidoAjax) {
    require_once "../models/AdministrativoModel.php";
} else {
    require_once "./models/AdministrativoModel.php";
}

class AdministrativoController extends AdministrativoModel
{
    public function listaMural() {
        return parent::getAvisos();
    }
    public function listaPerfil() {
        return parent::getPerfil();
    }

    public function recuperaAviso($id){
        $id = MainModel::decryption($id);
        return DbModel::getInfo('avisos', $id)->fetchObject();
    }
    public function recuperaPerfil($id){
        $id = MainModel::decryption($id);
        return DbModel::getInfo('perfis', $id)->fetchObject();
    }

    public function insereAviso($post) {
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
    public function inserePerfil($post) {
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

    public function editaAviso($post) {
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
    public function editaPerfil($post) {
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
    public function apagaPerfil($id){
        $id = MainModel::decryption($id['id']);
        $apaga = DbModel::apaga("perfis", $id);
        if ($apaga){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Perfi',
                'texto' => 'Perfil apagado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'administrativo/perfil'
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

}