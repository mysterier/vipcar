<?php

class AvatarController extends Controller
{

    public function actionIndex()
    {
        $model = Clients::model()->findByPk($this->uid);
        $model->setScenario('avatar');
        $path = $this->uploadAvatar();
        if ($path) {
            $model->avatar = $path;
            if ($model->save()) {
                $this->result['error_code'] = SUCCESS_DEFAULT;
                $this->result['error_msg'] = '';
                $this->result['avatar_path'] = $path;
            } else {
                $this->result['error_code'] = ERROR_DEFAULT;
                $this->result['error_msg'] = ERROR_MSG_UPLOAD;
            }                
        } else {
            $this->result['error_code'] = ERROR_DEFAULT;
            $this->result['error_msg'] = ERROR_MSG_UPLOAD;
        }
    }

    public function uploadAvatar()
    {
        if (!$_FILES)
            return false;
        $isSuc = false;
        $path = '/client/' . date('Y') . '/' . date('m') . '/';
        if (($pos = strrpos($_FILES["avatar"]["name"], '.')) !== false)
            $extensionName = (string) substr($_FILES["avatar"]["name"], $pos + 1);
        
        $name = 'avatar_' . date('d') . '_' . time() . '_' . rand(0, 9999) . '.' . $extensionName;
        $desFilePath;
        $tmpFilePath;
        
        
        if (in_array($_FILES["avatar"]["type"], [
            'image/gif',
            'image/jpeg',
            'image/png',
            'image/jpg',
            'image/pjpeg'
        ]) && $_FILES["avatar"]["size"] < (1024 * 1024 * 10)) {
            if ($_FILES["avatar"]["error"] > 0) {
                $isSuc = false;
            } else {
                $tmpFilePath = $_FILES["avatar"]["tmp_name"];
                $desFilePath =  DEFAULT_UPLOAD_PATH . $path;
                if (! is_dir($desFilePath))
                    mkdir($desFilePath, 0777, true);
                
                $desFilePath = $desFilePath . $name;
                move_uploaded_file($tmpFilePath, $desFilePath);
                $isSuc = $path . $name;
            }
        }
        return $isSuc;
    }
}