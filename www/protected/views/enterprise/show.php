<!--banner-->
<div class="imgtop">
   <img src="/images/service/imgtop01.jpg">
</div>


<!--互联网时代专车-->
<div class="showapp">
    <div class="wrapper-width">
        <h3 class="text-center">高效服务，品质保障</h3>
        <p class="text-center"> 更舒适、更便捷、更专业、更安全</p>
        <div class="enterprise-car">
            <img src="/images/enterprise/enterprise1.jpg"> 
        </div>
    </div>
</div>
<div class="clearfix"></div>
<!--app下载-->

	<div class="wrapper-width">
     <div class="enterprise-why-bg">
        <div class="enterprise-title">
            <img src="/images/enterprise/title1.png">
        </div>
        <div class="enterprise-why">           
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="col-md-3">
                            <img src="/images/enterprise/icon1.png">
                        </div>
                        <div class="col-md-9">
                            <h5>专业司机</h5>
                            <p>专业的司机团队，专业的服务培训，10年以上驾龄，安全、服务的保障。</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-3">
                            <img src="/images/enterprise/icon2.png">
                        </div>
                        <div class="col-md-9">
                            <h5>贵宾通道</h5>
                            <p>贵宾通道，无需等待。</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="col-md-3">
                            <img src="/images/enterprise/icon3.png">
                        </div>
                        <div class="col-md-9">
                            <h5>多样车型</h5>
                            <p>舒适、商务、豪华等多样化车型，匹配相对应的需求，按需用车。</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-3">
                            <img src="/images/enterprise/icon4.png">
                        </div>
                        <div class="col-md-9">
                            <h5>VIP尊享</h5>
                            <p>出行礼品及增值服务，尊享VIP。</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="col-md-3">
                            <img src="/images/enterprise/icon5.png">
                        </div>
                        <div class="col-md-9">
                            <h5>专属客服</h5>
                            <p>专属客服团队，为您提供用车需求的解决方案，全流程服务。</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-3">
                            <img src="/images/enterprise/icon6.png">
                        </div>
                        <div class="col-md-9">
                            <h5>合法营运</h5>
                            <p>自主车队，系统管理，合法营运</p>
                        </div>
                    </div>
                </div>               
            </div>
 
    </div>
		
    </div>
</div>

<!-- 你可以这样使用众择 -->


    <div class="wrapper-width padding100">
    <div class="enterprise-user-container">
        <div class="enterprise-use">
            <img src="/images/enterprise/title2.png">
        </div>
        <div class="enterprise-use-img">
            <img src="/images/enterprise/car-yuangong.png"> 
            <img src="/images/enterprise/car-kehu.png"> 
            <img src="/images/enterprise/car-huiyi.png"> 
        </div>
    </div>
    </div>
<div class="clearfix"></div>
<!--service-->

<div class="wrapper-width">
<?php if(Yii::app()->user->isGuest):?>
	<div class="enterprise-login">
		<h3 class="text-center">| 企业用户登录 |</h3>

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
					           'class' =>"col-sm-4 control-label"
					       ]);
					    ?>
						<div class="col-sm-4">
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
						      'class' => 'col-sm-4 errtxt'
						  ]); 
						?>
					</div>
					<div class="form-group">
						<?php 
					       echo $form->label($model, 'password', [
					           'class' =>"col-sm-4 control-label"
					       ]);
					    ?>
						<div class="col-sm-4">
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
						      'class' => 'col-sm-4 errtxt'
						  ]); 
						?>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-4">
							<div class="checkbox">
								<label> <?php echo $form->checkbox($model, 'rememberMe');?> 记住我 </label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-4">
                            <?php 
                                echo CHtml::submitButton('确定', [
                                    'class' => 'btn btn-block btn-info'
                                ]); 
                            ?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-4">
							<a class="btn btn-default col-sm-5" href="/register">用户注册</a>
							<button type="button"
								class="btn btn-default col-sm-offset-2 col-sm-5">忘记密码</button>
						</div>
					</div>
                <?php $this->endWidget(); ?>
	</div>
	<?php endif;?>
</div>
<div class="clearfix"></div>