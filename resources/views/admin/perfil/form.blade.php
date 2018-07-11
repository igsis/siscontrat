@extends('layout.menu.admin')

@section('titulo')
  Cadastro de perfil
@stop()

<?php  $path = isset($perfil) ? 'perfil.atualizar' : 'perfil.salvar'; ?>   

@section('conteudo')            
  @include('admin.perfil.mensagens', ['msg' => old('descricao')])            
  
  <form action="{{route($path)}}" method="POST">        
    {{csrf_field()}}
    
    <input type="hidden" name="id" value="{{isset($perfil) ? $perfil->id : ''}}">

    <div class="form-group">
      <label for="descrica">Descricao</label> 
      
      <input type="text" name="descricao" class="form-control" 
             minlength="3" maxlength="30"    
             placeholder="Informe uma descrição para o perfil do usuário" id="descricao" required
             value="{{isset($perfil) ? $perfil->descricao : ''}}">
    </div>
    <button type="submit" class="btn btn-primary">Salvar</button>
  </form>    
  <script type="text/javascript" src="/js/validacoes/admin/perfil.js"></script>  
@stop()