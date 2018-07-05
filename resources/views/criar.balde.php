@extends(layout.menu.admin)

@section('title')
  Cadastro do perfil do usuário
@stop()

@section('conteudo')
  <form>
    <div class="form-group">
      <label></label>	
      <input type="text" name="descricao" class="form-control" 
      minlength="3" maxlength="30" placeholder="Informe um nome de perfil para o usuário">
    </div>
    <button type="submit">Enviar</button>
  </form>
@stop()