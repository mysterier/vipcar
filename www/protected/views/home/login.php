<div class="loginimg">
	<div class="logintitle">
		<h3>登录</h3>
		<p>欢迎使用 众择用车，轻触按钮即可获取轻松出行的最佳之选。创建帐户，几分钟后即可出行。</p>
	</div>

	<div class="login">
		<ul class="logintop">
			<li <?php if(!isset($_GET['type'])) echo 'class="loginhover"';?>>个人用户</li>
			<li <?php if(isset($_GET['type'])) echo 'class="loginhover"';?>>企业用户</li>
		</ul>
		<h3>登录</h3>
		<div class="loginbottom">
			<!-- 1 -->
			<div <?php echo isset($_GET['type']) ? 'class="loginhide"' : '';?>>	
				<?php
                    $form = $this->beginWidget('CActiveForm', [
                        'id' => 'login-form',
                        'enableClientValidation' => true,
                        'clientOptions' => [
                            'validateOnSubmit' => true
                        ],
                        'htmlOptions' => [
                            'class' => 'form-horizontal'    
                        ]
                    ]);
                ?>
					<div class="form-group ">
					    <?php 
					       echo $form->label($model, 'username', [
					           'class' =>"col-sm-3 control-label"
					       ]);
					    ?>
						<div class="col-sm-6">
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
						      'class' => 'col-sm-3 errtxt'
						  ]); 
						?>
					</div>
					<div class="form-group">
						<?php 
					       echo $form->label($model, 'password', [
					           'class' =>"col-sm-3 control-label"
					       ]);
					    ?>
						<div class="col-sm-6">
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
						<div class="col-sm-offset-3 col-sm-6">
							<div class="checkbox">
								<label> <?php echo $form->checkbox($model, 'rememberMe');?> 记住我 </label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-6">
                            <?php 
                                echo CHtml::submitButton('确定', [
                                    'class' => 'btn btn-block btn-info'
                                ]); 
                            ?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-6">

							<a class="btn btn-default col-sm-5" href="/register">用户注册</a>
							<button type="button"
								class="btn btn-default col-sm-offset-2 col-sm-5">忘记密码</button>
						</div>
					</div>
                <?php $this->endWidget(); ?>
			</div>


			<div <?php echo !isset($_GET['type']) ? 'class="loginhide"' : '';?>>
				<div>	
				<?php
                    $form = $this->beginWidget('CActiveForm', [
                        'id' => 'login-form',
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
					    <?php 
					       echo $form->label($model, 'username', [
					           'class' =>"col-sm-3 control-label"
					       ]);
					    ?>
						<div class="col-sm-6">
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
						      'class' => 'col-sm-3 errtxt'
						  ]); 
						?>
					</div>
					<div class="form-group">
						<?php 
					       echo $form->label($model, 'password', [
					           'class' =>"col-sm-3 control-label"
					       ]);
					    ?>
						<div class="col-sm-6">
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
						<div class="col-sm-offset-3 col-sm-6">
							<div class="checkbox">
								<label> <?php echo $form->checkbox($model, 'rememberMe');?> 记住我 </label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-6">
                            <?php 
                                echo CHtml::submitButton('确定', [
                                    'class' => 'btn btn-block btn-info'
                                ]); 
                            ?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-6">
							<a class="btn btn-default col-sm-5" href="/register">用户注册</a>
							<button type="button"
								class="btn btn-default col-sm-offset-2 col-sm-5">忘记密码</button>
						</div>
					</div>
                <?php $this->endWidget(); ?>
			</div>

			</div>
		</div>
	</div>
</div>