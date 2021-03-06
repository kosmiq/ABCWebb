/* Filterable JS */
(function(jQuery) {
	jQuery.fn.filterable = function(settings) {
		settings = jQuery.extend({
			useHash: true,
			animationSpeed: 1000,
			show: { width: 'show', height: 'show', opacity: 'show' },
			hide: { width: 'hide', height: 'hide', opacity: 'hide' },
			useTags: true,
			tagSelector: '#portfolio-filter a',
			selectedTagClass: 'current',
			allTag: 'all'
		}, settings);
		
		return jQuery(this).each(function(){
		
			/* FILTER: select a tag and filter */
			jQuery(this).bind("filter", function( e, tagToShow ){
				if(settings.useTags){
					jQuery(settings.tagSelector).removeClass(settings.selectedTagClass);
					jQuery(settings.tagSelector + '[href=' + tagToShow + ']').addClass(settings.selectedTagClass);
				}
				jQuery(this).trigger("filterportfolio", [ tagToShow.substr(1) ]);
			});
		
			/* FILTERPORTFOLIO: pass in a class to show, all others will be hidden */
			jQuery(this).bind("filterportfolio", function( e, classToShow ){
				if(classToShow == settings.allTag){
					jQuery(this).trigger("show");
				}else{
					jQuery(this).trigger("show", [ '.' + classToShow ] );
					jQuery(this).trigger("hide", [ ':not(.' + classToShow + ')' ] );
				}
				if(settings.useHash){
					location.hash = '#' + classToShow;
				}
			});
			
			/* SHOW: show a single class*/
			jQuery(this).bind("show", function( e, selectorToShow ){
				jQuery(this).children(selectorToShow).animate(settings.show, settings.animationSpeed);
			});
			
			/* SHOW: hide a single class*/
			jQuery(this).bind("hide", function( e, selectorToHide ){
				jQuery(this).children(selectorToHide).animate(settings.hide, settings.animationSpeed);	
			});
			
			/* ============ Check URL Hash ====================*/
			if(settings.useHash){
				if(location.hash != '')
					jQuery(this).trigger("filter", [ location.hash ]);
				else
					jQuery(this).trigger("filter", [ '#' + settings.allTag ]);
			}
			
			/* ============ Setup Tags ====================*/
			if(settings.useTags){
				jQuery(settings.tagSelector).click(function(){
					jQuery('.content').trigger("filter", [ jQuery(this).attr('href') ]);
					
					jQuery(settings.tagSelector).removeClass('current');
					jQuery(this).addClass('current');
				});
			}
		});
	}
})(jQuery);


/* Fitvids minified */
(function(a){"use strict";a.fn.fitVids=function(b){var c={customSelector:null},d=document.createElement("div"),e=document.getElementsByTagName("base")[0]||document.getElementsByTagName("script")[0];return d.className="fit-vids-style",d.innerHTML="&shy;<style>               .fluid-width-video-wrapper {                 width: 100%;                              position: relative;                       padding: 0;                            }                                                                                   .fluid-width-video-wrapper iframe,        .fluid-width-video-wrapper object,        .fluid-width-video-wrapper embed {           position: absolute;                       top: 0;                                   left: 0;                                  width: 100%;                              height: 100%;                          }                                       </style>",e.parentNode.insertBefore(d,e),b&&a.extend(c,b),this.each(function(){var b=["iframe[src*='player.vimeo.com']","iframe[src*='www.youtube.com']","iframe[src*='www.youtube-nocookie.com']","iframe[src*='www.kickstarter.com']","object","embed"];c.customSelector&&b.push(c.customSelector);var d=a(this).find(b.join(","));d.each(function(){var b=a(this);if(!("embed"===this.tagName.toLowerCase()&&b.parent("object").length||b.parent(".fluid-width-video-wrapper").length)){var c="object"===this.tagName.toLowerCase()||b.attr("height")&&!isNaN(parseInt(b.attr("height"),10))?parseInt(b.attr("height"),10):b.height(),d=isNaN(parseInt(b.attr("width"),10))?b.width():parseInt(b.attr("width"),10),e=c/d;if(!b.attr("id")){var f="fitvid"+Math.floor(999999*Math.random());b.attr("id",f)}b.wrap('<div class="fluid-width-video-wrapper"></div>').parent(".fluid-width-video-wrapper").css("padding-top",100*e+"%"),b.removeAttr("height").removeAttr("width")}})})}})(jQuery);

/* ScrollToTop */
jQuery(document).ready(function($){
	$(window).scroll(function(){
		if ($(this).scrollTop() > 100) {
			$('.scrollup').fadeIn();
		} else {
			$('.scrollup').fadeOut();
		}
	});
	$('.scrollup').click(function(){
		$("html, body").animate({ scrollTop: 0 }, 600);
		return false;
	});
});

/* Mobile Menu */
jQuery(document).ready(function($){
	/* prepend menu icon */
	$('.site-title').append('<div id="mobi-menu"></div>');

	/* toggle nav */
	$("#mobi-menu").on("click", function(){
		$("#nav_menu-2").slideToggle();
		$(this).toggleClass("active");
	});
});