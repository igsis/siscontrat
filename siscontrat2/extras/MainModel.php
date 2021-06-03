<?php
require_once "DbModel.php";
require_once '../../config/configAPP.php';

class MainModel extends DbModel
{
    /**
     * <p>Encripta a mensagem usando o "openssl_encrypt"</p>
     * @param string $string
     * <p>Mensagem a ser encriptada</p>
     * @return string
     * <p>Retorna o valor já encriptado</p>
     */
    public function encryption($string)
    {
        $output = false;
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 16);
        $output = openssl_encrypt($string, METHOD, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }

    /**
     * <p>Decripta uma mensagem encriptada com a função "encryption"</p>
     * @param string $string
     * <p>Mensagem a ser decriptada</p>
     * @return string
     * <p>Retorna a mensagem decriptada</p>
     */
    protected function decryption($string)
    {
        if (strlen($string) > 10) {
            $key = hash('sha256', SECRET_KEY);
            $iv = substr(hash('sha256', SECRET_IV), 0, 16);
            $output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
            return $output;
        }

        return $string;
    }

    //retorna sim para campos valo = 1 e não para campos valor=0
    public function simNao($campo):string
    {
        if ($campo == 1 ) {
            return "Sim";
        } else {
            return "Não";
        }
    }

    //checa se o campo do parâmetro possuí algum dado, caso não possua, ele retorna "Não cadastrado"
    public function checaCampo($campo):string
    {
        if ($campo == NULL || $campo == '') {
            return "Não cadastrado";
        } else {
            return $campo;
        }
    }

    public function validaData($data, $hora = false):string
    {
        if ($hora == true){
            if ($data == "0000-00-00 00:00:00" || $data == null){
                $retornaData = "não cadastrado";
            } else{
                $retornaData = date('d/m/Y H:i:s', strtotime($data));
            }
        } else{
            if ($data == "0000-00-00" || $data == null){
                $retornaData = "não cadastrado";
            } else{
                $retornaData = date('d/m/Y', strtotime($data));
            }
        }
        return $retornaData;
    }
}