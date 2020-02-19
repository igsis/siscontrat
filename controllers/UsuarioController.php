<?php

if ($pedidoAjax) {
    require_once "../models/UsuarioModel.php";
} else {
    require_once "./models/UsuarioModel.php";
}

class UsuarioController extends UsuarioModel
{

    public function iniciaSessao($modulo = false, $edital = null) {
        $email = MainModel::limparString($_POST['email']);
        $senha = MainModel::limparString($_POST['senha']);
        $senha = MainModel::encryption($senha);

        $dadosLogin = [
            'email' => $email,
            'senha' => $senha
        ];

        $consultaEmail = UsuarioModel::getEmail($dadosLogin);

        if ($consultaEmail->rowCount() == 1){
            $consultaUsuario = UsuarioModel::getUsuario($dadosLogin);

            if ($consultaUsuario->rowCount() == 1) {
                $usuario = $consultaUsuario->fetch();

                session_start(['name' => 'sis']);
                $_SESSION['usuario_id_s'] = $usuario['id'];
                $_SESSION['nome_s'] = $usuario['nome'];

                MainModel::gravarLog('Fez Login');

                if (!$modulo) {
                    return $urlLocation = "<script> window.location='inicio/inicio' </script>";
                } else {
                    if ($modulo == 8) {
                        $_SESSION['edital_s'] = $edital;
                        return $urlLocation = "<script> window.location='fomentos/inicio&modulo=$modulo' </script>";
                    }
                }
            } else {
                $alerta = [
                    'alerta' => 'simples',
                    'titulo' => 'Erro!',
                    'texto' => 'Usuário / Senha incorreto',
                    'tipo' => 'error'
                ];
            }
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Usuário não existe',
                'tipo' => 'error'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function forcarFimSessao() {
        session_destroy();
        return header("Location: ".SERVERURL);
    }

    public function insereUsuario() {
        $erro = false;
        $dados = [];
        $camposIgnorados = ["senha2", "_method", "instituicao", "local"];
        foreach ($_POST as $campo => $post) {
            if (!in_array($campo, $camposIgnorados)) {
                $dados[$campo] = MainModel::limparString($post);
            }
        }

        $perfil_id = parent::getPerfil($dados['perfil']);
        unset($dados['perfil']);

        if ($perfil_id) {
            $dados['perfil_id'] = $perfil_id;
        } else {
            $erro = true;
            $alerta = [
                'alerta' => 'simples',
                'titulo' => "Erro!",
                'texto' => "Código informado não existe no sistema",
                'tipo' => "error"
            ];
        }

        // Valida Senha
        if ($_POST['senha'] != $_POST['senha2']) {
            $erro = true;
            $alerta = [
                'alerta' => 'simples',
                'titulo' => "Erro!",
                'texto' => "As senhas inseridas não conferem. Tente novamente",
                'tipo' => "error"
            ];
        }

        // Valida email unique
        $consultaEmail = DbModel::consultaSimples("SELECT email FROM usuarios WHERE email = '{$dados['email']}'");
        if ($consultaEmail->rowCount() >= 1) {
            $erro = true;
            $alerta = [
                'alerta' => 'simples',
                'titulo' => "Erro!",
                'texto' => "Email inserido já cadastrado. Tente novamente.",
                'tipo' => "error"
            ];
        }

        if (!$erro) {
            $dados['senha'] = MainModel::encryption($dados['senha']);
            $insereUsuario = DbModel::insert('usuarios', $dados);
            if ($insereUsuario) {
                $usuario_id = DbModel::connection()->lastInsertId();
                $dadosLocal = [
                    'local_id' => $_POST['local'],
                    'usuario_id' => $usuario_id
                ];
                $insereLocalUsuario = DbModel::insert('local_usuarios', $dadosLocal);
                if ($insereLocalUsuario) {
                    $alerta = [
                        'alerta' => 'sucesso',
                        'titulo' => 'Usuário Cadastrado!',
                        'texto' => 'Usuário cadastrado com Sucesso!',
                        'tipo' => 'success',
                        'location' => SERVERURL
                    ];
                } else {
                    DbModel::deleteEspecial('usuarios', 'id', $usuario_id);
                    $alerta = [
                        'alerta' => 'simples',
                        'titulo' => "Erro!",
                        'texto' => "Erro ao inserir os dados no sistema. Tente novamente",
                        'tipo' => "error"
                    ];
                }
            }
        }
        return MainModel::sweetAlert($alerta);
    }

    /* edita */
    public function editaUsuario($dados, $id){
        unset($dados['_method']);
        unset($dados['id']);
        $dados = MainModel::limpaPost($dados);
        $edita = DbModel::update('usuarios', $dados, $id);
        if ($edita) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Usuário',
                'texto' => 'Informações alteradas com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'inicio/edita'
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.'inicio/edita'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function trocaSenha($dados,$id){
        // Valida Senha
        if ($_POST['senha'] != $_POST['senha2']) {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => "Erro!",
                'texto' => "As senhas inseridas não conferem. Tente novamente",
                'tipo' => "error"
            ];
        }
        else{
            unset($dados['_method']);
            unset($dados['id']);
            unset($dados['senha2']);
            $dados = MainModel::limpaPost($dados);
            $dados['senha'] = MainModel::encryption($dados['senha']);
            $edita = DbModel::update('usuarios', $dados, $id);
            if ($edita) {
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Usuário',
                    'texto' => 'Senha alterada com sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL.'inicio/edita'
                ];
            }
            else{
                $alerta = [
                    'alerta' => 'simples',
                    'titulo' => 'Erro!',
                    'texto' => 'Erro ao salvar!',
                    'tipo' => 'error',
                    'location' => SERVERURL.'inicio/edita'
                ];
            }
        }
        return MainModel::sweetAlert($alerta);
    }

    public function recuperaUsuario($id) {
        return DbModel::getInfo('usuarios',$id);
    }
}
