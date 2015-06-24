<?php
namespace corp\models;

use common\models\User;
use yii\base\Model;
use common\sms\BaseSmsSender;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $phone;
    public $vcode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['phone', 'filter', 'filter' => 'trim'],
            ['phone', 'required'],
            ['phone', 'email'],
            ['phone', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => 0],//User::STATUS_ACTIVE],
                'message' => 'There is no user with such phone.'
            ],

            ['vcode', 'filter', 'filter' => 'trim'],
            ['vcode', 'required'],
            ['vcode', 'match', 'pattern'=>'/^\d{6}$/', 'message'=>'验证码不正确.'],
            ['vcode', function ($attribute, $params) {
                if (!$this->hasErrors()) {
                    if(!BaseSmsSender::validateVerifyCode($this->phone, $this->vcode)){
                        $this->addError($attribute, '手机号或验证码不正确.');
                    }
                }
            }],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function verifyPhone()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => 0,//User::STATUS_ACTIVE,
            'username' => $this->phone,
        ]);

        if ($user) {
            if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
            }

            if ($user->save()) {
                return $user;
            }
        }

        return false;
    }
}
