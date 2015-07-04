<?php

namespace corp\models;

use Yii;
use yii\base\Model;

use common\models\Company;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $phone;
    public $email;
    public $name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','phone', 'email'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => '公司名称',
            'phone' => '联系电话',
            'email' => '接收简历邮箱',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string  $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([$this->email => $this->name])
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send();
    }

    public function saveContactInfo()
    {
        return Company::updateContactInfo($this->name, $this->phone, $this->email);
    }
}
