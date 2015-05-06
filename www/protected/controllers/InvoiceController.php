<?php

class InvoiceController extends Controller
{
    public function init() {
        parent::init();
        $this->layout = '//layouts/account';
    }

    public function actionIndex() {
        $criteria = new CDbCriteria();
        $criteria->condition = 'uid=:uid';
        $criteria->params = [
            'uid' => $this->uid,
        ];
        $criteria->order = 'id DESC';
        $model = InvoiceRecord::model()->findAll($criteria);
        $amount = $this->getAmount();
        $hash['model'] = $model;
        $hash['available_invoice_amount'] = $amount['available_invoice_amount'];
        $this->render('index', $hash);
    }
    
    public function actionNew()
    {
        $model = new InvoiceRecord();
        $criteria = new CDbCriteria();
        $criteria->condition = 'uid=:uid and status=:status';
        $criteria->params = [
            'uid' => $this->uid,
            'status' => STATUS_LIVE
        ];
        $criteria->order = 'is_common_use DESC,id DESC';
        $address = InvoiceAddress::model()->findAll($criteria);
        $amount = $this->getAmount();
        $hash['model'] = $model;
        $hash['available_invoice_amount'] = $amount['available_invoice_amount'];
        $hash['address'] = $address;
        $this->render('form', $hash);                 
    }
    
    public function actionCreate() {
        $model = new InvoiceRecord('webcreate');
        $model->attributes = $_POST['InvoiceRecord'];
        $model->uid = $this->uid;
        if ($model->save())
            $this->redirect('/invoice/index');
        
        $criteria = new CDbCriteria();
        $criteria->condition = 'uid=:uid and status=:status';
        $criteria->params = [
            'uid' => $this->uid,
            'status' => STATUS_LIVE
        ];
        $criteria->order = 'is_common_use DESC,id DESC';
        $address = InvoiceAddress::model()->findAll($criteria);
        $amount = $this->getAmount();
        $hash['model'] = $model;
        $hash['available_invoice_amount'] = $amount['available_invoice_amount'];
        $hash['address'] = $address;
        $this->render('form', $hash);  
    }
    
    public function getAmount() {
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

        $result['expend_amount'] = $expend_amount;
        $result['available_invoice_amount'] = $available_invoice_amount;
        $result['have_invoiced_amount'] = $have_invoiced_amount;
        return $result;
    }
    
}