getUsuarios().forEach(function(usuario){
  var usuarioFinac = usuario.querySelector('#pagamento');
      
  usuarioFinac.addEventListener('click', function(event){        
    gravaUsuarioPagamento(usuario);  
  });
});  

function gravaUsuarioPagamento(usuario)
{
  var form = document.getElementById('frm_index_usuario');
      form.action = "/usuarioPgto/salvar";

  var inputUsuario = document.createElement('input');
      inputUsuario.setAttribute('type', 'hidden');
      inputUsuario.setAttribute('name', 'usuario_id');
      inputUsuario.setAttribute('value', setUsuario(usuario));    

  var inputAcesso = document.createElement('input');
      inputAcesso.setAttribute('type', 'hidden');
      inputAcesso.setAttribute('name', 'nivel_acesso');
      inputAcesso.setAttribute('value', setNivelAcesso(usuario, "#nivel_p"));

      form.appendChild(inputUsuario);      
      form.appendChild(inputAcesso);          
      form.submit();
} 
    
