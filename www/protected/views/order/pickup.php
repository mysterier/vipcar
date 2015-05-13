<div class="jiesongjiimg">
	<div class="wrapper-width">
		<div class="jiejititle">
			<h3>接送机</h3>
			<p>欢迎使用 众择用车，轻触按钮即可获取轻松出行的最佳之选。创建帐户，几分钟后即可出行。</p>
		</div>
		<div class="jieji">
			<ul class="jiejitop">
				<li class="jiejihover"><a href="/order/pickup">接机</a></li>
				<li><a href="/order/send">送机</a></li>
			</ul>
			<h3>接送机</h3>
			<div class=" jiesongjibottom">
				<div>
					<?php
                        $form = $this->beginWidget('CActiveForm', [
                            'id' => 'address-form',
                            'action' => '/order/pickup'
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
                                            'dateFormat' => 'yy-mm-dd',
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
						<div id="ajaxcheck" class="form-group padnone col-xs-offset-3 col-md-6">
							<div class="input-group">
								<div class="input-group-addon iconfont">&#xe630;</div>
								<?php 
                			      echo $form->textField($model, 'flight_number', [
                			          'class' => 'form-control',
                			          'placeholder' => '航班号'
                			      ]);
                			    ?>
							</div>
						</div>
						<?php 
            			  echo $form->error($model,'flight_number',[
            			      'inputID'=>'custom-id',
            			      'class' => 'col-sm-3 errtxt'
            			  ]); 
            			?>
						<div class="form-group padnone col-xs-offset-3 col-md-6">
							<div class="input-group">
								<div class="input-group-addon iconfont">&#xe622;</div>
								<?php 
                			      echo $form->textField($model, 'pickup_place', [
                			          'class' => 'form-control',
                			          'placeholder' => '航站楼',
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
						<div class="form-group padnone col-xs-offset-3 col-md-6">
							<div class="input-group">
								<div class="input-group-addon iconfont">&#xe606;</div>
								<?php 
                			      echo $form->textField($model, 'drop_place', [
                			          'class' => 'form-control',
                			          'placeholder' => '下车地点',
                			          'id' => 'suggestId'
                			      ]);
                			    ?>
							</div>
						</div>
						<?php 
            			  echo $form->error($model,'drop_place',[
            			      'inputID'=>'custom-id',
            			      'class' => 'col-sm-3 errtxt'
            			  ]); 
            			?>
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
						<?php 
        			      echo $form->textArea($model, 'summary', [
        			          'class' => 'form-group col-xs-offset-3 col-md-6',
        			          'rows' => '3',
        			          'placeholder' => '其他需求'
        			      ]);
        			    ?>
						<!--优惠券--> 
                        <a id="youhuiquan" href="#" style="text-align:left; margin-bottom:15px;" class="btn btn-default col-xs-offset-3 col-md-6" data-toggle="modal" type="button"> <span class="pull-left">优惠券</span><span class="pull-right text-muted">您目前有<span class=" text-danger">4</span>张优惠券</span> </a> 
                          
                    
                        <!-- 模态框 -->
                        <div class="modal fade" id="myyouhuiquan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">我的优惠券</h4>
                              </div>
                              <div class="modal-body">
                                  <!--content-->
                               <div class="container-fluid"> 
                                  <div class="yhq-color text-right">  
                                  <div><p class="yhq-logo"><img  src="/images/jieji/yhqlogo.png" width="50" height="50"></p><strong>50元优惠券</strong></div>              
                                  </div>             
                                  <div class="yhq-color text-right">  
                                  <div><p class="yhq-logo"><img  src="/images/jieji/yhqlogo.png" width="50" height="50"></p><strong>50元优惠券</strong></div>              
                                  </div>                         
                                  <div class="yhq-color text-right">  
                                  <div><p class="yhq-logo"><img  src="/images/jieji/yhqlogo.png" width="50" height="50"></p><strong>50元优惠券</strong></div>              
                                  </div>
                               </div>    
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">不使用优惠券</button>
                                <button type="button" class="btn btn-primary">确定使用</button>
                              </div>
                            </div>
                          </div>
                        </div>
        			    
						<!--价格-->

						<label class="padnone col-xs-offset-3 col-md-6 text-right">价格<span
							class="rmb">0</span>元
						</label>

						<!--协议-->
						<div style="clear: both;"
							class=" padnone checkbox col-xs-offset-3 col-md-6">
							<label> <?php echo $form->checkbox($model, 'agreeme');?> 勾选同意<a href="#"
								data-toggle="modal" data-target="#agreement">《众择用车》</a>协议
							</label>
						</div>
						<!-- Modal -->
						<div class="modal fade" id="agreement" tabindex="0" role="dialog"
							aria-labelledby="myModalLabel" data-target="#foo"
							aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal"
											aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
										<h4 class="modal-title" id="myModalLabel">Modal title</h4>
									</div>
									<div class="modal-body">...</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default"
											data-dismiss="modal">Close</button>
										<button type="button" class="btn btn-primary">Save changes</button>
									</div>
								</div>
							</div>
						</div>
						<button type="submit" class="btn btn-primary col-xs-offset-3 col-md-6">提交订单</button>
						<div class="clearfix"></div>
					<?php $this->endWidget(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$("#Orders_flight_number").blur(function(){
	date = $("#Orders_pickup_time").val();
	flight = $(this).val();
    $.post('/jsonp/getflight', {'flight':flight,'date':date}, function(data){
       if(data.error_code < 0) {
           $("#noflight").remove();
           $("#ajaxcheck").after('<div id="noflight" class="col-sm-3 errtxt">未查到相关航班号！</div>');
       } else {
    	   $("#noflight").remove();
    	   $("#Orders_pickup_time").val(data.pickup_time);
    	   $("#Orders_pickup_place").prop("readonly",true).val(data.pickup_place);
       }
    },'json');
});
//百度地图
var ac = new BMap.Autocomplete(
	{"input" : "suggestId",
	"location" : "上海"
});

</script>