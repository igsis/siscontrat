var nomeUsuario = document.getElementById('nomeUsuario');
   
nomeUsuario.addEventListener('input', function(){     
  nomeUsuario.value.length > 0 ? buscaUsuario() : exibeTodos();
});  

function buscaUsuario()
{
  getUsuarios().forEach(function(usuario){
         
    var nome = usuario.querySelector('.info-nome').textContent;
    var equals = new RegExp(nomeUsuario.value, 'i');

    if(equals.test(nome))
      usuario.classList.remove('ocultar');   
    else
      usuario.classList.add('ocultar');
  });   
}   

function getUsuarios()
{
  var usuarios = document.querySelectorAll('.usuarios');
    return usuarios;
}

function exibeTodos()
{
  getUsuarios().forEach(function(usuario){
    usuario.classList.remove('ocultar');     
  });
}