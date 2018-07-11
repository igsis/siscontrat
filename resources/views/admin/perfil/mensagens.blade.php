@if(sizeOf($errors) > 0)
  <div class="alert alert-danger">
    <ul>
      @foreach($errors->all() as $erro)
        <li>{{$erro}}</li>     
      @endforeach        
    </ul>  
  </div>  
@else
  @if(old('id'))
    <div class="alert alert-success">
      <p>O perfil <b>{{old('descricao')}}</b> foi atualizado com sucesso.</p>  
    </div>
  @elseif(old('descricao'))
    <div class="alert alert-success">
      <p>O perfil <b>{{old('descricao')}}</b> foi criado com sucesso.</p>  
    </div>
  @endif    
@endif  