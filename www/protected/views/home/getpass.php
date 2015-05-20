<!--account-->
<div class="account">
	<div class="account-right-head">
		<h3>忘记密码</h3>
	</div>
	<div class="account-container">
		<?php
            $form = $this->beginWidget('CActiveForm', [
                'id' => 'login-form',
                'action' => '/getpass',
                'htmlOptions' => [
                    'class' => 'form-horizontal'
                ]
            ]);
        ?>
			<div class="form-group">
			    <?php 
			       echo $form->label($model, 'mobile', [
			           'class' =>"col-sm-2 control-label"
			       ]);
			    ?>
				<div class="col-sm-5">
					<?php 
				      echo $form->telField($model, 'mobile', [
				          'class' => 'form-control person',
				          'placeholder' => '手机号'
				      ]);
				    ?>
				</div>
				<?php 
				  echo $form->error($model,'mobile',[
				      'inputID'=>'custom-id',
				      'class' => 'col-sm-3 errtxt'
				  ]); 
				?>
			</div>

			<div class="form-group">
    			<?php 
    		       echo $form->label($model, 'msg_code', [
    		           'class' =>"col-sm-2 control-label"
    		       ]);
    		    ?>
    			<div class="col-sm-5">
    				<?php 
    			     echo $form->textField($model, 'msg_code', [
    			          'class' => 'form-control',
    			          'placeholder' => '验证码'
    			      ]);
    			    ?>
    			</div>
    			<div class="col-sm-4">
    				<input type="button" class="btn btn-block btn-default getcode" mobile="person" value="获取短信验证码" />
    			</div>
    			<?php 
    			  echo $form->error($model,'msg_code',[
    			      'inputID'=>'custom-id',
    			      'class' => 'col-sm-3 errtxt'
    			  ]); 
    			?>
    		</div>
			<div class="form-group">
    			<?php
                    echo $form->label($model, 'password', [
                        'class' => 'col-sm-2 control-label',
                        'label' => '新密码'
                    ]);
                ?>
                <div class="col-sm-5">
                <?php
                    echo $form->passwordField($model, 'password', [
                        'class' => 'form-control',
                        'placeholder' => '新密码'
                    ]);
                ?>
                </div>
                <?php
                    echo $form->error($model, 'password', [
                        'inputID' => 'custom-id',
                        'class' => 'col-sm-5 errtxt'
                    ]);
                ?>
    		</div>
    		
    		<div class="form-group">
    			<?php
                    echo $form->label($model, 'confirmpwd', [
                        'class' => 'col-sm-2 control-label'
                    ]);
                ?>
                <div class="col-sm-5">
                <?php
                    echo $form->passwordField($model, 'confirmpwd', [
                        'class' => 'form-control',
                        'placeholder' => '确认密码'
                    ]);
                ?>
                </div>
                <?php
                    echo $form->error($model, 'confirmpwd', [
                        'inputID' => 'custom-id',
                        'class' => 'col-sm-5 errtxt'
                    ]);
                ?>
    		</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-5">
					<button type="submit" class="btn btn-info btn-block">确定</button>
				</div>
			</div>
		<?php $this->endWidget(); ?>
	</div>
</div>
<script type="text/javascript">
var wait=<?php echo VERIFY_CODE_RESEND;?>;
function time(o) {
    if (wait == 0) {
        o.removeAttribute("disabled"); 
        o.value="获取短信验证码";
        wait = <?php echo VERIFY_CODE_RESEND;?>;
    } else {
        o.setAttribute("disabled", true);
        o.value="重新发送(" + wait + ")";
        wait--;
        setTimeout(function() {
            time(o)
        },
        1000)
    }
}
$(".getcode").click(function(){
	class_name = $(this).attr('mobile');
    mobile = $("." + class_name).val();
	if (!mobile)
		alert('请先填写手机号码！');
	else {
		time(this);
		$.post('/jsonp/sendcode',{'mobile':mobile},function(data){
		    error_code = data.error_code;
		},'json');
	}	
});
</script>