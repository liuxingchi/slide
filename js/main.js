define(function(require,exports,module){
	require.async(['zepto'],function($){
		$('.wrapper').on('tap','.btn',function(){
			$(this).parent().find('.btn').removeClass('act');
			$(this).addClass('act');
			var allscore = 0;
			if($(this).parent().index()===$('.imgbox').length-1-$('.imgbox.end').length){
				$('.btn.act').each(function(){
					allscore += parseFloat($(this).attr('score'));
				})
				console.log(allscore);
				$.ajax({
					type:"GET",
					url:'actions.php?action=showResult&allscore='+allscore,
					dataType:"json",
					timeout:5000,
					cache:true,
					async:true,
					success: function (data, textStatus) {

					data = data[0];
//					alert(data.desc);
						if(!$('.imgbox.end').length)
						$('.outbox').append("<div class='imgbox end'><a href='javascript:void(0)'><img  url='upload/"+data.url+"'  class='mainpic'></div></a>");
						else{
							$('.end a img').attr('url','upload/'+data.url);

						}
						if(!LorT){
							$('.outbox').css('width',W*$('.imgbox').length+'rem');
						}else{
							$('.outbox').css('height',H*$('.imgbox').length+'rem');
						}
						move(1);
						//setTimeout("showPage()",2000);
						$('.imgbox.end').click(showPage);
						$('#pageImage').css({'right':L+'rem','width':W+'rem','height':H+'rem'});
						config.descMessage = data.desc;
						config.titleline = data.desc;
						WeiXinJSSDKSet(config);
						},
					error: function(XMLHttpRequest, textStatus, errorThrown) {}
				});
			}else{
				console.log(index);
				move(1);
			}
		})
		var pt = ($(window).height() - 1100)/200,W = 7.2,H = 11,L = 0,BI = 1;
		$('.wrapper').css({ 'padding-top':pt+'rem'});
		if($(window).width()/$(window).height()>72/110){
			H = $(window).height()/100;
			W = H*72/110;
			L = (7.2 - W)/2;
			BI = W/7.2;
		}
		$('body').append('<style>.oflow,.outbox .imgbox,.imgbox .mainpic{width:'+W+'rem;height:'+H+'rem}.oflow{margin-left:'+L+'rem}</style>')
//		$('.oflow').css({'width':W+'rem','height':H+'rem','margin-left':L+'rem'});
//		$('.imgbox,.mainpic').css({'width':W+'rem','height':H+'rem'});

		var index = 0,
			LorT = parseInt($('.wrapper').attr('moveto'))?true:false,
			movefun = function(){
				$('.lodding').show();
				var ready = 0;
				var leng = $('.imgbox').eq(index).find('[url]').each(function(i,o){
					var newimg = new Image();
					var this_ = $(this);
					newimg.onload = function(){
						newimg.onload = null;
						ready ++;
						if(i>0){
							$(o).css({'width':this.width/100+'rem','height':this.height/200+'rem','background':'url('+this.src+') no-repeat','background-size':'100% 200%'});
						}else{
							$(o).attr('src',this.src);
						}
						if(LorT){
							$('.outbox').css({'top':-(index*H)+'rem'});
						}else{
							$('.outbox').css({'left':-(index*W)+'rem'});
						}
						if(ready===leng&&this_.parents('.imgbox').index()===index){
							$('.imgbox').eq(index).find('.btn').each(function(){

								var left = parseFloat($(this).css('left'))*BI;
								var top = parseFloat($(this).css('top'))*BI;
								var width  = $(this).width()*BI/100;
								var height = $(this).height()*BI/100;
								$(this).css({'left':left+'rem','top':top+'rem','width':width+'rem','height':height+'rem','background-size':'100% 200%'});

							})
							$('.lodding').hide();
							$('.imgbox').eq(index).animate({'opacity':'1'},200);
						}
					}
					newimg.src = $(this).attr('url');

				}).length;
			},
			move = function(int){
				if(int>0&&index===$('.imgbox').length-1){
					return;
				}
				if(int<0&&index===0){
					return;
				}
				if(int>0&&$('.imgbox').eq(index).find('.act').length===0){
					return
				}
				index+=int;
				movefun();
			};
            document.addEventListener('touchmove', function (event) {
			event.preventDefault();
			}, false);
			if(LorT){
				$('.outbox').css('height',H*$('.imgbox').length+'rem');
				$('.wrapper').swipeUp(function(){
					move(1);
				});
				$('.wrapper').swipeDown(function(){
					move(-1);
				});
			}else{
				$('.outbox').css('width',W*$('.imgbox').length+'rem');
				$('.wrapper').swipeLeft(function(){
					move(1);
				});
				$('.wrapper').swipeRight(function(){
					move(-1);
				});
			}
		movefun();
	});
});