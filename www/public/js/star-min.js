$(function(){$(document).on("mouseover","i[cjmark]",function(){var a=$(this).index(),b=$(this).parents(".revinp");if(1==b.attr("status"))return!1;for(var c=$(this).parent().find("i"),d=0;a>=d;d++)c.eq(d).attr("class","level_solid");for(var d=a+1,e=c.length-1;e>=d;d++)c.eq(d).attr("class","level_hollow")}),$(document).on("click","i[cjmark]",function(){var a=$(this).index(),b=$(this).parents(".revinp"),c=b.attr("order_id");return 1==b.attr("status")?!1:(b.attr("status","1"),$.post("/jsonp/comment",{star:a+1,order_id:c},function(){}),void 0)})});