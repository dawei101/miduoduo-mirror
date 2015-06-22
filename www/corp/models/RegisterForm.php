<?php
namespace corp\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class RegisterForm extends Model
{
    public $username;
    public $password;
    public $verifyCode;
    public $isAgreeProtocol = true;

    private $_user = false;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            // username and password are both required
            [['username', 'password', 'verifyCode'], 'required'],
            //check username unique
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],

            ['username', 'string', 'min' => 2, 'max' => 255],
            ['password', 'string', 'min' => 6],

            // isAgreeProtocol must be a boolean value
            ['isAgreeProtocol', 'boolean'],
            // password is validated by validatePassword()
            ['verifyCode', 'validateVerifyCode'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => '手机号',
            'password' => '密码',
            'verifyCode' => '验证码',
            'isAgreeProtocol' => '同意协议并注册',
        ];
    }


    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateVerifyCode($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function register()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
}
