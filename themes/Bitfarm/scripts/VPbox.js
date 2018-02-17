(function($){
	$.vpbox = function(_){
			  	$.vpbox.__(_);
			  }
	$.extend(
			$.vpbox,
			{opt:{
				ver : "0.6",
				id  : "#vpbox",
				int : ""
				},
			p:function(){
				var id = $.vpbox.opt.id;
				$(id).css({left:$(window).width()/2-($(id).width()/2),top:(H()/2-($(id).height()/2))});
			},
			__:function(data){
					var id = $.vpbox.opt.id;
					_();
					$(id+' .content').empty().append(data).parent().show().css({left:$(window).width()/2-($(id).width()/2),top:(H()/2-($(id).height()/2))});
					$.vpbox.opt.int = setInterval("$.vpbox.p()",800);
				},
			_:function(){
					var id = $.vpbox.opt.id;
					clearInterval($.vpbox.opt.int);
					$(id).fadeOut(function() {$(id+' .content').empty();});
				}
			}
	);
	function _(){
		if($.vpbox.opt.set)return true;
		$.vpbox.opt.set = true;
		$('body').append("<div id='vpbox'><div class='content'></div></div>");
		new Image().src = '/pic/loading.gif';
	}
	function H(){
		var _;
		if(self.innerHeight){
			_=self.innerHeight;
		}else if(document.documentElement&&document.documentElement.clientHeight){
			_ = document.documentElement.clientHeight;
		}else if(document.body){
			_ = document.body.clientHeight;
		}
		return _;
	}
})(jQuery);