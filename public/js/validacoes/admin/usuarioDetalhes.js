getUsuarios().forEach(function(usuario){            
  usuario.addEventListener('click', function(){                
        
    var id = usuario.querySelector('#id');        
    var nome_completo = usuario.querySelector('#nome_completo');
    var telefone = usuario.querySelector('#telefone');
    var perfil = usuario.querySelector('#perfil');
    var dt_cadastro = usuario.querySelector('#dt_cadastro');
    var dt_acesso = usuario.querySelector('#dt_acesso');        
        
    $('#detalhes').on('show.bs.modal', function(e){   
      $('input[name=id]').val(id.textContent);
      $('input[name=nome_completo]').val(nome_completo.textContent);
      $('input[name=telefone]').val(telefone.textContent);
      $('input[name=perfil]').val(perfil.textContent);
      $('input[name=dt_cadastro]').val(dt_cadastro.textContent);
      $('input[name=dt_acesso]').val(dt_acesso.textContent);
    });  
  });
}); 

function getUsuarios()
{
  var usuarios = document.querySelectorAll('.usuarios');
  return usuarios;
}  
    