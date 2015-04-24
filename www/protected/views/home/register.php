<div class="registerimg">
	<div class="logintitle">
		<h3>注册</h3>
		<p>欢迎使用 众择用车，轻触按钮即可获取轻松出行的最佳之选。创建帐户，几分钟后即可出行。</p>
	</div>
	<div class="login">
		<ul class="logintop">
			<li <?php if(!isset($show_enter)) echo 'class="loginhover"';?>>个人用户</li>
			<li <?php if(isset($show_enter)) echo 'class="loginhover"';?>>企业用户</li>
		</ul>
		<h3>注册</h3>
		<div class="loginbottom">
			<div <?php echo isset($show_enter) ? 'class="loginhide"' : '';?>>
				<?php
                    $form = $this->beginWidget('CActiveForm', [
                        'id' => 'login-form',
                        'enableClientValidation' => true,
                        'action' => '/regperson',
                        'clientOptions' => [
                            'validateOnSubmit' => true
                        ],
                        'htmlOptions' => [
                            'class' => 'form-horizontal'
                        ]
                    ]);
                ?>
					<div class="form-group"> 
						<label for="" class="col-sm-2 control-label">注册信息</label>
					</div>
					<div class="form-group">
					    <?php 
					       echo $form->label($model, 'mobile', [
					           'class' =>"col-sm-3 control-label"
					       ]);
					    ?>
						<div class="col-sm-5">
							<?php 
						      echo $form->telField($model, 'mobile', [
						          'class' => 'form-control',
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
					           'class' =>"col-sm-3 control-label"
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
						<?php 
						  echo $form->error($model,'msg_code',[
						      'inputID'=>'custom-id',
						      'class' => 'col-sm-3 errtxt'
						  ]); 
						?>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-block btn-default">获取短信验证码</button>
						</div>
					</div>
					<div class="form-group">
						<?php 
					       echo $form->label($model, 'password', [
					           'class' =>"col-sm-3 control-label"
					       ]);
					    ?>
						<div class="col-sm-5">
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
						      'class' => 'col-sm-3 errtxt'
						  ]); 
						?>
					</div>
					<div class="form-group">
						<?php 
					       echo $form->label($model, 'confirmpwd', [
					           'class' =>"col-sm-3 control-label"
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
						  echo $form->error($model,'confirmpwd',[
						      'inputID'=>'custom-id',
						      'class' => 'col-sm-3 errtxt'
						  ]); 
						?>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">个人信息</label>
					</div>
					<div class="form-group">
						<?php 
					       echo $form->label($model, 'real_name', [
					           'class' =>"col-sm-3 control-label"
					       ]);
					    ?>
						<div class="col-sm-5">
							<?php 
						     echo $form->textField($model, 'real_name', [
						          'class' => 'form-control',
						          'placeholder' => '姓名'
						      ]);
						    ?>
						</div>
						<label class="col-sm-2"> 
						      <input name="Clients[client_title]" type="radio" value="1"> 先生
						</label> 
						<label class="col-sm-2"> 
						      <input name="Clients[client_title]" type="radio" value="2"> 女士
						</label>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-9">
							<div class="checkbox">
								<label> <?php echo $form->checkbox($model, 'agreeme');?>  我已阅读并同意<span>众择用车</span> </label>
							</div>
							<?php 
    						  echo $form->error($model,'agreeme',[
    						      'inputID'=>'custom-id',
    						      'class' => 'col-sm-3 errtxt'
    						  ]); 
    						?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-9">
							<button type="submit" class="btn btn-block btn-info">注册</button>
						</div>
						<div class="clearfix"></div>
					</div>
				<?php $this->endWidget(); ?>
			</div>
			<!--2-->
			<div <?php echo !isset($show_enter) ? 'class="loginhide"' : '';?>>
				<div>
					<?php
                        $form = $this->beginWidget('CActiveForm', [
                            'id' => 'login-form',
                            'enableClientValidation' => true,
                            'action' => '/regenter',
                            'clientOptions' => [
                                'validateOnSubmit' => true
                            ],
                            'htmlOptions' => [
                                'class' => 'form-horizontal'
                            ]
                        ]);
                    ?>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">账号信息</label>
						</div>
						<div class="form-group">
							<?php 
					       echo $form->label($item, 'originator', [
					           'class' =>"col-sm-3 control-label"
					       ]);
					    ?>
						<div class="col-sm-5">
							<?php 
						      echo $form->textField($item, 'originator', [
						          'class' => 'form-control',
						          'placeholder' => '创始人'
						      ]);
						    ?>
						</div>
						<?php 
						  echo $form->error($item,'originator',[
						      'inputID'=>'custom-id',
						      'class' => 'col-sm-3 errtxt'
						  ]); 
						?>
						</div>
						<div class="form-group">
    					    <?php 
    					       echo $form->label($model, 'mobile', [
    					           'class' =>"col-sm-3 control-label"
    					       ]);
    					    ?>
    						<div class="col-sm-5">
    							<?php 
    						      echo $form->telField($model, 'mobile', [
    						          'class' => 'form-control',
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
    					           'class' =>"col-sm-3 control-label"
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
    						<?php 
    						  echo $form->error($model,'msg_code',[
    						      'inputID'=>'custom-id',
    						      'class' => 'col-sm-3 errtxt'
    						  ]); 
    						?>
    						<div class="col-sm-4">
    							<button type="submit" class="btn btn-block btn-default">获取短信验证码</button>
    						</div>
    					</div>
						<div class="form-group">
							<?php 
    					       echo $form->label($model, 'password', [
    					           'class' =>"col-sm-3 control-label"
    					       ]);
    					    ?>
    						<div class="col-sm-5">
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
    						      'class' => 'col-sm-3 errtxt'
    						  ]); 
    						?>
						</div>
						<div class="form-group">
    						<?php 
    					       echo $form->label($model, 'confirmpwd', [
    					           'class' =>"col-sm-3 control-label"
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
    						  echo $form->error($model,'confirmpwd',[
    						      'inputID'=>'custom-id',
    						      'class' => 'col-sm-3 errtxt'
    						  ]); 
    						?>
    					</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">企业信息</label>
						</div>
						<div class="form-group">
							<?php 
					       echo $form->label($item, 'company_name', [
					           'class' =>"col-sm-3 control-label"
					       ]);
					    ?>
						<div class="col-sm-5">
							<?php 
						      echo $form->textField($item, 'company_name', [
						          'class' => 'form-control',
						          'placeholder' => '企业名称'
						      ]);
						    ?>
						</div>
						<?php 
						  echo $form->error($item,'company_name',[
						      'inputID'=>'custom-id',
						      'class' => 'col-sm-3 errtxt'
						  ]); 
						?>
						</div>
						<div class="form-group">
							<?php 
					       echo $form->label($model, 'email', [
					           'class' =>"col-sm-3 control-label"
					       ]);
					    ?>
						<div class="col-sm-5">
							<?php 
						      echo $form->textField($model, 'email', [
						          'class' => 'form-control',
						          'placeholder' => '邮箱'
						      ]);
						    ?>
						</div>
						<?php 
						  echo $form->error($model,'email',[
						      'inputID'=>'custom-id',
						      'class' => 'col-sm-3 errtxt'
						  ]); 
						?>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">所在地</label>
							<div class="col-sm-2">
								<select id="s_province" class="form-control" name="ClientItems[area][]"></select>
							</div>
							<div class="col-sm-2">
								<select id="s_city" class="form-control" name="ClientItems[area][]" ></select>
							</div>
							<div class="col-sm-2">
								<select id="s_county" class="form-control" name="ClientItems[area][]"></select>
							</div>
						</div>
						<div class="form-group">
							<?php 
    					       echo $form->label($item, 'address', [
    					           'class' =>"col-sm-3 control-label"
    					       ]);
    					    ?>
    						<div class="col-sm-5">
    							<?php 
    						      echo $form->textField($item, 'address', [
    						          'class' => 'form-control',
    						          'placeholder' => '公司地址'
    						      ]);
    						    ?>
    						</div>
    						<?php 
    						  echo $form->error($item,'address',[
    						      'inputID'=>'custom-id',
    						      'class' => 'col-sm-3 errtxt'
    						  ]); 
    						?>
						</div>
						<div class="form-group">
							<?php 
    					       echo $form->label($item, 'tel', [
    					           'class' =>"col-sm-3 control-label"
    					       ]);
    					    ?>
    						<div class="col-sm-5">
    							<?php 
    						      echo $form->textField($item, 'tel', [
    						          'class' => 'form-control',
    						          'placeholder' => '固定电话'
    						      ]);
    						    ?>
    						</div>
    						<?php 
    						  echo $form->error($item,'tel',[
    						      'inputID'=>'custom-id',
    						      'class' => 'col-sm-3 errtxt'
    						  ]); 
    						?>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-9">
    							<div class="checkbox">
    								<label> <?php echo $form->checkbox($model, 'agreeme');?>  我已阅读并同意<span>众择用车</span> </label>
    							</div>
    							<?php 
        						  echo $form->error($model,'agreeme',[
        						      'inputID'=>'custom-id',
        						      'class' => 'col-sm-3 errtxt'
        						  ]); 
        						?>
    						</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-9">
								<button type="submit" class="btn btn-block btn-info">注册</button>
							</div>
							<div class="clearfix"></div>
						</div>
					<?php $this->endWidget(); ?>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="/js/area.js"></script>
<script type="text/javascript">_init_area();</script>