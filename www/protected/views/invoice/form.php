<div class="account-right-head">
	<div class="pull-left">
		可开发票：<span><?php echo $available_invoice_amount;?>元</span>
	</div>
	<a href="/invoice/index" class="btn pull-right all-btn-color">查看开票记录</a>
	<div class="clearfix"></div>
	<h3>我要开发票</h3>
</div>

<div class="account-container">

	<?php
        $form = $this->beginWidget('CActiveForm', [
            'id' => 'address-form',
            'action' => '/invoice/create',
            'htmlOptions' => [
                'class' => 'form-horizontal'
            ]
        ]);
    ?>

		<div class="form-group">
		    <?php 
		       echo $form->label($model, 'invoice_amount', [
		           'class' =>"col-sm-2 control-label"
		       ]);
		    ?>
			<div class="col-sm-10">
				<?php 
			      echo $form->textField($model, 'invoice_amount', [
			          'class' => 'form-control',
			          'placeholder' => '开票金额'
			      ]);
			    ?>
			</div>
			<?php 
			  echo $form->error($model,'invoice_amount',[
			      'inputID'=>'custom-id',
			      'class' => 'col-sm-offset-2 col-sm-10 errtxt'
			  ]); 
			?>
<!-- <div class="col-sm-offset-2 col-sm-10 warningtxt">注：开票金额不得低于50元，300元以上免费寄送</div> -->
		</div>
		<div class="form-group">
			<?php 
		       echo $form->label($model, 'invoice_title', [
		           'class' =>"col-sm-2 control-label"
		       ]);
		    ?>
			<div class="col-sm-10">
				<?php 
			      echo $form->textField($model, 'invoice_title', [
			          'class' => 'form-control',
			          'placeholder' => '个人或公司'
			      ]);
			    ?>
			</div>
			<?php 
			  echo $form->error($model,'invoice_title',[
			      'inputID'=>'custom-id',
			      'class' => 'col-sm-offset-2 col-sm-10 errtxt'
			  ]); 
			?>
		</div>
		<div class="form-group ">
			<div class="col-sm-offset-2 col-sm-10 padnone">
				<ul class="invoice-addr">
					<?php $i=0; foreach ($address as $item):?>
					<li class="addrlist col-sm-3 <?php ++$i;if($i < 2) echo 'addrlist-select';?>"
					contacter_name="<?php echo $item->contacter_name;?>" contacter_mobile="<?php echo $item->contacter_mobile;?>" address_info="<?php echo $item->address_info;?>">
						<h5><?php echo $item->contacter_name;?>收</h5>
						<p><?php echo $item->address_info;?></p>
						<p class="small">TEL: <?php echo $item->contacter_mobile;?></p>
					</li>
					<?php endforeach;?>
					<a href="/address/index">
						<li class="addrlist col-sm-3  text-center">
							<h4>地址管理</h4>
					   </li>
					</a>
				</ul>
			</div>
		</div>

		<input id="contacter_name" type="hidden" value="<?php if($address) echo $address[0]->contacter_name;?>" name="InvoiceRecord[contacter_name]">
        <input id="contacter_mobile" type="hidden" value="<?php if($address) echo $address[0]->contacter_mobile;?>" name="InvoiceRecord[contacter_mobile]">
        <input id="address_info" type="hidden" value="<?php if($address) echo $address[0]->address_info;?>" name="InvoiceRecord[address_info]">
		<input type="hidden" value="<?php echo $available_invoice_amount;?>" name="available_invoice_amount" />
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-5">
				<button type="submit" class="btn btn-block all-btn-color">保存</button>
			</div>
		</div>

	<?php $this->endWidget(); ?>
</div>