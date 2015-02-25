<?php

class CouponController extends Controller
{
    
    public function actionList()
    {
        $this->title = '优惠券';
        $this->checkExpand();
        $attributes = [
            'open_id' => $this->openid,
            'status' => WX_COUPON_STATUS_ON
        ];
        $model = WxCoupon::model()->findAllByAttributes($attributes);
        $hash['coupons'] = $model;
        $this->render('list', $hash);
    }
}