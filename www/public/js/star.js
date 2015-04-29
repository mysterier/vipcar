$(function(){
	//点星星
	$(document).on('mouseover','i[cjmark]',function(){
		var num = $(this).index();
		var mark = $(this).parents('.revinp');

		if(mark.attr('status')==1) return false;
		
		var list = $(this).parent().find('i');
		for(var i=0;i<=num;i++){
			list.eq(i).attr('class','level_solid');
		}
		for(var i=num+1,len=list.length-1;i<=len;i++){
			list.eq(i).attr('class','level_hollow');
		}
	})
	//点击星星
	$(document).on('click','i[cjmark]',function(){
		var num = $(this).index();
		var mark = $(this).parents('.revinp');
		var order_id = mark.attr('order_id');
		
		if(mark.attr('status')==1){
			return false;	
		}else{
			mark.attr('status', '1');
			$.post('/jsonp/comment', {star:num+1,order_id:order_id}, function(data){

			});
		}
	})
})
