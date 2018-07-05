<!DOCTYPE html>
<html>
  <head>
    <title>@yield('titulo')</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/css/app.css">
    <link rel="stylesheet" type="text/css" href="/css/estilo.css">
  </head>
  <body>
    <div class="container">
      <nav class="navbar navbar-default setMenuAdmin">
        <div class="container-fluid">                
          <div class="navbar-header">      
            <a class="navbar-brand" href="/">Menu</a>
          </div>          
          <ul class="nav navbar-nav">
            <li class="dropdown dropdown-submenu"><a href="#" 
                class="dropdown-toggle" 
                data-toggle="dropdown">Usuário</a>
              <ul class="dropdown-menu">
                <li><a href="#">Perfil</a></li>
                <li><a href="{{action('UsuarioController@criar')}}">Novo</a></li>                
              </ul>
            </li>             
          </ul>
          <ul class="nav navbar-nav">
            <li><a href="#">Lista</a>
            </li>
          </ul>
          <ul class="nav navbar-nav ">
            <li><a href="#">Novo</a></li>
          </ul>           
        </div>
        
      </nav>
      @yield('conteudo')	
    </div>
  </body>
</html>