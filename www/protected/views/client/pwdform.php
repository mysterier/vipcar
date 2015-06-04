<div class="account-right-head">
	<h3>修改密码</h3>
</div>
<div class="account-container">
	    <?php
            $form = $this->beginWidget('CActiveForm', [
                'id' => 'login-form',
                'action' => '/client/updatepwd',
                //'enableClientValidation' => true,
                'clientOptions' => [
                    'validateOnSubmit' => true
                ],
                'htmlOptions' => [
                    'class' => 'form-horizontal'    
                ]
            ]);
        ?>
		<div class="form-group">
			<?php
                echo $form->label($model, 'oldpwd', [
                    'class' => 'col-sm-2 control-label'
                ]);
            ?>
            <div class="col-sm-5">
            <?php
                echo $form->passwordField($model, 'oldpwd', [
                    'class' => 'form-control',
                    'placeholder' => '原始密码'
                ]);
            ?>
            </div>
            <?php
                echo $form->error($model, 'oldpwd', [
                    'inputID' => 'custom-id',
                    'class' => 'col-sm-5 errtxt'
                ]);
            ?>
		</div>

		<div class="form-group">
			<?php
                echo $form->label($model, 'password', [
                    'class' => 'col-sm-2 control-label',
                    'label' => '新密码'
                ]);
            ?>
            <div class="col-sm-5">
            <?php
                echo $form->passwordField($model, 'password', [
                    'class' => 'form-control',
                    'placeholder' => '新密码'
                ]);
            ?>
            </div>
            <?php
                echo $form->error($model, 'password', [
                    'inputID' => 'custom-id',
                    'class' => 'col-sm-5 errtxt'
                ]);
            ?>
		</div>
		
		<div class="form-group">
			<?php
                echo $form->label($model, 'confirmpwd', [
                    'class' => 'col-sm-2 control-label'
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
                echo $form->error($model, 'confirmpwd', [
                    'inputID' => 'custom-id',
                    'class' => 'col-sm-5 errtxt'
                ]);
            ?>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-5">
				<button type="submit" class="btn btn-block all-btn-color">保存</button>
			</div>
		</div>
	 <?php $this->endWidget(); ?>
</div>
