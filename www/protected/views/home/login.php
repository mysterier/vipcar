<div class="loginimg">
	<div class="wrapper-width">
	<div class="login-right">
		<ul class="logintop">
			<li <?php if(!isset($_GET['type'])) echo 'class="loginhover"';?>>个人用户</li>
			<li <?php if(isset($_GET['type'])) echo 'class="loginhover"';?>>企业用户</li>
		</ul>
		<div class="loginbottom">
			<!-- 1 -->
			<div <?php echo isset($_GET['type']) ? 'class="loginhide"' : '';?>>
				<?php
                    $form = $this->beginWidget('CActiveForm', [
                        'id' => 'login-form',
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