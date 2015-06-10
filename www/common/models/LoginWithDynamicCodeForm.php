<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\models\User;

use common\sms\BaseSmsSender;


/**
 * Login form
 */
class LoginWithDynamicCodeForm extends Model
{
    public $phonenum;
    public $code;
    public $invited_code;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phonenum', 'code'], 'required', 'message'=>'不可为空'],
            ['rememberMe', 'boolean'],
            ['rememberMe', 'default', 'value'=>false],
            ['code', 'match', 'pattern'=>'/^\d{6}$/', 'message'=>'验证码不正确.'],
            ['invited_code', 'integer'],
            ['code', 'validateCode'],
        ];
    }

    /**
     * Validates the verify code.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateCode($attribute, $params)
    {

        if (!$this->hasErrors()) {
            if(!BaseSmsSender::validateVerifyCode($this->phonenum, $this->code)){
                $this->addError($attribute, '手机号或验证码不正确.');
            }
        }
    }

    /**
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->phonenum);
        }
        if (!$this->_user){
            $user = User::createUserWithPhonenum($this->phonenum,
                $invited_by=$this->invited_code);
            $this->_user = $user;
        }
        return $this->_user;
    }
}
