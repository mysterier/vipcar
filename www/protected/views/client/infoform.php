<div class="account-right-head">
	<h3>个人资料</h3>
</div>
<div class="account-information">	
    <div class="col-md-3">
    	<div class="form-group account-information-left">
    		<div class="information-header">
    			<img id="avatar" src="<?php echo $model->avatar ? 'http://'.DEFAULT_CDN_URL.$model->avatar : '/img/header.jpg';?>" alt="头像" class="img-rounded">
    		</div>
    		<a href="javascript:void(0)" class="information-file btn btn-info col-md-12">
    		      选择文件 <input id="file1" type="file" name="avatar" onchange="ajaxFileUpload()">
    		</a>
    	</div>
    </div>
<?php
    $form = $this->beginWidget('CActiveForm', [
        'id' => 'info-form',
        'action' => '/client/update',
        //'enableClientValidation' => true,
        'clientOptions' => [
            'validateOnSubmit' => true
        ],
        'htmlOptions' => [
            'class' => 'form-horizontal'    
        ]
    ]);
?>
		<div class="col-md-9">
			<div class="form-group account-information-right">
				<div class="form-group">
				    <?php 
				       echo $form->label($model, 'real_name', [
				           'class' =>"col-sm-3 control-label"
				       ]);
				    ?>
					<div class="col-sm-6">
					    <?php 
					      echo $form->textField($model, 'real_name', [
					          'class' => 'form-control',
					          'placeholder' => '姓名'
					      ]);
					    ?>						
					</div>
					<?php 
					  echo $form->error($model,'real_name',[
					      'inputID'=>'custom-id',
					      'class' => 'col-sm-3 errtxt'
					  ]); 
					?>
				</div>

				<div class="form-group">
					<label class="col-sm-3 control-label">性别</label>
					<div class="col-sm-6 line-center">
						<?php 
						  echo $form->radioButtonList($model, 'gender', [
						      '1' => '男',
						      '2' => '女'
						  ],[
						      'separator' => '&nbsp;&nbsp;&nbsp;&nbsp;'
						  ]);
						?>
					</div>
				</div>


				<div class="form-group">
					<?php 
				       echo $form->label($model, 'mobile', [
				           'class' =>"col-sm-3 control-label"
				       ]);
				    ?>
					<div class="col-sm-6">
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
				       echo $form->label($model, 'email', [
				           'class' =>"col-sm-3 control-label",
				           'label' => '电子邮箱'
				       ]);
				    ?>
					<div class="col-sm-6">
					    <?php 
					      echo $form->emailField($model, 'email', [
					          'class' => 'form-control',
					          'placeholder' => '电子邮箱'
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
					<div class="col-sm-offset-3 col-sm-6">
						<button type="submit" class="btn btn-info col-sm-12">保存</button>
					</div>
				</div>
			</div>
		</div>
	<?php $this->endWidget(); ?>
</div>
<script>
function ajaxFileUpload() {
    $.ajaxFileUpload
    (
        {
            url: '/jsonp/upload', //用于文件上传的服务器端请求地址
            secureuri: false, //一般设置为false
            fileElementId: 'file1', //文件上传空间的id属性  <input type="file" id="file" name="file" />
            dataType: 'json', //返回值类型 一般设置为json
            success: function (data, status)  //服务器成功响应处理函数
            {
                if (data.error_code == 1) {
                	$("#avatar").attr("src", 'http://<?php echo DEFAULT_CDN_URL;?>'+data.avatar_path);
                	//$('#file1').replaceWith('<input name="avatar" type="file" id="file1"  />');
                } else {
                    alert(data.error_msg);
                }
                
            },
            error: function (data, status, e)//服务器响应失败处理函数
            {
                alert(e);
            }
        }
    )
}
</script>