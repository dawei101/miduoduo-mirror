<?php
namespace corp\models;

use common\models\User;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class TaskPublishModel extends Model
{
    public $title;
    public $clearance_period;
    public $salary;
    public $salary_unit;
    public $salary_note;
    public $from_date;
    public $from_time;
    public $to_date;
    public $to_time;
    public $need_quantity;
    public $gender_requirement;
    public $height_requirement;
    public $age_requirement;
    public $degree_requirement;

    public $contact;
    public $contact_phonenum;


    private $_user = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
             [['title', '$salary'], 'required'],
        ];
    }


    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
