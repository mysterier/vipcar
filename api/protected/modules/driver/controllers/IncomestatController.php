<?php

class IncomestatController extends Controller
{

    public function actionIndex()
    {
        $this_month = date("Y-m-d H:i:s", mktime(0, 0, 0, date('m'), 1, date('Y')));
        
        $criteria = new CDbCriteria();
        $criteria->select = 'id,order_income,created';
        $criteria->condition = 'driver_id = :uid and status = :status and created > :created';
        $criteria->params = [
            'uid' => $this->uid,
            'status' => (string) ORDER_STATUS_END,
            'created' => $this_month
        ];
        
        $orders = Orders::model()->findAll($criteria);
        if ($orders) {
            $this_week = strtotime("-1 week Monday");
            $this_day = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            
            $month_income = $week_income = $today_income = $month_order = $week_order = $today_order = 0;
            
            foreach ($orders as $order) {
                $created = strtotime($order->created);
                // 本月统计
                ++ $month_order;
                $month_income += $order->order_income;
                // 本周统计
                if ($created > $this_week) {
                    ++ $week_order;
                    $week_income += $order->order_income;
                }
                // 当日统计
                if ($created > $this_day) {
                    ++ $today_order;
                    $today_income += $order->order_income;
                }
            }
            
            $this->result['error_code'] = SUCCESS_DEFAULT;
            $this->result['error_msg'] = '';
            $this->result['statistic'] = [
                'today_order' => $today_order,
                'today_income' => $today_income,
                'week_order' => $week_order,
                'week_income' => $week_income,
                'month_order' => $month_order,
                'month_income' => $month_income
            ];
            var_dump($this->result);
        } else {
            $this->result['error_code'] = ORDER_STATISTIC;
            $this->result['error_msg'] = ORDER_MSG_STATISTIC;
        }
    }
}