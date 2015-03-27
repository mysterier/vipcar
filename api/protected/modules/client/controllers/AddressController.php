<?php

class AddressController extends Controller
{

    public function actionAdd()
    {
        $attributes = $_POST;
        $attributes['uid'] = $this->uid;
        $address = new InvoiceAddress();
        $address->attributes = $attributes;
        $this->changeDefault();
        if ($address->save()) {
            $this->result['error_code'] = SUCCESS_DEFAULT;
            $this->result['error_msg'] = '';
        }                 
    }
    
    public function actionList() {
        //暂时无视sid
        //$sid = $this->getParam('last_address_sid');
        $criteria = new CDbCriteria();
        $criteria->condition = 'uid=:uid and status=:status';
        $criteria->params = [
            'uid' => $this->uid,
            'status' => STATUS_LIVE
        ];
        $criteria->order = 'id asc';
        $address = InvoiceAddress::model()->findAll($criteria);
        $address_list = [];
        $this->result['error_code'] = SUCCESS_DEFAULT;
        $this->result['error_msg'] = '';
        if ($address) {
            foreach ($address as $v) {
                $sid = $v->id;
                $address_list[] = [
                    'address_sid' => $v->id,
                    'contacter_name' => $v->contacter_name,
                    'contacter_mobile' => $v->contacter_mobile,
                    'address_info' => $v->address_info,
                    'is_common_use' => $v->is_common_use
                ];
            }
        }
        //$this->result['last_address_sid'] = $sid;
        $this->result['address_list'] = $address_list;
    }
    
    public function actionModify($id) {
        $address = InvoiceAddress::model()->findByPk($id);
        if ($address && $address->uid == $this->uid) {
            $address->attributes = $_POST;
            $this->changeDefault();
            if ($address->save()) {
                $this->result['error_code'] = SUCCESS_DEFAULT;
                $this->result['error_msg'] = '';
            }
        }
    }
    
    public function actionDelete($id) {
        $address = InvoiceAddress::model()->findByPk($id);
        $address->status = STATUS_DEL;
        if ($address->save()) {
            $this->result['error_code'] = SUCCESS_DEFAULT;
            $this->result['error_msg'] = '';
        }
    }
    
    private function changeDefault() {
        $is_common_use = $this->getParam('is_common_use');
        if ($is_common_use) {
            $attributes = [
                'uid' => $this->uid,
                'is_common_use' => $is_common_use
            ];
            $model = InvoiceAddress::model()->findByAttributes($attributes);
            if ($model) {
                $model->is_common_use = 0;
                $model->save();
            }
        }
    }
}