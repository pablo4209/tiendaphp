$(function(){
    
    $('.selTxt').focus(function(){
      this.select();
    });

    $("#login").keyup(function(e){
        var keyCode = e.keyCode || e.which;               
        e.preventDefault();

        if( keyCode == 13 ){  //ENTER
              $("#pass").focus();
        } 

        
    });

    $("#pass").keyup(function(e){
        var keyCode = e.keyCode || e.which;               
        e.preventDefault();
        
        if( keyCode == 13 ){  //ENTER
              valida_logueo();
        } 
        
    });

    $("#btnEntrar").click(function(){
        
        valida_logueo();

    });

});

//*************************************************************************************************
//Funci?n para validar direcci?n web
function valida_url() {
	var url=document.enviar.web.value;
  var re=/^(http|ftp)(s)?:\/\/\w+(\.\w+)*(-\w+)?\.([a-z]{2,3}|info|mobi|aero|asia|name)(:\d{2,5})?(\/)?((\/).+)?$/;
  return re.test(url);
  if (!valida_url(url)){
  		alert("La direccion Web ingresada no es valida");
  		document.enviar.web.value="";
	}

}
//*******************************************************
function valida_logueo()
{
    var form=document.form;
    if (form.login.value==0)
    {
        document.getElementById("valor").innerHTML="<div class='fail large png_bg'><font color='#ff0000'>EL Login est&aacute; vac&iacute;o</font></div>";
        form.login.value="";
        form.login.focus();
        return false;
    }else
    {
        document.getElementById("valor").innerHTML="";
    }
     if (form.pass.value==0)
    {
        document.getElementById("valor").innerHTML="<div class='fail large png_bg'><font color='#ff0000'>EL Password est&aacute; vac&iacute;o</font></div>";
        form.pass.value="";
        form.pass.focus();
        return false;
    }else
    {
        document.getElementById("valor").innerHTML="";
    }
    
    form.submit();
}