(function($){
	$._={id:'#jxwait',ret:0};
	$.api={
		init:function(J){
			if(!$._.APIset&&typeof(APIset)!="undefined"&&APIset!==null){
				$.extend($.api,APIset);
				$._.APIset=true;
			}
			if(J.er)
				$.api.msg(J.er);
			if(J.Fs)
				$.each(J.Fs,function(){
					$.api[this.Fn](this.Cn);
				});
		},
		msg:function(_){
			alert(_);
		},
		loading:function(_){
			if(!_.a)
				$($._.id)[_]().removeClass().animate({'height':'toggle','opacity':'toggle'},'slow').find('span').text('loading');
			else{
				$($._.id).addClass(_.a).find('span').text(_.t);
			}
		},
		vpbox:function(_){
			$.vpbox(_);
		},
		pipe:function(_){
			if(typeof(_.APIset)!="undefined")
				$.extend($.api,_.APIset);
			if(typeof(_.rollSet)!="undefined")
				$.extend($.api.rollback,_.rollSet);
		},
		rollback:{}
	};
	
	$.API=function(__,_,___){
		var y=typeof(_)!='undefined'?true:false;
		if($._._==__)
			return false;
		else
			$._._=__;
		if(y&&!$._.ret)
			$.api.loading('hide');
		
		$.ajax({type:'POST',timeout:5000,url:'/V3/API/API.php',data:__,dataType:'json',
			
			success:function(x){
				if(y)
					$.api.loading('show');
				$._._='';
				$.api.init(x);
			},
			error:function(){
				if($._.ret<2){
					$._.ret++;
					var l = {a:'t'+$._.ret,t:$._.ret==2?'Trying for the last time.':'Trying again.'};
					if(y)$.api.loading(l);
					$.API($._._+'&',_);
				}else{
					$._.ret=0;
					if(y){
						if(typeof(__)!='undefined')
							if(jQuery.isFunction($.api.rollback[__]))
								$.api.rollback[__]($._._);
						alert('Please try again later.');
						$.api.loading('show');
					}
				}
			}
		});
	};
})(jQuery);