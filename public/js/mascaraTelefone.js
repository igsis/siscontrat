function setMascara(phone, getMascara){
      
  telefone = phone
  mascara = getMascara

  setTimeout("aplicaMascara()",1)
}
    
function aplicaMascara(){
  telefone.value=mascara(telefone.value)
}
    
function getMascara(telefone){      
      
  telefone=telefone.replace(/\D/g,"");             
  telefone=telefone.replace(/^(\d{2})(\d)/g,"($1) $2"); 
  telefone=telefone.replace(/(\d)(\d{4})$/,"$1-$2");    
      
  return telefone;
}