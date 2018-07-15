@if(old('verificaUsuario'))
  <div class="alert alert-danger">
    <p>O usuário <b>{{old('usuario')}}</b> já possui cadastro.</p>  
  </div>  
@endif  

@if(old('verificaEmail'))
  <div class="alert alert-danger">
    <p>O email <b>{{old('email')}}</b> já possui cadastro.</p>  
  </div>  
@endif  