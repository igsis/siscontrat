@extends('layout.menu.admin')

@section('titulo')
  Cadastro de perfil
@stop()

<?php  
  $path = isset($perfil) ? 'perfil.atualizar' : 'perfil.salvar'; ?>

@section('conteudo')
  @include('admin.perfil.mensagens')
  @include('../validacoes.msgErro')
  <form action="{{route($path)}}" method="POST">
    {{csrf_field()}}

    <input type="hidden" name="id" value="{{isset($perfil) ? $perfil->id : ''}}">

    <div class="form-group">
      <label for="descrica">Descricao</label>

      <input type="text" name="descricao" class="form-control"
             minlength="3" maxlength="35" required 
             placeholder="Informe uma descrição para o perfil do usuário" id="descricao" 
             value="{{isset($perfil) ? $perfil->descricao 
                                     : old('descricao')}}">
    </div>
    <button type="submit" class="btn btn-primary">Salvar</button>
  </form>
  <script type="text/javascript" 
          src="{{asset('js/validacoes/admin/perfil.js')}}">
  </script>  
  
@stop()
