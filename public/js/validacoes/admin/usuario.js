(function (){        
  'Valida nome';
   var nome = document.querySelector('#nome_completo');  

   nome.addEventListener('invalid', function () {
     var $this = this;
     var errorsMessage = 'Um nome deve ser informado';

      $this.setCustomValidity('');

      if (!$this.validity.valid) {
        $this.setCustomValidity(errorsMessage);
      };
   });    
})();

(function (){      
   'Valida usuário';
    var usuario = document.querySelector('#usuario');  

    usuario.addEventListener('invalid', function () {
       var $this = this;
       var errorsMessage = 'Um login deve ser informado';

       $this.setCustomValidity('');

       if (!$this.validity.valid) {
          $this.setCustomValidity(errorsMessage);
       };
    });    
})();

(function (){      
   'Valida senha';
   var senha = document.querySelector('#senha');  

   senha.addEventListener('invalid', function () {
      var $this = this;
      var errorsMessage = 'Uma senha deve ser informada';

      $this.setCustomValidity('');

      if (!$this.validity.valid) {
         $this.setCustomValidity(errorsMessage);
      };
   });    
})();

(function (){      
   'Valida confirmação de senha';
   var senha_confirmation = document.querySelector('#senha_confirmation');  

   senha_confirmation.addEventListener('invalid', function () {
      var $this = this;
      var errorsMessage = 'Confirme a senha informada';

      $this.setCustomValidity('');

      if (!$this.validity.valid) {
         $this.setCustomValidity(errorsMessage);
      };
    });    
})();

(function (){      
   'Valida email';
   var email = document.querySelector('#email');  

   email.addEventListener('invalid', function () {
      var $this = this;
      var errorsMessage = 'Informe um e-mail no padrão igsis@gmail.com';

      $this.setCustomValidity('');

      if (!$this.validity.valid) {
         $this.setCustomValidity(errorsMessage);
      };
    });    
})();

(function (){      
   'Valida telefone';
   var telefone = document.querySelector('#telefone');  

   telefone.addEventListener('invalid', function () {
      var $this = this;
      var errorsMessage = 'Informe um numero de telefone';

      $this.setCustomValidity('');

      if (!$this.validity.valid) {
         $this.setCustomValidity(errorsMessage);
      };
   });    
})();

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
    var form = document.querySelector('form');
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
    var form = document.querySelector('form');
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

/*Foco no campo após request*/
window.onload = function(){
  var nome_completo = 
    document.querySelector("form").nome_completo.value;       

  var usuario = 
    document.querySelector("form").usuario.value;         

  var email = 
    document.querySelector("form").email.value;               

  if(nome_completo == ""){
    document.querySelector("form").nome_completo.focus();  
  }else if(usuario == ""){
    document.querySelector("form").usuario.focus();      
  }else if(email == ""){
    document.querySelector("form").email.focus();      
  }else{
    document.querySelector("form").senha.focus();       
  }   
  
}    