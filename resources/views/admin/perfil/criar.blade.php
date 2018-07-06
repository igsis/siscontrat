@extends('layout.menu.admin')

@section('titulo')
  Cadastro de perfil
@stop()

@section('conteudo')  
  <form action="{!!route('perfil.salvar')!!}" method="POST">        
    {{csrf_field()}}
    <div class="form-group">
      <label for="descrica">Descricao</label> 
      <input type="text" name="descricao" class="form-control" 
             minlength="3" maxlength="30"    
             placeholder="Informe uma descrição para o perfil do usuário" id="descricao" required>
    </div>
    <button type="submit" class="btn btn-primary">Salvar</button>
  </form>    
  <script type="text/javascript" src="/js/validacoes/admin/perfil.js"></script>  
@stop()