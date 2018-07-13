@if(old('checkUser'))
  <div class="alert alert-warning">
    <p>O usuário <b>{{old('usuario')}}</b> já possui cadastro.</p>  
  </div>  
@endif  