(function (){      
  'Valida descrição perfil';
   var descricao = document.querySelector('#descricao');  

   descricao.addEventListener('invalid', function () {
     var $this = this;
     var errorsMessage = 'Informe um nome para a descrição do usuário';

     $this.setCustomValidity('');

     if (!$this.validity.valid) {
       $this.setCustomValidity(errorsMessage);
     };
      });    
   })();
