(function (){      
  'Valida descrição perfil';
   var descricao = document.querySelector('#descricao');  

   descricao.addEventListener('invalid', function () {
     var $this = this;
     var errorsMessage = 'Informe um nome de perfil com pelo menos 3 caracteres';

     $this.setCustomValidity('');

     if (!$this.validity.valid) {
       $this.setCustomValidity(errorsMessage);
     };
      });    
   })();
