<?php

class InvoiceController extends Controller
{

    public function actionNew()
    {
        $attributes = $_POST;
        $attributes['uid'] = $this->uid;
        $invoice = new InvoiceRecord();
        $invoice->attributes = $attributes;
        if ($invoice->save()) {
            $this->result['error_code'] = SUCCESS_DEFAULT;
            $this->result['error_msg'] = '';
        }                 
    }
    
    public function actionHistory() {
        $sid = $this->getParam('last_invoice_sid');
        $criteria = new CDbCriteria();
        $criteria->condition = 'uid=:uid and id > :id';
        $criteria->params = [
            'uid' => $this->uid,
            'id' => $sid
        ];
        $criteria->order = 'id asc';
        $invoice = InvoiceRecord::model()->findAll($criteria);
        $invoice_list = [];
        $this->result['error_code'] = SUCCESS_DEFAULT;
        $this->result['error_msg'] = '';
        if ($invoice) {
            foreach ($invoice as $v) {
                $sid = $v->id;
                $invoice_list[] = [
                    'invoice_sid' => $v->id,
                    'invoice_title' => $v->invoice_title,
                    'invoice_amount' => $v->invoice_amount,
                ];
            }
        }
        $this->result['last_invoice_sid'] = $sid;
        $this->result['invoice_list'] = $invoice_list;
    }
    
    public function actionAmount() {
        $criteria = new CDbCriteria();
        $criteria->select = 'sum(order_income) total_income';
        $criteria->condition = 'client_id=:uid and status=:status';
        $criteria->params = [
            'uid' => $this->uid,
            'status' => (string)ORDER_STATUS_END
        ];
        $order = Orders::model()->find($criteria);
        $expend_amount = $available_invoice_amount = $have_invoiced_amount = 0;
        if ($order)
            $expend_amount = $order->total_income;
        
        $criteria->select = 'sum(invoice_amount) have_invoiced_amount';
        $criteria->condition = 'uid=:uid';
        $criteria->params = [
            'uid' => $this->uid,
        ];
        $invoice = InvoiceRecord::model()->find($criteria);
        if ($invoice)
            $have_invoiced_amount = $invoice->have_invoiced_amount;
        
        $available_invoice_amount = $expend_amount - $have_invoiced_amount;
        if ($available_invoice_amount < 0)
            $available_invoice_amount = 0;
        $this->result['error_code'] = SUCCESS_DEFAULT;
        $this->result['error_msg'] = '';
        $this->result['expend_amount'] = $expend_amount;
        $this->result['available_invoice_amount'] = $available_invoice_amount;
        $this->result['have_invoiced_amount'] = $have_invoiced_amount;
    }
    
}