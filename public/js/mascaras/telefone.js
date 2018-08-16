function mascaraTelefone()
{ 
  setTimeout("aplicaTelefone()",1)
}
    
function aplicaTelefone()
{
	telefone = document.querySelector("input[name='telefone']");
 	telefone.value = setMaskPhone(telefone.value);
}

function setMaskPhone(telefone)
{            
  telefone = telefone.replace(/\D/g,"");             
  telefone = telefone.replace(/^(\d{2})/g,"($1) "); 
  telefone = telefone.replace(/(\d{4,5})(\d{4})$/,"$1-$2");
        
  return telefone;
}
    
