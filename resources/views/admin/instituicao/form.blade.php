@extends('layout.menu.admin')

@section('titulo')
  Cadastro de Instituição
@stop()

<?php $path = isset($instituicao) ? 'instituicao.atualizar' 
                                  : 'instituicao.salvar'; ?>

@section('conteudo')
  @include('../validacoes.msgErro')   
  @include('admin.instituicao.mensagens')  
  <form action="{{route($path)}}" method="POST">
    {{csrf_field()}}    

    <div class="form-group">
      <label for="nome">Nome</label>
      <input type="text" name="nome" class="form-control"
             minlength="3" maxlength="60" required 
             placeholder="Informe um nome para a Instituição" 
             id="nome"
             value="{{isset($instituicao) ? $instituicao->nome 
                                          : old('nome')}}">
    </div>
    <div class="form-group">
      <label for="sigla">Sigla</label>
      <input type="text" name="sigla" class="form-control"
             minlength="3" maxlength="8" required 
             placeholder="Informe uma sigla para a Instituição" 
             id="sigla"
             value="{{isset($instituicao) ? $instituicao->sigla 
                                          : old('sigla')}}">
    </div>
    <button type="submit" class="btn btn-primary">Salvar</button>
  </form>
  <script type="text/javascript" 
          src="{{asset('js/validacoes/admin/instituicao.js')}}">
  </script>  
  
@stop()
