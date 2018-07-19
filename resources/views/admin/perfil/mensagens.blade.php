@if(old('id'))
  <div class="alert alert-success">
    <p>O perfil <b>{{old('descricao')}}</b> foi atualizado 
       com sucesso.</p>  
  </div>
@elseif(old('descricao'))
  <div class="alert alert-success">
    <p>O perfil <b>{{old('descricao')}}</b> foi criado com sucesso.
    </p>  
  </div>
@endif    

