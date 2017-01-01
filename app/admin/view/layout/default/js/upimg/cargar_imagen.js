$(document).ready(function(){
	
    $(".messages").hide();
    //queremos que esta variable sea global
    var fileExtension = "";
    //funci�n que observa los cambios del campo file y obtiene informaci�n
    $(':file').change(function()
    {
        //obtenemos un array con los datos del archivo
        var file = $("#imagen")[0].files[0];
        //obtenemos el nombre del archivo
        var fileName = file.name;
        //obtenemos la extensi�n del archivo
        fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
        //obtenemos el tama�o del archivo
        var fileSize = file.size;
        //obtenemos el tipo de archivo image/png ejemplo
        var fileType = file.type;
        //mensaje con la informaci�n del archivo
        showMessage("<span class='info'>Nombre: "+fileName+", Tama�o: "+fileSize+" bytes.</span>");
    });
 
    //al enviar el formulario
    $('#upimg').click(function(){
        //informaci�n del formulario
        var formData = new FormData($(".formulario")[0]);
        var message = "";    
        //hacemos la petici�n ajax  
        $.ajax({
            url: 'upload.php',  
            type: 'POST',
            // Form data
            //datos del formulario
            data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
            //mientras enviamos el archivo
            beforeSend: function(){
                message = $("<span class='before'>Subiendo la imagen, por favor espere...</span>");
                showMessage(message)         
            },
            //una vez finalizado correctamente
            success: function(data){
                message = $("<span class='success'>La imagen ha subido correctamente.</span>");
                showMessage(message);
                if(isImage(fileExtension))
                {
                    $(".showImage").html("<img src='"+$("#destino").val()+"/"+data+"' />");					
					$("#nombreimg").val(data);
					$("#aplicar").attr('disabled', false);					
                }
            },
            //si ha ocurrido un error
            error: function(){
                message = $("<span class='error'>Ha ocurrido un error.</span>");
                showMessage(message);
            }
        });
    });
	$('#aplicar').click(function(){ 
			opener.document.getElementById($("#controldestino").val()).value = $("#nombreimg").val();			
			opener.document.getElementById("imgImagen").src = $("#path").val() + $("#destino").val() + "/" + $("#nombreimg").val();
			self.close(); 
		});
	$('#cancelar').click(function(){  self.close(); });
})
 
//como la utilizamos demasiadas veces, creamos una funci�n para 
//evitar repetici�n de c�digo
function showMessage(message){
    $(".messages").html("").show();
    $(".messages").html(message);
}
 
//comprobamos si el archivo a subir es una imagen
//para visualizarla una vez haya subido
function isImage(extension)
{
    switch(extension.toLowerCase()) 
    {
        case 'jpg': case 'gif': case 'png': case 'jpeg':
            return true;
        break;
        default:
            return false;
        break;
    }
}