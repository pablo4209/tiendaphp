$(document).ready(function(){
	
	$("body").delegate("#panelMenu a", "click", function(){
			if($(this).children().is(".arrow")){				
				$(this).children().removeClass("arrow").addClass("arrow-down");
			}else if($(this).children().is(".arrow-down")){
				$(this).children().removeClass("arrow-down").addClass("arrow");
			}else{
				window.location.href = $("#linkCatalogo").attr("href") + '&cat=' + $(this).attr("idCat");			
			}
			
			
	
	});
	
	function collapseAll(){		
		$("#MainMenu").find("span").removeClass("arrow-down").addClass("arrow");
		$(".collapse").each(function(){
				$(this).removeClass("in");
		});
	}
	
	function expandAll(){
		$("#MainMenu").find("span").removeClass("arrow").addClass("arrow-down");		
		$(".collapse").each(function(){
				$(this).addClass("in");
		});
	}
			
});