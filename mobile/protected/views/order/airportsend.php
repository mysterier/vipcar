<div class="wrapper">
	<div class="tab">
		<a href="/order/airportpickup" class="text-center col-xs-offset-2 col-xs-4 tab-left"> 接机 </a>
		<a href="#" class="text-center col-xs-4 tab-right-select"> 送机</a>
	</div>
	<div class="clearfix"></div>
	<form method="post" action="/order/process/<?php echo ORDER_TYPE_AIRPORTSEND;?>?showwxpaytitle=1">
		<div class="formgroup">
			<a href="/order/addcontacter?type=2&is_round_trip=<?php echo $is_round_trip;?>&pickup_time=<?php echo $pickup_time;?>&pickup_place=<?php echo $pickup_place;?>&drop_place=<?php echo $drop_place;?>" class="formlist a-select">
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
			<div class="formlist">
				<div class="col-xs-2">
					<img src="/img/z-shijian.png">
				</div>
				<div class="col-xs-10">
					<input type="datetime-local" class="form-control" name="pickup_time" placeholder="上车时间">
				</div>
			</div>
		</div>
		<div class="formgroup">
			<div class="formlist">
				<div class="col-xs-2">
					<img src="/img/z-qidian.png">
				</div>
				<div class="col-xs-2">
					<p class="p-adress">上海</p>
				</div>
				<div class="col-xs-8">
					<input type="text" class="form-control" id="suggestId" placeholder="上车地点" name="pickup_place">
				</div>
			</div>
			<div class="formline"></div>
			<div class="formlist">
				<div class="col-xs-2">
					<img src="/img/z-qidian.png">
				</div>
				<div class="col-xs-2">
					<p class="p-adress">上海</p>
				</div>

				<div class="col-xs-8">
					<select id="terminal" class="form-control p-select drop_place" name="drop_place">
        				<optgroup label="航站楼"></optgroup>
        				<option value="虹桥国际机场T1">虹桥国际机场T1</option>
        				<option value="虹桥国际机场T2">虹桥国际机场T2</option>
        				<option value="浦东国际机场T1">浦东国际机场T1</option>
        				<option value="浦东国际机场T2">浦东国际机场T2</option>
        			</select>
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
					<img src="/img/z-wangfan.png">
				</div>
				 <div class="checkbox wangfan-checkbox pull-left">
				    <input type="checkbox" name="is_round_trip" value="1">
				 </div>
				 <div class="wangfan-checkbox p-select">
				 	往返
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
    		<div class="text-right price">
    			预计价格<span class="rmb">0</span>元
    		</div>
    	</div>
    	<input type="hidden" value="<?php echo $contacter_name;?>" name="contacter_name" />
    	<input type="hidden" value="<?php echo $contacter_phone;?>" name="contacter_phone" />
    	<input type="hidden" value="<?php echo $seats;?>" name="seats" />
    	<input id="Orders_vehicle_type" type="hidden" value="<?php echo VEHICLE_TYPE_BUSINESS;?>" name="vehicle_type" />
    	<div class="width98">
        <?php include '_protocol.php';?>
    	</div>
	</form>
</div>