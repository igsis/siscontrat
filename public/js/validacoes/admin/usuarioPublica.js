var tabela = document.getElementById('tb_usuarios');
  tabela.addEventListener('dblclick', function(event){                
          
    getPublicado() == "Sim"
      ? msg = confirm("Deseja despublicar o usuário?")
      : msg = confirm("Deseja publicar o usuário?"); 

    alteraStatus(msg);             
  });     

  function alteraStatus(msg){
    if(msg){
      var form = document.getElementById('frm_index_usuario');
          form.action = "/usuario/delete";

      var inputUsuario = document.createElement('input');
          inputUsuario.setAttribute('type', 'hidden');
          inputUsuario.setAttribute('name', 'usuario');
          inputUsuario.setAttribute('value', getUsuario());    

      var inputPublicado = document.createElement('input');
          inputPublicado.setAttribute('type', 'hidden');
          inputPublicado.setAttribute('name', 'publicado');
          inputPublicado.setAttribute('value', getPublicado()); 

      form.appendChild(inputUsuario);
      form.appendChild(inputPublicado);
      form.submit();        
    }
  }  
      
  function getUsuario(){
    var usuario = 
      event.target.parentNode.querySelector('#usuario').textContent;  
         
    return usuario;  
  }

  function getPublicado(){
    var publicado = 
      event.target.parentNode.querySelector('#publicado').textContent;
          
    return publicado;    
  }