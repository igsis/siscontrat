@if(old('id'))
  <div class="alert alert-success">
    <p>A instituicao <b>{{old('nome')}}</b> foi atualizada 
       com sucesso.</p>  
  </div>
@elseif(old('nome') and sizeOf($errors) ==0)
  <div class="alert alert-success">
    <p>A instituicao <b>{{old('nome')}}</b> foi criada com sucesso.
    </p>  
  </div>
@endif    

