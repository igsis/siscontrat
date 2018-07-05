(function (){      
      'Valida descrição perfil';
      var descricao = document.querySelector('#desc_perfil');  

      descricao.addEventListener('invalid', function () {
        var $this = this;
        var errorsMessage = 'Informe um nome para a descrição do usuário';

        $this.setCustomValidity('');

        if (!$this.validity.valid) {
          $this.setCustomValidity(errorsMessage);
        };
      });    
    })();
    
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
      var senhaConf = document.querySelector('#senhaConf');  

      senhaConf.addEventListener('invalid', function () {
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

    