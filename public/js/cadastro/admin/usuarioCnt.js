getUsuarios().forEach(function(usuario){
  var usuarioCont = usuario.querySelector('#contrato');
      
  usuarioCont.addEventListener('click', function(event){        
    gravaUsuarioContratos(usuario);  
  });
});  

function gravaUsuarioContratos(usuario)
{
  var form = document.getElementById('frm_index_usuario');
      form.action = "/usuarioCnt/salvar";

  var inputUsuario = document.createElement('input');
      inputUsuario.setAttribute('type', 'hidden');
      inputUsuario.setAttribute('name', 'usuario_id');
      inputUsuario.setAttribute('value', setUsuario(usuario));    

  var inputAcesso = document.createElement('input');
      inputAcesso.setAttribute('type', 'hidden');
      inputAcesso.setAttribute('name', 'nivel_acesso');
      inputAcesso.setAttribute('value', setNivelAcesso(usuario));

      form.appendChild(inputUsuario);      
      form.appendChild(inputAcesso);          
      form.submit();
} 
    
function setNivelAcesso(usuario)
{
  var nivel_acesso = usuario.querySelector('#nivel').textContent;
  return nivel_acesso == 1 ? 0 : 1;         
}

function setUsuario(usuario)
{
  var user = usuario.querySelector('#id').textContent;          
  return user;
}

function getUsuarios()
{
  var usuarios = document.querySelectorAll('.usuarios');
  return usuarios;
}