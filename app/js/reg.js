function verificarUserEmail(){
  var connect, form, response, result, user, email;
  user = __('login').value;
  email = __('correo').value;
  form = 'user=' + user + '&email=' + email;
  connect = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    connect.onreadystatechange = function() {
        if(connect.readyState == 4 && connect.status == 200) {
              if(connect.responseText == 1){
                __('_AJAX_REG_').innerHTML = "el usuario y email estan libres";
                return true;
              }else{
                __('_AJAX_REG_').innerHTML = connect.responseText;
                return false;
              }

        } else if(connect.readyState != 4) {
          result = '<div class="alert alert-dismissible alert-warning">';
          result += '<button type="button" class="close" data-dismiss="alert">x</button>';
          result += '<h4>Procesando...</h4>';
          result += '<p><strong>Estamos procesando tu registro...</strong></p>';
          result += '</div>';
          __('_AJAX_REG_').innerHTML = result;
        }
    }
    connect.open('POST','ajax.php?mode=userCheck',true);
    connect.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    connect.send(form);
}
