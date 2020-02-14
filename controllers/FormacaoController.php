<?php
if ($pedidoAjax) {
    require_once "../models/ValidacaoModel.php";
    require_once "../controllers/PessoaFisicaController.php";
} else {
    require_once "./models/ValidacaoModel.php";
    require_once "./controllers/PessoaFisicaController.php";
}

class FormacaoController extends ValidacaoModel
{
    public function insereFormacao()
    {
        /* executa limpeza nos campos */
        $dados = [];
        $pagina = $_POST['pagina'];
        unset($_POST['_method']);
        unset($_POST['pagina']);
        $pessoa_fisica_id = MainModel::decryption($_SESSION['origem_id_s']);
        $dados['pessoa_fisica_id'] = $pessoa_fisica_id;
        foreach ($_POST as $campo => $post) {
            $dados[$campo] = MainModel::limparString($post);
        }
        /* ./limpeza */
        DbModel::insert("form_cadastros",$dados);
        if (DbModel::connection()->errorCode() == 0) {
            $id = DbModel::connection()->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Detalhes do programa',
                'texto' => 'Cadastro realizado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . $pagina . '&idC=' . MainModel::encryption($id)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . $pagina
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function editaFormacao($id)
    {
        /* executa limpeza nos campos */
        $idDecrypt = MainModel::decryption($id);
        $dados = [];
        $pagina = $_POST['pagina'];
        unset($_POST['_method']);
        unset($_POST['pagina']);
        unset($_POST['id']);
        $dados['id'] = $idDecrypt;
        foreach ($_POST as $campo => $post) {
            $dados[$campo] = MainModel::limparString($post);
        }
        /* ./limpeza */
        DbModel::update("form_cadastros",$dados,$idDecrypt);
        if (DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Detalhes do programa',
                'texto' => 'Cadastro editado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . $pagina . '&idC=' . $id
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . $pagina . '&idC=' . $id
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function recuperaFormacao($idPf)
    {
        $idPf = MainModel::decryption($idPf);
        $formacao = DbModel::consultaSimples("
            SELECT * 
            FROM form_cadastros 
            LEFT JOIN form_regioes_preferenciais frp on form_cadastros.regiao_preferencial_id = frp.id
            LEFT JOIN form_programas fp on form_cadastros.programa_id = fp.id
            LEFT JOIN form_linguagens fl on form_cadastros.linguagem_id = fl.id
            LEFT JOIN form_projetos f on form_cadastros.projeto_id = f.id
            LEFT JOIN form_cargos fc on form_cadastros.form_cargo_id = fc.id
            WHERE pessoa_fisica_id = '$idPf'
        ");
        return $formacao;
    }

    public function validaForm($idPf){
        $idPf = MainModel::decryption($idPf);
        $formacao = ValidacaoModel::validaFormacao($idPf);
        return $formacao;
    }
}