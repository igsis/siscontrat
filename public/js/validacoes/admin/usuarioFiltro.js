function pegaFiltro()
{
  var filtro = document.getElementById('filtro');
      
  var form = document.getElementById('frm_index_usuario');      
      form.action = "/usuario/filtro";

  var input = document.createElement('input');
      input.setAttribute('type', 'hidden');
      input.setAttribute('name', 'filtro');
      input.setAttribute('value', filtro.value);

  form.appendChild(input);    
  form.submit();
}    