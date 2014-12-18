<?php

class IncomestatController extends Controller
{

    public function actionIndex()
    {
        $total_criteria = new CDbCriteria();
        $total_criteria->select = 'count(0) total_order,sum(order_income) total_income';
        $total_criteria->condition = 'driver_id = :uid and status = :status';
        $total_criteria->params = [
            'uid' => $this->uid,
            'status' => (string) ORDER_STATUS_END
        ];
        $total_orders = Orders::model()->find($total_criteria);
        
        
        $this_month = mktime(0, 0, 0, date('m'), 1, date('Y'));
        
        $criteria = new CDbCriteria();
        $criteria->select = 'id,order_income,last_update';
        $criteria->condition = 'driver_id = :uid and status = :status and last_update > :last_update';
        $criteria->params = [
            'uid' => $this->uid,
            'status' => (string) ORDER_STATUS_END,
            'last_update' => $this_month
        ];
        
        $this->result['error_code'] = SUCCESS_DEFAULT;
        $this->result['error_msg'] = '';
        
        $orders = Orders::model()->findAll($criteria);
        if ($orders) {
            $this_week = strtotime("-1 week Monday");
            $this_day = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            
            $month_income = $week_income = $today_income = $month_order = $week_order = $today_order = 0;
            
            foreach ($orders as $order) {
                // 本月统计
                ++ $month_order;
                $month_income += $order->order_income;
                // 本周统计
                if ($last_update > $this_week) {
                    ++ $week_order;
                    $week_income += $order->order_income;
                }
                // 当日统计
                if ($last_update > $this_day) {
                    ++ $today_order;
                    $today_income += $order->order_income;
                }
            }
                        
            $this->result['statistic'] = [
                'today_order' => $today_order,
                'today_income' => $today_income,
                'week_order' => $week_order,
                'week_income' => $week_income,
                'month_order' => $month_order,
                'month_income' => $month_income
            ];
        } else {
            $this->result['statistic'] = [
                'today_order' => 0,
                'today_income' => 0,
                'week_order' => 0,
                'week_income' => 0,
                'month_order' => 0,
                'month_income' => 0
            ];
        }
        $this->result['statistic']['total_order'] = $total_orders->total_order;
        $this->result['statistic']['total_income'] = $total_orders->total_income ? $total_orders->total_income : 0;
    }
}