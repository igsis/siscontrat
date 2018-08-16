function validaUsuario(){
  event.preventDefault();       
      
  var form = setForm(getForm(), setInput());
  form.submit();    

  function setInput(){
    var input = document.createElement('input');
        input.setAttribute('type', 'hidden');
        input.setAttribute('value', '1');
        input.setAttribute('name', 'verificaUsuario');  

    return input;
  }

  function getForm(){
    var form = document.querySelector('#form');
    return form;
  }

  function setForm(form, input){
    form.appendChild(input);            
    form.action = "/usuario/novo/validar";    
    form.method = "post";     

    return form;
  }    
}

function validaEmail(){
  event.preventDefault();       
      
  var form = setForm(getForm(), setInput());
  form.submit();    

  function setInput(){
    var input = document.createElement('input');
        input.setAttribute('type', 'hidden');
        input.setAttribute('value', '1');
        input.setAttribute('name', 'verificaEmail');  

    return input;
  }

  function getForm(){
    var form = document.querySelector('#form');
    return form;
  }

  function setForm(form, input){
    form.appendChild(input);            
    form.action = "/usuario/novo/validarEmail";    
    form.method = "post";     

    return form;
  }    
}

function comparaSenha(){
      
  var senha = document.getElementById('senha');
  var senha_confirmation = document.getElementById('senha_confirmation');      
      
  var btnSalvar = document.getElementById('btnSalvar');
      btnSalvar.classList.remove('oucutarElemento');  

  var ul = document.getElementById('msg');
      ul.classList.add('oucutarElemento');
      ul.style="list-style-type: none";          
      limpaLi();
      
  if(senha.value != senha_confirmation.value){
    btnSalvar.classList.add('oucutarElemento');                
    impressaoMsgErro();        
  }    

  function limpaLi(){
    var lis = document.querySelectorAll('.msgTempSenha');
    for (var i = 0; i < lis.length; i++){
      ul.removeChild(lis[i]);  
    }
  }          

  function impressaoMsgErro(){
        
    var li = document.createElement('li');
        li.classList.add('msgTempSenha');
        li.textContent = "As senhas devem ser iguais"; 
           
        ul.classList.remove('oucutarElemento'); 
        ul.classList.add('alert');
        ul.classList.add('alert-danger');
        ul.appendChild(li);
  }  
}  