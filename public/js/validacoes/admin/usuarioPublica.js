var tabela = document.getElementById('tb_usuarios');
  tabela.addEventListener('dblclick', function(event){                
          
    getPublicado() == "Sim"
      ? msg = confirm("Deseja despublicar o usuário?")
      : msg = confirm("Deseja publicar o usuário?"); 

    alteraStatus(msg);             
  });     

  function alteraStatus(msg){
    if(msg){
      var form = document.getElementById('frm_usuario_delete');
            
      var input = document.getElementById('user');            
          input.setAttribute('value', getUsuario());                        
      
      var input_public = document.getElementById('user_pub');
          input_public.setAttribute('value', getPublicado());  

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