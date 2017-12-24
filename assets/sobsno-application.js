$(function(){

	$.get( "/fragment/menu", function(html) {
		$(".app-menu").html(html);
	});

});
