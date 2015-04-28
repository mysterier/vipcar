<!--banner-->
<?php include __DIR__ . '/../home/_banner.php';?>


<!--互联网时代专车-->
<div class="showapp">
	<div class="wrapper-width">
		<h3 class="text-center">| 互联网时代专车 |</h3>
		<div class="enterprise-car">
			<div class="col-md-4 ">
				<img src="/img/enterprisecar1.jpg">
				<h4 class="text-center">私家车</h4>
				<p class="text-center">城市限流 外牌入市难 停车难度增大 养车成本增加</p>
			</div>
			<div class="col-md-4">
				<img src="/img/enterprisecar1.jpg">
				<h4 class="text-center">普通拼车、打车软件</h4>
				<p class="text-center">非专业司机多 车辆供不应求 服务不到位 国家不认可</p>
			</div>
			<div class="col-md-4">
				<img src="/img/enterprisecar1.jpg">
				<h4 class="text-center">众择用车</h4>
				<p class="text-center">贴心服务 免费保险 专业司机 车型多样</p>
			</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>
<!--app下载-->
<div class="enterprise-why-bg">
	<div class="wrapper-width">
		<h3 class="text-center">| 为什么选择众择 |</h3>
		<div class="enterprise-why">
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-6">
						<div class="col-md-3">
							<img src="/img/enterprisewhy1.png">
						</div>
						<div class="col-md-9">
							<h5>里程无忧</h5>
							<p>接送服务包含50公里及2小时使用，完全满足市区往返机场的距离。</p>
						</div>
					</div>
					<div class="col-md-6">
						<div class="col-md-3">
							<img src="/img/enterprisewhy2.jpg">
						</div>
						<div class="col-md-9">
							<h5>智能接机</h5>
							<p>网页和手机APP均可下单快捷接机</p>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="col-md-6">
						<div class="col-md-3">
							<img src="/img/enterprisewhy3.jpg">
						</div>
						<div class="col-md-9">
							<h5>延误无忧</h5>
							<p>延误所造成的等待时间，我们不会计入费用。</p>
						</div>
					</div>
					<div class="col-md-6">
						<div class="col-md-3">
							<img src="/img/enterprisewhy4.jpg">
						</div>
						<div class="col-md-9">
							<h5>快捷支付</h5>
							<p>绑定信用卡或用支付宝给您的账户充值，您也可以先用车、后付费。</p>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="col-md-6">
						<div class="col-md-3">
							<img src="/img/enterprisewhy5.jpg">
						</div>
						<div class="col-md-9">
							<h5>为他人订车</h5>
							<p>您可以再这里给TA人订车，给TA送去一份惊喜和便捷。</p>
						</div>
					</div>
					<div class="col-md-6">
						<div class="col-md-3">
							<img src="/img/enterprisewhy6.jpg">
						</div>
						<div class="col-md-9">
							<h5>举牌服务</h5>
							<p>免费为客户制作接机牌，免费代客举牌，方便用户联系。</p>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="col-md-6">
						<div class="col-md-3">
							<img src="/img/enterprisewhy7.jpg">
						</div>
						<div class="col-md-9">
							<h5>专业司机</h5>
							<p>为您提供服务的均来自上午租车领域，且驾龄超过10年的专业司机。</p>
						</div>
					</div>
					<div class="col-md-6">
						<div class="col-md-3">
							<img src="/img/enterprisewhy8.jpg">
						</div>
						<div class="col-md-9">
							<h5>车型多样</h5>
							<p>将满足您呢对舒适度的不同要求来匹配您的旅程。</p>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="col-md-6">
						<div class="col-md-3">
							<img src="/img/enterprisewhy9.jpg">
						</div>
						<div class="col-md-9">
							<h5>贴心提醒</h5>
							<p>全程短信免费提醒，让您安享贴心旅程。</p>
						</div>
					</div>
					<div class="col-md-6">
						<div class="col-md-3">
							<img src="/img/enterprisewhy10.jpg">
						</div>
						<div class="col-md-9">
							<h5>免费保险</h5>
							<p>每当您预定完成一次，所有乘客即获1份高额意外保险。</p>
						</div>
					</div>
				</div>
			</div>

		</div>

	</div>
</div>
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