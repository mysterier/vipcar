<div class="account-right-head">
	<h3><?php echo ($this->action->id == 'new') ? '新增地址' : '修改地址';?></h3>
</div>

<div class="account-container">
	<?php
        $form = $this->beginWidget('CActiveForm', [
            'id' => 'address-form',
            'action' => '/address/' . (($this->action->id == 'new') ? 'create' : 'update'),
            'htmlOptions' => [
                'class' => 'form-horizontal'
            ]
        ]);
    ?>
		<div class="form-group">
			<?php 
		       echo $form->label($model, 'contacter_name', [
		           'class' =>"col-sm-2 control-label"
		       ]);
		    ?>
			<div class="col-sm-5">
				<?php 
			      echo $form->textField($model, 'contacter_name', [
			          'class' => 'form-control',
			          'placeholder' => '联系人'
			      ]);
			    ?>
			</div>
			<?php 
			  echo $form->error($model,'contacter_name',[
			      'inputID'=>'custom-id',
			      'class' => 'col-sm-3 errtxt'
			  ]); 
			?>
		</div>

		<div class="form-group">
			<?php 
		       echo $form->label($model, 'contacter_mobile', [
		           'class' =>"col-sm-2 control-label"
		       ]);
		    ?>
			<div class="col-sm-5">
				<?php 
			      echo $form->telField($model, 'contacter_mobile', [
			          'class' => 'form-control',
			          'placeholder' => '联系电话'
			      ]);
			    ?>
			</div>
			<?php 
			  echo $form->error($model,'contacter_mobile',[
			      'inputID'=>'custom-id',
			      'class' => 'col-sm-3 errtxt'
			  ]); 
			?>
		</div>

		<div class="form-group">
			<?php 
		       echo $form->label($model, 'address_info', [
		           'class' =>"col-sm-2 control-label"
		       ]);
		    ?>
			<div class="col-sm-5">
				<?php 
			      echo $form->textField($model, 'address_info', [
			          'class' => 'form-control',
			          'placeholder' => '地址详情'
			      ]);
			    ?>
			</div>
			<?php 
			  echo $form->error($model,'address_info',[
			      'inputID'=>'custom-id',
			      'class' => 'col-sm-3 errtxt'
			  ]); 
			?>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label">设为默认地址</label>
			<div class="col-sm-6 line-center">
				<?php 
				  echo $form->radioButtonList($model, 'is_common_use', [
				      '1' => '是',
				      '0' => '否'
				  ],[
				      'separator' => '&nbsp;&nbsp;&nbsp;&nbsp;'
				  ]);
				?>
			</div>
		</div>
		<input type="hidden" name="id" value="<?php echo $model->id;?>" />
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-5">
				<button type="submit" class="btn all-btn-color col-sm-12">保存</button>
			</div>
		</div>	
	<?php $this->endWidget(); ?>
</div>