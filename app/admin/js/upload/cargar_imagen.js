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
        showMessage('<div class="alert alert-success" role="alert">Nombre: '+fileName+"</br> Tama�o: "+fileSize+" bytes.</div>");
    });
    
    //al enviar el formulario
    $('#upimg').click(function(){
        //informaci�n del formulario        
        var formData = new FormData($(".formulario")[0]);
        var message = "";    
        //hacemos la petici�n ajax  
        $.ajax({
            url: 'ajax.php/?mode=uploadimg',  
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
                message = $('<div class="alert alert-warning" role="alert">Subiendo la imagen, por favor espera...</div>');
                showMessage(message)         
            },
            //una vez finalizado correctamente
            success: function(data){
                message = $('<div class="alert alert-success" role="alert"><span>La imagen ha subido correctamente.</span></div>');
                showMessage(message);
                if(isImage(fileExtension))
                {
                    $(".showImage").html('<img style="max-height: 320px;" src="'+ $("#destino_temp").val() +data+'" />');					
					$("#nombre_img").val(data);
					$("#aplicar").attr('disabled', false);					
                }
            },
            //si ha ocurrido un error
            error: function(){
                message = $('<div class="alert alert-success" role="alert"><span class="error">Ha ocurrido un error.</span></div>');
                showMessage(message);
            }
        });
    });
	$('#aplicar').click(function(){ 
            $("#controldestino").attr("value", $("#nombre_img").val());
            $("#imgImagen").attr("src", $("#destino_temp").val() + $("#nombre_img").val());   			            
            $("#Imagen").attr("value", $("#nombre_img").val() )
            $('#divCargarImg').modal('hide');    
		});
	
})
 

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