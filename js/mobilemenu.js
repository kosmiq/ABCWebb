jQuery(document).ready(function($){
	/* prepend menu icon */
	$('#title').append('<div id="mobi-menu"></div>');

	/* toggle nav */
	$("#mobi-menu").on("click", function(){
		$("#nav_menu-2").slideToggle();
		$(this).toggleClass("active");
	});
});