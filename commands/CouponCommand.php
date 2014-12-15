<?php
/**
 * 优惠码相关脚本
 * 
 * @author lqf
 *
 */
class CouponCommand extends CConsoleCommand
{
    /**
     * 产生优惠码
     * 命令：cli.php Coupon create --num=100
     * 
     * @param int $num 产生数量默认500
     * @author lqf
     */
    public function actionCreate($num='') {
        $id = 100000;
        $num = $num ? $num : 500;
        $model = Coupon::model()->find('1 order by id DESC');
        if ($model)
            $id = $this->decryptionId($model->coupon);
        
        $head = '';
        $prefix = (string)COUPON_PREFIX;
        for ($i=0;$i<strlen($prefix);++$i)           
            $head .= $prefix[$i] + 2;
        
        $mid = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';        
                
        for ($i=0;$i<$num;++$i) {
            ++$id;
            $model = new Coupon();
            $mid = str_shuffle($mid);
            $mid = substr($mid, 0, 6);
            $tail = $this->encryptionId($id);
            $coupon = $head . $mid . $tail;
            $model->coupon = $coupon;
            if ($model->save())
                echo $coupon . "\n";          
        }
    }
    
    public function decryptionId($coupon) {
        $tail = substr($coupon, 10, 6);
        $word = substr($tail, -1);
        if ($word > 'F') {
            if (substr($tail, -2, 1) > 'F')
                $tail = substr($tail, 0, 4);
            $tail = substr($tail, 0, 5);
        }
        $id = hexdec($tail) - COUPON_CHECK_CODE;
        return $id;
    }
    
    public function encryptionId($id) {
        $id = $id + COUPON_CHECK_CODE;
        $id = dechex($id);
        $string = 'GHIJKLMNOPQRSTUVWXYZ';
        $string = str_shuffle($string);
        $id = substr($id . $string, 0, 6);
        return strtoupper($id);
    }
}