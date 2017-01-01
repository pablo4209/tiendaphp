function goLostpass() {
  var connect, form, response, result, email;
  email = __('email_lostpass').value;
  if(email != '') {
    form = 'email=' + email;
    connect = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    connect.onreadystatechange = function() {
      if(connect.readyState == 4 && connect.status == 200) {
        if(connect.responseText == 1) {
          result = '<div class="alert alert-dismissible alert-success">';
          result += '<h4>Se ha enviado un correo!</h4>';
          result += '<p><strong>Revisa tu correo y has clic en el enlace</strong></p>';
          result += '</div>';
          __('_AJAX_LOSTPASS_').innerHTML = result;
          location.reload();
        } else {
          __('_AJAX_LOSTPASS_').innerHTML = connect.responseText;
        }
      } else if(connect.readyState != 4) {
        result = '<div class="alert alert-dismissible alert-warning">';
        result += '<button type="button" class="close" data-dismiss="alert">x</button>';
        result += '<h4>Procesando...</h4>';
        result += '<p><strong>Estamos procesando la información...</strong></p>';
        result += '</div>';
        __('_AJAX_LOSTPASS_').innerHTML = result;
      }
    }
    connect.open('POST','ajax.php?mode=lostpass',true);
    connect.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    connect.send(form);
  } else {
    result = '<div class="alert alert-dismissible alert-danger">';
    result += '<button type="button" class="close" data-dismiss="alert">x</button>';
    result += '<h4>Error</h4>';
    result += '<p><strong>Debes llenar el campo de email</strong></p>';
    result += '</div>';
    __('_AJAX_LOSTPASS_').innerHTML = result;
  }
}

function runScriptLostpass(e) {
  if(e.keyCode == 13) {
    goLostpass();
  }
}