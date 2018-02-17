function mainmenu(){
$(" #jCrumbs ul ").css({display: "none"}); // Opera Fix
$(" #jCrumbs li").hover(function(){
		$(this).find('ul:first').css({visibility: "visible",display: "none"}).show(400);
		},function(){
		$(this).find('ul:first').css({visibility: "hidden"});
		});
}

 
 
 $(document).ready(function(){					
	mainmenu();
});