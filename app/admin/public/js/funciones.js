/* Desarrollado por www.cesarcancino.com */


function obtiene_http_request()
{
var req = false;
try
  {
    req = new XMLHttpRequest(); /* p.e. Firefox */
  }
catch(err1)
  {
  try
    {
     req = new ActiveXObject("Msxml2.XMLHTTP");
  /* algunas versiones IE */
    }
  catch(err2)
    {
    try
      {
       req = new ActiveXObject("Microsoft.XMLHTTP");
  /* algunas versiones IE */
      }
      catch(err3)
        {
         req = false;
        }
    }
  }
return req;
}
var miPeticion = obtiene_http_request();
/********************************************/
function from_post(id,ide,url)
{
        //para que no guarde la página en el caché...
		var mi_aleatorio=parseInt(Math.random()*99999999);
		//creo la URL dinámica
		var vinculo=url+"?id="+id+"&rand="+mi_aleatorio+"&valor="+id;
		//alert(vinculo);
		//ponemos true para que la petición sea asincrónica
		miPeticion.open("POST",vinculo,true);
		miPeticion.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		miPeticion.send(vinculo);
		
		
		//ahora procesamos la información enviada
		miPeticion.onreadystatechange=miPeticion.onreadystatechange=function(){
               //alert("ready_State="+miPeticion.readyState);
               if (miPeticion.readyState==4)
               {
				   //alert(miPeticion.readyState);
                       //alert("status ="+miPeticion.status);
                       if (miPeticion.status==200)
                       {
                                //alert(miPeticion.status);
                               //var http=miPeticion.responseXML;
                               //alert("http="+http);
                               var http=miPeticion.responseText;
                               document.getElementById(ide).innerHTML= http;

                       }
               }
               
       }
       miPeticion.send(null);
	
}
//funciones para libox
function show(url)
				{
				    //alert(url);
			document.getElementById('sombra').className='sombraLoad';
			document.getElementById('window').className='windowLoad';
			document.getElementById("foto_tecnologia").src=url;
                 }

		function hide()
		{
			document.getElementById('sombra').className='sombraUnload';
			document.getElementById('window').className='windowUnload';
			document.getElementById("foto_tecnologia").src="";
		}
     //para productos   
  function show_2(url,id)
				{
				    //alert("images/foto_caja_banner/"+url);
			document.getElementById('sombra').className='sombraLoad';
			document.getElementById('window').className='windowLoad';
			document.getElementById("imagen_arriba").src="images/foto_caja_banner/"+url;
            document.ima.id_producto.value=id;
            document.ima.archivo.value=url;
                 }

		function hide_2()
		{
			document.getElementById('sombra').className='sombraUnload';
			document.getElementById('window').className='windowUnload';
			document.getElementById("foto_tecnologia").src="";
		}      
//**************************************************
//mostrar reloj
	function muestraReloj()
{
// Compruebo si se puede ejecutar el script en el navegador del usuario
if (!document.layers && !document.all && !document.getElementById) return;
// Obtengo la hora actual y la divido en sus partes
var fechacompleta = new Date();
var horas = fechacompleta.getHours();
var minutos = fechacompleta.getMinutes();
var segundos = fechacompleta.getSeconds();
var mt = "AM";
// Pongo el formato 12 horas
if (horas> 12) {
mt = "PM";
horas = horas - 12;
}
if (horas == 0) horas = 12;
// Pongo minutos y segundos con dos digitos
if (minutos <= 9) minutos = "0" + minutos;
if (segundos <= 9) segundos = "0" + segundos;
// En la variable 'cadenareloj' puedes cambiar los colores y el tipo de fuente
//cadenareloj = "<font size='-1' face='verdana'>" + horas + ":" + minutos + ":" + segundos + " " + mt + "</font>";
cadenareloj =horas + ":" + minutos + ":" + segundos + " " + mt;
// Escribo el reloj de una manera u otra, segun el navegador del usuario
if (document.layers) {
document.layers.spanreloj.document.write(cadenareloj);
document.layers.spanreloj.document.close();
}
else if (document.all) spanreloj.innerHTML = cadenareloj;
else if (document.getElementById) document.getElementById("spanreloj").innerHTML = cadenareloj;
// Ejecuto la funcion con un intervalo de un segundo
setTimeout("muestraReloj()", 1000);
}
//*********************************************************************************
function botones(id,color)
{
    document.getElementById(id).style.backgroundColor=color;
}

//*******************************************************************************************************
function checkCDV( dvr )
{
  dv = dvr + "";
  if ( dv != '0' && dv != '1' && dv != '2' && dv != '3' && dv != '4' && dv != '5' && dv != '6' && dv != '7' && dv != '8' && dv != '9' && dv != 'k'  && dv != 'K')
  {
	//alert("Debe ingresar un digito verificador valido.");	  
	return false;
  }
  return true;
}

//////////////////////////////////////////////////

function checkDV( crut )
{

  var error = false; 
  largo = crut.length;
  if ( largo < 2 )
  {
        error = true;
  }
  if ( largo > 2 )
    rut = crut.substring(0, largo-1);
    dv = crut.charAt(largo-1);
    checkCDV( dv );

  if ( rut == null || dv == null )
      return 0;

  var dvr = '0';

  suma = 0;
  mul  = 2;

  for (i= rut.length-1  ; i >= 0; i--)
  {
    suma = suma + rut.charAt(i) * mul;
    if (mul == 7)
      mul = 2;
    else    
      mul++;
  }
  res = suma % 11;
  if (res==1)
    dvr = 'k';
  else if (res==0)
    dvr = '0';
  else
  {
    dvi = 11-res;
    dvr = dvi + "";
  }
  if ( dvr != dv.toLowerCase() )
  {
     error = true;
  }
  if(error) {
        return false;
  }
  else {
        return true;
  } 
}

function checkRutField(camtexto)
{
  var error = false;
  texto = camtexto.value;
  if(texto == "") {
        return true;
  }
  var tmpstr = "";
  for ( i=0; i < texto.length ; i++ )
    if ( texto.charAt(i) != ' ' && texto.charAt(i) != '.' && texto.charAt(i) != '-' )
      tmpstr = tmpstr + texto.charAt(i);
  texto = tmpstr;
  largo = texto.length;
  if ( largo > 0 && largo < 2 )
  {
    error = true;
  }
  for (i=0; i < largo ; i++ )
  { 
    if ( texto.charAt(i) !="0" && texto.charAt(i) != "1" && texto.charAt(i) !="2" && texto.charAt(i) != "3" && texto.charAt(i) != "4" && texto.charAt(i) !="5" && texto.charAt(i) != "6" && texto.charAt(i) != "7" && texto.charAt(i) !="8" && texto.charAt(i) != "9" &&texto.charAt(i) !="k" && texto.charAt(i) != "K" ) 
    {
      error = true;
    }
  }
  if (error == false){
  	var auxtext=texto.substring(0,texto.length-1);
        var auxdv=texto.substring(texto.length-1,texto.length);
	auxtext=parseInt(auxtext,10)+0;
	texto=auxtext+auxdv;
        camtexto.value=texto;
  }
  largo = texto.length;
  if ( largo > 0 && largo < 2 )
  {
    error = true;
  }
  var invertido = "";
  for ( i=(largo-1),j=0; i>=0; i--,j++ )
    invertido = invertido + texto.charAt(i);

  var dtexto = "";
  dtexto = dtexto + invertido.charAt(0);
  if(dtexto != "") {
        dtexto = dtexto + '-';
  }
  cnt = 0;

  for ( i=1,j=2; i<largo; i++,j++ )
  {
    if ( cnt == 3 )
    {
      dtexto = dtexto + '.';
      j++;
      dtexto = dtexto + invertido.charAt(i);
      cnt = 1;
    }
    else
    { 
      dtexto = dtexto + invertido.charAt(i);
      cnt++;
    }
  }
  invertido = "";
  for ( i=(dtexto.length-1),j=0; i>=0; i--,j++ )
    invertido = invertido + dtexto.charAt(i);


  camtexto.value = invertido;  
  if(texto.length > 7 ) {
        if ( !checkDV(texto) ) {
                error = true;
        }
  }

  else {
        error = true;
  }
 		
  if(error) {
       /* alert("El dato ingresado no es un R.U.T valido.");
        camtexto.select();
		camtexto.value="";
		camtexto.focus();
       */ return false;
  }
  else {
        return true;
  }
}
//*****************************************************************************
//Valida correo
function correo(correo) {
		  if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(correo)){
			
		   return (true)
		  } else {
		   
		   return (false);
		  }
		 }
//*************************************************************************************************************************************
//valida n?meros
function valida_numero(numero)
{
if (!/^([0-9])*$/.test(numero)){
		return false;
}else{
		return true;
	}
}

//*************************************************************************************************
//Funci?n para validar direcci?n web
function valida_url() {
	var url=document.enviar.web.value;
var re=/^(http|ftp)(s)?:\/\/\w+(\.\w+)*(-\w+)?\.([a-z]{2,3}|info|mobi|aero|asia|name)(:\d{2,5})?(\/)?((\/).+)?$/;
return re.test(url);
if (!valida_url(url)){
		alert("La direcci?n Web ingresada no es v�lida");
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
function eliminar(url)
{
	if (confirm("Realmente desea eliminar este registro?"))
	{
		window.location=url;
	}	
}
function limpiar()
{
	document.form.reset();
	document.form.nom.focus();
}
function valida_ingreso_usuario()
{
    var form=document.form;
    if (form.nom.value==0)
    {
        document.getElementById("valor").innerHTML="<div class='fail large png_bg'><font color='#ff0000'>EL Nombre est&aacute; vac&iacute;o</font></div>";
        form.nom.value="";
        form.nom.focus();
        return false;
    }else
    {
        document.getElementById("valor").innerHTML="";
    }
    if (form.correo.value==0)
    {
        document.getElementById("valor").innerHTML="<div class='fail large png_bg'><font color='#ff0000'>EL E-Mail est&aacute; vac&iacute;o</font></div>";
        form.correo.value="";
        form.correo.focus();
        return false;
    }else
    {
        document.getElementById("valor").innerHTML="";
    }
    if (valida_correo(form.correo.value)==false)
    {
        document.getElementById("valor").innerHTML="<div class='fail large png_bg'><font color='#ff0000'>EL E-Mail ingresado no es válido</font></div>";
        form.correo.value="";
        form.correo.focus();
        return false;
    }else
    {
        document.getElementById("valor").innerHTML="";
    }
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
    if (form.pass.value != form.pass_2.value)
    {
        document.getElementById("valor").innerHTML="<div class='fail large png_bg'><font color='#ff0000'>Las contraseñas ingresadas no coinciden</font></div>";
        form.pass.value="";
        form.pass_2.value="";
        form.pass.focus();
        return false;
    }else
    {
        document.getElementById("valor").innerHTML="";
    }
    //alert("todo ok");
    form.submit();
}
function valida_ingreso_cliente()
{
      var form=document.form;
    if (form.nom.value==0)
    {
        document.getElementById("valor").innerHTML="<div class='fail large png_bg'><font color='#ff0000'>EL Nombre est&aacute; vac&iacute;o</font></div>";
        form.nom.value="";
        form.nom.focus();
        return false;
    }else
    {
        document.getElementById("valor").innerHTML="";
    }
    if (form.rut.value==0)
    {
        document.getElementById("valor").innerHTML="<div class='fail large png_bg'><font color='#ff0000'>EL RUT est&aacute; vac&iacute;o</font></div>";
        form.rut.value="";
        form.rut.focus();
        return false;
    }else
    {
        document.getElementById("valor").innerHTML="";
    }
    if (checkRutField(document.form.rut)==false)
    {
        document.getElementById("valor").innerHTML="<div class='fail large png_bg'><font color='#ff0000'>EL RUT ingresado no es v&aacute;lido</font></div>";
        form.rut.value="";
        form.rut.focus();
        return false;
    }else
    {
        document.getElementById("valor").innerHTML="";
    }
    if (form.correo.value==0)
    {
        document.getElementById("valor").innerHTML="<div class='fail large png_bg'><font color='#ff0000'>EL E-Mail est&aacute; vac&iacute;o</font></div>";
        form.correo.value="";
        form.correo.focus();
        return false;
    }else
    {
        document.getElementById("valor").innerHTML="";
    }
    if (valida_correo(form.correo.value)==false)
    {
        document.getElementById("valor").innerHTML="<div class='fail large png_bg'><font color='#ff0000'>EL E-Mail ingresado no es válido</font></div>";
        form.correo.value="";
        form.correo.focus();
        return false;
    }else
    {
        document.getElementById("valor").innerHTML="";
    }
    if (form.tel.value==0)
    {
        document.getElementById("valor").innerHTML="<div class='fail large png_bg'><font color='#ff0000'>EL Teléfono est&aacute; vac&iacute;o</font></div>";
        form.tel.value="";
        form.tel.focus();
        return false;
    }else
    {
        document.getElementById("valor").innerHTML="";
    }
    
    
     if (form.dia.value==0)
    {
        document.getElementById("valor").innerHTML="<div class='fail large png_bg'><font color='#ff0000'>Indique su día de nacimiento</font></div>";
        form.dia.value="";
        form.dia.focus();
        return false;
    }else
    {
        document.getElementById("valor").innerHTML="";
    }
    
     if (form.mes.value==0)
    {
        document.getElementById("valor").innerHTML="<div class='fail large png_bg'><font color='#ff0000'>Indique su mes de nacimiento</font></div>";
        form.mes.value="";
        form.mes.focus();
        return false;
    }else
    {
        document.getElementById("valor").innerHTML="";
    }
     if (form.anio.value==0)
    {
        document.getElementById("valor").innerHTML="<div class='fail large png_bg'><font color='#ff0000'>Indique su año de nacimiento</font></div>";
        form.anio.value="";
        form.anio.focus();
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
    if (form.pass.value != form.pass_2.value)
    {
        document.getElementById("valor").innerHTML="<div class='fail large png_bg'><font color='#ff0000'>Las contraseñas ingresadas no coinciden</font></div>";
        form.pass.value="";
        form.pass_2.value="";
        form.pass.focus();
        return false;
    }else
    {
        document.getElementById("valor").innerHTML="";
    }
    if (form.dir_1.value==0)
    {
        document.getElementById("valor").innerHTML="<div class='fail large png_bg'><font color='#ff0000'>La dirección está vacía</font></div>";
        form.dir_1.value="";
        form.dir_1.focus();
        return false;
    }else
    {
        document.getElementById("valor").innerHTML="";
    }
    if (form.region_1.value==0)
    {
        document.getElementById("valor").innerHTML="<div class='fail large png_bg'><font color='#ff0000'>Indique la región</font></div>";
        form.region_1.value="";
        form.region_1.focus();
        return false;
    }else
    {
        document.getElementById("valor").innerHTML="";
    }
     if (form.ciudad_1.value==0)
    {
        document.getElementById("valor").innerHTML="<div class='fail large png_bg'><font color='#ff0000'>Indique la ciudad</font></div>";
        form.ciudad_1.value="";
        form.ciudad_1.focus();
        return false;
    }else
    {
        document.getElementById("valor").innerHTML="";
    }
     if (form.comuna_1.value==0)
    {
        document.getElementById("valor").innerHTML="<div class='fail large png_bg'><font color='#ff0000'>Indique la comuna</font></div>";
        form.comuna_1.value="";
        form.comuna_1.focus();
        return false;
    }else
    {
        document.getElementById("valor").innerHTML="";
    }
    //alert("todo ok");
    form.submit();
}
function valida_ingreso_registrado()
{
     var form=document.form;
    if (form.nom.value==0)
    {
        document.getElementById("valor").innerHTML="<div class='fail large png_bg'><font color='#ff0000'>EL Nombre est&aacute; vac&iacute;o</font></div>";
        form.nom.value="";
        form.nom.focus();
        return false;
    }else
    {
        document.getElementById("valor").innerHTML="";
    }
    if (form.correo.value==0)
    {
        document.getElementById("valor").innerHTML="<div class='fail large png_bg'><font color='#ff0000'>EL E-Mail est&aacute; vac&iacute;o</font></div>";
        form.correo.value="";
        form.correo.focus();
        return false;
    }else
    {
        document.getElementById("valor").innerHTML="";
    }
    if (valida_correo(form.correo.value)==false)
    {
        document.getElementById("valor").innerHTML="<div class='fail large png_bg'><font color='#ff0000'>EL E-Mail ingresado no es válido</font></div>";
        form.correo.value="";
        form.correo.focus();
        return false;
    }else
    {
        document.getElementById("valor").innerHTML="";
    }
    if (form.tel.value==0)
    {
        document.getElementById("valor").innerHTML="<div class='fail large png_bg'><font color='#ff0000'>EL Teléfono est&aacute; vac&iacute;o</font></div>";
        form.tel.value="";
        form.tel.focus();
        return false;
    }else
    {
        document.getElementById("valor").innerHTML="";
    }
    if (form.pass.value==0)
    {
        document.getElementById("valor").innerHTML="<div class='fail large png_bg'><font color='#ff0000'>La contraseña est&aacute; vac&iacute;a</font></div>";
        form.pass.value="";
        form.pass.focus();
        return false;
    }else
    {
        document.getElementById("valor").innerHTML="";
    }
    if (form.pass_2.value==0)
    {
        document.getElementById("valor").innerHTML="<div class='fail large png_bg'><font color='#ff0000'>Debe repetir la contraseña</font></div>";
        form.pass_2.value="";
        form.pass_2.focus();
        return false;
    }else
    {
        document.getElementById("valor").innerHTML="";
    }
    if (form.pass_2.value != form.pass.value)
    {
        document.getElementById("valor").innerHTML="<div class='fail large png_bg'><font color='#ff0000'>Las contraseñas ingresadas no coinciden</font></div>";
        form.pass_2.value="";
        form.pass.value="";
        form.pass.focus();
        return false;
    }else
    {
        document.getElementById("valor").innerHTML="";
    }
   form.submit();
}