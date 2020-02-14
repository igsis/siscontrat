<?php
if (isset($_GET['modulo'])) {
    $_SESSION['modulo_s'] = $_GET['modulo'];
}
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Resumo das informações para preenchimento do cadastro</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <p class="card-text">
                    Inicia-se aqui um processo passo-a-passo para o preenchimento dos dados do candidato às vagas dos Editais dos Programas da Supervisão de Formação. Antes de começar, tenha disponível estas informações para que o cadastro possa ser concluído.
                </p>
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-edit"></i>
                            Dados Necessários para o Cadastro
                        </h3>
                    </div>
                    <div class="card-body">
                        <p class="text-info"><b>Informações iniciais - Pessoa Física</b></p>
                        <ul>
                            <li>Nome</li>
                            <li>Nome artístico</li>
                            <li>Tipo do documento</li>
                            <li>Nº do documento</li>
                            <li>CPF</li>
                            <li>CCM</li>
                            <li>Telefones</li>
                            <li>E-mail</li>
                            <li>Data de nascimento</li>
                            <li>PIS/PASEP/NIT</li>
                            <li>CEP</li>
                            <li>Número</li>
                            <li>Complemento</li>
                            <li>Programa</li>
                        </ul>
                        <br>

                        <p class="text-info"><b>Dados Adicionais</b></p>
                        <ul>
                            <li>Estado Civil</li>
                            <li>Nacionalidade</li>
                            <li>DRT</li>
                            <li>Etnia</li>
                            <li>Grau de Instrução</li>
                            <li>Função</li>
                            <li>Banco</li>
                            <li>Agência</li>
                            <li>Conta</li>
                        </ul>
                        <br>

                        <p class="text-info"><b>Anexos do Proponente</b></p>
                        <ul>
                            <li>RG/RNE/PASSAPORTE</li>
                            <li>CPF</li>
                            <li>PIS/PASEP/NIT</li>
                            <li>Comprovante de Residência</li>
                        </ul>
                        <br>

                        <p class="text-info"><b>Demais Anexos</b></p>
                        <ul>
                            <li>Anexos de III a V</li>
                            <li>Currículo</li>
                            <li>Comprovante de Formação <strong>(Até 4)</strong></li>
                            <li>Comprovante de Experiência Artística <strong>(Até 4)</strong></li>
                            <li>Comprovante de Experiência Artístico-pedagógica <strong>(Até 4)</strong></li>
                            <li>Comprovante de Experiência em Coordenação/Articulação <strong>*(Para algumas funções)* (Até 4)</strong></li>
                        </ul>
                        <br>

                        <p class="text-info"><b>Finalizar</b></p>
                        <ul>
                            <li>Nesta tela haverá um resumo com todas as informações inseridas neste evento</li>
                            <li>Listará também, quando existirem, os campos pendente para preenchimento</li>
                        </ul>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <div class="offset-md-4 col-md-4">
                            <a href="<?= SERVERURL ?>formacao/proponente"><button class="btn btn-block btn-success">Clique aqui para começar</button></a>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
