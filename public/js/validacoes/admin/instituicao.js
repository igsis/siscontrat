(function (){      
  'Valida nome instituição';
   let nome = document.getElementById('nome');  

   nome.addEventListener('invalid', function () {
     let $this = this;
     let errorsMessage = 'Este campo requer no mínimo 3 caracteres';

     $this.setCustomValidity('');

     if (!$this.validity.valid) {
       $this.setCustomValidity(errorsMessage);
     };
   });    
})();

(function (){      
  'Valida sigla instituição';
   let sigla = document.getElementById('sigla');  

   sigla.addEventListener('invalid', function () {
     let $this = this;
     let errorsMessage = 'Este campo requer no mínimo 3 caracteres';

     $this.setCustomValidity('');

     if (!$this.validity.valid) {
       $this.setCustomValidity(errorsMessage);
     };
   });    
})();

/*Foco no campo apos request*/
window.onload = function(){
  document.getElementById("nome").focus();
}       
