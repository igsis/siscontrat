@if(sizeOf($errors) > 0)
  <div class="alert alert-danger">
    <ul>
      @foreach($errors->all() as $erro)
        <li>{{$erro}}</li>     
      @endforeach        
    </ul>  
  </div>  
@elseIf(old('checkUser'))
  <div class="alert alert-danger">
    <p>O usuário <b>{{old('usuario')}}</b> já possui cadastro.</p>  
  </div>  
@endif  