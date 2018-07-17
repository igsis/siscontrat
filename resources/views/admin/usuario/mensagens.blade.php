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

  @case (isset($recordSuccess))
    <div class="alert alert-success">
      <p>O usuário cadastro com sucesso!</p>  
    </div>   
  @break
@endswitch


  