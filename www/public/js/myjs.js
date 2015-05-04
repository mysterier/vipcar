$(function(){
		//导航顶		 
		var navH = $("#nav").offset().top; 
		//滚动条事件 
		$(window).scroll(function(){ 
		//获取滚动条的滑动距离 
		var scroH = $(this).scrollTop(); 
		//滚动条的滑动距离大于等于定位元素距离浏览器顶部的距离，就固定，反之就不固定 
		if(scroH>=navH){ 
		$("#nav").css({"position":"fixed","top":"0","left":"0","border-top":"4px solid #2e313b","height":"94px"}); 
		}else if(scroH<navH){ 
		$("#nav").css({"position":"static","margin":"0 auto"}); 
		} 
		}) ;

//banner
	 $(".banner .imglist").eq(0).show().siblings("div").hide();
		$(".banner .banner-btn li").mouseover(function(){
				clearInterval(timer);//当鼠标滑动时，则停止定时任务
				var _index = $(this).index();//获取当前索引（相对应的位置）
				/*当鼠标滑动到li相对应的位置上面，则添加一个样式（小圆点）*/
				$(this).addClass("banner-hover").siblings().removeClass("banner-hover");
				/*相对应的背景图片显示和隐藏*/
				$(".banner .imglist").eq(_index).fadeIn(1000).siblings("div").fadeOut(1000);
		}).mouseout(function(){
			 autoplay();//当鼠标离开时，则执行定时任务
			});
		 var _index = 0;
		 var timer = null;
		 /*定义一个定时任务*/
		 function autoplay(){
			timer=setInterval(function(){
				 _index++;
				  if(_index<4){
					$(".banner .banner-btn li").eq(_index).addClass("banner-hover").siblings().removeClass("banner-hover");
					$(".banner .imglist").eq(_index).fadeIn(1000).siblings("div").fadeOut(1000);
				  }else{_index=-1;}
						
				},3000); 
		 };
		 autoplay();


		 
		<!--tab-->		 
		var tab_li = $('.login ul li');
			tab_li.click(function(){
				$(this).addClass('loginhover').siblings().removeClass('loginhover');
				var index = tab_li.index(this);
				$('.loginbottom > div').eq(index).show().siblings().hide();
			});	


		var $tab_li = $('.account-tab ul li');
			$tab_li.click(function(){
				$(this).addClass('account-tab-hover').siblings().removeClass('account-tab-hover');
				var index = $tab_li.index(this);
				$('.account-container > div').eq(index).show().siblings().hide();
			});	

				
			
		<!--date-->		
//		 $('#datetimepicker').datetimepicker({
//		    format: 'yyyy-dd-mm'
//		});

});