<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{

    public $uid;
    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * 
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        $client = Clients::model()->findByAttributes([
            'mobile' => $this->username,
            'type' => isset($_GET['type']) ? $_GET['type'] : 0
        ]);
        $passwd = md5('suxian' . md5($this->password));
        if (! $client)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        elseif ($client->password !== $passwd)
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else {
            Yii::app()->user->setState('type', $client->type);
            $this->uid = $client->id;
            $this->errorCode = self::ERROR_NONE;
        }
            
        return ! $this->errorCode;
    }
    
    public function getId() {
        return $this->uid;
    }
}