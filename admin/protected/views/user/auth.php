<form method="post" action="/user/modifyauth">
<fieldset>
<div class="form-group">
    <label>角色名称:</label>
    <select id="role" name="role">
    <?php foreach($roles as $role_name):?>
        <option value="<?php echo $role_name;?>" <?php if($role == $role_name) echo 'selected';?>><?php echo $role_name;?></option>
    <?php endforeach;?>
    </select>
    <a href="/user/createrole" title="新增角色" aria-hidden="true" class="glyphicon glyphicon-plus"></a>
    <a id="delrole" href="#" title="删除角色" aria-hidden="true" class="glyphicon glyphicon-minus"></a>
</div>
<?php foreach($task_operation as $operation):?>
<?php $task_name = array_shift($operation);if($operation):?>
<div class="form-group" style="float: left;margin-right:100px;">
    <label><?php echo $task_name;?></label>
    <?php foreach($operation as $key => $value):?>
	<div class="checkbox">
        <label>
            <input type="checkbox" name="auth_operations[]" value="<?php echo $key;?>" <?php if(in_array($key, $children)) echo 'checked';?>> <?php echo $value;?>
        </label>
    </div>
    <?php endforeach;?>
</div>
<?php endif;endforeach;?>
</fieldset>
<div class="form-actions">
    <input type="submit" value="提交" />
</div>
</form>
<script>
$("#role").change(function(){
	role = $(this).val();
	window.location.href="/user/auth?role="+role;
});

$("#delrole").click(function(){
	choice = confirm("您确认要删除该角色吗？");
	if (choice) {
		role = $("#role").val();
		window.location.href="/user/delrole?role="+role;
	}
});
</script>