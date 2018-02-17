
/**
 * Version: 1.0.0
 * Copyright: TVCatchup Ltd
 * Author: Mason Jackson (m.jackson@tvcatchup.com)
 * Last update: March 31, 2009
 */

var requiredMajorVersion = 10;
var requiredMinorVersion = 1;
var requiredRevision = 0;

( function($) {
$(document).ready(function() {	

	$(".submit").hover(
		function () {
			$(this).addClass("hover");
		},
		function () {
			$(this).removeClass("hover");
		}
	);

	/* modal window overlay */
	$('<div id="qtip-blanket">').css({
		position: 'absolute',
	    top: $(document).scrollTop(),
	    left: 0,
	    height: $(document).height(),
	    width: '100%',
	    opacity: 0.7,
	    backgroundColor: 'black',
	    zIndex: 5000
	}).appendTo(document.body).hide();

	/* modal window */
	var qtip = $(document.body).qtip({
		content: {
			title: {
	           	text: 'Loading ...',
	           	button: 'Close'
	       	},
	       	text: '<div id=\"modal\">Loading ...</div>'
		},
	    position: {
	       	target: $(document.body),
	       	corner: 'center'
	    },
	    show: false,
	    hide: false,
		style: {
	         width: 600,
	         padding: '14px',
	         border: {
	            width: 9,
	            radius: 9,
	            color: '#666666'
	         },
	         name: 'dark'
		},
	    api: {
	      	beforeShow: function() {
	           	//$('#qtip-blanket').fadeIn(this.options.show.effect.length);
				
				console.log('before show');
	       	},
	       	beforeHide: function() {
	           	//$('#qtip-blanket').fadeOut(this.options.hide.effect.length);
	       	}
		}
	});

	// CHANNELS
	////////////////////////////////////////////////////////////////////////////////////////////////////

	$(".modal").click(function() {

		var channel = $(this).parent().attr("id").replace("ch_", "");
		var content = $("#beta").html().replace(/\?c=1/g, "?c=" + channel);

		var api = $(qtip).qtip("api");
		api.updateTitle("TVCatchup BETA");
		api.updateContent(content);
		api.show();

		return false;

	});
	
	

	// TV GUIDE
	////////////////////////////////////////////////////////////////////////////////////////////////////

	/* <select> */
	$("#days").change(function() {
		location.href = $(this).val();
	});

	/* re-order channels */
	$("#programmes").sortable({
		items: ".row",
		handle: ".logo",
		//containment: "#programmes",
		opacity: 0.6,
		update: function(event, ui) {
			$.ajax({
				type: "POST",
				url: "guide.html",
				data: "order=" + $("#programmes").sortable("toArray"),
				success: function(data, status) {
					//alert(data);
				}
			});
		}
	});

	/* disabled selection */
	$("#programmes").disableSelection();

	/* programmes */
	$(".programme").each(function() {
		$(this).qtip({
			content: {
				text: '<font color="#efefef">' + $(this).find(".tip").html() + '</font>'
			},
			show: 'mouseover',			
			api: {
				onRender: function(){

					/*var self=this;
					var div=$(self.elements.content[0]);
					
					console.log(div.attr('image_name'));
					console.log(div.attr('style'));
					
					
					var img=new Image();
					$(img).load(function() {
						$(this).hide();
						div.removeClass('loading').append(this);
						$(this).fadeIn();
					}).error(function(){
						console.log('error');
					}).attr(
						'src',
						'http://epg-images.tvcatchup.com/epg/' +div.attr('image_name')+ '?width=144&height=81&convertto=3'
					);*/
				}
			},
			hide: 'mouseout',
			position: {
				target: "mouse",
				adjust: {x: 5, y: 5}
			},
			style: {
				padding: 2,
		      	background: '#252525',
		      	color: '#ffffff',
		      	'font-size': '11px',
		      	border: {
		         	width: 7,
		         	radius: 5,
		         	color: '#252525'
		      	},
		      	//tip: true,
		      	name: 'dark'
			}
		});
		
		
		
		/* onclick
		$(this).click(function() {

			var api = $(qtip).qtip("api");
			api.updateTitle($(this).find(".title").html());
			api.show();

			$.get("?modal=1", {
				channel: $(this).find(".channel").html(),
				start: $(this).find(".start").html(),
				end: $(this).find(".end").html()
			}, function(data) {
				$("#modal").html(data);
			});

		});*/

	});
	
	 // Limit title text ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	  $(".textlimit").each(function(){
      len=$(this).text().length;
      if(len>40)
      {
      $(this).text($(this).text().substr(0,40)+'...');
      }
      }); 
	  
	  //Policy popup /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
	  
	  $(document).ready(function() {
		var $dialog = $('<div></div>')
			.html('EU E-Privacy Directive 5(3): This site uses "cookies" that store login details only (no personal data is stored). Such cookies can be blocked using your browser privacy settings but this will significantly affect your enjoyment of this site and is not recommended. Please refer to your browser help feature for more information or our <a href="{$config.url.site}/terms.html" title="Terms Of Service" style="color:#99F127">terms and conditions</a> for more information. No action is required, continued use of this site constitutes your agreement to the use of cookies.')
			.dialog({
				autoOpen: false,
				title: 'Cookie Policy',
				buttons: { "Ok": function() { $(this).dialog("close"); } }
			});

		$('#opener').click(function() {
			$dialog.dialog('open');
			return false;
		});
	});
	
	/*spotlight scroller
		
        $('#slideshow').cycle({
        fx:     'fade',
        pause: 1,
	    pager:  '#inner-slider-nav',
	    prev: '.prev',
	    next: '.next',
        before: function() { 
        $('#caption').html(this.alt);
	    $('#title').html(this.title);
        }
        });
	    $("#slideshow").hover(function() {
	    $("ul#nav").fadein();
	    },
	    function() {
	    $("ul#nav").fadeout();
        });
		
		Spotlight controls*/
		
		$("#mycarousel").jcarousel({
        horizontal: true,
        scroll: 1,
        auto: 5,
        start: 2,
        visible : null,
        wrap: 'circular',
	
       initCallback: mycarousel_initCallback,
        itemLoadCallback: trigger,  	   
		// This tells jCarousel NOT to autobuild prev/next buttons
        buttonNextHTML: null,
        buttonPrevHTML: null

       });
	   
       ////dropdown menu/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//$('body').ready(function() {
		
		$(document).ready(function() {
	
			$('.dropdown').mouseenter(function(e) {
				
				
				if($.browser.msie && $.browser.version.slice(0,3) == ("7.0","8.0")) {

					if(e.target.id && e.target.id=='hoverdown') {
						$(this).find('.sub_nav').slideDown(180);
					}
					
				} else {
					$(this).find('.sub_nav').slideDown(180);
				}

				
			});
			$('.dropdown').mouseleave(function() {
			$(this).find('.sub_nav').slideUp(180); 
			});
		});
	   //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	   
	   function mycarousel_initCallback(carousel) {
	

	
			$('.jcarousel-control a').bind('click', function() {
				carousel.scroll(jQuery.jcarousel.intval(jQuery(this).text()));
				return false;
			});
		
			$('.jcarousel-scroll select').bind('change', function() {
				carousel.options.scroll = jQuery.jcarousel.intval(this.options[this.selectedIndex].value);
				return false;
			});
		
			$('#mycarousel-next').bind('click', function() {
				carousel.next();
				return false;
			});
		
			$('#mycarousel-prev').bind('click', function() {
				carousel.prev();
				return false;
			});
		};
			

		function trigger(carousel, state) {
		
		
			$('#mycarousel').children().each(function(index){
		
				var jcarouselindex=parseInt($(this).attr('jcarouselindex'));
					
				if(carousel.first) {
		
					var second=carousel.first;
					second++;
		
					if(jcarouselindex==second) {
							
						var title=$(this).find(':first-child').attr('title');
						var alt=$(this).find(':first-child').attr('alt');
						// console.log(title+' '+alt);	
						$(".spotlight-title").text(title);
						$(".caption").text(alt);				
						// break;
					
					}
				}
			});
		}

});

} ) ( jQuery );




