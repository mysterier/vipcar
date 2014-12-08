<?php

class MessageController extends Controller
{

    public function actionIndex()
    {
        echo 'hello world';
    }
    
    public function actionList() {
        $id = $this->getParam('last_message_sid');
        $message = [];
        
        $c = new CDbCriteria();
        $c->condition = "t.driver_id = $this->uid and t.id > $id";
        $c->order = "t.id asc";
        
        $model = DriverMessage::model()->with('tpl')->findAll($c);

        if ($model) {
            foreach ($model as $msg) {
                $id = $msg->id;
                $message[] = [
                    'msg_date' => $msg->created,
                    'msg_content' => $msg->tpl->content,
                    'msg_tag' => $msg->tpl->tag
                ];
            }
            $this->result['error_code'] = SUCCESS_DEFAULT;
            $this->result['error_msg'] = '';
            $this->result['last_message_sid'] = $id;
            $this->result['message'] = $message;
        } else {
            $this->result['error_code'] = API_MAINTAIN_MESSAGE;
            $this->result['error_msg'] = API_MAINTAIN_MESSAGE_MSG;
        }
    }
}