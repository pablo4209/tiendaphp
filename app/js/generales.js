function __(id) {
  return document.getElementById(id);
}

function DeleteItem(contenido,url) {
  var action = window.confirm(contenido);
  if (action) {
      window.location = url;
  }
}

function habilitarBotones(){
	$(".btn").each(function(){ $(this).attr("disabled", false) });
}
function deshabilitarBotones(){
	$(".btn").each(function(){ $(this).attr("disabled", true) });
}

$(document).ready(function(){
	
	$("body").delegate(".soloNumeros", "keypress paste", function(event){		
		// Backspace, tab, enter, end, home, left, right
		  // We don't support the del key in Opera because del == . == 46.
		  var controlKeys = [8, 9, 13, 35, 36, 37, 39];
		  // IE doesn't support indexOf
		  var isControlKey = controlKeys.join(",").match(new RegExp(event.which));
		  // Some browsers just don't raise events for control keys. Easy.
		  // e.g. Safari backspace.
		  if (!event.which || // Control keys in most browsers. e.g. Firefox tab is 0
		      (49 <= event.which && event.which <= 57) || // Always 1 through 9
		      (48 == event.which && $(this).attr("value")) || // No 0 first digit
		      isControlKey) { // Opera assigns values for control keys.
		    return;
		  } else {
		    event.preventDefault();
		  }
	});

});
