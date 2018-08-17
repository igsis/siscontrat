function mascaraNome(nome)
{ 
  setTimeout(function(){
    nome.value = setMaskName(nome.value);  
  },250);
}

function setMaskName(nome)
{            
  nome = nome.replace(/^([\d,.=_+* ])/g, '');
            
  return nome;
}
    
