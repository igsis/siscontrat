@switch(true)
  @case (old('verificaUsuario'))
    <div class="alert alert-danger">
      <p>O usuário <b>{{old('usuario')}}</b> já possui cadastro.</p>  
    </div>  
  @break

  @case (old('verificaEmail'))
    <div class="alert alert-danger">
      <p>O email <b>{{old('email')}}</b> já possui cadastro.</p>  
    </div>  
  @break

  @case (isset($msgInsert))
    <div class="alert alert-success">
      <p>Usuário cadastrado com sucesso!</p>  
    </div>   
  @break  

  @case (old('id'))
    <div class="alert alert-success">
      <p>O Usuário {{old('nome_completo')}} foi atualizado com sucesso!</p>  
    </div>   
  @break

  @case (isset($msgUpdate))
    <div class="alert alert-danger">
      <p>Já existe outro usuário com o e-mail informado!</p>  
    </div>   
  @break  
@endswitch


  