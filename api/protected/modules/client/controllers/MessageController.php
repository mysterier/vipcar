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
        $c->condition = "t.client_id = $this->uid and t.id > $id";
        $c->order = "t.id asc";
    
        $model = ClientMessage::model()->with('tpl')->findAll($c);
    
        if ($model) {
        foreach ($model as $msg) {
                $id = $msg->id;
                $msg_tag = $msg->tpl_id ? $msg->tpl->tag : $msg->tag;
                $content = $msg->tpl_id ? $msg->tpl->content : $msg->content;
                $message[] = [
                    'msg_date' => $msg->created,
                    'msg_content' => $content,
                    'msg_tag' => $msg_tag
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