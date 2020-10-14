<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class FormacaoModel extends MainModel
{

    protected function getDocumento($documento,$tipo_doc){
        if($tipo_doc == 'cpf'){
            $consulta = DbModel::consultaSimples("SELECT id, nome, cpf as 'documento', email FROM pessoa_fisicas WHERE cpf LIKE '%$documento%'")->fetchAll(PDO::FETCH_ASSOC);
        }else if($tipo_doc == 'passaporte'){
            $consulta = DbModel::consultaSimples("SELECT id, nome, passaporte as 'documento', email FROM pessoa_fisicas WHERE passaporte LIKE '%$documento%'")->fetchAll(PDO::FETCH_ASSOC);
        }

        if (count($consulta) > 0) {
            for ($i = 0; $i < count($consulta); $i++) {
                $consulta[$i]['id'] = MainModel::encryption($consulta[$i]['id']);
            }
            return json_encode(array($consulta));
        }
        return 0;
        
    }

    protected function getPF()
    {
        return DbModel::consultaSimples("SELECT * FROM pessoa_fisicas")->fetchAll(PDO::FETCH_OBJ);
    }

    protected function getRegiaoPreferencial()
    {
        return DbModel::consultaSimples("SELECT * FROM regiao_preferencias")->fetchAll(PDO::FETCH_OBJ);
    }

}

