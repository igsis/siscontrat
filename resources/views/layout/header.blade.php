<!DOCTYPE html>
<html>
  <head>
    <title>@yield('titulo')</title>
    <meta charset="utf-8">
    
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" 
          href="{{asset('css/app.css')}}">        

    <link rel="stylesheet" type="text/css" 
          href="{{asset('css/bootstrap.css')}}">                         

    <link rel="stylesheet" type="text/css" 
          href="{{asset('css/estilo.css')}}">  
  </head>
  <body>
    <div class="container">
      @yield('menu')	
    </div>
  </body>
</html>    


