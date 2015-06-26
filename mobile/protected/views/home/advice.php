<div class="wrapper">
  <form method="post">
    <textarea class="form-control suggest-area" rows="8" name="content"></textarea>
    <button id="orderCommit" type="button" class="btn btn-block brown-btn width98">提交</button>
  </form>
</div>
<script>
$(function(){
	$("#orderCommit").click(function() {
		if($(".suggest-area").val() == '') {
			alertError('内容不能为空！');
		} else {
			$("form").submit();
		}
	});	
});
</script>