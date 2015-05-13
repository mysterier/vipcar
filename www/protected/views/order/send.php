<div class="jiesongjiimg">
	<div class="wrapper-width">
		<div class="jiejititle">
			<h3>接送机</h3>
			<p>欢迎使用 众择用车，轻触按钮即可获取轻松出行的最佳之选。创建帐户，几分钟后即可出行。</p>
		</div>
		<div class="jieji">
			<ul class="jiejitop">
				<li><a href="/order/pickup">接机</a></li>
				<li class="jiejihover"><a href="/order/send">送机</a></li>
			</ul>
			<h3>接送机</h3>
			<div class=" jiesongjibottom">
				<div>
                    <?php
                        $form = $this->beginWidget('CActiveForm', [
                            'id' => 'address-form',
                            'action' => '/order/send'
                        ]);
                    ?>

					<div class="form-group padnone col-xs-offset-3 col-md-6">
						<div class="input-group">
							<div class="input-group-addon iconfont">&#xf0053;</div>
							<?php 
            			      echo $form->textField($model, 'contacter_name', [
            			          'class' => 'form-control',
            			          'placeholder' => '联系人'
            			      ]);
            			    ?>
						</div>							
					</div>
				    <?php 
        			  echo $form->error($model,'contacter_name',[
        			      'inputID'=>'custom-id',
        			      'class' => 'col-sm-3 errtxt'
        			  ]); 
        			?>
					<div class="form-group padnone col-xs-offset-3 col-md-6">
						<div class="input-group">
							<div class="input-group-addon iconfont">&#xe64a;</div>
							<?php 
            			      echo $form->telField($model, 'contacter_phone', [
            			          'class' => 'form-control',
            			          'placeholder' => '联系电话'
            			      ]);
            			    ?>
						</div>
					</div>
					<?php 
        			  echo $form->error($model,'contacter_phone',[
        			      'inputID'=>'custom-id',
        			      'class' => 'col-sm-3 errtxt'
        			  ]); 
        			?>



					<div class="form-group padnone col-xs-offset-3 col-md-6">
						<div class="input-group">
							<div class="input-group-addon iconfont">&#xe738;</div>
            			    <?php
                                $this->widget('zii.widgets.jui.CJuiDatePicker', [
                                    'model' => $model,
                                    'attribute' => 'pickup_time',
                                    'language' => 'zh_cn',
                                    
                                    'options' => [
                                        'showAnim' => 'fold',
                                        'dateFormat' => 'yy-mm-dd hh:ii',
                                    ],
                                    'htmlOptions' => [
                                        'class' => 'form-control',
                                        'placeholder' => '上车时间',
                                        //'readonly' => 'readonly'
                                    ]
                                ]);
                                ?>
						</div>
					</div>
					<?php 
        			  echo $form->error($model,'pickup_time',[
        			      'inputID'=>'custom-id',
        			      'class' => 'col-sm-3 errtxt'
        			  ]); 
        			?>
					<div class="form-group padnone col-xs-offset-3 col-md-6">
						<div class="input-group">
							<div class="input-group-addon iconfont">&#xe606;</div>
							<?php 
            			      echo $form->textField($model, 'pickup_place', [
            			          'class' => 'form-control',
            			          'placeholder' => '上车地点',
            			          'id' => 'suggestId'
            			      ]);
            			    ?>
						</div>
					</div>
					<?php 
        			  echo $form->error($model,'pickup_place',[
        			      'inputID'=>'custom-id',
        			      'class' => 'col-sm-3 errtxt'
        			  ]); 
        			?>

					<div class="form-group  padnone col-xs-offset-3 col-md-6">
						<div class="input-group">
							<div class="input-group-addon iconfont">&#xe622;</div>
							<?php 
            			      echo $form->dropDownList($model, 'drop_place', [
            			          '虹桥国际机场T1' => '虹桥国际机场T1',
            			          '虹桥国际机场T2' => '虹桥国际机场T2',
            			          '浦东国际机场T1' => '浦东国际机场T1',
            			          '浦东国际机场T2' => '浦东国际机场T2'
            			      ],
            			      [
            			         'class' => 'form-control'
            			      ]);
            			    ?>
						</div>
					</div>



					<div class="form-group padnone col-xs-offset-3 col-md-6">
						<div class="input-group">
							<div class="input-group-addon iconfont">&#xe603;</div>
							<?php 
            			      echo $form->dropDownList($model, 'vehicle_type', [
            			          VEHICLE_TYPE_BUSINESS => '商务型',
            			          VEHICLE_TYPE_LUXURY => '豪华型'   
            			      ],
            			      [
            			         'class' => 'form-control'
            			      ]);
            			    ?>
						</div>
					</div>

					<div class="form-group  padnone col-xs-offset-3 col-md-6">
						<label for="exampleInputFile">是否往返</label>
						<div style="width: 100%;" class="input-group">
                            <?php 
            			      echo $form->dropDownList($model, 'is_round_trip', [
            			          '0' => '否',
            			          '1' => '是'   
            			      ],
            			      [
            			         'class' => 'form-control'
            			      ]);
            			    ?>
						</div>
					</div>
                    <?php 
        			      echo $form->textArea($model, 'summary', [
        			          'class' => 'form-group col-xs-offset-3 col-md-6',
        			          'rows' => '3',
        			          'placeholder' => '其他需求'
        			      ]);
        			    ?>


					<!--优惠券-->
					<a href="#" style="text-align: left; margin-bottom: 15px;"
						class="btn btn-default col-xs-offset-3 col-md-6"
						data-toggle="modal" data-target="#youhuiquan2" type="button"> <span
						class="pull-left">优惠券</span><span class=" pull-right text-muted">您目前有<span
							class=" text-danger allpadding">4</span>张优惠券
					</span>
					</a>


					<!--价格-->
					<label class=" text-right padnone col-xs-offset-3 col-md-6">价格<span
						class="rmb">0</span>元
					</label>
					<!--协议-->

					<div style="clear: both;"
						class=" padnone checkbox col-xs-offset-3 col-md-6">
						<label> <?php echo $form->checkbox($model, 'agreeme');?> 勾选同意<a href="#"
							data-toggle="modal" data-target="#agreement">《众择用车》</a>协议
						</label>
					</div>

					<button type="submit"
						class="btn btn-primary col-xs-offset-3 col-md-6">提交订单</button>

					<div class="clearfix"></div>
					<?php $this->endWidget(); ?>
				</div>

			</div>
		</div>
	</div>
</div>