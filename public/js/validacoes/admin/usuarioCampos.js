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