<div class="loginimg">
	<div class="wrapper-width">
	<div class="login-right">
		<ul class="logintop">
			<li <?php if(!isset($_GET['type'])) echo 'class="loginhover"';?>>密码登录</li>
			<li <?php if(isset($_GET['type'])) echo 'class="loginhover"';?>>手机验证码登录</li>
		</ul>
		<div class="loginbottom">
			<!-- 1 -->
			<div <?php echo isset($_GET['type']) ? 'class="loginhide"' : '';?>>
				<?php
                    $form = $this->beginWidget('CActiveForm', [
                        'id' => 'login-pwd',
                        'enableClientValidation' => true,
                        'action' => '/login',
                        'clientOptions' => [
                            'validateOnSubmit' => true
                        ],
                        'htmlOptions' => [
                            'class' => 'form-horizontal'
                        ]
                    ]);
                ?>
					<div class="form-group ">
						<div class="col-sm-12">
						    <?php
						      echo $form->telField($model, 'username', [
						          'class' => 'form-control',
						          'placeholder' => '手机号'
						      ]);
						    ?>
						</div>
						<?php
						  echo $form->error($model,'username',[
						      'inputID'=>'custom-id',
						      'class' => 'col-sm-12 errtxt'
						  ]);
						?>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
							<?php
						      echo $form->passwordField($model, 'password', [
						          'class' => 'form-control',
						          'placeholder' => '密码'
						      ]);
						    ?>
						</div>
						<?php
						  echo $form->error($model,'password',[
						      'inputID'=>'custom-id',
						      'class' => 'col-sm-12 errtxt'
						  ]);
						?>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
							<div class="checkbox">
								<label> <?php echo $form->checkbox($model, 'rememberMe');?> 记住我 </label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
                            <?php
                                echo CHtml::submitButton('确定', [
                                    'class' => 'btn btn-block btn-info'
                                ]);
                            ?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">

							<a class="btn btn-default col-sm-5" href="/register">用户注册</a>
							<a href="/getpass" class="btn btn-default col-sm-offset-2 col-sm-5">忘记密码</a>
						</div>
					</div>
                <?php $this->endWidget(); ?>
			</div>


			<div <?php echo !isset($_GET['type']) ? 'class="loginhide"' : '';?>>
				<div>
				<?php
                    $form = $this->beginWidget('CActiveForm', [
                        'id' => 'login-code',
                        'enableClientValidation' => true,
                        'action' => '/login?type=1',
                        'clientOptions' => [
                            'validateOnSubmit' => true
                        ],
                        'htmlOptions' => [
                            'class' => 'form-horizontal'
                        ]
                    ]);
                ?>
					<div class="form-group ">
						<div class="col-sm-12">
						    <?php
						      echo $form->telField($model, 'username', [
						          'id' => 'mobile',
						          'class' => 'form-control',
						          'placeholder' => '手机号'
						      ]);
						    ?>
						</div>
						<?php
						  echo $form->error($model,'username',[
						      'inputID'=>'custom-id',
						      'class' => 'col-sm-12 errtxt'
						  ]);
						?>
					</div>
					<div class="form-group">
						<div class="col-sm-7">
							<?php
						      echo $form->passwordField($model, 'password', [
						          'class' => 'form-control',
						          'placeholder' => '验证码'
						      ]);
						    ?>
						</div>
						<div class="col-sm-5">
						    <input type="button" class="btn btn-block btn-default getcode" mobile="enter" value="获取验证码" />
						</div>
						<?php
						  echo $form->error($model,'password',[
						      'inputID'=>'custom-id',
						      'class' => 'col-sm-12 errtxt'
						  ]);
						?>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
                            <?php
                                echo CHtml::submitButton('确定', [
                                    'class' => 'btn btn-block btn-info'
                                ]);
                            ?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
							<a class="btn btn-default col-sm-12" href="/register">用户注册</a>
						</div>
					</div>
                <?php $this->endWidget(); ?>
			</div>

			</div>
		</div>
	</div>
	<div class="login-left">
	<div class="login-head">
        <h3 class="text-center">欢迎使用众择用车</h3>
        <p class="text-center">让出行轻松一些</p>
    </div>
    </div>
</div>
<div class="clearfix"></div>
</div>
<script type="text/javascript" src="/js/jquery.validate.min.js"></script>
<script>
$.validator.addMethod("isMobile", function(value, element) {
	var length = value.length;
	var mobile = /^(?:(?:1(?:3[4-9]|5[012789]|8[78])\d{8}|1(?:3[0-2]|5[56]|8[56])\d{8}|18[0-9]\d{8}|1[35]3\d{8})|14[57]\d{8}|170[059]\d{7}|17[67]\d{8})$/;
	return this.optional(element) || (length == 11 && mobile.test(value));
	}, "请正确填写您的手机号码！");

$.validator.addMethod("checkMobile", function(value, element, param) {
	var result = false;
	$.ajax({
	    type: 'POST',
	    async: false,
	    url: '/jsonp/checkmobile',
	    data: {'mobile':value},
	    success: function(data){
    		switch (data) {
    		    case '1':
    			    //手机号码不存在
    		        break;
    		    case '2':
    			    //手机号码存在且已设置密码
    			    result = true;
    			    break;
    			    //手机号码存在但没设置密码
    		    case '3':
        		    if (param.usepwd) {
        		    	$.validator.messages.checkMobile = '未设置密码，请手机验证码登录后设置密码！';
            		} else {
            			result = true;
                	} 		    	
    			    break;
    		}
    	}
	});
	return this.optional(element) || result;
	}, '手机号码不存在！');

$("#login-pwd").validate({
	onfocusout: function(element){
        $(element).valid();
    },
  rules: {
	'LoginForm[username]':{
		required: true,
		isMobile: true,
		checkMobile:{'usepwd':true},
	},
    'LoginForm[password]': {
    	required: true,
    }
  },
  messages: {
	  'LoginForm[username]': {
		  required:'手机号码不能为空！'
	},
	'LoginForm[password]': {
		   required: '密码不能为空！',
	   }
  }
});

$("#login-code").validate({
	onfocusout:false,
	  rules: {
		  'LoginForm[username]':{
				required: true,
				isMobile: true,
				checkMobile:{'usepwd':false},
			},
		   'LoginForm[password]': {
			   required: true,
		   }
	  },
	  messages: {
		  'LoginForm[username]': {
			  required: '手机号码不能为空！'
		  },
		  'LoginForm[password]': {
			   required: '验证码不能为空！',
		   }
		}
	});


var wait=<?php echo VERIFY_CODE_RESEND;?>;
function time(o) {
    if (wait == 0) {
        o.removeAttribute("disabled"); 
        o.value="获取验证码";
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
	mobile = $("#mobile").val();
	if ($("#mobile").valid()) {
		time(this);
		$.post('/jsonp/sendcode',{'mobile':mobile},function(data){
		    error_code = data.error_code;
		},'json');
	}	
});
</script>