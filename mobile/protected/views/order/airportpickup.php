<div class="wrapper">
	<div class="tab">
		<a href="#" class="text-center col-xs-offset-2 col-xs-4 tab-left-select"> 接机 </a>
		<a href="/order/airportsend" class="text-center col-xs-4 tab-right"> 送机 </a>
	</div>
	<div class="clearfix"></div>
	<form method="post" action="/order/process/<?php echo ORDER_TYPE_AIRPORTPICKUP;?>?showwxpaytitle=1">
		<div class="formgroup">
			<a href="/order/addcontacter?type=1&flight_no=<?php echo $flight_no;?>&pickup_time=<?php echo $pickup_time;?>&pickup_place=<?php echo $pickup_place;?>&drop_place=<?php echo $drop_place;?>" class="formlist a-select">
				<div class="col-xs-2">
					<img src="/img/z-geren.png">
				</div>
				<div class="col-xs-8">
					<p class="p-gren">
						<span><?php echo $contacter_name;?></span><span><?php echo $seats;?>人</span>
					</p>
					<p class="p-gren">
						<span><?php echo $contacter_phone;?></span>
					</p>
				</div>
				<div class="col-xs-2">
					<img class="pull-right" src="/img/z-next.png">
				</div>
			</a>
		</div>
		<div class="formgroup">

			<a href="/order/flight?contacter_name=<?php echo $contacter_name;?>&contacter_phone=<?php echo $contacter_phone;?>&seats=<?php echo $seats;?>" class="formlist a-select">
				<div class="col-xs-2">
					<img src="/img/z-feiji.png">
				</div>
				<div class="col-xs-8">
				<?php if($flight_no):?>
				    <p class="p-normal p-select"><?php echo $flight_no?></p>
				<?php else:?>
					<p class="p-normal">航班号</p>
				<?php endif;?>
				</div>
				<div class="col-xs-2">
					<img class="pull-right" src="/img/z-next.png">
				</div>

			</a>
			<div class="formline"></div>
			<a href="/order/flight?contacter_name=<?php echo $contacter_name;?>&contacter_phone=<?php echo $contacter_phone;?>&seats=<?php echo $seats;?>" class="formlist a-select">
				<div class="col-xs-2">
					<img src="/img/z-shijian.png">
				</div>
				<div class="col-xs-10">
			    <?php if($pickup_time):?>
				    <p class="p-normal p-select"><?php echo $pickup_time?></p>
				<?php else:?>
					<p class="p-normal">航班时间</p>
				<?php endif;?>
				</div>
			</a>

		</div>
		<div class="formgroup">
			<div class="formlist">
				<div class="col-xs-2">
					<img src="/img/z-qidian.png">
				</div>
				<div class="col-xs-3">
					<p class="p-adress">上海</p>
				</div>

				<div class="col-xs-7">
				<?php if($pickup_place):?>
				    <p class="p-normal p-select"><?php echo $pickup_place?></p>
				<?php else:?>
					<p class="p-normal">航站楼</p>
				<?php endif;?>
				</div>

			</div>

			<div class="formline"></div>
			<div class="formlist">
				<div class="col-xs-2">
					<img src="/img/z-zhongdian.png">
				</div>
				<div class="col-xs-3">
					<p class="p-adress">上海</p>
				</div>
				<div class="col-xs-7">
					<input id="suggestId" type="text" class="form-control drop_place" placeholder="下车地址" name="drop_place" />
				</div>
			</div>
		</div>
		<div class="formgroup">
			<div class="formlist">
				<div class="col-xs-2">
					<img src="/img/z-qiche.png">
				</div>
				<div class="col-xs-10">
					<p class="p-normal p-select">
						商务GL8<span>(目前促销期)</span>
					</p>
				</div>
			</div>

			<div class="formline"></div>
			<div class="formlist">
				<div class="col-xs-2">
					<img src="/img/z-xuqiu.png">
				</div>
				<div class="col-xs-10">
					<textarea class="form-control" cols="1" rows="1" placeholder="其他需求" name="summary"></textarea>
				</div>
			</div>
		</div>
		<div class="formgroup">
			<div class="formlist">
				<div class="col-xs-2">
					<img src="/img/z-youhuiquan.png">
				</div>
				<div class="col-xs-10">
					<select id="showticket" class="form-control p-select" name="coupon_id">
						<option>您有0张优惠券</option>
					</select>
				</div>
			</div>
		</div>
	<div class="clearfix"></div>
	<div class="width98">
		<div class="text-right price ">
			预计价格<span class="rmb">0</span>元
		</div>
	</div>
	<input type="hidden" value="<?php echo $contacter_name;?>" name="contacter_name" />
	<input type="hidden" value="<?php echo $contacter_phone;?>" name="contacter_phone" />
	<input type="hidden" value="<?php echo $seats;?>" name="seats" />
	<input type="hidden" value="<?php echo $flight_no;?>" name="flight_number" />
	<input type="hidden" value="<?php echo $pickup_time;?>" name="pickup_time" />
	<input id="terminal" type="hidden" value="<?php echo $pickup_place;?>" name="pickup_place" />
	<input id="Orders_vehicle_type" type="hidden" value="<?php echo VEHICLE_TYPE_BUSINESS;?>" name="vehicle_type" />
	<div class="width98">
    <?php include '_protocol.php';?>
	</div>
	</form>
</div>