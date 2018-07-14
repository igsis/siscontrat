@if(sizeOf($errors) > 0)
  <div class="alert alert-danger">
    <ul>
      @foreach($errors->all() as $erro)
        <li>{{$erro}}</li>     
      @endforeach        
    </ul>  
  </div>  
@endif  